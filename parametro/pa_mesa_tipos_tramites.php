<?php
//Include Common Files @1-1B986E5A
define("RelativePath", "..");
define("PathToCurrentPage", "/parametro/");
define("FileName", "pa_mesa_tipos_tramites.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @2-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @4-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @5-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

class clsEditableGridtramites { //tramites Class @6-F81E6507

//Variables @6-B9C5BC16

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
    public $Sorter_tramite_id;
    public $Sorter_tramite_desc;
    public $Sorter_tramite_abrev;
    public $Sorter_estado_id;
//End Variables

//Class_Initialize Event @6-B47A5F11
    function clsEditableGridtramites($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid tramites/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "tramites";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["tramite_id"][0] = "tramite_id";
        $this->DataSource = new clstramitesDataSource($this);
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

        $this->SorterName = CCGetParam("tramitesOrder", "");
        $this->SorterDirection = CCGetParam("tramitesDir", "");

        $this->Sorter_tramite_id = new clsSorter($this->ComponentName, "Sorter_tramite_id", $FileName, $this);
        $this->Sorter_tramite_desc = new clsSorter($this->ComponentName, "Sorter_tramite_desc", $FileName, $this);
        $this->Sorter_tramite_abrev = new clsSorter($this->ComponentName, "Sorter_tramite_abrev", $FileName, $this);
        $this->Sorter_estado_id = new clsSorter($this->ComponentName, "Sorter_estado_id", $FileName, $this);
        $this->tramite_id = new clsControl(ccsLabel, "tramite_id", "Id", ccsInteger, "", NULL, $this);
        $this->tramite_desc = new clsControl(ccsTextBox, "tramite_desc", "Descripción", ccsText, "", NULL, $this);
        $this->tramite_desc->Required = true;
        $this->tramite_abrev = new clsControl(ccsTextBox, "tramite_abrev", "Abreviatura", ccsText, "", NULL, $this);
        $this->tramite_abrev->Required = true;
        $this->estado_id = new clsControl(ccsListBox, "estado_id", "Estado", ccsInteger, "", NULL, $this);
        $this->estado_id->DSType = dsTable;
        $this->estado_id->DataSource = new clsDBmesa();
        $this->estado_id->ds = & $this->estado_id->DataSource;
        $this->estado_id->DataSource->SQL = "SELECT * \n" .
"FROM estados {SQL_Where} {SQL_OrderBy}";
        $this->estado_id->DataSource->Order = "estado_desc";
        list($this->estado_id->BoundColumn, $this->estado_id->TextColumn, $this->estado_id->DBFormat) = array("estado_id", "estado_desc", "");
        $this->estado_id->DataSource->Order = "estado_desc";
        $this->estado_id->Required = true;
        $this->CheckBox_Delete = new clsControl(ccsCheckBox, "CheckBox_Delete", "CheckBox_Delete", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), NULL, $this);
        $this->CheckBox_Delete->CheckedValue = true;
        $this->CheckBox_Delete->UncheckedValue = false;
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Button_Submit = new clsButton("Button_Submit", $Method, $this);
    }
//End Class_Initialize Event

//Initialize Method @6-A0F82FF6
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["urls_tramite_desc"] = CCGetFromGet("s_tramite_desc", NULL);
        $this->DataSource->Parameters["urls_estado_id"] = CCGetFromGet("s_estado_id", NULL);
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

//GetFormParameters Method @6-4207E783
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["tramite_desc"][$RowNumber] = CCGetFromPost("tramite_desc_" . $RowNumber, NULL);
            $this->FormParameters["tramite_abrev"][$RowNumber] = CCGetFromPost("tramite_abrev_" . $RowNumber, NULL);
            $this->FormParameters["estado_id"][$RowNumber] = CCGetFromPost("estado_id_" . $RowNumber, NULL);
            $this->FormParameters["CheckBox_Delete"][$RowNumber] = CCGetFromPost("CheckBox_Delete_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @6-66CCD093
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $this->StoredValues = array();

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["tramite_id"] = $this->CachedColumns["tramite_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->tramite_desc->SetText($this->FormParameters["tramite_desc"][$this->RowNumber], $this->RowNumber);
            $this->tramite_abrev->SetText($this->FormParameters["tramite_abrev"][$this->RowNumber], $this->RowNumber);
            $this->estado_id->SetText($this->FormParameters["estado_id"][$this->RowNumber], $this->RowNumber);
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

//ValidateRow Method @6-D2704576
    function ValidateRow()
    {
        global $CCSLocales;
        if(strlen($this->CachedColumns["tramite_id"][$this->RowNumber])) 
            $Where = " AND tramite_id <> " . $this->DataSource->ToSQL($this->CachedColumns["tramite_id"][$this->RowNumber], ccsInteger); 
        else
            $Where = "";
        if (!isset($this->StoredValues["tramite_desc"])) $this->StoredValues["tramite_desc"] = array();
        $this->DataSource->tramite_desc->SetValue($this->tramite_desc->GetValue());
        if(CCDLookUp("COUNT(*)", "tramites", "tramite_desc=" . $this->DataSource->ToSQL($this->DataSource->tramite_desc->GetDBValue(), $this->DataSource->tramite_desc->DataType) . $Where, $this->DataSource) > 0)
            $this->tramite_desc->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "Descripción"));
        else if (in_array($this->tramite_desc->GetValue(), $this->StoredValues["tramite_desc"]))
            $this->tramite_desc->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "Descripción"));
        $this->StoredValues["tramite_desc"][] = $this->tramite_desc->GetValue();
        $this->tramite_desc->Validate();
        $this->tramite_abrev->Validate();
        $this->estado_id->Validate();
        $this->CheckBox_Delete->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->tramite_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tramite_abrev->Errors->ToString());
        $errors = ComposeStrings($errors, $this->estado_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->CheckBox_Delete->Errors->ToString());
        $this->tramite_desc->Errors->Clear();
        $this->tramite_abrev->Errors->Clear();
        $this->estado_id->Errors->Clear();
        $this->CheckBox_Delete->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @6-8E6F7915
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["tramite_desc"][$this->RowNumber]) && count($this->FormParameters["tramite_desc"][$this->RowNumber])) || strlen($this->FormParameters["tramite_desc"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["tramite_abrev"][$this->RowNumber]) && count($this->FormParameters["tramite_abrev"][$this->RowNumber])) || strlen($this->FormParameters["tramite_abrev"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["estado_id"][$this->RowNumber]) && count($this->FormParameters["estado_id"][$this->RowNumber])) || strlen($this->FormParameters["estado_id"][$this->RowNumber]));
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

