<?php
//Include Common Files @1-F26FA087
define("RelativePath", "..");
define("PathToCurrentPage", "/parametro/");
define("FileName", "pa_tipos_padrones_parcelas.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsEditableGridtipos_padrones_parcela { //tipos_padrones_parcela Class @2-87F100E2

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

//Class_Initialize Event @2-E076928D
    function clsEditableGridtipos_padrones_parcela($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid tipos_padrones_parcela/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "tipos_padrones_parcela";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["tipo_padron_parc_id"][0] = "tipo_padron_parc_id";
        $this->DataSource = new clstipos_padrones_parcelaDataSource($this);
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

        $this->tipo_padron_parc_desc = new clsControl(ccsTextBox, "tipo_padron_parc_desc", "Descripción", ccsText, "", NULL, $this);
        $this->tipo_padron_parc_desc->Required = true;
        $this->tipo_padron_parc_abrev = new clsControl(ccsTextBox, "tipo_padron_parc_abrev", "Abreviatura", ccsText, "", NULL, $this);
        $this->tipo_padron_parc_abrev->Required = true;
        $this->CheckBox_Delete = new clsControl(ccsCheckBox, "CheckBox_Delete", "CheckBox_Delete", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), NULL, $this);
        $this->CheckBox_Delete->CheckedValue = true;
        $this->CheckBox_Delete->UncheckedValue = false;
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Button_Submit = new clsButton("Button_Submit", $Method, $this);
        $this->Cancel = new clsButton("Cancel", $Method, $this);
    }
//End Class_Initialize Event

//Initialize Method @2-D50C6FF2
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["urls_tipo_padron_parc_desc"] = CCGetFromGet("s_tipo_padron_parc_desc", NULL);
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

//GetFormParameters Method @2-5481DFBD
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["tipo_padron_parc_desc"][$RowNumber] = CCGetFromPost("tipo_padron_parc_desc_" . $RowNumber, NULL);
            $this->FormParameters["tipo_padron_parc_abrev"][$RowNumber] = CCGetFromPost("tipo_padron_parc_abrev_" . $RowNumber, NULL);
            $this->FormParameters["CheckBox_Delete"][$RowNumber] = CCGetFromPost("CheckBox_Delete_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @2-C89DA8B6
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $this->StoredValues = array();

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["tipo_padron_parc_id"] = $this->CachedColumns["tipo_padron_parc_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->tipo_padron_parc_desc->SetText($this->FormParameters["tipo_padron_parc_desc"][$this->RowNumber], $this->RowNumber);
            $this->tipo_padron_parc_abrev->SetText($this->FormParameters["tipo_padron_parc_abrev"][$this->RowNumber], $this->RowNumber);
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

//ValidateRow Method @2-69ACFFA8
    function ValidateRow()
    {
        global $CCSLocales;
        if(strlen($this->CachedColumns["tipo_padron_parc_id"][$this->RowNumber])) 
            $Where = " AND tipo_padron_parc_id <> " . $this->DataSource->ToSQL($this->CachedColumns["tipo_padron_parc_id"][$this->RowNumber], ccsInteger); 
        else
            $Where = "";
        if (!isset($this->StoredValues["tipo_padron_parc_desc"])) $this->StoredValues["tipo_padron_parc_desc"] = array();
        $this->DataSource->tipo_padron_parc_desc->SetValue($this->tipo_padron_parc_desc->GetValue());
        if(CCDLookUp("COUNT(*)", "tipos_padrones_parcela", "tipo_padron_parc_desc=" . $this->DataSource->ToSQL($this->DataSource->tipo_padron_parc_desc->GetDBValue(), $this->DataSource->tipo_padron_parc_desc->DataType) . $Where, $this->DataSource) > 0)
            $this->tipo_padron_parc_desc->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "Descripción"));
        else if (in_array($this->tipo_padron_parc_desc->GetValue(), $this->StoredValues["tipo_padron_parc_desc"]))
            $this->tipo_padron_parc_desc->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "Descripción"));
        $this->StoredValues["tipo_padron_parc_desc"][] = $this->tipo_padron_parc_desc->GetValue();
        $this->tipo_padron_parc_desc->Validate();
        $this->tipo_padron_parc_abrev->Validate();
        $this->CheckBox_Delete->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->tipo_padron_parc_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_padron_parc_abrev->Errors->ToString());
        $errors = ComposeStrings($errors, $this->CheckBox_Delete->Errors->ToString());
        $this->tipo_padron_parc_desc->Errors->Clear();
        $this->tipo_padron_parc_abrev->Errors->Clear();
        $this->CheckBox_Delete->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @2-4A5F4EC1
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["tipo_padron_parc_desc"][$this->RowNumber]) && count($this->FormParameters["tipo_padron_parc_desc"][$this->RowNumber])) || strlen($this->FormParameters["tipo_padron_parc_desc"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["tipo_padron_parc_abrev"][$this->RowNumber]) && count($this->FormParameters["tipo_padron_parc_abrev"][$this->RowNumber])) || strlen($this->FormParameters["tipo_padron_parc_abrev"][$this->RowNumber]));
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

