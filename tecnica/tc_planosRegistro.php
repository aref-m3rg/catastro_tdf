<?php
//Include Common Files @1-FEBC2797
define("RelativePath", "..");
define("PathToCurrentPage", "/tecnica/");
define("FileName", "tc_planosRegistro.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @2-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @3-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Include Page implementation @4-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation



class clsGridplanos_detalle { //planos_detalle class @67-4E750D19

//Variables @67-6E51DF5A

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

//Class_Initialize Event @67-1E5B5C3A
    function clsGridplanos_detalle($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "planos_detalle";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid planos_detalle";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsplanos_detalleDataSource($this);
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
        $this->tipo_plano_desc = new clsControl(ccsLabel, "tipo_plano_desc", "tipo_plano_desc", ccsText, "", CCGetRequestParam("tipo_plano_desc", ccsGet, NULL), $this);
        $this->plano_nro = new clsControl(ccsLabel, "plano_nro", "plano_nro", ccsInteger, "", CCGetRequestParam("plano_nro", ccsGet, NULL), $this);
        $this->plano_anio = new clsControl(ccsLabel, "plano_anio", "plano_anio", ccsInteger, "", CCGetRequestParam("plano_anio", ccsGet, NULL), $this);
        $this->plano_e_nro = new clsControl(ccsLabel, "plano_e_nro", "plano_e_nro", ccsInteger, "", CCGetRequestParam("plano_e_nro", ccsGet, NULL), $this);
        $this->plano_e_letra = new clsControl(ccsLabel, "plano_e_letra", "plano_e_letra", ccsText, "", CCGetRequestParam("plano_e_letra", ccsGet, NULL), $this);
        $this->plano_e_anio = new clsControl(ccsLabel, "plano_e_anio", "plano_e_anio", ccsInteger, "", CCGetRequestParam("plano_e_anio", ccsGet, NULL), $this);
        $this->plano_f_inicio = new clsControl(ccsLabel, "plano_f_inicio", "plano_f_inicio", ccsDate, $DefaultDateFormat, CCGetRequestParam("plano_f_inicio", ccsGet, NULL), $this);
        $this->plano_f_archivo = new clsControl(ccsLabel, "plano_f_archivo", "plano_f_archivo", ccsDate, $DefaultDateFormat, CCGetRequestParam("plano_f_archivo", ccsGet, NULL), $this);
        $this->plano_disposicion = new clsControl(ccsLabel, "plano_disposicion", "plano_disposicion", ccsText, "", CCGetRequestParam("plano_disposicion", ccsGet, NULL), $this);
        $this->plano_f_entrada = new clsControl(ccsLabel, "plano_f_entrada", "plano_f_entrada", ccsDate, $DefaultDateFormat, CCGetRequestParam("plano_f_entrada", ccsGet, NULL), $this);
        $this->plano_f_salida = new clsControl(ccsLabel, "plano_f_salida", "plano_f_salida", ccsDate, $DefaultDateFormat, CCGetRequestParam("plano_f_salida", ccsGet, NULL), $this);
        $this->profesionales_prof_nombre = new clsControl(ccsLabel, "profesionales_prof_nombre", "profesionales_prof_nombre", ccsText, "", CCGetRequestParam("profesionales_prof_nombre", ccsGet, NULL), $this);
        $this->tipo_estado_plano_desc = new clsControl(ccsLabel, "tipo_estado_plano_desc", "tipo_estado_plano_desc", ccsText, "", CCGetRequestParam("tipo_estado_plano_desc", ccsGet, NULL), $this);
        $this->plano_f_registro = new clsControl(ccsLabel, "plano_f_registro", "plano_f_registro", ccsDate, $DefaultDateFormat, CCGetRequestParam("plano_f_registro", ccsGet, NULL), $this);
        $this->plano_observa = new clsControl(ccsLabel, "plano_observa", "plano_observa", ccsText, "", CCGetRequestParam("plano_observa", ccsGet, NULL), $this);
        $this->profesionales1_prof_nombre = new clsControl(ccsLabel, "profesionales1_prof_nombre", "profesionales1_prof_nombre", ccsText, "", CCGetRequestParam("profesionales1_prof_nombre", ccsGet, NULL), $this);
        $this->plano_sin_origen = new clsControl(ccsLabel, "plano_sin_origen", "plano_sin_origen", ccsInteger, "", CCGetRequestParam("plano_sin_origen", ccsGet, NULL), $this);
        $this->plano_svc = new clsControl(ccsLabel, "plano_svc", "plano_svc", ccsInteger, "", CCGetRequestParam("plano_svc", ccsGet, NULL), $this);
        $this->test = new clsControl(ccsLabel, "test", "test", ccsText, "", CCGetRequestParam("test", ccsGet, NULL), $this);
    }
//End Class_Initialize Event

//Initialize Method @67-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @67-8A1A617B
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
            $this->ControlsVisible["tipo_plano_desc"] = $this->tipo_plano_desc->Visible;
            $this->ControlsVisible["plano_nro"] = $this->plano_nro->Visible;
            $this->ControlsVisible["plano_anio"] = $this->plano_anio->Visible;
            $this->ControlsVisible["plano_e_nro"] = $this->plano_e_nro->Visible;
            $this->ControlsVisible["plano_e_letra"] = $this->plano_e_letra->Visible;
            $this->ControlsVisible["plano_e_anio"] = $this->plano_e_anio->Visible;
            $this->ControlsVisible["plano_f_inicio"] = $this->plano_f_inicio->Visible;
            $this->ControlsVisible["plano_f_archivo"] = $this->plano_f_archivo->Visible;
            $this->ControlsVisible["plano_disposicion"] = $this->plano_disposicion->Visible;
            $this->ControlsVisible["plano_f_entrada"] = $this->plano_f_entrada->Visible;
            $this->ControlsVisible["plano_f_salida"] = $this->plano_f_salida->Visible;
            $this->ControlsVisible["profesionales_prof_nombre"] = $this->profesionales_prof_nombre->Visible;
            $this->ControlsVisible["tipo_estado_plano_desc"] = $this->tipo_estado_plano_desc->Visible;
            $this->ControlsVisible["plano_f_registro"] = $this->plano_f_registro->Visible;
            $this->ControlsVisible["plano_observa"] = $this->plano_observa->Visible;
            $this->ControlsVisible["profesionales1_prof_nombre"] = $this->profesionales1_prof_nombre->Visible;
            $this->ControlsVisible["plano_sin_origen"] = $this->plano_sin_origen->Visible;
            $this->ControlsVisible["plano_svc"] = $this->plano_svc->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->tipo_depto_parc_desc->SetValue($this->DataSource->tipo_depto_parc_desc->GetValue());
                $this->tipo_plano_desc->SetValue($this->DataSource->tipo_plano_desc->GetValue());
                $this->plano_nro->SetValue($this->DataSource->plano_nro->GetValue());
                $this->plano_anio->SetValue($this->DataSource->plano_anio->GetValue());
                $this->plano_e_nro->SetValue($this->DataSource->plano_e_nro->GetValue());
                $this->plano_e_letra->SetValue($this->DataSource->plano_e_letra->GetValue());
                $this->plano_e_anio->SetValue($this->DataSource->plano_e_anio->GetValue());
                $this->plano_f_inicio->SetValue($this->DataSource->plano_f_inicio->GetValue());
                $this->plano_f_archivo->SetValue($this->DataSource->plano_f_archivo->GetValue());
                $this->plano_disposicion->SetValue($this->DataSource->plano_disposicion->GetValue());
                $this->plano_f_entrada->SetValue($this->DataSource->plano_f_entrada->GetValue());
                $this->plano_f_salida->SetValue($this->DataSource->plano_f_salida->GetValue());
                $this->profesionales_prof_nombre->SetValue($this->DataSource->profesionales_prof_nombre->GetValue());
                $this->tipo_estado_plano_desc->SetValue($this->DataSource->tipo_estado_plano_desc->GetValue());
                $this->plano_f_registro->SetValue($this->DataSource->plano_f_registro->GetValue());
                $this->plano_observa->SetValue($this->DataSource->plano_observa->GetValue());
                $this->profesionales1_prof_nombre->SetValue($this->DataSource->profesionales1_prof_nombre->GetValue());
                $this->plano_sin_origen->SetValue($this->DataSource->plano_sin_origen->GetValue());
                $this->plano_svc->SetValue($this->DataSource->plano_svc->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->tipo_depto_parc_desc->Show();
                $this->tipo_plano_desc->Show();
                $this->plano_nro->Show();
                $this->plano_anio->Show();
                $this->plano_e_nro->Show();
                $this->plano_e_letra->Show();
                $this->plano_e_anio->Show();
                $this->plano_f_inicio->Show();
                $this->plano_f_archivo->Show();
                $this->plano_disposicion->Show();
                $this->plano_f_entrada->Show();
                $this->plano_f_salida->Show();
                $this->profesionales_prof_nombre->Show();
                $this->tipo_estado_plano_desc->Show();
                $this->plano_f_registro->Show();
                $this->plano_observa->Show();
                $this->profesionales1_prof_nombre->Show();
                $this->plano_sin_origen->Show();
                $this->plano_svc->Show();
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
        $this->test->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @67-FA515B54
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->tipo_depto_parc_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_plano_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano_nro->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano_anio->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano_e_nro->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano_e_letra->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano_e_anio->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano_f_inicio->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano_f_archivo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano_disposicion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano_f_entrada->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano_f_salida->Errors->ToString());
        $errors = ComposeStrings($errors, $this->profesionales_prof_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_estado_plano_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano_f_registro->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano_observa->Errors->ToString());
        $errors = ComposeStrings($errors, $this->profesionales1_prof_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano_sin_origen->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano_svc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End planos_detalle Class @67-FCB6E20C

class clsplanos_detalleDataSource extends clsDBtdf_nuevo {  //planos_detalleDataSource Class @67-D7F471B4

//DataSource Variables @67-9F9295C6
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $tipo_depto_parc_desc;
    public $tipo_plano_desc;
    public $plano_nro;
    public $plano_anio;
    public $plano_e_nro;
    public $plano_e_letra;
    public $plano_e_anio;
    public $plano_f_inicio;
    public $plano_f_archivo;
    public $plano_disposicion;
    public $plano_f_entrada;
    public $plano_f_salida;
    public $profesionales_prof_nombre;
    public $tipo_estado_plano_desc;
    public $plano_f_registro;
    public $plano_observa;
    public $profesionales1_prof_nombre;
    public $plano_sin_origen;
    public $plano_svc;
//End DataSource Variables

//DataSourceClass_Initialize Event @67-CD9B619F
    function clsplanos_detalleDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid planos_detalle";
        $this->Initialize();
        $this->tipo_depto_parc_desc = new clsField("tipo_depto_parc_desc", ccsText, "");
        
        $this->tipo_plano_desc = new clsField("tipo_plano_desc", ccsText, "");
        
        $this->plano_nro = new clsField("plano_nro", ccsInteger, "");
        
        $this->plano_anio = new clsField("plano_anio", ccsInteger, "");
        
        $this->plano_e_nro = new clsField("plano_e_nro", ccsInteger, "");
        
        $this->plano_e_letra = new clsField("plano_e_letra", ccsText, "");
        
        $this->plano_e_anio = new clsField("plano_e_anio", ccsInteger, "");
        
        $this->plano_f_inicio = new clsField("plano_f_inicio", ccsDate, $this->DateFormat);
        
        $this->plano_f_archivo = new clsField("plano_f_archivo", ccsDate, $this->DateFormat);
        
        $this->plano_disposicion = new clsField("plano_disposicion", ccsText, "");
        
        $this->plano_f_entrada = new clsField("plano_f_entrada", ccsDate, $this->DateFormat);
        
        $this->plano_f_salida = new clsField("plano_f_salida", ccsDate, $this->DateFormat);
        
        $this->profesionales_prof_nombre = new clsField("profesionales_prof_nombre", ccsText, "");
        
        $this->tipo_estado_plano_desc = new clsField("tipo_estado_plano_desc", ccsText, "");
        
        $this->plano_f_registro = new clsField("plano_f_registro", ccsDate, $this->DateFormat);
        
        $this->plano_observa = new clsField("plano_observa", ccsText, "");
        
        $this->profesionales1_prof_nombre = new clsField("profesionales1_prof_nombre", ccsText, "");
        
        $this->plano_sin_origen = new clsField("plano_sin_origen", ccsInteger, "");
        
        $this->plano_svc = new clsField("plano_svc", ccsInteger, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @67-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @67-E81FE6BF
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

//Open Method @67-8567469B
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((((planos LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "planos.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN tipos_planos ON\n\n" .
        "planos.tipo_plano_id = tipos_planos.tipo_plano_id) LEFT JOIN tipos_estados_planos ON\n\n" .
        "planos.tipo_estado_plano_id = tipos_estados_planos.tipo_estado_plano_id) LEFT JOIN profesionales ON\n\n" .
        "planos.profesional_id = profesionales.prof_id) LEFT JOIN profesionales profesionales1 ON\n\n" .
        "planos.profesional_id_2 = profesionales1.prof_id";
        $this->SQL = "SELECT planos.*, tipo_depto_parc_desc, tipo_plano_desc, tipos_estados_planos.*, profesionales.prof_nombre AS profesionales_prof_nombre,\n\n" .
        "profesionales1.prof_nombre AS profesionales1_prof_nombre \n\n" .
        "FROM ((((planos LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "planos.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN tipos_planos ON\n\n" .
        "planos.tipo_plano_id = tipos_planos.tipo_plano_id) LEFT JOIN tipos_estados_planos ON\n\n" .
        "planos.tipo_estado_plano_id = tipos_estados_planos.tipo_estado_plano_id) LEFT JOIN profesionales ON\n\n" .
        "planos.profesional_id = profesionales.prof_id) LEFT JOIN profesionales profesionales1 ON\n\n" .
        "planos.profesional_id_2 = profesionales1.prof_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @67-E328DC9F
    function SetValues()
    {
        $this->tipo_depto_parc_desc->SetDBValue($this->f("tipo_depto_parc_desc"));
        $this->tipo_plano_desc->SetDBValue($this->f("tipo_plano_desc"));
        $this->plano_nro->SetDBValue(trim($this->f("plano_nro")));
        $this->plano_anio->SetDBValue(trim($this->f("plano_anio")));
        $this->plano_e_nro->SetDBValue(trim($this->f("plano_e_nro")));
        $this->plano_e_letra->SetDBValue($this->f("plano_e_letra"));
        $this->plano_e_anio->SetDBValue(trim($this->f("plano_e_anio")));
        $this->plano_f_inicio->SetDBValue(trim($this->f("plano_f_inicio")));
        $this->plano_f_archivo->SetDBValue(trim($this->f("plano_f_archivo")));
        $this->plano_disposicion->SetDBValue($this->f("plano_disposicion"));
        $this->plano_f_entrada->SetDBValue(trim($this->f("plano_f_entrada")));
        $this->plano_f_salida->SetDBValue(trim($this->f("plano_f_salida")));
        $this->profesionales_prof_nombre->SetDBValue($this->f("profesionales_prof_nombre"));
        $this->tipo_estado_plano_desc->SetDBValue($this->f("tipo_estado_plano_desc"));
        $this->plano_f_registro->SetDBValue(trim($this->f("plano_f_registro")));
        $this->plano_observa->SetDBValue($this->f("plano_observa"));
        $this->profesionales1_prof_nombre->SetDBValue($this->f("profesionales1_prof_nombre"));
        $this->plano_sin_origen->SetDBValue(trim($this->f("plano_sin_origen")));
        $this->plano_svc->SetDBValue(trim($this->f("plano_svc")));
    }
//End SetValues Method

} //End planos_detalleDataSource Class @67-FCB6E20C

class clsGridparcelas_origen { //parcelas_origen class @127-6561CDBF

//Variables @127-6E51DF5A

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

//Class_Initialize Event @127-0DF48E6F
    function clsGridparcelas_origen($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "parcelas_origen";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid parcelas_origen";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsparcelas_origenDataSource($this);
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
        $this->parcela_partida = new clsControl(ccsLabel, "parcela_partida", "parcela_partida", ccsInteger, "", CCGetRequestParam("parcela_partida", ccsGet, NULL), $this);
        $this->parcela_seccion = new clsControl(ccsLabel, "parcela_seccion", "parcela_seccion", ccsText, "", CCGetRequestParam("parcela_seccion", ccsGet, NULL), $this);
        $this->parcela_macizo = new clsControl(ccsLabel, "parcela_macizo", "parcela_macizo", ccsText, "", CCGetRequestParam("parcela_macizo", ccsGet, NULL), $this);
        $this->parcela_parcela = new clsControl(ccsLabel, "parcela_parcela", "parcela_parcela", ccsText, "", CCGetRequestParam("parcela_parcela", ccsGet, NULL), $this);
        $this->parcela_chacra = new clsControl(ccsLabel, "parcela_chacra", "parcela_chacra", ccsText, "", CCGetRequestParam("parcela_chacra", ccsGet, NULL), $this);
        $this->parcela_quinta = new clsControl(ccsLabel, "parcela_quinta", "parcela_quinta", ccsText, "", CCGetRequestParam("parcela_quinta", ccsGet, NULL), $this);
        $this->parcela_fraccion = new clsControl(ccsLabel, "parcela_fraccion", "parcela_fraccion", ccsText, "", CCGetRequestParam("parcela_fraccion", ccsGet, NULL), $this);
        $this->parcela_uf = new clsControl(ccsLabel, "parcela_uf", "parcela_uf", ccsText, "", CCGetRequestParam("parcela_uf", ccsGet, NULL), $this);
        $this->parcela_predio = new clsControl(ccsLabel, "parcela_predio", "parcela_predio", ccsText, "", CCGetRequestParam("parcela_predio", ccsGet, NULL), $this);
        $this->parcela_rte = new clsControl(ccsLabel, "parcela_rte", "parcela_rte", ccsText, "", CCGetRequestParam("parcela_rte", ccsGet, NULL), $this);
        $this->tipo_est_parc_descr = new clsControl(ccsLabel, "tipo_est_parc_descr", "tipo_est_parc_descr", ccsText, "", CCGetRequestParam("tipo_est_parc_descr", ccsGet, NULL), $this);
    }
//End Class_Initialize Event

//Initialize Method @127-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @127-AEC078D2
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlplano_id"] = CCGetFromGet("plano_id", NULL);
        $this->DataSource->Parameters["expr136"] = 'origen';

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
            $this->ControlsVisible["parcela_partida"] = $this->parcela_partida->Visible;
            $this->ControlsVisible["parcela_seccion"] = $this->parcela_seccion->Visible;
            $this->ControlsVisible["parcela_macizo"] = $this->parcela_macizo->Visible;
            $this->ControlsVisible["parcela_parcela"] = $this->parcela_parcela->Visible;
            $this->ControlsVisible["parcela_chacra"] = $this->parcela_chacra->Visible;
            $this->ControlsVisible["parcela_quinta"] = $this->parcela_quinta->Visible;
            $this->ControlsVisible["parcela_fraccion"] = $this->parcela_fraccion->Visible;
            $this->ControlsVisible["parcela_uf"] = $this->parcela_uf->Visible;
            $this->ControlsVisible["parcela_predio"] = $this->parcela_predio->Visible;
            $this->ControlsVisible["parcela_rte"] = $this->parcela_rte->Visible;
            $this->ControlsVisible["tipo_est_parc_descr"] = $this->tipo_est_parc_descr->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->tipo_depto_parc_desc->SetValue($this->DataSource->tipo_depto_parc_desc->GetValue());
                $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
                $this->parcela_seccion->SetValue($this->DataSource->parcela_seccion->GetValue());
                $this->parcela_macizo->SetValue($this->DataSource->parcela_macizo->GetValue());
                $this->parcela_parcela->SetValue($this->DataSource->parcela_parcela->GetValue());
                $this->parcela_chacra->SetValue($this->DataSource->parcela_chacra->GetValue());
                $this->parcela_quinta->SetValue($this->DataSource->parcela_quinta->GetValue());
                $this->parcela_fraccion->SetValue($this->DataSource->parcela_fraccion->GetValue());
                $this->parcela_uf->SetValue($this->DataSource->parcela_uf->GetValue());
                $this->parcela_predio->SetValue($this->DataSource->parcela_predio->GetValue());
                $this->parcela_rte->SetValue($this->DataSource->parcela_rte->GetValue());
                $this->tipo_est_parc_descr->SetValue($this->DataSource->tipo_est_parc_descr->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->tipo_depto_parc_desc->Show();
                $this->parcela_partida->Show();
                $this->parcela_seccion->Show();
                $this->parcela_macizo->Show();
                $this->parcela_parcela->Show();
                $this->parcela_chacra->Show();
                $this->parcela_quinta->Show();
                $this->parcela_fraccion->Show();
                $this->parcela_uf->Show();
                $this->parcela_predio->Show();
                $this->parcela_rte->Show();
                $this->tipo_est_parc_descr->Show();
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

//GetErrors Method @127-0AB433B7
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->tipo_depto_parc_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_partida->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_seccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_macizo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_parcela->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_chacra->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_quinta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_fraccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_uf->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_predio->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_rte->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_est_parc_descr->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End parcelas_origen Class @127-FCB6E20C

class clsparcelas_origenDataSource extends clsDBtdf_nuevo {  //parcelas_origenDataSource Class @127-C56AC843

//DataSource Variables @127-16318EE6
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $tipo_depto_parc_desc;
    public $parcela_partida;
    public $parcela_seccion;
    public $parcela_macizo;
    public $parcela_parcela;
    public $parcela_chacra;
    public $parcela_quinta;
    public $parcela_fraccion;
    public $parcela_uf;
    public $parcela_predio;
    public $parcela_rte;
    public $tipo_est_parc_descr;
//End DataSource Variables

//DataSourceClass_Initialize Event @127-ED589C87
    function clsparcelas_origenDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid parcelas_origen";
        $this->Initialize();
        $this->tipo_depto_parc_desc = new clsField("tipo_depto_parc_desc", ccsText, "");
        
        $this->parcela_partida = new clsField("parcela_partida", ccsInteger, "");
        
        $this->parcela_seccion = new clsField("parcela_seccion", ccsText, "");
        
        $this->parcela_macizo = new clsField("parcela_macizo", ccsText, "");
        
        $this->parcela_parcela = new clsField("parcela_parcela", ccsText, "");
        
        $this->parcela_chacra = new clsField("parcela_chacra", ccsText, "");
        
        $this->parcela_quinta = new clsField("parcela_quinta", ccsText, "");
        
        $this->parcela_fraccion = new clsField("parcela_fraccion", ccsText, "");
        
        $this->parcela_uf = new clsField("parcela_uf", ccsText, "");
        
        $this->parcela_predio = new clsField("parcela_predio", ccsText, "");
        
        $this->parcela_rte = new clsField("parcela_rte", ccsText, "");
        
        $this->tipo_est_parc_descr = new clsField("tipo_est_parc_descr", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @127-1893DBA0
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "parcelas.parcela_partida";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @127-DA2429C0
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlplano_id", ccsInteger, "", "", $this->Parameters["urlplano_id"], "", false);
        $this->wp->AddParameter("2", "expr136", ccsText, "", "", $this->Parameters["expr136"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "planos_parc_prov.plano_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "planos_parc_prov.planos_parc_prov_tipo", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @127-94500D23
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((parcelas INNER JOIN planos_parc_prov ON\n\n" .
        "planos_parc_prov.parcela_id = parcelas.parcela_id) LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "parcelas.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN tipos_estados_parcela ON\n\n" .
        "parcelas.tipo_est_parc_id = tipos_estados_parcela.tipo_est_parc_id";
        $this->SQL = "SELECT tipo_estado_id, parcelas.*, planos_parc_prov_tipo, plano_id, tipo_depto_parc_desc, tipo_est_parc_descr \n\n" .
        "FROM ((parcelas INNER JOIN planos_parc_prov ON\n\n" .
        "planos_parc_prov.parcela_id = parcelas.parcela_id) LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "parcelas.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN tipos_estados_parcela ON\n\n" .
        "parcelas.tipo_est_parc_id = tipos_estados_parcela.tipo_est_parc_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @127-72723756
    function SetValues()
    {
        $this->tipo_depto_parc_desc->SetDBValue($this->f("tipo_depto_parc_desc"));
        $this->parcela_partida->SetDBValue(trim($this->f("parcela_partida")));
        $this->parcela_seccion->SetDBValue($this->f("parcela_seccion"));
        $this->parcela_macizo->SetDBValue($this->f("parcela_macizo"));
        $this->parcela_parcela->SetDBValue($this->f("parcela_parcela"));
        $this->parcela_chacra->SetDBValue($this->f("parcela_chacra"));
        $this->parcela_quinta->SetDBValue($this->f("parcela_quinta"));
        $this->parcela_fraccion->SetDBValue($this->f("parcela_fraccion"));
        $this->parcela_uf->SetDBValue($this->f("parcela_uf"));
        $this->parcela_predio->SetDBValue($this->f("parcela_predio"));
        $this->parcela_rte->SetDBValue($this->f("parcela_rte"));
        $this->tipo_est_parc_descr->SetDBValue($this->f("tipo_est_parc_descr"));
    }
//End SetValues Method

} //End parcelas_origenDataSource Class @127-FCB6E20C

class clsGridparcelas_destino_sel { //parcelas_destino_sel class @215-9E31FD5B

//Variables @215-6E51DF5A

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

//Class_Initialize Event @215-4C4BB3E2
    function clsGridparcelas_destino_sel($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "parcelas_destino_sel";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid parcelas_destino_sel";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsparcelas_destino_selDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 1000;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 1000)
            $this->PageSize = 1000;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->parcela_partida = new clsControl(ccsLabel, "parcela_partida", "parcela_partida", ccsInteger, "", CCGetRequestParam("parcela_partida", ccsGet, NULL), $this);
        $this->parcela_seccion = new clsControl(ccsLabel, "parcela_seccion", "parcela_seccion", ccsText, "", CCGetRequestParam("parcela_seccion", ccsGet, NULL), $this);
        $this->parcela_macizo = new clsControl(ccsLabel, "parcela_macizo", "parcela_macizo", ccsText, "", CCGetRequestParam("parcela_macizo", ccsGet, NULL), $this);
        $this->parcela_parcela = new clsControl(ccsLabel, "parcela_parcela", "parcela_parcela", ccsText, "", CCGetRequestParam("parcela_parcela", ccsGet, NULL), $this);
        $this->parcela_chacra = new clsControl(ccsLabel, "parcela_chacra", "parcela_chacra", ccsText, "", CCGetRequestParam("parcela_chacra", ccsGet, NULL), $this);
        $this->parcela_quinta = new clsControl(ccsLabel, "parcela_quinta", "parcela_quinta", ccsText, "", CCGetRequestParam("parcela_quinta", ccsGet, NULL), $this);
        $this->parcela_fraccion = new clsControl(ccsLabel, "parcela_fraccion", "parcela_fraccion", ccsText, "", CCGetRequestParam("parcela_fraccion", ccsGet, NULL), $this);
        $this->parcela_uf = new clsControl(ccsLabel, "parcela_uf", "parcela_uf", ccsText, "", CCGetRequestParam("parcela_uf", ccsGet, NULL), $this);
        $this->parcela_predio = new clsControl(ccsLabel, "parcela_predio", "parcela_predio", ccsText, "", CCGetRequestParam("parcela_predio", ccsGet, NULL), $this);
        $this->parcela_rte = new clsControl(ccsLabel, "parcela_rte", "parcela_rte", ccsText, "", CCGetRequestParam("parcela_rte", ccsGet, NULL), $this);
        $this->tipo_depto_parc_abrev = new clsControl(ccsLabel, "tipo_depto_parc_abrev", "tipo_depto_parc_abrev", ccsText, "", CCGetRequestParam("tipo_depto_parc_abrev", ccsGet, NULL), $this);
        $this->tipo_est_parc_descr = new clsControl(ccsLabel, "tipo_est_parc_descr", "tipo_est_parc_descr", ccsText, "", CCGetRequestParam("tipo_est_parc_descr", ccsGet, NULL), $this);
    }
//End Class_Initialize Event

//Initialize Method @215-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @215-3058B2C3
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlplano_id"] = CCGetFromGet("plano_id", NULL);
        $this->DataSource->Parameters["expr223"] = destino;
        $this->DataSource->Parameters["urlplanos_parc_prov_parcela_id"] = CCGetFromGet("planos_parc_prov_parcela_id", NULL);

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
            $this->ControlsVisible["parcela_partida"] = $this->parcela_partida->Visible;
            $this->ControlsVisible["parcela_seccion"] = $this->parcela_seccion->Visible;
            $this->ControlsVisible["parcela_macizo"] = $this->parcela_macizo->Visible;
            $this->ControlsVisible["parcela_parcela"] = $this->parcela_parcela->Visible;
            $this->ControlsVisible["parcela_chacra"] = $this->parcela_chacra->Visible;
            $this->ControlsVisible["parcela_quinta"] = $this->parcela_quinta->Visible;
            $this->ControlsVisible["parcela_fraccion"] = $this->parcela_fraccion->Visible;
            $this->ControlsVisible["parcela_uf"] = $this->parcela_uf->Visible;
            $this->ControlsVisible["parcela_predio"] = $this->parcela_predio->Visible;
            $this->ControlsVisible["parcela_rte"] = $this->parcela_rte->Visible;
            $this->ControlsVisible["tipo_depto_parc_abrev"] = $this->tipo_depto_parc_abrev->Visible;
            $this->ControlsVisible["tipo_est_parc_descr"] = $this->tipo_est_parc_descr->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
                $this->parcela_seccion->SetValue($this->DataSource->parcela_seccion->GetValue());
                $this->parcela_macizo->SetValue($this->DataSource->parcela_macizo->GetValue());
                $this->parcela_parcela->SetValue($this->DataSource->parcela_parcela->GetValue());
                $this->parcela_chacra->SetValue($this->DataSource->parcela_chacra->GetValue());
                $this->parcela_quinta->SetValue($this->DataSource->parcela_quinta->GetValue());
                $this->parcela_fraccion->SetValue($this->DataSource->parcela_fraccion->GetValue());
                $this->parcela_uf->SetValue($this->DataSource->parcela_uf->GetValue());
                $this->parcela_predio->SetValue($this->DataSource->parcela_predio->GetValue());
                $this->parcela_rte->SetValue($this->DataSource->parcela_rte->GetValue());
                $this->tipo_depto_parc_abrev->SetValue($this->DataSource->tipo_depto_parc_abrev->GetValue());
                $this->tipo_est_parc_descr->SetValue($this->DataSource->tipo_est_parc_descr->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->parcela_partida->Show();
                $this->parcela_seccion->Show();
                $this->parcela_macizo->Show();
                $this->parcela_parcela->Show();
                $this->parcela_chacra->Show();
                $this->parcela_quinta->Show();
                $this->parcela_fraccion->Show();
                $this->parcela_uf->Show();
                $this->parcela_predio->Show();
                $this->parcela_rte->Show();
                $this->tipo_depto_parc_abrev->Show();
                $this->tipo_est_parc_descr->Show();
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

//GetErrors Method @215-06484AF1
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->parcela_partida->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_seccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_macizo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_parcela->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_chacra->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_quinta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_fraccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_uf->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_predio->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_rte->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_depto_parc_abrev->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_est_parc_descr->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End parcelas_destino_sel Class @215-FCB6E20C

class clsparcelas_destino_selDataSource extends clsDBtdf_nuevo {  //parcelas_destino_selDataSource Class @215-634915A2

//DataSource Variables @215-E3E39A54
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $parcela_partida;
    public $parcela_seccion;
    public $parcela_macizo;
    public $parcela_parcela;
    public $parcela_chacra;
    public $parcela_quinta;
    public $parcela_fraccion;
    public $parcela_uf;
    public $parcela_predio;
    public $parcela_rte;
    public $tipo_depto_parc_abrev;
    public $tipo_est_parc_descr;
//End DataSource Variables

//DataSourceClass_Initialize Event @215-1C1C94CF
    function clsparcelas_destino_selDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid parcelas_destino_sel";
        $this->Initialize();
        $this->parcela_partida = new clsField("parcela_partida", ccsInteger, "");
        
        $this->parcela_seccion = new clsField("parcela_seccion", ccsText, "");
        
        $this->parcela_macizo = new clsField("parcela_macizo", ccsText, "");
        
        $this->parcela_parcela = new clsField("parcela_parcela", ccsText, "");
        
        $this->parcela_chacra = new clsField("parcela_chacra", ccsText, "");
        
        $this->parcela_quinta = new clsField("parcela_quinta", ccsText, "");
        
        $this->parcela_fraccion = new clsField("parcela_fraccion", ccsText, "");
        
        $this->parcela_uf = new clsField("parcela_uf", ccsText, "");
        
        $this->parcela_predio = new clsField("parcela_predio", ccsText, "");
        
        $this->parcela_rte = new clsField("parcela_rte", ccsText, "");
        
        $this->tipo_depto_parc_abrev = new clsField("tipo_depto_parc_abrev", ccsText, "");
        
        $this->tipo_est_parc_descr = new clsField("tipo_est_parc_descr", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @215-3993B012
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "parcela_partida";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @215-26D716FE
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlplano_id", ccsInteger, "", "", $this->Parameters["urlplano_id"], "", false);
        $this->wp->AddParameter("2", "expr223", ccsText, "", "", $this->Parameters["expr223"], "", false);
        $this->wp->AddParameter("3", "urlplanos_parc_prov_parcela_id", ccsInteger, "", "", $this->Parameters["urlplanos_parc_prov_parcela_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "planos_parc_prov.plano_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "planos_parc_prov.planos_parc_prov_tipo", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opNotNull, "planos_parc_prov.parcela_id", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]);
    }
//End Prepare Method

//Open Method @215-B408A985
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((parcelas INNER JOIN planos_parc_prov ON\n\n" .
        "planos_parc_prov.parcela_id = parcelas.parcela_id) INNER JOIN tipos_deptos_parcela ON\n\n" .
        "parcelas.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) INNER JOIN tipos_estados_parcela ON\n\n" .
        "parcelas.tipo_est_parc_id = tipos_estados_parcela.tipo_est_parc_id";
        $this->SQL = "SELECT planos_prov_id, planos_parc_prov_tipo, parcela_partida, parcela_seccion, parcela_macizo, parcela_parcela, parcela_chacra, parcela_quinta,\n\n" .
        "parcela_fraccion, parcela_uf, parcela_predio, parcela_rte, tipo_depto_parc_abrev, tipo_est_parc_descr \n\n" .
        "FROM ((parcelas INNER JOIN planos_parc_prov ON\n\n" .
        "planos_parc_prov.parcela_id = parcelas.parcela_id) INNER JOIN tipos_deptos_parcela ON\n\n" .
        "parcelas.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) INNER JOIN tipos_estados_parcela ON\n\n" .
        "parcelas.tipo_est_parc_id = tipos_estados_parcela.tipo_est_parc_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @215-0DCA07E8
    function SetValues()
    {
        $this->parcela_partida->SetDBValue(trim($this->f("parcela_partida")));
        $this->parcela_seccion->SetDBValue($this->f("parcela_seccion"));
        $this->parcela_macizo->SetDBValue($this->f("parcela_macizo"));
        $this->parcela_parcela->SetDBValue($this->f("parcela_parcela"));
        $this->parcela_chacra->SetDBValue($this->f("parcela_chacra"));
        $this->parcela_quinta->SetDBValue($this->f("parcela_quinta"));
        $this->parcela_fraccion->SetDBValue($this->f("parcela_fraccion"));
        $this->parcela_uf->SetDBValue($this->f("parcela_uf"));
        $this->parcela_predio->SetDBValue($this->f("parcela_predio"));
        $this->parcela_rte->SetDBValue($this->f("parcela_rte"));
        $this->tipo_depto_parc_abrev->SetDBValue($this->f("tipo_depto_parc_abrev"));
        $this->tipo_est_parc_descr->SetDBValue($this->f("tipo_est_parc_descr"));
    }
//End SetValues Method

} //End parcelas_destino_selDataSource Class @215-FCB6E20C

class clsGridparcelas_destino_creadas { //parcelas_destino_creadas class @259-BCB7008F

//Variables @259-6E51DF5A

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

//Class_Initialize Event @259-78D4C3E7
    function clsGridparcelas_destino_creadas($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "parcelas_destino_creadas";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid parcelas_destino_creadas";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsparcelas_destino_creadasDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 1000;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 1000)
            $this->PageSize = 1000;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->planos_prov_seccion = new clsControl(ccsLabel, "planos_prov_seccion", "planos_prov_seccion", ccsText, "", CCGetRequestParam("planos_prov_seccion", ccsGet, NULL), $this);
        $this->planos_prov_macizo = new clsControl(ccsLabel, "planos_prov_macizo", "planos_prov_macizo", ccsText, "", CCGetRequestParam("planos_prov_macizo", ccsGet, NULL), $this);
        $this->planos_prov_chacra = new clsControl(ccsLabel, "planos_prov_chacra", "planos_prov_chacra", ccsText, "", CCGetRequestParam("planos_prov_chacra", ccsGet, NULL), $this);
        $this->planos_prov_quinta = new clsControl(ccsLabel, "planos_prov_quinta", "planos_prov_quinta", ccsText, "", CCGetRequestParam("planos_prov_quinta", ccsGet, NULL), $this);
        $this->planos_prov_fraccion = new clsControl(ccsLabel, "planos_prov_fraccion", "planos_prov_fraccion", ccsText, "", CCGetRequestParam("planos_prov_fraccion", ccsGet, NULL), $this);
        $this->parcela_uf = new clsControl(ccsLabel, "parcela_uf", "parcela_uf", ccsText, "", CCGetRequestParam("parcela_uf", ccsGet, NULL), $this);
        $this->parcela_predio = new clsControl(ccsLabel, "parcela_predio", "parcela_predio", ccsText, "", CCGetRequestParam("parcela_predio", ccsGet, NULL), $this);
        $this->parcela_rte = new clsControl(ccsLabel, "parcela_rte", "parcela_rte", ccsText, "", CCGetRequestParam("parcela_rte", ccsGet, NULL), $this);
        $this->tipo_depto_parc_desc = new clsControl(ccsLabel, "tipo_depto_parc_desc", "tipo_depto_parc_desc", ccsText, "", CCGetRequestParam("tipo_depto_parc_desc", ccsGet, NULL), $this);
        $this->planos_prov_parcela = new clsControl(ccsLabel, "planos_prov_parcela", "planos_prov_parcela", ccsText, "", CCGetRequestParam("planos_prov_parcela", ccsGet, NULL), $this);
    }
//End Class_Initialize Event

//Initialize Method @259-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @259-F626CBE2
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlplano_id"] = CCGetFromGet("plano_id", NULL);
        $this->DataSource->Parameters["expr274"] = destino;
        $this->DataSource->Parameters["expr370"] = "";

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
            $this->ControlsVisible["planos_prov_seccion"] = $this->planos_prov_seccion->Visible;
            $this->ControlsVisible["planos_prov_macizo"] = $this->planos_prov_macizo->Visible;
            $this->ControlsVisible["planos_prov_chacra"] = $this->planos_prov_chacra->Visible;
            $this->ControlsVisible["planos_prov_quinta"] = $this->planos_prov_quinta->Visible;
            $this->ControlsVisible["planos_prov_fraccion"] = $this->planos_prov_fraccion->Visible;
            $this->ControlsVisible["parcela_uf"] = $this->parcela_uf->Visible;
            $this->ControlsVisible["parcela_predio"] = $this->parcela_predio->Visible;
            $this->ControlsVisible["parcela_rte"] = $this->parcela_rte->Visible;
            $this->ControlsVisible["tipo_depto_parc_desc"] = $this->tipo_depto_parc_desc->Visible;
            $this->ControlsVisible["planos_prov_parcela"] = $this->planos_prov_parcela->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->planos_prov_seccion->SetValue($this->DataSource->planos_prov_seccion->GetValue());
                $this->planos_prov_macizo->SetValue($this->DataSource->planos_prov_macizo->GetValue());
                $this->planos_prov_chacra->SetValue($this->DataSource->planos_prov_chacra->GetValue());
                $this->planos_prov_quinta->SetValue($this->DataSource->planos_prov_quinta->GetValue());
                $this->planos_prov_fraccion->SetValue($this->DataSource->planos_prov_fraccion->GetValue());
                $this->parcela_uf->SetValue($this->DataSource->parcela_uf->GetValue());
                $this->parcela_predio->SetValue($this->DataSource->parcela_predio->GetValue());
                $this->parcela_rte->SetValue($this->DataSource->parcela_rte->GetValue());
                $this->tipo_depto_parc_desc->SetValue($this->DataSource->tipo_depto_parc_desc->GetValue());
                $this->planos_prov_parcela->SetValue($this->DataSource->planos_prov_parcela->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->planos_prov_seccion->Show();
                $this->planos_prov_macizo->Show();
                $this->planos_prov_chacra->Show();
                $this->planos_prov_quinta->Show();
                $this->planos_prov_fraccion->Show();
                $this->parcela_uf->Show();
                $this->parcela_predio->Show();
                $this->parcela_rte->Show();
                $this->tipo_depto_parc_desc->Show();
                $this->planos_prov_parcela->Show();
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

//GetErrors Method @259-C53633EB
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->planos_prov_seccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->planos_prov_macizo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->planos_prov_chacra->Errors->ToString());
        $errors = ComposeStrings($errors, $this->planos_prov_quinta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->planos_prov_fraccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_uf->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_predio->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_rte->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_depto_parc_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->planos_prov_parcela->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End parcelas_destino_creadas Class @259-FCB6E20C

class clsparcelas_destino_creadasDataSource extends clsDBtdf_nuevo {  //parcelas_destino_creadasDataSource Class @259-6084D179

//DataSource Variables @259-4DA1EFC0
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $planos_prov_seccion;
    public $planos_prov_macizo;
    public $planos_prov_chacra;
    public $planos_prov_quinta;
    public $planos_prov_fraccion;
    public $parcela_uf;
    public $parcela_predio;
    public $parcela_rte;
    public $tipo_depto_parc_desc;
    public $planos_prov_parcela;
//End DataSource Variables

//DataSourceClass_Initialize Event @259-EC28A88B
    function clsparcelas_destino_creadasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid parcelas_destino_creadas";
        $this->Initialize();
        $this->planos_prov_seccion = new clsField("planos_prov_seccion", ccsText, "");
        
        $this->planos_prov_macizo = new clsField("planos_prov_macizo", ccsText, "");
        
        $this->planos_prov_chacra = new clsField("planos_prov_chacra", ccsText, "");
        
        $this->planos_prov_quinta = new clsField("planos_prov_quinta", ccsText, "");
        
        $this->planos_prov_fraccion = new clsField("planos_prov_fraccion", ccsText, "");
        
        $this->parcela_uf = new clsField("parcela_uf", ccsText, "");
        
        $this->parcela_predio = new clsField("parcela_predio", ccsText, "");
        
        $this->parcela_rte = new clsField("parcela_rte", ccsText, "");
        
        $this->tipo_depto_parc_desc = new clsField("tipo_depto_parc_desc", ccsText, "");
        
        $this->planos_prov_parcela = new clsField("planos_prov_parcela", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @259-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @259-9C508592
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlplano_id", ccsInteger, "", "", $this->Parameters["urlplano_id"], "", false);
        $this->wp->AddParameter("2", "expr274", ccsText, "", "", $this->Parameters["expr274"], "", false);
        $this->wp->AddParameter("4", "expr370", ccsInteger, "", "", $this->Parameters["expr370"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "planos_parc_prov.plano_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "planos_parc_prov.planos_parc_prov_tipo", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->wp->Criterion[3] = "( planos_parc_prov.parcela_id IS NULL )";
        $this->wp->Criterion[4] = $this->wp->Operation(opNotEqual, "planos_parc_prov.parcela_id", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), $this->wp->opOR(
             true, 
             $this->wp->Criterion[3], 
             $this->wp->Criterion[4]));
    }
//End Prepare Method

//Open Method @259-A3F39DB6
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM planos_parc_prov LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "planos_parc_prov.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id";
        $this->SQL = "SELECT planos_prov_id, planos_parc_prov_tipo, planos_prov_rte, planos_prov_predio, planos_prov_uf, planos_prov_fraccion, planos_prov_quinta,\n\n" .
        "planos_prov_chacra, planos_prov_parcela, planos_prov_macizo, planos_prov_seccion, tipo_depto_parc_desc \n\n" .
        "FROM planos_parc_prov LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "planos_parc_prov.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @259-4F8B9E4D
    function SetValues()
    {
        $this->planos_prov_seccion->SetDBValue($this->f("planos_prov_seccion"));
        $this->planos_prov_macizo->SetDBValue($this->f("planos_prov_macizo"));
        $this->planos_prov_chacra->SetDBValue($this->f("planos_prov_chacra"));
        $this->planos_prov_quinta->SetDBValue($this->f("planos_prov_quinta"));
        $this->planos_prov_fraccion->SetDBValue($this->f("planos_prov_fraccion"));
        $this->parcela_uf->SetDBValue($this->f("parcela_uf"));
        $this->parcela_predio->SetDBValue($this->f("parcela_predio"));
        $this->parcela_rte->SetDBValue($this->f("parcela_rte"));
        $this->tipo_depto_parc_desc->SetDBValue($this->f("tipo_depto_parc_desc"));
        $this->planos_prov_parcela->SetDBValue($this->f("planos_prov_parcela"));
    }
//End SetValues Method

} //End parcelas_destino_creadasDataSource Class @259-FCB6E20C

class clsEditableGridEditableGrid1 { //EditableGrid1 Class @308-6C37505C

//Variables @308-F9538F3C

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

//Class_Initialize Event @308-E2284627
    function clsEditableGridEditableGrid1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid EditableGrid1/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "EditableGrid1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["mejora_id"][0] = "mejora_id";
        $this->DataSource = new clsEditableGrid1DataSource($this);
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

        $this->EmptyRows = 3;
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

        $this->parcela_partida = new clsControl(ccsLabel, "parcela_partida", "Parcela Id", ccsInteger, "", NULL, $this);
        $this->tipo_mejora_descrip = new clsControl(ccsLabel, "tipo_mejora_descrip", "Tipo Mejora Id", ccsText, "", NULL, $this);
        $this->tipo_mejora_estado_descrip = new clsControl(ccsLabel, "tipo_mejora_estado_descrip", "Tipo Mejora Estado Id", ccsText, "", NULL, $this);
        $this->tipo_mejora_destino_descrip = new clsControl(ccsLabel, "tipo_mejora_destino_descrip", "Tipo Mejora Destino Id", ccsText, "", NULL, $this);
        $this->mejora_nro_nota = new clsControl(ccsLabel, "mejora_nro_nota", "Mejora Nro Nota", ccsInteger, "", NULL, $this);
        $this->mejora_nro_exp = new clsControl(ccsLabel, "mejora_nro_exp", "Mejora Nro Exp", ccsInteger, "", NULL, $this);
        $this->mejora_letra_exp = new clsControl(ccsLabel, "mejora_letra_exp", "Mejora Letra Exp", ccsText, "", NULL, $this);
        $this->mejora_fecha_exp = new clsControl(ccsLabel, "mejora_fecha_exp", "Mejora Fecha Exp", ccsDate, $DefaultDateFormat, NULL, $this);
        $this->mejora_sup_cub = new clsControl(ccsLabel, "mejora_sup_cub", "Mejora Sup Cub", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), NULL, $this);
        $this->mejora_sup_semi_cub = new clsControl(ccsLabel, "mejora_sup_semi_cub", "Mejora Sup Semi Cub", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), NULL, $this);
        $this->mejora_porc_dominio = new clsControl(ccsLabel, "mejora_porc_dominio", "Mejora Porc Dominio", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), NULL, $this);
        $this->mejora_f_alta = new clsControl(ccsLabel, "mejora_f_alta", "Mejora F Alta", ccsDate, $DefaultDateFormat, NULL, $this);
        $this->Button_Submit = new clsButton("Button_Submit", $Method, $this);
        $this->Cancel = new clsButton("Cancel", $Method, $this);
        $this->parcelas_destinos_sel = new clsControl(ccsListBox, "parcelas_destinos_sel", "parcelas_destinos_sel", ccsInteger, "", NULL, $this);
        $this->parcelas_destinos_sel->DSType = dsTable;
        $this->parcelas_destinos_sel->DataSource = new clsDBtdf_nuevo();
        $this->parcelas_destinos_sel->ds = & $this->parcelas_destinos_sel->DataSource;
        $this->parcelas_destinos_sel->DataSource->SQL = "SELECT planos_prov_id, CONCAT('S:',IF(parcela_seccion IS NULL, '', parcela_seccion), ' / Ch:',IF(parcela_chacra IS NULL, '', parcela_chacra), ' / Qu:', IF(parcela_quinta IS NULL, '', parcela_quinta), ' / Ma:', IF(parcela_macizo IS NULL, '', parcela_macizo), ' / Fr:', IF(parcela_fraccion IS NULL, '', parcela_fraccion), ' / Pa:', IF(parcela_parcela IS NULL, '', parcela_parcela), ' / UF:', IF(parcela_uf IS NULL, '', parcela_uf), ' / Pr:', IF(parcela_predio IS NULL, '', parcela_predio), ' / Rte:', IF(parcela_rte IS NULL, '', parcela_rte) ) AS parcela_detalle \n" .
"FROM planos_parc_prov INNER JOIN parcelas ON\n" .
"planos_parc_prov.parcela_id = parcelas.parcela_id {SQL_Where} {SQL_OrderBy}";
        list($this->parcelas_destinos_sel->BoundColumn, $this->parcelas_destinos_sel->TextColumn, $this->parcelas_destinos_sel->DBFormat) = array("planos_prov_id", "parcela_detalle", "");
        $this->parcelas_destinos_sel->DataSource->Parameters["expr363"] = destino;
        $this->parcelas_destinos_sel->DataSource->Parameters["urlplano_id"] = CCGetFromGet("plano_id", NULL);
        $this->parcelas_destinos_sel->DataSource->wp = new clsSQLParameters();
        $this->parcelas_destinos_sel->DataSource->wp->AddParameter("1", "expr363", ccsText, "", "", $this->parcelas_destinos_sel->DataSource->Parameters["expr363"], "", false);
        $this->parcelas_destinos_sel->DataSource->wp->AddParameter("2", "urlplano_id", ccsInteger, "", "", $this->parcelas_destinos_sel->DataSource->Parameters["urlplano_id"], "", false);
        $this->parcelas_destinos_sel->DataSource->wp->Criterion[1] = $this->parcelas_destinos_sel->DataSource->wp->Operation(opEqual, "planos_parc_prov.planos_parc_prov_tipo", $this->parcelas_destinos_sel->DataSource->wp->GetDBValue("1"), $this->parcelas_destinos_sel->DataSource->ToSQL($this->parcelas_destinos_sel->DataSource->wp->GetDBValue("1"), ccsText),false);
        $this->parcelas_destinos_sel->DataSource->wp->Criterion[2] = $this->parcelas_destinos_sel->DataSource->wp->Operation(opEqual, "planos_parc_prov.plano_id", $this->parcelas_destinos_sel->DataSource->wp->GetDBValue("2"), $this->parcelas_destinos_sel->DataSource->ToSQL($this->parcelas_destinos_sel->DataSource->wp->GetDBValue("2"), ccsInteger),false);
        $this->parcelas_destinos_sel->DataSource->wp->Criterion[3] = "( planos_parc_prov.parcela_id IS NOT NULL OR planos_parc_prov.parcela_id <> '' )";
        $this->parcelas_destinos_sel->DataSource->Where = $this->parcelas_destinos_sel->DataSource->wp->opAND(
             false, $this->parcelas_destinos_sel->DataSource->wp->opAND(
             false, 
             $this->parcelas_destinos_sel->DataSource->wp->Criterion[1], 
             $this->parcelas_destinos_sel->DataSource->wp->Criterion[2]), 
             $this->parcelas_destinos_sel->DataSource->wp->Criterion[3]);
        $this->parcelas_destino_creadas = new clsControl(ccsListBox, "parcelas_destino_creadas", "parcelas_destino_creadas", ccsText, "", NULL, $this);
        $this->parcelas_destino_creadas->DSType = dsTable;
        $this->parcelas_destino_creadas->DataSource = new clsDBtdf_nuevo();
        $this->parcelas_destino_creadas->ds = & $this->parcelas_destino_creadas->DataSource;
        $this->parcelas_destino_creadas->DataSource->SQL = "SELECT planos_prov_id, CONCAT('S:',IF(planos_prov_seccion IS NULL, '', planos_prov_seccion), ' / Ch:',IF(planos_prov_chacra IS NULL, '', planos_prov_chacra), ' / Qu:', IF(planos_prov_quinta IS NULL, '', planos_prov_quinta), ' / Ma:', IF(planos_prov_macizo IS NULL, '', planos_prov_macizo), ' / Fr:', IF(planos_prov_fraccion IS NULL, '', planos_prov_fraccion), ' / Pa:', IF(planos_prov_parcela IS NULL, '', planos_prov_parcela), ' / UF:', IF(planos_prov_uf IS NULL, '', planos_prov_uf), ' / Pr:', IF(planos_prov_predio IS NULL, '', planos_prov_predio), ' / Rte:', IF(planos_prov_rte IS NULL, '', planos_prov_rte) ) AS parcela_detalle \n" .
"FROM planos_parc_prov {SQL_Where} {SQL_OrderBy}";
        list($this->parcelas_destino_creadas->BoundColumn, $this->parcelas_destino_creadas->TextColumn, $this->parcelas_destino_creadas->DBFormat) = array("planos_prov_id", "parcela_detalle", "");
        $this->parcelas_destino_creadas->DataSource->Parameters["urlplano_id"] = CCGetFromGet("plano_id", NULL);
        $this->parcelas_destino_creadas->DataSource->Parameters["expr368"] = destino;
        $this->parcelas_destino_creadas->DataSource->wp = new clsSQLParameters();
        $this->parcelas_destino_creadas->DataSource->wp->AddParameter("1", "urlplano_id", ccsInteger, "", "", $this->parcelas_destino_creadas->DataSource->Parameters["urlplano_id"], "", false);
        $this->parcelas_destino_creadas->DataSource->wp->AddParameter("2", "expr368", ccsText, "", "", $this->parcelas_destino_creadas->DataSource->Parameters["expr368"], "", false);
        $this->parcelas_destino_creadas->DataSource->wp->Criterion[1] = $this->parcelas_destino_creadas->DataSource->wp->Operation(opEqual, "plano_id", $this->parcelas_destino_creadas->DataSource->wp->GetDBValue("1"), $this->parcelas_destino_creadas->DataSource->ToSQL($this->parcelas_destino_creadas->DataSource->wp->GetDBValue("1"), ccsInteger),false);
        $this->parcelas_destino_creadas->DataSource->wp->Criterion[2] = $this->parcelas_destino_creadas->DataSource->wp->Operation(opEqual, "planos_parc_prov_tipo", $this->parcelas_destino_creadas->DataSource->wp->GetDBValue("2"), $this->parcelas_destino_creadas->DataSource->ToSQL($this->parcelas_destino_creadas->DataSource->wp->GetDBValue("2"), ccsText),false);
        $this->parcelas_destino_creadas->DataSource->wp->Criterion[3] = "( planos_parc_prov.parcela_id IS NULL OR planos_parc_prov.parcela_id = '' )";
        $this->parcelas_destino_creadas->DataSource->Where = $this->parcelas_destino_creadas->DataSource->wp->opAND(
             false, $this->parcelas_destino_creadas->DataSource->wp->opAND(
             false, 
             $this->parcelas_destino_creadas->DataSource->wp->Criterion[1], 
             $this->parcelas_destino_creadas->DataSource->wp->Criterion[2]), 
             $this->parcelas_destino_creadas->DataSource->wp->Criterion[3]);
        $this->Button_Registrar = new clsButton("Button_Registrar", $Method, $this);
        $this->mejora_id = new clsControl(ccsHidden, "mejora_id", "mejora_id", ccsText, "", NULL, $this);
    }
//End Class_Initialize Event

//Initialize Method @308-663FF5DC
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["urlplano_id"] = CCGetFromGet("plano_id", NULL);
    }
//End Initialize Method

//SetPrimaryKeys Method @308-EBC3F86C
    function SetPrimaryKeys($PrimaryKeys) {
        $this->PrimaryKeys = $PrimaryKeys;
        return $this->PrimaryKeys;
    }
//End SetPrimaryKeys Method

//GetPrimaryKeys Method @308-74F9A772
    function GetPrimaryKeys() {
        return $this->PrimaryKeys;
    }
//End GetPrimaryKeys Method

//GetFormParameters Method @308-5CEF53DC
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["parcelas_destinos_sel"][$RowNumber] = CCGetFromPost("parcelas_destinos_sel_" . $RowNumber, NULL);
            $this->FormParameters["parcelas_destino_creadas"][$RowNumber] = CCGetFromPost("parcelas_destino_creadas_" . $RowNumber, NULL);
            $this->FormParameters["mejora_id"][$RowNumber] = CCGetFromPost("mejora_id_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @308-90AB697B
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["mejora_id"] = $this->CachedColumns["mejora_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->parcelas_destinos_sel->SetText($this->FormParameters["parcelas_destinos_sel"][$this->RowNumber], $this->RowNumber);
            $this->parcelas_destino_creadas->SetText($this->FormParameters["parcelas_destino_creadas"][$this->RowNumber], $this->RowNumber);
            $this->mejora_id->SetText($this->FormParameters["mejora_id"][$this->RowNumber], $this->RowNumber);
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

//ValidateRow Method @308-6FE32825
    function ValidateRow()
    {
        global $CCSLocales;
        $this->parcelas_destinos_sel->Validate();
        $this->parcelas_destino_creadas->Validate();
        $this->mejora_id->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->parcelas_destinos_sel->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcelas_destino_creadas->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_id->Errors->ToString());
        $this->parcelas_destinos_sel->Errors->Clear();
        $this->parcelas_destino_creadas->Errors->Clear();
        $this->mejora_id->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @308-AA2CB293
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["parcelas_destinos_sel"][$this->RowNumber]) && count($this->FormParameters["parcelas_destinos_sel"][$this->RowNumber])) || strlen($this->FormParameters["parcelas_destinos_sel"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["parcelas_destino_creadas"][$this->RowNumber]) && count($this->FormParameters["parcelas_destino_creadas"][$this->RowNumber])) || strlen($this->FormParameters["parcelas_destino_creadas"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["mejora_id"][$this->RowNumber]) && count($this->FormParameters["mejora_id"][$this->RowNumber])) || strlen($this->FormParameters["mejora_id"][$this->RowNumber]));
        return $filed;
    }
//End CheckInsert Method

//CheckErrors Method @308-F5A3B433
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @308-9793C7E9
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
        } else if($this->Button_Registrar->Pressed) {
            $this->PressedButton = "Button_Registrar";
        }

        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Submit") {
            if(!CCGetEvent($this->Button_Submit->CCSEvents, "OnClick", $this->Button_Submit) || !$this->UpdateGrid()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Cancel") {
            if(!CCGetEvent($this->Cancel->CCSEvents, "OnClick", $this->Cancel)) {
                $Redirect = "";
            } else {
                $Redirect = "tc_planosRecord.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
            }
        } else if($this->PressedButton == "Button_Registrar") {
            if(!CCGetEvent($this->Button_Registrar->CCSEvents, "OnClick", $this->Button_Registrar)) {
                $Redirect = "";
            }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//UpdateGrid Method @308-40F3936C
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["mejora_id"] = $this->CachedColumns["mejora_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->parcelas_destinos_sel->SetText($this->FormParameters["parcelas_destinos_sel"][$this->RowNumber], $this->RowNumber);
            $this->parcelas_destino_creadas->SetText($this->FormParameters["parcelas_destino_creadas"][$this->RowNumber], $this->RowNumber);
            $this->mejora_id->SetText($this->FormParameters["mejora_id"][$this->RowNumber], $this->RowNumber);
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

//FormScript Method @308-E623D01D
    function FormScript($TotalRows)
    {
        $script = "";
        $script .= "\n<script language=\"JavaScript\" type=\"text/javascript\">\n<!--\n";
        $script .= "var EditableGrid1Elements;\n";
        $script .= "var EditableGrid1EmptyRows = 3;\n";
        $script .= "var " . $this->ComponentName . "parcelas_destinos_selID = 0;\n";
        $script .= "var " . $this->ComponentName . "parcelas_destino_creadasID = 1;\n";
        $script .= "var " . $this->ComponentName . "mejora_idID = 2;\n";
        $script .= "\nfunction initEditableGrid1Elements() {\n";
        $script .= "\tvar ED = document.forms[\"EditableGrid1\"];\n";
        $script .= "\tEditableGrid1Elements = new Array (\n";
        for($i = 1; $i <= $TotalRows; $i++) {
            $script .= "\t\tnew Array(" . "ED.parcelas_destinos_sel_" . $i . ", " . "ED.parcelas_destino_creadas_" . $i . ", " . "ED.mejora_id_" . $i . ")";
            if($i != $TotalRows) $script .= ",\n";
        }
        $script .= ");\n";
        $script .= "}\n";
        $script .= "\n//-->\n</script>";
        return $script;
    }
//End FormScript Method

//SetFormState Method @308-A620F641
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
                $this->CachedColumns["mejora_id"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["mejora_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @308-64D970EC
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["mejora_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @308-5D6CCE38
    function Show()
    {
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        global $CCSUseAmp;
        $Error = "";

        if(!$this->Visible) { return; }

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->parcelas_destinos_sel->Prepare();
        $this->parcelas_destino_creadas->Prepare();

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
        $this->ControlsVisible["parcela_partida"] = $this->parcela_partida->Visible;
        $this->ControlsVisible["tipo_mejora_descrip"] = $this->tipo_mejora_descrip->Visible;
        $this->ControlsVisible["tipo_mejora_estado_descrip"] = $this->tipo_mejora_estado_descrip->Visible;
        $this->ControlsVisible["tipo_mejora_destino_descrip"] = $this->tipo_mejora_destino_descrip->Visible;
        $this->ControlsVisible["mejora_nro_nota"] = $this->mejora_nro_nota->Visible;
        $this->ControlsVisible["mejora_nro_exp"] = $this->mejora_nro_exp->Visible;
        $this->ControlsVisible["mejora_letra_exp"] = $this->mejora_letra_exp->Visible;
        $this->ControlsVisible["mejora_fecha_exp"] = $this->mejora_fecha_exp->Visible;
        $this->ControlsVisible["mejora_sup_cub"] = $this->mejora_sup_cub->Visible;
        $this->ControlsVisible["mejora_sup_semi_cub"] = $this->mejora_sup_semi_cub->Visible;
        $this->ControlsVisible["mejora_porc_dominio"] = $this->mejora_porc_dominio->Visible;
        $this->ControlsVisible["mejora_f_alta"] = $this->mejora_f_alta->Visible;
        $this->ControlsVisible["parcelas_destinos_sel"] = $this->parcelas_destinos_sel->Visible;
        $this->ControlsVisible["parcelas_destino_creadas"] = $this->parcelas_destino_creadas->Visible;
        $this->ControlsVisible["mejora_id"] = $this->mejora_id->Visible;
        if ($is_next_record || ($EmptyRowsLeft && $this->InsertAllowed)) {
            do {
                $this->RowNumber++;
                if($is_next_record) {
                    $NonEmptyRows++;
                    $this->DataSource->SetValues();
                }
                if (!($this->FormSubmitted) && $is_next_record) {
                    $this->CachedColumns["mejora_id"][$this->RowNumber] = $this->DataSource->CachedColumns["mejora_id"];
                    $this->parcelas_destinos_sel->SetText("");
                    $this->parcelas_destino_creadas->SetText("");
                    $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
                    $this->tipo_mejora_descrip->SetValue($this->DataSource->tipo_mejora_descrip->GetValue());
                    $this->tipo_mejora_estado_descrip->SetValue($this->DataSource->tipo_mejora_estado_descrip->GetValue());
                    $this->tipo_mejora_destino_descrip->SetValue($this->DataSource->tipo_mejora_destino_descrip->GetValue());
                    $this->mejora_nro_nota->SetValue($this->DataSource->mejora_nro_nota->GetValue());
                    $this->mejora_nro_exp->SetValue($this->DataSource->mejora_nro_exp->GetValue());
                    $this->mejora_letra_exp->SetValue($this->DataSource->mejora_letra_exp->GetValue());
                    $this->mejora_fecha_exp->SetValue($this->DataSource->mejora_fecha_exp->GetValue());
                    $this->mejora_sup_cub->SetValue($this->DataSource->mejora_sup_cub->GetValue());
                    $this->mejora_sup_semi_cub->SetValue($this->DataSource->mejora_sup_semi_cub->GetValue());
                    $this->mejora_porc_dominio->SetValue($this->DataSource->mejora_porc_dominio->GetValue());
                    $this->mejora_f_alta->SetValue($this->DataSource->mejora_f_alta->GetValue());
                    $this->mejora_id->SetValue($this->DataSource->mejora_id->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->parcela_partida->SetText("");
                    $this->tipo_mejora_descrip->SetText("");
                    $this->tipo_mejora_estado_descrip->SetText("");
                    $this->tipo_mejora_destino_descrip->SetText("");
                    $this->mejora_nro_nota->SetText("");
                    $this->mejora_nro_exp->SetText("");
                    $this->mejora_letra_exp->SetText("");
                    $this->mejora_fecha_exp->SetText("");
                    $this->mejora_sup_cub->SetText("");
                    $this->mejora_sup_semi_cub->SetText("");
                    $this->mejora_porc_dominio->SetText("");
                    $this->mejora_f_alta->SetText("");
                    $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
                    $this->tipo_mejora_descrip->SetValue($this->DataSource->tipo_mejora_descrip->GetValue());
                    $this->tipo_mejora_estado_descrip->SetValue($this->DataSource->tipo_mejora_estado_descrip->GetValue());
                    $this->tipo_mejora_destino_descrip->SetValue($this->DataSource->tipo_mejora_destino_descrip->GetValue());
                    $this->mejora_nro_nota->SetValue($this->DataSource->mejora_nro_nota->GetValue());
                    $this->mejora_nro_exp->SetValue($this->DataSource->mejora_nro_exp->GetValue());
                    $this->mejora_letra_exp->SetValue($this->DataSource->mejora_letra_exp->GetValue());
                    $this->mejora_fecha_exp->SetValue($this->DataSource->mejora_fecha_exp->GetValue());
                    $this->mejora_sup_cub->SetValue($this->DataSource->mejora_sup_cub->GetValue());
                    $this->mejora_sup_semi_cub->SetValue($this->DataSource->mejora_sup_semi_cub->GetValue());
                    $this->mejora_porc_dominio->SetValue($this->DataSource->mejora_porc_dominio->GetValue());
                    $this->mejora_f_alta->SetValue($this->DataSource->mejora_f_alta->GetValue());
                    $this->parcelas_destinos_sel->SetText($this->FormParameters["parcelas_destinos_sel"][$this->RowNumber], $this->RowNumber);
                    $this->parcelas_destino_creadas->SetText($this->FormParameters["parcelas_destino_creadas"][$this->RowNumber], $this->RowNumber);
                    $this->mejora_id->SetText($this->FormParameters["mejora_id"][$this->RowNumber], $this->RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["mejora_id"][$this->RowNumber] = "";
                    $this->parcela_partida->SetText("");
                    $this->tipo_mejora_descrip->SetText("");
                    $this->tipo_mejora_estado_descrip->SetText("");
                    $this->tipo_mejora_destino_descrip->SetText("");
                    $this->mejora_nro_nota->SetText("");
                    $this->mejora_nro_exp->SetText("");
                    $this->mejora_letra_exp->SetText("");
                    $this->mejora_fecha_exp->SetText("");
                    $this->mejora_sup_cub->SetText("");
                    $this->mejora_sup_semi_cub->SetText("");
                    $this->mejora_porc_dominio->SetText("");
                    $this->mejora_f_alta->SetText("");
                    $this->parcelas_destinos_sel->SetText("");
                    $this->parcelas_destino_creadas->SetText("");
                    $this->mejora_id->SetText("");
                } else {
                    $this->parcela_partida->SetText("");
                    $this->tipo_mejora_descrip->SetText("");
                    $this->tipo_mejora_estado_descrip->SetText("");
                    $this->tipo_mejora_destino_descrip->SetText("");
                    $this->mejora_nro_nota->SetText("");
                    $this->mejora_nro_exp->SetText("");
                    $this->mejora_letra_exp->SetText("");
                    $this->mejora_fecha_exp->SetText("");
                    $this->mejora_sup_cub->SetText("");
                    $this->mejora_sup_semi_cub->SetText("");
                    $this->mejora_porc_dominio->SetText("");
                    $this->mejora_f_alta->SetText("");
                    $this->parcelas_destinos_sel->SetText($this->FormParameters["parcelas_destinos_sel"][$this->RowNumber], $this->RowNumber);
                    $this->parcelas_destino_creadas->SetText($this->FormParameters["parcelas_destino_creadas"][$this->RowNumber], $this->RowNumber);
                    $this->mejora_id->SetText($this->FormParameters["mejora_id"][$this->RowNumber], $this->RowNumber);
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->parcela_partida->Show($this->RowNumber);
                $this->tipo_mejora_descrip->Show($this->RowNumber);
                $this->tipo_mejora_estado_descrip->Show($this->RowNumber);
                $this->tipo_mejora_destino_descrip->Show($this->RowNumber);
                $this->mejora_nro_nota->Show($this->RowNumber);
                $this->mejora_nro_exp->Show($this->RowNumber);
                $this->mejora_letra_exp->Show($this->RowNumber);
                $this->mejora_fecha_exp->Show($this->RowNumber);
                $this->mejora_sup_cub->Show($this->RowNumber);
                $this->mejora_sup_semi_cub->Show($this->RowNumber);
                $this->mejora_porc_dominio->Show($this->RowNumber);
                $this->mejora_f_alta->Show($this->RowNumber);
                $this->parcelas_destinos_sel->Show($this->RowNumber);
                $this->parcelas_destino_creadas->Show($this->RowNumber);
                $this->mejora_id->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["mejora_id"] == $this->CachedColumns["mejora_id"][$this->RowNumber])) {
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
        $this->Cancel->Show();
        $this->Button_Registrar->Show();

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

} //End EditableGrid1 Class @308-FCB6E20C

class clsEditableGrid1DataSource extends clsDBtdf_nuevo {  //EditableGrid1DataSource Class @308-8C33ADEE

//DataSource Variables @308-A32374AC
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
    public $parcela_partida;
    public $tipo_mejora_descrip;
    public $tipo_mejora_estado_descrip;
    public $tipo_mejora_destino_descrip;
    public $mejora_nro_nota;
    public $mejora_nro_exp;
    public $mejora_letra_exp;
    public $mejora_fecha_exp;
    public $mejora_sup_cub;
    public $mejora_sup_semi_cub;
    public $mejora_porc_dominio;
    public $mejora_f_alta;
    public $parcelas_destinos_sel;
    public $parcelas_destino_creadas;
    public $mejora_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @308-36134BCA
    function clsEditableGrid1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid EditableGrid1/Error";
        $this->Initialize();
        $this->parcela_partida = new clsField("parcela_partida", ccsInteger, "");
        
        $this->tipo_mejora_descrip = new clsField("tipo_mejora_descrip", ccsText, "");
        
        $this->tipo_mejora_estado_descrip = new clsField("tipo_mejora_estado_descrip", ccsText, "");
        
        $this->tipo_mejora_destino_descrip = new clsField("tipo_mejora_destino_descrip", ccsText, "");
        
        $this->mejora_nro_nota = new clsField("mejora_nro_nota", ccsInteger, "");
        
        $this->mejora_nro_exp = new clsField("mejora_nro_exp", ccsInteger, "");
        
        $this->mejora_letra_exp = new clsField("mejora_letra_exp", ccsText, "");
        
        $this->mejora_fecha_exp = new clsField("mejora_fecha_exp", ccsDate, $this->DateFormat);
        
        $this->mejora_sup_cub = new clsField("mejora_sup_cub", ccsFloat, "");
        
        $this->mejora_sup_semi_cub = new clsField("mejora_sup_semi_cub", ccsFloat, "");
        
        $this->mejora_porc_dominio = new clsField("mejora_porc_dominio", ccsFloat, "");
        
        $this->mejora_f_alta = new clsField("mejora_f_alta", ccsDate, $this->DateFormat);
        
        $this->parcelas_destinos_sel = new clsField("parcelas_destinos_sel", ccsInteger, "");
        
        $this->parcelas_destino_creadas = new clsField("parcelas_destino_creadas", ccsText, "");
        
        $this->mejora_id = new clsField("mejora_id", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @308-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @308-4F030B1E
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlplano_id", ccsText, "", "", $this->Parameters["urlplano_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
    }
//End Prepare Method

//Open Method @308-56A142C4
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*) FROM mejoras\n" .
        "INNER JOIN parcelas ON parcelas.parcela_id = mejoras.parcela_id\n" .
        "INNER JOIN planos_parc_prov ON planos_parc_prov.parcela_id = parcelas.parcela_id\n" .
        "LEFT JOIN tipos_mejoras ON tipos_mejoras.tipo_mejora_id = mejoras.tipo_mejora_id\n" .
        "LEFT JOIN tipos_mejoras_estados ON tipos_mejoras_estados.tipo_mejora_estado_id = mejoras.tipo_mejora_estado_id\n" .
        "LEFT JOIN tipos_mejoras_destinos ON tipos_mejoras_destinos.tipo_mejora_destino_id = mejoras.tipo_mejora_destino_id\n" .
        "WHERE planos_parc_prov.plano_id = " . $this->SQLValue($this->wp->GetDBValue("1"), ccsText) . "";
        $this->SQL = "SELECT planos_parc_prov.planos_prov_id, planos_parc_prov.plano_id, parcelas.parcela_partida,\n" .
        "	mejoras.*,\n" .
        "	tipo_mejora_descrip,\n" .
        "	tipo_mejora_estado_descrip,\n" .
        "	tipo_mejora_destino_descrip\n" .
        "FROM mejoras\n" .
        "INNER JOIN parcelas ON parcelas.parcela_id = mejoras.parcela_id\n" .
        "INNER JOIN planos_parc_prov ON planos_parc_prov.parcela_id = parcelas.parcela_id\n" .
        "LEFT JOIN tipos_mejoras ON tipos_mejoras.tipo_mejora_id = mejoras.tipo_mejora_id\n" .
        "LEFT JOIN tipos_mejoras_estados ON tipos_mejoras_estados.tipo_mejora_estado_id = mejoras.tipo_mejora_estado_id\n" .
        "LEFT JOIN tipos_mejoras_destinos ON tipos_mejoras_destinos.tipo_mejora_destino_id = mejoras.tipo_mejora_destino_id\n" .
        "WHERE planos_parc_prov.plano_id = " . $this->SQLValue($this->wp->GetDBValue("1"), ccsText) . "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @308-490BAC46
    function SetValues()
    {
        $this->CachedColumns["mejora_id"] = $this->f("mejora_id");
        $this->parcela_partida->SetDBValue(trim($this->f("parcela_partida")));
        $this->tipo_mejora_descrip->SetDBValue($this->f("tipo_mejora_descrip"));
        $this->tipo_mejora_estado_descrip->SetDBValue($this->f("tipo_mejora_estado_descrip"));
        $this->tipo_mejora_destino_descrip->SetDBValue($this->f("tipo_mejora_destino_descrip"));
        $this->mejora_nro_nota->SetDBValue(trim($this->f("mejora_nro_nota")));
        $this->mejora_nro_exp->SetDBValue(trim($this->f("mejora_nro_exp")));
        $this->mejora_letra_exp->SetDBValue($this->f("mejora_letra_exp"));
        $this->mejora_fecha_exp->SetDBValue(trim($this->f("mejora_fecha_exp")));
        $this->mejora_sup_cub->SetDBValue(trim($this->f("mejora_sup_cub")));
        $this->mejora_sup_semi_cub->SetDBValue(trim($this->f("mejora_sup_semi_cub")));
        $this->mejora_porc_dominio->SetDBValue(trim($this->f("mejora_porc_dominio")));
        $this->mejora_f_alta->SetDBValue(trim($this->f("mejora_f_alta")));
        $this->mejora_id->SetDBValue($this->f("mejora_id"));
    }
//End SetValues Method

} //End EditableGrid1DataSource Class @308-FCB6E20C

//Initialize Page @1-E42D2DEA
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
$TemplateFileName = "tc_planosRegistro.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-B92DD6B4
include_once("./tc_planosRegistro_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-E467339C
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$planos_detalle = new clsGridplanos_detalle("", $MainPage);
$parcelas_origen = new clsGridparcelas_origen("", $MainPage);
$parcelas_destino_sel = new clsGridparcelas_destino_sel("", $MainPage);
$parcelas_destino_creadas = new clsGridparcelas_destino_creadas("", $MainPage);
$EditableGrid1 = new clsEditableGridEditableGrid1("", $MainPage);
$results_message = new clsControl(ccsLabel, "results_message", "results_message", ccsText, "", CCGetRequestParam("results_message", ccsGet, NULL), $MainPage);
$results_message->HTML = true;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->planos_detalle = & $planos_detalle;
$MainPage->parcelas_origen = & $parcelas_origen;
$MainPage->parcelas_destino_sel = & $parcelas_destino_sel;
$MainPage->parcelas_destino_creadas = & $parcelas_destino_creadas;
$MainPage->EditableGrid1 = & $EditableGrid1;
$MainPage->results_message = & $results_message;
$planos_detalle->Initialize();
$parcelas_origen->Initialize();
$parcelas_destino_sel->Initialize();
$parcelas_destino_creadas->Initialize();
$EditableGrid1->Initialize();

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

//Execute Components @1-A586B3DD
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
$EditableGrid1->Operation();
//End Execute Components

//Go to destination page @1-D820919E
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    unset($planos_detalle);
    unset($parcelas_origen);
    unset($parcelas_destino_sel);
    unset($parcelas_destino_creadas);
    unset($EditableGrid1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-73D07A86
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$planos_detalle->Show();
$parcelas_origen->Show();
$parcelas_destino_sel->Show();
$parcelas_destino_creadas->Show();
$EditableGrid1->Show();
$results_message->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font face=\"Arial" . "\"><small>&#71;&#101;ne&#1" . "14;&#97;t&#101;&#100; <!-- SC" . "C -->&#119;&#105;&#116;h " . "<!-- CCS -->Cod&#101;Ch&#97" . ";&#114;ge <!-- SCC -->S&#116;" . "udio.</small></font></cente" . "r>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font face=\"Arial" . "\"><small>&#71;&#101;ne&#1" . "14;&#97;t&#101;&#100; <!-- SC" . "C -->&#119;&#105;&#116;h " . "<!-- CCS -->Cod&#101;Ch&#97" . ";&#114;ge <!-- SCC -->S&#116;" . "udio.</small></font></cente" . "r>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font face=\"Arial" . "\"><small>&#71;&#101;ne&#1" . "14;&#97;t&#101;&#100; <!-- SC" . "C -->&#119;&#105;&#116;h " . "<!-- CCS -->Cod&#101;Ch&#97" . ";&#114;ge <!-- SCC -->S&#116;" . "udio.</small></font></cente" . "r>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-D74A1806
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($planos_detalle);
unset($parcelas_origen);
unset($parcelas_destino_sel);
unset($parcelas_destino_creadas);
unset($EditableGrid1);
unset($Tpl);
//End Unload Page


?>
