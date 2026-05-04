<?php
//Include Common Files @1-22990F74
define("RelativePath", "..");
define("PathToCurrentPage", "/piezas/");
define("FileName", "msa_adjuntar.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files



//Include Page implementation @100-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @101-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @102-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

class clsGridpiezas_piezas_tipos_trami { //piezas_piezas_tipos_trami class @2-739B4FF9

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

//Class_Initialize Event @2-0FBD3B14
    function clsGridpiezas_piezas_tipos_trami($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "piezas_piezas_tipos_trami";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid piezas_piezas_tipos_trami";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clspiezas_piezas_tipos_tramiDataSource($this);
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

        $this->pieza_iniciador = new clsControl(ccsLabel, "pieza_iniciador", "pieza_iniciador", ccsText, "", CCGetRequestParam("pieza_iniciador", ccsGet, NULL), $this);
        $this->pieza_tipo_desc = new clsControl(ccsLabel, "pieza_tipo_desc", "pieza_tipo_desc", ccsText, "", CCGetRequestParam("pieza_tipo_desc", ccsGet, NULL), $this);
        $this->pieza = new clsControl(ccsLabel, "pieza", "pieza", ccsText, "", CCGetRequestParam("pieza", ccsGet, NULL), $this);
        $this->tramite_desc = new clsControl(ccsLabel, "tramite_desc", "tramite_desc", ccsText, "", CCGetRequestParam("tramite_desc", ccsGet, NULL), $this);
        $this->pieza_f_alta = new clsControl(ccsLabel, "pieza_f_alta", "pieza_f_alta", ccsDate, $DefaultDateFormat, CCGetRequestParam("pieza_f_alta", ccsGet, NULL), $this);
        $this->unidad_p_nombre = new clsControl(ccsLabel, "unidad_p_nombre", "unidad_p_nombre", ccsText, "", CCGetRequestParam("unidad_p_nombre", ccsGet, NULL), $this);
        $this->entorno_desc = new clsControl(ccsLabel, "entorno_desc", "entorno_desc", ccsText, "", CCGetRequestParam("entorno_desc", ccsGet, NULL), $this);
        $this->pieza_descripcion = new clsControl(ccsLabel, "pieza_descripcion", "pieza_descripcion", ccsText, "", CCGetRequestParam("pieza_descripcion", ccsGet, NULL), $this);
        $this->pieza_observaciones = new clsControl(ccsLabel, "pieza_observaciones", "pieza_observaciones", ccsText, "", CCGetRequestParam("pieza_observaciones", ccsGet, NULL), $this);
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

//Show Method @2-22CC9840
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlpieza_id"] = CCGetFromGet("pieza_id", NULL);
        $this->DataSource->Parameters["expr13"] = 1;

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
            $this->ControlsVisible["pieza_iniciador"] = $this->pieza_iniciador->Visible;
            $this->ControlsVisible["pieza_tipo_desc"] = $this->pieza_tipo_desc->Visible;
            $this->ControlsVisible["pieza"] = $this->pieza->Visible;
            $this->ControlsVisible["tramite_desc"] = $this->tramite_desc->Visible;
            $this->ControlsVisible["pieza_f_alta"] = $this->pieza_f_alta->Visible;
            $this->ControlsVisible["unidad_p_nombre"] = $this->unidad_p_nombre->Visible;
            $this->ControlsVisible["entorno_desc"] = $this->entorno_desc->Visible;
            $this->ControlsVisible["pieza_descripcion"] = $this->pieza_descripcion->Visible;
            $this->ControlsVisible["pieza_observaciones"] = $this->pieza_observaciones->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->pieza_iniciador->SetValue($this->DataSource->pieza_iniciador->GetValue());
                $this->pieza_tipo_desc->SetValue($this->DataSource->pieza_tipo_desc->GetValue());
                $this->pieza->SetValue($this->DataSource->pieza->GetValue());
                $this->tramite_desc->SetValue($this->DataSource->tramite_desc->GetValue());
                $this->pieza_f_alta->SetValue($this->DataSource->pieza_f_alta->GetValue());
                $this->unidad_p_nombre->SetValue($this->DataSource->unidad_p_nombre->GetValue());
                $this->entorno_desc->SetValue($this->DataSource->entorno_desc->GetValue());
                $this->pieza_descripcion->SetValue($this->DataSource->pieza_descripcion->GetValue());
                $this->pieza_observaciones->SetValue($this->DataSource->pieza_observaciones->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->pieza_iniciador->Show();
                $this->pieza_tipo_desc->Show();
                $this->pieza->Show();
                $this->tramite_desc->Show();
                $this->pieza_f_alta->Show();
                $this->unidad_p_nombre->Show();
                $this->entorno_desc->Show();
                $this->pieza_descripcion->Show();
                $this->pieza_observaciones->Show();
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

//GetErrors Method @2-43C7C15F
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->pieza_iniciador->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pieza_tipo_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pieza->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tramite_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pieza_f_alta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->unidad_p_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->entorno_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pieza_descripcion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pieza_observaciones->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End piezas_piezas_tipos_trami Class @2-FCB6E20C

class clspiezas_piezas_tipos_tramiDataSource extends clsDBmesa {  //piezas_piezas_tipos_tramiDataSource Class @2-70A9BED9

//DataSource Variables @2-476CBC1E
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $pieza_iniciador;
    public $pieza_tipo_desc;
    public $pieza;
    public $tramite_desc;
    public $pieza_f_alta;
    public $unidad_p_nombre;
    public $entorno_desc;
    public $pieza_descripcion;
    public $pieza_observaciones;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-6DECF42F
    function clspiezas_piezas_tipos_tramiDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid piezas_piezas_tipos_trami";
        $this->Initialize();
        $this->pieza_iniciador = new clsField("pieza_iniciador", ccsText, "");
        
        $this->pieza_tipo_desc = new clsField("pieza_tipo_desc", ccsText, "");
        
        $this->pieza = new clsField("pieza", ccsText, "");
        
        $this->tramite_desc = new clsField("tramite_desc", ccsText, "");
        
        $this->pieza_f_alta = new clsField("pieza_f_alta", ccsDate, $this->DateFormat);
        
        $this->unidad_p_nombre = new clsField("unidad_p_nombre", ccsText, "");
        
        $this->entorno_desc = new clsField("entorno_desc", ccsText, "");
        
        $this->pieza_descripcion = new clsField("pieza_descripcion", ccsText, "");
        
        $this->pieza_observaciones = new clsField("pieza_observaciones", ccsText, "");
        

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

//Prepare Method @2-F239C0D0
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlpieza_id", ccsInteger, "", "", $this->Parameters["urlpieza_id"], "", false);
        $this->wp->AddParameter("2", "expr13", ccsInteger, "", "", $this->Parameters["expr13"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "piezas.pieza_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "unidades_param.unidad_p_activo", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @2-E1095EF3
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (((piezas INNER JOIN piezas_tipos ON\n\n" .
        "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) INNER JOIN tramites ON\n\n" .
        "piezas.tramite_id = tramites.tramite_id) INNER JOIN unidades_param ON\n\n" .
        "piezas.unidad_id = unidades_param.unidad_id) INNER JOIN entornos ON\n\n" .
        "piezas.entorno_id = entornos.entorno_id";
        $this->SQL = "SELECT pieza_tipo_desc, tramite_desc, unidad_p_nombre, CONCAT_WS('-',pieza_nro,pieza_letra,pieza_anio) AS pieza, pieza_id, pieza_iniciador,\n\n" .
        "pieza_descripcion, pieza_f_alta, piezas_tipos.pieza_tipo_id AS tipo, pieza_observaciones, piezas.unidad_id AS unidad_id,\n\n" .
        "entorno_desc \n\n" .
        "FROM (((piezas INNER JOIN piezas_tipos ON\n\n" .
        "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) INNER JOIN tramites ON\n\n" .
        "piezas.tramite_id = tramites.tramite_id) INNER JOIN unidades_param ON\n\n" .
        "piezas.unidad_id = unidades_param.unidad_id) INNER JOIN entornos ON\n\n" .
        "piezas.entorno_id = entornos.entorno_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-14E4F044
    function SetValues()
    {
        $this->pieza_iniciador->SetDBValue($this->f("pieza_iniciador"));
        $this->pieza_tipo_desc->SetDBValue($this->f("pieza_tipo_desc"));
        $this->pieza->SetDBValue($this->f("pieza"));
        $this->tramite_desc->SetDBValue($this->f("tramite_desc"));
        $this->pieza_f_alta->SetDBValue(trim($this->f("pieza_f_alta")));
        $this->unidad_p_nombre->SetDBValue($this->f("unidad_p_nombre"));
        $this->entorno_desc->SetDBValue($this->f("entorno_desc"));
        $this->pieza_descripcion->SetDBValue($this->f("pieza_descripcion"));
        $this->pieza_observaciones->SetDBValue($this->f("pieza_observaciones"));
    }
//End SetValues Method

} //End piezas_piezas_tipos_tramiDataSource Class @2-FCB6E20C

class clsEditableGridarea { //area Class @103-31688929

//Variables @103-F9538F3C

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

//Class_Initialize Event @103-200A1DB0
    function clsEditableGridarea($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid area/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "area";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["piezas.pieza_id"][0] = "piezas.pieza_id";
        $this->CachedColumns["pase_id"][0] = "pase_id";
        $this->CachedColumns["pieza_id"][0] = "pieza_id";
        $this->CachedColumns["pieza_tipo_id"][0] = "pieza_tipo_id";
        $this->CachedColumns["adjunto_id"][0] = "adjunto_id";
        $this->CachedColumns["entorno_id"][0] = "entorno_id";
        $this->DataSource = new clsareaDataSource($this);
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

        $this->pieza_tipo_abrev = new clsControl(ccsLabel, "pieza_tipo_abrev", "Pieza Tipo Abrev", ccsText, "", NULL, $this);
        $this->pieza = new clsControl(ccsLabel, "pieza", "Pieza", ccsText, "", NULL, $this);
        $this->pase_n_fojas = new clsControl(ccsLabel, "pase_n_fojas", "Pase N Fojas", ccsInteger, "", NULL, $this);
        $this->pieza_tm_nro = new clsControl(ccsLabel, "pieza_tm_nro", "Pieza Tm Nro", ccsInteger, "", NULL, $this);
        $this->pieza_descripcion = new clsControl(ccsLabel, "pieza_descripcion", "Pieza Descripcion", ccsText, "", NULL, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->pieza_f_alta = new clsControl(ccsLabel, "pieza_f_alta", "pieza_f_alta", ccsDate, $DefaultDateFormat, NULL, $this);
        $this->entorno_abrev = new clsControl(ccsLabel, "entorno_abrev", "entorno_abrev", ccsText, "", NULL, $this);
        $this->chk = new clsControl(ccsCheckBox, "chk", "chk", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), NULL, $this);
        $this->chk->CheckedValue = true;
        $this->chk->UncheckedValue = false;
        $this->adj_tipo_id = new clsControl(ccsListBox, "adj_tipo_id", "adj_tipo_id", ccsInteger, "", NULL, $this);
        $this->adj_tipo_id->DSType = dsTable;
        $this->adj_tipo_id->DataSource = new clsDBmesa();
        $this->adj_tipo_id->ds = & $this->adj_tipo_id->DataSource;
        $this->adj_tipo_id->DataSource->SQL = "SELECT * \n" .
"FROM adjuntos_tipos {SQL_Where} {SQL_OrderBy}";
        list($this->adj_tipo_id->BoundColumn, $this->adj_tipo_id->TextColumn, $this->adj_tipo_id->DBFormat) = array("adj_tipo_id", "adj_tipo_desc", "");
        $this->Button1 = new clsButton("Button1", $Method, $this);
        $this->pieza_id = new clsControl(ccsHidden, "pieza_id", "pieza_id", ccsInteger, "", NULL, $this);
        $this->Button2 = new clsButton("Button2", $Method, $this);
    }
//End Class_Initialize Event

//Initialize Method @103-EBB5AE25
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["expr123"] = 1;
        $this->DataSource->Parameters["expr124"] = 1;
        $this->DataSource->Parameters["sesunidad_id"] = CCGetSession("unidad_id", NULL);
        $this->DataSource->Parameters["expr126"] = 1;
        $this->DataSource->Parameters["expr127"] = 1;
        $this->DataSource->Parameters["urls_pieza_nro"] = CCGetFromGet("s_pieza_nro", NULL);
        $this->DataSource->Parameters["urls_pieza_letra"] = CCGetFromGet("s_pieza_letra", NULL);
        $this->DataSource->Parameters["urls_pieza_anio"] = CCGetFromGet("s_pieza_anio", NULL);
        $this->DataSource->Parameters["urlpieza_id"] = CCGetFromGet("pieza_id", NULL);
    }
//End Initialize Method

//SetPrimaryKeys Method @103-EBC3F86C
    function SetPrimaryKeys($PrimaryKeys) {
        $this->PrimaryKeys = $PrimaryKeys;
        return $this->PrimaryKeys;
    }
//End SetPrimaryKeys Method

//GetPrimaryKeys Method @103-74F9A772
    function GetPrimaryKeys() {
        return $this->PrimaryKeys;
    }
//End GetPrimaryKeys Method

//GetFormParameters Method @103-61D18B9C
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["chk"][$RowNumber] = CCGetFromPost("chk_" . $RowNumber, NULL);
            $this->FormParameters["adj_tipo_id"][$RowNumber] = CCGetFromPost("adj_tipo_id_" . $RowNumber, NULL);
            $this->FormParameters["pieza_id"][$RowNumber] = CCGetFromPost("pieza_id_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @103-F2CA8434
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
            $this->DataSource->CachedColumns["adjunto_id"] = $this->CachedColumns["adjunto_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["entorno_id"] = $this->CachedColumns["entorno_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->chk->SetText($this->FormParameters["chk"][$this->RowNumber], $this->RowNumber);
            $this->adj_tipo_id->SetText($this->FormParameters["adj_tipo_id"][$this->RowNumber], $this->RowNumber);
            $this->pieza_id->SetText($this->FormParameters["pieza_id"][$this->RowNumber], $this->RowNumber);
            if ($this->UpdatedRows >= $this->RowNumber) {
                if(!$this->chk->Value)
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

//ValidateRow Method @103-B0294608
    function ValidateRow()
    {
        global $CCSLocales;
        $this->chk->Validate();
        $this->adj_tipo_id->Validate();
        $this->pieza_id->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->chk->Errors->ToString());
        $errors = ComposeStrings($errors, $this->adj_tipo_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pieza_id->Errors->ToString());
        $this->chk->Errors->Clear();
        $this->adj_tipo_id->Errors->Clear();
        $this->pieza_id->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @103-C03B0E8D
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["adj_tipo_id"][$this->RowNumber]) && count($this->FormParameters["adj_tipo_id"][$this->RowNumber])) || strlen($this->FormParameters["adj_tipo_id"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["pieza_id"][$this->RowNumber]) && count($this->FormParameters["pieza_id"][$this->RowNumber])) || strlen($this->FormParameters["pieza_id"][$this->RowNumber]));
        return $filed;
    }
//End CheckInsert Method

//CheckErrors Method @103-F5A3B433
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @103-DC70F336
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
        $this->PressedButton = "Button1";
        if($this->Button1->Pressed) {
            $this->PressedButton = "Button1";
        } else if($this->Button2->Pressed) {
            $this->PressedButton = "Button2";
        }

        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button1") {
            if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1) || !$this->UpdateGrid()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button2") {
            if(!CCGetEvent($this->Button2->CCSEvents, "OnClick", $this->Button2)) {
                $Redirect = "";
            } else {
                $Redirect = "msa_principal.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
            }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//UpdateGrid Method @103-B1E6404A
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
            $this->DataSource->CachedColumns["adjunto_id"] = $this->CachedColumns["adjunto_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["entorno_id"] = $this->CachedColumns["entorno_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->chk->SetText($this->FormParameters["chk"][$this->RowNumber], $this->RowNumber);
            $this->adj_tipo_id->SetText($this->FormParameters["adj_tipo_id"][$this->RowNumber], $this->RowNumber);
            $this->pieza_id->SetText($this->FormParameters["pieza_id"][$this->RowNumber], $this->RowNumber);
            if ($this->UpdatedRows >= $this->RowNumber) {
                if($this->chk->Value) {
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

//DeleteRow Method @103-A4A656F6
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

//FormScript Method @103-9D01328D
    function FormScript($TotalRows)
    {
        $script = "";
        $script .= "\n<script language=\"JavaScript\" type=\"text/javascript\">\n<!--\n";
        $script .= "var areaElements;\n";
        $script .= "var areaEmptyRows = 0;\n";
        $script .= "var " . $this->ComponentName . "DeleteControl = 0;\n";
        $script .= "var " . $this->ComponentName . "adj_tipo_idID = 1;\n";
        $script .= "var " . $this->ComponentName . "pieza_idID = 2;\n";
        $script .= "\nfunction initareaElements() {\n";
        $script .= "\tvar ED = document.forms[\"area\"];\n";
        $script .= "\tareaElements = new Array (\n";
        for($i = 1; $i <= $TotalRows; $i++) {
            $script .= "\t\tnew Array(" . "ED.chk_" . $i . ", " . "ED.adj_tipo_id_" . $i . ", " . "ED.pieza_id_" . $i . ")";
            if($i != $TotalRows) $script .= ",\n";
        }
        $script .= ");\n";
        $script .= "}\n";
        $script .= "\n//-->\n</script>";
        return $script;
    }
//End FormScript Method

//SetFormState Method @103-8C69E069
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
                $this->CachedColumns["adjunto_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 5];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["entorno_id"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["piezas.pieza_id"][$RowNumber] = "";
                $this->CachedColumns["pase_id"][$RowNumber] = "";
                $this->CachedColumns["pieza_id"][$RowNumber] = "";
                $this->CachedColumns["pieza_tipo_id"][$RowNumber] = "";
                $this->CachedColumns["adjunto_id"][$RowNumber] = "";
                $this->CachedColumns["entorno_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @103-7D1B7353
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
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["adjunto_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["entorno_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @103-208BDAB8
    function Show()
    {
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        global $CCSUseAmp;
        $Error = "";

        if(!$this->Visible) { return; }

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->adj_tipo_id->Prepare();

        $this->DataSource->open();
        $is_next_record = ($this->ReadAllowed && $this->DataSource->next_record());
        $this->IsEmpty = ! $is_next_record;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) { return; }

        $this->Attributes->Show();
        $this->Button1->Visible = $this->Button1->Visible && ($this->InsertAllowed || $this->UpdateAllowed || $this->DeleteAllowed);
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
        $this->ControlsVisible["pieza_f_alta"] = $this->pieza_f_alta->Visible;
        $this->ControlsVisible["entorno_abrev"] = $this->entorno_abrev->Visible;
        $this->ControlsVisible["chk"] = $this->chk->Visible;
        $this->ControlsVisible["adj_tipo_id"] = $this->adj_tipo_id->Visible;
        $this->ControlsVisible["pieza_id"] = $this->pieza_id->Visible;
        if ($is_next_record || ($EmptyRowsLeft && $this->InsertAllowed)) {
            do {
                $this->RowNumber++;
                if($is_next_record) {
                    $NonEmptyRows++;
                    $this->DataSource->SetValues();
                }
                if (!($is_next_record) || !($this->DeleteAllowed)) {
                    $this->chk->Visible = false;
                }
                if (!($this->FormSubmitted) && $is_next_record) {
                    $this->CachedColumns["piezas.pieza_id"][$this->RowNumber] = $this->DataSource->CachedColumns["piezas.pieza_id"];
                    $this->CachedColumns["pase_id"][$this->RowNumber] = $this->DataSource->CachedColumns["pase_id"];
                    $this->CachedColumns["pieza_id"][$this->RowNumber] = $this->DataSource->CachedColumns["pieza_id"];
                    $this->CachedColumns["pieza_tipo_id"][$this->RowNumber] = $this->DataSource->CachedColumns["pieza_tipo_id"];
                    $this->CachedColumns["adjunto_id"][$this->RowNumber] = $this->DataSource->CachedColumns["adjunto_id"];
                    $this->CachedColumns["entorno_id"][$this->RowNumber] = $this->DataSource->CachedColumns["entorno_id"];
                    $this->chk->SetValue("");
                    $this->adj_tipo_id->SetText("");
                    $this->pieza_tipo_abrev->SetValue($this->DataSource->pieza_tipo_abrev->GetValue());
                    $this->pieza->SetValue($this->DataSource->pieza->GetValue());
                    $this->pase_n_fojas->SetValue($this->DataSource->pase_n_fojas->GetValue());
                    $this->pieza_tm_nro->SetValue($this->DataSource->pieza_tm_nro->GetValue());
                    $this->pieza_descripcion->SetValue($this->DataSource->pieza_descripcion->GetValue());
                    $this->pieza_f_alta->SetValue($this->DataSource->pieza_f_alta->GetValue());
                    $this->entorno_abrev->SetValue($this->DataSource->entorno_abrev->GetValue());
                    $this->pieza_id->SetValue($this->DataSource->pieza_id->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->pieza_tipo_abrev->SetText("");
                    $this->pieza->SetText("");
                    $this->pase_n_fojas->SetText("");
                    $this->pieza_tm_nro->SetText("");
                    $this->pieza_descripcion->SetText("");
                    $this->pieza_f_alta->SetText("");
                    $this->entorno_abrev->SetText("");
                    $this->pieza_tipo_abrev->SetValue($this->DataSource->pieza_tipo_abrev->GetValue());
                    $this->pieza->SetValue($this->DataSource->pieza->GetValue());
                    $this->pase_n_fojas->SetValue($this->DataSource->pase_n_fojas->GetValue());
                    $this->pieza_tm_nro->SetValue($this->DataSource->pieza_tm_nro->GetValue());
                    $this->pieza_descripcion->SetValue($this->DataSource->pieza_descripcion->GetValue());
                    $this->pieza_f_alta->SetValue($this->DataSource->pieza_f_alta->GetValue());
                    $this->entorno_abrev->SetValue($this->DataSource->entorno_abrev->GetValue());
                    $this->chk->SetText($this->FormParameters["chk"][$this->RowNumber], $this->RowNumber);
                    $this->adj_tipo_id->SetText($this->FormParameters["adj_tipo_id"][$this->RowNumber], $this->RowNumber);
                    $this->pieza_id->SetText($this->FormParameters["pieza_id"][$this->RowNumber], $this->RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["piezas.pieza_id"][$this->RowNumber] = "";
                    $this->CachedColumns["pase_id"][$this->RowNumber] = "";
                    $this->CachedColumns["pieza_id"][$this->RowNumber] = "";
                    $this->CachedColumns["pieza_tipo_id"][$this->RowNumber] = "";
                    $this->CachedColumns["adjunto_id"][$this->RowNumber] = "";
                    $this->CachedColumns["entorno_id"][$this->RowNumber] = "";
                    $this->pieza_tipo_abrev->SetText("");
                    $this->pieza->SetText("");
                    $this->pase_n_fojas->SetText("");
                    $this->pieza_tm_nro->SetText("");
                    $this->pieza_descripcion->SetText("");
                    $this->pieza_f_alta->SetText("");
                    $this->entorno_abrev->SetText("");
                    $this->chk->SetValue("");
                    $this->adj_tipo_id->SetText("");
                    $this->pieza_id->SetText("");
                } else {
                    $this->pieza_tipo_abrev->SetText("");
                    $this->pieza->SetText("");
                    $this->pase_n_fojas->SetText("");
                    $this->pieza_tm_nro->SetText("");
                    $this->pieza_descripcion->SetText("");
                    $this->pieza_f_alta->SetText("");
                    $this->entorno_abrev->SetText("");
                    $this->chk->SetText($this->FormParameters["chk"][$this->RowNumber], $this->RowNumber);
                    $this->adj_tipo_id->SetText($this->FormParameters["adj_tipo_id"][$this->RowNumber], $this->RowNumber);
                    $this->pieza_id->SetText($this->FormParameters["pieza_id"][$this->RowNumber], $this->RowNumber);
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->pieza_tipo_abrev->Show($this->RowNumber);
                $this->pieza->Show($this->RowNumber);
                $this->pase_n_fojas->Show($this->RowNumber);
                $this->pieza_tm_nro->Show($this->RowNumber);
                $this->pieza_descripcion->Show($this->RowNumber);
                $this->pieza_f_alta->Show($this->RowNumber);
                $this->entorno_abrev->Show($this->RowNumber);
                $this->chk->Show($this->RowNumber);
                $this->adj_tipo_id->Show($this->RowNumber);
                $this->pieza_id->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["piezas.pieza_id"] == $this->CachedColumns["piezas.pieza_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["pase_id"] == $this->CachedColumns["pase_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["pieza_id"] == $this->CachedColumns["pieza_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["pieza_tipo_id"] == $this->CachedColumns["pieza_tipo_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["adjunto_id"] == $this->CachedColumns["adjunto_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["entorno_id"] == $this->CachedColumns["entorno_id"][$this->RowNumber])) {
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
        $this->Button1->Show();
        $this->Button2->Show();

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

} //End area Class @103-FCB6E20C

class clsareaDataSource extends clsDBmesa {  //areaDataSource Class @103-D8CC5B5C

//DataSource Variables @103-E6D2B275
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $DeleteParameters;
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
    public $pieza_f_alta;
    public $entorno_abrev;
    public $chk;
    public $adj_tipo_id;
    public $pieza_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @103-05938695
    function clsareaDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid area/Error";
        $this->Initialize();
        $this->pieza_tipo_abrev = new clsField("pieza_tipo_abrev", ccsText, "");
        
        $this->pieza = new clsField("pieza", ccsText, "");
        
        $this->pase_n_fojas = new clsField("pase_n_fojas", ccsInteger, "");
        
        $this->pieza_tm_nro = new clsField("pieza_tm_nro", ccsInteger, "");
        
        $this->pieza_descripcion = new clsField("pieza_descripcion", ccsText, "");
        
        $this->pieza_f_alta = new clsField("pieza_f_alta", ccsDate, $this->DateFormat);
        
        $this->entorno_abrev = new clsField("entorno_abrev", ccsText, "");
        
        $this->chk = new clsField("chk", ccsBoolean, $this->BooleanFormat);
        
        $this->adj_tipo_id = new clsField("adj_tipo_id", ccsInteger, "");
        
        $this->pieza_id = new clsField("pieza_id", ccsInteger, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @103-BFB46204
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "pases.pase_f_pase desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @103-A9DC048B
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "expr123", ccsInteger, "", "", $this->Parameters["expr123"], "", false);
        $this->wp->AddParameter("2", "expr124", ccsInteger, "", "", $this->Parameters["expr124"], "", false);
        $this->wp->AddParameter("3", "sesunidad_id", ccsInteger, "", "", $this->Parameters["sesunidad_id"], "", false);
        $this->wp->AddParameter("4", "expr126", ccsInteger, "", "", $this->Parameters["expr126"], "", false);
        $this->wp->AddParameter("5", "expr127", ccsInteger, "", "", $this->Parameters["expr127"], "", false);
        $this->wp->AddParameter("6", "urls_pieza_nro", ccsInteger, "", "", $this->Parameters["urls_pieza_nro"], "", false);
        $this->wp->AddParameter("7", "urls_pieza_letra", ccsText, "", "", $this->Parameters["urls_pieza_letra"], "", false);
        $this->wp->AddParameter("8", "urls_pieza_anio", ccsInteger, "", "", $this->Parameters["urls_pieza_anio"], "", false);
        $this->wp->AddParameter("9", "urlpieza_id", ccsInteger, "", "", $this->Parameters["urlpieza_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "pases.pase_confirmado", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "pases.pase_activo", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "pases.des_unidad_id", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opIsNull, "adjuntos.adjunto_id", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsInteger),false);
        $this->wp->Criterion[5] = $this->wp->Operation(opNotEqual, "piezas.pieza_archivada", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsInteger),false);
        $this->wp->Criterion[6] = $this->wp->Operation(opEqual, "pieza_nro", $this->wp->GetDBValue("6"), $this->ToSQL($this->wp->GetDBValue("6"), ccsInteger),false);
        $this->wp->Criterion[7] = $this->wp->Operation(opContains, "pieza_letra", $this->wp->GetDBValue("7"), $this->ToSQL($this->wp->GetDBValue("7"), ccsText),false);
        $this->wp->Criterion[8] = $this->wp->Operation(opEqual, "pieza_anio", $this->wp->GetDBValue("8"), $this->ToSQL($this->wp->GetDBValue("8"), ccsInteger),false);
        $this->wp->Criterion[9] = $this->wp->Operation(opNotEqual, "piezas.pieza_id", $this->wp->GetDBValue("9"), $this->ToSQL($this->wp->GetDBValue("9"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
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
             $this->wp->Criterion[6]), 
             $this->wp->Criterion[7]), 
             $this->wp->Criterion[8]), 
             $this->wp->Criterion[9]);
    }
//End Prepare Method

//Open Method @103-0B358DF9
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (((piezas INNER JOIN pases ON\n\n" .
        "pases.pieza_id = piezas.pieza_id) INNER JOIN piezas_tipos ON\n\n" .
        "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) LEFT JOIN adjuntos ON\n\n" .
        "piezas.pieza_id = adjuntos.adj_pieza_id) INNER JOIN entornos ON\n\n" .
        "piezas.entorno_id = entornos.entorno_id";
        $this->SQL = "SELECT pieza_tipo_abrev, piezas.pieza_id AS pieza_id, CONCAT_WS('-',pieza_nro,pieza_letra,pieza_anio) AS pieza, pieza_tm_nro, pieza_descripcion,\n\n" .
        "pase_n_fojas, pieza_f_alta, entorno_abrev \n\n" .
        "FROM (((piezas INNER JOIN pases ON\n\n" .
        "pases.pieza_id = piezas.pieza_id) INNER JOIN piezas_tipos ON\n\n" .
        "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) LEFT JOIN adjuntos ON\n\n" .
        "piezas.pieza_id = adjuntos.adj_pieza_id) INNER JOIN entornos ON\n\n" .
        "piezas.entorno_id = entornos.entorno_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @103-58DF2045
    function SetValues()
    {
        $this->CachedColumns["piezas.pieza_id"] = $this->f("pieza_id");
        $this->CachedColumns["pase_id"] = $this->f("pase_id");
        $this->CachedColumns["pieza_id"] = $this->f("pieza_id");
        $this->CachedColumns["pieza_tipo_id"] = $this->f("pieza_tipo_id");
        $this->CachedColumns["adjunto_id"] = $this->f("adjunto_id");
        $this->CachedColumns["entorno_id"] = $this->f("entorno_id");
        $this->pieza_tipo_abrev->SetDBValue($this->f("pieza_tipo_abrev"));
        $this->pieza->SetDBValue($this->f("pieza"));
        $this->pase_n_fojas->SetDBValue(trim($this->f("pase_n_fojas")));
        $this->pieza_tm_nro->SetDBValue(trim($this->f("pieza_tm_nro")));
        $this->pieza_descripcion->SetDBValue($this->f("pieza_descripcion"));
        $this->pieza_f_alta->SetDBValue(trim($this->f("pieza_f_alta")));
        $this->entorno_abrev->SetDBValue($this->f("entorno_abrev"));
        $this->pieza_id->SetDBValue(trim($this->f("pieza_id")));
    }
//End SetValues Method

//Delete Method @103-D88CA96A
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "Select 1";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete", $this->Parent);
        }
    }
//End Delete Method

} //End areaDataSource Class @103-FCB6E20C

class clsRecordarea1 { //area1 Class @164-E2E9F6FC

//Variables @164-9E315808

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

//Class_Initialize Event @164-35C8441C
    function clsRecordarea1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record area1/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "area1";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->pieza_id = new clsControl(ccsHidden, "pieza_id", "pieza_id", ccsInteger, "", CCGetRequestParam("pieza_id", $Method, NULL), $this);
            $this->s_pieza_nro = new clsControl(ccsTextBox, "s_pieza_nro", "s_pieza_nro", ccsInteger, "", CCGetRequestParam("s_pieza_nro", $Method, NULL), $this);
            $this->s_pieza_letra = new clsControl(ccsTextBox, "s_pieza_letra", "s_pieza_letra", ccsText, "", CCGetRequestParam("s_pieza_letra", $Method, NULL), $this);
            $this->s_pieza_anio = new clsControl(ccsTextBox, "s_pieza_anio", "s_pieza_anio", ccsInteger, "", CCGetRequestParam("s_pieza_anio", $Method, NULL), $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->pieza_id->Value) && !strlen($this->pieza_id->Value) && $this->pieza_id->Value !== false)
                    $this->pieza_id->SetText(CCGEtParam(pieza_id));
            }
        }
    }
//End Class_Initialize Event

//Validate Method @164-F20092A2
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->pieza_id->Validate() && $Validation);
        $Validation = ($this->s_pieza_nro->Validate() && $Validation);
        $Validation = ($this->s_pieza_letra->Validate() && $Validation);
        $Validation = ($this->s_pieza_anio->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->pieza_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_pieza_nro->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_pieza_letra->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_pieza_anio->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @164-BDCC1E6D
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->pieza_id->Errors->Count());
        $errors = ($errors || $this->s_pieza_nro->Errors->Count());
        $errors = ($errors || $this->s_pieza_letra->Errors->Count());
        $errors = ($errors || $this->s_pieza_anio->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @164-ED598703
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

//Operation Method @164-DD94EE4C
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
        $Redirect = $FileName;
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = $FileName . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @164-145BF3D6
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
            $Error = ComposeStrings($Error, $this->pieza_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_pieza_nro->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_pieza_letra->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_pieza_anio->Errors->ToString());
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
        $this->pieza_id->Show();
        $this->s_pieza_nro->Show();
        $this->s_pieza_letra->Show();
        $this->s_pieza_anio->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End area1 Class @164-FCB6E20C



//Initialize Page @1-BD152CD6
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
$TemplateFileName = "msa_adjuntar.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-114E5A9A
include_once("./msa_adjuntar_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-6BC0AE71
$DBmesa = new clsDBmesa();
$MainPage->Connections["mesa"] = & $DBmesa;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$piezas_piezas_tipos_trami = new clsGridpiezas_piezas_tipos_trami("", $MainPage);
$area = new clsEditableGridarea("", $MainPage);
$area1 = new clsRecordarea1("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->piezas_piezas_tipos_trami = & $piezas_piezas_tipos_trami;
$MainPage->area = & $area;
$MainPage->area1 = & $area1;
$piezas_piezas_tipos_trami->Initialize();
$area->Initialize();

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

//Execute Components @1-5171F1E2
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
$area->Operation();
$area1->Operation();
//End Execute Components

//Go to destination page @1-E40D6363
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBmesa->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($piezas_piezas_tipos_trami);
    unset($area);
    unset($area1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-D434CED7
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$piezas_piezas_tipos_trami->Show();
$area->Show();
$area1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$ERKJKGP3S2H1N = explode("|", "<center><font face=\"Arial\">|<small>&#71;en&#101;r&#97;t&#1|01;d <!-- CCS -->wi&#116;h <!-- |SCC -->&#67;o&#100;&#101;&#67|;&#104;a&#114;&#103;e <!-- CC|S -->&#83;&#116;u&#100;&#105;o.<|/small></font></center>");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($ERKJKGP3S2H1N,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($ERKJKGP3S2H1N,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($ERKJKGP3S2H1N,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-2B134C1A
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmesa->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($piezas_piezas_tipos_trami);
unset($area);
unset($area1);
unset($Tpl);
//End Unload Page


?>
