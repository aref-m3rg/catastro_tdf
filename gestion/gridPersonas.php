<?php
//Include Common Files @1-699E70C4
define("RelativePath", "..");
define("PathToCurrentPage", "/gestion/");
define("FileName", "gridPersonas.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
include_once(RelativePath . "/Services.php");
//End Include Common Files

class clsEditableGridpersonas_personas_parcela { //personas_personas_parcela Class @115-F70C6A90

//Variables @115-F9538F3C

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

//Class_Initialize Event @115-35CC3422
    function clsEditableGridpersonas_personas_parcela($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid personas_personas_parcela/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "personas_personas_parcela";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["personas.persona_id"][0] = "personas.persona_id";
        $this->CachedColumns["persona_id"][0] = "persona_id";
        $this->CachedColumns["persona_parcela_id"][0] = "persona_parcela_id";
        $this->CachedColumns["tipo_documento_id"][0] = "tipo_documento_id";
        $this->CachedColumns["tipo_persona_id"][0] = "tipo_persona_id";
        $this->CachedColumns["tipo_persona_parcela_id"][0] = "tipo_persona_parcela_id";
        $this->CachedColumns["tipo_estado_id"][0] = "tipo_estado_id";
        $this->CachedColumns["tipo_perso_jur_id"][0] = "tipo_perso_jur_id";
        $this->CachedColumns["tipo_instrumento_id"][0] = "tipo_instrumento_id";
        $this->DataSource = new clspersonas_personas_parcelaDataSource($this);
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

        $this->EmptyRows = 0;
        $this->ReadAllowed = true;
        $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
        if(!$this->Visible) return;

        $this->ReadAllowed = $this->ReadAllowed && CCUserInGroups(CCGetGroupID(), "1;2");
        $this->UpdateAllowed = CCUserInGroups(CCGetGroupID(), "2");
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

        $this->persona_cuit = new clsControl(ccsLabel, "persona_cuit", "Persona Cuit", ccsText, "", NULL, $this);
        $this->persona_denominacion = new clsControl(ccsLabel, "persona_denominacion", "Persona Denominacion", ccsText, "", NULL, $this);
        $this->personas_parcelas_tipo_estado_id = new clsControl(ccsHidden, "personas_parcelas_tipo_estado_id", "Estado", ccsText, "", NULL, $this);
        $this->personas_parcelas_tipo_estado_id->Required = true;
        $this->tipo_persona_descrip = new clsControl(ccsLabel, "tipo_persona_descrip", "Tipo Persona Descrip", ccsText, "", NULL, $this);
        $this->tipo_persona_parcela_descrip = new clsControl(ccsLabel, "tipo_persona_parcela_descrip", "Tipo Persona Parcela Descrip", ccsText, "", NULL, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->tipo_documento_abrev = new clsControl(ccsLabel, "tipo_documento_abrev", "Tipo Documento Descrip", ccsText, "", NULL, $this);
        $this->persona_nro_doc = new clsControl(ccsLabel, "persona_nro_doc", "Persona Nro Doc", ccsInteger, "", NULL, $this);
        $this->Button_Submit = new clsButton("Button_Submit", $Method, $this);
        $this->persona_parcela_id = new clsControl(ccsHidden, "persona_parcela_id", "persona_parcela_id", ccsInteger, "", NULL, $this);
        $this->Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", NULL, $this);
        $this->Label1->HTML = true;
        $this->panel_add = new clsPanel("panel_add", $this);
        $this->ImageLink3 = new clsControl(ccsImageLink, "ImageLink3", "ImageLink3", ccsText, "", NULL, $this);
        $this->ImageLink3->Page = "";
        $this->ppal = new clsControl(ccsCheckBox, "ppal", "ppal", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), NULL, $this);
        $this->ppal->CheckedValue = true;
        $this->ppal->UncheckedValue = false;
        $this->ImageLink1 = new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", NULL, $this);
        $this->ImageLink1->Page = "";
        $this->ImageLink2 = new clsControl(ccsImageLink, "ImageLink2", "ImageLink2", ccsText, "", NULL, $this);
        $this->ImageLink2->Page = "";
        $this->persona_parcela_dominio = new clsControl(ccsLabel, "persona_parcela_dominio", "persona_parcela_dominio", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), NULL, $this);
        $this->este = new clsControl(ccsImageLink, "este", "este", ccsText, "", NULL, $this);
        $this->este->Page = "";
        $this->tipo_perso_jur_abrev = new clsControl(ccsLabel, "tipo_perso_jur_abrev", "tipo_perso_jur_abrev", ccsText, "", NULL, $this);
        $this->total_dom = new clsControl(ccsLabel, "total_dom", "total_dom", ccsText, "", NULL, $this);
        $this->total_dom->HTML = true;
        $this->tipo_estado_descrip = new clsControl(ccsLabel, "tipo_estado_descrip", "tipo_estado_descrip", ccsText, "", NULL, $this);
        $this->tipo_estado_descrip->HTML = true;
        $this->instrumento = new clsControl(ccsLabel, "instrumento", "instrumento", ccsText, "", NULL, $this);
        $this->panel_add->AddComponent("ImageLink3", $this->ImageLink3);
    }
//End Class_Initialize Event

//Initialize Method @115-99529F7C
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["urlparcela_id"] = CCGetFromGet("parcela_id", NULL);
    }
//End Initialize Method

//SetPrimaryKeys Method @115-EBC3F86C
    function SetPrimaryKeys($PrimaryKeys) {
        $this->PrimaryKeys = $PrimaryKeys;
        return $this->PrimaryKeys;
    }
//End SetPrimaryKeys Method

//GetPrimaryKeys Method @115-74F9A772
    function GetPrimaryKeys() {
        return $this->PrimaryKeys;
    }
//End GetPrimaryKeys Method

//GetFormParameters Method @115-3E007397
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["personas_parcelas_tipo_estado_id"][$RowNumber] = CCGetFromPost("personas_parcelas_tipo_estado_id_" . $RowNumber, NULL);
            $this->FormParameters["persona_parcela_id"][$RowNumber] = CCGetFromPost("persona_parcela_id_" . $RowNumber, NULL);
            $this->FormParameters["ppal"][$RowNumber] = CCGetFromPost("ppal_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @115-689E258B
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["personas.persona_id"] = $this->CachedColumns["personas.persona_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["persona_id"] = $this->CachedColumns["persona_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["persona_parcela_id"] = $this->CachedColumns["persona_parcela_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_documento_id"] = $this->CachedColumns["tipo_documento_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_persona_id"] = $this->CachedColumns["tipo_persona_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_persona_parcela_id"] = $this->CachedColumns["tipo_persona_parcela_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_estado_id"] = $this->CachedColumns["tipo_estado_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_perso_jur_id"] = $this->CachedColumns["tipo_perso_jur_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_instrumento_id"] = $this->CachedColumns["tipo_instrumento_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->personas_parcelas_tipo_estado_id->SetText($this->FormParameters["personas_parcelas_tipo_estado_id"][$this->RowNumber], $this->RowNumber);
            $this->persona_parcela_id->SetText($this->FormParameters["persona_parcela_id"][$this->RowNumber], $this->RowNumber);
            $this->ppal->SetText($this->FormParameters["ppal"][$this->RowNumber], $this->RowNumber);
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

//ValidateRow Method @115-F23DF087
    function ValidateRow()
    {
        global $CCSLocales;
        $this->personas_parcelas_tipo_estado_id->Validate();
        $this->persona_parcela_id->Validate();
        $this->ppal->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->personas_parcelas_tipo_estado_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->persona_parcela_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ppal->Errors->ToString());
        $this->personas_parcelas_tipo_estado_id->Errors->Clear();
        $this->persona_parcela_id->Errors->Clear();
        $this->ppal->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @115-7C586CC0
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["personas_parcelas_tipo_estado_id"][$this->RowNumber]) && count($this->FormParameters["personas_parcelas_tipo_estado_id"][$this->RowNumber])) || strlen($this->FormParameters["personas_parcelas_tipo_estado_id"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["persona_parcela_id"][$this->RowNumber]) && count($this->FormParameters["persona_parcela_id"][$this->RowNumber])) || strlen($this->FormParameters["persona_parcela_id"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["ppal"][$this->RowNumber]) && count($this->FormParameters["ppal"][$this->RowNumber])) || strlen($this->FormParameters["ppal"][$this->RowNumber]));
        return $filed;
    }
//End CheckInsert Method

//CheckErrors Method @115-F5A3B433
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @115-909F269B
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

