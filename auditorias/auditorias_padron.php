<?php
//Include Common Files @1-9353CE2F
define("RelativePath", "..");
define("PathToCurrentPage", "/auditorias/");
define("FileName", "auditorias_padron.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridauditorias_auditorias_tip1 { //auditorias_auditorias_tip1 class @2-159FD6FE

//Variables @2-40BC675D

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
    public $Sorter_auditoria_script;
    public $Sorter_auditoria_host;
    public $Sorter_auditoria_fecha;
    public $Sorter_auditoria_tabla;
    public $Sorter_auditoria_registro_id;
    public $Sorter_auditoria_descripcion;
    public $Sorter_aud_tip_abrev;
    public $Sorter_user_nombre;
    public $Sorter_user_nombre1;
//End Variables

//Class_Initialize Event @2-D53D25B6
    function clsGridauditorias_auditorias_tip1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "auditorias_auditorias_tip1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid auditorias_auditorias_tip1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsauditorias_auditorias_tip1DataSource($this);
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
        $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
        $this->SorterName = CCGetParam("auditorias_auditorias_tip1Order", "");
        $this->SorterDirection = CCGetParam("auditorias_auditorias_tip1Dir", "");

        $this->auditoria_script = new clsControl(ccsLabel, "auditoria_script", "auditoria_script", ccsText, "", CCGetRequestParam("auditoria_script", ccsGet, NULL), $this);
        $this->auditoria_host = new clsControl(ccsLabel, "auditoria_host", "auditoria_host", ccsText, "", CCGetRequestParam("auditoria_host", ccsGet, NULL), $this);
        $this->auditoria_fecha = new clsControl(ccsLabel, "auditoria_fecha", "auditoria_fecha", ccsDate, array("dd", "/", "mm", "/", "yyyy", " ", "h", ":", "nn", " ", "AM/PM"), CCGetRequestParam("auditoria_fecha", ccsGet, NULL), $this);
        $this->auditoria_tabla = new clsControl(ccsLabel, "auditoria_tabla", "auditoria_tabla", ccsText, "", CCGetRequestParam("auditoria_tabla", ccsGet, NULL), $this);
        $this->auditoria_registro_id = new clsControl(ccsLabel, "auditoria_registro_id", "auditoria_registro_id", ccsInteger, "", CCGetRequestParam("auditoria_registro_id", ccsGet, NULL), $this);
        $this->auditoria_descripcion = new clsControl(ccsLabel, "auditoria_descripcion", "auditoria_descripcion", ccsText, "", CCGetRequestParam("auditoria_descripcion", ccsGet, NULL), $this);
        $this->aud_tip_abrev = new clsControl(ccsLabel, "aud_tip_abrev", "aud_tip_abrev", ccsText, "", CCGetRequestParam("aud_tip_abrev", ccsGet, NULL), $this);
        $this->usuario_nombre = new clsControl(ccsLabel, "usuario_nombre", "usuario_nombre", ccsText, "", CCGetRequestParam("usuario_nombre", ccsGet, NULL), $this);
        $this->detalle = new clsPanel("detalle", $this);
        $this->det = new clsControl(ccsImageLink, "det", "det", ccsText, "", CCGetRequestParam("det", ccsGet, NULL), $this);
        $this->det->Page = "auditDetalle_padron.php";
        $this->parcela_partida = new clsControl(ccsLabel, "parcela_partida", "parcela_partida", ccsText, "", CCGetRequestParam("parcela_partida", ccsGet, NULL), $this);
        $this->auditorias_auditorias_tip1_TotalRecords = new clsControl(ccsLabel, "auditorias_auditorias_tip1_TotalRecords", "auditorias_auditorias_tip1_TotalRecords", ccsText, "", CCGetRequestParam("auditorias_auditorias_tip1_TotalRecords", ccsGet, NULL), $this);
        $this->Sorter_auditoria_script = new clsSorter($this->ComponentName, "Sorter_auditoria_script", $FileName, $this);
        $this->Sorter_auditoria_host = new clsSorter($this->ComponentName, "Sorter_auditoria_host", $FileName, $this);
        $this->Sorter_auditoria_fecha = new clsSorter($this->ComponentName, "Sorter_auditoria_fecha", $FileName, $this);
        $this->Sorter_auditoria_tabla = new clsSorter($this->ComponentName, "Sorter_auditoria_tabla", $FileName, $this);
        $this->Sorter_auditoria_registro_id = new clsSorter($this->ComponentName, "Sorter_auditoria_registro_id", $FileName, $this);
        $this->Sorter_auditoria_descripcion = new clsSorter($this->ComponentName, "Sorter_auditoria_descripcion", $FileName, $this);
        $this->Sorter_aud_tip_abrev = new clsSorter($this->ComponentName, "Sorter_aud_tip_abrev", $FileName, $this);
        $this->Sorter_user_nombre = new clsSorter($this->ComponentName, "Sorter_user_nombre", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Sorter_user_nombre1 = new clsSorter($this->ComponentName, "Sorter_user_nombre1", $FileName, $this);
        $this->detalle->AddComponent("det", $this->det);
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

//Show Method @2-1AC0B753
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["expr112"] = parcelas;
        $this->DataSource->Parameters["expr125"] = personas_parcelas;
        $this->DataSource->Parameters["urlparcela_partida"] = CCGetFromGet("parcela_partida", NULL);
        $this->DataSource->Parameters["urlf_desde"] = CCGetFromGet("f_desde", NULL);
        $this->DataSource->Parameters["urlf_hasta"] = CCGetFromGet("f_hasta", NULL);
        $this->DataSource->Parameters["expr138"] = 0;

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
            $this->ControlsVisible["auditoria_script"] = $this->auditoria_script->Visible;
            $this->ControlsVisible["auditoria_host"] = $this->auditoria_host->Visible;
            $this->ControlsVisible["auditoria_fecha"] = $this->auditoria_fecha->Visible;
            $this->ControlsVisible["auditoria_tabla"] = $this->auditoria_tabla->Visible;
            $this->ControlsVisible["auditoria_registro_id"] = $this->auditoria_registro_id->Visible;
            $this->ControlsVisible["auditoria_descripcion"] = $this->auditoria_descripcion->Visible;
            $this->ControlsVisible["aud_tip_abrev"] = $this->aud_tip_abrev->Visible;
            $this->ControlsVisible["usuario_nombre"] = $this->usuario_nombre->Visible;
            $this->ControlsVisible["detalle"] = $this->detalle->Visible;
            $this->ControlsVisible["det"] = $this->det->Visible;
            $this->ControlsVisible["parcela_partida"] = $this->parcela_partida->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->auditoria_script->SetValue($this->DataSource->auditoria_script->GetValue());
                $this->auditoria_host->SetValue($this->DataSource->auditoria_host->GetValue());
                $this->auditoria_fecha->SetValue($this->DataSource->auditoria_fecha->GetValue());
                $this->auditoria_tabla->SetValue($this->DataSource->auditoria_tabla->GetValue());
                $this->auditoria_registro_id->SetValue($this->DataSource->auditoria_registro_id->GetValue());
                $this->auditoria_descripcion->SetValue($this->DataSource->auditoria_descripcion->GetValue());
                $this->aud_tip_abrev->SetValue($this->DataSource->aud_tip_abrev->GetValue());
                $this->usuario_nombre->SetValue($this->DataSource->usuario_nombre->GetValue());
                $this->det->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->det->Parameters = CCAddParam($this->det->Parameters, "auditoria_id", $this->DataSource->f("auditoria_id"));
                $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->auditoria_script->Show();
                $this->auditoria_host->Show();
                $this->auditoria_fecha->Show();
                $this->auditoria_tabla->Show();
                $this->auditoria_registro_id->Show();
                $this->auditoria_descripcion->Show();
                $this->aud_tip_abrev->Show();
                $this->usuario_nombre->Show();
                $this->detalle->Show();
                $this->parcela_partida->Show();
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
        $this->auditorias_auditorias_tip1_TotalRecords->Show();
        $this->Sorter_auditoria_script->Show();
        $this->Sorter_auditoria_host->Show();
        $this->Sorter_auditoria_fecha->Show();
        $this->Sorter_auditoria_tabla->Show();
        $this->Sorter_auditoria_registro_id->Show();
        $this->Sorter_auditoria_descripcion->Show();
        $this->Sorter_aud_tip_abrev->Show();
        $this->Sorter_user_nombre->Show();
        $this->Navigator->Show();
        $this->Sorter_user_nombre1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @2-C79F3119
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->auditoria_script->Errors->ToString());
        $errors = ComposeStrings($errors, $this->auditoria_host->Errors->ToString());
        $errors = ComposeStrings($errors, $this->auditoria_fecha->Errors->ToString());
        $errors = ComposeStrings($errors, $this->auditoria_tabla->Errors->ToString());
        $errors = ComposeStrings($errors, $this->auditoria_registro_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->auditoria_descripcion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->aud_tip_abrev->Errors->ToString());
        $errors = ComposeStrings($errors, $this->usuario_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->det->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_partida->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End auditorias_auditorias_tip1 Class @2-FCB6E20C

class clsauditorias_auditorias_tip1DataSource extends clsDBtdf_nuevo {  //auditorias_auditorias_tip1DataSource Class @2-9B66171E

//DataSource Variables @2-7C4E2AC8
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $auditoria_script;
    public $auditoria_host;
    public $auditoria_fecha;
    public $auditoria_tabla;
    public $auditoria_registro_id;
    public $auditoria_descripcion;
    public $aud_tip_abrev;
    public $usuario_nombre;
    public $parcela_partida;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-BA5AAD3F
    function clsauditorias_auditorias_tip1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid auditorias_auditorias_tip1";
        $this->Initialize();
        $this->auditoria_script = new clsField("auditoria_script", ccsText, "");
        
        $this->auditoria_host = new clsField("auditoria_host", ccsText, "");
        
        $this->auditoria_fecha = new clsField("auditoria_fecha", ccsDate, $this->DateFormat);
        
        $this->auditoria_tabla = new clsField("auditoria_tabla", ccsText, "");
        
        $this->auditoria_registro_id = new clsField("auditoria_registro_id", ccsInteger, "");
        
        $this->auditoria_descripcion = new clsField("auditoria_descripcion", ccsText, "");
        
        $this->aud_tip_abrev = new clsField("aud_tip_abrev", ccsText, "");
        
        $this->usuario_nombre = new clsField("usuario_nombre", ccsText, "");
        
        $this->parcela_partida = new clsField("parcela_partida", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-8BDA749D
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "auditoria_fecha desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_auditoria_script" => array("auditoria_script", ""), 
            "Sorter_auditoria_host" => array("auditoria_host", ""), 
            "Sorter_auditoria_fecha" => array("auditoria_fecha", ""), 
            "Sorter_auditoria_tabla" => array("auditoria_tabla", ""), 
            "Sorter_auditoria_registro_id" => array("auditoria_registro_id", ""), 
            "Sorter_auditoria_descripcion" => array("auditoria_descripcion", ""), 
            "Sorter_aud_tip_abrev" => array("aud_tip_abrev", ""), 
            "Sorter_user_nombre" => array("usuario_nombre", ""), 
            "Sorter_user_nombre1" => array("parcela_partida", "")));
    }
//End SetOrder Method

//Prepare Method @2-D1947BC0
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "expr112", ccsText, "", "", $this->Parameters["expr112"], "", false);
        $this->wp->AddParameter("2", "expr125", ccsText, "", "", $this->Parameters["expr125"], "", false);
        $this->wp->AddParameter("3", "urlparcela_partida", ccsInteger, "", "", $this->Parameters["urlparcela_partida"], "", false);
        $this->wp->AddParameter("4", "urlf_desde", ccsDate, array("dd", "/", "mm", "/", "yyyy"), array("yyyy", "-", "mm", "-", "dd"), $this->Parameters["urlf_desde"], "", false);
        $this->wp->AddParameter("5", "urlf_hasta", ccsDate, array("dd", "/", "mm", "/", "yyyy"), array("yyyy", "-", "mm", "-", "dd"), $this->Parameters["urlf_hasta"], "", false);
        $this->wp->AddParameter("6", "expr138", ccsInteger, "", "", $this->Parameters["expr138"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "auditorias.auditoria_tabla", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "auditorias.auditoria_tabla", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "parcelas.parcela_partida", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opGreaterThanOrEqual, "auditorias.auditoria_fecha", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsDate),false);
        $this->wp->Criterion[5] = $this->wp->Operation(opLessThanOrEqual, "auditorias.auditoria_fecha", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsDate),false);
        $this->wp->Criterion[6] = $this->wp->Operation(opGreaterThanOrEqual, "parcelas.parcela_partida", $this->wp->GetDBValue("6"), $this->ToSQL($this->wp->GetDBValue("6"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opOR(
             true, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]), 
             $this->wp->Criterion[4]), 
             $this->wp->Criterion[5]), 
             $this->wp->Criterion[6]);
    }
