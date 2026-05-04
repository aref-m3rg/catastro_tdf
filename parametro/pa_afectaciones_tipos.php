<?php
//Include Common Files @1-FADF22C5
define("RelativePath", "..");
define("PathToCurrentPage", "/parametro/");
define("FileName", "pa_afectaciones_tipos.php");
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

class clsEditableGridtipos_afectaciones { //tipos_afectaciones Class @6-B7AB6830

//Variables @6-B601F54E

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
    public $Sorter_tipo_afectacion_nombre;
    public $Sorter_tipo_afectacion_abrev;
//End Variables

//Class_Initialize Event @6-3F91FCF5
    function clsEditableGridtipos_afectaciones($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid tipos_afectaciones/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "tipos_afectaciones";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["tipo_afectacion_id"][0] = "tipo_afectacion_id";
        $this->DataSource = new clstipos_afectacionesDataSource($this);
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

        $this->SorterName = CCGetParam("tipos_afectacionesOrder", "");
        $this->SorterDirection = CCGetParam("tipos_afectacionesDir", "");

        $this->Sorter_tipo_afectacion_nombre = new clsSorter($this->ComponentName, "Sorter_tipo_afectacion_nombre", $FileName, $this);
        $this->Sorter_tipo_afectacion_abrev = new clsSorter($this->ComponentName, "Sorter_tipo_afectacion_abrev", $FileName, $this);
        $this->tipo_afectacion_nombre = new clsControl(ccsTextBox, "tipo_afectacion_nombre", "Nombre", ccsText, "", NULL, $this);
        $this->tipo_afectacion_nombre->Required = true;
        $this->tipo_afectacion_abrev = new clsControl(ccsTextBox, "tipo_afectacion_abrev", "Abreviatura", ccsText, "", NULL, $this);
        $this->tipo_afectacion_abrev->Required = true;
        $this->CheckBox_Delete = new clsControl(ccsCheckBox, "CheckBox_Delete", "CheckBox_Delete", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), NULL, $this);
        $this->CheckBox_Delete->CheckedValue = true;
        $this->CheckBox_Delete->UncheckedValue = false;
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Button_Submit = new clsButton("Button_Submit", $Method, $this);
        $this->CheckBox1 = new clsControl(ccsCheckBox, "CheckBox1", "CheckBox1", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), NULL, $this);
        $this->CheckBox1->CheckedValue = true;
        $this->CheckBox1->UncheckedValue = false;
    }
//End Class_Initialize Event

//Initialize Method @6-9C4C78B1
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["urls_tipo_afectacion_nombre"] = CCGetFromGet("s_tipo_afectacion_nombre", NULL);
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

//GetFormParameters Method @6-4ECD3C77
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["tipo_afectacion_nombre"][$RowNumber] = CCGetFromPost("tipo_afectacion_nombre_" . $RowNumber, NULL);
            $this->FormParameters["tipo_afectacion_abrev"][$RowNumber] = CCGetFromPost("tipo_afectacion_abrev_" . $RowNumber, NULL);
            $this->FormParameters["CheckBox_Delete"][$RowNumber] = CCGetFromPost("CheckBox_Delete_" . $RowNumber, NULL);
            $this->FormParameters["CheckBox1"][$RowNumber] = CCGetFromPost("CheckBox1_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @6-E0745FD9
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["tipo_afectacion_id"] = $this->CachedColumns["tipo_afectacion_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->tipo_afectacion_nombre->SetText($this->FormParameters["tipo_afectacion_nombre"][$this->RowNumber], $this->RowNumber);
            $this->tipo_afectacion_abrev->SetText($this->FormParameters["tipo_afectacion_abrev"][$this->RowNumber], $this->RowNumber);
            $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
            $this->CheckBox1->SetText($this->FormParameters["CheckBox1"][$this->RowNumber], $this->RowNumber);
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

//ValidateRow Method @6-10E62314
    function ValidateRow()
    {
        global $CCSLocales;
        $this->tipo_afectacion_nombre->Validate();
        $this->tipo_afectacion_abrev->Validate();
        $this->CheckBox_Delete->Validate();
        $this->CheckBox1->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->tipo_afectacion_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_afectacion_abrev->Errors->ToString());
        $errors = ComposeStrings($errors, $this->CheckBox_Delete->Errors->ToString());
        $errors = ComposeStrings($errors, $this->CheckBox1->Errors->ToString());
        $this->tipo_afectacion_nombre->Errors->Clear();
        $this->tipo_afectacion_abrev->Errors->Clear();
        $this->CheckBox_Delete->Errors->Clear();
        $this->CheckBox1->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @6-A4752CC6
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["tipo_afectacion_nombre"][$this->RowNumber]) && count($this->FormParameters["tipo_afectacion_nombre"][$this->RowNumber])) || strlen($this->FormParameters["tipo_afectacion_nombre"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["tipo_afectacion_abrev"][$this->RowNumber]) && count($this->FormParameters["tipo_afectacion_abrev"][$this->RowNumber])) || strlen($this->FormParameters["tipo_afectacion_abrev"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["CheckBox1"][$this->RowNumber]) && count($this->FormParameters["CheckBox1"][$this->RowNumber])) || strlen($this->FormParameters["CheckBox1"][$this->RowNumber]));
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

