<?php
//Include Common Files @1-29370646
define("RelativePath", "..");
define("PathToCurrentPage", "/panel/");
define("FileName", "pn_inicio.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridwellcome { //wellcome class @5-6A958F53

//Variables @5-6E51DF5A

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

//Class_Initialize Event @5-C71B0A2B
    function clsGridwellcome($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "wellcome";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid wellcome";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clswellcomeDataSource($this);
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

        $this->Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsDate, array("LongDate"), CCGetRequestParam("Label1", ccsGet, NULL), $this);
        $this->usuario_nombre = new clsControl(ccsLabel, "usuario_nombre", "usuario_nombre", ccsText, "", CCGetRequestParam("usuario_nombre", ccsGet, NULL), $this);
        $this->grupo_nombre = new clsControl(ccsLabel, "grupo_nombre", "grupo_nombre", ccsText, "", CCGetRequestParam("grupo_nombre", ccsGet, NULL), $this);
    }
//End Class_Initialize Event

//Initialize Method @5-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @5-4979C934
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["sesUID"] = CCGetSession("UID", NULL);

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
            $this->ControlsVisible["Label1"] = $this->Label1->Visible;
            $this->ControlsVisible["usuario_nombre"] = $this->usuario_nombre->Visible;
            $this->ControlsVisible["grupo_nombre"] = $this->grupo_nombre->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                if(!is_array($this->Label1->Value) && !strlen($this->Label1->Value) && $this->Label1->Value !== false)
                    $this->Label1->SetValue(time());
                $this->usuario_nombre->SetValue($this->DataSource->usuario_nombre->GetValue());
                $this->grupo_nombre->SetValue($this->DataSource->grupo_nombre->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->Label1->Show();
                $this->usuario_nombre->Show();
                $this->grupo_nombre->Show();
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

//GetErrors Method @5-3DA84BF8
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->Label1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->usuario_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->grupo_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End wellcome Class @5-FCB6E20C

class clswellcomeDataSource extends clsDBtdf_nuevo {  //wellcomeDataSource Class @5-F041C075

//DataSource Variables @5-10A8C37B
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $usuario_nombre;
    public $grupo_nombre;
//End DataSource Variables

//DataSourceClass_Initialize Event @5-7C777686
    function clswellcomeDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid wellcome";
        $this->Initialize();
        $this->usuario_nombre = new clsField("usuario_nombre", ccsText, "");
        
        $this->grupo_nombre = new clsField("grupo_nombre", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @5-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @5-2D7DB436
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "sesUID", ccsInteger, "", "", $this->Parameters["sesUID"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "_usuarios.usuario_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @5-6F8BA697
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM _usuarios INNER JOIN _perfiles ON\n\n" .
        "_usuarios.perfil_id = _perfiles.perfil_id";
        $this->SQL = "SELECT UPPER(usuario_nombre) AS usuario_nombre, UPPER(perfil_nombre) AS grupo_nombre, perfil_nombre \n\n" .
        "FROM _usuarios INNER JOIN _perfiles ON\n\n" .
        "_usuarios.perfil_id = _perfiles.perfil_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @5-A8A851B0
    function SetValues()
    {
        $this->usuario_nombre->SetDBValue($this->f("usuario_nombre"));
        $this->grupo_nombre->SetDBValue($this->f("perfil_nombre"));
    }
//End SetValues Method

} //End wellcomeDataSource Class @5-FCB6E20C

//Include Page implementation @86-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @87-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @88-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

class clsGridlogs_logs_tipos { //logs_logs_tipos class @15-612C8656

//Variables @15-6E51DF5A

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

//Class_Initialize Event @15-BA8578FB
    function clsGridlogs_logs_tipos($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "logs_logs_tipos";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid logs_logs_tipos";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clslogs_logs_tiposDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 15;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->auditoria_fecha = new clsControl(ccsLabel, "auditoria_fecha", "auditoria_fecha", ccsDate, array("dd", "/", "mm", "/", "yyyy", " ", "H", ":", "nn"), CCGetRequestParam("auditoria_fecha", ccsGet, NULL), $this);
        $this->aud_tip_descripcion = new clsControl(ccsLabel, "aud_tip_descripcion", "aud_tip_descripcion", ccsText, "", CCGetRequestParam("aud_tip_descripcion", ccsGet, NULL), $this);
        $this->auditoria_host = new clsControl(ccsLabel, "auditoria_host", "auditoria_host", ccsText, "", CCGetRequestParam("auditoria_host", ccsGet, NULL), $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
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

//Show Method @15-3AB7298A
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["expr75"] = 1;
        $this->DataSource->Parameters["expr76"] = 2;
        $this->DataSource->Parameters["sesUID"] = CCGetSession("UID", NULL);

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
            $this->ControlsVisible["aud_tip_descripcion"] = $this->aud_tip_descripcion->Visible;
            $this->ControlsVisible["auditoria_host"] = $this->auditoria_host->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->auditoria_fecha->SetValue($this->DataSource->auditoria_fecha->GetValue());
                $this->aud_tip_descripcion->SetValue($this->DataSource->aud_tip_descripcion->GetValue());
                $this->auditoria_host->SetValue($this->DataSource->auditoria_host->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->auditoria_fecha->Show();
                $this->aud_tip_descripcion->Show();
                $this->auditoria_host->Show();
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
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @15-1CA4A8FA
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->auditoria_fecha->Errors->ToString());
        $errors = ComposeStrings($errors, $this->aud_tip_descripcion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->auditoria_host->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End logs_logs_tipos Class @15-FCB6E20C

class clslogs_logs_tiposDataSource extends clsDBtdf_nuevo {  //logs_logs_tiposDataSource Class @15-24D34A99

//DataSource Variables @15-4BCA0BAB
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $auditoria_fecha;
    public $aud_tip_descripcion;
    public $auditoria_host;
//End DataSource Variables

//DataSourceClass_Initialize Event @15-01518A1C
    function clslogs_logs_tiposDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid logs_logs_tipos";
        $this->Initialize();
        $this->auditoria_fecha = new clsField("auditoria_fecha", ccsDate, $this->DateFormat);
        
        $this->aud_tip_descripcion = new clsField("aud_tip_descripcion", ccsText, "");
        
        $this->auditoria_host = new clsField("auditoria_host", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @15-72870233
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "auditoria_fecha desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @15-812A490D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "expr75", ccsInteger, "", "", $this->Parameters["expr75"], "", false);
        $this->wp->AddParameter("2", "expr76", ccsInteger, "", "", $this->Parameters["expr76"], "", false);
        $this->wp->AddParameter("3", "sesUID", ccsInteger, "", "", $this->Parameters["sesUID"], "", true);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "auditorias.aud_tip_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "auditorias.aud_tip_id", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "auditorias.usuarios_id", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),true);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opOR(
             true, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]);
    }
//End Prepare Method

//Open Method @15-7D8C12BB
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM auditorias INNER JOIN auditorias_tipos ON\n\n" .
        "auditorias.aud_tip_id = auditorias_tipos.aud_tip_id";
        $this->SQL = "SELECT aud_tip_descripcion, auditoria_host, auditoria_fecha \n\n" .
        "FROM auditorias INNER JOIN auditorias_tipos ON\n\n" .
        "auditorias.aud_tip_id = auditorias_tipos.aud_tip_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @15-A2CEE2E6
    function SetValues()
    {
        $this->auditoria_fecha->SetDBValue(trim($this->f("auditoria_fecha")));
        $this->aud_tip_descripcion->SetDBValue($this->f("aud_tip_descripcion"));
        $this->auditoria_host->SetDBValue($this->f("auditoria_host"));
    }
//End SetValues Method

} //End logs_logs_tiposDataSource Class @15-FCB6E20C

class clsGridnoticias_noticias_categor { //noticias_noticias_categor class @30-8B686606

//Variables @30-6E51DF5A

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

//Class_Initialize Event @30-03281EA2
    function clsGridnoticias_noticias_categor($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "noticias_noticias_categor";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid noticias_noticias_categor";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsnoticias_noticias_categorDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 10;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 10)
            $this->PageSize = 10;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->usuario_nombre = new clsControl(ccsLabel, "usuario_nombre", "usuario_nombre", ccsText, "", CCGetRequestParam("usuario_nombre", ccsGet, NULL), $this);
        $this->noti_cat_icono = new clsControl(ccsImage, "noti_cat_icono", "noti_cat_icono", ccsText, "", CCGetRequestParam("noti_cat_icono", ccsGet, NULL), $this);
        $this->noticia_id = new clsControl(ccsLabel, "noticia_id", "noticia_id", ccsInteger, "", CCGetRequestParam("noticia_id", ccsGet, NULL), $this);
        $this->noticias_asunto = new clsControl(ccsLink, "noticias_asunto", "noticias_asunto", ccsText, "", CCGetRequestParam("noticias_asunto", ccsGet, NULL), $this);
        $this->noticias_asunto->Page = "pn_recordNoticiaHilo.php";
        $this->noti_hilo_fecha = new clsControl(ccsLabel, "noti_hilo_fecha", "noti_hilo_fecha", ccsDate, array("dd", "/", "mm", "/", "yy", " ", "H", ":", "nn"), CCGetRequestParam("noti_hilo_fecha", ccsGet, NULL), $this);
        $this->noticias_fecha = new clsControl(ccsLabel, "noticias_fecha", "noticias_fecha", ccsDate, array("dd", "/", "mm", "/", "yy", " ", "H", ":", "nn"), CCGetRequestParam("noticias_fecha", ccsGet, NULL), $this);
        $this->usr_seg_usuario_nombre = new clsControl(ccsLabel, "usr_seg_usuario_nombre", "usr_seg_usuario_nombre", ccsText, "", CCGetRequestParam("usr_seg_usuario_nombre", ccsGet, NULL), $this);
        $this->not_h_desc = new clsControl(ccsLabel, "not_h_desc", "not_h_desc", ccsText, "", CCGetRequestParam("not_h_desc", ccsGet, NULL), $this);
        $this->not_h_icono = new clsControl(ccsImage, "not_h_icono", "not_h_icono", ccsText, "", CCGetRequestParam("not_h_icono", ccsGet, NULL), $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->ImageLink1 = new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", CCGetRequestParam("ImageLink1", ccsGet, NULL), $this);
        $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("noticias_noticia_id", "noticias_noticias_categorPage", "ccsForm"));
        $this->ImageLink1->Page = "pn_recordNoticias.php";
    }
//End Class_Initialize Event

//Initialize Method @30-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @30-B5D00909
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
            $this->ControlsVisible["usuario_nombre"] = $this->usuario_nombre->Visible;
            $this->ControlsVisible["noti_cat_icono"] = $this->noti_cat_icono->Visible;
            $this->ControlsVisible["noticia_id"] = $this->noticia_id->Visible;
            $this->ControlsVisible["noticias_asunto"] = $this->noticias_asunto->Visible;
            $this->ControlsVisible["noti_hilo_fecha"] = $this->noti_hilo_fecha->Visible;
            $this->ControlsVisible["noticias_fecha"] = $this->noticias_fecha->Visible;
            $this->ControlsVisible["usr_seg_usuario_nombre"] = $this->usr_seg_usuario_nombre->Visible;
            $this->ControlsVisible["not_h_desc"] = $this->not_h_desc->Visible;
            $this->ControlsVisible["not_h_icono"] = $this->not_h_icono->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->usuario_nombre->SetValue($this->DataSource->usuario_nombre->GetValue());
                $this->noti_cat_icono->SetValue($this->DataSource->noti_cat_icono->GetValue());
                $this->noticia_id->SetValue($this->DataSource->noticia_id->GetValue());
                $this->noticias_asunto->SetValue($this->DataSource->noticias_asunto->GetValue());
                $this->noticias_asunto->Parameters = CCGetQueryString("QueryString", array("noticias_noticias_categorPage", "ccsForm"));
                $this->noticias_asunto->Parameters = CCAddParam($this->noticias_asunto->Parameters, "noticia_id", $this->DataSource->f("noticias_noticia_id"));
                $this->noti_hilo_fecha->SetValue($this->DataSource->noti_hilo_fecha->GetValue());
                $this->noticias_fecha->SetValue($this->DataSource->noticias_fecha->GetValue());
                $this->usr_seg_usuario_nombre->SetValue($this->DataSource->usr_seg_usuario_nombre->GetValue());
                $this->not_h_desc->SetValue($this->DataSource->not_h_desc->GetValue());
                $this->not_h_icono->SetValue($this->DataSource->not_h_icono->GetValue());
                $this->noti_cat_icono->Attributes->SetValue("title", $this->DataSource->f("noti_cat_descr"));
                $this->not_h_icono->Attributes->SetValue("title", $this->DataSource->f("not_h_desc"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->usuario_nombre->Show();
                $this->noti_cat_icono->Show();
                $this->noticia_id->Show();
                $this->noticias_asunto->Show();
                $this->noti_hilo_fecha->Show();
                $this->noticias_fecha->Show();
                $this->usr_seg_usuario_nombre->Show();
                $this->not_h_desc->Show();
                $this->not_h_icono->Show();
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
        $this->ImageLink1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @30-7888813F
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->usuario_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->noti_cat_icono->Errors->ToString());
        $errors = ComposeStrings($errors, $this->noticia_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->noticias_asunto->Errors->ToString());
        $errors = ComposeStrings($errors, $this->noti_hilo_fecha->Errors->ToString());
        $errors = ComposeStrings($errors, $this->noticias_fecha->Errors->ToString());
        $errors = ComposeStrings($errors, $this->usr_seg_usuario_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->not_h_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->not_h_icono->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End noticias_noticias_categor Class @30-FCB6E20C

class clsnoticias_noticias_categorDataSource extends clsDBtdf_nuevo {  //noticias_noticias_categorDataSource Class @30-E685C8BA

//DataSource Variables @30-289BADC9
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $usuario_nombre;
    public $noti_cat_icono;
    public $noticia_id;
    public $noticias_asunto;
    public $noti_hilo_fecha;
    public $noticias_fecha;
    public $usr_seg_usuario_nombre;
    public $not_h_desc;
    public $not_h_icono;
//End DataSource Variables

//DataSourceClass_Initialize Event @30-B7F68266
    function clsnoticias_noticias_categorDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid noticias_noticias_categor";
        $this->Initialize();
        $this->usuario_nombre = new clsField("usuario_nombre", ccsText, "");
        
        $this->noti_cat_icono = new clsField("noti_cat_icono", ccsText, "");
        
        $this->noticia_id = new clsField("noticia_id", ccsInteger, "");
        
        $this->noticias_asunto = new clsField("noticias_asunto", ccsText, "");
        
        $this->noti_hilo_fecha = new clsField("noti_hilo_fecha", ccsDate, $this->DateFormat);
        
        $this->noticias_fecha = new clsField("noticias_fecha", ccsDate, $this->DateFormat);
        
        $this->usr_seg_usuario_nombre = new clsField("usr_seg_usuario_nombre", ccsText, "");
        
        $this->not_h_desc = new clsField("not_h_desc", ccsText, "");
        
        $this->not_h_icono = new clsField("not_h_icono", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @30-FB57D607
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "noticias_h_estados.not_h_orden, noticias_hilos.noti_hilo_fecha desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @30-A5259A39
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->Criterion[1] = "( noticias_hilos.noti_hilo_id = (SELECT noti_hilo_id FROM noticias_hilos as h WHERE h.noticia_id = noticias.noticia_id ORDER BY noti_hilo_fecha DESC LIMIT 1) )";
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @30-F4FAFFFA
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT noticias_texto AS noticias_texto, noticias_fecha, noti_cat_icono, noti_cat_abrev, noti_cat_descr, noticias_asunto, noticias.noticia_id AS noticias_noticia_id,\n\n" .
        "noti_hilo_fecha, not_h_desc, not_h_icono, not_h_abrev, noticias_hilos.usuario_id AS noticias_hilos_usuario_id, usr_seg.usuario_nombre AS usr_seg_usuario_nombre,\n\n" .
        "_usuarios.usuario_nombre AS _usuarios_usuario_nombre, _usuarios.usuario_id AS _usuarios_usuario_id \n\n" .
        "FROM ((((noticias LEFT JOIN noticias_categoria ON\n\n" .
        "noticias.noti_cat_id = noticias_categoria.noti_cat_id) INNER JOIN noticias_hilos ON\n\n" .
        "noticias_hilos.noticia_id = noticias.noticia_id) INNER JOIN _usuarios _usuarios ON\n\n" .
        "noticias.usuario_id = _usuarios.usuario_id) LEFT JOIN noticias_h_estados ON\n\n" .
        "noticias_hilos.not_h_est_id = noticias_h_estados.not_h_est_id) INNER JOIN _usuarios usr_seg ON\n\n" .
        "noticias_hilos.usuario_id = usr_seg.usuario_id {SQL_Where}\n\n" .
        "GROUP BY noticias.noticia_id {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @30-B8D576CB
    function SetValues()
    {
        $this->usuario_nombre->SetDBValue($this->f("_usuarios_usuario_nombre"));
        $this->noti_cat_icono->SetDBValue($this->f("noti_cat_icono"));
        $this->noticia_id->SetDBValue(trim($this->f("noticias_noticia_id")));
        $this->noticias_asunto->SetDBValue($this->f("noticias_asunto"));
        $this->noti_hilo_fecha->SetDBValue(trim($this->f("noti_hilo_fecha")));
        $this->noticias_fecha->SetDBValue(trim($this->f("noticias_fecha")));
        $this->usr_seg_usuario_nombre->SetDBValue($this->f("usr_seg_usuario_nombre"));
        $this->not_h_desc->SetDBValue($this->f("not_h_desc"));
        $this->not_h_icono->SetDBValue($this->f("not_h_icono"));
    }
//End SetValues Method

} //End noticias_noticias_categorDataSource Class @30-FCB6E20C

//Initialize Page @1-C72466A0
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
$TemplateFileName = "pn_inicio.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-2C1B1622
include_once("./pn_inicio_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-7D03D37E
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$wellcome = new clsGridwellcome("", $MainPage);
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$logs_logs_tipos = new clsGridlogs_logs_tipos("", $MainPage);
$noticias_noticias_categor = new clsGridnoticias_noticias_categor("", $MainPage);
$MainPage->wellcome = & $wellcome;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->logs_logs_tipos = & $logs_logs_tipos;
$MainPage->noticias_noticias_categor = & $noticias_noticias_categor;
$wellcome->Initialize();
$logs_logs_tipos->Initialize();
$noticias_noticias_categor->Initialize();

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

//Go to destination page @1-2014215A
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    unset($wellcome);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($logs_logs_tipos);
    unset($noticias_noticias_categor);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-14CFE5B9
$wellcome->Show();
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$logs_logs_tipos->Show();
$noticias_noticias_categor->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$BTRDSR8G5K5F = explode("|", "<center><font |face=\"Arial\"><sma|ll>&#71;e&#110;&#|101;&#114;&#97;te|&#100; <!-- SCC -|->wit&#104; <!-- SC|C -->&#67;od&#|101;Ch&#97;r&#10|3;e <!-- SCC -|->Studio.</small></|font></center>");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($BTRDSR8G5K5F,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($BTRDSR8G5K5F,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($BTRDSR8G5K5F,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-5424AD0E
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($wellcome);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($logs_logs_tipos);
unset($noticias_noticias_categor);
unset($Tpl);
//End Unload Page


?>
