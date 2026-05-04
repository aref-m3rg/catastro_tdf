<?php
//Include Common Files @1-82BB320B
define("RelativePath", "..");
define("PathToCurrentPage", "/piezas/");
define("FileName", "msa_pase.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @53-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @54-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @55-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

class clsGridpiezas_piezas_tipos { //piezas_piezas_tipos class @2-03C1D75A

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

//Class_Initialize Event @2-5D0F82F4
    function clsGridpiezas_piezas_tipos($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "piezas_piezas_tipos";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid piezas_piezas_tipos";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clspiezas_piezas_tiposDataSource($this);
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

        $this->pieza_descripcion = new clsControl(ccsLabel, "pieza_descripcion", "pieza_descripcion", ccsText, "", CCGetRequestParam("pieza_descripcion", ccsGet, NULL), $this);
        $this->pieza_f_alta = new clsControl(ccsLabel, "pieza_f_alta", "pieza_f_alta", ccsDate, $DefaultDateFormat, CCGetRequestParam("pieza_f_alta", ccsGet, NULL), $this);
        $this->pieza_tipo_desc = new clsControl(ccsLabel, "pieza_tipo_desc", "pieza_tipo_desc", ccsText, "", CCGetRequestParam("pieza_tipo_desc", ccsGet, NULL), $this);
        $this->pieza = new clsControl(ccsLabel, "pieza", "pieza", ccsText, "", CCGetRequestParam("pieza", ccsGet, NULL), $this);
        $this->externo = new clsControl(ccsLabel, "externo", "externo", ccsText, "", CCGetRequestParam("externo", ccsGet, NULL), $this);
        $this->externo->HTML = true;
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

//Show Method @2-C99E43AC
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlpieza_id"] = CCGetFromGet("pieza_id", NULL);

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
            $this->ControlsVisible["pieza_descripcion"] = $this->pieza_descripcion->Visible;
            $this->ControlsVisible["pieza_f_alta"] = $this->pieza_f_alta->Visible;
            $this->ControlsVisible["pieza_tipo_desc"] = $this->pieza_tipo_desc->Visible;
            $this->ControlsVisible["pieza"] = $this->pieza->Visible;
            $this->ControlsVisible["externo"] = $this->externo->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->pieza_descripcion->SetValue($this->DataSource->pieza_descripcion->GetValue());
                $this->pieza_f_alta->SetValue($this->DataSource->pieza_f_alta->GetValue());
                $this->pieza_tipo_desc->SetValue($this->DataSource->pieza_tipo_desc->GetValue());
                $this->pieza->SetValue($this->DataSource->pieza->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->pieza_descripcion->Show();
                $this->pieza_f_alta->Show();
                $this->pieza_tipo_desc->Show();
                $this->pieza->Show();
                $this->externo->Show();
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

//GetErrors Method @2-9574374B
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->pieza_descripcion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pieza_f_alta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pieza_tipo_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pieza->Errors->ToString());
        $errors = ComposeStrings($errors, $this->externo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End piezas_piezas_tipos Class @2-FCB6E20C

class clspiezas_piezas_tiposDataSource extends clsDBmesa {  //piezas_piezas_tiposDataSource Class @2-4119DF9D

//DataSource Variables @2-A07088D0
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $pieza_descripcion;
    public $pieza_f_alta;
    public $pieza_tipo_desc;
    public $pieza;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-C1574A3B
    function clspiezas_piezas_tiposDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid piezas_piezas_tipos";
        $this->Initialize();
        $this->pieza_descripcion = new clsField("pieza_descripcion", ccsText, "");
        
        $this->pieza_f_alta = new clsField("pieza_f_alta", ccsDate, $this->DateFormat);
        
        $this->pieza_tipo_desc = new clsField("pieza_tipo_desc", ccsText, "");
        
        $this->pieza = new clsField("pieza", ccsText, "");
        

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

//Prepare Method @2-265B239B
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlpieza_id", ccsInteger, "", "", $this->Parameters["urlpieza_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "piezas.pieza_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-5DBFC491
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM piezas INNER JOIN piezas_tipos ON\n\n" .
        "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id";
        $this->SQL = "SELECT CONCAT_WS('-',pieza_nro,pieza_letra,pieza_anio) AS pieza, pieza_tipo_desc, pieza_descripcion, pieza_f_alta \n\n" .
        "FROM piezas INNER JOIN piezas_tipos ON\n\n" .
        "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-31387FB5
    function SetValues()
    {
        $this->pieza_descripcion->SetDBValue($this->f("pieza_descripcion"));
        $this->pieza_f_alta->SetDBValue(trim($this->f("pieza_f_alta")));
        $this->pieza_tipo_desc->SetDBValue($this->f("pieza_tipo_desc"));
        $this->pieza->SetDBValue($this->f("pieza"));
    }
//End SetValues Method

} //End piezas_piezas_tiposDataSource Class @2-FCB6E20C

class clsRecordpase { //pase Class @22-AB046C9F

//Variables @22-9E315808

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

//Class_Initialize Event @22-CD63CB3A
    function clsRecordpase($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record pase/Error";
        $this->DataSource = new clspaseDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "pase";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->pase_n_fojas = new clsControl(ccsTextBox, "pase_n_fojas", "Nro de Fojas", ccsText, "", CCGetRequestParam("pase_n_fojas", $Method, NULL), $this);
            $this->pase_n_fojas->Required = true;
            $this->pase_comentario = new clsControl(ccsTextArea, "pase_comentario", "pase_comentario", ccsText, "", CCGetRequestParam("pase_comentario", $Method, NULL), $this);
            $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->des_unidad_id = new clsControl(ccsListBox, "des_unidad_id", "Destino", ccsInteger, "", CCGetRequestParam("des_unidad_id", $Method, NULL), $this);
            $this->des_unidad_id->DSType = dsTable;
            $this->des_unidad_id->DataSource = new clsDBunidades();
            $this->des_unidad_id->ds = & $this->des_unidad_id->DataSource;
            $this->des_unidad_id->DataSource->SQL = "SELECT CONCAT(RPAD(unidad_nombre,35,'_'),'(',IFNULL(unidad_p_responsable,'Sin Referente'),')') AS descripcion, unidades.unidad_id AS unidad_id,\n" .
"unidades_tipo_tramites.* \n" .
"FROM (unidades INNER JOIN unidades_param ON\n" .
"unidades_param.unidad_id = unidades.unidad_id) INNER JOIN unidades_tipo_tramites ON\n" .
"unidades_tipo_tramites.unidad_id = unidades.unidad_id {SQL_Where}\n" .
"GROUP BY unidades_tipo_tramites.unidad_id {SQL_OrderBy}";
            $this->des_unidad_id->DataSource->Order = "unidades.unidad_nombre";
            list($this->des_unidad_id->BoundColumn, $this->des_unidad_id->TextColumn, $this->des_unidad_id->DBFormat) = array("unidad_id", "descripcion", "");
            $this->des_unidad_id->DataSource->Parameters["urltipo_tramites_id"] = CCGetFromGet("tipo_tramites_id", NULL);
            $this->des_unidad_id->DataSource->Parameters["expr57"] = 1;
            $this->des_unidad_id->DataSource->Parameters["postentorno_id"] = CCGetFromPost("entorno_id", NULL);
            $this->des_unidad_id->DataSource->Parameters["sesunidad_id"] = CCGetSession("unidad_id", NULL);
            $this->des_unidad_id->DataSource->wp = new clsSQLParameters();
            $this->des_unidad_id->DataSource->wp->AddParameter("1", "urltipo_tramites_id", ccsInteger, "", "", $this->des_unidad_id->DataSource->Parameters["urltipo_tramites_id"], "", false);
            $this->des_unidad_id->DataSource->wp->AddParameter("2", "expr57", ccsInteger, "", "", $this->des_unidad_id->DataSource->Parameters["expr57"], "", false);
            $this->des_unidad_id->DataSource->wp->AddParameter("3", "postentorno_id", ccsInteger, "", "", $this->des_unidad_id->DataSource->Parameters["postentorno_id"], 1, false);
            $this->des_unidad_id->DataSource->wp->AddParameter("4", "sesunidad_id", ccsInteger, "", "", $this->des_unidad_id->DataSource->Parameters["sesunidad_id"], "", false);
            $this->des_unidad_id->DataSource->wp->Criterion[1] = $this->des_unidad_id->DataSource->wp->Operation(opEqual, "unidades_tipo_tramites.tipo_tramites_id", $this->des_unidad_id->DataSource->wp->GetDBValue("1"), $this->des_unidad_id->DataSource->ToSQL($this->des_unidad_id->DataSource->wp->GetDBValue("1"), ccsInteger),false);
            $this->des_unidad_id->DataSource->wp->Criterion[2] = $this->des_unidad_id->DataSource->wp->Operation(opEqual, "unidades.estado_id", $this->des_unidad_id->DataSource->wp->GetDBValue("2"), $this->des_unidad_id->DataSource->ToSQL($this->des_unidad_id->DataSource->wp->GetDBValue("2"), ccsInteger),false);
            $this->des_unidad_id->DataSource->wp->Criterion[3] = $this->des_unidad_id->DataSource->wp->Operation(opEqual, "unidades.entorno_id", $this->des_unidad_id->DataSource->wp->GetDBValue("3"), $this->des_unidad_id->DataSource->ToSQL($this->des_unidad_id->DataSource->wp->GetDBValue("3"), ccsInteger),false);
            $this->des_unidad_id->DataSource->wp->Criterion[4] = $this->des_unidad_id->DataSource->wp->Operation(opNotEqual, "unidades_tipo_tramites.unidad_id", $this->des_unidad_id->DataSource->wp->GetDBValue("4"), $this->des_unidad_id->DataSource->ToSQL($this->des_unidad_id->DataSource->wp->GetDBValue("4"), ccsInteger),false);
            $this->des_unidad_id->DataSource->Where = $this->des_unidad_id->DataSource->wp->opAND(
                 false, $this->des_unidad_id->DataSource->wp->opAND(
                 false, $this->des_unidad_id->DataSource->wp->opAND(
                 false, 
                 $this->des_unidad_id->DataSource->wp->Criterion[1], 
                 $this->des_unidad_id->DataSource->wp->Criterion[2]), 
                 $this->des_unidad_id->DataSource->wp->Criterion[3]), 
                 $this->des_unidad_id->DataSource->wp->Criterion[4]);
            $this->des_unidad_id->DataSource->Order = "unidades.unidad_nombre";
            $this->des_unidad_id->Required = true;
            $this->Panel1 = new clsPanel("Panel1", $this);
            $this->entorno_id = new clsControl(ccsListBox, "entorno_id", "entorno_id", ccsText, "", CCGetRequestParam("entorno_id", $Method, NULL), $this);
            $this->entorno_id->DSType = dsTable;
            $this->entorno_id->DataSource = new clsDBmesa();
            $this->entorno_id->ds = & $this->entorno_id->DataSource;
            $this->entorno_id->DataSource->SQL = "SELECT * \n" .
"FROM entornos {SQL_Where} {SQL_OrderBy}";
            list($this->entorno_id->BoundColumn, $this->entorno_id->TextColumn, $this->entorno_id->DBFormat) = array("entorno_id", "entorno_desc", "");
            $this->pase_confir_ext = new clsControl(ccsCheckBox, "pase_confir_ext", "pase_confir_ext", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("pase_confir_ext", $Method, NULL), $this);
            $this->pase_confir_ext->CheckedValue = true;
            $this->pase_confir_ext->UncheckedValue = false;
            $this->unidad_id = new clsControl(ccsHidden, "unidad_id", "unidad_id", ccsText, "", CCGetRequestParam("unidad_id", $Method, NULL), $this);
            $this->Panel1->AddComponent("entorno_id", $this->entorno_id);
            $this->Panel1->AddComponent("pase_confir_ext", $this->pase_confir_ext);
            if(!$this->FormSubmitted) {
                if(!is_array($this->entorno_id->Value) && !strlen($this->entorno_id->Value) && $this->entorno_id->Value !== false)
                    $this->entorno_id->SetText(1);
                if(!is_array($this->pase_confir_ext->Value) && !strlen($this->pase_confir_ext->Value) && $this->pase_confir_ext->Value !== false)
                    $this->pase_confir_ext->SetValue(false);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @22-5D060BAC
    function Initialize()
    {

        if(!$this->Visible)
            return;

    }
//End Initialize Method

//Validate Method @22-D36EE9C9
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->pase_n_fojas->Validate() && $Validation);
        $Validation = ($this->pase_comentario->Validate() && $Validation);
        $Validation = ($this->des_unidad_id->Validate() && $Validation);
        $Validation = ($this->entorno_id->Validate() && $Validation);
        $Validation = ($this->pase_confir_ext->Validate() && $Validation);
        $Validation = ($this->unidad_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->pase_n_fojas->Errors->Count() == 0);
        $Validation =  $Validation && ($this->pase_comentario->Errors->Count() == 0);
        $Validation =  $Validation && ($this->des_unidad_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->entorno_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->pase_confir_ext->Errors->Count() == 0);
        $Validation =  $Validation && ($this->unidad_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @22-FFDD062F
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->pase_n_fojas->Errors->Count());
        $errors = ($errors || $this->pase_comentario->Errors->Count());
        $errors = ($errors || $this->des_unidad_id->Errors->Count());
        $errors = ($errors || $this->entorno_id->Errors->Count());
        $errors = ($errors || $this->pase_confir_ext->Errors->Count());
        $errors = ($errors || $this->unidad_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @22-ED598703
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

//Operation Method @22-232354FC
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        $this->DataSource->Prepare();
        if(!$this->FormSubmitted) {
            $this->EditMode = true;
            return;
        }

        if($this->FormSubmitted) {
            $this->PressedButton = "Button_Insert";
            if($this->Button_Insert->Pressed) {
                $this->PressedButton = "Button_Insert";
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            }
        }
        $Redirect = "msa_principal.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "pieza_id"));
        if($this->PressedButton == "Button_Cancel") {
            $Redirect = "msa_principal.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "pieza_id", "tipo_tramites_id"));
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Insert") {
                $Redirect = "msa_principal.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "pieza_id", "tipo_tramites_id"));
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
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

//InsertRow Method @22-2B6A5BEC
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//Show Method @22-4FBABEEC
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

        $this->des_unidad_id->Prepare();
        $this->entorno_id->Prepare();

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
                    $this->des_unidad_id->SetValue($this->DataSource->des_unidad_id->GetValue());
                    $this->pase_confir_ext->SetValue($this->DataSource->pase_confir_ext->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->pase_n_fojas->Errors->ToString());
            $Error = ComposeStrings($Error, $this->pase_comentario->Errors->ToString());
            $Error = ComposeStrings($Error, $this->des_unidad_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->entorno_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->pase_confir_ext->Errors->ToString());
            $Error = ComposeStrings($Error, $this->unidad_id->Errors->ToString());
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

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->pase_n_fojas->Show();
        $this->pase_comentario->Show();
        $this->Button_Insert->Show();
        $this->Button_Cancel->Show();
        $this->des_unidad_id->Show();
        $this->Panel1->Show();
        $this->unidad_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End pase Class @22-FCB6E20C

class clspaseDataSource extends clsDBmesa {  //paseDataSource Class @22-1D668E6F

//DataSource Variables @22-A42099E6
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $wp;
    public $AllParametersSet;


    // Datasource fields
    public $pase_n_fojas;
    public $pase_comentario;
    public $des_unidad_id;
    public $entorno_id;
    public $pase_confir_ext;
    public $unidad_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @22-8F697AE6
    function clspaseDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record pase/Error";
        $this->Initialize();
        $this->pase_n_fojas = new clsField("pase_n_fojas", ccsText, "");
        
        $this->pase_comentario = new clsField("pase_comentario", ccsText, "");
        
        $this->des_unidad_id = new clsField("des_unidad_id", ccsInteger, "");
        
        $this->entorno_id = new clsField("entorno_id", ccsText, "");
        
        $this->pase_confir_ext = new clsField("pase_confir_ext", ccsBoolean, $this->BooleanFormat);
        
        $this->unidad_id = new clsField("unidad_id", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//Prepare Method @22-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @22-30D3AF4D
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM pases {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @22-BC6F1F41
    function SetValues()
    {
        $this->des_unidad_id->SetDBValue(trim($this->f("des_unidad_id")));
        $this->pase_confir_ext->SetDBValue(trim($this->f("pase_confir_ext")));
    }
//End SetValues Method

//Insert Method @22-41CA6C84
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->SQL = "select 1";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

} //End paseDataSource Class @22-FCB6E20C



//Initialize Page @1-69869756
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
$TemplateFileName = "msa_pase.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-9319C648
include_once("./msa_pase_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-E851909F
$DBmesa = new clsDBmesa();
$MainPage->Connections["mesa"] = & $DBmesa;
$DBunidades = new clsDBunidades();
$MainPage->Connections["unidades"] = & $DBunidades;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$piezas_piezas_tipos = new clsGridpiezas_piezas_tipos("", $MainPage);
$pase = new clsRecordpase("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->piezas_piezas_tipos = & $piezas_piezas_tipos;
$MainPage->pase = & $pase;
$piezas_piezas_tipos->Initialize();
$pase->Initialize();

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

//Execute Components @1-7637D743
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
$pase->Operation();
//End Execute Components

//Go to destination page @1-AC410E77
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBmesa->close();
    $DBunidades->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($piezas_piezas_tipos);
    unset($pase);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-085E4367
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$piezas_piezas_tipos->Show();
$pase->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font face=\"Arial\"><small>&#71;en&#101;ra&#116;&#101;d <!-- CCS -->&#119;i&#116;h <!-- CCS -->&#67;&#111;de&#67;ha&#114;ge <!-- SCC -->S&#116;ud&#105;o.</small></font></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font face=\"Arial\"><small>&#71;en&#101;ra&#116;&#101;d <!-- CCS -->&#119;i&#116;h <!-- CCS -->&#67;&#111;de&#67;ha&#114;ge <!-- SCC -->S&#116;ud&#105;o.</small></font></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font face=\"Arial\"><small>&#71;en&#101;ra&#116;&#101;d <!-- CCS -->&#119;i&#116;h <!-- CCS -->&#67;&#111;de&#67;ha&#114;ge <!-- SCC -->S&#116;ud&#105;o.</small></font></center>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-44B40CDE
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmesa->close();
$DBunidades->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($piezas_piezas_tipos);
unset($pase);
unset($Tpl);
//End Unload Page


?>