//UpdateGrid Method @115-A2AC0A83
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["personas.persona_id"] = $this->CachedColumns["personas.persona_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["persona_id"] = $this->CachedColumns["persona_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["persona_parcela_id"] = $this->CachedColumns["persona_parcela_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_documento_id"] = $this->CachedColumns["tipo_documento_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_persona_id"] = $this->CachedColumns["tipo_persona_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_persona_parcela_id"] = $this->CachedColumns["tipo_persona_parcela_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_estado_id"] = $this->CachedColumns["tipo_estado_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_perso_jur_id"] = $this->CachedColumns["tipo_perso_jur_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_instrumento_id"] = $this->CachedColumns["tipo_instrumento_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->personas_parcelas_tipo_estado_id->SetText($this->FormParameters["personas_parcelas_tipo_estado_id"][$this->RowNumber], $this->RowNumber);
            $this->persona_parcela_id->SetText($this->FormParameters["persona_parcela_id"][$this->RowNumber], $this->RowNumber);
            $this->ppal->SetText($this->FormParameters["ppal"][$this->RowNumber], $this->RowNumber);
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

//UpdateRow Method @115-826962C2
    function UpdateRow()
    {
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->persona_cuit->SetValue($this->persona_cuit->GetValue(true));
        $this->DataSource->persona_denominacion->SetValue($this->persona_denominacion->GetValue(true));
        $this->DataSource->personas_parcelas_tipo_estado_id->SetValue($this->personas_parcelas_tipo_estado_id->GetValue(true));
        $this->DataSource->tipo_persona_descrip->SetValue($this->tipo_persona_descrip->GetValue(true));
        $this->DataSource->tipo_persona_parcela_descrip->SetValue($this->tipo_persona_parcela_descrip->GetValue(true));
        $this->DataSource->tipo_documento_abrev->SetValue($this->tipo_documento_abrev->GetValue(true));
        $this->DataSource->persona_nro_doc->SetValue($this->persona_nro_doc->GetValue(true));
        $this->DataSource->persona_parcela_id->SetValue($this->persona_parcela_id->GetValue(true));
        $this->DataSource->ppal->SetValue($this->ppal->GetValue(true));
        $this->DataSource->ImageLink1->SetValue($this->ImageLink1->GetValue(true));
        $this->DataSource->ImageLink2->SetValue($this->ImageLink2->GetValue(true));
        $this->DataSource->persona_parcela_dominio->SetValue($this->persona_parcela_dominio->GetValue(true));
        $this->DataSource->este->SetValue($this->este->GetValue(true));
        $this->DataSource->tipo_perso_jur_abrev->SetValue($this->tipo_perso_jur_abrev->GetValue(true));
        $this->DataSource->tipo_estado_descrip->SetValue($this->tipo_estado_descrip->GetValue(true));
        $this->DataSource->instrumento->SetValue($this->instrumento->GetValue(true));
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

//FormScript Method @115-59800DB5
    function FormScript($TotalRows)
    {
        $script = "";
        return $script;
    }
//End FormScript Method

//SetFormState Method @115-3365EA9B
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
            for($i = 2; $i < sizeof($pieces); $i = $i + 9)  {
                $piece = $pieces[$i + 0];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["personas.persona_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 1];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["persona_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 2];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["persona_parcela_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 3];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["tipo_documento_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 4];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["tipo_persona_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 5];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["tipo_persona_parcela_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 6];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["tipo_estado_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 7];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["tipo_perso_jur_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 8];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["tipo_instrumento_id"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["personas.persona_id"][$RowNumber] = "";
                $this->CachedColumns["persona_id"][$RowNumber] = "";
                $this->CachedColumns["persona_parcela_id"][$RowNumber] = "";
                $this->CachedColumns["tipo_documento_id"][$RowNumber] = "";
                $this->CachedColumns["tipo_persona_id"][$RowNumber] = "";
                $this->CachedColumns["tipo_persona_parcela_id"][$RowNumber] = "";
                $this->CachedColumns["tipo_estado_id"][$RowNumber] = "";
                $this->CachedColumns["tipo_perso_jur_id"][$RowNumber] = "";
                $this->CachedColumns["tipo_instrumento_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @115-2ADBD4A0
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["personas.persona_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["persona_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["persona_parcela_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["tipo_documento_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["tipo_persona_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["tipo_persona_parcela_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["tipo_estado_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["tipo_perso_jur_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["tipo_instrumento_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @115-A964AAAA
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
        $this->ControlsVisible["persona_cuit"] = $this->persona_cuit->Visible;
        $this->ControlsVisible["persona_denominacion"] = $this->persona_denominacion->Visible;
        $this->ControlsVisible["personas_parcelas_tipo_estado_id"] = $this->personas_parcelas_tipo_estado_id->Visible;
        $this->ControlsVisible["tipo_persona_descrip"] = $this->tipo_persona_descrip->Visible;
        $this->ControlsVisible["tipo_persona_parcela_descrip"] = $this->tipo_persona_parcela_descrip->Visible;
        $this->ControlsVisible["tipo_documento_abrev"] = $this->tipo_documento_abrev->Visible;
        $this->ControlsVisible["persona_nro_doc"] = $this->persona_nro_doc->Visible;
        $this->ControlsVisible["persona_parcela_id"] = $this->persona_parcela_id->Visible;
        $this->ControlsVisible["ppal"] = $this->ppal->Visible;
        $this->ControlsVisible["ImageLink1"] = $this->ImageLink1->Visible;
        $this->ControlsVisible["ImageLink2"] = $this->ImageLink2->Visible;
        $this->ControlsVisible["persona_parcela_dominio"] = $this->persona_parcela_dominio->Visible;
        $this->ControlsVisible["este"] = $this->este->Visible;
        $this->ControlsVisible["tipo_perso_jur_abrev"] = $this->tipo_perso_jur_abrev->Visible;
        $this->ControlsVisible["tipo_estado_descrip"] = $this->tipo_estado_descrip->Visible;
        $this->ControlsVisible["instrumento"] = $this->instrumento->Visible;
        if ($is_next_record || ($EmptyRowsLeft && $this->InsertAllowed)) {
            do {
                $this->RowNumber++;
                if($is_next_record) {
                    $NonEmptyRows++;
                    $this->DataSource->SetValues();
                }
                if (!($this->FormSubmitted) && $is_next_record) {
                    $this->CachedColumns["personas.persona_id"][$this->RowNumber] = $this->DataSource->CachedColumns["personas.persona_id"];
                    $this->CachedColumns["persona_id"][$this->RowNumber] = $this->DataSource->CachedColumns["persona_id"];
                    $this->CachedColumns["persona_parcela_id"][$this->RowNumber] = $this->DataSource->CachedColumns["persona_parcela_id"];
                    $this->CachedColumns["tipo_documento_id"][$this->RowNumber] = $this->DataSource->CachedColumns["tipo_documento_id"];
                    $this->CachedColumns["tipo_persona_id"][$this->RowNumber] = $this->DataSource->CachedColumns["tipo_persona_id"];
                    $this->CachedColumns["tipo_persona_parcela_id"][$this->RowNumber] = $this->DataSource->CachedColumns["tipo_persona_parcela_id"];
                    $this->CachedColumns["tipo_estado_id"][$this->RowNumber] = $this->DataSource->CachedColumns["tipo_estado_id"];
                    $this->CachedColumns["tipo_perso_jur_id"][$this->RowNumber] = $this->DataSource->CachedColumns["tipo_perso_jur_id"];
                    $this->CachedColumns["tipo_instrumento_id"][$this->RowNumber] = $this->DataSource->CachedColumns["tipo_instrumento_id"];
                    $this->ImageLink1->SetText("");
                    $this->ImageLink2->SetText("");
                    $this->este->SetText("");
                    $this->persona_cuit->SetValue($this->DataSource->persona_cuit->GetValue());
                    $this->persona_denominacion->SetValue($this->DataSource->persona_denominacion->GetValue());
                    $this->personas_parcelas_tipo_estado_id->SetValue($this->DataSource->personas_parcelas_tipo_estado_id->GetValue());
                    $this->tipo_persona_descrip->SetValue($this->DataSource->tipo_persona_descrip->GetValue());
                    $this->tipo_persona_parcela_descrip->SetValue($this->DataSource->tipo_persona_parcela_descrip->GetValue());
                    $this->tipo_documento_abrev->SetValue($this->DataSource->tipo_documento_abrev->GetValue());
                    $this->persona_nro_doc->SetValue($this->DataSource->persona_nro_doc->GetValue());
                    $this->persona_parcela_id->SetValue($this->DataSource->persona_parcela_id->GetValue());
                    $this->ppal->SetValue($this->DataSource->ppal->GetValue());
                    $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("direcciones", "direccion_id", "add", "person_id", "ccsForm"));
                    $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "persona_id", $this->DataSource->f("persona_id"));
                    $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "personas", 1);
                    $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "persona_parcela_id", $this->DataSource->f("persona_parcela_id"));
                    $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "parcela_id", CCGetFromGet("parcela_id", NULL));
                    $this->ImageLink2->Parameters = CCGetQueryString("QueryString", array("personas", "persona_parcela_id", "direccion_id", "add", "ccsForm"));
                    $this->ImageLink2->Parameters = CCAddParam($this->ImageLink2->Parameters, "direcciones", 1);
                    $this->ImageLink2->Parameters = CCAddParam($this->ImageLink2->Parameters, "persona_id", $this->DataSource->f("persona_id"));
                    $this->ImageLink2->Parameters = CCAddParam($this->ImageLink2->Parameters, "parcela_id", CCGetFromGet("parcela_id", NULL));
                    $this->persona_parcela_dominio->SetValue($this->DataSource->persona_parcela_dominio->GetValue());
                    $this->este->Parameters = CCGetQueryString("QueryString", array("direcciones", "direccion_id", "add", "person_id", "ccsForm"));
                    $this->este->Parameters = CCAddParam($this->este->Parameters, "persona_id", $this->DataSource->f("persona_id"));
                    $this->este->Parameters = CCAddParam($this->este->Parameters, "personas", 1);
                    $this->este->Parameters = CCAddParam($this->este->Parameters, "persona_parcela_id", $this->DataSource->f("persona_parcela_id"));
                    $this->este->Parameters = CCAddParam($this->este->Parameters, "parcela_id", CCGetFromGet("parcela_id", NULL));
                    $this->tipo_perso_jur_abrev->SetValue($this->DataSource->tipo_perso_jur_abrev->GetValue());
                    $this->tipo_estado_descrip->SetValue($this->DataSource->tipo_estado_descrip->GetValue());
                    $this->instrumento->SetValue($this->DataSource->instrumento->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->persona_cuit->SetText("");
                    $this->persona_denominacion->SetText("");
                    $this->tipo_persona_descrip->SetText("");
                    $this->tipo_persona_parcela_descrip->SetText("");
                    $this->tipo_documento_abrev->SetText("");
                    $this->persona_nro_doc->SetText("");
                    $this->ImageLink1->SetText("");
                    $this->ImageLink2->SetText("");
                    $this->persona_parcela_dominio->SetText("");
                    $this->este->SetText("");
                    $this->tipo_perso_jur_abrev->SetText("");
                    $this->tipo_estado_descrip->SetText("");
                    $this->instrumento->SetText("");
                    $this->persona_cuit->SetValue($this->DataSource->persona_cuit->GetValue());
                    $this->persona_denominacion->SetValue($this->DataSource->persona_denominacion->GetValue());
                    $this->tipo_persona_descrip->SetValue($this->DataSource->tipo_persona_descrip->GetValue());
                    $this->tipo_persona_parcela_descrip->SetValue($this->DataSource->tipo_persona_parcela_descrip->GetValue());
                    $this->tipo_documento_abrev->SetValue($this->DataSource->tipo_documento_abrev->GetValue());
                    $this->persona_nro_doc->SetValue($this->DataSource->persona_nro_doc->GetValue());
                    $this->persona_parcela_dominio->SetValue($this->DataSource->persona_parcela_dominio->GetValue());
                    $this->tipo_perso_jur_abrev->SetValue($this->DataSource->tipo_perso_jur_abrev->GetValue());
                    $this->tipo_estado_descrip->SetValue($this->DataSource->tipo_estado_descrip->GetValue());
                    $this->instrumento->SetValue($this->DataSource->instrumento->GetValue());
                    $this->personas_parcelas_tipo_estado_id->SetText($this->FormParameters["personas_parcelas_tipo_estado_id"][$this->RowNumber], $this->RowNumber);
                    $this->persona_parcela_id->SetText($this->FormParameters["persona_parcela_id"][$this->RowNumber], $this->RowNumber);
                    $this->ppal->SetText($this->FormParameters["ppal"][$this->RowNumber], $this->RowNumber);
                    $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "persona_id", $this->DataSource->f("persona_id"));
                    $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "personas", 1);
                    $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "persona_parcela_id", $this->DataSource->f("persona_parcela_id"));
                    $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "parcela_id", CCGetFromGet("parcela_id", NULL));
                    $this->ImageLink2->Parameters = CCAddParam($this->ImageLink2->Parameters, "direcciones", 1);
                    $this->ImageLink2->Parameters = CCAddParam($this->ImageLink2->Parameters, "persona_id", $this->DataSource->f("persona_id"));
                    $this->ImageLink2->Parameters = CCAddParam($this->ImageLink2->Parameters, "parcela_id", CCGetFromGet("parcela_id", NULL));
                    $this->este->Parameters = CCAddParam($this->este->Parameters, "persona_id", $this->DataSource->f("persona_id"));
                    $this->este->Parameters = CCAddParam($this->este->Parameters, "personas", 1);
                    $this->este->Parameters = CCAddParam($this->este->Parameters, "persona_parcela_id", $this->DataSource->f("persona_parcela_id"));
                    $this->este->Parameters = CCAddParam($this->este->Parameters, "parcela_id", CCGetFromGet("parcela_id", NULL));
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["personas.persona_id"][$this->RowNumber] = "";
                    $this->CachedColumns["persona_id"][$this->RowNumber] = "";
                    $this->CachedColumns["persona_parcela_id"][$this->RowNumber] = "";
                    $this->CachedColumns["tipo_documento_id"][$this->RowNumber] = "";
                    $this->CachedColumns["tipo_persona_id"][$this->RowNumber] = "";
                    $this->CachedColumns["tipo_persona_parcela_id"][$this->RowNumber] = "";
                    $this->CachedColumns["tipo_estado_id"][$this->RowNumber] = "";
                    $this->CachedColumns["tipo_perso_jur_id"][$this->RowNumber] = "";
                    $this->CachedColumns["tipo_instrumento_id"][$this->RowNumber] = "";
                    $this->persona_cuit->SetText("");
                    $this->persona_denominacion->SetText("");
                    $this->personas_parcelas_tipo_estado_id->SetText("");
                    $this->tipo_persona_descrip->SetText("");
                    $this->tipo_persona_parcela_descrip->SetText("");
                    $this->tipo_documento_abrev->SetText("");
                    $this->persona_nro_doc->SetText("");
                    $this->persona_parcela_id->SetText("");
                    $this->ppal->SetValue("");
                    $this->ImageLink1->SetText("");
                    $this->ImageLink2->SetText("");
                    $this->persona_parcela_dominio->SetText("");
                    $this->este->SetText("");
                    $this->tipo_perso_jur_abrev->SetText("");
                    $this->tipo_estado_descrip->SetText("");
                    $this->instrumento->SetText("");
                    $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "persona_id", $this->DataSource->f("persona_id"));
                    $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "personas", 1);
                    $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "persona_parcela_id", $this->DataSource->f("persona_parcela_id"));
                    $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "parcela_id", CCGetFromGet("parcela_id", NULL));
                    $this->ImageLink2->Parameters = CCAddParam($this->ImageLink2->Parameters, "direcciones", 1);
                    $this->ImageLink2->Parameters = CCAddParam($this->ImageLink2->Parameters, "persona_id", $this->DataSource->f("persona_id"));
                    $this->ImageLink2->Parameters = CCAddParam($this->ImageLink2->Parameters, "parcela_id", CCGetFromGet("parcela_id", NULL));
                    $this->este->Parameters = CCAddParam($this->este->Parameters, "persona_id", $this->DataSource->f("persona_id"));
                    $this->este->Parameters = CCAddParam($this->este->Parameters, "personas", 1);
                    $this->este->Parameters = CCAddParam($this->este->Parameters, "persona_parcela_id", $this->DataSource->f("persona_parcela_id"));
                    $this->este->Parameters = CCAddParam($this->este->Parameters, "parcela_id", CCGetFromGet("parcela_id", NULL));
                } else {
                    $this->persona_cuit->SetText("");
                    $this->persona_denominacion->SetText("");
                    $this->tipo_persona_descrip->SetText("");
                    $this->tipo_persona_parcela_descrip->SetText("");
                    $this->tipo_documento_abrev->SetText("");
                    $this->persona_nro_doc->SetText("");
                    $this->ImageLink1->SetText("");
                    $this->ImageLink2->SetText("");
                    $this->persona_parcela_dominio->SetText("");
                    $this->este->SetText("");
                    $this->tipo_perso_jur_abrev->SetText("");
                    $this->tipo_estado_descrip->SetText("");
                    $this->instrumento->SetText("");
                    $this->personas_parcelas_tipo_estado_id->SetText($this->FormParameters["personas_parcelas_tipo_estado_id"][$this->RowNumber], $this->RowNumber);
                    $this->persona_parcela_id->SetText($this->FormParameters["persona_parcela_id"][$this->RowNumber], $this->RowNumber);
                    $this->ppal->SetText($this->FormParameters["ppal"][$this->RowNumber], $this->RowNumber);
                    $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "persona_id", $this->DataSource->f("persona_id"));
                    $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "personas", 1);
                    $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "persona_parcela_id", $this->DataSource->f("persona_parcela_id"));
                    $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "parcela_id", CCGetFromGet("parcela_id", NULL));
                    $this->ImageLink2->Parameters = CCAddParam($this->ImageLink2->Parameters, "direcciones", 1);
                    $this->ImageLink2->Parameters = CCAddParam($this->ImageLink2->Parameters, "persona_id", $this->DataSource->f("persona_id"));
                    $this->ImageLink2->Parameters = CCAddParam($this->ImageLink2->Parameters, "parcela_id", CCGetFromGet("parcela_id", NULL));
                    $this->este->Parameters = CCAddParam($this->este->Parameters, "persona_id", $this->DataSource->f("persona_id"));
                    $this->este->Parameters = CCAddParam($this->este->Parameters, "personas", 1);
                    $this->este->Parameters = CCAddParam($this->este->Parameters, "persona_parcela_id", $this->DataSource->f("persona_parcela_id"));
                    $this->este->Parameters = CCAddParam($this->este->Parameters, "parcela_id", CCGetFromGet("parcela_id", NULL));
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->persona_cuit->Show($this->RowNumber);
                $this->persona_denominacion->Show($this->RowNumber);
                $this->personas_parcelas_tipo_estado_id->Show($this->RowNumber);
                $this->tipo_persona_descrip->Show($this->RowNumber);
                $this->tipo_persona_parcela_descrip->Show($this->RowNumber);
                $this->tipo_documento_abrev->Show($this->RowNumber);
                $this->persona_nro_doc->Show($this->RowNumber);
                $this->persona_parcela_id->Show($this->RowNumber);
                $this->ppal->Show($this->RowNumber);
                $this->ImageLink1->Show($this->RowNumber);
                $this->ImageLink2->Show($this->RowNumber);
                $this->persona_parcela_dominio->Show($this->RowNumber);
                $this->este->Show($this->RowNumber);
                $this->tipo_perso_jur_abrev->Show($this->RowNumber);
                $this->tipo_estado_descrip->Show($this->RowNumber);
                $this->instrumento->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["personas.persona_id"] == $this->CachedColumns["personas.persona_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["persona_id"] == $this->CachedColumns["persona_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["persona_parcela_id"] == $this->CachedColumns["persona_parcela_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["tipo_documento_id"] == $this->CachedColumns["tipo_documento_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["tipo_persona_id"] == $this->CachedColumns["tipo_persona_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["tipo_persona_parcela_id"] == $this->CachedColumns["tipo_persona_parcela_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["tipo_estado_id"] == $this->CachedColumns["tipo_estado_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["tipo_perso_jur_id"] == $this->CachedColumns["tipo_perso_jur_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["tipo_instrumento_id"] == $this->CachedColumns["tipo_instrumento_id"][$this->RowNumber])) {
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
        $this->ImageLink3->Parameters = CCGetQueryString("QueryString", array("persona_id", "persona_parcela_id", "person_id", "ccsForm"));
        $this->ImageLink3->Parameters = CCAddParam($this->ImageLink3->Parameters, "parcela_id", CCGetFromGet("parcela_id", NULL));
        $this->ImageLink3->Parameters = CCAddParam($this->ImageLink3->Parameters, "add", 1);
        $this->ImageLink3->Parameters = CCAddParam($this->ImageLink3->Parameters, "personas", 1);
        $this->Navigator->Show();
        $this->Button_Submit->Show();
        $this->Label1->Show();
        $this->panel_add->Show();
        $this->total_dom->Show();

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

} //End personas_personas_parcela Class @115-FCB6E20C

class clspersonas_personas_parcelaDataSource extends clsDBtdf_nuevo {  //personas_personas_parcelaDataSource Class @115-090A7A70

//DataSource Variables @115-B972D226
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $UpdateParameters;
    public $CountSQL;
    public $wp;
    public $AllParametersSet;

    public $CachedColumns;
    public $CurrentRow;
    public $UpdateFields = array();

    // Datasource fields
    public $persona_cuit;
    public $persona_denominacion;
    public $personas_parcelas_tipo_estado_id;
    public $tipo_persona_descrip;
    public $tipo_persona_parcela_descrip;
    public $tipo_documento_abrev;
    public $persona_nro_doc;
    public $persona_parcela_id;
    public $ppal;
    public $ImageLink1;
    public $ImageLink2;
    public $persona_parcela_dominio;
    public $este;
    public $tipo_perso_jur_abrev;
    public $tipo_estado_descrip;
    public $instrumento;
//End DataSource Variables

//DataSourceClass_Initialize Event @115-0DED0356
    function clspersonas_personas_parcelaDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid personas_personas_parcela/Error";
        $this->Initialize();
        $this->persona_cuit = new clsField("persona_cuit", ccsText, "");
        
        $this->persona_denominacion = new clsField("persona_denominacion", ccsText, "");
        
        $this->personas_parcelas_tipo_estado_id = new clsField("personas_parcelas_tipo_estado_id", ccsText, "");
        
        $this->tipo_persona_descrip = new clsField("tipo_persona_descrip", ccsText, "");
        
        $this->tipo_persona_parcela_descrip = new clsField("tipo_persona_parcela_descrip", ccsText, "");
        
        $this->tipo_documento_abrev = new clsField("tipo_documento_abrev", ccsText, "");
        
        $this->persona_nro_doc = new clsField("persona_nro_doc", ccsInteger, "");
        
        $this->persona_parcela_id = new clsField("persona_parcela_id", ccsInteger, "");
        
        $this->ppal = new clsField("ppal", ccsBoolean, $this->BooleanFormat);
        
        $this->ImageLink1 = new clsField("ImageLink1", ccsText, "");
        
        $this->ImageLink2 = new clsField("ImageLink2", ccsText, "");
        
        $this->persona_parcela_dominio = new clsField("persona_parcela_dominio", ccsFloat, "");
        
        $this->este = new clsField("este", ccsText, "");
        
        $this->tipo_perso_jur_abrev = new clsField("tipo_perso_jur_abrev", ccsText, "");
        
        $this->tipo_estado_descrip = new clsField("tipo_estado_descrip", ccsText, "");
        
        $this->instrumento = new clsField("instrumento", ccsText, "");
        

        $this->UpdateFields["personas_parcelas_tipo_estado_id"] = array("Name" => "tipo_estado_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["persona_parcela_id"] = array("Name" => "persona_parcela_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["persona_parcela_ppal"] = array("Name" => "persona_parcela_ppal", "Value" => "", "DataType" => ccsBoolean);
    }
//End DataSourceClass_Initialize Event

//SetOrder Method @115-95902A62
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "tipo_estado_descrip, tipo_persona_parcela_ppal, persona_parcela_f_pro desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @115-F2B17E61
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlparcela_id", ccsInteger, "", "", $this->Parameters["urlparcela_id"], -1, false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "personas_parcelas.parcela_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @115-9905D004
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((((((personas INNER JOIN personas_parcelas ON\n\n" .
        "personas_parcelas.persona_id = personas.persona_id) LEFT JOIN tipos_documentos ON\n\n" .
        "personas.tipo_documento_id = tipos_documentos.tipo_documento_id) LEFT JOIN tipos_personas ON\n\n" .
        "personas.tipo_persona_id = tipos_personas.tipo_persona_id) LEFT JOIN tipos_personas_juridicas ON\n\n" .
        "personas.tipo_perso_jur_id = tipos_personas_juridicas.tipo_perso_jur_id) LEFT JOIN tipos_personas_parcelas ON\n\n" .
        "personas_parcelas.tipo_persona_parcela_id = tipos_personas_parcelas.tipo_persona_parcela_id) LEFT JOIN tipos_estados ON\n\n" .
        "tipos_estados.tipo_estado_id = personas_parcelas.tipo_estado_id) LEFT JOIN tipos_instrumentos ON\n\n" .
        "personas_parcelas.tipo_instrumento_id = tipos_instrumentos.tipo_instrumento_id";
        $this->SQL = "SELECT tipo_persona_descrip, tipo_documento_descrip, tipo_persona_parcela_descrip, persona_denominacion, persona_nro_doc, persona_cuit,\n\n" .
        "personas.persona_id AS persona_id, tipo_documento_abrev, persona_parcela_id, persona_parcela_ppal, persona_parcela_ppal AS Expr1,\n\n" .
        "personas_parcelas.persona_id AS personas_parcelas_persona_id, personas_parcelas.tipo_estado_id AS personas_parcelas_tipo_estado_id,\n\n" .
        "tipo_estado_valor, persona_parcela_dominio, tipo_perso_jur_abrev, tipo_estado_descrip, persona_parcela_num_int, tipo_instrumento_descrip,\n\n" .
        "tipo_instrumento_abrev, CONCAT(tipos_instrumentos.tipo_instrumento_abrev,' ',personas_parcelas.persona_parcela_num_int) AS instrumento,\n\n" .
        "tipo_estado_html \n\n" .
        "FROM ((((((personas INNER JOIN personas_parcelas ON\n\n" .
        "personas_parcelas.persona_id = personas.persona_id) LEFT JOIN tipos_documentos ON\n\n" .
        "personas.tipo_documento_id = tipos_documentos.tipo_documento_id) LEFT JOIN tipos_personas ON\n\n" .
        "personas.tipo_persona_id = tipos_personas.tipo_persona_id) LEFT JOIN tipos_personas_juridicas ON\n\n" .
        "personas.tipo_perso_jur_id = tipos_personas_juridicas.tipo_perso_jur_id) LEFT JOIN tipos_personas_parcelas ON\n\n" .
        "personas_parcelas.tipo_persona_parcela_id = tipos_personas_parcelas.tipo_persona_parcela_id) LEFT JOIN tipos_estados ON\n\n" .
        "tipos_estados.tipo_estado_id = personas_parcelas.tipo_estado_id) LEFT JOIN tipos_instrumentos ON\n\n" .
        "personas_parcelas.tipo_instrumento_id = tipos_instrumentos.tipo_instrumento_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @115-614B7792
    function SetValues()
    {
        $this->CachedColumns["personas.persona_id"] = $this->f("persona_id");
        $this->CachedColumns["persona_id"] = $this->f("personas_parcelas_persona_id");
        $this->CachedColumns["persona_parcela_id"] = $this->f("persona_parcela_id");
        $this->CachedColumns["tipo_documento_id"] = $this->f("tipo_documento_id");
        $this->CachedColumns["tipo_persona_id"] = $this->f("tipo_persona_id");
        $this->CachedColumns["tipo_persona_parcela_id"] = $this->f("tipo_persona_parcela_id");
        $this->CachedColumns["tipo_estado_id"] = $this->f("personas_parcelas_tipo_estado_id");
        $this->CachedColumns["tipo_perso_jur_id"] = $this->f("tipo_perso_jur_id");
        $this->CachedColumns["tipo_instrumento_id"] = $this->f("tipo_instrumento_id");
        $this->persona_cuit->SetDBValue($this->f("persona_cuit"));
        $this->persona_denominacion->SetDBValue($this->f("persona_denominacion"));
        $this->personas_parcelas_tipo_estado_id->SetDBValue($this->f("personas_parcelas_tipo_estado_id"));
        $this->tipo_persona_descrip->SetDBValue($this->f("tipo_persona_descrip"));
        $this->tipo_persona_parcela_descrip->SetDBValue($this->f("tipo_persona_parcela_descrip"));
        $this->tipo_documento_abrev->SetDBValue($this->f("tipo_documento_abrev"));
        $this->persona_nro_doc->SetDBValue(trim($this->f("persona_nro_doc")));
        $this->persona_parcela_id->SetDBValue(trim($this->f("persona_parcela_id")));
        $this->ppal->SetDBValue(trim($this->f("persona_parcela_ppal")));
        $this->persona_parcela_dominio->SetDBValue(trim($this->f("persona_parcela_dominio")));
        $this->tipo_perso_jur_abrev->SetDBValue($this->f("tipo_perso_jur_abrev"));
        $this->tipo_estado_descrip->SetDBValue($this->f("tipo_estado_html"));
        $this->instrumento->SetDBValue($this->f("instrumento"));
    }
//End SetValues Method

//Update Method @115-36A602CD
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "persona_parcela_id=" . $this->ToSQL($this->CachedColumns["persona_parcela_id"], ccsInteger);
        $this->UpdateFields["personas_parcelas_tipo_estado_id"]["Value"] = $this->personas_parcelas_tipo_estado_id->GetDBValue(true);
        $this->UpdateFields["persona_parcela_id"]["Value"] = $this->persona_parcela_id->GetDBValue(true);
        $this->UpdateFields["persona_parcela_ppal"]["Value"] = $this->ppal->GetDBValue(true);
        $this->SQL = CCBuildUpdate("personas_parcelas", $this->UpdateFields, $this);
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

} //End personas_personas_parcelaDataSource Class @115-FCB6E20C

class clsRecordpersonas { //personas Class @189-9339D5E2

//Variables @189-9E315808

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

//Class_Initialize Event @189-F8E6C362
    function clsRecordpersonas($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record personas/Error";
        $this->DataSource = new clspersonasDataSource($this);
        $this->ds = & $this->DataSource;
        $this->ReadAllowed = true;
        $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
        if($this->Visible)
        {
            $this->ReadAllowed = $this->ReadAllowed && CCUserInGroups(CCGetGroupID(), "1;2");
            $this->UpdateAllowed = CCUserInGroups(CCGetGroupID(), "2");
            $this->ComponentName = "personas";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->persona_nro_doc = new clsControl(ccsTextBox, "persona_nro_doc", "Documento", ccsInteger, "", CCGetRequestParam("persona_nro_doc", $Method, NULL), $this);
            $this->persona_denominacion = new clsControl(ccsHidden, "persona_denominacion", "Apellido y Nombre", ccsText, "", CCGetRequestParam("persona_denominacion", $Method, NULL), $this);
            $this->persona_fecha_nac = new clsControl(ccsTextBox, "persona_fecha_nac", "Fecha Nac", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("persona_fecha_nac", $Method, NULL), $this);
            $this->persona_tel_movil = new clsControl(ccsTextBox, "persona_tel_movil", "Tel Movil", ccsText, "", CCGetRequestParam("persona_tel_movil", $Method, NULL), $this);
            $this->persona_cuit = new clsControl(ccsTextBox, "persona_cuit", "Cuit", ccsText, "", CCGetRequestParam("persona_cuit", $Method, NULL), $this);
            $this->tipo_documento_id = new clsControl(ccsListBox, "tipo_documento_id", "Tipo Documento", ccsInteger, "", CCGetRequestParam("tipo_documento_id", $Method, NULL), $this);
            $this->tipo_documento_id->DSType = dsTable;
            $this->tipo_documento_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_documento_id->ds = & $this->tipo_documento_id->DataSource;
            $this->tipo_documento_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_documentos {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_documento_id->BoundColumn, $this->tipo_documento_id->TextColumn, $this->tipo_documento_id->DBFormat) = array("tipo_documento_id", "tipo_documento_abrev", "");
            $this->pais_id = new clsControl(ccsListBox, "pais_id", "Pais Id", ccsInteger, "", CCGetRequestParam("pais_id", $Method, NULL), $this);
            $this->pais_id->DSType = dsTable;
            $this->pais_id->DataSource = new clsDBtdf_nuevo();
            $this->pais_id->ds = & $this->pais_id->DataSource;
            $this->pais_id->DataSource->SQL = "SELECT * \n" .
"FROM paises {SQL_Where} {SQL_OrderBy}";
            list($this->pais_id->BoundColumn, $this->pais_id->TextColumn, $this->pais_id->DBFormat) = array("pais_id", "pais_nombre", "");
            $this->persona_email = new clsControl(ccsTextBox, "persona_email", "Email", ccsText, "", CCGetRequestParam("persona_email", $Method, NULL), $this);
            $this->persona_parcela_origen = new clsControl(ccsHidden, "persona_parcela_origen", "persona_parcela_origen", ccsText, "", CCGetRequestParam("persona_parcela_origen", $Method, NULL), $this);
            $this->persona_parcela_dominio = new clsControl(ccsTextBox, "persona_parcela_dominio", "porcentaje domino", ccsFloat, "", CCGetRequestParam("persona_parcela_dominio", $Method, NULL), $this);
            $this->tipo_persona_parcela_id = new clsControl(ccsListBox, "tipo_persona_parcela_id", "Figura", ccsInteger, "", CCGetRequestParam("tipo_persona_parcela_id", $Method, NULL), $this);
            $this->tipo_persona_parcela_id->DSType = dsTable;
            $this->tipo_persona_parcela_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_persona_parcela_id->ds = & $this->tipo_persona_parcela_id->DataSource;
            $this->tipo_persona_parcela_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_personas_parcelas {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_persona_parcela_id->BoundColumn, $this->tipo_persona_parcela_id->TextColumn, $this->tipo_persona_parcela_id->DBFormat) = array("tipo_persona_parcela_id", "tipo_persona_parcela_descrip", "");
            $this->tipo_persona_parcela_id->DataSource->Parameters["expr659"] = 1;
            $this->tipo_persona_parcela_id->DataSource->wp = new clsSQLParameters();
            $this->tipo_persona_parcela_id->DataSource->wp->AddParameter("1", "expr659", ccsInteger, "", "", $this->tipo_persona_parcela_id->DataSource->Parameters["expr659"], "", false);
            $this->tipo_persona_parcela_id->DataSource->wp->Criterion[1] = $this->tipo_persona_parcela_id->DataSource->wp->Operation(opEqual, "tipo_estado_id", $this->tipo_persona_parcela_id->DataSource->wp->GetDBValue("1"), $this->tipo_persona_parcela_id->DataSource->ToSQL($this->tipo_persona_parcela_id->DataSource->wp->GetDBValue("1"), ccsInteger),false);
            $this->tipo_persona_parcela_id->DataSource->Where = 
                 $this->tipo_persona_parcela_id->DataSource->wp->Criterion[1];
            $this->tipo_persona_parcela_id->Required = true;
            $this->persona = new clsControl(ccsLabel, "persona", "persona", ccsText, "", CCGetRequestParam("persona", $Method, NULL), $this);
            $this->persona_parcela_f_pro = new clsControl(ccsHidden, "persona_parcela_f_pro", "persona_parcela_f_pro", ccsText, "", CCGetRequestParam("persona_parcela_f_pro", $Method, NULL), $this);
            $this->audit_string = new clsControl(ccsHidden, "audit_string", "audit_string", ccsText, "", CCGetRequestParam("audit_string", $Method, NULL), $this);
            $this->tipo_persona_id = new clsControl(ccsListBox, "tipo_persona_id", "Tipo de persona", ccsText, "", CCGetRequestParam("tipo_persona_id", $Method, NULL), $this);
            $this->tipo_persona_id->DSType = dsTable;
            $this->tipo_persona_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_persona_id->ds = & $this->tipo_persona_id->DataSource;
            $this->tipo_persona_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_personas {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_persona_id->BoundColumn, $this->tipo_persona_id->TextColumn, $this->tipo_persona_id->DBFormat) = array("tipo_persona_id", "tipo_persona_descrip", "");
            $this->editar = new clsButton("editar", $Method, $this);
            $this->persona_parcela_f_int = new clsControl(ccsTextBox, "persona_parcela_f_int", "Fecha Instrumento", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("persona_parcela_f_int", $Method, NULL), $this);
            $this->DatePicker_persona_parcela_f_int1 = new clsDatePicker("DatePicker_persona_parcela_f_int1", "personas", "persona_parcela_f_int", $this);
            $this->persona_id = new clsControl(ccsHidden, "persona_id", "persona_id", ccsText, "", CCGetRequestParam("persona_id", $Method, NULL), $this);
            $this->persona_nombre = new clsControl(ccsTextBox, "persona_nombre", "persona_nombre", ccsText, "", CCGetRequestParam("persona_nombre", $Method, NULL), $this);
            $this->persona_apellido = new clsControl(ccsTextBox, "persona_apellido", "persona_apellido", ccsText, "", CCGetRequestParam("persona_apellido", $Method, NULL), $this);
            $this->persona_conyuge = new clsControl(ccsTextBox, "persona_conyuge", "Conyuge", ccsText, "", CCGetRequestParam("persona_conyuge", $Method, NULL), $this);
            $this->persona_parcela_num_int = new clsControl(ccsTextBox, "persona_parcela_num_int", "Nro Instrumento", ccsText, "", CCGetRequestParam("persona_parcela_num_int", $Method, NULL), $this);
            $this->persona_parcela_num_int->Required = true;
            $this->tipo_instrumento_id = new clsControl(ccsListBox, "tipo_instrumento_id", "Tipo Instrumento", ccsInteger, "", CCGetRequestParam("tipo_instrumento_id", $Method, NULL), $this);
            $this->tipo_instrumento_id->DSType = dsTable;
            $this->tipo_instrumento_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_instrumento_id->ds = & $this->tipo_instrumento_id->DataSource;
            $this->tipo_instrumento_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_instrumentos {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_instrumento_id->BoundColumn, $this->tipo_instrumento_id->TextColumn, $this->tipo_instrumento_id->DBFormat) = array("tipo_instrumento_id", "tipo_instrumento_descrip", "");
            $this->tipo_instrumento_id->Required = true;
            $this->tipo_perso_jur_id = new clsControl(ccsListBox, "tipo_perso_jur_id", "tipo_perso_jur_id", ccsText, "", CCGetRequestParam("tipo_perso_jur_id", $Method, NULL), $this);
            $this->tipo_perso_jur_id->DSType = dsTable;
            $this->tipo_perso_jur_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_perso_jur_id->ds = & $this->tipo_perso_jur_id->DataSource;
            $this->tipo_perso_jur_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_personas_juridicas {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_perso_jur_id->BoundColumn, $this->tipo_perso_jur_id->TextColumn, $this->tipo_perso_jur_id->DBFormat) = array("tipo_perso_jur_id", "tipo_perso_jur_descrip", "");
            $this->persona_relacionada = new clsControl(ccsLabel, "persona_relacionada", "persona_relacionada", ccsText, "", CCGetRequestParam("persona_relacionada", $Method, NULL), $this);
            $this->tipo_estado_id = new clsControl(ccsListBox, "tipo_estado_id", "tipo_estado_id", ccsInteger, "", CCGetRequestParam("tipo_estado_id", $Method, NULL), $this);
            $this->tipo_estado_id->DSType = dsTable;
            $this->tipo_estado_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_estado_id->ds = & $this->tipo_estado_id->DataSource;
            $this->tipo_estado_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_estados {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_estado_id->BoundColumn, $this->tipo_estado_id->TextColumn, $this->tipo_estado_id->DBFormat) = array("tipo_estado_id", "tipo_estado_descrip", "");
            $this->eliminar = new clsButton("eliminar", $Method, $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->pais_id->Value) && !strlen($this->pais_id->Value) && $this->pais_id->Value !== false)
                    $this->pais_id->SetText(12);
                if(!is_array($this->tipo_estado_id->Value) && !strlen($this->tipo_estado_id->Value) && $this->tipo_estado_id->Value !== false)
                    $this->tipo_estado_id->SetText(1);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @189-CC73B27B
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlpersona_parcela_id"] = CCGetFromGet("persona_parcela_id", NULL);
    }
//End Initialize Method

//Validate Method @189-4CE5D235
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        if(strlen($this->persona_email->GetText()) && !preg_match ("/^[\w\.-]{1,}\@([\da-zA-Z-]{1,}\.){1,}[\da-zA-Z-]+$/", $this->persona_email->GetText())) {
            $this->persona_email->Errors->addError($CCSLocales->GetText("CCS_MaskValidation", "Email"));
        }
        $Validation = ($this->persona_nro_doc->Validate() && $Validation);
        $Validation = ($this->persona_denominacion->Validate() && $Validation);
        $Validation = ($this->persona_fecha_nac->Validate() && $Validation);
        $Validation = ($this->persona_tel_movil->Validate() && $Validation);
        $Validation = ($this->persona_cuit->Validate() && $Validation);
        $Validation = ($this->tipo_documento_id->Validate() && $Validation);
        $Validation = ($this->pais_id->Validate() && $Validation);
        $Validation = ($this->persona_email->Validate() && $Validation);
        $Validation = ($this->persona_parcela_origen->Validate() && $Validation);
        $Validation = ($this->persona_parcela_dominio->Validate() && $Validation);
        $Validation = ($this->tipo_persona_parcela_id->Validate() && $Validation);
        $Validation = ($this->persona_parcela_f_pro->Validate() && $Validation);
        $Validation = ($this->audit_string->Validate() && $Validation);
        $Validation = ($this->tipo_persona_id->Validate() && $Validation);
        $Validation = ($this->persona_parcela_f_int->Validate() && $Validation);
        $Validation = ($this->persona_id->Validate() && $Validation);
        $Validation = ($this->persona_nombre->Validate() && $Validation);
        $Validation = ($this->persona_apellido->Validate() && $Validation);
        $Validation = ($this->persona_conyuge->Validate() && $Validation);
        $Validation = ($this->persona_parcela_num_int->Validate() && $Validation);
        $Validation = ($this->tipo_instrumento_id->Validate() && $Validation);
        $Validation = ($this->tipo_perso_jur_id->Validate() && $Validation);
        $Validation = ($this->tipo_estado_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->persona_nro_doc->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_denominacion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_fecha_nac->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_tel_movil->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_cuit->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_documento_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->pais_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_email->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_parcela_origen->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_parcela_dominio->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_persona_parcela_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_parcela_f_pro->Errors->Count() == 0);
        $Validation =  $Validation && ($this->audit_string->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_persona_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_parcela_f_int->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_nombre->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_apellido->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_conyuge->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_parcela_num_int->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_instrumento_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_perso_jur_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_estado_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @189-3706A817
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->persona_nro_doc->Errors->Count());
        $errors = ($errors || $this->persona_denominacion->Errors->Count());
        $errors = ($errors || $this->persona_fecha_nac->Errors->Count());
        $errors = ($errors || $this->persona_tel_movil->Errors->Count());
        $errors = ($errors || $this->persona_cuit->Errors->Count());
        $errors = ($errors || $this->tipo_documento_id->Errors->Count());
        $errors = ($errors || $this->pais_id->Errors->Count());
        $errors = ($errors || $this->persona_email->Errors->Count());
        $errors = ($errors || $this->persona_parcela_origen->Errors->Count());
        $errors = ($errors || $this->persona_parcela_dominio->Errors->Count());
        $errors = ($errors || $this->tipo_persona_parcela_id->Errors->Count());
        $errors = ($errors || $this->persona->Errors->Count());
        $errors = ($errors || $this->persona_parcela_f_pro->Errors->Count());
        $errors = ($errors || $this->audit_string->Errors->Count());
        $errors = ($errors || $this->tipo_persona_id->Errors->Count());
        $errors = ($errors || $this->persona_parcela_f_int->Errors->Count());
        $errors = ($errors || $this->DatePicker_persona_parcela_f_int1->Errors->Count());
        $errors = ($errors || $this->persona_id->Errors->Count());
        $errors = ($errors || $this->persona_nombre->Errors->Count());
        $errors = ($errors || $this->persona_apellido->Errors->Count());
        $errors = ($errors || $this->persona_conyuge->Errors->Count());
        $errors = ($errors || $this->persona_parcela_num_int->Errors->Count());
        $errors = ($errors || $this->tipo_instrumento_id->Errors->Count());
        $errors = ($errors || $this->tipo_perso_jur_id->Errors->Count());
        $errors = ($errors || $this->persona_relacionada->Errors->Count());
        $errors = ($errors || $this->tipo_estado_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @189-ED598703
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

//Operation Method @189-753C04A1
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        $this->DataSource->Prepare();
        if(!$this->FormSubmitted) {
            $this->EditMode = $this->DataSource->AllParametersSet;
            return;
        }

        if($this->FormSubmitted) {
            $this->PressedButton = $this->EditMode ? "Button_Update" : "Button_Cancel";
            if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            } else if($this->editar->Pressed) {
                $this->PressedButton = "editar";
            } else if($this->eliminar->Pressed) {
                $this->PressedButton = "eliminar";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Cancel") {
            $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "persona_id", "persona_parcela_id", "personas", "direcciones", "direccion_id", "add", "persona_relacionada_id"));
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "editar") {
            $Redirect = "EditPersona.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
            if(!CCGetEvent($this->editar->CCSEvents, "OnClick", $this->editar)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "eliminar") {
            $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "persona_id", "personas", "persona_parcela_id"));
            if(!CCGetEvent($this->eliminar->CCSEvents, "OnClick", $this->eliminar)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Update" && $this->UpdateAllowed) {
                $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "persona_relacionada_id"));
                if(!CCGetEvent($this->Button_Update->CCSEvents, "OnClick", $this->Button_Update) || !$this->UpdateRow()) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//UpdateRow Method @189-9C3AA3F6
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->persona_parcela_origen->SetValue($this->persona_parcela_origen->GetValue(true));
        $this->DataSource->persona_parcela_dominio->SetValue($this->persona_parcela_dominio->GetValue(true));
        $this->DataSource->tipo_persona_parcela_id->SetValue($this->tipo_persona_parcela_id->GetValue(true));
        $this->DataSource->persona_parcela_f_pro->SetValue($this->persona_parcela_f_pro->GetValue(true));
        $this->DataSource->audit_string->SetValue($this->audit_string->GetValue(true));
        $this->DataSource->persona_parcela_num_int->SetValue($this->persona_parcela_num_int->GetValue(true));
        $this->DataSource->tipo_instrumento_id->SetValue($this->tipo_instrumento_id->GetValue(true));
        $this->DataSource->persona_parcela_f_int->SetValue($this->persona_parcela_f_int->GetValue(true));
        $this->DataSource->persona_id->SetValue($this->persona_id->GetValue(true));
        $this->DataSource->tipo_estado_id->SetValue($this->tipo_estado_id->GetValue(true));
        $this->DataSource->tipo_persona_id->SetValue($this->tipo_persona_id->GetValue(true));
        $this->DataSource->tipo_perso_jur_id->SetValue($this->tipo_perso_jur_id->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @189-EBD13AE5
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

        $this->tipo_documento_id->Prepare();
        $this->pais_id->Prepare();
        $this->tipo_persona_parcela_id->Prepare();
        $this->tipo_persona_id->Prepare();
        $this->tipo_instrumento_id->Prepare();
        $this->tipo_perso_jur_id->Prepare();
        $this->tipo_estado_id->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if($this->EditMode) {
            if($this->DataSource->Errors->Count()){
                $this->Errors->AddErrors($this->DataSource->Errors);
                $this->DataSource->Errors->clear();
            }
            $this->DataSource->Open();
            if($this->DataSource->Errors->Count() == 0 && $this->DataSource->next_record()) {
                $this->DataSource->SetValues();
                if(!$this->FormSubmitted){
                    $this->persona_nro_doc->SetValue($this->DataSource->persona_nro_doc->GetValue());
                    $this->persona_fecha_nac->SetValue($this->DataSource->persona_fecha_nac->GetValue());
                    $this->persona_tel_movil->SetValue($this->DataSource->persona_tel_movil->GetValue());
                    $this->persona_cuit->SetValue($this->DataSource->persona_cuit->GetValue());
                    $this->tipo_documento_id->SetValue($this->DataSource->tipo_documento_id->GetValue());
                    $this->pais_id->SetValue($this->DataSource->pais_id->GetValue());
                    $this->persona_email->SetValue($this->DataSource->persona_email->GetValue());
                    $this->persona_parcela_origen->SetValue($this->DataSource->persona_parcela_origen->GetValue());
                    $this->persona_parcela_dominio->SetValue($this->DataSource->persona_parcela_dominio->GetValue());
                    $this->tipo_persona_parcela_id->SetValue($this->DataSource->tipo_persona_parcela_id->GetValue());
                    $this->persona_parcela_f_pro->SetValue($this->DataSource->persona_parcela_f_pro->GetValue());
                    $this->audit_string->SetValue($this->DataSource->audit_string->GetValue());
                    $this->tipo_persona_id->SetValue($this->DataSource->tipo_persona_id->GetValue());
                    $this->persona_parcela_f_int->SetValue($this->DataSource->persona_parcela_f_int->GetValue());
                    $this->persona_id->SetValue($this->DataSource->persona_id->GetValue());
                    $this->persona_nombre->SetValue($this->DataSource->persona_nombre->GetValue());
                    $this->persona_apellido->SetValue($this->DataSource->persona_apellido->GetValue());
                    $this->persona_conyuge->SetValue($this->DataSource->persona_conyuge->GetValue());
                    $this->persona_parcela_num_int->SetValue($this->DataSource->persona_parcela_num_int->GetValue());
                    $this->tipo_instrumento_id->SetValue($this->DataSource->tipo_instrumento_id->GetValue());
                    $this->tipo_perso_jur_id->SetValue($this->DataSource->tipo_perso_jur_id->GetValue());
                    $this->tipo_estado_id->SetValue($this->DataSource->tipo_estado_id->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->persona_nro_doc->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_denominacion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_fecha_nac->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_tel_movil->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_cuit->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_documento_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->pais_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_email->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_parcela_origen->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_parcela_dominio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_persona_parcela_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_parcela_f_pro->Errors->ToString());
            $Error = ComposeStrings($Error, $this->audit_string->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_persona_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_parcela_f_int->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_persona_parcela_f_int1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_nombre->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_apellido->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_conyuge->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_parcela_num_int->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_instrumento_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_perso_jur_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_relacionada->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_estado_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DataSource->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);
        $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Update->Show();
        $this->Button_Cancel->Show();
        $this->persona_nro_doc->Show();
        $this->persona_denominacion->Show();
        $this->persona_fecha_nac->Show();
        $this->persona_tel_movil->Show();
        $this->persona_cuit->Show();
        $this->tipo_documento_id->Show();
        $this->pais_id->Show();
        $this->persona_email->Show();
        $this->persona_parcela_origen->Show();
        $this->persona_parcela_dominio->Show();
        $this->tipo_persona_parcela_id->Show();
        $this->persona->Show();
        $this->persona_parcela_f_pro->Show();
        $this->audit_string->Show();
        $this->tipo_persona_id->Show();
        $this->editar->Show();
        $this->persona_parcela_f_int->Show();
        $this->DatePicker_persona_parcela_f_int1->Show();
        $this->persona_id->Show();
        $this->persona_nombre->Show();
        $this->persona_apellido->Show();
        $this->persona_conyuge->Show();
        $this->persona_parcela_num_int->Show();
        $this->tipo_instrumento_id->Show();
        $this->tipo_perso_jur_id->Show();
        $this->persona_relacionada->Show();
        $this->tipo_estado_id->Show();
        $this->eliminar->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End personas Class @189-FCB6E20C

class clspersonasDataSource extends clsDBtdf_nuevo {  //personasDataSource Class @189-9C37F6CB

//DataSource Variables @189-37410E26
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $UpdateParameters;
    public $wp;
    public $AllParametersSet;

    public $UpdateFields = array();

    // Datasource fields
    public $persona_nro_doc;
    public $persona_denominacion;
    public $persona_fecha_nac;
    public $persona_tel_movil;
    public $persona_cuit;
    public $tipo_documento_id;
    public $pais_id;
    public $persona_email;
    public $persona_parcela_origen;
    public $persona_parcela_dominio;
    public $tipo_persona_parcela_id;
    public $persona;
    public $persona_parcela_f_pro;
    public $audit_string;
    public $tipo_persona_id;
    public $persona_parcela_f_int;
    public $persona_id;
    public $persona_nombre;
    public $persona_apellido;
    public $persona_conyuge;
    public $persona_parcela_num_int;
    public $tipo_instrumento_id;
    public $tipo_perso_jur_id;
    public $persona_relacionada;
    public $tipo_estado_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @189-20EE2A7E
    function clspersonasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record personas/Error";
        $this->Initialize();
        $this->persona_nro_doc = new clsField("persona_nro_doc", ccsInteger, "");
        
        $this->persona_denominacion = new clsField("persona_denominacion", ccsText, "");
        
        $this->persona_fecha_nac = new clsField("persona_fecha_nac", ccsDate, $this->DateFormat);
        
        $this->persona_tel_movil = new clsField("persona_tel_movil", ccsText, "");
        
        $this->persona_cuit = new clsField("persona_cuit", ccsText, "");
        
        $this->tipo_documento_id = new clsField("tipo_documento_id", ccsInteger, "");
        
        $this->pais_id = new clsField("pais_id", ccsInteger, "");
        
        $this->persona_email = new clsField("persona_email", ccsText, "");
        
        $this->persona_parcela_origen = new clsField("persona_parcela_origen", ccsText, "");
        
        $this->persona_parcela_dominio = new clsField("persona_parcela_dominio", ccsFloat, "");
        
        $this->tipo_persona_parcela_id = new clsField("tipo_persona_parcela_id", ccsInteger, "");
        
        $this->persona = new clsField("persona", ccsText, "");
        
        $this->persona_parcela_f_pro = new clsField("persona_parcela_f_pro", ccsText, "");
        
        $this->audit_string = new clsField("audit_string", ccsText, "");
        
        $this->tipo_persona_id = new clsField("tipo_persona_id", ccsText, "");
        
        $this->persona_parcela_f_int = new clsField("persona_parcela_f_int", ccsDate, $this->DateFormat);
        
        $this->persona_id = new clsField("persona_id", ccsText, "");
        
        $this->persona_nombre = new clsField("persona_nombre", ccsText, "");
        
        $this->persona_apellido = new clsField("persona_apellido", ccsText, "");
        
        $this->persona_conyuge = new clsField("persona_conyuge", ccsText, "");
        
        $this->persona_parcela_num_int = new clsField("persona_parcela_num_int", ccsText, "");
        
        $this->tipo_instrumento_id = new clsField("tipo_instrumento_id", ccsInteger, "");
        
        $this->tipo_perso_jur_id = new clsField("tipo_perso_jur_id", ccsText, "");
        
        $this->persona_relacionada = new clsField("persona_relacionada", ccsText, "");
        
        $this->tipo_estado_id = new clsField("tipo_estado_id", ccsInteger, "");
        

        $this->UpdateFields["persona_parcela_origen"] = array("Name" => "persona_parcela_origen", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["persona_parcela_dominio"] = array("Name" => "persona_parcela_dominio", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_persona_parcela_id"] = array("Name" => "tipo_persona_parcela_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["persona_parcela_f_pro"] = array("Name" => "persona_parcela_f_pro", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["audit_string"] = array("Name" => "audit_string", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["persona_parcela_num_int"] = array("Name" => "persona_parcela_num_int", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_instrumento_id"] = array("Name" => "tipo_instrumento_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["persona_parcela_f_int"] = array("Name" => "persona_parcela_f_int", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["personas_parcelas.persona_id"] = array("Name" => "persona_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["personas_parcelas.tipo_estado_id"] = array("Name" => "tipo_estado_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_persona_id"] = array("Name" => "tipo_persona_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_perso_jur_id"] = array("Name" => "tipo_perso_jur_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @189-208BB000
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlpersona_parcela_id", ccsInteger, "", "", $this->Parameters["urlpersona_parcela_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "personas_parcelas.persona_parcela_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @189-C049056A
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM personas_parcelas INNER JOIN personas ON\n\n" .
        "personas_parcelas.persona_id = personas.persona_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @189-6568CAA8
    function SetValues()
    {
        $this->persona_nro_doc->SetDBValue(trim($this->f("persona_nro_doc")));
        $this->persona_fecha_nac->SetDBValue(trim($this->f("persona_fecha_nac")));
        $this->persona_tel_movil->SetDBValue($this->f("persona_tel_movil"));
        $this->persona_cuit->SetDBValue($this->f("persona_cuit"));
        $this->tipo_documento_id->SetDBValue(trim($this->f("tipo_documento_id")));
        $this->pais_id->SetDBValue(trim($this->f("pais_id")));
        $this->persona_email->SetDBValue($this->f("persona_email"));
        $this->persona_parcela_origen->SetDBValue($this->f("persona_parcela_origen"));
        $this->persona_parcela_dominio->SetDBValue(trim($this->f("persona_parcela_dominio")));
        $this->tipo_persona_parcela_id->SetDBValue(trim($this->f("tipo_persona_parcela_id")));
        $this->persona_parcela_f_pro->SetDBValue($this->f("persona_parcela_f_pro"));
        $this->audit_string->SetDBValue($this->f("audit_string"));
        $this->tipo_persona_id->SetDBValue($this->f("tipo_persona_id"));
        $this->persona_parcela_f_int->SetDBValue(trim($this->f("persona_parcela_f_int")));
        $this->persona_id->SetDBValue($this->f("persona_id"));
        $this->persona_nombre->SetDBValue($this->f("persona_nombre"));
        $this->persona_apellido->SetDBValue($this->f("persona_apellido"));
        $this->persona_conyuge->SetDBValue($this->f("persona_conyuge"));
        $this->persona_parcela_num_int->SetDBValue($this->f("persona_parcela_num_int"));
        $this->tipo_instrumento_id->SetDBValue(trim($this->f("tipo_instrumento_id")));
        $this->tipo_perso_jur_id->SetDBValue($this->f("tipo_perso_jur_id"));
        $this->tipo_estado_id->SetDBValue(trim($this->f("tipo_estado_id")));
    }
//End SetValues Method

//Update Method @189-0C14CD70
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["persona_parcela_origen"] = new clsSQLParameter("ctrlpersona_parcela_origen", ccsText, "", "", $this->persona_parcela_origen->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["persona_parcela_dominio"] = new clsSQLParameter("ctrlpersona_parcela_dominio", ccsFloat, "", "", $this->persona_parcela_dominio->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_persona_parcela_id"] = new clsSQLParameter("ctrltipo_persona_parcela_id", ccsInteger, "", "", $this->tipo_persona_parcela_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["persona_parcela_f_pro"] = new clsSQLParameter("ctrlpersona_parcela_f_pro", ccsText, "", "", $this->persona_parcela_f_pro->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["audit_string"] = new clsSQLParameter("ctrlaudit_string", ccsText, "", "", $this->audit_string->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["persona_parcela_num_int"] = new clsSQLParameter("ctrlpersona_parcela_num_int", ccsText, "", "", $this->persona_parcela_num_int->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_instrumento_id"] = new clsSQLParameter("ctrltipo_instrumento_id", ccsInteger, "", "", $this->tipo_instrumento_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["persona_parcela_f_int"] = new clsSQLParameter("ctrlpersona_parcela_f_int", ccsDate, array("dd", "/", "mm", "/", "yyyy"), $this->DateFormat, $this->persona_parcela_f_int->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["personas_parcelas.persona_id"] = new clsSQLParameter("ctrlpersona_id", ccsText, "", "", $this->persona_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["personas_parcelas.tipo_estado_id"] = new clsSQLParameter("ctrltipo_estado_id", ccsText, "", "", $this->tipo_estado_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_persona_id"] = new clsSQLParameter("ctrltipo_persona_id", ccsText, "", "", $this->tipo_persona_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_perso_jur_id"] = new clsSQLParameter("ctrltipo_perso_jur_id", ccsText, "", "", $this->tipo_perso_jur_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $wp = new clsSQLParameters($this->ErrorBlock);
        $wp->AddParameter("1", "urlpersona_parcela_id", ccsInteger, "", "", CCGetFromGet("persona_parcela_id", NULL), "", false);
        if(!$wp->AllParamsSet()) {
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        if (!is_null($this->cp["persona_parcela_origen"]->GetValue()) and !strlen($this->cp["persona_parcela_origen"]->GetText()) and !is_bool($this->cp["persona_parcela_origen"]->GetValue())) 
            $this->cp["persona_parcela_origen"]->SetValue($this->persona_parcela_origen->GetValue(true));
        if (!is_null($this->cp["persona_parcela_dominio"]->GetValue()) and !strlen($this->cp["persona_parcela_dominio"]->GetText()) and !is_bool($this->cp["persona_parcela_dominio"]->GetValue())) 
            $this->cp["persona_parcela_dominio"]->SetValue($this->persona_parcela_dominio->GetValue(true));
        if (!is_null($this->cp["tipo_persona_parcela_id"]->GetValue()) and !strlen($this->cp["tipo_persona_parcela_id"]->GetText()) and !is_bool($this->cp["tipo_persona_parcela_id"]->GetValue())) 
            $this->cp["tipo_persona_parcela_id"]->SetValue($this->tipo_persona_parcela_id->GetValue(true));
        if (!is_null($this->cp["persona_parcela_f_pro"]->GetValue()) and !strlen($this->cp["persona_parcela_f_pro"]->GetText()) and !is_bool($this->cp["persona_parcela_f_pro"]->GetValue())) 
            $this->cp["persona_parcela_f_pro"]->SetValue($this->persona_parcela_f_pro->GetValue(true));
        if (!is_null($this->cp["audit_string"]->GetValue()) and !strlen($this->cp["audit_string"]->GetText()) and !is_bool($this->cp["audit_string"]->GetValue())) 
            $this->cp["audit_string"]->SetValue($this->audit_string->GetValue(true));
        if (!is_null($this->cp["persona_parcela_num_int"]->GetValue()) and !strlen($this->cp["persona_parcela_num_int"]->GetText()) and !is_bool($this->cp["persona_parcela_num_int"]->GetValue())) 
            $this->cp["persona_parcela_num_int"]->SetValue($this->persona_parcela_num_int->GetValue(true));
        if (!is_null($this->cp["tipo_instrumento_id"]->GetValue()) and !strlen($this->cp["tipo_instrumento_id"]->GetText()) and !is_bool($this->cp["tipo_instrumento_id"]->GetValue())) 
            $this->cp["tipo_instrumento_id"]->SetValue($this->tipo_instrumento_id->GetValue(true));
        if (!is_null($this->cp["persona_parcela_f_int"]->GetValue()) and !strlen($this->cp["persona_parcela_f_int"]->GetText()) and !is_bool($this->cp["persona_parcela_f_int"]->GetValue())) 
            $this->cp["persona_parcela_f_int"]->SetValue($this->persona_parcela_f_int->GetValue(true));
        if (!is_null($this->cp["personas_parcelas.persona_id"]->GetValue()) and !strlen($this->cp["personas_parcelas.persona_id"]->GetText()) and !is_bool($this->cp["personas_parcelas.persona_id"]->GetValue())) 
            $this->cp["personas_parcelas.persona_id"]->SetValue($this->persona_id->GetValue(true));
        if (!is_null($this->cp["personas_parcelas.tipo_estado_id"]->GetValue()) and !strlen($this->cp["personas_parcelas.tipo_estado_id"]->GetText()) and !is_bool($this->cp["personas_parcelas.tipo_estado_id"]->GetValue())) 
            $this->cp["personas_parcelas.tipo_estado_id"]->SetValue($this->tipo_estado_id->GetValue(true));
        if (!is_null($this->cp["tipo_persona_id"]->GetValue()) and !strlen($this->cp["tipo_persona_id"]->GetText()) and !is_bool($this->cp["tipo_persona_id"]->GetValue())) 
            $this->cp["tipo_persona_id"]->SetValue($this->tipo_persona_id->GetValue(true));
        if (!is_null($this->cp["tipo_perso_jur_id"]->GetValue()) and !strlen($this->cp["tipo_perso_jur_id"]->GetText()) and !is_bool($this->cp["tipo_perso_jur_id"]->GetValue())) 
            $this->cp["tipo_perso_jur_id"]->SetValue($this->tipo_perso_jur_id->GetValue(true));
        $wp->Criterion[1] = $wp->Operation(opEqual, "persona_parcela_id", $wp->GetDBValue("1"), $this->ToSQL($wp->GetDBValue("1"), ccsInteger),false);
        $Where = 
             $wp->Criterion[1];
        $this->UpdateFields["persona_parcela_origen"]["Value"] = $this->cp["persona_parcela_origen"]->GetDBValue(true);
        $this->UpdateFields["persona_parcela_dominio"]["Value"] = $this->cp["persona_parcela_dominio"]->GetDBValue(true);
        $this->UpdateFields["tipo_persona_parcela_id"]["Value"] = $this->cp["tipo_persona_parcela_id"]->GetDBValue(true);
        $this->UpdateFields["persona_parcela_f_pro"]["Value"] = $this->cp["persona_parcela_f_pro"]->GetDBValue(true);
        $this->UpdateFields["audit_string"]["Value"] = $this->cp["audit_string"]->GetDBValue(true);
        $this->UpdateFields["persona_parcela_num_int"]["Value"] = $this->cp["persona_parcela_num_int"]->GetDBValue(true);
        $this->UpdateFields["tipo_instrumento_id"]["Value"] = $this->cp["tipo_instrumento_id"]->GetDBValue(true);
        $this->UpdateFields["persona_parcela_f_int"]["Value"] = $this->cp["persona_parcela_f_int"]->GetDBValue(true);
        $this->UpdateFields["personas_parcelas.persona_id"]["Value"] = $this->cp["personas_parcelas.persona_id"]->GetDBValue(true);
        $this->UpdateFields["personas_parcelas.tipo_estado_id"]["Value"] = $this->cp["personas_parcelas.tipo_estado_id"]->GetDBValue(true);
        $this->UpdateFields["tipo_persona_id"]["Value"] = $this->cp["tipo_persona_id"]->GetDBValue(true);
        $this->UpdateFields["tipo_perso_jur_id"]["Value"] = $this->cp["tipo_perso_jur_id"]->GetDBValue(true);
        $this->SQL = CCBuildUpdate("personas_parcelas", $this->UpdateFields, $this);
        $this->SQL .= strlen($Where) ? " WHERE " . $Where : $Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

} //End personasDataSource Class @189-FCB6E20C

class clsEditableGriddomicilios { //domicilios Class @243-DCFEC820

//Variables @243-F9538F3C

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

//Class_Initialize Event @243-076A0B3F
    function clsEditableGriddomicilios($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid domicilios/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "domicilios";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["calle_id"][0] = "calle_id";
        $this->CachedColumns["departamento_id"][0] = "departamento_id";
        $this->CachedColumns["direccion_id"][0] = "direccion_id";
        $this->CachedColumns["localidad_id"][0] = "localidad_id";
        $this->CachedColumns["tipo_direccion_id"][0] = "tipo_direccion_id";
        $this->CachedColumns["barrio_id"][0] = "barrio_id";
        $this->CachedColumns["provincia_id"][0] = "provincia_id";
        $this->CachedColumns["dpto_id"][0] = "dpto_id";
        $this->DataSource = new clsdomiciliosDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = 20;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: EditableGrid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->EmptyRows = 1;
        $this->ReadAllowed = true;
        $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
        if(!$this->Visible) return;

        $this->ReadAllowed = $this->ReadAllowed && CCUserInGroups(CCGetGroupID(), "1;2");
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

        $this->barrios_barrio_nombre = new clsControl(ccsLabel, "barrios_barrio_nombre", "barrios_barrio_nombre", ccsText, "", NULL, $this);
        $this->direccion_piso = new clsControl(ccsLabel, "direccion_piso", "direccion_piso", ccsText, "", NULL, $this);
        $this->direccion_depto = new clsControl(ccsLabel, "direccion_depto", "direccion_depto", ccsText, "", NULL, $this);
        $this->calles_calle_nombre = new clsControl(ccsLabel, "calles_calle_nombre", "calles_calle_nombre", ccsText, "", NULL, $this);
        $this->tipo_direccion_descrip = new clsControl(ccsLabel, "tipo_direccion_descrip", "tipo_direccion_descrip", ccsText, "", NULL, $this);
        $this->direccion_numeracion = new clsControl(ccsLabel, "direccion_numeracion", "direccion_numeracion", ccsText, "", NULL, $this);
        $this->direccion_manzana = new clsControl(ccsLabel, "direccion_manzana", "direccion_manzana", ccsText, "", NULL, $this);
        $this->direccion_casa = new clsControl(ccsLabel, "direccion_casa", "direccion_casa", ccsText, "", NULL, $this);
        $this->localidades_localidad_nombre = new clsControl(ccsLabel, "localidades_localidad_nombre", "localidades_localidad_nombre", ccsText, "", NULL, $this);
        $this->departamentos_departamento_nombre = new clsControl(ccsLabel, "departamentos_departamento_nombre", "departamentos_departamento_nombre", ccsText, "", NULL, $this);
        $this->provincias_provincia_nombre = new clsControl(ccsLabel, "provincias_provincia_nombre", "provincias_provincia_nombre", ccsText, "", NULL, $this);
        $this->persona = new clsControl(ccsLabel, "persona", "persona", ccsText, "", NULL, $this);
        $this->ImageLink1 = new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", NULL, $this);
        $this->ImageLink1->Page = "";
        $this->Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", NULL, $this);
        $this->panel = new clsPanel("panel", $this);
        $this->addDp = new clsControl(ccsImageLink, "addDp", "addDp", ccsText, "", NULL, $this);
        $this->addDp->Page = "";
        $this->salir = new clsButton("salir", $Method, $this);
        $this->panel->AddComponent("addDp", $this->addDp);
    }
//End Class_Initialize Event

//Initialize Method @243-20A902B3
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["urlpersona_id"] = CCGetFromGet("persona_id", NULL);
    }
//End Initialize Method

//SetPrimaryKeys Method @243-EBC3F86C
    function SetPrimaryKeys($PrimaryKeys) {
        $this->PrimaryKeys = $PrimaryKeys;
        return $this->PrimaryKeys;
    }
//End SetPrimaryKeys Method

//GetPrimaryKeys Method @243-74F9A772
    function GetPrimaryKeys() {
        return $this->PrimaryKeys;
    }
//End GetPrimaryKeys Method

//GetFormParameters Method @243-097BD644
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
        }
    }
//End GetFormParameters Method

//Validate Method @243-0B8E544B
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["calle_id"] = $this->CachedColumns["calle_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["departamento_id"] = $this->CachedColumns["departamento_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["direccion_id"] = $this->CachedColumns["direccion_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["localidad_id"] = $this->CachedColumns["localidad_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_direccion_id"] = $this->CachedColumns["tipo_direccion_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["barrio_id"] = $this->CachedColumns["barrio_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["provincia_id"] = $this->CachedColumns["provincia_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["dpto_id"] = $this->CachedColumns["dpto_id"][$this->RowNumber];
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

//ValidateRow Method @243-BEFC2A36
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

//CheckInsert Method @243-FC0A7F41
    function CheckInsert()
    {
        $filed = false;
        return $filed;
    }
//End CheckInsert Method

//CheckErrors Method @243-F5A3B433
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @243-8F9C2742
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
        $this->PressedButton = "";
        if($this->salir->Pressed) {
            $this->PressedButton = "salir";
        }

        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "salir") {
            if(!CCGetEvent($this->salir->CCSEvents, "OnClick", $this->salir)) {
                $Redirect = "";
            } else {
                $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "direcciones", "persona_id"));
            }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//UpdateGrid Method @243-A460DC2C
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["calle_id"] = $this->CachedColumns["calle_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["departamento_id"] = $this->CachedColumns["departamento_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["direccion_id"] = $this->CachedColumns["direccion_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["localidad_id"] = $this->CachedColumns["localidad_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_direccion_id"] = $this->CachedColumns["tipo_direccion_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["barrio_id"] = $this->CachedColumns["barrio_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["provincia_id"] = $this->CachedColumns["provincia_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["dpto_id"] = $this->CachedColumns["dpto_id"][$this->RowNumber];
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

//FormScript Method @243-59800DB5
    function FormScript($TotalRows)
    {
        $script = "";
        return $script;
    }
//End FormScript Method

//SetFormState Method @243-7B10FA98
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
            for($i = 2; $i < sizeof($pieces); $i = $i + 8)  {
                $piece = $pieces[$i + 0];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["calle_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 1];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["departamento_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 2];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["direccion_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 3];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["localidad_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 4];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["tipo_direccion_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 5];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["barrio_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 6];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["provincia_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 7];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["dpto_id"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["calle_id"][$RowNumber] = "";
                $this->CachedColumns["departamento_id"][$RowNumber] = "";
                $this->CachedColumns["direccion_id"][$RowNumber] = "";
                $this->CachedColumns["localidad_id"][$RowNumber] = "";
                $this->CachedColumns["tipo_direccion_id"][$RowNumber] = "";
                $this->CachedColumns["barrio_id"][$RowNumber] = "";
                $this->CachedColumns["provincia_id"][$RowNumber] = "";
                $this->CachedColumns["dpto_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @243-636D6FD9
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["calle_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["departamento_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["direccion_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["localidad_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["tipo_direccion_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["barrio_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["provincia_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["dpto_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @243-F5585A64
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
        $this->ControlsVisible["barrios_barrio_nombre"] = $this->barrios_barrio_nombre->Visible;
        $this->ControlsVisible["direccion_piso"] = $this->direccion_piso->Visible;
        $this->ControlsVisible["direccion_depto"] = $this->direccion_depto->Visible;
        $this->ControlsVisible["calles_calle_nombre"] = $this->calles_calle_nombre->Visible;
        $this->ControlsVisible["tipo_direccion_descrip"] = $this->tipo_direccion_descrip->Visible;
        $this->ControlsVisible["direccion_numeracion"] = $this->direccion_numeracion->Visible;
        $this->ControlsVisible["direccion_manzana"] = $this->direccion_manzana->Visible;
        $this->ControlsVisible["direccion_casa"] = $this->direccion_casa->Visible;
        $this->ControlsVisible["localidades_localidad_nombre"] = $this->localidades_localidad_nombre->Visible;
        $this->ControlsVisible["departamentos_departamento_nombre"] = $this->departamentos_departamento_nombre->Visible;
        $this->ControlsVisible["provincias_provincia_nombre"] = $this->provincias_provincia_nombre->Visible;
        $this->ControlsVisible["ImageLink1"] = $this->ImageLink1->Visible;
        if ($is_next_record || ($EmptyRowsLeft && $this->InsertAllowed)) {
            do {
                $this->RowNumber++;
                if($is_next_record) {
                    $NonEmptyRows++;
                    $this->DataSource->SetValues();
                }
                if (!($this->FormSubmitted) && $is_next_record) {
                    $this->CachedColumns["calle_id"][$this->RowNumber] = $this->DataSource->CachedColumns["calle_id"];
                    $this->CachedColumns["departamento_id"][$this->RowNumber] = $this->DataSource->CachedColumns["departamento_id"];
                    $this->CachedColumns["direccion_id"][$this->RowNumber] = $this->DataSource->CachedColumns["direccion_id"];
                    $this->CachedColumns["localidad_id"][$this->RowNumber] = $this->DataSource->CachedColumns["localidad_id"];
                    $this->CachedColumns["tipo_direccion_id"][$this->RowNumber] = $this->DataSource->CachedColumns["tipo_direccion_id"];
                    $this->CachedColumns["barrio_id"][$this->RowNumber] = $this->DataSource->CachedColumns["barrio_id"];
                    $this->CachedColumns["provincia_id"][$this->RowNumber] = $this->DataSource->CachedColumns["provincia_id"];
                    $this->CachedColumns["dpto_id"][$this->RowNumber] = $this->DataSource->CachedColumns["dpto_id"];
                    $this->ImageLink1->SetText("");
                    $this->barrios_barrio_nombre->SetValue($this->DataSource->barrios_barrio_nombre->GetValue());
                    $this->direccion_piso->SetValue($this->DataSource->direccion_piso->GetValue());
                    $this->direccion_depto->SetValue($this->DataSource->direccion_depto->GetValue());
                    $this->calles_calle_nombre->SetValue($this->DataSource->calles_calle_nombre->GetValue());
                    $this->tipo_direccion_descrip->SetValue($this->DataSource->tipo_direccion_descrip->GetValue());
                    $this->direccion_numeracion->SetValue($this->DataSource->direccion_numeracion->GetValue());
                    $this->direccion_manzana->SetValue($this->DataSource->direccion_manzana->GetValue());
                    $this->direccion_casa->SetValue($this->DataSource->direccion_casa->GetValue());
                    $this->localidades_localidad_nombre->SetValue($this->DataSource->localidades_localidad_nombre->GetValue());
                    $this->departamentos_departamento_nombre->SetValue($this->DataSource->departamentos_departamento_nombre->GetValue());
                    $this->provincias_provincia_nombre->SetValue($this->DataSource->provincias_provincia_nombre->GetValue());
                    $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                    $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "direccion_id", $this->DataSource->f("direccion_id"));
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->barrios_barrio_nombre->SetText("");
                    $this->direccion_piso->SetText("");
                    $this->direccion_depto->SetText("");
                    $this->calles_calle_nombre->SetText("");
                    $this->tipo_direccion_descrip->SetText("");
                    $this->direccion_numeracion->SetText("");
                    $this->direccion_manzana->SetText("");
                    $this->direccion_casa->SetText("");
                    $this->localidades_localidad_nombre->SetText("");
                    $this->departamentos_departamento_nombre->SetText("");
                    $this->provincias_provincia_nombre->SetText("");
                    $this->ImageLink1->SetText("");
                    $this->barrios_barrio_nombre->SetValue($this->DataSource->barrios_barrio_nombre->GetValue());
                    $this->direccion_piso->SetValue($this->DataSource->direccion_piso->GetValue());
                    $this->direccion_depto->SetValue($this->DataSource->direccion_depto->GetValue());
                    $this->calles_calle_nombre->SetValue($this->DataSource->calles_calle_nombre->GetValue());
                    $this->tipo_direccion_descrip->SetValue($this->DataSource->tipo_direccion_descrip->GetValue());
                    $this->direccion_numeracion->SetValue($this->DataSource->direccion_numeracion->GetValue());
                    $this->direccion_manzana->SetValue($this->DataSource->direccion_manzana->GetValue());
                    $this->direccion_casa->SetValue($this->DataSource->direccion_casa->GetValue());
                    $this->localidades_localidad_nombre->SetValue($this->DataSource->localidades_localidad_nombre->GetValue());
                    $this->departamentos_departamento_nombre->SetValue($this->DataSource->departamentos_departamento_nombre->GetValue());
                    $this->provincias_provincia_nombre->SetValue($this->DataSource->provincias_provincia_nombre->GetValue());
                    $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "direccion_id", $this->DataSource->f("direccion_id"));
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["calle_id"][$this->RowNumber] = "";
                    $this->CachedColumns["departamento_id"][$this->RowNumber] = "";
                    $this->CachedColumns["direccion_id"][$this->RowNumber] = "";
                    $this->CachedColumns["localidad_id"][$this->RowNumber] = "";
                    $this->CachedColumns["tipo_direccion_id"][$this->RowNumber] = "";
                    $this->CachedColumns["barrio_id"][$this->RowNumber] = "";
                    $this->CachedColumns["provincia_id"][$this->RowNumber] = "";
                    $this->CachedColumns["dpto_id"][$this->RowNumber] = "";
                    $this->barrios_barrio_nombre->SetText("");
                    $this->direccion_piso->SetText("");
                    $this->direccion_depto->SetText("");
                    $this->calles_calle_nombre->SetText("");
                    $this->tipo_direccion_descrip->SetText("");
                    $this->direccion_numeracion->SetText("");
                    $this->direccion_manzana->SetText("");
                    $this->direccion_casa->SetText("");
                    $this->localidades_localidad_nombre->SetText("");
                    $this->departamentos_departamento_nombre->SetText("");
                    $this->provincias_provincia_nombre->SetText("");
                    $this->ImageLink1->SetText("");
                    $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "direccion_id", $this->DataSource->f("direccion_id"));
                } else {
                    $this->barrios_barrio_nombre->SetText("");
                    $this->direccion_piso->SetText("");
                    $this->direccion_depto->SetText("");
                    $this->calles_calle_nombre->SetText("");
                    $this->tipo_direccion_descrip->SetText("");
                    $this->direccion_numeracion->SetText("");
                    $this->direccion_manzana->SetText("");
                    $this->direccion_casa->SetText("");
                    $this->localidades_localidad_nombre->SetText("");
                    $this->departamentos_departamento_nombre->SetText("");
                    $this->provincias_provincia_nombre->SetText("");
                    $this->ImageLink1->SetText("");
                    $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "direccion_id", $this->DataSource->f("direccion_id"));
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->barrios_barrio_nombre->Show($this->RowNumber);
                $this->direccion_piso->Show($this->RowNumber);
                $this->direccion_depto->Show($this->RowNumber);
                $this->calles_calle_nombre->Show($this->RowNumber);
                $this->tipo_direccion_descrip->Show($this->RowNumber);
                $this->direccion_numeracion->Show($this->RowNumber);
                $this->direccion_manzana->Show($this->RowNumber);
                $this->direccion_casa->Show($this->RowNumber);
                $this->localidades_localidad_nombre->Show($this->RowNumber);
                $this->departamentos_departamento_nombre->Show($this->RowNumber);
                $this->provincias_provincia_nombre->Show($this->RowNumber);
                $this->ImageLink1->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["calle_id"] == $this->CachedColumns["calle_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["departamento_id"] == $this->CachedColumns["departamento_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["direccion_id"] == $this->CachedColumns["direccion_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["localidad_id"] == $this->CachedColumns["localidad_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["tipo_direccion_id"] == $this->CachedColumns["tipo_direccion_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["barrio_id"] == $this->CachedColumns["barrio_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["provincia_id"] == $this->CachedColumns["provincia_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["dpto_id"] == $this->CachedColumns["dpto_id"][$this->RowNumber])) {
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
        $this->addDp->Parameters = CCGetQueryString("QueryString", array("direccion_id", "ccsForm"));
        $this->addDp->Parameters = CCAddParam($this->addDp->Parameters, "add", 1);
        $this->persona->Show();
        $this->Label1->Show();
        $this->panel->Show();
        $this->salir->Show();

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

} //End domicilios Class @243-FCB6E20C

class clsdomiciliosDataSource extends clsDBtdf_nuevo {  //domiciliosDataSource Class @243-A491432B

//DataSource Variables @243-CD4CDF9E
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
    public $barrios_barrio_nombre;
    public $direccion_piso;
    public $direccion_depto;
    public $calles_calle_nombre;
    public $tipo_direccion_descrip;
    public $direccion_numeracion;
    public $direccion_manzana;
    public $direccion_casa;
    public $localidades_localidad_nombre;
    public $departamentos_departamento_nombre;
    public $provincias_provincia_nombre;
    public $ImageLink1;
//End DataSource Variables

//DataSourceClass_Initialize Event @243-2062AD0D
    function clsdomiciliosDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid domicilios/Error";
        $this->Initialize();
        $this->barrios_barrio_nombre = new clsField("barrios_barrio_nombre", ccsText, "");
        
        $this->direccion_piso = new clsField("direccion_piso", ccsText, "");
        
        $this->direccion_depto = new clsField("direccion_depto", ccsText, "");
        
        $this->calles_calle_nombre = new clsField("calles_calle_nombre", ccsText, "");
        
        $this->tipo_direccion_descrip = new clsField("tipo_direccion_descrip", ccsText, "");
        
        $this->direccion_numeracion = new clsField("direccion_numeracion", ccsText, "");
        
        $this->direccion_manzana = new clsField("direccion_manzana", ccsText, "");
        
        $this->direccion_casa = new clsField("direccion_casa", ccsText, "");
        
        $this->localidades_localidad_nombre = new clsField("localidades_localidad_nombre", ccsText, "");
        
        $this->departamentos_departamento_nombre = new clsField("departamentos_departamento_nombre", ccsText, "");
        
        $this->provincias_provincia_nombre = new clsField("provincias_provincia_nombre", ccsText, "");
        
        $this->ImageLink1 = new clsField("ImageLink1", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @243-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @243-47CE12C4
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlpersona_id", ccsInteger, "", "", $this->Parameters["urlpersona_id"], -1, false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "direcciones.persona_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @243-4D457A68
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (((((direcciones LEFT JOIN calles ON\n\n" .
        "direcciones.calle_id = calles.calle_id) LEFT JOIN localidades ON\n\n" .
        "direcciones.localidad_id = localidades.localidad_id) LEFT JOIN tipos_direcciones ON\n\n" .
        "direcciones.tipo_direccion_id = tipos_direcciones.tipo_direccion_id) LEFT JOIN barrios ON\n\n" .
        "direcciones.barrio_id = barrios.barrio_id) LEFT JOIN provincias ON\n\n" .
        "direcciones.provincia_id = provincias.provincia_id) LEFT JOIN departamentos ON\n\n" .
        "direcciones.departamento_id = departamentos.dpto_id";
        $this->SQL = "SELECT IFNULL(calles.calle_nombre,direcciones.calle_nombre) AS calles_calle_nombre, localidades.localidad_nombre AS localidades_localidad_nombre,\n\n" .
        "tipo_direccion_descrip, direccion_numeracion, barrios.barrio_nombre AS barrios_barrio_nombre, direccion_manzana, direccion_casa,\n\n" .
        "direccion_piso, direccion_depto, direccion_area, direccion_torre, direccion_lote, direccion_id, provincias.provincia_nombre AS provincias_provincia_nombre,\n\n" .
        "dpto_desc \n\n" .
        "FROM (((((direcciones LEFT JOIN calles ON\n\n" .
        "direcciones.calle_id = calles.calle_id) LEFT JOIN localidades ON\n\n" .
        "direcciones.localidad_id = localidades.localidad_id) LEFT JOIN tipos_direcciones ON\n\n" .
        "direcciones.tipo_direccion_id = tipos_direcciones.tipo_direccion_id) LEFT JOIN barrios ON\n\n" .
        "direcciones.barrio_id = barrios.barrio_id) LEFT JOIN provincias ON\n\n" .
        "direcciones.provincia_id = provincias.provincia_id) LEFT JOIN departamentos ON\n\n" .
        "direcciones.departamento_id = departamentos.dpto_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @243-236473FB
    function SetValues()
    {
        $this->CachedColumns["calle_id"] = $this->f("calle_id");
        $this->CachedColumns["departamento_id"] = $this->f("departamento_id");
        $this->CachedColumns["direccion_id"] = $this->f("direccion_id");
        $this->CachedColumns["localidad_id"] = $this->f("localidad_id");
        $this->CachedColumns["tipo_direccion_id"] = $this->f("tipo_direccion_id");
        $this->CachedColumns["barrio_id"] = $this->f("barrio_id");
        $this->CachedColumns["provincia_id"] = $this->f("provincia_id");
        $this->CachedColumns["dpto_id"] = $this->f("dpto_id");
        $this->barrios_barrio_nombre->SetDBValue($this->f("barrios_barrio_nombre"));
        $this->direccion_piso->SetDBValue($this->f("direccion_piso"));
        $this->direccion_depto->SetDBValue($this->f("direccion_depto"));
        $this->calles_calle_nombre->SetDBValue($this->f("calles_calle_nombre"));
        $this->tipo_direccion_descrip->SetDBValue($this->f("tipo_direccion_descrip"));
        $this->direccion_numeracion->SetDBValue($this->f("direccion_numeracion"));
        $this->direccion_manzana->SetDBValue($this->f("direccion_manzana"));
        $this->direccion_casa->SetDBValue($this->f("direccion_casa"));
        $this->localidades_localidad_nombre->SetDBValue($this->f("localidades_localidad_nombre"));
        $this->departamentos_departamento_nombre->SetDBValue($this->f("dpto_desc"));
        $this->provincias_provincia_nombre->SetDBValue($this->f("provincias_provincia_nombre"));
    }
//End SetValues Method

} //End domiciliosDataSource Class @243-FCB6E20C

class clsRecorddirecciones { //direcciones Class @326-B996BB24

//Variables @326-9E315808

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

//Class_Initialize Event @326-533DF7C2
    function clsRecorddirecciones($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record direcciones/Error";
        $this->DataSource = new clsdireccionesDataSource($this);
        $this->ds = & $this->DataSource;
        $this->ReadAllowed = true;
        $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
        if($this->Visible)
        {
            $this->ReadAllowed = $this->ReadAllowed && CCUserInGroups(CCGetGroupID(), "1;2");
            $this->InsertAllowed = CCUserInGroups(CCGetGroupID(), "2");
            $this->UpdateAllowed = CCUserInGroups(CCGetGroupID(), "2");
            $this->ComponentName = "direcciones";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->Button_Delete = new clsButton("Button_Delete", $Method, $this);
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->localidad_id = new clsControl(ccsListBox, "localidad_id", "Localidad", ccsInteger, "", CCGetRequestParam("localidad_id", $Method, NULL), $this);
            $this->localidad_id->DSType = dsTable;
            $this->localidad_id->DataSource = new clsDBtdf_nuevo();
            $this->localidad_id->ds = & $this->localidad_id->DataSource;
            $this->localidad_id->DataSource->SQL = "SELECT localidad_id, localidad_nombre \n" .
"FROM localidades {SQL_Where} {SQL_OrderBy}";
            $this->localidad_id->DataSource->Order = "localidad_nombre";
            list($this->localidad_id->BoundColumn, $this->localidad_id->TextColumn, $this->localidad_id->DBFormat) = array("localidad_id", "localidad_nombre", "");
            $this->localidad_id->DataSource->Order = "localidad_nombre";
            $this->barrio_id = new clsControl(ccsHidden, "barrio_id", "Barrio", ccsInteger, "", CCGetRequestParam("barrio_id", $Method, NULL), $this);
            $this->direccion_manzana = new clsControl(ccsTextBox, "direccion_manzana", "Direccion Manzana", ccsText, "", CCGetRequestParam("direccion_manzana", $Method, NULL), $this);
            $this->direccion_piso = new clsControl(ccsTextBox, "direccion_piso", "Direccion Piso", ccsInteger, "", CCGetRequestParam("direccion_piso", $Method, NULL), $this);
            $this->direccion_area = new clsControl(ccsTextBox, "direccion_area", "Direccion Area", ccsText, "", CCGetRequestParam("direccion_area", $Method, NULL), $this);
            $this->direccion_lote = new clsControl(ccsTextBox, "direccion_lote", "Direccion Lote", ccsText, "", CCGetRequestParam("direccion_lote", $Method, NULL), $this);
            $this->direccion_observ = new clsControl(ccsTextBox, "direccion_observ", "Direccion Observ", ccsText, "", CCGetRequestParam("direccion_observ", $Method, NULL), $this);
            $this->direccion_numeracion = new clsControl(ccsTextBox, "direccion_numeracion", "Direccion Numeracion", ccsInteger, "", CCGetRequestParam("direccion_numeracion", $Method, NULL), $this);
            $this->direccion_casa = new clsControl(ccsTextBox, "direccion_casa", "Direccion Casa", ccsText, "", CCGetRequestParam("direccion_casa", $Method, NULL), $this);
            $this->direccion_depto = new clsControl(ccsTextBox, "direccion_depto", "Direccion Depto", ccsText, "", CCGetRequestParam("direccion_depto", $Method, NULL), $this);
            $this->direccion_torre = new clsControl(ccsTextBox, "direccion_torre", "Direccion Torre", ccsText, "", CCGetRequestParam("direccion_torre", $Method, NULL), $this);
            $this->tipo_estado_id = new clsControl(ccsHidden, "tipo_estado_id", "Tipo Estado Id", ccsInteger, "", CCGetRequestParam("tipo_estado_id", $Method, NULL), $this);
            $this->accion = new clsControl(ccsLabel, "accion", "accion", ccsText, "", CCGetRequestParam("accion", $Method, NULL), $this);
            $this->extras = new clsPanel("extras", $this);
            $this->departamento_id = new clsControl(ccsListBox, "departamento_id", "Departamento", ccsInteger, "", CCGetRequestParam("departamento_id", $Method, NULL), $this);
            $this->departamento_id->DSType = dsTable;
            $this->departamento_id->DataSource = new clsDBtdf_nuevo();
            $this->departamento_id->ds = & $this->departamento_id->DataSource;
            $this->departamento_id->DataSource->SQL = "SELECT departamento_id, departamento_nombre \n" .
"FROM departamentos {SQL_Where} {SQL_OrderBy}";
            $this->departamento_id->DataSource->Order = "departamento_nombre";
            list($this->departamento_id->BoundColumn, $this->departamento_id->TextColumn, $this->departamento_id->DBFormat) = array("dpto_id", "dpto_desc", "");
            $this->departamento_id->DataSource->Order = "departamento_nombre";
            $this->provincia_id = new clsControl(ccsListBox, "provincia_id", "Provincia", ccsInteger, "", CCGetRequestParam("provincia_id", $Method, NULL), $this);
            $this->provincia_id->DSType = dsTable;
            $this->provincia_id->DataSource = new clsDBtdf_nuevo();
            $this->provincia_id->ds = & $this->provincia_id->DataSource;
            $this->provincia_id->DataSource->SQL = "SELECT provincia_nombre, provincia_id \n" .
"FROM provincias {SQL_Where} {SQL_OrderBy}";
            $this->provincia_id->DataSource->Order = "provincia_nombre";
            list($this->provincia_id->BoundColumn, $this->provincia_id->TextColumn, $this->provincia_id->DBFormat) = array("provincia_id", "provincia_nombre", "");
            $this->provincia_id->DataSource->Order = "provincia_nombre";
            $this->tipo_puerta_id = new clsControl(ccsListBox, "tipo_puerta_id", "tipo de puerta", ccsInteger, "", CCGetRequestParam("tipo_puerta_id", $Method, NULL), $this);
            $this->tipo_puerta_id->DSType = dsTable;
            $this->tipo_puerta_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_puerta_id->ds = & $this->tipo_puerta_id->DataSource;
            $this->tipo_puerta_id->DataSource->SQL = "SELECT tipo_puerta_id, tipo_puerta_descrip \n" .
"FROM tipos_puertas {SQL_Where} {SQL_OrderBy}";
            $this->tipo_puerta_id->DataSource->Order = "tipo_puerta_descrip";
            list($this->tipo_puerta_id->BoundColumn, $this->tipo_puerta_id->TextColumn, $this->tipo_puerta_id->DBFormat) = array("tipo_puerta_id", "tipo_puerta_descrip", "");
            $this->tipo_puerta_id->DataSource->Order = "tipo_puerta_descrip";
            $this->tipo_puerta_id->Required = true;
            $this->tipo_direccion_id = new clsControl(ccsListBox, "tipo_direccion_id", "tipo de direccion", ccsInteger, "", CCGetRequestParam("tipo_direccion_id", $Method, NULL), $this);
            $this->tipo_direccion_id->DSType = dsTable;
            $this->tipo_direccion_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_direccion_id->ds = & $this->tipo_direccion_id->DataSource;
            $this->tipo_direccion_id->DataSource->SQL = "SELECT tipo_direccion_id, tipo_direccion_descrip \n" .
"FROM tipos_direcciones {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_direccion_id->BoundColumn, $this->tipo_direccion_id->TextColumn, $this->tipo_direccion_id->DBFormat) = array("tipo_direccion_id", "tipo_direccion_descrip", "");
            $this->tipo_direccion_id->Required = true;
            $this->persona_id = new clsControl(ccsHidden, "persona_id", "persona_id", ccsInteger, "", CCGetRequestParam("persona_id", $Method, NULL), $this);
            $this->tipo_calle_id = new clsControl(ccsListBox, "tipo_calle_id", "Tipo Calle", ccsInteger, "", CCGetRequestParam("tipo_calle_id", $Method, NULL), $this);
            $this->tipo_calle_id->DSType = dsTable;
            $this->tipo_calle_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_calle_id->ds = & $this->tipo_calle_id->DataSource;
            $this->tipo_calle_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_calles {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_calle_id->BoundColumn, $this->tipo_calle_id->TextColumn, $this->tipo_calle_id->DBFormat) = array("tipo_calle_id", "tipo_calle_descrip", "");
            $this->tipo_calle_id->Required = true;
            $this->calle_id = new clsControl(ccsHidden, "calle_id", "calle_id", ccsText, "", CCGetRequestParam("calle_id", $Method, NULL), $this);
            $this->nombre_calle = new clsControl(ccsTextBox, "nombre_calle", "nombre_calle", ccsText, "", CCGetRequestParam("nombre_calle", $Method, NULL), $this);
            $this->nombre_barrio = new clsControl(ccsTextBox, "nombre_barrio", "nombre_barrio", ccsText, "", CCGetRequestParam("nombre_barrio", $Method, NULL), $this);
            $this->direccion_cp = new clsControl(ccsTextBox, "direccion_cp", "direccion_cp", ccsText, "", CCGetRequestParam("direccion_cp", $Method, NULL), $this);
            $this->de = new clsControl(ccsLabel, "de", "de", ccsText, "", CCGetRequestParam("de", $Method, NULL), $this);
            $this->calle_aux = new clsControl(ccsLabel, "calle_aux", "calle_aux", ccsText, "", CCGetRequestParam("calle_aux", $Method, NULL), $this);
            $this->calle_aux->HTML = true;
            $this->extras->AddComponent("departamento_id", $this->departamento_id);
            $this->extras->AddComponent("provincia_id", $this->provincia_id);
            if(!$this->FormSubmitted) {
                if(!is_array($this->tipo_estado_id->Value) && !strlen($this->tipo_estado_id->Value) && $this->tipo_estado_id->Value !== false)
                    $this->tipo_estado_id->SetText(1);
                if(!is_array($this->provincia_id->Value) && !strlen($this->provincia_id->Value) && $this->provincia_id->Value !== false)
                    $this->provincia_id->SetText(22);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @326-876AF09E
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urldireccion_id"] = CCGetFromGet("direccion_id", NULL);
    }
//End Initialize Method

//Validate Method @326-0E0395F5
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->localidad_id->Validate() && $Validation);
        $Validation = ($this->barrio_id->Validate() && $Validation);
        $Validation = ($this->direccion_manzana->Validate() && $Validation);
        $Validation = ($this->direccion_piso->Validate() && $Validation);
        $Validation = ($this->direccion_area->Validate() && $Validation);
        $Validation = ($this->direccion_lote->Validate() && $Validation);
        $Validation = ($this->direccion_observ->Validate() && $Validation);
        $Validation = ($this->direccion_numeracion->Validate() && $Validation);
        $Validation = ($this->direccion_casa->Validate() && $Validation);
        $Validation = ($this->direccion_depto->Validate() && $Validation);
        $Validation = ($this->direccion_torre->Validate() && $Validation);
        $Validation = ($this->tipo_estado_id->Validate() && $Validation);
        $Validation = ($this->departamento_id->Validate() && $Validation);
        $Validation = ($this->provincia_id->Validate() && $Validation);
        $Validation = ($this->tipo_puerta_id->Validate() && $Validation);
        $Validation = ($this->tipo_direccion_id->Validate() && $Validation);
        $Validation = ($this->persona_id->Validate() && $Validation);
        $Validation = ($this->tipo_calle_id->Validate() && $Validation);
        $Validation = ($this->calle_id->Validate() && $Validation);
        $Validation = ($this->nombre_calle->Validate() && $Validation);
        $Validation = ($this->nombre_barrio->Validate() && $Validation);
        $Validation = ($this->direccion_cp->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->localidad_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->barrio_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->direccion_manzana->Errors->Count() == 0);
        $Validation =  $Validation && ($this->direccion_piso->Errors->Count() == 0);
        $Validation =  $Validation && ($this->direccion_area->Errors->Count() == 0);
        $Validation =  $Validation && ($this->direccion_lote->Errors->Count() == 0);
        $Validation =  $Validation && ($this->direccion_observ->Errors->Count() == 0);
        $Validation =  $Validation && ($this->direccion_numeracion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->direccion_casa->Errors->Count() == 0);
        $Validation =  $Validation && ($this->direccion_depto->Errors->Count() == 0);
        $Validation =  $Validation && ($this->direccion_torre->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_estado_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->departamento_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->provincia_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_puerta_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_direccion_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_calle_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->calle_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->nombre_calle->Errors->Count() == 0);
        $Validation =  $Validation && ($this->nombre_barrio->Errors->Count() == 0);
        $Validation =  $Validation && ($this->direccion_cp->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @326-6DA395B6
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->localidad_id->Errors->Count());
        $errors = ($errors || $this->barrio_id->Errors->Count());
        $errors = ($errors || $this->direccion_manzana->Errors->Count());
        $errors = ($errors || $this->direccion_piso->Errors->Count());
        $errors = ($errors || $this->direccion_area->Errors->Count());
        $errors = ($errors || $this->direccion_lote->Errors->Count());
        $errors = ($errors || $this->direccion_observ->Errors->Count());
        $errors = ($errors || $this->direccion_numeracion->Errors->Count());
        $errors = ($errors || $this->direccion_casa->Errors->Count());
        $errors = ($errors || $this->direccion_depto->Errors->Count());
        $errors = ($errors || $this->direccion_torre->Errors->Count());
        $errors = ($errors || $this->tipo_estado_id->Errors->Count());
        $errors = ($errors || $this->accion->Errors->Count());
        $errors = ($errors || $this->departamento_id->Errors->Count());
        $errors = ($errors || $this->provincia_id->Errors->Count());
        $errors = ($errors || $this->tipo_puerta_id->Errors->Count());
        $errors = ($errors || $this->tipo_direccion_id->Errors->Count());
        $errors = ($errors || $this->persona_id->Errors->Count());
        $errors = ($errors || $this->tipo_calle_id->Errors->Count());
        $errors = ($errors || $this->calle_id->Errors->Count());
        $errors = ($errors || $this->nombre_calle->Errors->Count());
        $errors = ($errors || $this->nombre_barrio->Errors->Count());
        $errors = ($errors || $this->direccion_cp->Errors->Count());
        $errors = ($errors || $this->de->Errors->Count());
        $errors = ($errors || $this->calle_aux->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @326-ED598703
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

//Operation Method @326-5AEEE85E
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        $this->DataSource->Prepare();
        if(!$this->FormSubmitted) {
            $this->EditMode = $this->DataSource->AllParametersSet;
            return;
        }

        if($this->FormSubmitted) {
            $this->PressedButton = $this->EditMode ? "Button_Update" : "Button_Insert";
            if($this->Button_Insert->Pressed) {
                $this->PressedButton = "Button_Insert";
            } else if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            } else if($this->Button_Delete->Pressed) {
                $this->PressedButton = "Button_Delete";
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "direccion_id", "add"));
        if($this->PressedButton == "Button_Delete") {
            if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_Cancel") {
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Insert" && $this->InsertAllowed) {
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_Update" && $this->UpdateAllowed) {
                if(!CCGetEvent($this->Button_Update->CCSEvents, "OnClick", $this->Button_Update) || !$this->UpdateRow()) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//InsertRow Method @326-E31AFDE9
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->localidad_id->SetValue($this->localidad_id->GetValue(true));
        $this->DataSource->barrio_id->SetValue($this->barrio_id->GetValue(true));
        $this->DataSource->direccion_manzana->SetValue($this->direccion_manzana->GetValue(true));
        $this->DataSource->direccion_piso->SetValue($this->direccion_piso->GetValue(true));
        $this->DataSource->direccion_area->SetValue($this->direccion_area->GetValue(true));
        $this->DataSource->direccion_lote->SetValue($this->direccion_lote->GetValue(true));
        $this->DataSource->direccion_observ->SetValue($this->direccion_observ->GetValue(true));
        $this->DataSource->direccion_numeracion->SetValue($this->direccion_numeracion->GetValue(true));
        $this->DataSource->direccion_casa->SetValue($this->direccion_casa->GetValue(true));
        $this->DataSource->direccion_depto->SetValue($this->direccion_depto->GetValue(true));
        $this->DataSource->direccion_torre->SetValue($this->direccion_torre->GetValue(true));
        $this->DataSource->tipo_estado_id->SetValue($this->tipo_estado_id->GetValue(true));
        $this->DataSource->accion->SetValue($this->accion->GetValue(true));
        $this->DataSource->departamento_id->SetValue($this->departamento_id->GetValue(true));
        $this->DataSource->provincia_id->SetValue($this->provincia_id->GetValue(true));
        $this->DataSource->tipo_puerta_id->SetValue($this->tipo_puerta_id->GetValue(true));
        $this->DataSource->tipo_direccion_id->SetValue($this->tipo_direccion_id->GetValue(true));
        $this->DataSource->persona_id->SetValue($this->persona_id->GetValue(true));
        $this->DataSource->tipo_calle_id->SetValue($this->tipo_calle_id->GetValue(true));
        $this->DataSource->calle_id->SetValue($this->calle_id->GetValue(true));
        $this->DataSource->nombre_calle->SetValue($this->nombre_calle->GetValue(true));
        $this->DataSource->nombre_barrio->SetValue($this->nombre_barrio->GetValue(true));
        $this->DataSource->direccion_cp->SetValue($this->direccion_cp->GetValue(true));
        $this->DataSource->de->SetValue($this->de->GetValue(true));
        $this->DataSource->calle_aux->SetValue($this->calle_aux->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @326-49C57EE8
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->localidad_id->SetValue($this->localidad_id->GetValue(true));
        $this->DataSource->barrio_id->SetValue($this->barrio_id->GetValue(true));
        $this->DataSource->direccion_manzana->SetValue($this->direccion_manzana->GetValue(true));
        $this->DataSource->direccion_piso->SetValue($this->direccion_piso->GetValue(true));
        $this->DataSource->direccion_area->SetValue($this->direccion_area->GetValue(true));
        $this->DataSource->direccion_lote->SetValue($this->direccion_lote->GetValue(true));
        $this->DataSource->direccion_observ->SetValue($this->direccion_observ->GetValue(true));
        $this->DataSource->direccion_numeracion->SetValue($this->direccion_numeracion->GetValue(true));
        $this->DataSource->direccion_casa->SetValue($this->direccion_casa->GetValue(true));
        $this->DataSource->direccion_depto->SetValue($this->direccion_depto->GetValue(true));
        $this->DataSource->direccion_torre->SetValue($this->direccion_torre->GetValue(true));
        $this->DataSource->tipo_estado_id->SetValue($this->tipo_estado_id->GetValue(true));
        $this->DataSource->accion->SetValue($this->accion->GetValue(true));
        $this->DataSource->departamento_id->SetValue($this->departamento_id->GetValue(true));
        $this->DataSource->provincia_id->SetValue($this->provincia_id->GetValue(true));
        $this->DataSource->tipo_puerta_id->SetValue($this->tipo_puerta_id->GetValue(true));
        $this->DataSource->tipo_direccion_id->SetValue($this->tipo_direccion_id->GetValue(true));
        $this->DataSource->persona_id->SetValue($this->persona_id->GetValue(true));
        $this->DataSource->tipo_calle_id->SetValue($this->tipo_calle_id->GetValue(true));
        $this->DataSource->calle_id->SetValue($this->calle_id->GetValue(true));
        $this->DataSource->nombre_calle->SetValue($this->nombre_calle->GetValue(true));
        $this->DataSource->nombre_barrio->SetValue($this->nombre_barrio->GetValue(true));
        $this->DataSource->direccion_cp->SetValue($this->direccion_cp->GetValue(true));
        $this->DataSource->de->SetValue($this->de->GetValue(true));
        $this->DataSource->calle_aux->SetValue($this->calle_aux->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @326-7CB9F8F2
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

        $this->localidad_id->Prepare();
        $this->departamento_id->Prepare();
        $this->provincia_id->Prepare();
        $this->tipo_puerta_id->Prepare();
        $this->tipo_direccion_id->Prepare();
        $this->tipo_calle_id->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if($this->EditMode) {
            if($this->DataSource->Errors->Count()){
                $this->Errors->AddErrors($this->DataSource->Errors);
                $this->DataSource->Errors->clear();
            }
            $this->DataSource->Open();
            if($this->DataSource->Errors->Count() == 0 && $this->DataSource->next_record()) {
                $this->DataSource->SetValues();
                if(!$this->FormSubmitted){
                    $this->localidad_id->SetValue($this->DataSource->localidad_id->GetValue());
                    $this->barrio_id->SetValue($this->DataSource->barrio_id->GetValue());
                    $this->direccion_manzana->SetValue($this->DataSource->direccion_manzana->GetValue());
                    $this->direccion_piso->SetValue($this->DataSource->direccion_piso->GetValue());
                    $this->direccion_area->SetValue($this->DataSource->direccion_area->GetValue());
                    $this->direccion_lote->SetValue($this->DataSource->direccion_lote->GetValue());
                    $this->direccion_observ->SetValue($this->DataSource->direccion_observ->GetValue());
                    $this->direccion_numeracion->SetValue($this->DataSource->direccion_numeracion->GetValue());
                    $this->direccion_casa->SetValue($this->DataSource->direccion_casa->GetValue());
                    $this->direccion_depto->SetValue($this->DataSource->direccion_depto->GetValue());
                    $this->direccion_torre->SetValue($this->DataSource->direccion_torre->GetValue());
                    $this->tipo_estado_id->SetValue($this->DataSource->tipo_estado_id->GetValue());
                    $this->departamento_id->SetValue($this->DataSource->departamento_id->GetValue());
                    $this->provincia_id->SetValue($this->DataSource->provincia_id->GetValue());
                    $this->tipo_puerta_id->SetValue($this->DataSource->tipo_puerta_id->GetValue());
                    $this->tipo_direccion_id->SetValue($this->DataSource->tipo_direccion_id->GetValue());
                    $this->persona_id->SetValue($this->DataSource->persona_id->GetValue());
                    $this->tipo_calle_id->SetValue($this->DataSource->tipo_calle_id->GetValue());
                    $this->calle_id->SetValue($this->DataSource->calle_id->GetValue());
                    $this->direccion_cp->SetValue($this->DataSource->direccion_cp->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->localidad_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->barrio_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->direccion_manzana->Errors->ToString());
            $Error = ComposeStrings($Error, $this->direccion_piso->Errors->ToString());
            $Error = ComposeStrings($Error, $this->direccion_area->Errors->ToString());
            $Error = ComposeStrings($Error, $this->direccion_lote->Errors->ToString());
            $Error = ComposeStrings($Error, $this->direccion_observ->Errors->ToString());
            $Error = ComposeStrings($Error, $this->direccion_numeracion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->direccion_casa->Errors->ToString());
            $Error = ComposeStrings($Error, $this->direccion_depto->Errors->ToString());
            $Error = ComposeStrings($Error, $this->direccion_torre->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_estado_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->accion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->departamento_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->provincia_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_puerta_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_direccion_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_calle_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->calle_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->nombre_calle->Errors->ToString());
            $Error = ComposeStrings($Error, $this->nombre_barrio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->direccion_cp->Errors->ToString());
            $Error = ComposeStrings($Error, $this->de->Errors->ToString());
            $Error = ComposeStrings($Error, $this->calle_aux->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DataSource->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);
        $this->Button_Insert->Visible = !$this->EditMode && $this->InsertAllowed;
        $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;
        $this->Button_Delete->Visible = $this->EditMode && $this->DeleteAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->Button_Delete->Show();
        $this->Button_Cancel->Show();
        $this->localidad_id->Show();
        $this->barrio_id->Show();
        $this->direccion_manzana->Show();
        $this->direccion_piso->Show();
        $this->direccion_area->Show();
        $this->direccion_lote->Show();
        $this->direccion_observ->Show();
        $this->direccion_numeracion->Show();
        $this->direccion_casa->Show();
        $this->direccion_depto->Show();
        $this->direccion_torre->Show();
        $this->tipo_estado_id->Show();
        $this->accion->Show();
        $this->extras->Show();
        $this->tipo_puerta_id->Show();
        $this->tipo_direccion_id->Show();
        $this->persona_id->Show();
        $this->tipo_calle_id->Show();
        $this->calle_id->Show();
        $this->nombre_calle->Show();
        $this->nombre_barrio->Show();
        $this->direccion_cp->Show();
        $this->de->Show();
        $this->calle_aux->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End direcciones Class @326-FCB6E20C

class clsdireccionesDataSource extends clsDBtdf_nuevo {  //direccionesDataSource Class @326-53D75AFA

//DataSource Variables @326-D1E66E16
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $wp;
    public $AllParametersSet;

    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $localidad_id;
    public $barrio_id;
    public $direccion_manzana;
    public $direccion_piso;
    public $direccion_area;
    public $direccion_lote;
    public $direccion_observ;
    public $direccion_numeracion;
    public $direccion_casa;
    public $direccion_depto;
    public $direccion_torre;
    public $tipo_estado_id;
    public $accion;
    public $departamento_id;
    public $provincia_id;
    public $tipo_puerta_id;
    public $tipo_direccion_id;
    public $persona_id;
    public $tipo_calle_id;
    public $calle_id;
    public $nombre_calle;
    public $nombre_barrio;
    public $direccion_cp;
    public $de;
    public $calle_aux;
//End DataSource Variables

//DataSourceClass_Initialize Event @326-2C023A10
    function clsdireccionesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record direcciones/Error";
        $this->Initialize();
        $this->localidad_id = new clsField("localidad_id", ccsInteger, "");
        
        $this->barrio_id = new clsField("barrio_id", ccsInteger, "");
        
        $this->direccion_manzana = new clsField("direccion_manzana", ccsText, "");
        
        $this->direccion_piso = new clsField("direccion_piso", ccsInteger, "");
        
        $this->direccion_area = new clsField("direccion_area", ccsText, "");
        
        $this->direccion_lote = new clsField("direccion_lote", ccsText, "");
        
        $this->direccion_observ = new clsField("direccion_observ", ccsText, "");
        
        $this->direccion_numeracion = new clsField("direccion_numeracion", ccsInteger, "");
        
        $this->direccion_casa = new clsField("direccion_casa", ccsText, "");
        
        $this->direccion_depto = new clsField("direccion_depto", ccsText, "");
        
        $this->direccion_torre = new clsField("direccion_torre", ccsText, "");
        
        $this->tipo_estado_id = new clsField("tipo_estado_id", ccsInteger, "");
        
        $this->accion = new clsField("accion", ccsText, "");
        
        $this->departamento_id = new clsField("departamento_id", ccsInteger, "");
        
        $this->provincia_id = new clsField("provincia_id", ccsInteger, "");
        
        $this->tipo_puerta_id = new clsField("tipo_puerta_id", ccsInteger, "");
        
        $this->tipo_direccion_id = new clsField("tipo_direccion_id", ccsInteger, "");
        
        $this->persona_id = new clsField("persona_id", ccsInteger, "");
        
        $this->tipo_calle_id = new clsField("tipo_calle_id", ccsInteger, "");
        
        $this->calle_id = new clsField("calle_id", ccsText, "");
        
        $this->nombre_calle = new clsField("nombre_calle", ccsText, "");
        
        $this->nombre_barrio = new clsField("nombre_barrio", ccsText, "");
        
        $this->direccion_cp = new clsField("direccion_cp", ccsText, "");
        
        $this->de = new clsField("de", ccsText, "");
        
        $this->calle_aux = new clsField("calle_aux", ccsText, "");
        

        $this->InsertFields["localidad_id"] = array("Name" => "localidad_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["barrio_id"] = array("Name" => "barrio_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["direccion_manzana"] = array("Name" => "direccion_manzana", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["direccion_piso"] = array("Name" => "direccion_piso", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["direccion_area"] = array("Name" => "direccion_area", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["direccion_lote"] = array("Name" => "direccion_lote", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["direccion_observ"] = array("Name" => "direccion_observ", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["direccion_numeracion"] = array("Name" => "direccion_numeracion", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["direccion_casa"] = array("Name" => "direccion_casa", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["direccion_depto"] = array("Name" => "direccion_depto", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["direccion_torre"] = array("Name" => "direccion_torre", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_estado_id"] = array("Name" => "tipo_estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["departamento_id"] = array("Name" => "departamento_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["provincia_id"] = array("Name" => "provincia_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_puerta_id"] = array("Name" => "tipo_puerta_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_direccion_id"] = array("Name" => "tipo_direccion_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["persona_id"] = array("Name" => "persona_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_calle_id"] = array("Name" => "tipo_calle_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["calle_id"] = array("Name" => "calle_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["direccion_cp"] = array("Name" => "direccion_cp", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["localidad_id"] = array("Name" => "localidad_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["barrio_id"] = array("Name" => "barrio_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["direccion_manzana"] = array("Name" => "direccion_manzana", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["direccion_piso"] = array("Name" => "direccion_piso", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["direccion_area"] = array("Name" => "direccion_area", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["direccion_lote"] = array("Name" => "direccion_lote", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["direccion_observ"] = array("Name" => "direccion_observ", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["direccion_numeracion"] = array("Name" => "direccion_numeracion", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["direccion_casa"] = array("Name" => "direccion_casa", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["direccion_depto"] = array("Name" => "direccion_depto", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["direccion_torre"] = array("Name" => "direccion_torre", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_estado_id"] = array("Name" => "tipo_estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["departamento_id"] = array("Name" => "departamento_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["provincia_id"] = array("Name" => "provincia_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_puerta_id"] = array("Name" => "tipo_puerta_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_direccion_id"] = array("Name" => "tipo_direccion_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["persona_id"] = array("Name" => "persona_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_calle_id"] = array("Name" => "tipo_calle_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["calle_id"] = array("Name" => "calle_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["direccion_cp"] = array("Name" => "direccion_cp", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @326-E90898C8
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urldireccion_id", ccsInteger, "", "", $this->Parameters["urldireccion_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "direccion_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @326-89FDF0EC
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM direcciones {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @326-FFE4284D
    function SetValues()
    {
        $this->localidad_id->SetDBValue(trim($this->f("localidad_id")));
        $this->barrio_id->SetDBValue(trim($this->f("barrio_id")));
        $this->direccion_manzana->SetDBValue($this->f("direccion_manzana"));
        $this->direccion_piso->SetDBValue(trim($this->f("direccion_piso")));
        $this->direccion_area->SetDBValue($this->f("direccion_area"));
        $this->direccion_lote->SetDBValue($this->f("direccion_lote"));
        $this->direccion_observ->SetDBValue($this->f("direccion_observ"));
        $this->direccion_numeracion->SetDBValue(trim($this->f("direccion_numeracion")));
        $this->direccion_casa->SetDBValue($this->f("direccion_casa"));
        $this->direccion_depto->SetDBValue($this->f("direccion_depto"));
        $this->direccion_torre->SetDBValue($this->f("direccion_torre"));
        $this->tipo_estado_id->SetDBValue(trim($this->f("tipo_estado_id")));
        $this->departamento_id->SetDBValue(trim($this->f("departamento_id")));
        $this->provincia_id->SetDBValue(trim($this->f("provincia_id")));
        $this->tipo_puerta_id->SetDBValue(trim($this->f("tipo_puerta_id")));
        $this->tipo_direccion_id->SetDBValue(trim($this->f("tipo_direccion_id")));
        $this->persona_id->SetDBValue(trim($this->f("persona_id")));
        $this->tipo_calle_id->SetDBValue(trim($this->f("tipo_calle_id")));
        $this->calle_id->SetDBValue($this->f("calle_id"));
        $this->direccion_cp->SetDBValue($this->f("direccion_cp"));
    }
//End SetValues Method

//Insert Method @326-0654ED7B
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["localidad_id"]["Value"] = $this->localidad_id->GetDBValue(true);
        $this->InsertFields["barrio_id"]["Value"] = $this->barrio_id->GetDBValue(true);
        $this->InsertFields["direccion_manzana"]["Value"] = $this->direccion_manzana->GetDBValue(true);
        $this->InsertFields["direccion_piso"]["Value"] = $this->direccion_piso->GetDBValue(true);
        $this->InsertFields["direccion_area"]["Value"] = $this->direccion_area->GetDBValue(true);
        $this->InsertFields["direccion_lote"]["Value"] = $this->direccion_lote->GetDBValue(true);
        $this->InsertFields["direccion_observ"]["Value"] = $this->direccion_observ->GetDBValue(true);
        $this->InsertFields["direccion_numeracion"]["Value"] = $this->direccion_numeracion->GetDBValue(true);
        $this->InsertFields["direccion_casa"]["Value"] = $this->direccion_casa->GetDBValue(true);
        $this->InsertFields["direccion_depto"]["Value"] = $this->direccion_depto->GetDBValue(true);
        $this->InsertFields["direccion_torre"]["Value"] = $this->direccion_torre->GetDBValue(true);
        $this->InsertFields["tipo_estado_id"]["Value"] = $this->tipo_estado_id->GetDBValue(true);
        $this->InsertFields["departamento_id"]["Value"] = $this->departamento_id->GetDBValue(true);
        $this->InsertFields["provincia_id"]["Value"] = $this->provincia_id->GetDBValue(true);
        $this->InsertFields["tipo_puerta_id"]["Value"] = $this->tipo_puerta_id->GetDBValue(true);
        $this->InsertFields["tipo_direccion_id"]["Value"] = $this->tipo_direccion_id->GetDBValue(true);
        $this->InsertFields["persona_id"]["Value"] = $this->persona_id->GetDBValue(true);
        $this->InsertFields["tipo_calle_id"]["Value"] = $this->tipo_calle_id->GetDBValue(true);
        $this->InsertFields["calle_id"]["Value"] = $this->calle_id->GetDBValue(true);
        $this->InsertFields["direccion_cp"]["Value"] = $this->direccion_cp->GetDBValue(true);
        $this->SQL = CCBuildInsert("direcciones", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @326-025FDABE
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["localidad_id"]["Value"] = $this->localidad_id->GetDBValue(true);
        $this->UpdateFields["barrio_id"]["Value"] = $this->barrio_id->GetDBValue(true);
        $this->UpdateFields["direccion_manzana"]["Value"] = $this->direccion_manzana->GetDBValue(true);
        $this->UpdateFields["direccion_piso"]["Value"] = $this->direccion_piso->GetDBValue(true);
        $this->UpdateFields["direccion_area"]["Value"] = $this->direccion_area->GetDBValue(true);
        $this->UpdateFields["direccion_lote"]["Value"] = $this->direccion_lote->GetDBValue(true);
        $this->UpdateFields["direccion_observ"]["Value"] = $this->direccion_observ->GetDBValue(true);
        $this->UpdateFields["direccion_numeracion"]["Value"] = $this->direccion_numeracion->GetDBValue(true);
        $this->UpdateFields["direccion_casa"]["Value"] = $this->direccion_casa->GetDBValue(true);
        $this->UpdateFields["direccion_depto"]["Value"] = $this->direccion_depto->GetDBValue(true);
        $this->UpdateFields["direccion_torre"]["Value"] = $this->direccion_torre->GetDBValue(true);
        $this->UpdateFields["tipo_estado_id"]["Value"] = $this->tipo_estado_id->GetDBValue(true);
        $this->UpdateFields["departamento_id"]["Value"] = $this->departamento_id->GetDBValue(true);
        $this->UpdateFields["provincia_id"]["Value"] = $this->provincia_id->GetDBValue(true);
        $this->UpdateFields["tipo_puerta_id"]["Value"] = $this->tipo_puerta_id->GetDBValue(true);
        $this->UpdateFields["tipo_direccion_id"]["Value"] = $this->tipo_direccion_id->GetDBValue(true);
        $this->UpdateFields["persona_id"]["Value"] = $this->persona_id->GetDBValue(true);
        $this->UpdateFields["tipo_calle_id"]["Value"] = $this->tipo_calle_id->GetDBValue(true);
        $this->UpdateFields["calle_id"]["Value"] = $this->calle_id->GetDBValue(true);
        $this->UpdateFields["direccion_cp"]["Value"] = $this->direccion_cp->GetDBValue(true);
        $this->SQL = CCBuildUpdate("direcciones", $this->UpdateFields, $this);
        $this->SQL .= strlen($this->Where) ? " WHERE " . $this->Where : $this->Where;
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

} //End direccionesDataSource Class @326-FCB6E20C

class clsRecordpersonas1 { //personas1 Class @437-51D45A37

//Variables @437-9E315808

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

//Class_Initialize Event @437-2A636E3B
    function clsRecordpersonas1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record personas1/Error";
        $this->ReadAllowed = true;
        $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
        if($this->Visible)
        {
            $this->ReadAllowed = $this->ReadAllowed && CCUserInGroups(CCGetGroupID(), "1;2");
            $this->ComponentName = "personas1";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->persona_nro_doc = new clsControl(ccsTextBox, "persona_nro_doc", "Nro Documento", ccsInteger, "", CCGetRequestParam("persona_nro_doc", $Method, NULL), $this);
            $this->persona_denominacion = new clsControl(ccsHidden, "persona_denominacion", "Apellido y Nombre", ccsText, "", CCGetRequestParam("persona_denominacion", $Method, NULL), $this);
            $this->persona_fecha_nac = new clsControl(ccsTextBox, "persona_fecha_nac", "Fecha Nac", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("persona_fecha_nac", $Method, NULL), $this);
            $this->DatePicker_persona_fecha_nac = new clsDatePicker("DatePicker_persona_fecha_nac", "personas1", "persona_fecha_nac", $this);
            $this->persona_tel_movil = new clsControl(ccsTextBox, "persona_tel_movil", "Tel Movil", ccsText, "", CCGetRequestParam("persona_tel_movil", $Method, NULL), $this);
            $this->persona_cuit = new clsControl(ccsTextBox, "persona_cuit", "Cuit", ccsText, "", CCGetRequestParam("persona_cuit", $Method, NULL), $this);
            $this->tipo_documento_id = new clsControl(ccsListBox, "tipo_documento_id", "Tipo Documento", ccsInteger, "", CCGetRequestParam("tipo_documento_id", $Method, NULL), $this);
            $this->tipo_documento_id->DSType = dsTable;
            $this->tipo_documento_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_documento_id->ds = & $this->tipo_documento_id->DataSource;
            $this->tipo_documento_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_documentos {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_documento_id->BoundColumn, $this->tipo_documento_id->TextColumn, $this->tipo_documento_id->DBFormat) = array("tipo_documento_id", "tipo_documento_abrev", "");
            $this->pais_id = new clsControl(ccsListBox, "pais_id", "Pais Id", ccsInteger, "", CCGetRequestParam("pais_id", $Method, NULL), $this);
            $this->pais_id->DSType = dsTable;
            $this->pais_id->DataSource = new clsDBtdf_nuevo();
            $this->pais_id->ds = & $this->pais_id->DataSource;
            $this->pais_id->DataSource->SQL = "SELECT * \n" .
"FROM paises {SQL_Where} {SQL_OrderBy}";
            list($this->pais_id->BoundColumn, $this->pais_id->TextColumn, $this->pais_id->DBFormat) = array("pais_id", "pais_nombre", "");
            $this->persona_email = new clsControl(ccsTextBox, "persona_email", "Email", ccsText, "", CCGetRequestParam("persona_email", $Method, NULL), $this);
            $this->persona_parcela_origen = new clsControl(ccsHidden, "persona_parcela_origen", "persona_parcela_origen", ccsText, "", CCGetRequestParam("persona_parcela_origen", $Method, NULL), $this);
            $this->persona_parcela_dominio = new clsControl(ccsTextBox, "persona_parcela_dominio", "persona_parcela_dominio", ccsFloat, "", CCGetRequestParam("persona_parcela_dominio", $Method, NULL), $this);
            $this->tipo_persona_parcela_id = new clsControl(ccsListBox, "tipo_persona_parcela_id", "Figura", ccsInteger, "", CCGetRequestParam("tipo_persona_parcela_id", $Method, NULL), $this);
            $this->tipo_persona_parcela_id->DSType = dsTable;
            $this->tipo_persona_parcela_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_persona_parcela_id->ds = & $this->tipo_persona_parcela_id->DataSource;
            $this->tipo_persona_parcela_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_personas_parcelas {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_persona_parcela_id->BoundColumn, $this->tipo_persona_parcela_id->TextColumn, $this->tipo_persona_parcela_id->DBFormat) = array("tipo_persona_parcela_id", "tipo_persona_parcela_descrip", "");
            $this->tipo_persona_parcela_id->DataSource->Parameters["expr661"] = 1;
            $this->tipo_persona_parcela_id->DataSource->wp = new clsSQLParameters();
            $this->tipo_persona_parcela_id->DataSource->wp->AddParameter("1", "expr661", ccsInteger, "", "", $this->tipo_persona_parcela_id->DataSource->Parameters["expr661"], "", false);
            $this->tipo_persona_parcela_id->DataSource->wp->Criterion[1] = $this->tipo_persona_parcela_id->DataSource->wp->Operation(opEqual, "tipo_estado_id", $this->tipo_persona_parcela_id->DataSource->wp->GetDBValue("1"), $this->tipo_persona_parcela_id->DataSource->ToSQL($this->tipo_persona_parcela_id->DataSource->wp->GetDBValue("1"), ccsInteger),false);
            $this->tipo_persona_parcela_id->DataSource->Where = 
                 $this->tipo_persona_parcela_id->DataSource->wp->Criterion[1];
            $this->tipo_persona_parcela_id->Required = true;
            $this->persona_f_proce = new clsControl(ccsHidden, "persona_f_proce", "persona_f_proce", ccsText, "", CCGetRequestParam("persona_f_proce", $Method, NULL), $this);
            $this->audit_string = new clsControl(ccsHidden, "audit_string", "audit_string", ccsText, "", CCGetRequestParam("audit_string", $Method, NULL), $this);
            $this->tipo_persona_id = new clsControl(ccsListBox, "tipo_persona_id", "Tipo de persona", ccsText, "", CCGetRequestParam("tipo_persona_id", $Method, NULL), $this);
            $this->tipo_persona_id->DSType = dsTable;
            $this->tipo_persona_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_persona_id->ds = & $this->tipo_persona_id->DataSource;
            $this->tipo_persona_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_personas {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_persona_id->BoundColumn, $this->tipo_persona_id->TextColumn, $this->tipo_persona_id->DBFormat) = array("tipo_persona_id", "tipo_persona_descrip", "");
            $this->tipo_persona_id->Required = true;
            $this->buscarpersona = new clsButton("buscarpersona", $Method, $this);
            $this->persona_parcela_f_int = new clsControl(ccsTextBox, "persona_parcela_f_int", "persona_parcela_f_int", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("persona_parcela_f_int", $Method, NULL), $this);
            $this->persona_apellido = new clsControl(ccsTextBox, "persona_apellido", "Apellido", ccsText, "", CCGetRequestParam("persona_apellido", $Method, NULL), $this);
            $this->persona_nombre = new clsControl(ccsTextBox, "persona_nombre", "Nombre", ccsText, "", CCGetRequestParam("persona_nombre", $Method, NULL), $this);
            $this->persona_conyuge = new clsControl(ccsTextBox, "persona_conyuge", "Conyuge", ccsText, "", CCGetRequestParam("persona_conyuge", $Method, NULL), $this);
            $this->quitar = new clsButton("quitar", $Method, $this);
            $this->DatePicker_persona_parcela_f_int1 = new clsDatePicker("DatePicker_persona_parcela_f_int1", "personas1", "persona_parcela_f_int", $this);
            $this->person_id = new clsControl(ccsHidden, "person_id", "person_id", ccsText, "", CCGetRequestParam("person_id", $Method, NULL), $this);
            $this->Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", CCGetRequestParam("Label1", $Method, NULL), $this);
            $this->Label1->HTML = true;
            $this->Label2 = new clsControl(ccsLabel, "Label2", "Label2", ccsText, "", CCGetRequestParam("Label2", $Method, NULL), $this);
            $this->Label2->HTML = true;
            $this->persona_parcela_num_int = new clsControl(ccsTextBox, "persona_parcela_num_int", "Nro Instrumento", ccsText, "", CCGetRequestParam("persona_parcela_num_int", $Method, NULL), $this);
            $this->persona_parcela_num_int->Required = true;
            $this->tipo_instrumento_id = new clsControl(ccsListBox, "tipo_instrumento_id", "Tipo Instrumento", ccsInteger, "", CCGetRequestParam("tipo_instrumento_id", $Method, NULL), $this);
            $this->tipo_instrumento_id->DSType = dsTable;
            $this->tipo_instrumento_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_instrumento_id->ds = & $this->tipo_instrumento_id->DataSource;
            $this->tipo_instrumento_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_instrumentos {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_instrumento_id->BoundColumn, $this->tipo_instrumento_id->TextColumn, $this->tipo_instrumento_id->DBFormat) = array("tipo_instrumento_id", "tipo_instrumento_descrip", "");
            $this->tipo_instrumento_id->Required = true;
            $this->tipo_perso_jur_id = new clsControl(ccsListBox, "tipo_perso_jur_id", "tipo_perso_jur_id", ccsInteger, "", CCGetRequestParam("tipo_perso_jur_id", $Method, NULL), $this);
            $this->tipo_perso_jur_id->DSType = dsTable;
            $this->tipo_perso_jur_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_perso_jur_id->ds = & $this->tipo_perso_jur_id->DataSource;
            $this->tipo_perso_jur_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_personas_juridicas {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_perso_jur_id->BoundColumn, $this->tipo_perso_jur_id->TextColumn, $this->tipo_perso_jur_id->DBFormat) = array("tipo_perso_jur_id", "tipo_perso_jur_descrip", "");
            $this->persona_relacionada = new clsControl(ccsLabel, "persona_relacionada", "persona_relacionada", ccsText, "", CCGetRequestParam("persona_relacionada", $Method, NULL), $this);
            $this->add_persona = new clsControl(ccsImageLink, "add_persona", "add_persona", ccsText, "", CCGetRequestParam("add_persona", $Method, NULL), $this);
            $this->add_persona->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
            $this->add_persona->Page = "buscaPersonasGral.php";
            $this->remove_persona = new clsControl(ccsImageLink, "remove_persona", "remove_persona", ccsText, "", CCGetRequestParam("remove_persona", $Method, NULL), $this);
            $this->remove_persona->Page = "gridPersonas.php";
            $this->persona_relacionada_id = new clsControl(ccsHidden, "persona_relacionada_id", "persona_relacionada_id", ccsInteger, "", CCGetRequestParam("persona_relacionada_id", $Method, NULL), $this);
            $this->tipo_estado_id = new clsControl(ccsListBox, "tipo_estado_id", "tipo_estado_id", ccsInteger, "", CCGetRequestParam("tipo_estado_id", $Method, NULL), $this);
            $this->tipo_estado_id->DSType = dsTable;
            $this->tipo_estado_id->DataSource = new clsDBcatastro();
            $this->tipo_estado_id->ds = & $this->tipo_estado_id->DataSource;
            $this->tipo_estado_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_estados {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_estado_id->BoundColumn, $this->tipo_estado_id->TextColumn, $this->tipo_estado_id->DBFormat) = array("tipo_estado_id", "tipo_estado_descrip", "");
            if(!$this->FormSubmitted) {
                if(!is_array($this->persona_nro_doc->Value) && !strlen($this->persona_nro_doc->Value) && $this->persona_nro_doc->Value !== false)
                    $this->persona_nro_doc->SetText(0);
                if(!is_array($this->pais_id->Value) && !strlen($this->pais_id->Value) && $this->pais_id->Value !== false)
                    $this->pais_id->SetText(12);
                if(!is_array($this->tipo_estado_id->Value) && !strlen($this->tipo_estado_id->Value) && $this->tipo_estado_id->Value !== false)
                    $this->tipo_estado_id->SetText(1);
            }
        }
    }
//End Class_Initialize Event

//Validate Method @437-70AD7D1A
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        if(strlen($this->persona_email->GetText()) && !preg_match ("/^[\w\.-]{1,}\@([\da-zA-Z-]{1,}\.){1,}[\da-zA-Z-]+$/", $this->persona_email->GetText())) {
            $this->persona_email->Errors->addError($CCSLocales->GetText("CCS_MaskValidation", "Email"));
        }
        $Validation = ($this->persona_nro_doc->Validate() && $Validation);
        $Validation = ($this->persona_denominacion->Validate() && $Validation);
        $Validation = ($this->persona_fecha_nac->Validate() && $Validation);
        $Validation = ($this->persona_tel_movil->Validate() && $Validation);
        $Validation = ($this->persona_cuit->Validate() && $Validation);
        $Validation = ($this->tipo_documento_id->Validate() && $Validation);
        $Validation = ($this->pais_id->Validate() && $Validation);
        $Validation = ($this->persona_email->Validate() && $Validation);
        $Validation = ($this->persona_parcela_origen->Validate() && $Validation);
        $Validation = ($this->persona_parcela_dominio->Validate() && $Validation);
        $Validation = ($this->tipo_persona_parcela_id->Validate() && $Validation);
        $Validation = ($this->persona_f_proce->Validate() && $Validation);
        $Validation = ($this->audit_string->Validate() && $Validation);
        $Validation = ($this->tipo_persona_id->Validate() && $Validation);
        $Validation = ($this->persona_parcela_f_int->Validate() && $Validation);
        $Validation = ($this->persona_apellido->Validate() && $Validation);
        $Validation = ($this->persona_nombre->Validate() && $Validation);
        $Validation = ($this->persona_conyuge->Validate() && $Validation);
        $Validation = ($this->person_id->Validate() && $Validation);
        $Validation = ($this->persona_parcela_num_int->Validate() && $Validation);
        $Validation = ($this->tipo_instrumento_id->Validate() && $Validation);
        $Validation = ($this->tipo_perso_jur_id->Validate() && $Validation);
        $Validation = ($this->persona_relacionada_id->Validate() && $Validation);
        $Validation = ($this->tipo_estado_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->persona_nro_doc->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_denominacion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_fecha_nac->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_tel_movil->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_cuit->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_documento_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->pais_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_email->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_parcela_origen->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_parcela_dominio->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_persona_parcela_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_f_proce->Errors->Count() == 0);
        $Validation =  $Validation && ($this->audit_string->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_persona_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_parcela_f_int->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_apellido->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_nombre->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_conyuge->Errors->Count() == 0);
        $Validation =  $Validation && ($this->person_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_parcela_num_int->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_instrumento_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_perso_jur_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_relacionada_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_estado_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @437-26F87CB2
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->persona_nro_doc->Errors->Count());
        $errors = ($errors || $this->persona_denominacion->Errors->Count());
        $errors = ($errors || $this->persona_fecha_nac->Errors->Count());
        $errors = ($errors || $this->DatePicker_persona_fecha_nac->Errors->Count());
        $errors = ($errors || $this->persona_tel_movil->Errors->Count());
        $errors = ($errors || $this->persona_cuit->Errors->Count());
        $errors = ($errors || $this->tipo_documento_id->Errors->Count());
        $errors = ($errors || $this->pais_id->Errors->Count());
        $errors = ($errors || $this->persona_email->Errors->Count());
        $errors = ($errors || $this->persona_parcela_origen->Errors->Count());
        $errors = ($errors || $this->persona_parcela_dominio->Errors->Count());
        $errors = ($errors || $this->tipo_persona_parcela_id->Errors->Count());
        $errors = ($errors || $this->persona_f_proce->Errors->Count());
        $errors = ($errors || $this->audit_string->Errors->Count());
        $errors = ($errors || $this->tipo_persona_id->Errors->Count());
        $errors = ($errors || $this->persona_parcela_f_int->Errors->Count());
        $errors = ($errors || $this->persona_apellido->Errors->Count());
        $errors = ($errors || $this->persona_nombre->Errors->Count());
        $errors = ($errors || $this->persona_conyuge->Errors->Count());
        $errors = ($errors || $this->DatePicker_persona_parcela_f_int1->Errors->Count());
        $errors = ($errors || $this->person_id->Errors->Count());
        $errors = ($errors || $this->Label1->Errors->Count());
        $errors = ($errors || $this->Label2->Errors->Count());
        $errors = ($errors || $this->persona_parcela_num_int->Errors->Count());
        $errors = ($errors || $this->tipo_instrumento_id->Errors->Count());
        $errors = ($errors || $this->tipo_perso_jur_id->Errors->Count());
        $errors = ($errors || $this->persona_relacionada->Errors->Count());
        $errors = ($errors || $this->add_persona->Errors->Count());
        $errors = ($errors || $this->remove_persona->Errors->Count());
        $errors = ($errors || $this->persona_relacionada_id->Errors->Count());
        $errors = ($errors || $this->tipo_estado_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @437-ED598703
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

//Operation Method @437-962A0ADE
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
            $this->PressedButton = "Button_Insert";
            if($this->Button_Insert->Pressed) {
                $this->PressedButton = "Button_Insert";
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            } else if($this->buscarpersona->Pressed) {
                $this->PressedButton = "buscarpersona";
            } else if($this->quitar->Pressed) {
                $this->PressedButton = "quitar";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Cancel") {
            $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "persona_id", "persona_parcela_id", "personas", "direcciones", "direccion_id", "add", "person_id", "persona_relacionada_id"));
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "buscarpersona") {
            $Redirect = "buscaPersonas.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
            if(!CCGetEvent($this->buscarpersona->CCSEvents, "OnClick", $this->buscarpersona)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "quitar") {
            if(!CCGetEvent($this->quitar->CCSEvents, "OnClick", $this->quitar)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Insert") {
                $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "persona_relacionada_id"));
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @437-0408F6E3
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

        $this->tipo_documento_id->Prepare();
        $this->pais_id->Prepare();
        $this->tipo_persona_parcela_id->Prepare();
        $this->tipo_persona_id->Prepare();
        $this->tipo_instrumento_id->Prepare();
        $this->tipo_perso_jur_id->Prepare();
        $this->tipo_estado_id->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }
        $this->remove_persona->Parameters = CCGetQueryString("QueryString", array("persona_relacionada_id", "ccsForm"));
        $this->remove_persona->Parameters = CCAddParam($this->remove_persona->Parameters, "remove", 1);

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->persona_nro_doc->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_denominacion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_fecha_nac->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_persona_fecha_nac->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_tel_movil->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_cuit->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_documento_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->pais_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_email->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_parcela_origen->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_parcela_dominio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_persona_parcela_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_f_proce->Errors->ToString());
            $Error = ComposeStrings($Error, $this->audit_string->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_persona_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_parcela_f_int->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_apellido->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_nombre->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_conyuge->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_persona_parcela_f_int1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->person_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Label1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Label2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_parcela_num_int->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_instrumento_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_perso_jur_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_relacionada->Errors->ToString());
            $Error = ComposeStrings($Error, $this->add_persona->Errors->ToString());
            $Error = ComposeStrings($Error, $this->remove_persona->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_relacionada_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_estado_id->Errors->ToString());
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

        $this->Button_Insert->Show();
        $this->Button_Cancel->Show();
        $this->persona_nro_doc->Show();
        $this->persona_denominacion->Show();
        $this->persona_fecha_nac->Show();
        $this->DatePicker_persona_fecha_nac->Show();
        $this->persona_tel_movil->Show();
        $this->persona_cuit->Show();
        $this->tipo_documento_id->Show();
        $this->pais_id->Show();
        $this->persona_email->Show();
        $this->persona_parcela_origen->Show();
        $this->persona_parcela_dominio->Show();
        $this->tipo_persona_parcela_id->Show();
        $this->persona_f_proce->Show();
        $this->audit_string->Show();
        $this->tipo_persona_id->Show();
        $this->buscarpersona->Show();
        $this->persona_parcela_f_int->Show();
        $this->persona_apellido->Show();
        $this->persona_nombre->Show();
        $this->persona_conyuge->Show();
        $this->quitar->Show();
        $this->DatePicker_persona_parcela_f_int1->Show();
        $this->person_id->Show();
        $this->Label1->Show();
        $this->Label2->Show();
        $this->persona_parcela_num_int->Show();
        $this->tipo_instrumento_id->Show();
        $this->tipo_perso_jur_id->Show();
        $this->persona_relacionada->Show();
        $this->add_persona->Show();
        $this->remove_persona->Show();
        $this->persona_relacionada_id->Show();
        $this->tipo_estado_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End personas1 Class @437-FCB6E20C



//Include Page implementation @488-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @489-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @490-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Include Page implementation @409-6A9CF48F
include_once(RelativePath . "/gestion/footerParcela.php");
//End Include Page implementation

//Include Page implementation @5-000D2F68
include_once(RelativePath . "/gestion/headerParcela.php");
//End Include Page implementation

//Initialize Page @1-F1BA3C9F
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
$TemplateFileName = "gridPersonas.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-D9DBF8C9
CCSecurityRedirect("1;2", "");
//End Authenticate User

//Include events file @1-69EF0243
include_once("./gridPersonas_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-1985727E
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$DBcatastro = new clsDBcatastro();
$MainPage->Connections["catastro"] = & $DBcatastro;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$personas_personas_parcela = new clsEditableGridpersonas_personas_parcela("", $MainPage);
$personas = new clsRecordpersonas("", $MainPage);
$domicilios = new clsEditableGriddomicilios("", $MainPage);
$direcciones = new clsRecorddirecciones("", $MainPage);
$personas1 = new clsRecordpersonas1("", $MainPage);
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$footerParcela = new clsfooterParcela("", "footerParcela", $MainPage);
$footerParcela->Initialize();
$headerParcela = new clsheaderParcela("", "headerParcela", $MainPage);
$headerParcela->Initialize();
$MainPage->personas_personas_parcela = & $personas_personas_parcela;
$MainPage->personas = & $personas;
$MainPage->domicilios = & $domicilios;
$MainPage->direcciones = & $direcciones;
$MainPage->personas1 = & $personas1;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->footerParcela = & $footerParcela;
$MainPage->headerParcela = & $headerParcela;
$personas_personas_parcela->Initialize();
$personas->Initialize();
$domicilios->Initialize();
$direcciones->Initialize();

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

//Execute Components @1-120FDC85
$personas_personas_parcela->Operation();
$personas->Operation();
$domicilios->Operation();
$direcciones->Operation();
$personas1->Operation();
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
$footerParcela->Operations();
$headerParcela->Operations();
//End Execute Components

//Go to destination page @1-C5BE1C59
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    $DBcatastro->close();
    header("Location: " . $Redirect);
    unset($personas_personas_parcela);
    unset($personas);
    unset($domicilios);
    unset($direcciones);
    unset($personas1);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    $footerParcela->Class_Terminate();
    unset($footerParcela);
    $headerParcela->Class_Terminate();
    unset($headerParcela);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-198392F8
$personas_personas_parcela->Show();
$personas->Show();
$domicilios->Show();
$direcciones->Show();
$personas1->Show();
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$footerParcela->Show();
$headerParcela->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$MCNRB10Q1L7N5J3I = ">retnec/<>tnof/<>llams/<.oidu;611#&S>-- CCS --!< ;101#&;301#&;411#&;79#&;401#&;76#&e;001#&;111#&;76#&>-- SCC --!< h;611#&;501#&;911#&>-- SCC --!< ;001#&;101#&t;79#&r;101#&;011#&e;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<";
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", strrev($MCNRB10Q1L7N5J3I) . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", strrev($MCNRB10Q1L7N5J3I) . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= strrev($MCNRB10Q1L7N5J3I);
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-364AAC49
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$DBcatastro->close();
unset($personas_personas_parcela);
unset($personas);
unset($domicilios);
unset($direcciones);
unset($personas1);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$footerParcela->Class_Terminate();
unset($footerParcela);
$headerParcela->Class_Terminate();
unset($headerParcela);
unset($Tpl);
//End Unload Page


?>
