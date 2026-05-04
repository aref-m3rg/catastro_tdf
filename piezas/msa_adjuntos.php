<?php
//Include Common Files @1-56A3C75F
define("RelativePath", "..");
define("PathToCurrentPage", "/piezas/");
define("FileName", "msa_adjuntos.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

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

//Class_Initialize Event @2-61D41F98
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

        $this->pieza = new clsControl(ccsLabel, "pieza", "pieza", ccsText, "", CCGetRequestParam("pieza", ccsGet, NULL), $this);
        $this->pieza_iniciador = new clsControl(ccsLabel, "pieza_iniciador", "pieza_iniciador", ccsText, "", CCGetRequestParam("pieza_iniciador", ccsGet, NULL), $this);
        $this->pieza_tipo_desc = new clsControl(ccsLabel, "pieza_tipo_desc", "pieza_tipo_desc", ccsText, "", CCGetRequestParam("pieza_tipo_desc", ccsGet, NULL), $this);
        $this->pieza_f_alta = new clsControl(ccsLabel, "pieza_f_alta", "pieza_f_alta", ccsDate, $DefaultDateFormat, CCGetRequestParam("pieza_f_alta", ccsGet, NULL), $this);
        $this->tramite_desc = new clsControl(ccsLabel, "tramite_desc", "tramite_desc", ccsText, "", CCGetRequestParam("tramite_desc", ccsGet, NULL), $this);
        $this->pieza_descripcion = new clsControl(ccsLabel, "pieza_descripcion", "pieza_descripcion", ccsText, "", CCGetRequestParam("pieza_descripcion", ccsGet, NULL), $this);
        $this->unidad_p_nombre = new clsControl(ccsLabel, "unidad_p_nombre", "unidad_p_nombre", ccsText, "", CCGetRequestParam("unidad_p_nombre", ccsGet, NULL), $this);
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

//Show Method @2-F6C6F19A
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlpieza_id"] = CCGetFromGet("pieza_id", NULL);
        $this->DataSource->Parameters["expr11"] = 1;

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
            $this->ControlsVisible["pieza"] = $this->pieza->Visible;
            $this->ControlsVisible["pieza_iniciador"] = $this->pieza_iniciador->Visible;
            $this->ControlsVisible["pieza_tipo_desc"] = $this->pieza_tipo_desc->Visible;
            $this->ControlsVisible["pieza_f_alta"] = $this->pieza_f_alta->Visible;
            $this->ControlsVisible["tramite_desc"] = $this->tramite_desc->Visible;
            $this->ControlsVisible["pieza_descripcion"] = $this->pieza_descripcion->Visible;
            $this->ControlsVisible["unidad_p_nombre"] = $this->unidad_p_nombre->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->pieza->SetValue($this->DataSource->pieza->GetValue());
                $this->pieza_iniciador->SetValue($this->DataSource->pieza_iniciador->GetValue());
                $this->pieza_tipo_desc->SetValue($this->DataSource->pieza_tipo_desc->GetValue());
                $this->pieza_f_alta->SetValue($this->DataSource->pieza_f_alta->GetValue());
                $this->tramite_desc->SetValue($this->DataSource->tramite_desc->GetValue());
                $this->pieza_descripcion->SetValue($this->DataSource->pieza_descripcion->GetValue());
                $this->unidad_p_nombre->SetValue($this->DataSource->unidad_p_nombre->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->pieza->Show();
                $this->pieza_iniciador->Show();
                $this->pieza_tipo_desc->Show();
                $this->pieza_f_alta->Show();
                $this->tramite_desc->Show();
                $this->pieza_descripcion->Show();
                $this->unidad_p_nombre->Show();
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

//GetErrors Method @2-A11DDC3A
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->pieza->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pieza_iniciador->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pieza_tipo_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pieza_f_alta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tramite_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pieza_descripcion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->unidad_p_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End piezas_piezas_tipos_trami Class @2-FCB6E20C

class clspiezas_piezas_tipos_tramiDataSource extends clsDBmesa {  //piezas_piezas_tipos_tramiDataSource Class @2-70A9BED9

//DataSource Variables @2-D4442C4A
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $pieza;
    public $pieza_iniciador;
    public $pieza_tipo_desc;
    public $pieza_f_alta;
    public $tramite_desc;
    public $pieza_descripcion;
    public $unidad_p_nombre;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-4AA64E7B
    function clspiezas_piezas_tipos_tramiDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid piezas_piezas_tipos_trami";
        $this->Initialize();
        $this->pieza = new clsField("pieza", ccsText, "");
        
        $this->pieza_iniciador = new clsField("pieza_iniciador", ccsText, "");
        
        $this->pieza_tipo_desc = new clsField("pieza_tipo_desc", ccsText, "");
        
        $this->pieza_f_alta = new clsField("pieza_f_alta", ccsDate, $this->DateFormat);
        
        $this->tramite_desc = new clsField("tramite_desc", ccsText, "");
        
        $this->pieza_descripcion = new clsField("pieza_descripcion", ccsText, "");
        
        $this->unidad_p_nombre = new clsField("unidad_p_nombre", ccsText, "");
        

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

//Prepare Method @2-9BB4087E
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlpieza_id", ccsInteger, "", "", $this->Parameters["urlpieza_id"], "", false);
        $this->wp->AddParameter("2", "expr11", ccsInteger, "", "", $this->Parameters["expr11"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "piezas.pieza_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "unidades_param.unidad_p_activo", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @2-5B7580E6
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((piezas INNER JOIN piezas_tipos ON\n\n" .
        "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) INNER JOIN tramites ON\n\n" .
        "piezas.tramite_id = tramites.tramite_id) INNER JOIN unidades_param ON\n\n" .
        "piezas.unidad_id = unidades_param.unidad_id";
        $this->SQL = "SELECT pieza_tipo_desc, CONCAT_WS('-',pieza_nro,pieza_letra,pieza_anio) AS pieza, pieza_iniciador, unidad_p_nombre, tramite_desc,\n\n" .
        "pieza_descripcion, pieza_f_alta \n\n" .
        "FROM ((piezas INNER JOIN piezas_tipos ON\n\n" .
        "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) INNER JOIN tramites ON\n\n" .
        "piezas.tramite_id = tramites.tramite_id) INNER JOIN unidades_param ON\n\n" .
        "piezas.unidad_id = unidades_param.unidad_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-8101BC05
    function SetValues()
    {
        $this->pieza->SetDBValue($this->f("pieza"));
        $this->pieza_iniciador->SetDBValue($this->f("pieza_iniciador"));
        $this->pieza_tipo_desc->SetDBValue($this->f("pieza_tipo_desc"));
        $this->pieza_f_alta->SetDBValue(trim($this->f("pieza_f_alta")));
        $this->tramite_desc->SetDBValue($this->f("tramite_desc"));
        $this->pieza_descripcion->SetDBValue($this->f("pieza_descripcion"));
        $this->unidad_p_nombre->SetDBValue($this->f("unidad_p_nombre"));
    }
//End SetValues Method

} //End piezas_piezas_tipos_tramiDataSource Class @2-FCB6E20C

class clsGridadjuntos_adjuntos_tipos_p { //adjuntos_adjuntos_tipos_p class @26-A8DB980B

//Variables @26-6E51DF5A

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

//Class_Initialize Event @26-9663A9AD
    function clsGridadjuntos_adjuntos_tipos_p($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "adjuntos_adjuntos_tipos_p";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid adjuntos_adjuntos_tipos_p";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsadjuntos_adjuntos_tipos_pDataSource($this);
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

        $this->adj_comentario = new clsControl(ccsLabel, "adj_comentario", "adj_comentario", ccsText, "", CCGetRequestParam("adj_comentario", ccsGet, NULL), $this);
        $this->adj_tipo_abrev = new clsControl(ccsLabel, "adj_tipo_abrev", "adj_tipo_abrev", ccsText, "", CCGetRequestParam("adj_tipo_abrev", ccsGet, NULL), $this);
        $this->pieza = new clsControl(ccsLabel, "pieza", "pieza", ccsText, "", CCGetRequestParam("pieza", ccsGet, NULL), $this);
        $this->pieza_descripcion = new clsControl(ccsLabel, "pieza_descripcion", "pieza_descripcion", ccsText, "", CCGetRequestParam("pieza_descripcion", ccsGet, NULL), $this);
        $this->tramite_abrev = new clsControl(ccsLabel, "tramite_abrev", "tramite_abrev", ccsText, "", CCGetRequestParam("tramite_abrev", ccsGet, NULL), $this);
        $this->ImageLink1 = new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", CCGetRequestParam("ImageLink1", ccsGet, NULL), $this);
        $this->ImageLink1->Page = "msa_adjuntos.php";
        $this->pieza_tm_nro = new clsControl(ccsLabel, "pieza_tm_nro", "pieza_tm_nro", ccsInteger, "", CCGetRequestParam("pieza_tm_nro", ccsGet, NULL), $this);
        $this->adjuntos_adjuntos_tipos_p_TotalRecords = new clsControl(ccsLabel, "adjuntos_adjuntos_tipos_p_TotalRecords", "adjuntos_adjuntos_tipos_p_TotalRecords", ccsText, "", CCGetRequestParam("adjuntos_adjuntos_tipos_p_TotalRecords", ccsGet, NULL), $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @26-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @26-BDCD98A0
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
            $this->ControlsVisible["adj_comentario"] = $this->adj_comentario->Visible;
            $this->ControlsVisible["adj_tipo_abrev"] = $this->adj_tipo_abrev->Visible;
            $this->ControlsVisible["pieza"] = $this->pieza->Visible;
            $this->ControlsVisible["pieza_descripcion"] = $this->pieza_descripcion->Visible;
            $this->ControlsVisible["tramite_abrev"] = $this->tramite_abrev->Visible;
            $this->ControlsVisible["ImageLink1"] = $this->ImageLink1->Visible;
            $this->ControlsVisible["pieza_tm_nro"] = $this->pieza_tm_nro->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->adj_comentario->SetValue($this->DataSource->adj_comentario->GetValue());
                $this->adj_tipo_abrev->SetValue($this->DataSource->adj_tipo_abrev->GetValue());
                $this->pieza->SetValue($this->DataSource->pieza->GetValue());
                $this->pieza_descripcion->SetValue($this->DataSource->pieza_descripcion->GetValue());
                $this->tramite_abrev->SetValue($this->DataSource->tramite_abrev->GetValue());
                $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "ppal_pieza_id", $this->DataSource->f("ppal_pieza_id"));
                $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "adj_pieza_id", $this->DataSource->f("adj_pieza_id"));
                $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "desadjuntar", 1);
                $this->pieza_tm_nro->SetValue($this->DataSource->pieza_tm_nro->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->adj_comentario->Show();
                $this->adj_tipo_abrev->Show();
                $this->pieza->Show();
                $this->pieza_descripcion->Show();
                $this->tramite_abrev->Show();
                $this->ImageLink1->Show();
                $this->pieza_tm_nro->Show();
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
        $this->adjuntos_adjuntos_tipos_p_TotalRecords->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @26-7C7477ED
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->adj_comentario->Errors->ToString());
        $errors = ComposeStrings($errors, $this->adj_tipo_abrev->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pieza->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pieza_descripcion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tramite_abrev->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ImageLink1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pieza_tm_nro->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End adjuntos_adjuntos_tipos_p Class @26-FCB6E20C

class clsadjuntos_adjuntos_tipos_pDataSource extends clsDBmesa {  //adjuntos_adjuntos_tipos_pDataSource Class @26-0997ED65

//DataSource Variables @26-D22CBB4D
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $adj_comentario;
    public $adj_tipo_abrev;
    public $pieza;
    public $pieza_descripcion;
    public $tramite_abrev;
    public $pieza_tm_nro;
//End DataSource Variables

//DataSourceClass_Initialize Event @26-32869AE9
    function clsadjuntos_adjuntos_tipos_pDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid adjuntos_adjuntos_tipos_p";
        $this->Initialize();
        $this->adj_comentario = new clsField("adj_comentario", ccsText, "");
        
        $this->adj_tipo_abrev = new clsField("adj_tipo_abrev", ccsText, "");
        
        $this->pieza = new clsField("pieza", ccsText, "");
        
        $this->pieza_descripcion = new clsField("pieza_descripcion", ccsText, "");
        
        $this->tramite_abrev = new clsField("tramite_abrev", ccsText, "");
        
        $this->pieza_tm_nro = new clsField("pieza_tm_nro", ccsInteger, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @26-2A14DD61
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "adj_fecha, adj_pieza_id";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @26-347075EE
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlpieza_id", ccsInteger, "", "", $this->Parameters["urlpieza_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "adjuntos.ppal_pieza_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @26-E927BCB7
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (((piezas INNER JOIN piezas_tipos ON\n\n" .
        "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) INNER JOIN tramites ON\n\n" .
        "piezas.tramite_id = tramites.tramite_id) INNER JOIN adjuntos ON\n\n" .
        "adjuntos.adj_pieza_id = piezas.pieza_id) INNER JOIN adjuntos_tipos ON\n\n" .
        "adjuntos.adj_tipo_id = adjuntos_tipos.adj_tipo_id";
        $this->SQL = "SELECT pieza_tipo_abrev, CONCAT_WS('-',pieza_nro,pieza_letra,pieza_anio) AS pieza, pieza_descripcion, tramite_abrev, tramite_desc,\n\n" .
        "pieza_tipo_desc, pieza_f_alta, adj_tipo_desc, adj_tipo_abrev, adj_comentario, adj_fecha, adj_pieza_id, ppal_pieza_id, pieza_tm_nro \n\n" .
        "FROM (((piezas INNER JOIN piezas_tipos ON\n\n" .
        "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) INNER JOIN tramites ON\n\n" .
        "piezas.tramite_id = tramites.tramite_id) INNER JOIN adjuntos ON\n\n" .
        "adjuntos.adj_pieza_id = piezas.pieza_id) INNER JOIN adjuntos_tipos ON\n\n" .
        "adjuntos.adj_tipo_id = adjuntos_tipos.adj_tipo_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @26-666D0F17
    function SetValues()
    {
        $this->adj_comentario->SetDBValue($this->f("adj_comentario"));
        $this->adj_tipo_abrev->SetDBValue($this->f("adj_tipo_abrev"));
        $this->pieza->SetDBValue($this->f("pieza"));
        $this->pieza_descripcion->SetDBValue($this->f("pieza_descripcion"));
        $this->tramite_abrev->SetDBValue($this->f("tramite_abrev"));
        $this->pieza_tm_nro->SetDBValue(trim($this->f("pieza_tm_nro")));
    }
//End SetValues Method

} //End adjuntos_adjuntos_tipos_pDataSource Class @26-FCB6E20C

//Initialize Page @1-B95BDFEA
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
$TemplateFileName = "msa_adjuntos.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-883777D9
include_once("./msa_adjuntos_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-717FDFBC
$DBmesa = new clsDBmesa();
$MainPage->Connections["mesa"] = & $DBmesa;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$piezas_piezas_tipos_trami = new clsGridpiezas_piezas_tipos_trami("", $MainPage);
$adjuntos_adjuntos_tipos_p = new clsGridadjuntos_adjuntos_tipos_p("", $MainPage);
$MainPage->piezas_piezas_tipos_trami = & $piezas_piezas_tipos_trami;
$MainPage->adjuntos_adjuntos_tipos_p = & $adjuntos_adjuntos_tipos_p;
$piezas_piezas_tipos_trami->Initialize();
$adjuntos_adjuntos_tipos_p->Initialize();

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

//Go to destination page @1-17797F6A
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBmesa->close();
    header("Location: " . $Redirect);
    unset($piezas_piezas_tipos_trami);
    unset($adjuntos_adjuntos_tipos_p);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-D531031A
$piezas_piezas_tipos_trami->Show();
$adjuntos_adjuntos_tipos_p->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$JPIFL6O2R10H6L = array("<center><font face=\"","Arial\"><small>&#71;e","&#110;e&#114;&#97;&#116",";e&#100; <!-- SCC -->w","&#105;&#116;h <!--"," CCS -->C&#111;&#100;&","#101;&#67;ha&#114;ge <","!-- SCC -->S&#116;u&","#100;io.</small></fon","t></center>");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($JPIFL6O2R10H6L,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($JPIFL6O2R10H6L,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($JPIFL6O2R10H6L,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-68C7AB90
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmesa->close();
unset($piezas_piezas_tipos_trami);
unset($adjuntos_adjuntos_tipos_p);
unset($Tpl);
//End Unload Page


?>