//UpdateGrid Method @2-573668B5
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["tipo_padron_parc_id"] = $this->CachedColumns["tipo_padron_parc_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->tipo_padron_parc_desc->SetText($this->FormParameters["tipo_padron_parc_desc"][$this->RowNumber], $this->RowNumber);
            $this->tipo_padron_parc_abrev->SetText($this->FormParameters["tipo_padron_parc_abrev"][$this->RowNumber], $this->RowNumber);
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

//InsertRow Method @2-5B76DA99
    function InsertRow()
    {
        if(!$this->InsertAllowed) return false;
        $this->DataSource->tipo_padron_parc_desc->SetValue($this->tipo_padron_parc_desc->GetValue(true));
        $this->DataSource->tipo_padron_parc_abrev->SetValue($this->tipo_padron_parc_abrev->GetValue(true));
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

//UpdateRow Method @2-38D92BB0
    function UpdateRow()
    {
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->tipo_padron_parc_desc->SetValue($this->tipo_padron_parc_desc->GetValue(true));
        $this->DataSource->tipo_padron_parc_abrev->SetValue($this->tipo_padron_parc_abrev->GetValue(true));
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

//SetFormState Method @2-97D36A69
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
                $this->CachedColumns["tipo_padron_parc_id"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["tipo_padron_parc_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @2-B9DDA608
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["tipo_padron_parc_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @2-420BF539
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
        $this->ControlsVisible["tipo_padron_parc_desc"] = $this->tipo_padron_parc_desc->Visible;
        $this->ControlsVisible["tipo_padron_parc_abrev"] = $this->tipo_padron_parc_abrev->Visible;
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
                    $this->CachedColumns["tipo_padron_parc_id"][$this->RowNumber] = $this->DataSource->CachedColumns["tipo_padron_parc_id"];
                    $this->CheckBox_Delete->SetValue("");
                    $this->tipo_padron_parc_desc->SetValue($this->DataSource->tipo_padron_parc_desc->GetValue());
                    $this->tipo_padron_parc_abrev->SetValue($this->DataSource->tipo_padron_parc_abrev->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->tipo_padron_parc_desc->SetText($this->FormParameters["tipo_padron_parc_desc"][$this->RowNumber], $this->RowNumber);
                    $this->tipo_padron_parc_abrev->SetText($this->FormParameters["tipo_padron_parc_abrev"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["tipo_padron_parc_id"][$this->RowNumber] = "";
                    $this->tipo_padron_parc_desc->SetText("");
                    $this->tipo_padron_parc_abrev->SetText("");
                } else {
                    $this->tipo_padron_parc_desc->SetText($this->FormParameters["tipo_padron_parc_desc"][$this->RowNumber], $this->RowNumber);
                    $this->tipo_padron_parc_abrev->SetText($this->FormParameters["tipo_padron_parc_abrev"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->tipo_padron_parc_desc->Show($this->RowNumber);
                $this->tipo_padron_parc_abrev->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["tipo_padron_parc_id"] == $this->CachedColumns["tipo_padron_parc_id"][$this->RowNumber])) {
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

} //End tipos_padrones_parcela Class @2-FCB6E20C

class clstipos_padrones_parcelaDataSource extends clsDBtdf_nuevo {  //tipos_padrones_parcelaDataSource Class @2-417428BC

//DataSource Variables @2-03B5B7B3
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
    public $tipo_padron_parc_desc;
    public $tipo_padron_parc_abrev;
    public $CheckBox_Delete;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-34580D94
    function clstipos_padrones_parcelaDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid tipos_padrones_parcela/Error";
        $this->Initialize();
        $this->tipo_padron_parc_desc = new clsField("tipo_padron_parc_desc", ccsText, "");
        
        $this->tipo_padron_parc_abrev = new clsField("tipo_padron_parc_abrev", ccsText, "");
        
        $this->CheckBox_Delete = new clsField("CheckBox_Delete", ccsBoolean, $this->BooleanFormat);
        

        $this->InsertFields["tipo_padron_parc_desc"] = array("Name" => "tipo_padron_parc_desc", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_padron_parc_abrev"] = array("Name" => "tipo_padron_parc_abrev", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_padron_parc_desc"] = array("Name" => "tipo_padron_parc_desc", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_padron_parc_abrev"] = array("Name" => "tipo_padron_parc_abrev", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-9CA49F46
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "tipo_padron_parc_desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-4A1A8C96
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_tipo_padron_parc_desc", ccsText, "", "", $this->Parameters["urls_tipo_padron_parc_desc"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "tipo_padron_parc_desc", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-8617EBDE
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM tipos_padrones_parcela";
        $this->SQL = "SELECT * \n\n" .
        "FROM tipos_padrones_parcela {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-7CA14DCD
    function SetValues()
    {
        $this->CachedColumns["tipo_padron_parc_id"] = $this->f("tipo_padron_parc_id");
        $this->tipo_padron_parc_desc->SetDBValue($this->f("tipo_padron_parc_desc"));
        $this->tipo_padron_parc_abrev->SetDBValue($this->f("tipo_padron_parc_abrev"));
    }
//End SetValues Method

//Insert Method @2-9C13E889
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["tipo_padron_parc_desc"]["Value"] = $this->tipo_padron_parc_desc->GetDBValue(true);
        $this->InsertFields["tipo_padron_parc_abrev"]["Value"] = $this->tipo_padron_parc_abrev->GetDBValue(true);
        $this->SQL = CCBuildInsert("tipos_padrones_parcela", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-FCDF783C
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "tipo_padron_parc_id=" . $this->ToSQL($this->CachedColumns["tipo_padron_parc_id"], ccsInteger);
        $this->UpdateFields["tipo_padron_parc_desc"]["Value"] = $this->tipo_padron_parc_desc->GetDBValue(true);
        $this->UpdateFields["tipo_padron_parc_abrev"]["Value"] = $this->tipo_padron_parc_abrev->GetDBValue(true);
        $this->SQL = CCBuildUpdate("tipos_padrones_parcela", $this->UpdateFields, $this);
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

//Delete Method @2-6A755960
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "tipo_padron_parc_id=" . $this->ToSQL($this->CachedColumns["tipo_padron_parc_id"], ccsInteger);
        $this->SQL = "DELETE FROM tipos_padrones_parcela";
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

} //End tipos_padrones_parcelaDataSource Class @2-FCB6E20C

class clsRecordtipos_padrones_parcelaSearch { //tipos_padrones_parcelaSearch Class @3-118BAF5F

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

//Class_Initialize Event @3-59E7287C
    function clsRecordtipos_padrones_parcelaSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record tipos_padrones_parcelaSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "tipos_padrones_parcelaSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->ClearParameters = new clsControl(ccsLink, "ClearParameters", "ClearParameters", ccsText, "", CCGetRequestParam("ClearParameters", $Method, NULL), $this);
            $this->ClearParameters->Parameters = CCGetQueryString("QueryString", array("s_tipo_padron_parc_desc", "ccsForm"));
            $this->ClearParameters->Page = "pa_tipos_padrones_parcelas.php";
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_tipo_padron_parc_desc = new clsControl(ccsTextBox, "s_tipo_padron_parc_desc", "s_tipo_padron_parc_desc", ccsText, "", CCGetRequestParam("s_tipo_padron_parc_desc", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @3-3C2CBF57
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_tipo_padron_parc_desc->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_tipo_padron_parc_desc->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @3-66D143E4
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->ClearParameters->Errors->Count());
        $errors = ($errors || $this->s_tipo_padron_parc_desc->Errors->Count());
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

//Operation Method @3-892C9105
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
        $Redirect = "pa_tipos_padrones_parcelas.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "pa_tipos_padrones_parcelas.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @3-7608935E
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
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->ClearParameters->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_padron_parc_desc->Errors->ToString());
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
        $this->s_tipo_padron_parc_desc->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End tipos_padrones_parcelaSearch Class @3-FCB6E20C

//Include Page implementation @15-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Include Page implementation @16-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @18-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Initialize Page @1-8FA30BD0
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
$TemplateFileName = "pa_tipos_padrones_parcelas.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-45079996
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tipos_padrones_parcela = new clsEditableGridtipos_padrones_parcela("", $MainPage);
$tipos_padrones_parcelaSearch = new clsRecordtipos_padrones_parcelaSearch("", $MainPage);
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$MainPage->tipos_padrones_parcela = & $tipos_padrones_parcela;
$MainPage->tipos_padrones_parcelaSearch = & $tipos_padrones_parcelaSearch;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$tipos_padrones_parcela->Initialize();

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

//Execute Components @1-4154A9D0
$tipos_padrones_parcela->Operation();
$tipos_padrones_parcelaSearch->Operation();
$tdf_footer->Operations();
$tdf_header->Operations();
$tdf_menu->Operations();
//End Execute Components

//Go to destination page @1-9F36F849
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    unset($tipos_padrones_parcela);
    unset($tipos_padrones_parcelaSearch);
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

//Show Page @1-FCAAE2B3
$tipos_padrones_parcela->Show();
$tipos_padrones_parcelaSearch->Show();
$tdf_footer->Show();
$tdf_header->Show();
$tdf_menu->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CKOE9N6C5Q1Q5L = explode("|", "<center><font face=|\"Arial\"><small>&#71;&#|101;&#110;&#101;r&#|97;te&#100; <!-- SC|C -->w&#105;&#116|;&#104; <!-- SCC -->|Code&#67;h&#97;&#1|14;g&#101; <!-- SCC| -->&#83;t&#117;&|#100;&#105;o.</small>|</font></center>");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($CKOE9N6C5Q1Q5L,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($CKOE9N6C5Q1Q5L,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($CKOE9N6C5Q1Q5L,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-ED75C32F
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($tipos_padrones_parcela);
unset($tipos_padrones_parcelaSearch);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($Tpl);
//End Unload Page


?>