//UpdateGrid Method @6-34EC4905
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["tipo_afectacion_id"] = $this->CachedColumns["tipo_afectacion_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->tipo_afectacion_nombre->SetText($this->FormParameters["tipo_afectacion_nombre"][$this->RowNumber], $this->RowNumber);
            $this->tipo_afectacion_abrev->SetText($this->FormParameters["tipo_afectacion_abrev"][$this->RowNumber], $this->RowNumber);
            $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
            $this->CheckBox1->SetText($this->FormParameters["CheckBox1"][$this->RowNumber], $this->RowNumber);
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

//InsertRow Method @6-2D8547EC
    function InsertRow()
    {
        if(!$this->InsertAllowed) return false;
        $this->DataSource->tipo_afectacion_nombre->SetValue($this->tipo_afectacion_nombre->GetValue(true));
        $this->DataSource->tipo_afectacion_abrev->SetValue($this->tipo_afectacion_abrev->GetValue(true));
        $this->DataSource->CheckBox1->SetValue($this->CheckBox1->GetValue(true));
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

//UpdateRow Method @6-6B2FC6F1
    function UpdateRow()
    {
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->tipo_afectacion_nombre->SetValue($this->tipo_afectacion_nombre->GetValue(true));
        $this->DataSource->tipo_afectacion_abrev->SetValue($this->tipo_afectacion_abrev->GetValue(true));
        $this->DataSource->CheckBox1->SetValue($this->CheckBox1->GetValue(true));
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

//SetFormState Method @6-749FC407
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
                $this->CachedColumns["tipo_afectacion_id"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["tipo_afectacion_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @6-5FB3ADD1
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["tipo_afectacion_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @6-FC7E7178
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
        $this->ControlsVisible["tipo_afectacion_nombre"] = $this->tipo_afectacion_nombre->Visible;
        $this->ControlsVisible["tipo_afectacion_abrev"] = $this->tipo_afectacion_abrev->Visible;
        $this->ControlsVisible["CheckBox_Delete"] = $this->CheckBox_Delete->Visible;
        $this->ControlsVisible["CheckBox1"] = $this->CheckBox1->Visible;
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
                    $this->CachedColumns["tipo_afectacion_id"][$this->RowNumber] = $this->DataSource->CachedColumns["tipo_afectacion_id"];
                    $this->CheckBox_Delete->SetValue("");
                    $this->tipo_afectacion_nombre->SetValue($this->DataSource->tipo_afectacion_nombre->GetValue());
                    $this->tipo_afectacion_abrev->SetValue($this->DataSource->tipo_afectacion_abrev->GetValue());
                    $this->CheckBox1->SetValue($this->DataSource->CheckBox1->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->tipo_afectacion_nombre->SetText($this->FormParameters["tipo_afectacion_nombre"][$this->RowNumber], $this->RowNumber);
                    $this->tipo_afectacion_abrev->SetText($this->FormParameters["tipo_afectacion_abrev"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox1->SetText($this->FormParameters["CheckBox1"][$this->RowNumber], $this->RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["tipo_afectacion_id"][$this->RowNumber] = "";
                    $this->tipo_afectacion_nombre->SetText("");
                    $this->tipo_afectacion_abrev->SetText("");
                    $this->CheckBox1->SetValue(false);
                } else {
                    $this->tipo_afectacion_nombre->SetText($this->FormParameters["tipo_afectacion_nombre"][$this->RowNumber], $this->RowNumber);
                    $this->tipo_afectacion_abrev->SetText($this->FormParameters["tipo_afectacion_abrev"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox1->SetText($this->FormParameters["CheckBox1"][$this->RowNumber], $this->RowNumber);
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->tipo_afectacion_nombre->Show($this->RowNumber);
                $this->tipo_afectacion_abrev->Show($this->RowNumber);
                $this->CheckBox_Delete->Show($this->RowNumber);
                $this->CheckBox1->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["tipo_afectacion_id"] == $this->CachedColumns["tipo_afectacion_id"][$this->RowNumber])) {
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
        $this->Sorter_tipo_afectacion_nombre->Show();
        $this->Sorter_tipo_afectacion_abrev->Show();
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

} //End tipos_afectaciones Class @6-FCB6E20C

class clstipos_afectacionesDataSource extends clsDBtdf_nuevo {  //tipos_afectacionesDataSource Class @6-B7B64B2C

//DataSource Variables @6-ED600596
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
    public $tipo_afectacion_nombre;
    public $tipo_afectacion_abrev;
    public $CheckBox_Delete;
    public $CheckBox1;
//End DataSource Variables

//DataSourceClass_Initialize Event @6-A513DF86
    function clstipos_afectacionesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid tipos_afectaciones/Error";
        $this->Initialize();
        $this->tipo_afectacion_nombre = new clsField("tipo_afectacion_nombre", ccsText, "");
        
        $this->tipo_afectacion_abrev = new clsField("tipo_afectacion_abrev", ccsText, "");
        
        $this->CheckBox_Delete = new clsField("CheckBox_Delete", ccsBoolean, $this->BooleanFormat);
        
        $this->CheckBox1 = new clsField("CheckBox1", ccsBoolean, $this->BooleanFormat);
        

        $this->InsertFields["tipo_afectacion_nombre"] = array("Name" => "tipo_afectacion_nombre", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_afectacion_abrev"] = array("Name" => "tipo_afectacion_abrev", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_afectacion_req_plano"] = array("Name" => "tipo_afectacion_req_plano", "Value" => "", "DataType" => ccsBoolean);
        $this->UpdateFields["tipo_afectacion_nombre"] = array("Name" => "tipo_afectacion_nombre", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_afectacion_abrev"] = array("Name" => "tipo_afectacion_abrev", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_afectacion_req_plano"] = array("Name" => "tipo_afectacion_req_plano", "Value" => "", "DataType" => ccsBoolean);
    }
//End DataSourceClass_Initialize Event

//SetOrder Method @6-011B7805
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "tipo_afectacion_nombre";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_tipo_afectacion_nombre" => array("tipo_afectacion_nombre", ""), 
            "Sorter_tipo_afectacion_abrev" => array("tipo_afectacion_abrev", "")));
    }
//End SetOrder Method

//Prepare Method @6-3B8B1DEE
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_tipo_afectacion_nombre", ccsText, "", "", $this->Parameters["urls_tipo_afectacion_nombre"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "tipo_afectacion_nombre", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @6-AD6284A1
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM tipos_afectaciones";
        $this->SQL = "SELECT * \n\n" .
        "FROM tipos_afectaciones {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @6-4E72180B
    function SetValues()
    {
        $this->CachedColumns["tipo_afectacion_id"] = $this->f("tipo_afectacion_id");
        $this->tipo_afectacion_nombre->SetDBValue($this->f("tipo_afectacion_nombre"));
        $this->tipo_afectacion_abrev->SetDBValue($this->f("tipo_afectacion_abrev"));
        $this->CheckBox1->SetDBValue(trim($this->f("tipo_afectacion_req_plano")));
    }
//End SetValues Method

//Insert Method @6-5774AE23
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["tipo_afectacion_nombre"]["Value"] = $this->tipo_afectacion_nombre->GetDBValue(true);
        $this->InsertFields["tipo_afectacion_abrev"]["Value"] = $this->tipo_afectacion_abrev->GetDBValue(true);
        $this->InsertFields["tipo_afectacion_req_plano"]["Value"] = $this->CheckBox1->GetDBValue(true);
        $this->SQL = CCBuildInsert("tipos_afectaciones", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @6-90DB4950
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "tipo_afectacion_id=" . $this->ToSQL($this->CachedColumns["tipo_afectacion_id"], ccsInteger);
        $this->UpdateFields["tipo_afectacion_nombre"]["Value"] = $this->tipo_afectacion_nombre->GetDBValue(true);
        $this->UpdateFields["tipo_afectacion_abrev"]["Value"] = $this->tipo_afectacion_abrev->GetDBValue(true);
        $this->UpdateFields["tipo_afectacion_req_plano"]["Value"] = $this->CheckBox1->GetDBValue(true);
        $this->SQL = CCBuildUpdate("tipos_afectaciones", $this->UpdateFields, $this);
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

//Delete Method @6-C6A41995
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "tipo_afectacion_id=" . $this->ToSQL($this->CachedColumns["tipo_afectacion_id"], ccsInteger);
        $this->SQL = "DELETE FROM tipos_afectaciones";
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

} //End tipos_afectacionesDataSource Class @6-FCB6E20C

class clsRecordtipos_afectacionesSearch { //tipos_afectacionesSearch Class @7-7320DC5D

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

//Class_Initialize Event @7-C825FFEA
    function clsRecordtipos_afectacionesSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record tipos_afectacionesSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "tipos_afectacionesSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_tipo_afectacion_nombre = new clsControl(ccsTextBox, "s_tipo_afectacion_nombre", "s_tipo_afectacion_nombre", ccsText, "", CCGetRequestParam("s_tipo_afectacion_nombre", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @7-1A358A48
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_tipo_afectacion_nombre->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_tipo_afectacion_nombre->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @7-5F406AEC
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_tipo_afectacion_nombre->Errors->Count());
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

//Operation Method @7-62B51B85
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
        $Redirect = "pa_afectaciones_tipos.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "pa_afectaciones_tipos.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @7-17A0ABEF
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
            $Error = ComposeStrings($Error, $this->s_tipo_afectacion_nombre->Errors->ToString());
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
        $this->s_tipo_afectacion_nombre->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End tipos_afectacionesSearch Class @7-FCB6E20C

//Initialize Page @1-FE6C80B3
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
$TemplateFileName = "pa_afectaciones_tipos.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-D9DBF8C9
CCSecurityRedirect("1;2", "");
//End Authenticate User

//Include events file @1-3F2AB240
include_once("./pa_afectaciones_tipos_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-22B9975D
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
$tipos_afectaciones = new clsEditableGridtipos_afectaciones("", $MainPage);
$tipos_afectacionesSearch = new clsRecordtipos_afectacionesSearch("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tipos_afectaciones = & $tipos_afectaciones;
$MainPage->tipos_afectacionesSearch = & $tipos_afectacionesSearch;
$tipos_afectaciones->Initialize();

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

//Execute Components @1-B0F7C80A
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
$tipos_afectaciones->Operation();
$tipos_afectacionesSearch->Operation();
//End Execute Components

//Go to destination page @1-B9837C92
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($tipos_afectaciones);
    unset($tipos_afectacionesSearch);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-885BB577
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$tipos_afectaciones->Show();
$tipos_afectacionesSearch->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font face=\"Ari" . "al\"><small>Ge&#110;&#1" . "01;&#114;a&#116;&#10" . "1;&#100; <!-- SCC -" . "->w&#105;t&#104; <!-" . "- SCC -->&#67;&#111;" . "d&#101;C&#104;&#97;&#" . "114;&#103;e <!-- CCS" . " -->St&#117;di&#111;." . "</small></font></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font face=\"Ari" . "al\"><small>Ge&#110;&#1" . "01;&#114;a&#116;&#10" . "1;&#100; <!-- SCC -" . "->w&#105;t&#104; <!-" . "- SCC -->&#67;&#111;" . "d&#101;C&#104;&#97;&#" . "114;&#103;e <!-- CCS" . " -->St&#117;di&#111;." . "</small></font></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font face=\"Ari" . "al\"><small>Ge&#110;&#1" . "01;&#114;a&#116;&#10" . "1;&#100; <!-- SCC -" . "->w&#105;t&#104; <!-" . "- SCC -->&#67;&#111;" . "d&#101;C&#104;&#97;&#" . "114;&#103;e <!-- CCS" . " -->St&#117;di&#111;." . "</small></font></center>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-C4FEB88C
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($tipos_afectaciones);
unset($tipos_afectacionesSearch);
unset($Tpl);
//End Unload Page


?>
