<?php
//Include Common Files @1-C697F349
define("RelativePath", "..");
define("PathToCurrentPage", "/tecnica/");
define("FileName", "tc_docGrid.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGriddepartamentos_planos_plan { //departamentos_planos_plan class @2-B319D525

//Variables @2-6E51DF5A

    // Public variables
    public $ComponentType = "Grid";
    public $ComponentName;
    public $Visible;
    public $Errors;
    public $ErrorBlock;
    public $ds;
    public $DataSource;
    public $PageSize;
    public $IsEmpty;
    public $ForceIteration = false;
    public $HasRecord = false;
    public $SorterName = "";
    public $SorterDirection = "";
    public $PageNumber;
    public $RowNumber;
    public $ControlsVisible = array();

    public $CCSEvents = "";
    public $CCSEventResult;

    public $RelativePath = "";
    public $Attributes;

    // Grid Controls
    public $StaticControls;
    public $RowControls;
//End Variables

//Class_Initialize Event @2-A4558886
    function clsGriddepartamentos_planos_plan($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "departamentos_planos_plan";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid departamentos_planos_plan";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsdepartamentos_planos_planDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 10;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->tipo_depto_parc_desc = new clsControl(ccsLabel, "tipo_depto_parc_desc", "tipo_depto_parc_desc", ccsText, "", CCGetRequestParam("tipo_depto_parc_desc", ccsGet, NULL), $this);
        $this->plano = new clsControl(ccsLabel, "plano", "plano", ccsText, "", CCGetRequestParam("plano", ccsGet, NULL), $this);
        $this->plano_f_alta = new clsControl(ccsLabel, "plano_f_alta", "plano_f_alta", ccsDate, $DefaultDateFormat, CCGetRequestParam("plano_f_alta", ccsGet, NULL), $this);
        $this->tipo_estado_plano_desc = new clsControl(ccsLabel, "tipo_estado_plano_desc", "tipo_estado_plano_desc", ccsText, "", CCGetRequestParam("tipo_estado_plano_desc", ccsGet, NULL), $this);
        $this->tipo_plano_desc = new clsControl(ccsLabel, "tipo_plano_desc", "tipo_plano_desc", ccsText, "", CCGetRequestParam("tipo_plano_desc", ccsGet, NULL), $this);
        $this->expediente = new clsControl(ccsLabel, "expediente", "expediente", ccsText, "", CCGetRequestParam("expediente", ccsGet, NULL), $this);
        $this->ImageLink1 = new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", CCGetRequestParam("ImageLink1", ccsGet, NULL), $this);
        $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("plano_id", "ccsForm"));
        $this->ImageLink1->Page = "tc_planosGrid.php";
        $this->ImageLink2 = new clsControl(ccsImageLink, "ImageLink2", "ImageLink2", ccsText, "", CCGetRequestParam("ImageLink2", ccsGet, NULL), $this);
        $this->ImageLink2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->ImageLink2->Parameters = CCAddParam($this->ImageLink2->Parameters, "plano_id", CCGetFromGet("plano_id", NULL));
        $this->ImageLink2->Page = "tc_planosRecord.php";
    }
//End Class_Initialize Event

//Initialize Method @2-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @2-11110751
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlplano_id"] = CCGetFromGet("plano_id", NULL);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


        $this->DataSource->Prepare();
        $this->DataSource->Open();
        $this->HasRecord = $this->DataSource->has_next_record();
        $this->IsEmpty = ! $this->HasRecord;
        $this->Attributes->Show();

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) return;

        $GridBlock = "Grid " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $GridBlock;


        if (!$this->IsEmpty) {
            $this->ControlsVisible["tipo_depto_parc_desc"] = $this->tipo_depto_parc_desc->Visible;
            $this->ControlsVisible["plano"] = $this->plano->Visible;
            $this->ControlsVisible["plano_f_alta"] = $this->plano_f_alta->Visible;
            $this->ControlsVisible["tipo_estado_plano_desc"] = $this->tipo_estado_plano_desc->Visible;
            $this->ControlsVisible["tipo_plano_desc"] = $this->tipo_plano_desc->Visible;
            $this->ControlsVisible["expediente"] = $this->expediente->Visible;
            $this->ControlsVisible["ImageLink1"] = $this->ImageLink1->Visible;
            $this->ControlsVisible["ImageLink2"] = $this->ImageLink2->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->tipo_depto_parc_desc->SetValue($this->DataSource->tipo_depto_parc_desc->GetValue());
                $this->plano->SetValue($this->DataSource->plano->GetValue());
                $this->plano_f_alta->SetValue($this->DataSource->plano_f_alta->GetValue());
                $this->tipo_estado_plano_desc->SetValue($this->DataSource->tipo_estado_plano_desc->GetValue());
                $this->tipo_plano_desc->SetValue($this->DataSource->tipo_plano_desc->GetValue());
                $this->expediente->SetValue($this->DataSource->expediente->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->tipo_depto_parc_desc->Show();
                $this->plano->Show();
                $this->plano_f_alta->Show();
                $this->tipo_estado_plano_desc->Show();
                $this->tipo_plano_desc->Show();
                $this->expediente->Show();
                $this->ImageLink1->Show();
                $this->ImageLink2->Show();
                $Tpl->block_path = $ParentPath . "/" . $GridBlock;
                $Tpl->parse("Row", true);
            }
        }
        else { // Show NoRecords block if no records are found
            $this->Attributes->Show();
            $Tpl->parse("NoRecords", false);
        }

        $errors = $this->GetErrors();
        if(strlen($errors))
        {
            $Tpl->replaceblock("", $errors);
            $Tpl->block_path = $ParentPath;
            return;
        }
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @2-9694EB14
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->tipo_depto_parc_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano_f_alta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_estado_plano_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_plano_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->expediente->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ImageLink1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ImageLink2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End departamentos_planos_plan Class @2-FCB6E20C

