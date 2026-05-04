<?php
//Include Common Files @1-AC463BBA
define("RelativePath", "..");
define("PathToCurrentPage", "/previsado/");
define("FileName", "previsados_respuesta.php");
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

class clsGridprevisados_detalles_carga { //previsados_detalles_carga class @4-4B3AF373

//Variables @4-C13C8BA7

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
    public $Sorter_previsado_requisito_id;
    public $Sorter_previsado_detalle_carga_ubica;
//End Variables

//Class_Initialize Event @4-1742F09F
    function clsGridprevisados_detalles_carga($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "previsados_detalles_carga";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid previsados_detalles_carga";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsprevisados_detalles_cargaDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 100;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("previsados_detalles_cargaOrder", "");
        $this->SorterDirection = CCGetParam("previsados_detalles_cargaDir", "");

        $this->previsado_requisito_descrip = new clsControl(ccsLabel, "previsado_requisito_descrip", "previsado_requisito_descrip", ccsText, "", CCGetRequestParam("previsado_requisito_descrip", ccsGet, NULL), $this);
        $this->previsado_detalle_carga_ubica = new clsControl(ccsLabel, "previsado_detalle_carga_ubica", "previsado_detalle_carga_ubica", ccsText, "", CCGetRequestParam("previsado_detalle_carga_ubica", ccsGet, NULL), $this);
        $this->previsado_detalle_carga_ubica->HTML = true;
        $this->Sorter_previsado_requisito_id = new clsSorter($this->ComponentName, "Sorter_previsado_requisito_id", $FileName, $this);
        $this->Sorter_previsado_detalle_carga_ubica = new clsSorter($this->ComponentName, "Sorter_previsado_detalle_carga_ubica", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->previsado_titular = new clsControl(ccsLabel, "previsado_titular", "previsado_titular", ccsText, "", CCGetRequestParam("previsado_titular", ccsGet, NULL), $this);
        $this->previsado_titular->HTML = true;
        $this->profesional_nombre = new clsControl(ccsLabel, "profesional_nombre", "profesional_nombre", ccsText, "", CCGetRequestParam("profesional_nombre", ccsGet, NULL), $this);
        $this->profesional_nombre->HTML = true;
        $this->tipo_plano = new clsControl(ccsLabel, "tipo_plano", "tipo_plano", ccsText, "", CCGetRequestParam("tipo_plano", ccsGet, NULL), $this);
        $this->tipo_plano->HTML = true;
        $this->fecha_carga = new clsControl(ccsLabel, "fecha_carga", "fecha_carga", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("fecha_carga", ccsGet, NULL), $this);
        $this->fecha_carga->HTML = true;
        $this->matricula = new clsControl(ccsLabel, "matricula", "matricula", ccsText, "", CCGetRequestParam("matricula", ccsGet, NULL), $this);
        $this->matricula->HTML = true;
        $this->cad = new clsControl(ccsLabel, "cad", "cad", ccsText, "", CCGetRequestParam("cad", ccsGet, NULL), $this);
        $this->cad->HTML = true;
        $this->nomenclatura_origen = new clsControl(ccsLabel, "nomenclatura_origen", "nomenclatura_origen", ccsText, "", CCGetRequestParam("nomenclatura_origen", ccsGet, NULL), $this);
        $this->nomenclatura_origen->HTML = true;
        $this->nomenclatura_destino = new clsControl(ccsLabel, "nomenclatura_destino", "nomenclatura_destino", ccsText, "", CCGetRequestParam("nomenclatura_destino", ccsGet, NULL), $this);
        $this->nomenclatura_destino->HTML = true;
        $this->nomenclatura_afectacion = new clsControl(ccsLabel, "nomenclatura_afectacion", "nomenclatura_afectacion", ccsText, "", CCGetRequestParam("nomenclatura_afectacion", ccsGet, NULL), $this);
        $this->nomenclatura_afectacion->HTML = true;
    }
//End Class_Initialize Event

//Initialize Method @4-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @4-0C643212
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlprevisado_carga_id"] = CCGetFromGet("previsado_carga_id", NULL);

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
            $this->ControlsVisible["previsado_requisito_descrip"] = $this->previsado_requisito_descrip->Visible;
            $this->ControlsVisible["previsado_detalle_carga_ubica"] = $this->previsado_detalle_carga_ubica->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->previsado_requisito_descrip->SetValue($this->DataSource->previsado_requisito_descrip->GetValue());
                $this->previsado_detalle_carga_ubica->SetValue($this->DataSource->previsado_detalle_carga_ubica->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->previsado_requisito_descrip->Show();
                $this->previsado_detalle_carga_ubica->Show();
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
        $this->Sorter_previsado_requisito_id->Show();
        $this->Sorter_previsado_detalle_carga_ubica->Show();
        $this->Navigator->Show();
        $this->previsado_titular->Show();
        $this->profesional_nombre->Show();
        $this->tipo_plano->Show();
        $this->fecha_carga->Show();
        $this->matricula->Show();
        $this->cad->Show();
        $this->nomenclatura_origen->Show();
        $this->nomenclatura_destino->Show();
        $this->nomenclatura_afectacion->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @4-F6A55024
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->previsado_requisito_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->previsado_detalle_carga_ubica->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End previsados_detalles_carga Class @4-FCB6E20C

class clsprevisados_detalles_cargaDataSource extends clsDBtdf_nuevo {  //previsados_detalles_cargaDataSource Class @4-386C5D7E

//DataSource Variables @4-25B591EA
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $previsado_requisito_descrip;
    public $previsado_detalle_carga_ubica;
//End DataSource Variables

//DataSourceClass_Initialize Event @4-B2DE6326
    function clsprevisados_detalles_cargaDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid previsados_detalles_carga";
        $this->Initialize();
        $this->previsado_requisito_descrip = new clsField("previsado_requisito_descrip", ccsText, "");
        
        $this->previsado_detalle_carga_ubica = new clsField("previsado_detalle_carga_ubica", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @4-C46D8526
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "previsados_detalles_cargas.previsado_requisito_id";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_previsado_requisito_id" => array("previsado_requisito_id", ""), 
            "Sorter_previsado_detalle_carga_ubica" => array("previsado_detalle_carga_ubica", "")));
    }
//End SetOrder Method

//Prepare Method @4-9AD70429
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlprevisado_carga_id", ccsInteger, "", "", $this->Parameters["urlprevisado_carga_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "previsados_detalles_cargas.previsado_carga_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @4-2DEC40A3
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT previsados_detalles_cargas.*, previsado_requisito_descrip \n\n" .
        "FROM previsados_detalles_cargas LEFT JOIN previsados_tipos_planos_requisitos ON\n\n" .
        "previsados_detalles_cargas.previsado_requisito_id = previsados_tipos_planos_requisitos.previsado_requisito_id {SQL_Where}\n\n" .
        "GROUP BY previsado_detalle_carga_id {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @4-91BBCD0F
    function SetValues()
    {
        $this->previsado_requisito_descrip->SetDBValue($this->f("previsado_requisito_descrip"));
        $this->previsado_detalle_carga_ubica->SetDBValue($this->f("previsado_detalle_nombre_arch_org"));
    }
//End SetValues Method

} //End previsados_detalles_cargaDataSource Class @4-FCB6E20C

class clsRecordrespuesta { //respuesta Class @12-381A5420

//Variables @12-9E315808

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

//Class_Initialize Event @12-8820BA2E
    function clsRecordrespuesta($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record respuesta/Error";
        $this->DataSource = new clsrespuestaDataSource($this);
        $this->ds = & $this->DataSource;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "respuesta";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "multipart/form-data";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->observaciones = new clsControl(ccsTextArea, "observaciones", "observaciones", ccsText, "", CCGetRequestParam("observaciones", $Method, NULL), $this);
            $this->previsado_tipo_verif_id = new clsControl(ccsCheckBoxList, "previsado_tipo_verif_id", "previsado_tipo_verif_id", ccsInteger, "", CCGetRequestParam("previsado_tipo_verif_id", $Method, NULL), $this);
            $this->previsado_tipo_verif_id->Multiple = true;
            $this->previsado_tipo_verif_id->DSType = dsTable;
            $this->previsado_tipo_verif_id->DataSource = new clsDBtdf_nuevo();
            $this->previsado_tipo_verif_id->ds = & $this->previsado_tipo_verif_id->DataSource;
            $this->previsado_tipo_verif_id->DataSource->SQL = "SELECT previsado_tipo_verif_id, previsado_tipo_verif_descrip, previsado_tipo_verif_orden, tipo_estado_id, CONCAT(previsado_tipo_verif_orden,' - ',previsado_tipo_verif_descrip) AS descripcion \n" .
"FROM previsados_tipos_verificaciones {SQL_Where} {SQL_OrderBy}";
            $this->previsado_tipo_verif_id->DataSource->Order = "previsado_tipo_verif_orden";
            list($this->previsado_tipo_verif_id->BoundColumn, $this->previsado_tipo_verif_id->TextColumn, $this->previsado_tipo_verif_id->DBFormat) = array("previsado_tipo_verif_id", "descripcion", "");
            $this->previsado_tipo_verif_id->DataSource->Parameters["expr37"] = 1;
            $this->previsado_tipo_verif_id->DataSource->wp = new clsSQLParameters();
            $this->previsado_tipo_verif_id->DataSource->wp->AddParameter("1", "expr37", ccsInteger, "", "", $this->previsado_tipo_verif_id->DataSource->Parameters["expr37"], "", false);
            $this->previsado_tipo_verif_id->DataSource->wp->Criterion[1] = $this->previsado_tipo_verif_id->DataSource->wp->Operation(opEqual, "tipo_estado_id", $this->previsado_tipo_verif_id->DataSource->wp->GetDBValue("1"), $this->previsado_tipo_verif_id->DataSource->ToSQL($this->previsado_tipo_verif_id->DataSource->wp->GetDBValue("1"), ccsInteger),false);
            $this->previsado_tipo_verif_id->DataSource->Where = 
                 $this->previsado_tipo_verif_id->DataSource->wp->Criterion[1];
            $this->previsado_tipo_verif_id->DataSource->Order = "previsado_tipo_verif_orden";
            $this->previsado_tipo_verif_id->HTML = true;
            $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
            $this->Button_cancelar = new clsButton("Button_cancelar", $Method, $this);
            $this->previsado_tipo_estado_carga_id = new clsControl(ccsListBox, "previsado_tipo_estado_carga_id", "Respuesta", ccsInteger, "", CCGetRequestParam("previsado_tipo_estado_carga_id", $Method, NULL), $this);
            $this->previsado_tipo_estado_carga_id->DSType = dsTable;
            $this->previsado_tipo_estado_carga_id->DataSource = new clsDBtdf_nuevo();
            $this->previsado_tipo_estado_carga_id->ds = & $this->previsado_tipo_estado_carga_id->DataSource;
            $this->previsado_tipo_estado_carga_id->DataSource->SQL = "SELECT * \n" .
"FROM (previsados_tipos_estados_relaciones INNER JOIN previsados_cargas ON\n" .
"previsados_cargas.previsado_tipo_estado_carga_id = previsados_tipos_estados_relaciones.previsado_tipo_estado_carga_id) LEFT JOIN previsados_tipos_estados_cargas ON\n" .
"previsados_tipos_estados_relaciones.previsado_tipo_estado_carga_visible_id = previsados_tipos_estados_cargas.previsado_tipo_estado_carga_id {SQL_Where} {SQL_OrderBy}";
            $this->previsado_tipo_estado_carga_id->DataSource->Order = "previsado_tipo_estado_carga_orden";
            list($this->previsado_tipo_estado_carga_id->BoundColumn, $this->previsado_tipo_estado_carga_id->TextColumn, $this->previsado_tipo_estado_carga_id->DBFormat) = array("previsado_tipo_estado_carga_visible_id", "previsado_tipo_estado_carga_descrip", "");
            $this->previsado_tipo_estado_carga_id->DataSource->Parameters["urlprevisado_carga_id"] = CCGetFromGet("previsado_carga_id", NULL);
            $this->previsado_tipo_estado_carga_id->DataSource->wp = new clsSQLParameters();
            $this->previsado_tipo_estado_carga_id->DataSource->wp->AddParameter("1", "urlprevisado_carga_id", ccsInteger, "", "", $this->previsado_tipo_estado_carga_id->DataSource->Parameters["urlprevisado_carga_id"], "", false);
            $this->previsado_tipo_estado_carga_id->DataSource->wp->Criterion[1] = $this->previsado_tipo_estado_carga_id->DataSource->wp->Operation(opEqual, "previsados_cargas.previsado_carga_id", $this->previsado_tipo_estado_carga_id->DataSource->wp->GetDBValue("1"), $this->previsado_tipo_estado_carga_id->DataSource->ToSQL($this->previsado_tipo_estado_carga_id->DataSource->wp->GetDBValue("1"), ccsInteger),false);
            $this->previsado_tipo_estado_carga_id->DataSource->Where = 
                 $this->previsado_tipo_estado_carga_id->DataSource->wp->Criterion[1];
            $this->previsado_tipo_estado_carga_id->DataSource->Order = "previsado_tipo_estado_carga_orden";
            $this->nombre = new clsControl(ccsLabel, "nombre", "nombre", ccsText, "", CCGetRequestParam("nombre", $Method, NULL), $this);
            $this->Button1 = new clsButton("Button1", $Method, $this);
            $this->previsado_respuesta_nota = new clsControl(ccsTextArea, "previsado_respuesta_nota", "previsado_respuesta_nota", ccsText, "", CCGetRequestParam("previsado_respuesta_nota", $Method, NULL), $this);
            $this->contestacion = new clsControl(ccsLabel, "contestacion", "contestacion", ccsText, "", CCGetRequestParam("contestacion", $Method, NULL), $this);
            $this->contestacion->HTML = true;
            $this->cantidad = new clsControl(ccsHidden, "cantidad", "cantidad", ccsText, "", CCGetRequestParam("cantidad", $Method, NULL), $this);
            $this->aviso = new clsControl(ccsLabel, "aviso", "aviso", ccsText, "", CCGetRequestParam("aviso", $Method, NULL), $this);
            $this->aviso->HTML = true;
            $this->archivo_carga = new clsFileUpload("archivo_carga", "ARCHIVO PDF", "../tmp/", "archivos_observaciones/", "*.pdf", "", 5242880, $this);
            $this->caratula = new clsControl(ccsHidden, "caratula", "caratula", ccsText, "", CCGetRequestParam("caratula", $Method, NULL), $this);
            $this->fecha_caratula = new clsControl(ccsHidden, "fecha_caratula", "fecha_caratula", ccsText, "", CCGetRequestParam("fecha_caratula", $Method, NULL), $this);
            $this->plazo_tiempo = new clsControl(ccsTextBox, "plazo_tiempo", "plazo_tiempo", ccsText, "", CCGetRequestParam("plazo_tiempo", $Method, NULL), $this);
            $this->previsado_plazo_entrega_id = new clsControl(ccsListBox, "previsado_plazo_entrega_id", "previsado_plazo_entrega_id", ccsInteger, "", CCGetRequestParam("previsado_plazo_entrega_id", $Method, NULL), $this);
            $this->previsado_plazo_entrega_id->DSType = dsTable;
            $this->previsado_plazo_entrega_id->DataSource = new clsDBtdf_nuevo();
            $this->previsado_plazo_entrega_id->ds = & $this->previsado_plazo_entrega_id->DataSource;
            $this->previsado_plazo_entrega_id->DataSource->SQL = "SELECT * \n" .
"FROM previsados_plazos_entregas {SQL_Where} {SQL_OrderBy}";
            list($this->previsado_plazo_entrega_id->BoundColumn, $this->previsado_plazo_entrega_id->TextColumn, $this->previsado_plazo_entrega_id->DBFormat) = array("previsado_plazo_entrega_id", "previsado_plazo_entrega_descrip", "");
            $this->Panel1 = new clsPanel("Panel1", $this);
            $this->tipo_depto_parc_id = new clsControl(ccsTextBox, "tipo_depto_parc_id", "tipo_depto_parc_id", ccsText, "", CCGetRequestParam("tipo_depto_parc_id", $Method, NULL), $this);
            $this->previsado_respuesta_nro_plano = new clsControl(ccsTextBox, "previsado_respuesta_nro_plano", "previsado_respuesta_nro_plano", ccsText, "", CCGetRequestParam("previsado_respuesta_nro_plano", $Method, NULL), $this);
            $this->previsado_respuesta_nro_anio = new clsControl(ccsTextBox, "previsado_respuesta_nro_anio", "previsado_respuesta_nro_anio", ccsText, "", CCGetRequestParam("previsado_respuesta_nro_anio", $Method, NULL), $this);
            $this->previsado_respuesta_exp_nro = new clsControl(ccsTextBox, "previsado_respuesta_exp_nro", "previsado_respuesta_exp_nro", ccsText, "", CCGetRequestParam("previsado_respuesta_exp_nro", $Method, NULL), $this);
            $this->previsado_respuesta_exp_letra = new clsControl(ccsTextBox, "previsado_respuesta_exp_letra", "previsado_respuesta_exp_letra", ccsText, "", CCGetRequestParam("previsado_respuesta_exp_letra", $Method, NULL), $this);
            $this->previsado_respuesta_exp_anio = new clsControl(ccsTextBox, "previsado_respuesta_exp_anio", "previsado_respuesta_exp_anio", ccsText, "", CCGetRequestParam("previsado_respuesta_exp_anio", $Method, NULL), $this);
            $this->Panel1->Visible = false;
            $this->Panel1->AddComponent("tipo_depto_parc_id", $this->tipo_depto_parc_id);
            $this->Panel1->AddComponent("previsado_respuesta_nro_plano", $this->previsado_respuesta_nro_plano);
            $this->Panel1->AddComponent("previsado_respuesta_nro_anio", $this->previsado_respuesta_nro_anio);
            $this->Panel1->AddComponent("previsado_respuesta_exp_nro", $this->previsado_respuesta_exp_nro);
            $this->Panel1->AddComponent("previsado_respuesta_exp_letra", $this->previsado_respuesta_exp_letra);
            $this->Panel1->AddComponent("previsado_respuesta_exp_anio", $this->previsado_respuesta_exp_anio);
            if(!$this->FormSubmitted) {
                if(!is_array($this->previsado_tipo_estado_carga_id->Value) && !strlen($this->previsado_tipo_estado_carga_id->Value) && $this->previsado_tipo_estado_carga_id->Value !== false)
                    $this->previsado_tipo_estado_carga_id->SetText(3);
                if(!is_array($this->plazo_tiempo->Value) && !strlen($this->plazo_tiempo->Value) && $this->plazo_tiempo->Value !== false)
                    $this->plazo_tiempo->SetText(15);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @12-CBEB55AA
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlprevisado_carga_id"] = CCGetFromGet("previsado_carga_id", NULL);
    }
//End Initialize Method

//Validate Method @12-4EDD20E5
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->observaciones->Validate() && $Validation);
        $Validation = ($this->previsado_tipo_verif_id->Validate() && $Validation);
        $Validation = ($this->previsado_tipo_estado_carga_id->Validate() && $Validation);
        $Validation = ($this->previsado_respuesta_nota->Validate() && $Validation);
        $Validation = ($this->cantidad->Validate() && $Validation);
        $Validation = ($this->archivo_carga->Validate() && $Validation);
        $Validation = ($this->caratula->Validate() && $Validation);
        $Validation = ($this->fecha_caratula->Validate() && $Validation);
        $Validation = ($this->plazo_tiempo->Validate() && $Validation);
        $Validation = ($this->previsado_plazo_entrega_id->Validate() && $Validation);
        $Validation = ($this->tipo_depto_parc_id->Validate() && $Validation);
        $Validation = ($this->previsado_respuesta_nro_plano->Validate() && $Validation);
        $Validation = ($this->previsado_respuesta_nro_anio->Validate() && $Validation);
        $Validation = ($this->previsado_respuesta_exp_nro->Validate() && $Validation);
        $Validation = ($this->previsado_respuesta_exp_letra->Validate() && $Validation);
        $Validation = ($this->previsado_respuesta_exp_anio->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->observaciones->Errors->Count() == 0);
        $Validation =  $Validation && ($this->previsado_tipo_verif_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->previsado_tipo_estado_carga_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->previsado_respuesta_nota->Errors->Count() == 0);
        $Validation =  $Validation && ($this->cantidad->Errors->Count() == 0);
        $Validation =  $Validation && ($this->archivo_carga->Errors->Count() == 0);
        $Validation =  $Validation && ($this->caratula->Errors->Count() == 0);
        $Validation =  $Validation && ($this->fecha_caratula->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plazo_tiempo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->previsado_plazo_entrega_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_depto_parc_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->previsado_respuesta_nro_plano->Errors->Count() == 0);
        $Validation =  $Validation && ($this->previsado_respuesta_nro_anio->Errors->Count() == 0);
        $Validation =  $Validation && ($this->previsado_respuesta_exp_nro->Errors->Count() == 0);
        $Validation =  $Validation && ($this->previsado_respuesta_exp_letra->Errors->Count() == 0);
        $Validation =  $Validation && ($this->previsado_respuesta_exp_anio->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @12-3D18B903
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->observaciones->Errors->Count());
        $errors = ($errors || $this->previsado_tipo_verif_id->Errors->Count());
        $errors = ($errors || $this->previsado_tipo_estado_carga_id->Errors->Count());
        $errors = ($errors || $this->nombre->Errors->Count());
        $errors = ($errors || $this->previsado_respuesta_nota->Errors->Count());
        $errors = ($errors || $this->contestacion->Errors->Count());
        $errors = ($errors || $this->cantidad->Errors->Count());
        $errors = ($errors || $this->aviso->Errors->Count());
        $errors = ($errors || $this->archivo_carga->Errors->Count());
        $errors = ($errors || $this->caratula->Errors->Count());
        $errors = ($errors || $this->fecha_caratula->Errors->Count());
        $errors = ($errors || $this->plazo_tiempo->Errors->Count());
        $errors = ($errors || $this->previsado_plazo_entrega_id->Errors->Count());
        $errors = ($errors || $this->tipo_depto_parc_id->Errors->Count());
        $errors = ($errors || $this->previsado_respuesta_nro_plano->Errors->Count());
        $errors = ($errors || $this->previsado_respuesta_nro_anio->Errors->Count());
        $errors = ($errors || $this->previsado_respuesta_exp_nro->Errors->Count());
        $errors = ($errors || $this->previsado_respuesta_exp_letra->Errors->Count());
        $errors = ($errors || $this->previsado_respuesta_exp_anio->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @12-ED598703
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

//Operation Method @12-CD55F2D9
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

        $this->archivo_carga->Upload();

        if($this->FormSubmitted) {
            $this->PressedButton = "Button_Insert";
            if($this->Button_Insert->Pressed) {
                $this->PressedButton = "Button_Insert";
            } else if($this->Button_cancelar->Pressed) {
                $this->PressedButton = "Button_cancelar";
            } else if($this->Button1->Pressed) {
                $this->PressedButton = "Button1";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_cancelar") {
            $Redirect = "previsados_busqueda.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "previsado_carga_id"));
            if(!CCGetEvent($this->Button_cancelar->CCSEvents, "OnClick", $this->Button_cancelar)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button1") {
            if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Insert") {
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert)) {
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

//Show Method @12-506F9ADB
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

        $this->previsado_tipo_verif_id->Prepare();
        $this->previsado_tipo_estado_carga_id->Prepare();
        $this->previsado_plazo_entrega_id->Prepare();

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
            } else {
                $this->EditMode = false;
            }
        }
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->observaciones->Errors->ToString());
            $Error = ComposeStrings($Error, $this->previsado_tipo_verif_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->previsado_tipo_estado_carga_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->nombre->Errors->ToString());
            $Error = ComposeStrings($Error, $this->previsado_respuesta_nota->Errors->ToString());
            $Error = ComposeStrings($Error, $this->contestacion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->cantidad->Errors->ToString());
            $Error = ComposeStrings($Error, $this->aviso->Errors->ToString());
            $Error = ComposeStrings($Error, $this->archivo_carga->Errors->ToString());
            $Error = ComposeStrings($Error, $this->caratula->Errors->ToString());
            $Error = ComposeStrings($Error, $this->fecha_caratula->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plazo_tiempo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->previsado_plazo_entrega_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_depto_parc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->previsado_respuesta_nro_plano->Errors->ToString());
            $Error = ComposeStrings($Error, $this->previsado_respuesta_nro_anio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->previsado_respuesta_exp_nro->Errors->ToString());
            $Error = ComposeStrings($Error, $this->previsado_respuesta_exp_letra->Errors->ToString());
            $Error = ComposeStrings($Error, $this->previsado_respuesta_exp_anio->Errors->ToString());
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

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->observaciones->Show();
        $this->previsado_tipo_verif_id->Show();
        $this->Button_Insert->Show();
        $this->Button_cancelar->Show();
        $this->previsado_tipo_estado_carga_id->Show();
        $this->nombre->Show();
        $this->Button1->Show();
        $this->previsado_respuesta_nota->Show();
        $this->contestacion->Show();
        $this->cantidad->Show();
        $this->aviso->Show();
        $this->archivo_carga->Show();
        $this->caratula->Show();
        $this->fecha_caratula->Show();
        $this->plazo_tiempo->Show();
        $this->previsado_plazo_entrega_id->Show();
        $this->Panel1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End respuesta Class @12-FCB6E20C

class clsrespuestaDataSource extends clsDBtdf_nuevo {  //respuestaDataSource Class @12-F239093C

//DataSource Variables @12-4A37556C
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $wp;
    public $AllParametersSet;