//End Prepare Method

//Open Method @2-7E031BFB
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (((auditorias LEFT JOIN auditorias_tipos ON\n\n" .
        "auditorias.aud_tip_id = auditorias_tipos.aud_tip_id) LEFT JOIN usuarios ON\n\n" .
        "auditorias.usuarios_id = usuarios.usuario_id) LEFT JOIN parcelas ON\n\n" .
        "auditorias.auditoria_registro_id = parcelas.parcela_id) LEFT JOIN grupos ON\n\n" .
        "usuarios.grupo_id = grupos.grupo_id";
        $this->SQL = "SELECT auditoria_script, auditoria_host, aud_tip_abrev, auditoria_fecha, auditoria_tabla, auditoria_registro_id, auditoria_descripcion,\n\n" .
        "auditorias.auditoria_id AS auditoria_id, usuario_nombre, parcela_partida \n\n" .
        "FROM (((auditorias LEFT JOIN auditorias_tipos ON\n\n" .
        "auditorias.aud_tip_id = auditorias_tipos.aud_tip_id) LEFT JOIN usuarios ON\n\n" .
        "auditorias.usuarios_id = usuarios.usuario_id) LEFT JOIN parcelas ON\n\n" .
        "auditorias.auditoria_registro_id = parcelas.parcela_id) LEFT JOIN grupos ON\n\n" .
        "usuarios.grupo_id = grupos.grupo_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-DE9FD351
    function SetValues()
    {
        $this->auditoria_script->SetDBValue($this->f("auditoria_script"));
        $this->auditoria_host->SetDBValue($this->f("auditoria_host"));
        $this->auditoria_fecha->SetDBValue(trim($this->f("auditoria_fecha")));
        $this->auditoria_tabla->SetDBValue($this->f("auditoria_tabla"));
        $this->auditoria_registro_id->SetDBValue(trim($this->f("auditoria_registro_id")));
        $this->auditoria_descripcion->SetDBValue($this->f("auditoria_descripcion"));
        $this->aud_tip_abrev->SetDBValue($this->f("aud_tip_abrev"));
        $this->usuario_nombre->SetDBValue($this->f("usuario_nombre"));
        $this->parcela_partida->SetDBValue($this->f("parcela_partida"));
    }
//End SetValues Method

} //End auditorias_auditorias_tip1DataSource Class @2-FCB6E20C

class clsRecordauditorias_auditorias_tip { //auditorias_auditorias_tip Class @18-352D7E91

//Variables @18-9E315808

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

//Class_Initialize Event @18-C50FE702
    function clsRecordauditorias_auditorias_tip($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record auditorias_auditorias_tip/Error";
        $this->ReadAllowed = true;
        $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
        if($this->Visible)
        {
            $this->ReadAllowed = $this->ReadAllowed && CCUserInGroups(CCGetGroupID(), "1;2");
            $this->ComponentName = "auditorias_auditorias_tip";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->parcela_partida = new clsControl(ccsTextBox, "parcela_partida", "parcela_partida", ccsInteger, "", CCGetRequestParam("parcela_partida", $Method, NULL), $this);
            $this->Button1 = new clsButton("Button1", $Method, $this);
            $this->f_desde = new clsControl(ccsTextBox, "f_desde", "f_desde", ccsDate, $DefaultDateFormat, CCGetRequestParam("f_desde", $Method, NULL), $this);
            $this->DatePicker_f_desde1 = new clsDatePicker("DatePicker_f_desde1", "auditorias_auditorias_tip", "f_desde", $this);
            $this->f_hasta = new clsControl(ccsTextBox, "f_hasta", "f_hasta", ccsDate, $DefaultDateFormat, CCGetRequestParam("f_hasta", $Method, NULL), $this);
            $this->DatePicker_f_hasta1 = new clsDatePicker("DatePicker_f_hasta1", "auditorias_auditorias_tip", "f_hasta", $this);
        }
    }
//End Class_Initialize Event

//Validate Method @18-EC84F7E7
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->parcela_partida->Validate() && $Validation);
        $Validation = ($this->f_desde->Validate() && $Validation);
        $Validation = ($this->f_hasta->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->parcela_partida->Errors->Count() == 0);
        $Validation =  $Validation && ($this->f_desde->Errors->Count() == 0);
        $Validation =  $Validation && ($this->f_hasta->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @18-16F8732C
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->parcela_partida->Errors->Count());
        $errors = ($errors || $this->f_desde->Errors->Count());
        $errors = ($errors || $this->DatePicker_f_desde1->Errors->Count());
        $errors = ($errors || $this->f_hasta->Errors->Count());
        $errors = ($errors || $this->DatePicker_f_hasta1->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @18-ED598703
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

//Operation Method @18-EB7D3BF1
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
            } else if($this->Button1->Pressed) {
                $this->PressedButton = "Button1";
            }
        }
        $Redirect = "auditorias_padron.php";
        if($this->PressedButton == "Button1") {
            if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "auditorias_padron.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y", "Button1", "Button1_x", "Button1_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @18-80FF7343
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
            $Error = ComposeStrings($Error, $this->parcela_partida->Errors->ToString());
            $Error = ComposeStrings($Error, $this->f_desde->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_f_desde1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->f_hasta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_f_hasta1->Errors->ToString());
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
        $this->parcela_partida->Show();
        $this->Button1->Show();
        $this->f_desde->Show();
        $this->DatePicker_f_desde1->Show();
        $this->f_hasta->Show();
        $this->DatePicker_f_hasta1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End auditorias_auditorias_tip Class @18-FCB6E20C

//Include Page implementation @109-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @110-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @111-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Initialize Page @1-84527291
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
$TemplateFileName = "auditorias_padron.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-D9DBF8C9
CCSecurityRedirect("1;2", "");
//End Authenticate User

//Include events file @1-46E476F7
include_once("./auditorias_padron_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-FD8704E4
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$auditorias_auditorias_tip1 = new clsGridauditorias_auditorias_tip1("", $MainPage);
$auditorias_auditorias_tip = new clsRecordauditorias_auditorias_tip("", $MainPage);
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$MainPage->auditorias_auditorias_tip1 = & $auditorias_auditorias_tip1;
$MainPage->auditorias_auditorias_tip = & $auditorias_auditorias_tip;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$auditorias_auditorias_tip1->Initialize();

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

//Execute Components @1-72851F84
$auditorias_auditorias_tip->Operation();
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
//End Execute Components

//Go to destination page @1-7B85822D
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    unset($auditorias_auditorias_tip1);
    unset($auditorias_auditorias_tip);
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

//Show Page @1-405D7D0F
$auditorias_auditorias_tip1->Show();
$auditorias_auditorias_tip->Show();
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$QOGALC0J5N2J2R2M = explode("|", "<center><font face=\"Arial\"><small|>&#71;ene&#114;&#97;t&#101;d |<!-- SCC -->&#119;&#105;&#116|;h <!-- CCS -->&#67;&#111;&#|100;&#101;&#67;ha&#114;&#103;e |<!-- SCC -->&#83;t&#117;&#10|0;io.</small></font></center>");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($QOGALC0J5N2J2R2M,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($QOGALC0J5N2J2R2M,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($QOGALC0J5N2J2R2M,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-CA924D2C
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($auditorias_auditorias_tip1);
unset($auditorias_auditorias_tip);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($Tpl);
//End Unload Page


?>