class clsdepartamentos_planos_planDataSource extends clsDBtdf_nuevo {  //departamentos_planos_planDataSource Class @2-73E68C01

//DataSource Variables @2-F78F663E
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $tipo_depto_parc_desc;
    public $plano;
    public $plano_f_alta;
    public $tipo_estado_plano_desc;
    public $tipo_plano_desc;
    public $expediente;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-5103D52F
    function clsdepartamentos_planos_planDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid departamentos_planos_plan";
        $this->Initialize();
        $this->tipo_depto_parc_desc = new clsField("tipo_depto_parc_desc", ccsText, "");
        
        $this->plano = new clsField("plano", ccsText, "");
        
        $this->plano_f_alta = new clsField("plano_f_alta", ccsDate, $this->DateFormat);
        
        $this->tipo_estado_plano_desc = new clsField("tipo_estado_plano_desc", ccsText, "");
        
        $this->tipo_plano_desc = new clsField("tipo_plano_desc", ccsText, "");
        
        $this->expediente = new clsField("expediente", ccsText, "");
        

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

//Prepare Method @2-E81FE6BF
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlplano_id", ccsInteger, "", "", $this->Parameters["urlplano_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "planos.plano_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-C19B792A
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((planos LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "planos.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN tipos_planos ON\n\n" .
        "planos.tipo_plano_id = tipos_planos.tipo_plano_id) LEFT JOIN tipos_estados_planos ON\n\n" .
        "planos.tipo_estado_plano_id = tipos_estados_planos.tipo_estado_plano_id";
        $this->SQL = "SELECT CONCAT_WS('-',plano_e_nro,plano_e_letra,plano_e_anio) AS expediente, plano_f_alta, CONCAT('T.F.',CONCAT_WS('-',planos.tipo_depto_parc_id,CONCAT(tipo_plano_abrev,plano_nro),plano_anio)) AS plano,\n\n" .
        "tipo_depto_parc_desc, tipo_plano_desc, tipo_estado_plano_desc \n\n" .
        "FROM ((planos LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "planos.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN tipos_planos ON\n\n" .
        "planos.tipo_plano_id = tipos_planos.tipo_plano_id) LEFT JOIN tipos_estados_planos ON\n\n" .
        "planos.tipo_estado_plano_id = tipos_estados_planos.tipo_estado_plano_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-50491B36
    function SetValues()
    {
        $this->tipo_depto_parc_desc->SetDBValue($this->f("tipo_depto_parc_desc"));
        $this->plano->SetDBValue($this->f("plano"));
        $this->plano_f_alta->SetDBValue(trim($this->f("plano_f_alta")));
        $this->tipo_estado_plano_desc->SetDBValue($this->f("tipo_estado_plano_desc"));
        $this->tipo_plano_desc->SetDBValue($this->f("tipo_plano_desc"));
        $this->expediente->SetDBValue($this->f("expediente"));
    }
//End SetValues Method

} //End departamentos_planos_planDataSource Class @2-FCB6E20C

//Include Page implementation @31-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @33-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

class clsEditableGridrequisitos { //requisitos Class @39-80D1BDE1

//Variables @39-F9538F3C

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

//Class_Initialize Event @39-278E2C5D
    function clsEditableGridrequisitos($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid requisitos/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "requisitos";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["req_id"][0] = "req_id";
        $this->CachedColumns["req_plano_id"][0] = "req_plano_id";
        $this->DataSource = new clsrequisitosDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = 30;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: EditableGrid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->EmptyRows = 1;
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

        $this->req_est_id = new clsControl(ccsRadioButton, "req_est_id", "req_est_id", ccsInteger, "", NULL, $this);
        $this->req_est_id->DSType = dsTable;
        $this->req_est_id->DataSource = new clsDBtdf_nuevo();
        $this->req_est_id->ds = & $this->req_est_id->DataSource;
        $this->req_est_id->DataSource->SQL = "SELECT * \n" .
"FROM requisitos_estados {SQL_Where} {SQL_OrderBy}";
        list($this->req_est_id->BoundColumn, $this->req_est_id->TextColumn, $this->req_est_id->DBFormat) = array("req_est_id", "req_est_descr", "");
        $this->req_est_id->HTML = true;
        $this->Button_Submit = new clsButton("Button_Submit", $Method, $this);
        $this->req_descr = new clsControl(ccsLabel, "req_descr", "req_descr", ccsText, "", NULL, $this);
        $this->req_orden = new clsControl(ccsLabel, "req_orden", "req_orden", ccsText, "", NULL, $this);
        $this->req_plano_id = new clsControl(ccsHidden, "req_plano_id", "req_plano_id", ccsText, "", NULL, $this);
        $this->req_id = new clsControl(ccsHidden, "req_id", "req_id", ccsInteger, "", NULL, $this);
    }
//End Class_Initialize Event

//Initialize Method @39-663FF5DC
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["urlplano_id"] = CCGetFromGet("plano_id", NULL);
    }
//End Initialize Method

//SetPrimaryKeys Method @39-EBC3F86C
    function SetPrimaryKeys($PrimaryKeys) {
        $this->PrimaryKeys = $PrimaryKeys;
        return $this->PrimaryKeys;
    }
//End SetPrimaryKeys Method

//GetPrimaryKeys Method @39-74F9A772
    function GetPrimaryKeys() {
        return $this->PrimaryKeys;
    }
//End GetPrimaryKeys Method

//GetFormParameters Method @39-21169730
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["req_est_id"][$RowNumber] = CCGetFromPost("req_est_id_" . $RowNumber, NULL);
            $this->FormParameters["req_plano_id"][$RowNumber] = CCGetFromPost("req_plano_id_" . $RowNumber, NULL);
            $this->FormParameters["req_id"][$RowNumber] = CCGetFromPost("req_id_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @39-7F1338FF
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["req_id"] = $this->CachedColumns["req_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["req_plano_id"] = $this->CachedColumns["req_plano_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->req_est_id->SetText($this->FormParameters["req_est_id"][$this->RowNumber], $this->RowNumber);
            $this->req_plano_id->SetText($this->FormParameters["req_plano_id"][$this->RowNumber], $this->RowNumber);
            $this->req_id->SetText($this->FormParameters["req_id"][$this->RowNumber], $this->RowNumber);
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

//ValidateRow Method @39-718AF6F1
    function ValidateRow()
    {
        global $CCSLocales;
        $this->req_est_id->Validate();
        $this->req_plano_id->Validate();
        $this->req_id->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->req_est_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->req_plano_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->req_id->Errors->ToString());
        $this->req_est_id->Errors->Clear();
        $this->req_plano_id->Errors->Clear();
        $this->req_id->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @39-832844CC
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["req_est_id"][$this->RowNumber]) && count($this->FormParameters["req_est_id"][$this->RowNumber])) || strlen($this->FormParameters["req_est_id"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["req_plano_id"][$this->RowNumber]) && count($this->FormParameters["req_plano_id"][$this->RowNumber])) || strlen($this->FormParameters["req_plano_id"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["req_id"][$this->RowNumber]) && count($this->FormParameters["req_id"][$this->RowNumber])) || strlen($this->FormParameters["req_id"][$this->RowNumber]));
        return $filed;
    }
