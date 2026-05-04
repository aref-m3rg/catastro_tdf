<?php

//Include Common Files @1-68A7F13F
define("RelativePath", "..");
define("PathToCurrentPage", "/auditorias/");
define("FileName", "auditDetalle.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridauditorias_detalle { //auditorias_detalle class @2-9FEBDEDC

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

//Class_Initialize Event @2-7B15759F
    function clsGridauditorias_detalle($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "auditorias_detalle";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid auditorias_detalle";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsauditorias_detalleDataSource($this);
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
        $this->Visible = (CCSecurityAccessCheck("1;2") == "success");

        $this->auditoria_det_campo = new clsControl(ccsLabel, "auditoria_det_campo", "auditoria_det_campo", ccsText, "", CCGetRequestParam("auditoria_det_campo", ccsGet, NULL), $this);
        $this->auditoria_det_old = new clsControl(ccsLabel, "auditoria_det_old", "auditoria_det_old", ccsText, "", CCGetRequestParam("auditoria_det_old", ccsGet, NULL), $this);
        $this->auditoria_det_new = new clsControl(ccsLabel, "auditoria_det_new", "auditoria_det_new", ccsText, "", CCGetRequestParam("auditoria_det_new", ccsGet, NULL), $this);
        $this->auditoria_det_descripcion = new clsControl(ccsLabel, "auditoria_det_descripcion", "auditoria_det_descripcion", ccsText, "", CCGetRequestParam("auditoria_det_descripcion", ccsGet, NULL), $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Link1 = new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $this);
        $this->Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->Link1->Page = "auditorias.php";
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

//Show Method @2-65123C2C
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlauditoria_id"] = CCGetFromGet("auditoria_id", NULL);

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
            $this->ControlsVisible["auditoria_det_campo"] = $this->auditoria_det_campo->Visible;
            $this->ControlsVisible["auditoria_det_old"] = $this->auditoria_det_old->Visible;
            $this->ControlsVisible["auditoria_det_new"] = $this->auditoria_det_new->Visible;
            $this->ControlsVisible["auditoria_det_descripcion"] = $this->auditoria_det_descripcion->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->auditoria_det_campo->SetValue($this->DataSource->auditoria_det_campo->GetValue());
                $this->auditoria_det_old->SetValue($this->DataSource->auditoria_det_old->GetValue());
                $this->auditoria_det_new->SetValue($this->DataSource->auditoria_det_new->GetValue());
                $this->auditoria_det_descripcion->SetValue($this->DataSource->auditoria_det_descripcion->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->auditoria_det_campo->Show();
                $this->auditoria_det_old->Show();
                $this->auditoria_det_new->Show();
                $this->auditoria_det_descripcion->Show();
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
        $this->Navigator->Show();
        $this->Link1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @2-85975E76
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->auditoria_det_campo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->auditoria_det_old->Errors->ToString());
        $errors = ComposeStrings($errors, $this->auditoria_det_new->Errors->ToString());
        $errors = ComposeStrings($errors, $this->auditoria_det_descripcion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End auditorias_detalle Class @2-FCB6E20C

class clsauditorias_detalleDataSource extends clsDBtdf_nuevo {  //auditorias_detalleDataSource Class @2-C6D409C6

//DataSource Variables @2-D715834F
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $auditoria_det_campo;
    public $auditoria_det_old;
    public $auditoria_det_new;
    public $auditoria_det_descripcion;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-EE7D0D57
    function clsauditorias_detalleDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid auditorias_detalle";
        $this->Initialize();
        $this->auditoria_det_campo = new clsField("auditoria_det_campo", ccsText, "");
        
        $this->auditoria_det_old = new clsField("auditoria_det_old", ccsText, "");
        
        $this->auditoria_det_new = new clsField("auditoria_det_new", ccsText, "");
        
        $this->auditoria_det_descripcion = new clsField("auditoria_det_descripcion", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-A9C72797
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "auditoria_det_campo";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-79AAEA46
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlauditoria_id", ccsInteger, "", "", $this->Parameters["urlauditoria_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "auditoria_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-3EDC1999
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM auditorias_detalle";
        $this->SQL = "SELECT auditoria_det_campo, auditoria_det_old, auditoria_det_new, auditoria_det_descripcion \n\n" .
        "FROM auditorias_detalle {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-C6332958
    function SetValues()
    {
        $this->auditoria_det_campo->SetDBValue($this->f("auditoria_det_campo"));
        $this->auditoria_det_old->SetDBValue($this->f("auditoria_det_old"));
        $this->auditoria_det_new->SetDBValue($this->f("auditoria_det_new"));
        $this->auditoria_det_descripcion->SetDBValue($this->f("auditoria_det_descripcion"));
    }
//End SetValues Method

} //End auditorias_detalleDataSource Class @2-FCB6E20C

class clsGridauditorias_auditorias_tip { //auditorias_auditorias_tip class @15-DC986F8E

//Variables @15-9CC499F1

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
    public $Sorter_auditoria_fecha;
    public $Sorter_auditoria_tabla;
    public $Sorter_auditoria_registro_id;
    public $Sorter_aud_tip_descripcion;
    public $Sorter_user_nombre;
//End Variables

//Class_Initialize Event @15-82C1661C
    function clsGridauditorias_auditorias_tip($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "auditorias_auditorias_tip";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid auditorias_auditorias_tip";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsauditorias_auditorias_tipDataSource($this);
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
        $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
        $this->SorterName = CCGetParam("auditorias_auditorias_tipOrder", "");
        $this->SorterDirection = CCGetParam("auditorias_auditorias_tipDir", "");

        $this->auditoria_fecha = new clsControl(ccsLabel, "auditoria_fecha", "auditoria_fecha", ccsDate, array("dd", "/", "mm", "/", "yyyy", " ", "h", ":", "nn", " ", "AM/PM"), CCGetRequestParam("auditoria_fecha", ccsGet, NULL), $this);
        $this->auditoria_tabla = new clsControl(ccsLabel, "auditoria_tabla", "auditoria_tabla", ccsText, "", CCGetRequestParam("auditoria_tabla", ccsGet, NULL), $this);
        $this->auditoria_registro_id = new clsControl(ccsLabel, "auditoria_registro_id", "auditoria_registro_id", ccsInteger, "", CCGetRequestParam("auditoria_registro_id", ccsGet, NULL), $this);
        $this->aud_tip_descripcion = new clsControl(ccsLabel, "aud_tip_descripcion", "aud_tip_descripcion", ccsText, "", CCGetRequestParam("aud_tip_descripcion", ccsGet, NULL), $this);
        $this->usuario_nombre = new clsControl(ccsLabel, "usuario_nombre", "usuario_nombre", ccsText, "", CCGetRequestParam("usuario_nombre", ccsGet, NULL), $this);
        $this->Sorter_auditoria_fecha = new clsSorter($this->ComponentName, "Sorter_auditoria_fecha", $FileName, $this);
        $this->Sorter_auditoria_tabla = new clsSorter($this->ComponentName, "Sorter_auditoria_tabla", $FileName, $this);
        $this->Sorter_auditoria_registro_id = new clsSorter($this->ComponentName, "Sorter_auditoria_registro_id", $FileName, $this);
        $this->Sorter_aud_tip_descripcion = new clsSorter($this->ComponentName, "Sorter_aud_tip_descripcion", $FileName, $this);
        $this->Sorter_user_nombre = new clsSorter($this->ComponentName, "Sorter_user_nombre", $FileName, $this);
    }
//End Class_Initialize Event

//Initialize Method @15-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @15-4C83F8EC
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlauditoria_id"] = CCGetFromGet("auditoria_id", NULL);

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
            $this->ControlsVisible["auditoria_fecha"] = $this->auditoria_fecha->Visible;
            $this->ControlsVisible["auditoria_tabla"] = $this->auditoria_tabla->Visible;
            $this->ControlsVisible["auditoria_registro_id"] = $this->auditoria_registro_id->Visible;
            $this->ControlsVisible["aud_tip_descripcion"] = $this->aud_tip_descripcion->Visible;
            $this->ControlsVisible["usuario_nombre"] = $this->usuario_nombre->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->auditoria_fecha->SetValue($this->DataSource->auditoria_fecha->GetValue());
                $this->auditoria_tabla->SetValue($this->DataSource->auditoria_tabla->GetValue());
                $this->auditoria_registro_id->SetValue($this->DataSource->auditoria_registro_id->GetValue());
                $this->aud_tip_descripcion->SetValue($this->DataSource->aud_tip_descripcion->GetValue());
                $this->usuario_nombre->SetValue($this->DataSource->usuario_nombre->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->auditoria_fecha->Show();
                $this->auditoria_tabla->Show();
                $this->auditoria_registro_id->Show();
                $this->aud_tip_descripcion->Show();
                $this->usuario_nombre->Show();
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
        $this->Sorter_auditoria_fecha->Show();
        $this->Sorter_auditoria_tabla->Show();
        $this->Sorter_auditoria_registro_id->Show();
        $this->Sorter_aud_tip_descripcion->Show();
        $this->Sorter_user_nombre->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @15-5BF338E8
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->auditoria_fecha->Errors->ToString());
        $errors = ComposeStrings($errors, $this->auditoria_tabla->Errors->ToString());
        $errors = ComposeStrings($errors, $this->auditoria_registro_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->aud_tip_descripcion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->usuario_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End auditorias_auditorias_tip Class @15-FCB6E20C

class clsauditorias_auditorias_tipDataSource extends clsDBtdf_nuevo {  //auditorias_auditorias_tipDataSource Class @15-324EB54B

//DataSource Variables @15-88B2311B
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $auditoria_fecha;
    public $auditoria_tabla;
    public $auditoria_registro_id;
    public $aud_tip_descripcion;
    public $usuario_nombre;
//End DataSource Variables

//DataSourceClass_Initialize Event @15-8B3EE587
    function clsauditorias_auditorias_tipDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid auditorias_auditorias_tip";
        $this->Initialize();
        $this->auditoria_fecha = new clsField("auditoria_fecha", ccsDate, $this->DateFormat);
        
        $this->auditoria_tabla = new clsField("auditoria_tabla", ccsText, "");
        
        $this->auditoria_registro_id = new clsField("auditoria_registro_id", ccsInteger, "");
        
        $this->aud_tip_descripcion = new clsField("aud_tip_descripcion", ccsText, "");
        
        $this->usuario_nombre = new clsField("usuario_nombre", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @15-E5366464
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_auditoria_fecha" => array("auditoria_fecha", ""), 
            "Sorter_auditoria_tabla" => array("auditoria_tabla", ""), 
            "Sorter_auditoria_registro_id" => array("auditoria_registro_id", ""), 
            "Sorter_aud_tip_descripcion" => array("aud_tip_descripcion", ""), 
            "Sorter_user_nombre" => array("usuario_nombre", "")));
    }
//End SetOrder Method

//Prepare Method @15-5BDAE472
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlauditoria_id", ccsInteger, "", "", $this->Parameters["urlauditoria_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "auditorias.auditoria_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @15-121AF6CB
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (auditorias LEFT JOIN auditorias_tipos ON\n\n" .
        "auditorias.aud_tip_id = auditorias_tipos.aud_tip_id) LEFT JOIN usuarios ON\n\n" .
        "auditorias.usuarios_id = usuarios.usuario_id";
        $this->SQL = "SELECT auditoria_tabla, auditoria_registro_id, auditoria_fecha, aud_tip_descripcion, usuarios.* \n\n" .
        "FROM (auditorias LEFT JOIN auditorias_tipos ON\n\n" .
        "auditorias.aud_tip_id = auditorias_tipos.aud_tip_id) LEFT JOIN usuarios ON\n\n" .
        "auditorias.usuarios_id = usuarios.usuario_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @15-F3EC08E8
    function SetValues()
    {
        $this->auditoria_fecha->SetDBValue(trim($this->f("auditoria_fecha")));
        $this->auditoria_tabla->SetDBValue($this->f("auditoria_tabla"));
        $this->auditoria_registro_id->SetDBValue(trim($this->f("auditoria_registro_id")));
        $this->aud_tip_descripcion->SetDBValue($this->f("aud_tip_descripcion"));
        $this->usuario_nombre->SetDBValue($this->f("usuario_nombre"));
    }
//End SetValues Method

} //End auditorias_auditorias_tipDataSource Class @15-FCB6E20C

//Include Page implementation @49-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @50-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @51-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Initialize Page @1-26C3CF1D
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
$TemplateFileName = "auditDetalle.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-D9DBF8C9
CCSecurityRedirect("1;2", "");
//End Authenticate User

//Include events file @1-0C8A462F
include_once("./auditDetalle_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-414EF258
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$auditorias_detalle = new clsGridauditorias_detalle("", $MainPage);
$auditorias_auditorias_tip = new clsGridauditorias_auditorias_tip("", $MainPage);
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$MainPage->auditorias_detalle = & $auditorias_detalle;
$MainPage->auditorias_auditorias_tip = & $auditorias_auditorias_tip;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$auditorias_detalle->Initialize();
$auditorias_auditorias_tip->Initialize();

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

//Execute Components @1-1BB09E23
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
//End Execute Components

//Go to destination page @1-F7845A27
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    unset($auditorias_detalle);
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

//Show Page @1-0C510503
$auditorias_detalle->Show();
$auditorias_auditorias_tip->Show();
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$LGKDE8E2C4K2K = explode("|", "<center><font face=\"Ar|ial\"><small>&#71;e&|#110;era&#116;e&#100|; <!-- SCC -->&#119;|&#105;th <!-- CCS --|>Cod&#101;&#67;&#10|4;&#97;&#114;ge <!-- SCC| -->&#83;&#116;ud&#105|;o.</small></font></cen|ter>");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($LGKDE8E2C4K2K,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($LGKDE8E2C4K2K,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($LGKDE8E2C4K2K,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-6BA1E504
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($auditorias_detalle);
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
