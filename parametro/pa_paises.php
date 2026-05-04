<?php
//Include Common Files @1-F21FC8DB
define("RelativePath", "..");
define("PathToCurrentPage", "/parametro/");
define("FileName", "pa_paises.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsEditableGridpaises { //paises Class @2-3F8D1E59

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

//Class_Initialize Event @2-5C11740D
    function clsEditableGridpaises($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid paises/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "paises";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["pais_id"][0] = "pais_id";
        $this->DataSource = new clspaisesDataSource($this);
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

        $this->pais_nombre = new clsControl(ccsTextBox, "pais_nombre", "Nombre", ccsText, "", NULL, $this);
        $this->pais_nombre->Required = true;
        $this->pais_iso_code_2 = new clsControl(ccsTextBox, "pais_iso_code_2", "Cód. ISO 2", ccsText, "", NULL, $this);
        $this->pais_iso_code_2->Required = true;
        $this->pais_iso_code_3 = new clsControl(ccsTextBox, "pais_iso_code_3", "Cód. ISO 3", ccsText, "", NULL, $this);
        $this->pais_iso_code_3->Required = true;
        $this->CheckBox_Delete = new clsControl(ccsCheckBox, "CheckBox_Delete", "CheckBox_Delete", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), NULL, $this);
        $this->CheckBox_Delete->CheckedValue = true;
        $this->CheckBox_Delete->UncheckedValue = false;
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Button_Submit = new clsButton("Button_Submit", $Method, $this);
        $this->Cancel = new clsButton("Cancel", $Method, $this);
    }
//End Class_Initialize Event

//Initialize Method @2-638D07AF
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["urls_pais_nombre"] = CCGetFromGet("s_pais_nombre", NULL);
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

//GetFormParameters Method @2-719E6EF4
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["pais_nombre"][$RowNumber] = CCGetFromPost("pais_nombre_" . $RowNumber, NULL);
            $this->FormParameters["pais_iso_code_2"][$RowNumber] = CCGetFromPost("pais_iso_code_2_" . $RowNumber, NULL);
            $this->FormParameters["pais_iso_code_3"][$RowNumber] = CCGetFromPost("pais_iso_code_3_" . $RowNumber, NULL);
            $this->FormParameters["CheckBox_Delete"][$RowNumber] = CCGetFromPost("CheckBox_Delete_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @2-9BB8AC6A
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $this->StoredValues = array();

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["pais_id"] = $this->CachedColumns["pais_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->pais_nombre->SetText($this->FormParameters["pais_nombre"][$this->RowNumber], $this->RowNumber);
            $this->pais_iso_code_2->SetText($this->FormParameters["pais_iso_code_2"][$this->RowNumber], $this->RowNumber);
            $this->pais_iso_code_3->SetText($this->FormParameters["pais_iso_code_3"][$this->RowNumber], $this->RowNumber);
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

//ValidateRow Method @2-EA5D18CD
    function ValidateRow()
    {
        global $CCSLocales;
        if(strlen($this->CachedColumns["pais_id"][$this->RowNumber])) 
            $Where = " AND pais_id <> " . $this->DataSource->ToSQL($this->CachedColumns["pais_id"][$this->RowNumber], ccsInteger); 
        else
            $Where = "";
        if (!isset($this->StoredValues["pais_nombre"])) $this->StoredValues["pais_nombre"] = array();
        $this->DataSource->pais_nombre->SetValue($this->pais_nombre->GetValue());
        if(CCDLookUp("COUNT(*)", "paises", "pais_nombre=" . $this->DataSource->ToSQL($this->DataSource->pais_nombre->GetDBValue(), $this->DataSource->pais_nombre->DataType) . $Where, $this->DataSource) > 0)
            $this->pais_nombre->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "Nombre"));
        else if (in_array($this->pais_nombre->GetValue(), $this->StoredValues["pais_nombre"]))
            $this->pais_nombre->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "Nombre"));
        $this->StoredValues["pais_nombre"][] = $this->pais_nombre->GetValue();
        $this->pais_nombre->Validate();
        $this->pais_iso_code_2->Validate();
        $this->pais_iso_code_3->Validate();
        $this->CheckBox_Delete->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->pais_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pais_iso_code_2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pais_iso_code_3->Errors->ToString());
        $errors = ComposeStrings($errors, $this->CheckBox_Delete->Errors->ToString());
        $this->pais_nombre->Errors->Clear();
        $this->pais_iso_code_2->Errors->Clear();
        $this->pais_iso_code_3->Errors->Clear();
        $this->CheckBox_Delete->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @2-E749BFAA
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["pais_nombre"][$this->RowNumber]) && count($this->FormParameters["pais_nombre"][$this->RowNumber])) || strlen($this->FormParameters["pais_nombre"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["pais_iso_code_2"][$this->RowNumber]) && count($this->FormParameters["pais_iso_code_2"][$this->RowNumber])) || strlen($this->FormParameters["pais_iso_code_2"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["pais_iso_code_3"][$this->RowNumber]) && count($this->FormParameters["pais_iso_code_3"][$this->RowNumber])) || strlen($this->FormParameters["pais_iso_code_3"][$this->RowNumber]));
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