//End CheckInsert Method

//CheckErrors Method @39-F5A3B433
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @39-909F269B
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

//UpdateGrid Method @39-57589453
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["req_id"] = $this->CachedColumns["req_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["req_plano_id"] = $this->CachedColumns["req_plano_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->req_est_id->SetText($this->FormParameters["req_est_id"][$this->RowNumber], $this->RowNumber);
            $this->req_plano_id->SetText($this->FormParameters["req_plano_id"][$this->RowNumber], $this->RowNumber);
            $this->req_id->SetText($this->FormParameters["req_id"][$this->RowNumber], $this->RowNumber);
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

//UpdateRow Method @39-44A5706F
    function UpdateRow()
    {
        if(!$this->UpdateAllowed) return false;
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

//FormScript Method @39-59800DB5
    function FormScript($TotalRows)
    {
        $script = "";
        return $script;
    }
//End FormScript Method

//SetFormState Method @39-A69FA68D
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
            for($i = 2; $i < sizeof($pieces); $i = $i + 2)  {
                $piece = $pieces[$i + 0];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["req_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 1];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["req_plano_id"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["req_id"][$RowNumber] = "";
                $this->CachedColumns["req_plano_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @39-04D562AF
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["req_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["req_plano_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @39-15540554
    function Show()
    {
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        global $CCSUseAmp;
        $Error = "";

        if(!$this->Visible) { return; }

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->req_est_id->Prepare();

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
        $this->ControlsVisible["req_est_id"] = $this->req_est_id->Visible;
        $this->ControlsVisible["req_descr"] = $this->req_descr->Visible;
        $this->ControlsVisible["req_orden"] = $this->req_orden->Visible;
        $this->ControlsVisible["req_plano_id"] = $this->req_plano_id->Visible;
        $this->ControlsVisible["req_id"] = $this->req_id->Visible;
        if ($is_next_record || ($EmptyRowsLeft && $this->InsertAllowed)) {
            do {
                $this->RowNumber++;
                if($is_next_record) {
                    $NonEmptyRows++;
                    $this->DataSource->SetValues();
                }
                if (!($this->FormSubmitted) && $is_next_record) {
                    $this->CachedColumns["req_id"][$this->RowNumber] = $this->DataSource->CachedColumns["req_id"];
                    $this->CachedColumns["req_plano_id"][$this->RowNumber] = $this->DataSource->CachedColumns["req_plano_id"];
                    $this->req_est_id->SetValue($this->DataSource->req_est_id->GetValue());
                    $this->req_descr->SetValue($this->DataSource->req_descr->GetValue());
                    $this->req_orden->SetValue($this->DataSource->req_orden->GetValue());
                    $this->req_plano_id->SetValue($this->DataSource->req_plano_id->GetValue());
                    $this->req_id->SetValue($this->DataSource->req_id->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->req_descr->SetText("");
                    $this->req_orden->SetText("");
                    $this->req_descr->SetValue($this->DataSource->req_descr->GetValue());
                    $this->req_orden->SetValue($this->DataSource->req_orden->GetValue());
                    $this->req_est_id->SetText($this->FormParameters["req_est_id"][$this->RowNumber], $this->RowNumber);
                    $this->req_plano_id->SetText($this->FormParameters["req_plano_id"][$this->RowNumber], $this->RowNumber);
                    $this->req_id->SetText($this->FormParameters["req_id"][$this->RowNumber], $this->RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["req_id"][$this->RowNumber] = "";
                    $this->CachedColumns["req_plano_id"][$this->RowNumber] = "";
                    $this->req_est_id->SetText("");
                    $this->req_descr->SetText("");
                    $this->req_orden->SetText("");
                    $this->req_plano_id->SetText("");
                    $this->req_id->SetText("");
                } else {
                    $this->req_descr->SetText("");
                    $this->req_orden->SetText("");
                    $this->req_est_id->SetText($this->FormParameters["req_est_id"][$this->RowNumber], $this->RowNumber);
                    $this->req_plano_id->SetText($this->FormParameters["req_plano_id"][$this->RowNumber], $this->RowNumber);
                    $this->req_id->SetText($this->FormParameters["req_id"][$this->RowNumber], $this->RowNumber);
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->req_est_id->Show($this->RowNumber);
                $this->req_descr->Show($this->RowNumber);
                $this->req_orden->Show($this->RowNumber);
                $this->req_plano_id->Show($this->RowNumber);
                $this->req_id->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["req_id"] == $this->CachedColumns["req_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["req_plano_id"] == $this->CachedColumns["req_plano_id"][$this->RowNumber])) {
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

} //End requisitos Class @39-FCB6E20C

class clsrequisitosDataSource extends clsDBtdf_nuevo {  //requisitosDataSource Class @39-084A6583

//DataSource Variables @39-4DBA25C5
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

    // Datasource fields
    public $req_est_id;
    public $req_descr;
    public $req_orden;
    public $req_plano_id;
    public $req_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @39-E31CD464
    function clsrequisitosDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid requisitos/Error";
        $this->Initialize();
        $this->req_est_id = new clsField("req_est_id", ccsInteger, "");
        
        $this->req_descr = new clsField("req_descr", ccsText, "");
        
        $this->req_orden = new clsField("req_orden", ccsText, "");
        
        $this->req_plano_id = new clsField("req_plano_id", ccsText, "");
        
        $this->req_id = new clsField("req_id", ccsInteger, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @39-DFA74175
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "requisitos.req_orden";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @39-D1204E09
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlplano_id", ccsInteger, "", "", $this->Parameters["urlplano_id"], 0, false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
    }
//End Prepare Method

//Open Method @39-48871936
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*) FROM requisitos \n" .
        "LEFT JOIN requisitos_planos ON requisitos.req_id = requisitos_planos.req_id\n" .
        "AND requisitos_planos.plano_id = " . $this->SQLValue($this->wp->GetDBValue("1"), ccsInteger) . "";
        $this->SQL = "SELECT req_descr, requisitos.req_id AS req_id, IFNULL(req_est_id,3) req_est_id, \n" .
        "req_orden, req_plano_id \n" .
        "FROM requisitos \n" .
        "LEFT JOIN requisitos_planos ON requisitos.req_id = requisitos_planos.req_id\n" .
        "AND requisitos_planos.plano_id = " . $this->SQLValue($this->wp->GetDBValue("1"), ccsInteger) . " {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @39-13F0DF8F
    function SetValues()
    {
        $this->CachedColumns["req_id"] = $this->f("req_id");
        $this->CachedColumns["req_plano_id"] = $this->f("req_plano_id");
        $this->req_est_id->SetDBValue(trim($this->f("req_est_id")));
        $this->req_descr->SetDBValue($this->f("req_descr"));
        $this->req_orden->SetDBValue($this->f("req_orden"));
        $this->req_plano_id->SetDBValue($this->f("req_plano_id"));
        $this->req_id->SetDBValue(trim($this->f("req_id")));
    }
//End SetValues Method

//Update Method @39-93B7C1B8
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->SQL = "select 1";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

} //End requisitosDataSource Class @39-FCB6E20C

//Include Page implementation @84-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Initialize Page @1-BD6F7641
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
$TemplateFileName = "tc_docGrid.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-CBFD1E0E
CCSecurityRedirect("1;2", "../tdf_restricted.php");
//End Authenticate User

//Include events file @1-2A9E0856
include_once("./tc_docGrid_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-C788F8F4
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$departamentos_planos_plan = new clsGriddepartamentos_planos_plan("", $MainPage);
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$requisitos = new clsEditableGridrequisitos("", $MainPage);
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$MainPage->departamentos_planos_plan = & $departamentos_planos_plan;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->requisitos = & $requisitos;
$MainPage->tdf_menu = & $tdf_menu;
$departamentos_planos_plan->Initialize();
$requisitos->Initialize();

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

//Execute Components @1-E230BFD3
$tdf_header->Operations();
$tdf_footer->Operations();
$requisitos->Operation();
$tdf_menu->Operations();
//End Execute Components

//Go to destination page @1-E37BE179
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    unset($departamentos_planos_plan);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($requisitos);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-4F2039A7
$departamentos_planos_plan->Show();
$tdf_header->Show();
$tdf_footer->Show();
$requisitos->Show();
$tdf_menu->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font face=" . "\"Arial\"><small>G&#101" . ";n&#101;r&#97;t&#10" . "1;d <!-- SCC -->&" . "#119;&#105;&#116;h " . "<!-- SCC -->&#67;od" . "eC&#104;arge <!-- CCS " . "-->&#83;&#116;&#11" . "7;&#100;io.</small" . "></font></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font face=" . "\"Arial\"><small>G&#101" . ";n&#101;r&#97;t&#10" . "1;d <!-- SCC -->&" . "#119;&#105;&#116;h " . "<!-- SCC -->&#67;od" . "eC&#104;arge <!-- CCS " . "-->&#83;&#116;&#11" . "7;&#100;io.</small" . "></font></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font face=" . "\"Arial\"><small>G&#101" . ";n&#101;r&#97;t&#10" . "1;d <!-- SCC -->&" . "#119;&#105;&#116;h " . "<!-- SCC -->&#67;od" . "eC&#104;arge <!-- CCS " . "-->&#83;&#116;&#11" . "7;&#100;io.</small" . "></font></center>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-7C5DA5C9
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($departamentos_planos_plan);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($requisitos);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($Tpl);
//End Unload Page


?>
