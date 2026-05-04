<?php
//Include Common Files @1-C6FEB92B
define("RelativePath", "..");
define("PathToCurrentPage", "/gestion/");
define("FileName", "union2.php");
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

class clsGridparcelas_tmp { //parcelas_tmp class @8-577B9E36

//Variables @8-10C8FD28

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
    public $Sorter_parcela_partida;
    public $Sorter_parcela_nomenclatura;
//End Variables

//Class_Initialize Event @8-F56ABA9A
    function clsGridparcelas_tmp($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "parcelas_tmp";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid parcelas_tmp";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsparcelas_tmpDataSource($this);
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
        $this->SorterName = CCGetParam("parcelas_tmpOrder", "");
        $this->SorterDirection = CCGetParam("parcelas_tmpDir", "");

        $this->parcela_partida = new clsControl(ccsLabel, "parcela_partida", "parcela_partida", ccsInteger, "", CCGetRequestParam("parcela_partida", ccsGet, NULL), $this);
        $this->parcela_nomenclatura = new clsControl(ccsLabel, "parcela_nomenclatura", "parcela_nomenclatura", ccsText, "", CCGetRequestParam("parcela_nomenclatura", ccsGet, NULL), $this);
        $this->Sorter_parcela_partida = new clsSorter($this->ComponentName, "Sorter_parcela_partida", $FileName, $this);
        $this->Sorter_parcela_nomenclatura = new clsSorter($this->ComponentName, "Sorter_parcela_nomenclatura", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->New = new clsControl(ccsLink, "New", "New", ccsText, "", CCGetRequestParam("New", ccsGet, NULL), $this);
        $this->New->Parameters = CCGetQueryString("QueryString", array("id", "ccsForm"));
        $this->New->Page = "";
    }
//End Class_Initialize Event

//Initialize Method @8-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @8-EEDC09C8
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;


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
            $this->ControlsVisible["parcela_nomenclatura"] = $this->parcela_nomenclatura->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
                $this->parcela_nomenclatura->SetValue($this->DataSource->parcela_nomenclatura->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->parcela_partida->Show();
                $this->parcela_nomenclatura->Show();
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
        $this->Navigator->PageNumber = $this->DataSource->AbsolutePage;
        $this->Navigator->PageSize = $this->PageSize;
        if ($this->DataSource->RecordsCount == "CCS not counted")
            $this->Navigator->TotalPages = $this->DataSource->AbsolutePage + ($this->DataSource->next_record() ? 1 : 0);
        else
            $this->Navigator->TotalPages = $this->DataSource->PageCount();
        if ($this->Navigator->TotalPages <= 1) {
            $this->Navigator->Visible = false;
        }
        $this->Sorter_parcela_partida->Show();
        $this->Sorter_parcela_nomenclatura->Show();
        $this->Navigator->Show();
        $this->New->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @8-DD146A06
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->parcela_partida->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_nomenclatura->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End parcelas_tmp Class @8-FCB6E20C

class clsparcelas_tmpDataSource extends clsDBtdf_nuevo {  //parcelas_tmpDataSource Class @8-1AB92E1D

//DataSource Variables @8-39371997
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $parcela_partida;
    public $parcela_nomenclatura;
//End DataSource Variables

//DataSourceClass_Initialize Event @8-387DDBA5
    function clsparcelas_tmpDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid parcelas_tmp";
        $this->Initialize();
        $this->parcela_partida = new clsField("parcela_partida", ccsInteger, "");
        
        $this->parcela_nomenclatura = new clsField("parcela_nomenclatura", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @8-6F6EDCD9
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_parcela_partida" => array("parcela_partida", ""), 
            "Sorter_parcela_nomenclatura" => array("parcela_nomenclatura", "")));
    }
//End SetOrder Method

//Prepare Method @8-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @8-8A19A27B
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM tmp INNER JOIN parcelas ON\n\n" .
        "tmp.tmp_parcela_id = parcelas.parcela_id";
        $this->SQL = "SELECT * \n\n" .
        "FROM tmp INNER JOIN parcelas ON\n\n" .
        "tmp.tmp_parcela_id = parcelas.parcela_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @8-DBE407AE
    function SetValues()
    {
        $this->parcela_partida->SetDBValue(trim($this->f("parcela_partida")));
        $this->parcela_nomenclatura->SetDBValue($this->f("parcela_nomenclatura"));
    }
//End SetValues Method

} //End parcelas_tmpDataSource Class @8-FCB6E20C

class clsRecordpadrones_parcelas_parcela { //padrones_parcelas_parcela Class @19-F3F45EC7

//Variables @19-9E315808

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

//Class_Initialize Event @19-910C1197
    function clsRecordpadrones_parcelas_parcela($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record padrones_parcelas_parcela/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "padrones_parcelas_parcela";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->parcela_parcela = new clsControl(ccsTextBox, "parcela_parcela", "Parcela", ccsText, "", CCGetRequestParam("parcela_parcela", $Method, NULL), $this);
            $this->parcela_quinta = new clsControl(ccsTextBox, "parcela_quinta", "Quinta", ccsText, "", CCGetRequestParam("parcela_quinta", $Method, NULL), $this);
            $this->parcela_fraccion = new clsControl(ccsTextBox, "parcela_fraccion", "Fraccion", ccsText, "", CCGetRequestParam("parcela_fraccion", $Method, NULL), $this);
            $this->parcela_uf = new clsControl(ccsTextBox, "parcela_uf", "Uf", ccsText, "", CCGetRequestParam("parcela_uf", $Method, NULL), $this);
            $this->cancel = new clsButton("cancel", $Method, $this);
            $this->parcela_macizo = new clsControl(ccsTextBox, "parcela_macizo", "Macizo", ccsText, "", CCGetRequestParam("parcela_macizo", $Method, NULL), $this);
            $this->parcela_predio = new clsControl(ccsTextBox, "parcela_predio", "parcela_predio", ccsText, "", CCGetRequestParam("parcela_predio", $Method, NULL), $this);
            $this->parcela_rte = new clsControl(ccsTextBox, "parcela_rte", "parcela_rte", ccsText, "", CCGetRequestParam("parcela_rte", $Method, NULL), $this);
            $this->tipo_est_parc_id = new clsControl(ccsListBox, "tipo_est_parc_id", "tipo_est_parc_id", ccsInteger, "", CCGetRequestParam("tipo_est_parc_id", $Method, NULL), $this);
            $this->tipo_est_parc_id->DSType = dsTable;
            $this->tipo_est_parc_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_est_parc_id->ds = & $this->tipo_est_parc_id->DataSource;
            $this->tipo_est_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_estados_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_est_parc_id->BoundColumn, $this->tipo_est_parc_id->TextColumn, $this->tipo_est_parc_id->DBFormat) = array("tipo_est_parc_id", "tipo_est_parc_descr", "");
            $this->tipo_parcela_uso_id = new clsControl(ccsListBox, "tipo_parcela_uso_id", "tipo_parcela_uso_id", ccsInteger, "", CCGetRequestParam("tipo_parcela_uso_id", $Method, NULL), $this);
            $this->tipo_parcela_uso_id->DSType = dsTable;
            $this->tipo_parcela_uso_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_parcela_uso_id->ds = & $this->tipo_parcela_uso_id->DataSource;
            $this->tipo_parcela_uso_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_parcelas_usos {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_parcela_uso_id->BoundColumn, $this->tipo_parcela_uso_id->TextColumn, $this->tipo_parcela_uso_id->DBFormat) = array("tipo_parcela_uso_id", "tipo_parcela_uso_descrip", "");
            $this->plano_nro = new clsControl(ccsTextBox, "plano_nro", "plano_nro", ccsText, "", CCGetRequestParam("plano_nro", $Method, NULL), $this);
            $this->plano_anio = new clsControl(ccsTextBox, "plano_anio", "plano_anio", ccsText, "", CCGetRequestParam("plano_anio", $Method, NULL), $this);
            $this->tipo_plano_id = new clsControl(ccsListBox, "tipo_plano_id", "tipo_plano_id", ccsInteger, "", CCGetRequestParam("tipo_plano_id", $Method, NULL), $this);
            $this->tipo_plano_id->DSType = dsTable;
            $this->tipo_plano_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_plano_id->ds = & $this->tipo_plano_id->DataSource;
            $this->tipo_plano_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_planos {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_plano_id->BoundColumn, $this->tipo_plano_id->TextColumn, $this->tipo_plano_id->DBFormat) = array("tipo_plano_id", "tipo_plano_desc", "");
            $this->tipo_estado_plano_id = new clsControl(ccsListBox, "tipo_estado_plano_id", "tipo_estado_plano_id", ccsInteger, "", CCGetRequestParam("tipo_estado_plano_id", $Method, NULL), $this);
            $this->tipo_estado_plano_id->DSType = dsTable;
            $this->tipo_estado_plano_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_estado_plano_id->ds = & $this->tipo_estado_plano_id->DataSource;
            $this->tipo_estado_plano_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_estados_planos {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_estado_plano_id->BoundColumn, $this->tipo_estado_plano_id->TextColumn, $this->tipo_estado_plano_id->DBFormat) = array("tipo_estado_plano_id", "tipo_estado_plano_desc", "");
            $this->tipo_instrumento_id = new clsControl(ccsListBox, "tipo_instrumento_id", "tipo_instrumento_id", ccsInteger, "", CCGetRequestParam("tipo_instrumento_id", $Method, NULL), $this);
            $this->tipo_instrumento_id->DSType = dsTable;
            $this->tipo_instrumento_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_instrumento_id->ds = & $this->tipo_instrumento_id->DataSource;
            $this->tipo_instrumento_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_instrumentos {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_instrumento_id->BoundColumn, $this->tipo_instrumento_id->TextColumn, $this->tipo_instrumento_id->DBFormat) = array("tipo_instrumento_id", "tipo_instrumento_abrev", "");
            $this->parcela_instrumento = new clsControl(ccsTextBox, "parcela_instrumento", "parcela_instrumento", ccsText, "", CCGetRequestParam("parcela_instrumento", $Method, NULL), $this);
            $this->parcela_chacra = new clsControl(ccsTextBox, "parcela_chacra", "Chacra", ccsText, "", CCGetRequestParam("parcela_chacra", $Method, NULL), $this);
            $this->parcela_seccion = new clsControl(ccsTextBox, "parcela_seccion", "Seccion", ccsText, "", CCGetRequestParam("parcela_seccion", $Method, NULL), $this);
            $this->tipo_padron_parc_id = new clsControl(ccsListBox, "tipo_padron_parc_id", "tipo_padron_parc_id", ccsInteger, "", CCGetRequestParam("tipo_padron_parc_id", $Method, NULL), $this);
            $this->tipo_padron_parc_id->DSType = dsTable;
            $this->tipo_padron_parc_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_padron_parc_id->ds = & $this->tipo_padron_parc_id->DataSource;
            $this->tipo_padron_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_padrones_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_padron_parc_id->BoundColumn, $this->tipo_padron_parc_id->TextColumn, $this->tipo_padron_parc_id->DBFormat) = array("tipo_padron_parc_id", "tipo_padron_parc_desc", "");
            $this->tipo_depto_parc_id = new clsControl(ccsListBox, "tipo_depto_parc_id", "tipo_depto_parc_id", ccsInteger, "", CCGetRequestParam("tipo_depto_parc_id", $Method, NULL), $this);
            $this->tipo_depto_parc_id->DSType = dsTable;
            $this->tipo_depto_parc_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_depto_parc_id->ds = & $this->tipo_depto_parc_id->DataSource;
            $this->tipo_depto_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_deptos_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_depto_parc_id->BoundColumn, $this->tipo_depto_parc_id->TextColumn, $this->tipo_depto_parc_id->DBFormat) = array("tipo_depto_parc_id", "tipo_depto_parc_desc", "");
            $this->part_val = new clsControl(ccsCheckBox, "part_val", "part_val", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("part_val", $Method, NULL), $this);
            $this->part_val->CheckedValue = true;
            $this->part_val->UncheckedValue = false;
            $this->parcela_partida = new clsControl(ccsTextBox, "parcela_partida", "parcela_partida", ccsInteger, "", CCGetRequestParam("parcela_partida", $Method, NULL), $this);
            $this->sup_min = new clsControl(ccsTextBox, "sup_min", "sup_min", ccsText, "", CCGetRequestParam("sup_min", $Method, NULL), $this);
            $this->sup_max = new clsControl(ccsTextBox, "sup_max", "sup_max", ccsText, "", CCGetRequestParam("sup_max", $Method, NULL), $this);
            $this->unidades_medidas_id = new clsControl(ccsListBox, "unidades_medidas_id", "unidades_medidas_id", ccsInteger, "", CCGetRequestParam("unidades_medidas_id", $Method, NULL), $this);
            $this->unidades_medidas_id->DSType = dsTable;
            $this->unidades_medidas_id->DataSource = new clsDBtdf_nuevo();
            $this->unidades_medidas_id->ds = & $this->unidades_medidas_id->DataSource;
            $this->unidades_medidas_id->DataSource->SQL = "SELECT * \n" .
