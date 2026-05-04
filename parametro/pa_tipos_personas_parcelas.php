<?php
//Include Common Files @1-4ED8A78D
define("RelativePath", "..");
define("PathToCurrentPage", "/parametro/");
define("FileName", "pa_tipos_personas_parcelas.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsEditableGridtipos_personas_parcelas { //tipos_personas_parcelas Class @2-EFCC2F47

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

//Class_Initialize Event @2-C8EF262D
    function clsEditableGridtipos_personas_parcelas($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid tipos_personas_parcelas/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "tipos_personas_parcelas";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["tipo_persona_parcela_id"][0] = "tipo_persona_parcela_id";
        $this->DataSource = new clstipos_personas_parcelasDataSource($this);
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

        $this->tipo_persona_parcela_descrip = new clsControl(ccsTextBox, "tipo_persona_parcela_descrip", "Descripción", ccsText, "", NULL, $this);
        $this->tipo_persona_parcela_descrip->Required = true;
        $this->tipo_persona_parcela_abrev = new clsControl(ccsTextBox, "tipo_persona_parcela_abrev", "Abreviatura", ccsText, "", NULL, $this);
        $this->tipo_persona_parcela_abrev->Required = true;
        $this->CheckBox_Delete = new clsControl(ccsCheckBox, "CheckBox_Delete", "CheckBox_Delete", ccsInteger, "", NULL, $this);
        $this->CheckBox_Delete->CheckedValue = $this->CheckBox_Delete->GetParsedValue(2);
        $this->CheckBox_Delete->UncheckedValue = $this->CheckBox_Delete->GetParsedValue(1);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Button_Submit = new clsButton("Button_Submit", $Method, $this);
        $this->Cancel = new clsButton("Cancel", $Method, $this);
    }
//End Class_Initialize Event

//Initialize Method @2-6DF3F5B6
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["urls_tipo_persona_parcela_descrip"] = CCGetFromGet("s_tipo_persona_parcela_descrip", NULL);
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

//GetFormParameters Method @2-387A4981
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["tipo_persona_parcela_descrip"][$RowNumber] = CCGetFromPost("tipo_persona_parcela_descrip_" . $RowNumber, NULL);
            $this->FormParameters["tipo_persona_parcela_abrev"][$RowNumber] = CCGetFromPost("tipo_persona_parcela_abrev_" . $RowNumber, NULL);
            $this->FormParameters["CheckBox_Delete"][$RowNumber] = CCGetFromPost("CheckBox_Delete_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @2-D5F71008
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $this->StoredValues = array();

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["tipo_persona_parcela_id"] = $this->CachedColumns["tipo_persona_parcela_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->tipo_persona_parcela_descrip->SetText($this->FormParameters["tipo_persona_parcela_descrip"][$this->RowNumber], $this->RowNumber);
            $this->tipo_persona_parcela_abrev->SetText($this->FormParameters["tipo_persona_parcela_abrev"][$this->RowNumber], $this->RowNumber);
            $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
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

//ValidateRow Method @2-8F8D06F5
    function ValidateRow()
    {
        global $CCSLocales;
        if(strlen($this->CachedColumns["tipo_persona_parcela_id"][$this->RowNumber])) 
            $Where = " AND tipo_persona_parcela_id <> " . $this->DataSource->ToSQL($this->CachedColumns["tipo_persona_parcela_id"][$this->RowNumber], ccsInteger); 
        else
            $Where = "";
        if (!isset($this->StoredValues["tipo_persona_parcela_descrip"])) $this->StoredValues["tipo_persona_parcela_descrip"] = array();
        $this->DataSource->tipo_persona_parcela_descrip->SetValue($this->tipo_persona_parcela_descrip->GetValue());
        if(CCDLookUp("COUNT(*)", "tipos_personas_parcelas", "tipo_persona_parcela_descrip=" . $this->DataSource->ToSQL($this->DataSource->tipo_persona_parcela_descrip->GetDBValue(), $this->DataSource->tipo_persona_parcela_descrip->DataType) . $Where, $this->DataSource) > 0)
            $this->tipo_persona_parcela_descrip->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "Descripción"));
        else if (in_array($this->tipo_persona_parcela_descrip->GetValue(), $this->StoredValues["tipo_persona_parcela_descrip"]))
            $this->tipo_persona_parcela_descrip->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "Descripción"));
        $this->StoredValues["tipo_persona_parcela_descrip"][] = $this->tipo_persona_parcela_descrip->GetValue();
        $this->tipo_persona_parcela_descrip->Validate();
        $this->tipo_persona_parcela_abrev->Validate();
        $this->CheckBox_Delete->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->tipo_persona_parcela_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_persona_parcela_abrev->Errors->ToString());
        $errors = ComposeStrings($errors, $this->CheckBox_Delete->Errors->ToString());
        $this->tipo_persona_parcela_descrip->Errors->Clear();
        $this->tipo_persona_parcela_abrev->Errors->Clear();
        $this->CheckBox_Delete->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @2-1F4265A3
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["tipo_persona_parcela_descrip"][$this->RowNumber]) && count($this->FormParameters["tipo_persona_parcela_descrip"][$this->RowNumber])) || strlen($this->FormParameters["tipo_persona_parcela_descrip"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["tipo_persona_parcela_abrev"][$this->RowNumber]) && count($this->FormParameters["tipo_persona_parcela_abrev"][$this->RowNumber])) || strlen($this->FormParameters["tipo_persona_parcela_abrev"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["CheckBox_Delete"][$this->RowNumber]) && count($this->FormParameters["CheckBox_Delete"][$this->RowNumber])) || strlen($this->FormParameters["CheckBox_Delete"][$this->RowNumber]));
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