//Operation Method @6-909F269B
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

//UpdateGrid Method @6-EBFE4DB2
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["tramite_id"] = $this->CachedColumns["tramite_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->tramite_desc->SetText($this->FormParameters["tramite_desc"][$this->RowNumber], $this->RowNumber);
            $this->tramite_abrev->SetText($this->FormParameters["tramite_abrev"][$this->RowNumber], $this->RowNumber);
            $this->estado_id->SetText($this->FormParameters["estado_id"][$this->RowNumber], $this->RowNumber);
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

//InsertRow Method @6-0CA336CA
    function InsertRow()
    {
        if(!$this->InsertAllowed) return false;
        $this->DataSource->tramite_id->SetValue($this->tramite_id->GetValue(true));
        $this->DataSource->tramite_desc->SetValue($this->tramite_desc->GetValue(true));
        $this->DataSource->tramite_abrev->SetValue($this->tramite_abrev->GetValue(true));
        $this->DataSource->estado_id->SetValue($this->estado_id->GetValue(true));
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

//UpdateRow Method @6-3E0CA2A8
    function UpdateRow()
    {
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->tramite_id->SetValue($this->tramite_id->GetValue(true));
        $this->DataSource->tramite_desc->SetValue($this->tramite_desc->GetValue(true));
        $this->DataSource->tramite_abrev->SetValue($this->tramite_abrev->GetValue(true));
        $this->DataSource->estado_id->SetValue($this->estado_id->GetValue(true));
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

//DeleteRow Method @6-A4A656F6
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

//FormScript Method @6-59800DB5
    function FormScript($TotalRows)
    {
        $script = "";
        return $script;
    }
//End FormScript Method

//SetFormState Method @6-D3980967
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
                $this->CachedColumns["tramite_id"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["tramite_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @6-5F781EDC
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["tramite_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @6-33247B17
    function Show()
    {
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        global $CCSUseAmp;
        $Error = "";

        if(!$this->Visible) { return; }

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->estado_id->Prepare();

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
        $this->ControlsVisible["tramite_id"] = $this->tramite_id->Visible;
        $this->ControlsVisible["tramite_desc"] = $this->tramite_desc->Visible;
        $this->ControlsVisible["tramite_abrev"] = $this->tramite_abrev->Visible;
        $this->ControlsVisible["estado_id"] = $this->estado_id->Visible;
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
                    $this->CachedColumns["tramite_id"][$this->RowNumber] = $this->DataSource->CachedColumns["tramite_id"];
                    $this->CheckBox_Delete->SetValue("");
                    $this->tramite_id->SetValue($this->DataSource->tramite_id->GetValue());
                    $this->tramite_desc->SetValue($this->DataSource->tramite_desc->GetValue());
                    $this->tramite_abrev->SetValue($this->DataSource->tramite_abrev->GetValue());
                    $this->estado_id->SetValue($this->DataSource->estado_id->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->tramite_id->SetText("");
                    $this->tramite_id->SetValue($this->DataSource->tramite_id->GetValue());
                    $this->tramite_desc->SetText($this->FormParameters["tramite_desc"][$this->RowNumber], $this->RowNumber);
                    $this->tramite_abrev->SetText($this->FormParameters["tramite_abrev"][$this->RowNumber], $this->RowNumber);
                    $this->estado_id->SetText($this->FormParameters["estado_id"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["tramite_id"][$this->RowNumber] = "";
                    $this->tramite_id->SetText("");
                    $this->tramite_desc->SetText("");
                    $this->tramite_abrev->SetText("");
                    $this->estado_id->SetText("");
                } else {
                    $this->tramite_id->SetText("");
                    $this->tramite_desc->SetText($this->FormParameters["tramite_desc"][$this->RowNumber], $this->RowNumber);
                    $this->tramite_abrev->SetText($this->FormParameters["tramite_abrev"][$this->RowNumber], $this->RowNumber);
                    $this->estado_id->SetText($this->FormParameters["estado_id"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->tramite_id->Show($this->RowNumber);
                $this->tramite_desc->Show($this->RowNumber);
                $this->tramite_abrev->Show($this->RowNumber);
                $this->estado_id->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["tramite_id"] == $this->CachedColumns["tramite_id"][$this->RowNumber])) {
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
        $this->Sorter_tramite_id->Show();
        $this->Sorter_tramite_desc->Show();
        $this->Sorter_tramite_abrev->Show();
        $this->Sorter_estado_id->Show();
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

} //End tramites Class @6-FCB6E20C

class clstramitesDataSource extends clsDBmesa {  //tramitesDataSource Class @6-BFD6BBB5

//DataSource Variables @6-E2148E3C
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
    public $tramite_id;
    public $tramite_desc;
    public $tramite_abrev;
    public $estado_id;
    public $CheckBox_Delete;
//End DataSource Variables

//DataSourceClass_Initialize Event @6-644BE6A0
    function clstramitesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid tramites/Error";
        $this->Initialize();
        $this->tramite_id = new clsField("tramite_id", ccsInteger, "");
        
        $this->tramite_desc = new clsField("tramite_desc", ccsText, "");
        
        $this->tramite_abrev = new clsField("tramite_abrev", ccsText, "");
        
        $this->estado_id = new clsField("estado_id", ccsInteger, "");
        
        $this->CheckBox_Delete = new clsField("CheckBox_Delete", ccsBoolean, $this->BooleanFormat);
        

        $this->InsertFields["tramite_desc"] = array("Name" => "tramite_desc", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tramite_abrev"] = array("Name" => "tramite_abrev", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["estado_id"] = array("Name" => "estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tramite_desc"] = array("Name" => "tramite_desc", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tramite_abrev"] = array("Name" => "tramite_abrev", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["estado_id"] = array("Name" => "estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//SetOrder Method @6-F0BD2D22
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "tramite_desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_tramite_id" => array("tramite_id", ""), 
            "Sorter_tramite_desc" => array("tramite_desc", ""), 
            "Sorter_tramite_abrev" => array("tramite_abrev", ""), 
            "Sorter_estado_id" => array("estado_id", "")));
    }
//End SetOrder Method

//Prepare Method @6-6CDC739A
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_tramite_desc", ccsText, "", "", $this->Parameters["urls_tramite_desc"], "", false);
        $this->wp->AddParameter("2", "urls_estado_id", ccsInteger, "", "", $this->Parameters["urls_estado_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "tramite_desc", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "estado_id", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @6-BB3E184E
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM tramites";
        $this->SQL = "SELECT * \n\n" .
        "FROM tramites {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @6-D32B4011
    function SetValues()
    {
        $this->CachedColumns["tramite_id"] = $this->f("tramite_id");
        $this->tramite_id->SetDBValue(trim($this->f("tramite_id")));
        $this->tramite_desc->SetDBValue($this->f("tramite_desc"));
        $this->tramite_abrev->SetDBValue($this->f("tramite_abrev"));
        $this->estado_id->SetDBValue(trim($this->f("estado_id")));
    }
//End SetValues Method

//Insert Method @6-87FA5CD7
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["tramite_desc"]["Value"] = $this->tramite_desc->GetDBValue(true);
        $this->InsertFields["tramite_abrev"]["Value"] = $this->tramite_abrev->GetDBValue(true);
        $this->InsertFields["estado_id"]["Value"] = $this->estado_id->GetDBValue(true);
        $this->SQL = CCBuildInsert("tramites", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @6-EAFFE047
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "tramite_id=" . $this->ToSQL($this->CachedColumns["tramite_id"], ccsInteger);
        $this->UpdateFields["tramite_desc"]["Value"] = $this->tramite_desc->GetDBValue(true);
        $this->UpdateFields["tramite_abrev"]["Value"] = $this->tramite_abrev->GetDBValue(true);
        $this->UpdateFields["estado_id"]["Value"] = $this->estado_id->GetDBValue(true);
        $this->SQL = CCBuildUpdate("tramites", $this->UpdateFields, $this);
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

//Delete Method @6-ADDFC1E8
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "tramite_id=" . $this->ToSQL($this->CachedColumns["tramite_id"], ccsInteger);
        $this->SQL = "DELETE FROM tramites";
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

} //End tramitesDataSource Class @6-FCB6E20C

class clsRecordtramitesSearch { //tramitesSearch Class @7-D872344C

//Variables @7-9E315808

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

//Class_Initialize Event @7-B195302D
    function clsRecordtramitesSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record tramitesSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "tramitesSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_tramite_desc = new clsControl(ccsTextBox, "s_tramite_desc", "s_tramite_desc", ccsText, "", CCGetRequestParam("s_tramite_desc", $Method, NULL), $this);
            $this->s_estado_id = new clsControl(ccsListBox, "s_estado_id", "s_estado_id", ccsInteger, "", CCGetRequestParam("s_estado_id", $Method, NULL), $this);
            $this->s_estado_id->DSType = dsTable;
            $this->s_estado_id->DataSource = new clsDBtdf_nuevo();
            $this->s_estado_id->ds = & $this->s_estado_id->DataSource;
            $this->s_estado_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_estados {SQL_Where} {SQL_OrderBy}";
            list($this->s_estado_id->BoundColumn, $this->s_estado_id->TextColumn, $this->s_estado_id->DBFormat) = array("tipo_estado_id", "tipo_estado_descrip", "");
        }
    }
//End Class_Initialize Event

//Validate Method @7-2CE34EFE
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_tramite_desc->Validate() && $Validation);
        $Validation = ($this->s_estado_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_tramite_desc->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_estado_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @7-CDEE470F
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_tramite_desc->Errors->Count());
        $errors = ($errors || $this->s_estado_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @7-ED598703
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

//Operation Method @7-3509C5A2
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
        $Redirect = "pa_mesa_tipos_tramites.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "pa_mesa_tipos_tramites.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @7-7B4E1D30
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

        $this->s_estado_id->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_tramite_desc->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_estado_id->Errors->ToString());
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
        $this->s_tramite_desc->Show();
        $this->s_estado_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End tramitesSearch Class @7-FCB6E20C

//Initialize Page @1-83F70AFB
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
$TemplateFileName = "pa_mesa_tipos_tramites.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-D9DBF8C9
CCSecurityRedirect("1;2", "");
//End Authenticate User

//Include events file @1-A93B6C09
include_once("./pa_mesa_tipos_tramites_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-67FAD31E
$DBmesa = new clsDBmesa();
$MainPage->Connections["mesa"] = & $DBmesa;
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$tramites = new clsEditableGridtramites("", $MainPage);
$tramitesSearch = new clsRecordtramitesSearch("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tramites = & $tramites;
$MainPage->tramitesSearch = & $tramitesSearch;
$tramites->Initialize();

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

//Execute Components @1-1C3D4295
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
$tramites->Operation();
$tramitesSearch->Operation();
//End Execute Components

//Go to destination page @1-3B7CA40B
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBmesa->close();
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($tramites);
    unset($tramitesSearch);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-4D90978F
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$tramites->Show();
$tramitesSearch->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$ACPCH7H9F6S = "<center><font face=\"Arial\"><small>G&#101;&#110;&#101;rate&#100; <!-- CCS -->with <!-- CCS -->C&#111;&#100;e&#67;ha&#114;&#103;e <!-- CCS -->&#83;&#116;u&#100;&#105;o.</small></font></center>";
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", $ACPCH7H9F6S . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", $ACPCH7H9F6S . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= $ACPCH7H9F6S;
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-09F302C1
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmesa->close();
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($tramites);
unset($tramitesSearch);
unset($Tpl);
//End Unload Page


?>