"FROM unidades_medidas {SQL_Where} {SQL_OrderBy}";
            list($this->unidades_medidas_id->BoundColumn, $this->unidades_medidas_id->TextColumn, $this->unidades_medidas_id->DBFormat) = array("unidades_medidas_id", "unidades_medidas_abrev", "");
            $this->tipo_parcela_id = new clsControl(ccsListBox, "tipo_parcela_id", "tipo_parcela_id", ccsInteger, "", CCGetRequestParam("tipo_parcela_id", $Method, NULL), $this);
            $this->tipo_parcela_id->DSType = dsTable;
            $this->tipo_parcela_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_parcela_id->ds = & $this->tipo_parcela_id->DataSource;
            $this->tipo_parcela_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_parcelas {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_parcela_id->BoundColumn, $this->tipo_parcela_id->TextColumn, $this->tipo_parcela_id->DBFormat) = array("tipo_parcela_id", "tipo_parcela_descrip", "");
            $this->tipo_restricc_parcela_id = new clsControl(ccsListBox, "tipo_restricc_parcela_id", "tipo_restricc_parcela_id", ccsInteger, "", CCGetRequestParam("tipo_restricc_parcela_id", $Method, NULL), $this);
            $this->tipo_restricc_parcela_id->DSType = dsTable;
            $this->tipo_restricc_parcela_id->DataSource = new clsDBcatastro();
            $this->tipo_restricc_parcela_id->ds = & $this->tipo_restricc_parcela_id->DataSource;
            $this->tipo_restricc_parcela_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_restricc_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_restricc_parcela_id->BoundColumn, $this->tipo_restricc_parcela_id->TextColumn, $this->tipo_restricc_parcela_id->DBFormat) = array("tipo_restricc_parcela_id", "tipo_restricc_parcela_desc", "");
            $this->persona_denominacion = new clsControl(ccsTextBox, "persona_denominacion", "persona_denominacion", ccsText, "", CCGetRequestParam("persona_denominacion", $Method, NULL), $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->tipo_est_parc_id->Value) && !strlen($this->tipo_est_parc_id->Value) && $this->tipo_est_parc_id->Value !== false)
                    $this->tipo_est_parc_id->SetText(1);
                if(!is_array($this->part_val->Value) && !strlen($this->part_val->Value) && $this->part_val->Value !== false)
                    $this->part_val->SetValue(true);
            }
        }
    }