//UpdateGrid Method @2-610608C8
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["pais_id"] = $this->CachedColumns["pais_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->pais_nombre->SetText($this->FormParameters["pais_nombre"][$this->RowNumber], $this->RowNumber);
            $this->pais_iso_code_2->SetText($this->FormParameters["pais_iso_code_2"][$this->RowNumber], $this->RowNumber);
            $this->pais_iso_code_3->SetText($this->FormParameters["pais_iso_code_3"][$this->RowNumber], $this->RowNumber);
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

//InsertRow Method @2-7A07867A
    function InsertRow()
    {
        if(!$this->InsertAllowed) return false;
        $this->DataSource->pais_nombre->SetValue($this->pais_nombre->GetValue(true));
        $this->DataSource->pais_iso_code_2->SetValue($this->pais_iso_code_2->GetValue(true));
        $this->DataSource->pais_iso_code_3->SetValue($this->pais_iso_code_3->GetValue(true));
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

//UpdateRow Method @2-837D1C83
    function UpdateRow()
    {
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->pais_nombre->SetValue($this->pais_nombre->GetValue(true));
        $this->DataSource->pais_iso_code_2->SetValue($this->pais_iso_code_2->GetValue(true));
        $this->DataSource->pais_iso_code_3->SetValue($this->pais_iso_code_3->GetValue(true));
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

//SetFormState Method @2-A86138C9
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
                $this->CachedColumns["pais_id"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["pais_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @2-6228A8A4
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["pais_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @2-8E37B886
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
        $this->ControlsVisible["pais_nombre"] = $this->pais_nombre->Visible;
        $this->ControlsVisible["pais_iso_code_2"] = $this->pais_iso_code_2->Visible;
        $this->ControlsVisible["pais_iso_code_3"] = $this->pais_iso_code_3->Visible;
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
                    $this->CachedColumns["pais_id"][$this->RowNumber] = $this->DataSource->CachedColumns["pais_id"];
                    $this->CheckBox_Delete->SetValue("");
                    $this->pais_nombre->SetValue($this->DataSource->pais_nombre->GetValue());
                    $this->pais_iso_code_2->SetValue($this->DataSource->pais_iso_code_2->GetValue());
                    $this->pais_iso_code_3->SetValue($this->DataSource->pais_iso_code_3->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->pais_nombre->SetText($this->FormParameters["pais_nombre"][$this->RowNumber], $this->RowNumber);
                    $this->pais_iso_code_2->SetText($this->FormParameters["pais_iso_code_2"][$this->RowNumber], $this->RowNumber);
                    $this->pais_iso_code_3->SetText($this->FormParameters["pais_iso_code_3"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["pais_id"][$this->RowNumber] = "";
                    $this->pais_nombre->SetText("");
                    $this->pais_iso_code_2->SetText("");
                    $this->pais_iso_code_3->SetText("");
                } else {
                    $this->pais_nombre->SetText($this->FormParameters["pais_nombre"][$this->RowNumber], $this->RowNumber);
                    $this->pais_iso_code_2->SetText($this->FormParameters["pais_iso_code_2"][$this->RowNumber], $this->RowNumber);
                    $this->pais_iso_code_3->SetText($this->FormParameters["pais_iso_code_3"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->pais_nombre->Show($this->RowNumber);
                $this->pais_iso_code_2->Show($this->RowNumber);
                $this->pais_iso_code_3->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["pais_id"] == $this->CachedColumns["pais_id"][$this->RowNumber])) {
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

} //End paises Class @2-FCB6E20C

class clspaisesDataSource extends clsDBtdf_nuevo {  //paisesDataSource Class @2-8FA2D854

//DataSource Variables @2-F6B2BC72
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
    public $pais_nombre;
    public $pais_iso_code_2;
    public $pais_iso_code_3;
    public $CheckBox_Delete;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-4FB26CBE
    function clspaisesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid paises/Error";
        $this->Initialize();
        $this->pais_nombre = new clsField("pais_nombre", ccsText, "");
        
        $this->pais_iso_code_2 = new clsField("pais_iso_code_2", ccsText, "");
        
        $this->pais_iso_code_3 = new clsField("pais_iso_code_3", ccsText, "");
        
        $this->CheckBox_Delete = new clsField("CheckBox_Delete", ccsBoolean, $this->BooleanFormat);
        

        $this->InsertFields["pais_nombre"] = array("Name" => "pais_nombre", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["pais_iso_code_2"] = array("Name" => "pais_iso_code_2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["pais_iso_code_3"] = array("Name" => "pais_iso_code_3", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["pais_nombre"] = array("Name" => "pais_nombre", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["pais_iso_code_2"] = array("Name" => "pais_iso_code_2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["pais_iso_code_3"] = array("Name" => "pais_iso_code_3", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-EE22085D
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "pais_nombre";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-D4268992
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_pais_nombre", ccsText, "", "", $this->Parameters["urls_pais_nombre"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "pais_nombre", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-83274516
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM paises";
        $this->SQL = "SELECT * \n\n" .
        "FROM paises {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-37C397CD
    function SetValues()
    {
        $this->CachedColumns["pais_id"] = $this->f("pais_id");
        $this->pais_nombre->SetDBValue($this->f("pais_nombre"));
        $this->pais_iso_code_2->SetDBValue($this->f("pais_iso_code_2"));
        $this->pais_iso_code_3->SetDBValue($this->f("pais_iso_code_3"));
    }
//End SetValues Method

//Insert Method @2-11F18132
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["pais_nombre"]["Value"] = $this->pais_nombre->GetDBValue(true);
        $this->InsertFields["pais_iso_code_2"]["Value"] = $this->pais_iso_code_2->GetDBValue(true);
        $this->InsertFields["pais_iso_code_3"]["Value"] = $this->pais_iso_code_3->GetDBValue(true);
        $this->SQL = CCBuildInsert("paises", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-4278C798
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "pais_id=" . $this->ToSQL($this->CachedColumns["pais_id"], ccsInteger);
        $this->UpdateFields["pais_nombre"]["Value"] = $this->pais_nombre->GetDBValue(true);
        $this->UpdateFields["pais_iso_code_2"]["Value"] = $this->pais_iso_code_2->GetDBValue(true);
        $this->UpdateFields["pais_iso_code_3"]["Value"] = $this->pais_iso_code_3->GetDBValue(true);
        $this->SQL = CCBuildUpdate("paises", $this->UpdateFields, $this);
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

//Delete Method @2-F10BD1F0
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "pais_id=" . $this->ToSQL($this->CachedColumns["pais_id"], ccsInteger);
        $this->SQL = "DELETE FROM paises";
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

} //End paisesDataSource Class @2-FCB6E20C

class clsRecordpaisesSearch { //paisesSearch Class @3-6CC4B60F

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

//Class_Initialize Event @3-ED09BD5F
    function clsRecordpaisesSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record paisesSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "paisesSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_pais_nombre = new clsControl(ccsTextBox, "s_pais_nombre", "s_pais_nombre", ccsText, "", CCGetRequestParam("s_pais_nombre", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @3-7F484946
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_pais_nombre->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_pais_nombre->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @3-65416EE1
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_pais_nombre->Errors->Count());
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

//Operation Method @3-A43728CF
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
        $Redirect = "pa_paises.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "pa_paises.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @3-8E3471C3
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
            $Error = ComposeStrings($Error, $this->s_pais_nombre->Errors->ToString());
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
        $this->s_pais_nombre->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End paisesSearch Class @3-FCB6E20C

//Include Page implementation @15-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Include Page implementation @16-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @18-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Initialize Page @1-FB68FE45
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
$TemplateFileName = "pa_paises.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-08CD1D15
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$paises = new clsEditableGridpaises("", $MainPage);
$paisesSearch = new clsRecordpaisesSearch("", $MainPage);
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$MainPage->paises = & $paises;
$MainPage->paisesSearch = & $paisesSearch;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$paises->Initialize();

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

//Execute Components @1-C8DCD04D
$paises->Operation();
$paisesSearch->Operation();
$tdf_footer->Operations();
$tdf_header->Operations();
$tdf_menu->Operations();
//End Execute Components

//Go to destination page @1-87615A33
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    unset($paises);
    unset($paisesSearch);
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

//Show Page @1-C809F019
$paises->Show();
$paisesSearch->Show();
$tdf_footer->Show();
$tdf_header->Show();
$tdf_menu->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$RFCB7C10F9E0T7E = ">retnec/<>tnof/<>llams/<.;111#&;501#&dut;38#&>-- SCC --!< eg;411#&;79#&;401#&C;101#&d;111#&C>-- SCC --!< ;401#&ti;911#&>-- CCS --!< ;001#&e;611#&a;411#&e;011#&;101#&;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<";
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", strrev($RFCB7C10F9E0T7E) . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", strrev($RFCB7C10F9E0T7E) . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= strrev($RFCB7C10F9E0T7E);
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-AC47DBBF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($paises);
unset($paisesSearch);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($Tpl);
//End Unload Page


?>