    // Datasource fields
    public $observaciones;
    public $previsado_tipo_verif_id;
    public $previsado_tipo_estado_carga_id;
    public $nombre;
    public $previsado_respuesta_nota;
    public $contestacion;
    public $cantidad;
    public $aviso;
    public $archivo_carga;
    public $caratula;
    public $fecha_caratula;
    public $plazo_tiempo;
    public $previsado_plazo_entrega_id;
    public $tipo_depto_parc_id;
    public $previsado_respuesta_nro_plano;
    public $previsado_respuesta_nro_anio;
    public $previsado_respuesta_exp_nro;
    public $previsado_respuesta_exp_letra;
    public $previsado_respuesta_exp_anio;
//End DataSource Variables

//DataSourceClass_Initialize Event @12-F6FA6635
    function clsrespuestaDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record respuesta/Error";
        $this->Initialize();
        $this->observaciones = new clsField("observaciones", ccsText, "");
        
        $this->previsado_tipo_verif_id = new clsField("previsado_tipo_verif_id", ccsInteger, "");
        
        $this->previsado_tipo_estado_carga_id = new clsField("previsado_tipo_estado_carga_id", ccsInteger, "");
        
        $this->nombre = new clsField("nombre", ccsText, "");
        
        $this->previsado_respuesta_nota = new clsField("previsado_respuesta_nota", ccsText, "");
        