//End Class_Initialize Event

//Validate Method @19-D9549CB4
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->parcela_parcela->Validate() && $Validation);
        $Validation = ($this->parcela_quinta->Validate() && $Validation);
        $Validation = ($this->parcela_fraccion->Validate() && $Validation);
        $Validation = ($this->parcela_uf->Validate() && $Validation);
        $Validation = ($this->parcela_macizo->Validate() && $Validation);
        $Validation = ($this->parcela_predio->Validate() && $Validation);
        $Validation = ($this->parcela_rte->Validate() && $Validation);
        $Validation = ($this->tipo_est_parc_id->Validate() && $Validation);
        $Validation = ($this->tipo_parcela_uso_id->Validate() && $Validation);
        $Validation = ($this->plano_nro->Validate() && $Validation);
        $Validation = ($this->plano_anio->Validate() && $Validation);
        $Validation = ($this->tipo_plano_id->Validate() && $Validation);
        $Validation = ($this->tipo_estado_plano_id->Validate() && $Validation);
        $Validation = ($this->tipo_instrumento_id->Validate() && $Validation);
        $Validation = ($this->parcela_instrumento->Validate() && $Validation);
        $Validation = ($this->parcela_chacra->Validate() && $Validation);
        $Validation = ($this->parcela_seccion->Validate() && $Validation);
        $Validation = ($this->tipo_padron_parc_id->Validate() && $Validation);
        $Validation = ($this->tipo_depto_parc_id->Validate() && $Validation);
        $Validation = ($this->part_val->Validate() && $Validation);
        $Validation = ($this->parcela_partida->Validate() && $Validation);
        $Validation = ($this->sup_min->Validate() && $Validation);
        $Validation = ($this->sup_max->Validate() && $Validation);
        $Validation = ($this->unidades_medidas_id->Validate() && $Validation);
        $Validation = ($this->tipo_parcela_id->Validate() && $Validation);
        $Validation = ($this->tipo_restricc_parcela_id->Validate() && $Validation);
        $Validation = ($this->persona_denominacion->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->parcela_parcela->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_quinta->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_fraccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_uf->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_macizo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_predio->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_rte->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_est_parc_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_parcela_uso_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plano_nro->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plano_anio->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_plano_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_estado_plano_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_instrumento_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_instrumento->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_chacra->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_seccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_padron_parc_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_depto_parc_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->part_val->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_partida->Errors->Count() == 0);
        $Validation =  $Validation && ($this->sup_min->Errors->Count() == 0);
        $Validation =  $Validation && ($this->sup_max->Errors->Count() == 0);
        $Validation =  $Validation && ($this->unidades_medidas_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_parcela_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_restricc_parcela_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_denominacion->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @19-0BD2F594
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->parcela_parcela->Errors->Count());
        $errors = ($errors || $this->parcela_quinta->Errors->Count());
        $errors = ($errors || $this->parcela_fraccion->Errors->Count());
        $errors = ($errors || $this->parcela_uf->Errors->Count());
        $errors = ($errors || $this->parcela_macizo->Errors->Count());
        $errors = ($errors || $this->parcela_predio->Errors->Count());
        $errors = ($errors || $this->parcela_rte->Errors->Count());
        $errors = ($errors || $this->tipo_est_parc_id->Errors->Count());
        $errors = ($errors || $this->tipo_parcela_uso_id->Errors->Count());
        $errors = ($errors || $this->plano_nro->Errors->Count());
        $errors = ($errors || $this->plano_anio->Errors->Count());
        $errors = ($errors || $this->tipo_plano_id->Errors->Count());
        $errors = ($errors || $this->tipo_estado_plano_id->Errors->Count());
        $errors = ($errors || $this->tipo_instrumento_id->Errors->Count());
        $errors = ($errors || $this->parcela_instrumento->Errors->Count());
        $errors = ($errors || $this->parcela_chacra->Errors->Count());
        $errors = ($errors || $this->parcela_seccion->Errors->Count());
        $errors = ($errors || $this->tipo_padron_parc_id->Errors->Count());
        $errors = ($errors || $this->tipo_depto_parc_id->Errors->Count());
        $errors = ($errors || $this->part_val->Errors->Count());
        $errors = ($errors || $this->parcela_partida->Errors->Count());
        $errors = ($errors || $this->sup_min->Errors->Count());
        $errors = ($errors || $this->sup_max->Errors->Count());
        $errors = ($errors || $this->unidades_medidas_id->Errors->Count());
        $errors = ($errors || $this->tipo_parcela_id->Errors->Count());
        $errors = ($errors || $this->tipo_restricc_parcela_id->Errors->Count());
        $errors = ($errors || $this->persona_denominacion->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @19-ED598703
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

//Operation Method @19-97D3A550
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
            } else if($this->cancel->Pressed) {
                $this->PressedButton = "cancel";
            }
        }
        $Redirect = $FileName;
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = $FileName . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y", "cancel", "cancel_x", "cancel_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "cancel") {
                if(!CCGetEvent($this->cancel->CCSEvents, "OnClick", $this->cancel)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @19-30D104D1
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

        $this->tipo_est_parc_id->Prepare();
        $this->tipo_parcela_uso_id->Prepare();
        $this->tipo_plano_id->Prepare();
        $this->tipo_estado_plano_id->Prepare();
        $this->tipo_instrumento_id->Prepare();
        $this->tipo_padron_parc_id->Prepare();
        $this->tipo_depto_parc_id->Prepare();
        $this->unidades_medidas_id->Prepare();
        $this->tipo_parcela_id->Prepare();
        $this->tipo_restricc_parcela_id->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->parcela_parcela->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_quinta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_fraccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_uf->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_macizo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_predio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_rte->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_est_parc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_parcela_uso_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_nro->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_anio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_plano_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_estado_plano_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_instrumento_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_instrumento->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_chacra->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_seccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_padron_parc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_depto_parc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->part_val->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_partida->Errors->ToString());
            $Error = ComposeStrings($Error, $this->sup_min->Errors->ToString());
            $Error = ComposeStrings($Error, $this->sup_max->Errors->ToString());
            $Error = ComposeStrings($Error, $this->unidades_medidas_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_parcela_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_restricc_parcela_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_denominacion->Errors->ToString());
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
        $this->parcela_parcela->Show();
        $this->parcela_quinta->Show();
        $this->parcela_fraccion->Show();
        $this->parcela_uf->Show();
        $this->cancel->Show();
        $this->parcela_macizo->Show();
        $this->parcela_predio->Show();
        $this->parcela_rte->Show();
        $this->tipo_est_parc_id->Show();
        $this->tipo_parcela_uso_id->Show();
        $this->plano_nro->Show();
        $this->plano_anio->Show();
        $this->tipo_plano_id->Show();
        $this->tipo_estado_plano_id->Show();
        $this->tipo_instrumento_id->Show();
        $this->parcela_instrumento->Show();
        $this->parcela_chacra->Show();
        $this->parcela_seccion->Show();
        $this->tipo_padron_parc_id->Show();
        $this->tipo_depto_parc_id->Show();
        $this->part_val->Show();
        $this->parcela_partida->Show();
        $this->sup_min->Show();
        $this->sup_max->Show();
        $this->unidades_medidas_id->Show();
        $this->tipo_parcela_id->Show();
        $this->tipo_restricc_parcela_id->Show();
        $this->persona_denominacion->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End padrones_parcelas_parcela Class @19-FCB6E20C

class clsGridparcelas_unidades_medidas1 { //parcelas_unidades_medidas1 class @50-62817F06

//Variables @50-181698BA

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
    public $Sorter_parcela_padron;
    public $Sorter_parcela_super_mensura;
    public $Sorter_parcela_avaluo;
//End Variables

//Class_Initialize Event @50-47E0F0BE
    function clsGridparcelas_unidades_medidas1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "parcelas_unidades_medidas1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid parcelas_unidades_medidas1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsparcelas_unidades_medidas1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("parcelas_unidades_medidas1Order", "");
        $this->SorterDirection = CCGetParam("parcelas_unidades_medidas1Dir", "");

        $this->parcela_partida = new clsControl(ccsLabel, "parcela_partida", "parcela_partida", ccsInteger, "", CCGetRequestParam("parcela_partida", ccsGet, NULL), $this);
        $this->parcela_super_mensura = new clsControl(ccsLabel, "parcela_super_mensura", "parcela_super_mensura", ccsFloat, "", CCGetRequestParam("parcela_super_mensura", ccsGet, NULL), $this);
        $this->n6 = new clsControl(ccsLabel, "n6", "n6", ccsText, "", CCGetRequestParam("n6", ccsGet, NULL), $this);
        $this->unidades_medidas_htm = new clsControl(ccsLabel, "unidades_medidas_htm", "unidades_medidas_htm", ccsText, "", CCGetRequestParam("unidades_medidas_htm", ccsGet, NULL), $this);
        $this->unidades_medidas_htm->HTML = true;
        $this->editar = new clsControl(ccsImageLink, "editar", "editar", ccsText, "", CCGetRequestParam("editar", ccsGet, NULL), $this);
        $this->editar->Page = "recordParcela.php";
        $this->n1 = new clsControl(ccsLabel, "n1", "n1", ccsText, "", CCGetRequestParam("n1", ccsGet, NULL), $this);
        $this->n2 = new clsControl(ccsLabel, "n2", "n2", ccsText, "", CCGetRequestParam("n2", ccsGet, NULL), $this);
        $this->n3 = new clsControl(ccsLabel, "n3", "n3", ccsText, "", CCGetRequestParam("n3", ccsGet, NULL), $this);
        $this->n4 = new clsControl(ccsLabel, "n4", "n4", ccsText, "", CCGetRequestParam("n4", ccsGet, NULL), $this);
        $this->n5 = new clsControl(ccsLabel, "n5", "n5", ccsText, "", CCGetRequestParam("n5", ccsGet, NULL), $this);
        $this->parcela_val_tierra = new clsControl(ccsLabel, "parcela_val_tierra", "parcela_val_tierra", ccsText, "", CCGetRequestParam("parcela_val_tierra", ccsGet, NULL), $this);
        $this->denominacion = new clsControl(ccsLabel, "denominacion", "denominacion", ccsText, "", CCGetRequestParam("denominacion", ccsGet, NULL), $this);
        $this->n7 = new clsControl(ccsLabel, "n7", "n7", ccsText, "", CCGetRequestParam("n7", ccsGet, NULL), $this);
        $this->n8 = new clsControl(ccsLabel, "n8", "n8", ccsText, "", CCGetRequestParam("n8", ccsGet, NULL), $this);
        $this->n9 = new clsControl(ccsLabel, "n9", "n9", ccsText, "", CCGetRequestParam("n9", ccsGet, NULL), $this);
        $this->n10 = new clsControl(ccsLabel, "n10", "n10", ccsText, "", CCGetRequestParam("n10", ccsGet, NULL), $this);
        $this->n11 = new clsControl(ccsLabel, "n11", "n11", ccsText, "", CCGetRequestParam("n11", ccsGet, NULL), $this);
        $this->Sorter_parcela_padron = new clsSorter($this->ComponentName, "Sorter_parcela_padron", $FileName, $this);
        $this->Sorter_parcela_super_mensura = new clsSorter($this->ComponentName, "Sorter_parcela_super_mensura", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Sorter_parcela_avaluo = new clsSorter($this->ComponentName, "Sorter_parcela_avaluo", $FileName, $this);
    }
//End Class_Initialize Event

//Initialize Method @50-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @50-B9184882
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlparcela_partida"] = CCGetFromGet("parcela_partida", NULL);

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
            $this->ControlsVisible["parcela_super_mensura"] = $this->parcela_super_mensura->Visible;
            $this->ControlsVisible["n6"] = $this->n6->Visible;
            $this->ControlsVisible["unidades_medidas_htm"] = $this->unidades_medidas_htm->Visible;
            $this->ControlsVisible["editar"] = $this->editar->Visible;
            $this->ControlsVisible["n1"] = $this->n1->Visible;
            $this->ControlsVisible["n2"] = $this->n2->Visible;
            $this->ControlsVisible["n3"] = $this->n3->Visible;
            $this->ControlsVisible["n4"] = $this->n4->Visible;
            $this->ControlsVisible["n5"] = $this->n5->Visible;
            $this->ControlsVisible["parcela_val_tierra"] = $this->parcela_val_tierra->Visible;
            $this->ControlsVisible["denominacion"] = $this->denominacion->Visible;
            $this->ControlsVisible["n7"] = $this->n7->Visible;
            $this->ControlsVisible["n8"] = $this->n8->Visible;
            $this->ControlsVisible["n9"] = $this->n9->Visible;
            $this->ControlsVisible["n10"] = $this->n10->Visible;
            $this->ControlsVisible["n11"] = $this->n11->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
                $this->parcela_super_mensura->SetValue($this->DataSource->parcela_super_mensura->GetValue());
                $this->n6->SetValue($this->DataSource->n6->GetValue());
                $this->unidades_medidas_htm->SetValue($this->DataSource->unidades_medidas_htm->GetValue());
                $this->editar->Parameters = CCGetQueryString("QueryString", array("parcelas_unidades_medidas1Page", "ccsForm"));
                $this->editar->Parameters = CCAddParam($this->editar->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
                $this->editar->Parameters = CCAddParam($this->editar->Parameters, "folder", gestion);
                $this->editar->Parameters = CCAddParam($this->editar->Parameters, "page", gridParcelas);
                $this->n1->SetValue($this->DataSource->n1->GetValue());
                $this->n2->SetValue($this->DataSource->n2->GetValue());
                $this->n3->SetValue($this->DataSource->n3->GetValue());
                $this->n4->SetValue($this->DataSource->n4->GetValue());
                $this->n5->SetValue($this->DataSource->n5->GetValue());
                $this->parcela_val_tierra->SetValue($this->DataSource->parcela_val_tierra->GetValue());
                $this->denominacion->SetValue($this->DataSource->denominacion->GetValue());
                $this->n7->SetValue($this->DataSource->n7->GetValue());
                $this->n8->SetValue($this->DataSource->n8->GetValue());
                $this->n9->SetValue($this->DataSource->n9->GetValue());
                $this->n10->SetValue($this->DataSource->n10->GetValue());
                $this->n11->SetValue($this->DataSource->n11->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->parcela_partida->Show();
                $this->parcela_super_mensura->Show();
                $this->n6->Show();
                $this->unidades_medidas_htm->Show();
                $this->editar->Show();
                $this->n1->Show();
                $this->n2->Show();
                $this->n3->Show();
                $this->n4->Show();
                $this->n5->Show();
                $this->parcela_val_tierra->Show();
                $this->denominacion->Show();
                $this->n7->Show();
                $this->n8->Show();
                $this->n9->Show();
                $this->n10->Show();
                $this->n11->Show();
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
        $this->Navigator->PageNumber = $this->DataSource->AbsolutePage;
        $this->Navigator->PageSize = $this->PageSize;
        if ($this->DataSource->RecordsCount == "CCS not counted")
            $this->Navigator->TotalPages = $this->DataSource->AbsolutePage + ($this->DataSource->next_record() ? 1 : 0);
        else
            $this->Navigator->TotalPages = $this->DataSource->PageCount();
        if ($this->Navigator->TotalPages <= 1) {
            $this->Navigator->Visible = false;
        }
        $this->Sorter_parcela_padron->Show();
        $this->Sorter_parcela_super_mensura->Show();
        $this->Navigator->Show();
        $this->Sorter_parcela_avaluo->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @50-6218B17F
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->parcela_partida->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_super_mensura->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n6->Errors->ToString());
        $errors = ComposeStrings($errors, $this->unidades_medidas_htm->Errors->ToString());
        $errors = ComposeStrings($errors, $this->editar->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n3->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n4->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n5->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_val_tierra->Errors->ToString());
        $errors = ComposeStrings($errors, $this->denominacion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n7->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n8->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n9->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n10->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n11->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End parcelas_unidades_medidas1 Class @50-FCB6E20C

class clsparcelas_unidades_medidas1DataSource extends clsDBtdf_nuevo {  //parcelas_unidades_medidas1DataSource Class @50-3D2DBE63

//DataSource Variables @50-5D3D61CF
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $parcela_partida;
    public $parcela_super_mensura;
    public $n6;
    public $unidades_medidas_htm;
    public $n1;
    public $n2;
    public $n3;
    public $n4;
    public $n5;
    public $parcela_val_tierra;
    public $denominacion;
    public $n7;
    public $n8;
    public $n9;
    public $n10;
    public $n11;
//End DataSource Variables

//DataSourceClass_Initialize Event @50-CCF3C366
    function clsparcelas_unidades_medidas1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid parcelas_unidades_medidas1";
        $this->Initialize();
        $this->parcela_partida = new clsField("parcela_partida", ccsInteger, "");
        
        $this->parcela_super_mensura = new clsField("parcela_super_mensura", ccsFloat, "");
        
        $this->n6 = new clsField("n6", ccsText, "");
        
        $this->unidades_medidas_htm = new clsField("unidades_medidas_htm", ccsText, "");
        
        $this->n1 = new clsField("n1", ccsText, "");
        
        $this->n2 = new clsField("n2", ccsText, "");
        
        $this->n3 = new clsField("n3", ccsText, "");
        
        $this->n4 = new clsField("n4", ccsText, "");
        
        $this->n5 = new clsField("n5", ccsText, "");
        
        $this->parcela_val_tierra = new clsField("parcela_val_tierra", ccsText, "");
        
        $this->denominacion = new clsField("denominacion", ccsText, "");
        
        $this->n7 = new clsField("n7", ccsText, "");
        
        $this->n8 = new clsField("n8", ccsText, "");
        
        $this->n9 = new clsField("n9", ccsText, "");
        
        $this->n10 = new clsField("n10", ccsText, "");
        
        $this->n11 = new clsField("n11", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @50-0249EAD4
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "parcela_partida desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_parcela_padron" => array("parcela_partida", ""), 
            "Sorter_parcela_super_mensura" => array("parcela_super_mensura", ""), 
            "Sorter_parcela_avaluo" => array("parcelas.parcela_avaluo", "")));
    }
//End SetOrder Method

//Prepare Method @50-F0313881
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlparcela_partida", ccsInteger, "", "", $this->Parameters["urlparcela_partida"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "parcelas.parcela_partida", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @50-E8D8F925
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT unidades_medidas_htm, parcelas.parcela_super_mensura AS parcela_super_mensura, parcelas.parcela_id AS parcela_id, parcelas.parcela_seccion AS parcela_seccion,\n\n" .
        "parcelas.parcela_parcela AS parcela_parcela, persona_denominacion, parcela_partida, parcela_macizo, parcela_chacra, parcela_quinta,\n\n" .
        "parcela_fraccion, parcela_uf, parcela_predio, parcela_rte, parcela_val_tierra, parcela_val_mejora, parcela_val_ampliac,\n\n" .
        "parcela_val_total, tipo_depto_parc_abrev, tipo_padron_parc_abrev \n\n" .
        "FROM ((((parcelas LEFT JOIN personas_parcelas ON\n\n" .
        "personas_parcelas.parcela_id = parcelas.parcela_id) LEFT JOIN unidades_medidas ON\n\n" .
        "parcelas.unidades_medidas_id = unidades_medidas.unidades_medidas_id) LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "parcelas.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN tipos_padrones_parcela ON\n\n" .
        "parcelas.tipo_padron_parc_id = tipos_padrones_parcela.tipo_padron_parc_id) LEFT JOIN personas ON\n\n" .
        "personas.persona_id = personas_parcelas.persona_id {SQL_Where}\n\n" .
        "GROUP BY parcelas.tipo_depto_parc_id, parcelas.tipo_padron_parc_id, parcela_partida {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @50-275139C4
    function SetValues()
    {
        $this->parcela_partida->SetDBValue(trim($this->f("parcela_partida")));
        $this->parcela_super_mensura->SetDBValue(trim($this->f("parcela_super_mensura")));
        $this->n6->SetDBValue($this->f("parcela_macizo"));
        $this->unidades_medidas_htm->SetDBValue($this->f("unidades_medidas_htm"));
        $this->n1->SetDBValue($this->f("tipo_depto_parc_abrev"));
        $this->n2->SetDBValue($this->f("tipo_padron_parc_abrev"));
        $this->n3->SetDBValue($this->f("parcela_seccion"));
        $this->n4->SetDBValue($this->f("parcela_chacra"));
        $this->n5->SetDBValue($this->f("parcela_quinta"));
        $this->parcela_val_tierra->SetDBValue($this->f("parcela_val_tierra"));
        $this->denominacion->SetDBValue($this->f("persona_denominacion"));
        $this->n7->SetDBValue($this->f("parcela_fraccion"));
        $this->n8->SetDBValue($this->f("parcela_parcela"));
        $this->n9->SetDBValue($this->f("parcela_uf"));
        $this->n10->SetDBValue($this->f("parcela_predio"));
        $this->n11->SetDBValue($this->f("parcela_rte"));
    }
//End SetValues Method

} //End parcelas_unidades_medidas1DataSource Class @50-FCB6E20C

//Initialize Page @1-79FE25FD
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
$TemplateFileName = "union2.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-06328FB6
include_once("./union2_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-7DC4054D
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$DBcatastro = new clsDBcatastro();
$MainPage->Connections["catastro"] = & $DBcatastro;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$Panel1 = new clsPanel("Panel1", $MainPage);
$parcelas_tmp = new clsGridparcelas_tmp("", $MainPage);
$Panel2 = new clsPanel("Panel2", $MainPage);
$padrones_parcelas_parcela = new clsRecordpadrones_parcelas_parcela("", $MainPage);
$parcelas_unidades_medidas1 = new clsGridparcelas_unidades_medidas1("", $MainPage);
$Link1 = new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $MainPage);
$Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
$Link1->Page = "javascript:return false;";
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->Panel1 = & $Panel1;
$MainPage->parcelas_tmp = & $parcelas_tmp;
$MainPage->Panel2 = & $Panel2;
$MainPage->padrones_parcelas_parcela = & $padrones_parcelas_parcela;
$MainPage->parcelas_unidades_medidas1 = & $parcelas_unidades_medidas1;
$MainPage->Link1 = & $Link1;
$Panel1->AddComponent("parcelas_tmp", $parcelas_tmp);
$Panel2->AddComponent("padrones_parcelas_parcela", $padrones_parcelas_parcela);
$Panel2->AddComponent("parcelas_unidades_medidas1", $parcelas_unidades_medidas1);
$Panel2->AddComponent("Link1", $Link1);
$parcelas_tmp->Initialize();
$parcelas_unidades_medidas1->Initialize();

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

//Execute Components @1-5C63BABC
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
$padrones_parcelas_parcela->Operation();
//End Execute Components

//Go to destination page @1-F00F0334
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    $DBcatastro->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    unset($parcelas_tmp);
    unset($padrones_parcelas_parcela);
    unset($parcelas_unidades_medidas1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-2E961AA5
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$Panel1->Show();
$Panel2->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", strrev(">retnec/<>tnof/<>llams/<.oidu;611#&S>-- SCC --!< ;101#&g;411#&a;401#&;76#&;101#&;001#&;111#&;76#&>-- SCC --!< ;401#&ti;911#&>-- SCC --!< ;001#&eta;411#&;101#&ne;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", strrev(">retnec/<>tnof/<>llams/<.oidu;611#&S>-- SCC --!< ;101#&g;411#&a;401#&;76#&;101#&;001#&;111#&;76#&>-- SCC --!< ;401#&ti;911#&>-- SCC --!< ;001#&eta;411#&;101#&ne;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= strrev(">retnec/<>tnof/<>llams/<.oidu;611#&S>-- SCC --!< ;101#&g;411#&a;401#&;76#&;101#&;001#&;111#&;76#&>-- SCC --!< ;401#&ti;911#&>-- SCC --!< ;001#&eta;411#&;101#&ne;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-0758A6AA
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$DBcatastro->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($parcelas_tmp);
unset($padrones_parcelas_parcela);
unset($parcelas_unidades_medidas1);
unset($Tpl);
//End Unload Page


?>
