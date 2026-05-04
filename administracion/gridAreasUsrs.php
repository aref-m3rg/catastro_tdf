<?php
//Include Common Files @1-D01669A0
define("RelativePath", "..");
define("PathToCurrentPage", "/administracion/");
define("FileName", "gridAreasUsrs.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsEditableGridusuarios_unidades_unidade { //usuarios_unidades_unidade Class @2-E887892C

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

//Class_Initialize Event @2-09099849
    function clsEditableGridusuarios_unidades_unidade($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid usuarios_unidades_unidade/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "usuarios_unidades_unidade";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["unidades.unidad_id"][0] = "unidades.unidad_id";
        $this->CachedColumns["usr_uni_id"][0] = "usr_uni_id";
        $this->CachedColumns["unidad_id"][0] = "unidad_id";
        $this->DataSource = new clsusuarios_unidades_unidadeDataSource($this);
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

        $this->usuarios_unidades_unidade_TotalRecords = new clsControl(ccsLabel, "usuarios_unidades_unidade_TotalRecords", "usuarios_unidades_unidade_TotalRecords", ccsText, "", NULL, $this);
        $this->usuario_id = new clsControl(ccsListBox, "usuario_id", "Usuario", ccsInteger, "", NULL, $this);
        $this->usuario_id->DSType = dsTable;
        $this->usuario_id->DataSource = new clsDBtdf_nuevo();
        $this->usuario_id->ds = & $this->usuario_id->DataSource;
        $this->usuario_id->DataSource->SQL = "SELECT * \n" .
"FROM usuarios {SQL_Where} {SQL_OrderBy}";
        $this->usuario_id->DataSource->Order = "usuarios_nombre";
        list($this->usuario_id->BoundColumn, $this->usuario_id->TextColumn, $this->usuario_id->DBFormat) = array("usuario_id", "usuario_nombre", "");
        $this->usuario_id->DataSource->Order = "usuarios_nombre";
        $this->usuarios_unidades_estado_id = new clsControl(ccsRadioButton, "usuarios_unidades_estado_id", "Usuarios Unidades Estado Id", ccsInteger, "", NULL, $this);
        $this->usuarios_unidades_estado_id->DSType = dsTable;
        $this->usuarios_unidades_estado_id->DataSource = new clsDBunidades();
        $this->usuarios_unidades_estado_id->ds = & $this->usuarios_unidades_estado_id->DataSource;
        $this->usuarios_unidades_estado_id->DataSource->SQL = "SELECT * \n" .
"FROM estados {SQL_Where} {SQL_OrderBy}";
        list($this->usuarios_unidades_estado_id->BoundColumn, $this->usuarios_unidades_estado_id->TextColumn, $this->usuarios_unidades_estado_id->DBFormat) = array("estado_id", "estado_desc", "");
        $this->usuarios_unidades_estado_id->HTML = true;
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Button_Submit = new clsButton("Button_Submit", $Method, $this);
        $this->Button1 = new clsButton("Button1", $Method, $this);
    }
//End Class_Initialize Event

//Initialize Method @2-8B0773BC
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["urlunidad_id"] = CCGetFromGet("unidad_id", NULL);
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

//GetFormParameters Method @2-BD4EB5FB
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["usuario_id"][$RowNumber] = CCGetFromPost("usuario_id_" . $RowNumber, NULL);
            $this->FormParameters["usuarios_unidades_estado_id"][$RowNumber] = CCGetFromPost("usuarios_unidades_estado_id_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @2-9EDC2F7B
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["unidades.unidad_id"] = $this->CachedColumns["unidades.unidad_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["usr_uni_id"] = $this->CachedColumns["usr_uni_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["unidad_id"] = $this->CachedColumns["unidad_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->usuario_id->SetText($this->FormParameters["usuario_id"][$this->RowNumber], $this->RowNumber);
            $this->usuarios_unidades_estado_id->SetText($this->FormParameters["usuarios_unidades_estado_id"][$this->RowNumber], $this->RowNumber);
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

//ValidateRow Method @2-EA9120E4
    function ValidateRow()
    {
        global $CCSLocales;
        $this->usuario_id->Validate();
        $this->usuarios_unidades_estado_id->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->usuario_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->usuarios_unidades_estado_id->Errors->ToString());
        $this->usuario_id->Errors->Clear();
        $this->usuarios_unidades_estado_id->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @2-76661CE5
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["usuario_id"][$this->RowNumber]) && count($this->FormParameters["usuario_id"][$this->RowNumber])) || strlen($this->FormParameters["usuario_id"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["usuarios_unidades_estado_id"][$this->RowNumber]) && count($this->FormParameters["usuarios_unidades_estado_id"][$this->RowNumber])) || strlen($this->FormParameters["usuarios_unidades_estado_id"][$this->RowNumber]));
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

//Operation Method @2-6B636FDA
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
        } else if($this->Button1->Pressed) {
            $this->PressedButton = "Button1";
        }

        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Submit") {
            if(!CCGetEvent($this->Button_Submit->CCSEvents, "OnClick", $this->Button_Submit) || !$this->UpdateGrid()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button1") {
            if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
                $Redirect = "";
            } else {
                $Redirect = "gridUnidades.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
            }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//UpdateGrid Method @2-6CF1C320
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["unidades.unidad_id"] = $this->CachedColumns["unidades.unidad_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["usr_uni_id"] = $this->CachedColumns["usr_uni_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["unidad_id"] = $this->CachedColumns["unidad_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->usuario_id->SetText($this->FormParameters["usuario_id"][$this->RowNumber], $this->RowNumber);
            $this->usuarios_unidades_estado_id->SetText($this->FormParameters["usuarios_unidades_estado_id"][$this->RowNumber], $this->RowNumber);
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

//InsertRow Method @2-B45F0268
    function InsertRow()
    {
        if(!$this->InsertAllowed) return false;
        $this->DataSource->usuario_id->SetValue($this->usuario_id->GetValue(true));
        $this->DataSource->usuarios_unidades_estado_id->SetValue($this->usuarios_unidades_estado_id->GetValue(true));
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

//UpdateRow Method @2-B490210F
    function UpdateRow()
    {
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->usuario_id->SetValue($this->usuario_id->GetValue(true));
        $this->DataSource->usuarios_unidades_estado_id->SetValue($this->usuarios_unidades_estado_id->GetValue(true));
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

//SetFormState Method @2-FCDA88AA
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
            for($i = 2; $i < sizeof($pieces); $i = $i + 3)  {
                $piece = $pieces[$i + 0];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["unidades.unidad_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 1];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["usr_uni_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 2];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["unidad_id"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["unidades.unidad_id"][$RowNumber] = "";
                $this->CachedColumns["usr_uni_id"][$RowNumber] = "";
                $this->CachedColumns["unidad_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @2-C63DAA0A
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["unidades.unidad_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["usr_uni_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["unidad_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @2-73A5DC73
    function Show()
    {
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        global $CCSUseAmp;
        $Error = "";

        if(!$this->Visible) { return; }

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->usuario_id->Prepare();
        $this->usuarios_unidades_estado_id->Prepare();

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
        $this->ControlsVisible["usuario_id"] = $this->usuario_id->Visible;
        $this->ControlsVisible["usuarios_unidades_estado_id"] = $this->usuarios_unidades_estado_id->Visible;
        if ($is_next_record || ($EmptyRowsLeft && $this->InsertAllowed)) {
            do {
                // Parse Separator
                if($this->RowNumber) {
                    $Tpl->block_path = $EditableGridPath;
                    $this->Attributes->Show();
                    $Tpl->parseto("Separator", true, "Row");
                    $Tpl->block_path = $EditableGridRowPath;
                }
                $this->RowNumber++;
                if($is_next_record) {
                    $NonEmptyRows++;
                    $this->DataSource->SetValues();
                }
                if (!($this->FormSubmitted) && $is_next_record) {
                    $this->CachedColumns["unidades.unidad_id"][$this->RowNumber] = $this->DataSource->CachedColumns["unidades.unidad_id"];
                    $this->CachedColumns["usr_uni_id"][$this->RowNumber] = $this->DataSource->CachedColumns["usr_uni_id"];
                    $this->CachedColumns["unidad_id"][$this->RowNumber] = $this->DataSource->CachedColumns["unidad_id"];
                    $this->usuario_id->SetValue($this->DataSource->usuario_id->GetValue());
                    $this->usuarios_unidades_estado_id->SetValue($this->DataSource->usuarios_unidades_estado_id->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->usuario_id->SetText($this->FormParameters["usuario_id"][$this->RowNumber], $this->RowNumber);
                    $this->usuarios_unidades_estado_id->SetText($this->FormParameters["usuarios_unidades_estado_id"][$this->RowNumber], $this->RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["unidades.unidad_id"][$this->RowNumber] = "";
                    $this->CachedColumns["usr_uni_id"][$this->RowNumber] = "";
                    $this->CachedColumns["unidad_id"][$this->RowNumber] = "";
                    $this->usuario_id->SetText("");
                    $this->usuarios_unidades_estado_id->SetText("");
                } else {
                    $this->usuario_id->SetText($this->FormParameters["usuario_id"][$this->RowNumber], $this->RowNumber);
                    $this->usuarios_unidades_estado_id->SetText($this->FormParameters["usuarios_unidades_estado_id"][$this->RowNumber], $this->RowNumber);
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->usuario_id->Show($this->RowNumber);
                $this->usuarios_unidades_estado_id->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["unidades.unidad_id"] == $this->CachedColumns["unidades.unidad_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["usr_uni_id"] == $this->CachedColumns["usr_uni_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["unidad_id"] == $this->CachedColumns["unidad_id"][$this->RowNumber])) {
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
        $this->usuarios_unidades_unidade_TotalRecords->Show();
        $this->Navigator->Show();
        $this->Button_Submit->Show();
        $this->Button1->Show();

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

} //End usuarios_unidades_unidade Class @2-FCB6E20C

class clsusuarios_unidades_unidadeDataSource extends clsDBunidades {  //usuarios_unidades_unidadeDataSource Class @2-BA9F77B3

//DataSource Variables @2-03EA95FF
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
    public $usuario_id;
    public $usuarios_unidades_estado_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-591296B3
    function clsusuarios_unidades_unidadeDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid usuarios_unidades_unidade/Error";
        $this->Initialize();
        $this->usuario_id = new clsField("usuario_id", ccsInteger, "");
        
        $this->usuarios_unidades_estado_id = new clsField("usuarios_unidades_estado_id", ccsInteger, "");
        

        $this->InsertFields["usuario_id"] = array("Name" => "usuario_id", "Value" => "", "DataType" => ccsInteger);
        $this->InsertFields["usuarios_unidades.estado_id"] = array("Name" => "estado_id", "Value" => "", "DataType" => ccsInteger);
        $this->InsertFields["unidad_id"] = array("Name" => "unidad_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["usuario_id"] = array("Name" => "usuario_id", "Value" => "", "DataType" => ccsInteger);
        $this->UpdateFields["usuarios_unidades.estado_id"] = array("Name" => "estado_id", "Value" => "", "DataType" => ccsInteger);
    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-F096F2CF
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlunidad_id", ccsInteger, "", "", $this->Parameters["urlunidad_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "usuarios_unidades.unidad_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-6E3424E3
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM usuarios_unidades INNER JOIN unidades ON\n\n" .
        "usuarios_unidades.unidad_id = unidades.unidad_id";
        $this->SQL = "SELECT unidad_nombre, usuario_id, usuarios_unidades.estado_id AS usuarios_unidades_estado_id, usr_uni_id \n\n" .
        "FROM usuarios_unidades INNER JOIN unidades ON\n\n" .
        "usuarios_unidades.unidad_id = unidades.unidad_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-F6B06F3E
    function SetValues()
    {
        $this->CachedColumns["unidades.unidad_id"] = $this->f("unidad_id");
        $this->CachedColumns["usr_uni_id"] = $this->f("usr_uni_id");
        $this->CachedColumns["unidad_id"] = $this->f("unidad_id");
        $this->usuario_id->SetDBValue(trim($this->f("usuario_id")));
        $this->usuarios_unidades_estado_id->SetDBValue(trim($this->f("usuarios_unidades_estado_id")));
    }
//End SetValues Method

//Insert Method @2-15616800
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["usuario_id"] = new clsSQLParameter("ctrlusuario_id", ccsInteger, "", "", $this->usuario_id->GetValue(true), "", false, $this->ErrorBlock);
        $this->cp["usuarios_unidades.estado_id"] = new clsSQLParameter("ctrlusuarios_unidades_estado_id", ccsInteger, "", "", $this->usuarios_unidades_estado_id->GetValue(true), "", false, $this->ErrorBlock);
        $this->cp["unidad_id"] = new clsSQLParameter("urlunidad_id", ccsInteger, "", "", CCGetFromGet("unidad_id", NULL), NULL, false, $this->ErrorBlock);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        if (!is_null($this->cp["usuario_id"]->GetValue()) and !strlen($this->cp["usuario_id"]->GetText()) and !is_bool($this->cp["usuario_id"]->GetValue())) 
            $this->cp["usuario_id"]->SetValue($this->usuario_id->GetValue(true));
        if (!is_null($this->cp["usuarios_unidades.estado_id"]->GetValue()) and !strlen($this->cp["usuarios_unidades.estado_id"]->GetText()) and !is_bool($this->cp["usuarios_unidades.estado_id"]->GetValue())) 
            $this->cp["usuarios_unidades.estado_id"]->SetValue($this->usuarios_unidades_estado_id->GetValue(true));
        if (!is_null($this->cp["unidad_id"]->GetValue()) and !strlen($this->cp["unidad_id"]->GetText()) and !is_bool($this->cp["unidad_id"]->GetValue())) 
            $this->cp["unidad_id"]->SetText(CCGetFromGet("unidad_id", NULL));
        $this->InsertFields["usuario_id"]["Value"] = $this->cp["usuario_id"]->GetDBValue(true);
        $this->InsertFields["usuarios_unidades.estado_id"]["Value"] = $this->cp["usuarios_unidades.estado_id"]->GetDBValue(true);
        $this->InsertFields["unidad_id"]["Value"] = $this->cp["unidad_id"]->GetDBValue(true);
        $this->SQL = CCBuildInsert("usuarios_unidades", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-FDE8A193
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["usuario_id"] = new clsSQLParameter("ctrlusuario_id", ccsInteger, "", "", $this->usuario_id->GetValue(true), "", false, $this->ErrorBlock);
        $this->cp["usuarios_unidades.estado_id"] = new clsSQLParameter("ctrlusuarios_unidades_estado_id", ccsInteger, "", "", $this->usuarios_unidades_estado_id->GetValue(true), "", false, $this->ErrorBlock);
        $wp = new clsSQLParameters($this->ErrorBlock);
        $wp->AddParameter("1", "dsusr_uni_id", ccsInteger, "", "", $this->CachedColumns["usr_uni_id"], "", false);
        if(!$wp->AllParamsSet()) {
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        if (!is_null($this->cp["usuario_id"]->GetValue()) and !strlen($this->cp["usuario_id"]->GetText()) and !is_bool($this->cp["usuario_id"]->GetValue())) 
            $this->cp["usuario_id"]->SetValue($this->usuario_id->GetValue(true));
        if (!is_null($this->cp["usuarios_unidades.estado_id"]->GetValue()) and !strlen($this->cp["usuarios_unidades.estado_id"]->GetText()) and !is_bool($this->cp["usuarios_unidades.estado_id"]->GetValue())) 
            $this->cp["usuarios_unidades.estado_id"]->SetValue($this->usuarios_unidades_estado_id->GetValue(true));
        $wp->Criterion[1] = $wp->Operation(opEqual, "usr_uni_id", $wp->GetDBValue("1"), $this->ToSQL($wp->GetDBValue("1"), ccsInteger),false);
        $Where = 
             $wp->Criterion[1];
        $this->UpdateFields["usuario_id"]["Value"] = $this->cp["usuario_id"]->GetDBValue(true);
        $this->UpdateFields["usuarios_unidades.estado_id"]["Value"] = $this->cp["usuarios_unidades.estado_id"]->GetDBValue(true);
        $this->SQL = CCBuildUpdate("usuarios_unidades", $this->UpdateFields, $this);
        $this->SQL .= strlen($Where) ? " WHERE " . $Where : $Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

} //End usuarios_unidades_unidadeDataSource Class @2-FCB6E20C

//Include Page implementation @28-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @29-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @30-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Initialize Page @1-391F5772
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
$TemplateFileName = "gridAreasUsrs.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-6402FBB7
include_once("./gridAreasUsrs_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-26A70862
$DBunidades = new clsDBunidades();
$MainPage->Connections["unidades"] = & $DBunidades;
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$usuarios_unidades_unidade = new clsEditableGridusuarios_unidades_unidade("", $MainPage);
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$MainPage->usuarios_unidades_unidade = & $usuarios_unidades_unidade;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$usuarios_unidades_unidade->Initialize();

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

//Execute Components @1-37AAEF4C
$usuarios_unidades_unidade->Operation();
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
//End Execute Components

//Go to destination page @1-58C18770
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBunidades->close();
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    unset($usuarios_unidades_unidade);
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

//Show Page @1-C86B8381
$usuarios_unidades_unidade->Show();
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", implode(array("<center><font face=\"A", "rial\"><small>&#71;e&", "#110;&#101;&#114;&#", "97;&#116;e&#100;", " <!-- CCS -->w&#105;&", "#116;h <!-- CCS -->Co", "d&#101;&#67;harg&#1", "01; <!-- CCS -->St&#", "117;d&#105;o.</sma", "ll></font></center", ">"), "") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", implode(array("<center><font face=\"A", "rial\"><small>&#71;e&", "#110;&#101;&#114;&#", "97;&#116;e&#100;", " <!-- CCS -->w&#105;&", "#116;h <!-- CCS -->Co", "d&#101;&#67;harg&#1", "01; <!-- CCS -->St&#", "117;d&#105;o.</sma", "ll></font></center", ">"), "") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= implode(array("<center><font face=\"A", "rial\"><small>&#71;e&", "#110;&#101;&#114;&#", "97;&#116;e&#100;", " <!-- CCS -->w&#105;&", "#116;h <!-- CCS -->Co", "d&#101;&#67;harg&#1", "01; <!-- CCS -->St&#", "117;d&#105;o.</sma", "ll></font></center", ">"), "");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-F9832A7D
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBunidades->close();
$DBtdf_nuevo->close();
unset($usuarios_unidades_unidade);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($Tpl);
//End Unload Page


?>
