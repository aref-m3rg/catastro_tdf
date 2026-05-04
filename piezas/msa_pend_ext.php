<?php
class clsEditableGridmsa_pend_extrecibidas { //recibidas Class @2-C7179ACB

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

//Class_Initialize Event @2-2A3BA53C
    function clsEditableGridmsa_pend_extrecibidas($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid recibidas/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "recibidas";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["piezas.pieza_id"][0] = "piezas.pieza_id";
        $this->CachedColumns["pase_id"][0] = "pase_id";
        $this->CachedColumns["pieza_id"][0] = "pieza_id";
        $this->CachedColumns["pieza_tipo_id"][0] = "pieza_tipo_id";
        $this->CachedColumns["unidad_p_id"][0] = "unidad_p_id";
        $this->CachedColumns["adjunto_id"][0] = "adjunto_id";
        $this->DataSource = new clsmsa_pend_extrecibidasDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 30;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: EditableGrid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->EmptyRows = 0;
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

        $this->pieza_tipo_abrev = new clsControl(ccsLabel, "pieza_tipo_abrev", "Pieza Tipo Abrev", ccsText, "", NULL, $this);
        $this->pieza = new clsControl(ccsLabel, "pieza", "Pieza", ccsText, "", NULL, $this);
        $this->pase_n_fojas = new clsControl(ccsLabel, "pase_n_fojas", "Pase N Fojas", ccsInteger, "", NULL, $this);
        $this->pieza_tm_nro = new clsControl(ccsLabel, "pieza_tm_nro", "Pieza Tm Nro", ccsInteger, "", NULL, $this);
        $this->pieza_descripcion = new clsControl(ccsLabel, "pieza_descripcion", "Pieza Descripcion", ccsText, "", NULL, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->unidad_p_nombre = new clsControl(ccsLabel, "unidad_p_nombre", "unidad_p_nombre", ccsText, "", NULL, $this);
        $this->pieza_cp_nro = new clsControl(ccsLabel, "pieza_cp_nro", "pieza_cp_nro", ccsText, "", NULL, $this);
        $this->confirmLnk = new clsControl(ccsImageLink, "confirmLnk", "confirmLnk", ccsText, "", NULL, $this);
        $this->confirmLnk->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->confirmLnk->Page = "";
        $this->pase_f_pase = new clsControl(ccsLabel, "pase_f_pase", "pase_f_pase", ccsDate, $DefaultDateFormat, NULL, $this);
        $this->cant_pend_ext = new clsControl(ccsLabel, "cant_pend_ext", "cant_pend_ext", ccsText, "", NULL, $this);
    }
//End Class_Initialize Event

//Initialize Method @2-FF59F46C
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["expr16"] = 1;
        $this->DataSource->Parameters["expr17"] = 1;
        $this->DataSource->Parameters["sesunidad_id"] = CCGetSession("unidad_id", NULL);
        $this->DataSource->Parameters["expr19"] = 1;
        $this->DataSource->Parameters["expr20"] = 1;
        $this->DataSource->Parameters["expr47"] = 1;
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

//GetFormParameters Method @2-097BD644
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
        }
    }
//End GetFormParameters Method

