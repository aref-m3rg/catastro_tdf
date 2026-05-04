<?php
//Include Common Files @1-840E51A9
define("RelativePath", "..");
define("PathToCurrentPage", "/parametro/");
define("FileName", "pa_tipos_mejoras_destinos.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsEditableGridtipos_mejoras_destinos1 { //tipos_mejoras_destinos1 Class @15-0EE34622

//Variables @15-96DACC12

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

//Class_Initialize Event @15-126ADCFB
    function clsEditableGridtipos_mejoras_destinos1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid tipos_mejoras_destinos1/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "tipos_mejoras_destinos1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["tipo_mejora_destino_id"][0] = "tipo_mejora_destino_id";
        $this->DataSource = new clstipos_mejoras_destinos1DataSource($this);
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

        $this->tipo_mejora_destino_descrip = new clsControl(ccsTextBox, "tipo_mejora_destino_descrip", "Descripción", ccsText, "", NULL, $this);
        $this->tipo_mejora_destino_descrip->Required = true;
        $this->tipo_mejora_destino_abrev = new clsControl(ccsTextBox, "tipo_mejora_destino_abrev", "Abreviatura", ccsText, "", NULL, $this);
        $this->tipo_mejora_destino_abrev->Required = true;
        $this->CheckBox_Delete = new clsControl(ccsCheckBox, "CheckBox_Delete", "CheckBox_Delete", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), NULL, $this);
        $this->CheckBox_Delete->CheckedValue = true;
        $this->CheckBox_Delete->UncheckedValue = false;
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Button_Submit = new clsButton("Button_Submit", $Method, $this);
        $this->Cancel = new clsButton("Cancel", $Method, $this);
    }
//End Class_Initialize Event

//Initialize Method @15-D5F62F3D
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["urls_tipo_mejora_destino_descrip"] = CCGetFromGet("s_tipo_mejora_destino_descrip", NULL);
    }
//End Initialize Method

//SetPrimaryKeys Method @15-EBC3F86C
    function SetPrimaryKeys($PrimaryKeys) {
        $this->PrimaryKeys = $PrimaryKeys;
        return $this->PrimaryKeys;
    }
//End SetPrimaryKeys Method

//GetPrimaryKeys Method @15-74F9A772
    function GetPrimaryKeys() {
        return $this->PrimaryKeys;
    }
//End GetPrimaryKeys Method

//GetFormParameters Method @15-8F5F3ED6
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["tipo_mejora_destino_descrip"][$RowNumber] = CCGetFromPost("tipo_mejora_destino_descrip_" . $RowNumber, NULL);
            $this->FormParameters["tipo_mejora_destino_abrev"][$RowNumber] = CCGetFromPost("tipo_mejora_destino_abrev_" . $RowNumber, NULL);
            $this->FormParameters["CheckBox_Delete"][$RowNumber] = CCGetFromPost("CheckBox_Delete_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @15-75DACF2C
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $this->StoredValues = array();

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["tipo_mejora_destino_id"] = $this->CachedColumns["tipo_mejora_destino_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->tipo_mejora_destino_descrip->SetText($this->FormParameters["tipo_mejora_destino_descrip"][$this->RowNumber], $this->RowNumber);
            $this->tipo_mejora_destino_abrev->SetText($this->FormParameters["tipo_mejora_destino_abrev"][$this->RowNumber], $this->RowNumber);
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

//ValidateRow Method @15-B01D1F9D
    function ValidateRow()
    {
        global $CCSLocales;
        if(strlen($this->CachedColumns["tipo_mejora_destino_id"][$this->RowNumber])) 
            $Where = " AND tipo_mejora_destino_id <> " . $this->DataSource->ToSQL($this->CachedColumns["tipo_mejora_destino_id"][$this->RowNumber], ccsInteger); 
        else
            $Where = "";
        if (!isset($this->StoredValues["tipo_mejora_destino_descrip"])) $this->StoredValues["tipo_mejora_destino_descrip"] = array();
        $this->DataSource->tipo_mejora_destino_descrip->SetValue($this->tipo_mejora_destino_descrip->GetValue());
        if(CCDLookUp("COUNT(*)", "tipos_mejoras_destinos", "tipo_mejora_destino_descrip=" . $this->DataSource->ToSQL($this->DataSource->tipo_mejora_destino_descrip->GetDBValue(), $this->DataSource->tipo_mejora_destino_descrip->DataType) . $Where, $this->DataSource) > 0)
            $this->tipo_mejora_destino_descrip->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "Descripción"));
        else if (in_array($this->tipo_mejora_destino_descrip->GetValue(), $this->StoredValues["tipo_mejora_destino_descrip"]))
            $this->tipo_mejora_destino_descrip->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "Descripción"));
        $this->StoredValues["tipo_mejora_destino_descrip"][] = $this->tipo_mejora_destino_descrip->GetValue();
        $this->tipo_mejora_destino_descrip->Validate();
        $this->tipo_mejora_destino_abrev->Validate();
        $this->CheckBox_Delete->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->tipo_mejora_destino_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_mejora_destino_abrev->Errors->ToString());
        $errors = ComposeStrings($errors, $this->CheckBox_Delete->Errors->ToString());
        $this->tipo_mejora_destino_descrip->Errors->Clear();
        $this->tipo_mejora_destino_abrev->Errors->Clear();
        $this->CheckBox_Delete->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @15-90E454C3
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["tipo_mejora_destino_descrip"][$this->RowNumber]) && count($this->FormParameters["tipo_mejora_destino_descrip"][$this->RowNumber])) || strlen($this->FormParameters["tipo_mejora_destino_descrip"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["tipo_mejora_destino_abrev"][$this->RowNumber]) && count($this->FormParameters["tipo_mejora_destino_abrev"][$this->RowNumber])) || strlen($this->FormParameters["tipo_mejora_destino_abrev"][$this->RowNumber]));
        return $filed;
    }