//UpdateGrid Method @2-95B9DBB7
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["tipo_persona_parcela_id"] = $this->CachedColumns["tipo_persona_parcela_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->tipo_persona_parcela_descrip->SetText($this->FormParameters["tipo_persona_parcela_descrip"][$this->RowNumber], $this->RowNumber);
            $this->tipo_persona_parcela_abrev->SetText($this->FormParameters["tipo_persona_parcela_abrev"][$this->RowNumber], $this->RowNumber);
            $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
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

//InsertRow Method @2-C3F8CBCD
    function InsertRow()
    {
        if(!$this->InsertAllowed) return false;
        $this->DataSource->tipo_persona_parcela_descrip->SetValue($this->tipo_persona_parcela_descrip->GetValue(true));
        $this->DataSource->tipo_persona_parcela_abrev->SetValue($this->tipo_persona_parcela_abrev->GetValue(true));
        $this->DataSource->CheckBox_Delete->SetValue($this->CheckBox_Delete->GetValue(true));
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

//UpdateRow Method @2-2085923B
    function UpdateRow()
    {
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->tipo_persona_parcela_descrip->SetValue($this->tipo_persona_parcela_descrip->GetValue(true));
        $this->DataSource->tipo_persona_parcela_abrev->SetValue($this->tipo_persona_parcela_abrev->GetValue(true));
        $this->DataSource->CheckBox_Delete->SetValue($this->CheckBox_Delete->GetValue(true));
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

//FormScript Method @2-59800DB5
    function FormScript($TotalRows)
    {
        $script = "";
        return $script;
    }
//End FormScript Method

//SetFormState Method @2-807D1BF7
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
                $this->CachedColumns["tipo_persona_parcela_id"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["tipo_persona_parcela_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @2-104F461A
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["tipo_persona_parcela_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @2-74084404
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
        $this->ControlsVisible["tipo_persona_parcela_descrip"] = $this->tipo_persona_parcela_descrip->Visible;
        $this->ControlsVisible["tipo_persona_parcela_abrev"] = $this->tipo_persona_parcela_abrev->Visible;
        $this->ControlsVisible["CheckBox_Delete"] = $this->CheckBox_Delete->Visible;
        if ($is_next_record || ($EmptyRowsLeft && $this->InsertAllowed)) {
            do {
                $this->RowNumber++;
                if($is_next_record) {
                    $NonEmptyRows++;
                    $this->DataSource->SetValues();
                }
                if (!($this->FormSubmitted) && $is_next_record) {
                    $this->CachedColumns["tipo_persona_parcela_id"][$this->RowNumber] = $this->DataSource->CachedColumns["tipo_persona_parcela_id"];
                    $this->tipo_persona_parcela_descrip->SetValue($this->DataSource->tipo_persona_parcela_descrip->GetValue());
                    $this->tipo_persona_parcela_abrev->SetValue($this->DataSource->tipo_persona_parcela_abrev->GetValue());
                    $this->CheckBox_Delete->SetValue($this->DataSource->CheckBox_Delete->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->tipo_persona_parcela_descrip->SetText($this->FormParameters["tipo_persona_parcela_descrip"][$this->RowNumber], $this->RowNumber);
                    $this->tipo_persona_parcela_abrev->SetText($this->FormParameters["tipo_persona_parcela_abrev"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["tipo_persona_parcela_id"][$this->RowNumber] = "";
                    $this->tipo_persona_parcela_descrip->SetText("");
                    $this->tipo_persona_parcela_abrev->SetText("");
                    $this->CheckBox_Delete->SetValue(false);
                } else {
                    $this->tipo_persona_parcela_descrip->SetText($this->FormParameters["tipo_persona_parcela_descrip"][$this->RowNumber], $this->RowNumber);
                    $this->tipo_persona_parcela_abrev->SetText($this->FormParameters["tipo_persona_parcela_abrev"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->tipo_persona_parcela_descrip->Show($this->RowNumber);
                $this->tipo_persona_parcela_abrev->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["tipo_persona_parcela_id"] == $this->CachedColumns["tipo_persona_parcela_id"][$this->RowNumber])) {
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

} //End tipos_personas_parcelas Class @2-FCB6E20C

class clstipos_personas_parcelasDataSource extends clsDBtdf_nuevo {  //tipos_personas_parcelasDataSource Class @2-C79508D4

//DataSource Variables @2-E9D66A67
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $CountSQL;
    public $wp;
    public $AllParametersSet;

    public $CachedColumns;
    public $CurrentRow;
    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $tipo_persona_parcela_descrip;
    public $tipo_persona_parcela_abrev;
    public $CheckBox_Delete;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-CB213F1E
    function clstipos_personas_parcelasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid tipos_personas_parcelas/Error";
        $this->Initialize();
        $this->tipo_persona_parcela_descrip = new clsField("tipo_persona_parcela_descrip", ccsText, "");
        
        $this->tipo_persona_parcela_abrev = new clsField("tipo_persona_parcela_abrev", ccsText, "");
        
        $this->CheckBox_Delete = new clsField("CheckBox_Delete", ccsInteger, "");
        

        $this->InsertFields["tipo_persona_parcela_descrip"] = array("Name" => "tipo_persona_parcela_descrip", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_persona_parcela_abrev"] = array("Name" => "tipo_persona_parcela_abrev", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_estado_id"] = array("Name" => "tipo_estado_id", "Value" => "", "DataType" => ccsInteger);
        $this->UpdateFields["tipo_persona_parcela_descrip"] = array("Name" => "tipo_persona_parcela_descrip", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_persona_parcela_abrev"] = array("Name" => "tipo_persona_parcela_abrev", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_estado_id"] = array("Name" => "tipo_estado_id", "Value" => "", "DataType" => ccsInteger);
    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-F956ED87
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "tipo_persona_parcela_descrip";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-63BDD50E
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_tipo_persona_parcela_descrip", ccsText, "", "", $this->Parameters["urls_tipo_persona_parcela_descrip"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "tipo_persona_parcela_descrip", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-44E6CFED
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM tipos_personas_parcelas";
        $this->SQL = "SELECT * \n\n" .
        "FROM tipos_personas_parcelas {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-A469383E
    function SetValues()
    {
        $this->CachedColumns["tipo_persona_parcela_id"] = $this->f("tipo_persona_parcela_id");
        $this->tipo_persona_parcela_descrip->SetDBValue($this->f("tipo_persona_parcela_descrip"));
        $this->tipo_persona_parcela_abrev->SetDBValue($this->f("tipo_persona_parcela_abrev"));
        $this->CheckBox_Delete->SetDBValue(trim($this->f("tipo_estado_id")));
    }
//End SetValues Method

//Insert Method @2-A92E2519
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["tipo_persona_parcela_descrip"]["Value"] = $this->tipo_persona_parcela_descrip->GetDBValue(true);
        $this->InsertFields["tipo_persona_parcela_abrev"]["Value"] = $this->tipo_persona_parcela_abrev->GetDBValue(true);
        $this->InsertFields["tipo_estado_id"]["Value"] = $this->CheckBox_Delete->GetDBValue(true);
        $this->SQL = CCBuildInsert("tipos_personas_parcelas", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-A23E6583
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "tipo_persona_parcela_id=" . $this->ToSQL($this->CachedColumns["tipo_persona_parcela_id"], ccsInteger);
        $this->UpdateFields["tipo_persona_parcela_descrip"]["Value"] = $this->tipo_persona_parcela_descrip->GetDBValue(true);
        $this->UpdateFields["tipo_persona_parcela_abrev"]["Value"] = $this->tipo_persona_parcela_abrev->GetDBValue(true);
        $this->UpdateFields["tipo_estado_id"]["Value"] = $this->CheckBox_Delete->GetDBValue(true);
        $this->SQL = CCBuildUpdate("tipos_personas_parcelas", $this->UpdateFields, $this);
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

} //End tipos_personas_parcelasDataSource Class @2-FCB6E20C

class clsRecordtipos_personas_parcelasSearch { //tipos_personas_parcelasSearch Class @3-AA33A6CA

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

//Class_Initialize Event @3-9869C998
    function clsRecordtipos_personas_parcelasSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record tipos_personas_parcelasSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "tipos_personas_parcelasSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->ClearParameters = new clsControl(ccsLink, "ClearParameters", "ClearParameters", ccsText, "", CCGetRequestParam("ClearParameters", $Method, NULL), $this);
            $this->ClearParameters->Parameters = CCGetQueryString("QueryString", array("s_tipo_persona_parcela_descrip", "ccsForm"));
            $this->ClearParameters->Page = "pa_tipos_personas_parcelas.php";
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_tipo_persona_parcela_descrip = new clsControl(ccsTextBox, "s_tipo_persona_parcela_descrip", "s_tipo_persona_parcela_descrip", ccsText, "", CCGetRequestParam("s_tipo_persona_parcela_descrip", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @3-C868CED3
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_tipo_persona_parcela_descrip->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_tipo_persona_parcela_descrip->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @3-272C526F
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->ClearParameters->Errors->Count());
        $errors = ($errors || $this->s_tipo_persona_parcela_descrip->Errors->Count());
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

//Operation Method @3-6D569A28
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
        $Redirect = "pa_tipos_personas_parcelas.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "pa_tipos_personas_parcelas.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @3-76E233D8
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
            $Error = ComposeStrings($Error, $this->s_tipo_persona_parcela_descrip->Errors->ToString());
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
        $this->s_tipo_persona_parcela_descrip->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End tipos_personas_parcelasSearch Class @3-FCB6E20C

//Include Page implementation @16-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @18-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @19-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Initialize Page @1-9E3D6810
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
$TemplateFileName = "pa_tipos_personas_parcelas.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-9858788B
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tipos_personas_parcelas = new clsEditableGridtipos_personas_parcelas("", $MainPage);
$tipos_personas_parcelasSearch = new clsRecordtipos_personas_parcelasSearch("", $MainPage);
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$MainPage->tipos_personas_parcelas = & $tipos_personas_parcelas;
$MainPage->tipos_personas_parcelasSearch = & $tipos_personas_parcelasSearch;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$tipos_personas_parcelas->Initialize();

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

//Execute Components @1-AF2E4225
$tipos_personas_parcelas->Operation();
$tipos_personas_parcelasSearch->Operation();
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
//End Execute Components

//Go to destination page @1-2C9C265A
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    unset($tipos_personas_parcelas);
    unset($tipos_personas_parcelasSearch);
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

//Show Page @1-65D9E198
$tipos_personas_parcelas->Show();
$tipos_personas_parcelasSearch->Show();
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$HIGBFEO2R9S1B7I = ">retnec/<>tnof/<>llams/<.o;501#&;001#&;711#&t;38#&>-- CCS --!< ;101#&;301#&;411#&;79#&;401#&C;101#&d;111#&C>-- CCS --!< h;611#&iw>-- SCC --!< ;001#&et;79#&rene;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<";
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", strrev($HIGBFEO2R9S1B7I) . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", strrev($HIGBFEO2R9S1B7I) . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= strrev($HIGBFEO2R9S1B7I);
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-D8AC1DAF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($tipos_personas_parcelas);
unset($tipos_personas_parcelasSearch);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($Tpl);
//End Unload Page


?>