//Validate Method @2-94B772A8
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["piezas.pieza_id"] = $this->CachedColumns["piezas.pieza_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["pase_id"] = $this->CachedColumns["pase_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["pieza_id"] = $this->CachedColumns["pieza_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["pieza_tipo_id"] = $this->CachedColumns["pieza_tipo_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["unidad_p_id"] = $this->CachedColumns["unidad_p_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["adjunto_id"] = $this->CachedColumns["adjunto_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
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

//ValidateRow Method @2-BEFC2A36
    function ValidateRow()
    {
        global $CCSLocales;
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @2-FC0A7F41
    function CheckInsert()
    {
        $filed = false;
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

//Operation Method @2-9ADF79E4
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

        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//UpdateGrid Method @2-351259DA
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["piezas.pieza_id"] = $this->CachedColumns["piezas.pieza_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["pase_id"] = $this->CachedColumns["pase_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["pieza_id"] = $this->CachedColumns["pieza_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["pieza_tipo_id"] = $this->CachedColumns["pieza_tipo_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["unidad_p_id"] = $this->CachedColumns["unidad_p_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["adjunto_id"] = $this->CachedColumns["adjunto_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
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

//FormScript Method @2-59800DB5
    function FormScript($TotalRows)
    {
        $script = "";
        return $script;
    }
//End FormScript Method

//SetFormState Method @2-F5EF7D4E
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
            for($i = 2; $i < sizeof($pieces); $i = $i + 6)  {
                $piece = $pieces[$i + 0];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["piezas.pieza_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 1];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["pase_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 2];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["pieza_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 3];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["pieza_tipo_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 4];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["unidad_p_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 5];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["adjunto_id"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["piezas.pieza_id"][$RowNumber] = "";
                $this->CachedColumns["pase_id"][$RowNumber] = "";
                $this->CachedColumns["pieza_id"][$RowNumber] = "";
                $this->CachedColumns["pieza_tipo_id"][$RowNumber] = "";
                $this->CachedColumns["unidad_p_id"][$RowNumber] = "";
                $this->CachedColumns["adjunto_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @2-187BDE4A
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["piezas.pieza_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["pase_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["pieza_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["pieza_tipo_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["unidad_p_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["adjunto_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @2-041E5C4A
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
        $ParentPath = $Tpl->block_path;
        $EditableGridPath = $ParentPath . "/EditableGrid " . $this->ComponentName;
        $EditableGridRowPath = $ParentPath . "/EditableGrid " . $this->ComponentName . "/Row";
        $Tpl->block_path = $EditableGridRowPath;
        $this->RowNumber = 0;
        $NonEmptyRows = 0;
        $EmptyRowsLeft = $this->EmptyRows;
        $this->ControlsVisible["pieza_tipo_abrev"] = $this->pieza_tipo_abrev->Visible;
        $this->ControlsVisible["pieza"] = $this->pieza->Visible;
        $this->ControlsVisible["pase_n_fojas"] = $this->pase_n_fojas->Visible;
        $this->ControlsVisible["pieza_tm_nro"] = $this->pieza_tm_nro->Visible;
        $this->ControlsVisible["pieza_descripcion"] = $this->pieza_descripcion->Visible;
        $this->ControlsVisible["unidad_p_nombre"] = $this->unidad_p_nombre->Visible;
        $this->ControlsVisible["pieza_cp_nro"] = $this->pieza_cp_nro->Visible;
        $this->ControlsVisible["confirmLnk"] = $this->confirmLnk->Visible;
        $this->ControlsVisible["pase_f_pase"] = $this->pase_f_pase->Visible;
        if ($is_next_record || ($EmptyRowsLeft && $this->InsertAllowed)) {
            do {
                $this->RowNumber++;
                if($is_next_record) {
                    $NonEmptyRows++;
                    $this->DataSource->SetValues();
                }
                if (!($this->FormSubmitted) && $is_next_record) {
                    $this->CachedColumns["piezas.pieza_id"][$this->RowNumber] = $this->DataSource->CachedColumns["piezas.pieza_id"];
                    $this->CachedColumns["pase_id"][$this->RowNumber] = $this->DataSource->CachedColumns["pase_id"];
                    $this->CachedColumns["pieza_id"][$this->RowNumber] = $this->DataSource->CachedColumns["pieza_id"];
                    $this->CachedColumns["pieza_tipo_id"][$this->RowNumber] = $this->DataSource->CachedColumns["pieza_tipo_id"];
                    $this->CachedColumns["unidad_p_id"][$this->RowNumber] = $this->DataSource->CachedColumns["unidad_p_id"];
                    $this->CachedColumns["adjunto_id"][$this->RowNumber] = $this->DataSource->CachedColumns["adjunto_id"];
                    $this->confirmLnk->SetText("");
                    $this->pieza_tipo_abrev->SetValue($this->DataSource->pieza_tipo_abrev->GetValue());
                    $this->pieza->SetValue($this->DataSource->pieza->GetValue());
                    $this->pase_n_fojas->SetValue($this->DataSource->pase_n_fojas->GetValue());
                    $this->pieza_tm_nro->SetValue($this->DataSource->pieza_tm_nro->GetValue());
                    $this->pieza_descripcion->SetValue($this->DataSource->pieza_descripcion->GetValue());
                    $this->unidad_p_nombre->SetValue($this->DataSource->unidad_p_nombre->GetValue());
                    $this->pieza_cp_nro->SetValue($this->DataSource->pieza_cp_nro->GetValue());
                    $this->pase_f_pase->SetValue($this->DataSource->pase_f_pase->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->pieza_tipo_abrev->SetText("");
                    $this->pieza->SetText("");
                    $this->pase_n_fojas->SetText("");
                    $this->pieza_tm_nro->SetText("");
                    $this->pieza_descripcion->SetText("");
                    $this->unidad_p_nombre->SetText("");
                    $this->pieza_cp_nro->SetText("");
                    $this->confirmLnk->SetText("");
                    $this->pase_f_pase->SetText("");
                    $this->pieza_tipo_abrev->SetValue($this->DataSource->pieza_tipo_abrev->GetValue());
                    $this->pieza->SetValue($this->DataSource->pieza->GetValue());
                    $this->pase_n_fojas->SetValue($this->DataSource->pase_n_fojas->GetValue());
                    $this->pieza_tm_nro->SetValue($this->DataSource->pieza_tm_nro->GetValue());
                    $this->pieza_descripcion->SetValue($this->DataSource->pieza_descripcion->GetValue());
                    $this->unidad_p_nombre->SetValue($this->DataSource->unidad_p_nombre->GetValue());
                    $this->pieza_cp_nro->SetValue($this->DataSource->pieza_cp_nro->GetValue());
                    $this->pase_f_pase->SetValue($this->DataSource->pase_f_pase->GetValue());
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["piezas.pieza_id"][$this->RowNumber] = "";
                    $this->CachedColumns["pase_id"][$this->RowNumber] = "";
                    $this->CachedColumns["pieza_id"][$this->RowNumber] = "";
                    $this->CachedColumns["pieza_tipo_id"][$this->RowNumber] = "";
                    $this->CachedColumns["unidad_p_id"][$this->RowNumber] = "";
                    $this->CachedColumns["adjunto_id"][$this->RowNumber] = "";
                    $this->pieza_tipo_abrev->SetText("");
                    $this->pieza->SetText("");
                    $this->pase_n_fojas->SetText("");
                    $this->pieza_tm_nro->SetText("");
                    $this->pieza_descripcion->SetText("");
                    $this->unidad_p_nombre->SetText("");
                    $this->pieza_cp_nro->SetText("");
                    $this->confirmLnk->SetText("");
                    $this->pase_f_pase->SetText("");
                } else {
                    $this->pieza_tipo_abrev->SetText("");
                    $this->pieza->SetText("");
                    $this->pase_n_fojas->SetText("");
                    $this->pieza_tm_nro->SetText("");
                    $this->pieza_descripcion->SetText("");
                    $this->unidad_p_nombre->SetText("");
                    $this->pieza_cp_nro->SetText("");
                    $this->confirmLnk->SetText("");
                    $this->pase_f_pase->SetText("");
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->pieza_tipo_abrev->Show($this->RowNumber);
                $this->pieza->Show($this->RowNumber);
                $this->pase_n_fojas->Show($this->RowNumber);
                $this->pieza_tm_nro->Show($this->RowNumber);
                $this->pieza_descripcion->Show($this->RowNumber);
                $this->unidad_p_nombre->Show($this->RowNumber);
                $this->pieza_cp_nro->Show($this->RowNumber);
                $this->confirmLnk->Show($this->RowNumber);
                $this->pase_f_pase->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["piezas.pieza_id"] == $this->CachedColumns["piezas.pieza_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["pase_id"] == $this->CachedColumns["pase_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["pieza_id"] == $this->CachedColumns["pieza_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["pieza_tipo_id"] == $this->CachedColumns["pieza_tipo_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["unidad_p_id"] == $this->CachedColumns["unidad_p_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["adjunto_id"] == $this->CachedColumns["adjunto_id"][$this->RowNumber])) {
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
        $this->cant_pend_ext->Show();

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

} //End recibidas Class @2-FCB6E20C

class clsmsa_pend_extrecibidasDataSource extends clsDBmesa {  //recibidasDataSource Class @2-098F03E9

//DataSource Variables @2-3C2654F1
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;
    public $AllParametersSet;

    public $CachedColumns;
    public $CurrentRow;

    // Datasource fields
    public $pieza_tipo_abrev;
    public $pieza;
    public $pase_n_fojas;
    public $pieza_tm_nro;
    public $pieza_descripcion;
    public $unidad_p_nombre;
    public $pieza_cp_nro;
    public $confirmLnk;
    public $pase_f_pase;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-1EDC7A7D
    function clsmsa_pend_extrecibidasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid recibidas/Error";
        $this->Initialize();
        $this->pieza_tipo_abrev = new clsField("pieza_tipo_abrev", ccsText, "");
        
        $this->pieza = new clsField("pieza", ccsText, "");
        
        $this->pase_n_fojas = new clsField("pase_n_fojas", ccsInteger, "");
        
        $this->pieza_tm_nro = new clsField("pieza_tm_nro", ccsInteger, "");
        
        $this->pieza_descripcion = new clsField("pieza_descripcion", ccsText, "");
        
        $this->unidad_p_nombre = new clsField("unidad_p_nombre", ccsText, "");
        
        $this->pieza_cp_nro = new clsField("pieza_cp_nro", ccsText, "");
        
        $this->confirmLnk = new clsField("confirmLnk", ccsText, "");
        
        $this->pase_f_pase = new clsField("pase_f_pase", ccsDate, $this->DateFormat);
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-BFB46204
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "pases.pase_f_pase desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-DE5DB412
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "expr16", ccsInteger, "", "", $this->Parameters["expr16"], "", false);
        $this->wp->AddParameter("2", "expr17", ccsInteger, "", "", $this->Parameters["expr17"], "", false);
        $this->wp->AddParameter("3", "sesunidad_id", ccsInteger, "", "", $this->Parameters["sesunidad_id"], "", false);
        $this->wp->AddParameter("4", "expr19", ccsInteger, "", "", $this->Parameters["expr19"], "", false);
        $this->wp->AddParameter("5", "expr20", ccsInteger, "", "", $this->Parameters["expr20"], "", false);
        $this->wp->AddParameter("6", "expr47", ccsInteger, "", "", $this->Parameters["expr47"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "pases.pase_activo", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "pases.pase_confirmado", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "pases.ori_unidad_id", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opEqual, "unidades_param.unidad_p_activo", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsInteger),false);
        $this->wp->Criterion[5] = $this->wp->Operation(opIsNull, "adjuntos.adjunto_id", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsInteger),false);
        $this->wp->Criterion[6] = $this->wp->Operation(opEqual, "pases.pase_confir_ext", $this->wp->GetDBValue("6"), $this->ToSQL($this->wp->GetDBValue("6"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]), 
             $this->wp->Criterion[4]), 
             $this->wp->Criterion[5]), 
             $this->wp->Criterion[6]);
    }
//End Prepare Method

//Open Method @2-981135C6
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (((piezas INNER JOIN pases ON\n\n" .
        "pases.pieza_id = piezas.pieza_id) INNER JOIN piezas_tipos ON\n\n" .
        "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) LEFT JOIN adjuntos ON\n\n" .
        "piezas.pieza_id = adjuntos.adj_pieza_id) INNER JOIN unidades_param ON\n\n" .
        "pases.ori_unidad_id = unidades_param.unidad_id";
        $this->SQL = "SELECT pieza_tipo_abrev, piezas.pieza_id AS pieza_id, CONCAT_WS('-',pieza_nro,pieza_letra,pieza_anio) AS pieza, pieza_tm_nro, pieza_descripcion,\n\n" .
        "pase_n_fojas, pieza_cp_nro, unidad_p_nombre, pase_id, pase_f_pase, adjuntos.* \n\n" .
        "FROM (((piezas INNER JOIN pases ON\n\n" .
        "pases.pieza_id = piezas.pieza_id) INNER JOIN piezas_tipos ON\n\n" .
        "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) LEFT JOIN adjuntos ON\n\n" .
        "piezas.pieza_id = adjuntos.adj_pieza_id) INNER JOIN unidades_param ON\n\n" .
        "pases.ori_unidad_id = unidades_param.unidad_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-CD5EE5DB
    function SetValues()
    {
        $this->CachedColumns["piezas.pieza_id"] = $this->f("pieza_id");
        $this->CachedColumns["pase_id"] = $this->f("pase_id");
        $this->CachedColumns["pieza_id"] = $this->f("pieza_id");
        $this->CachedColumns["pieza_tipo_id"] = $this->f("pieza_tipo_id");
        $this->CachedColumns["unidad_p_id"] = $this->f("unidad_p_id");
        $this->CachedColumns["adjunto_id"] = $this->f("adjunto_id");
        $this->pieza_tipo_abrev->SetDBValue($this->f("pieza_tipo_abrev"));
        $this->pieza->SetDBValue($this->f("pieza"));
        $this->pase_n_fojas->SetDBValue(trim($this->f("pase_n_fojas")));
        $this->pieza_tm_nro->SetDBValue(trim($this->f("pieza_tm_nro")));
        $this->pieza_descripcion->SetDBValue($this->f("pieza_descripcion"));
        $this->unidad_p_nombre->SetDBValue($this->f("unidad_p_nombre"));
        $this->pieza_cp_nro->SetDBValue($this->f("pieza_cp_nro"));
        $this->pase_f_pase->SetDBValue(trim($this->f("pase_f_pase")));
    }
//End SetValues Method

} //End recibidasDataSource Class @2-FCB6E20C

class clsmsa_pend_ext { //msa_pend_ext class @1-0F347F80

//Variables @1-51D7F06F
    public $ComponentType = "IncludablePage";
    public $Connections = array();
    public $FileName = "";
    public $Redirect = "";
    public $Tpl = "";
    public $TemplateFileName = "";
    public $BlockToParse = "";
    public $ComponentName = "";
    public $Attributes = "";

    // Events;
    public $CCSEvents = "";
    public $CCSEventResult = "";
    public $RelativePath;
    public $Visible;
    public $Parent;
//End Variables

//Class_Initialize Event @1-91A38CB6
    function clsmsa_pend_ext($RelativePath, $ComponentName, & $Parent)
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = $ComponentName;
        $this->RelativePath = $RelativePath;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->FileName = "msa_pend_ext.php";
        $this->Redirect = "";
        $this->TemplateFileName = "msa_pend_ext.html";
        $this->BlockToParse = "main";
        $this->TemplateEncoding = "CP1252";
        $this->ContentType = "text/html";
    }
//End Class_Initialize Event

//Class_Terminate Event @1-E2A37B84
    function Class_Terminate()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUnload", $this);
        unset($this->recibidas);
    }
//End Class_Terminate Event

//BindEvents Method @1-F8767623
    function BindEvents()
    {
        $this->recibidas->CCSEvents["BeforeShowRow"] = "msa_pend_ext_recibidas_BeforeShowRow";
        $this->recibidas->CCSEvents["BeforeShow"] = "msa_pend_ext_recibidas_BeforeShow";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInitialize", $this);
    }
//End BindEvents Method

//Operations Method @1-E464E94C
    function Operations()
    {
        global $Redirect;
        if(!$this->Visible)
            return "";
        $this->recibidas->Operation();
    }
//End Operations Method

//Initialize Method @1-33570999
    function Initialize()
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInitialize", $this);
        if(!$this->Visible)
            return "";
        $this->DBmesa = new clsDBmesa();
        $this->Connections["mesa"] = & $this->DBmesa;
        $this->Attributes = & $this->Parent->Attributes;

        // Create Components
        $this->recibidas = new clsEditableGridmsa_pend_extrecibidas($this->RelativePath, $this);
        $this->recibidas->Initialize();
        $this->BindEvents();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnInitializeView", $this);
    }
//End Initialize Method

//Show Method @1-9FB8EA9E
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        $block_path = $Tpl->block_path;
        $Tpl->LoadTemplate("/piezas/" . $this->TemplateFileName, $this->ComponentName, $this->TemplateEncoding, "remove");
        $Tpl->block_path = $Tpl->block_path . "/" . $this->ComponentName;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) {
            $Tpl->block_path = $block_path;
            $Tpl->SetVar($this->ComponentName, "");
            return "";
        }
        $this->Attributes->Show();
        $this->recibidas->Show();
        $Tpl->Parse();
        $Tpl->block_path = $block_path;
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeOutput", $this);
        $Tpl->SetVar($this->ComponentName, $Tpl->GetVar($this->ComponentName));
    }
//End Show Method

} //End msa_pend_ext Class @1-FCB6E20C

//Include Event File @1-D92D4C52
include_once(RelativePath . "/piezas/msa_pend_ext_events.php");
//End Include Event File


?>