        $this->contestacion = new clsField("contestacion", ccsText, "");
        
        $this->cantidad = new clsField("cantidad", ccsText, "");
        
        $this->aviso = new clsField("aviso", ccsText, "");
        
        $this->archivo_carga = new clsField("archivo_carga", ccsText, "");
        
        $this->caratula = new clsField("caratula", ccsText, "");
        
        $this->fecha_caratula = new clsField("fecha_caratula", ccsText, "");
        
        $this->plazo_tiempo = new clsField("plazo_tiempo", ccsText, "");
        
        $this->previsado_plazo_entrega_id = new clsField("previsado_plazo_entrega_id", ccsInteger, "");
        
        $this->tipo_depto_parc_id = new clsField("tipo_depto_parc_id", ccsText, "");
        
        $this->previsado_respuesta_nro_plano = new clsField("previsado_respuesta_nro_plano", ccsText, "");
        
        $this->previsado_respuesta_nro_anio = new clsField("previsado_respuesta_nro_anio", ccsText, "");
        
        $this->previsado_respuesta_exp_nro = new clsField("previsado_respuesta_exp_nro", ccsText, "");
        
        $this->previsado_respuesta_exp_letra = new clsField("previsado_respuesta_exp_letra", ccsText, "");
        
        $this->previsado_respuesta_exp_anio = new clsField("previsado_respuesta_exp_anio", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//Prepare Method @12-CC194E27
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlprevisado_carga_id", ccsInteger, "", "", $this->Parameters["urlprevisado_carga_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "previsados_respuestas.previsado_carga_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @12-AF704905
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT previsados_respuestas.*, previsado_tipo_estado_carga_id \n\n" .
        "FROM previsados_respuestas INNER JOIN previsados_cargas ON\n\n" .
        "previsados_respuestas.previsado_carga_id = previsados_cargas.previsado_carga_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @12-BAF0975B
    function SetValues()
    {
    }
//End SetValues Method

} //End respuestaDataSource Class @12-FCB6E20C

//Include Page implementation @61-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Initialize Page @1-FABF90B7
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
$TemplateFileName = "previsados_respuesta.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-CBFD1E0E
CCSecurityRedirect("1;2", "../tdf_restricted.php");
//End Authenticate User

//Include events file @1-F1A36298
include_once("./previsados_respuesta_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-F8E06F04
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$previsados_detalles_carga = new clsGridprevisados_detalles_carga("", $MainPage);
$respuesta = new clsRecordrespuesta("", $MainPage);
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->previsados_detalles_carga = & $previsados_detalles_carga;
$MainPage->respuesta = & $respuesta;
$MainPage->tdf_menu = & $tdf_menu;
$previsados_detalles_carga->Initialize();
$respuesta->Initialize();

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

//Execute Components @1-CBDD634E
$tdf_header->Operations();
$tdf_footer->Operations();
$respuesta->Operation();
$tdf_menu->Operations();
//End Execute Components

//Go to destination page @1-1162D861
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($previsados_detalles_carga);
    unset($respuesta);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-A4C76E6E
$tdf_header->Show();
$tdf_footer->Show();
$previsados_detalles_carga->Show();
$respuesta->Show();
$tdf_menu->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font " . "face=\"Arial\">" . "<small>G&#101;" . "&#110;&#101;r&#" . "97;&#116;ed <!" . "-- SCC -->&#119;" . "&#105;t&#104; " . "<!-- SCC -->&#67" . ";o&#100;&#101;Ch" . "&#97;&#114;ge <" . "!-- CCS -->&#83;&#" . "116;&#117;d&#105" . ";o.</small></fon" . "t></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font " . "face=\"Arial\">" . "<small>G&#101;" . "&#110;&#101;r&#" . "97;&#116;ed <!" . "-- SCC -->&#119;" . "&#105;t&#104; " . "<!-- SCC -->&#67" . ";o&#100;&#101;Ch" . "&#97;&#114;ge <" . "!-- CCS -->&#83;&#" . "116;&#117;d&#105" . ";o.</small></fon" . "t></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font " . "face=\"Arial\">" . "<small>G&#101;" . "&#110;&#101;r&#" . "97;&#116;ed <!" . "-- SCC -->&#119;" . "&#105;t&#104; " . "<!-- SCC -->&#67" . ";o&#100;&#101;Ch" . "&#97;&#114;ge <" . "!-- CCS -->&#83;&#" . "116;&#117;d&#105" . ";o.</small></fon" . "t></center>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-D94FD88E
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($previsados_detalles_carga);
unset($respuesta);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($Tpl);
//End Unload Page


?>