//End CheckInsert Method

//CheckErrors Method @15-F5A3B433
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @15-6B923CC2
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

//UpdateGrid Method @15-8AC6D920
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["tipo_mejora_destino_id"] = $this->CachedColumns["tipo_mejora_destino_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->tipo_mejora_destino_descrip->SetText($this->FormParameters["tipo_mejora_destino_descrip"][$this->RowNumber], $this->RowNumber);
            $this->tipo_mejora_destino_abrev->SetText($this->FormParameters["tipo_mejora_destino_abrev"][$this->RowNumber], $this->RowNumber);
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

//InsertRow Method @15-6146E129
    function InsertRow()
    {
        if(!$this->InsertAllowed) return false;
        $this->DataSource->tipo_mejora_destino_descrip->SetValue($this->tipo_mejora_destino_descrip->GetValue(true));
        $this->DataSource->tipo_mejora_destino_abrev->SetValue($this->tipo_mejora_destino_abrev->GetValue(true));
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

//UpdateRow Method @15-C9BFEC17
    function UpdateRow()
    {
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->tipo_mejora_destino_descrip->SetValue($this->tipo_mejora_destino_descrip->GetValue(true));
        $this->DataSource->tipo_mejora_destino_abrev->SetValue($this->tipo_mejora_destino_abrev->GetValue(true));
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

//DeleteRow Method @15-A4A656F6
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

//FormScript Method @15-59800DB5
    function FormScript($TotalRows)
    {
        $script = "";
        return $script;
    }
//End FormScript Method

//SetFormState Method @15-29062373
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
                $this->CachedColumns["tipo_mejora_destino_id"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["tipo_mejora_destino_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @15-00CEB182
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["tipo_mejora_destino_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @15-EE9EC4DE
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
        $this->ControlsVisible["tipo_mejora_destino_descrip"] = $this->tipo_mejora_destino_descrip->Visible;
        $this->ControlsVisible["tipo_mejora_destino_abrev"] = $this->tipo_mejora_destino_abrev->Visible;
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
                    $this->CachedColumns["tipo_mejora_destino_id"][$this->RowNumber] = $this->DataSource->CachedColumns["tipo_mejora_destino_id"];
                    $this->CheckBox_Delete->SetValue("");
                    $this->tipo_mejora_destino_descrip->SetValue($this->DataSource->tipo_mejora_destino_descrip->GetValue());
                    $this->tipo_mejora_destino_abrev->SetValue($this->DataSource->tipo_mejora_destino_abrev->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->tipo_mejora_destino_descrip->SetText($this->FormParameters["tipo_mejora_destino_descrip"][$this->RowNumber], $this->RowNumber);
                    $this->tipo_mejora_destino_abrev->SetText($this->FormParameters["tipo_mejora_destino_abrev"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["tipo_mejora_destino_id"][$this->RowNumber] = "";
                    $this->tipo_mejora_destino_descrip->SetText("");
                    $this->tipo_mejora_destino_abrev->SetText("");
                } else {
                    $this->tipo_mejora_destino_descrip->SetText($this->FormParameters["tipo_mejora_destino_descrip"][$this->RowNumber], $this->RowNumber);
                    $this->tipo_mejora_destino_abrev->SetText($this->FormParameters["tipo_mejora_destino_abrev"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->tipo_mejora_destino_descrip->Show($this->RowNumber);
                $this->tipo_mejora_destino_abrev->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["tipo_mejora_destino_id"] == $this->CachedColumns["tipo_mejora_destino_id"][$this->RowNumber])) {
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

} //End tipos_mejoras_destinos1 Class @15-FCB6E20C

class clstipos_mejoras_destinos1DataSource extends clsDBtdf_nuevo {  //tipos_mejoras_destinos1DataSource Class @15-0DA7538F

//DataSource Variables @15-37EE9B2E
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
    public $tipo_mejora_destino_descrip;
    public $tipo_mejora_destino_abrev;
    public $CheckBox_Delete;
//End DataSource Variables

//DataSourceClass_Initialize Event @15-B80E2248
    function clstipos_mejoras_destinos1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid tipos_mejoras_destinos1/Error";
        $this->Initialize();
        $this->tipo_mejora_destino_descrip = new clsField("tipo_mejora_destino_descrip", ccsText, "");
        
        $this->tipo_mejora_destino_abrev = new clsField("tipo_mejora_destino_abrev", ccsText, "");
        
        $this->CheckBox_Delete = new clsField("CheckBox_Delete", ccsBoolean, $this->BooleanFormat);
        

        $this->InsertFields["tipo_mejora_destino_descrip"] = array("Name" => "tipo_mejora_destino_descrip", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_mejora_destino_abrev"] = array("Name" => "tipo_mejora_destino_abrev", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_mejora_destino_descrip"] = array("Name" => "tipo_mejora_destino_descrip", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_mejora_destino_abrev"] = array("Name" => "tipo_mejora_destino_abrev", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//SetOrder Method @15-0C1C67F0
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "tipo_mejora_destino_descrip";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @15-73444A16
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_tipo_mejora_destino_descrip", ccsText, "", "", $this->Parameters["urls_tipo_mejora_destino_descrip"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "tipo_mejora_destino_descrip", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @15-83D29362
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM tipos_mejoras_destinos";
        $this->SQL = "SELECT * \n\n" .
        "FROM tipos_mejoras_destinos {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @15-3A99B1F1
    function SetValues()
    {
        $this->CachedColumns["tipo_mejora_destino_id"] = $this->f("tipo_mejora_destino_id");
        $this->tipo_mejora_destino_descrip->SetDBValue($this->f("tipo_mejora_destino_descrip"));
        $this->tipo_mejora_destino_abrev->SetDBValue($this->f("tipo_mejora_destino_abrev"));
    }
//End SetValues Method

//Insert Method @15-B1B0AAB2
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["tipo_mejora_destino_descrip"]["Value"] = $this->tipo_mejora_destino_descrip->GetDBValue(true);
        $this->InsertFields["tipo_mejora_destino_abrev"]["Value"] = $this->tipo_mejora_destino_abrev->GetDBValue(true);
        $this->SQL = CCBuildInsert("tipos_mejoras_destinos", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @15-4062DF72
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "tipo_mejora_destino_id=" . $this->ToSQL($this->CachedColumns["tipo_mejora_destino_id"], ccsInteger);
        $this->UpdateFields["tipo_mejora_destino_descrip"]["Value"] = $this->tipo_mejora_destino_descrip->GetDBValue(true);
        $this->UpdateFields["tipo_mejora_destino_abrev"]["Value"] = $this->tipo_mejora_destino_abrev->GetDBValue(true);
        $this->SQL = CCBuildUpdate("tipos_mejoras_destinos", $this->UpdateFields, $this);
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

//Delete Method @15-61A15474
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "tipo_mejora_destino_id=" . $this->ToSQL($this->CachedColumns["tipo_mejora_destino_id"], ccsInteger);
        $this->SQL = "DELETE FROM tipos_mejoras_destinos";
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

} //End tipos_mejoras_destinos1DataSource Class @15-FCB6E20C

class clsRecordtipos_mejoras_destinosSearch1 { //tipos_mejoras_destinosSearch1 Class @16-5C7C890C

//Variables @16-9E315808

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

//Class_Initialize Event @16-A7EC8AF6
    function clsRecordtipos_mejoras_destinosSearch1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record tipos_mejoras_destinosSearch1/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "tipos_mejoras_destinosSearch1";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->ClearParameters = new clsControl(ccsLink, "ClearParameters", "ClearParameters", ccsText, "", CCGetRequestParam("ClearParameters", $Method, NULL), $this);
            $this->ClearParameters->Parameters = CCGetQueryString("QueryString", array("s_tipo_mejora_destino_descrip", "ccsForm"));
            $this->ClearParameters->Page = "pa_tipos_mejoras_destinos.php";
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_tipo_mejora_destino_descrip = new clsControl(ccsTextBox, "s_tipo_mejora_destino_descrip", "s_tipo_mejora_destino_descrip", ccsText, "", CCGetRequestParam("s_tipo_mejora_destino_descrip", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @16-2CD46250
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_tipo_mejora_destino_descrip->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_tipo_mejora_destino_descrip->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @16-6E8FE5B2
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->ClearParameters->Errors->Count());
        $errors = ($errors || $this->s_tipo_mejora_destino_descrip->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @16-ED598703
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

//Operation Method @16-EF899799
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
        $Redirect = "pa_tipos_mejoras_destinos.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "pa_tipos_mejoras_destinos.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @16-CD36EAC5
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
            $Error = ComposeStrings($Error, $this->s_tipo_mejora_destino_descrip->Errors->ToString());
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
        $this->s_tipo_mejora_destino_descrip->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End tipos_mejoras_destinosSearch1 Class @16-FCB6E20C

//Include Page implementation @28-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @30-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @31-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Initialize Page @1-D02117DF
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
$TemplateFileName = "pa_tipos_mejoras_destinos.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-EBD61E8C
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tipos_mejoras_destinos1 = new clsEditableGridtipos_mejoras_destinos1("", $MainPage);
$tipos_mejoras_destinosSearch1 = new clsRecordtipos_mejoras_destinosSearch1("", $MainPage);
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$MainPage->tipos_mejoras_destinos1 = & $tipos_mejoras_destinos1;
$MainPage->tipos_mejoras_destinosSearch1 = & $tipos_mejoras_destinosSearch1;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$tipos_mejoras_destinos1->Initialize();

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

//Execute Components @1-73118D18
$tipos_mejoras_destinos1->Operation();
$tipos_mejoras_destinosSearch1->Operation();
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
//End Execute Components

//Go to destination page @1-25A3FDD6
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    unset($tipos_mejoras_destinos1);
    unset($tipos_mejoras_destinosSearch1);
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

//Show Page @1-CDEFCE62
$tipos_mejoras_destinos1->Show();
$tipos_mejoras_destinosSearch1->Show();
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$KOMJKMSO5C0A8J = array("<center><font f","ace=\"Arial\">","<small>Ge&#110;","&#101;&#114;","a&#116;&#101;d"," <!-- CCS --",">&#119;&#105;","t&#104; <!-- CCS"," -->Cod&#101;&#","67;h&#97;rg&#10","1; <!-- SCC -->St","&#117;&#100;&#","105;o.</small></","font></center>");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($KOMJKMSO5C0A8J,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($KOMJKMSO5C0A8J,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($KOMJKMSO5C0A8J,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-1471741E
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($tipos_mejoras_destinos1);
unset($tipos_mejoras_destinosSearch1);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($Tpl);
//End Unload Page


?>
