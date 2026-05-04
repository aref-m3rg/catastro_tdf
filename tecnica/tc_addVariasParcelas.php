<?php
//Include Common Files @1-0A36DDEE
define("RelativePath", "..");
define("PathToCurrentPage", "/tecnica/");
define("FileName", "tc_addVariasParcelas.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @68-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @69-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @70-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

class clsGriddepartamentos_planos_plan { //departamentos_planos_plan class @71-B319D525

//Variables @71-6E51DF5A

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

//Class_Initialize Event @71-67BD4223
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

        $this->dpto_desc = new clsControl(ccsLabel, "dpto_desc", "dpto_desc", ccsText, "", CCGetRequestParam("dpto_desc", ccsGet, NULL), $this);
        $this->plano = new clsControl(ccsLabel, "plano", "plano", ccsText, "", CCGetRequestParam("plano", ccsGet, NULL), $this);
        $this->plano_est_desc = new clsControl(ccsLabel, "plano_est_desc", "plano_est_desc", ccsText, "", CCGetRequestParam("plano_est_desc", ccsGet, NULL), $this);
        $this->plano_tipo_desc = new clsControl(ccsLabel, "plano_tipo_desc", "plano_tipo_desc", ccsText, "", CCGetRequestParam("plano_tipo_desc", ccsGet, NULL), $this);
        $this->expte = new clsControl(ccsLabel, "expte", "expte", ccsText, "", CCGetRequestParam("expte", ccsGet, NULL), $this);
    }
//End Class_Initialize Event

//Initialize Method @71-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @71-E8286030
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
            $this->ControlsVisible["dpto_desc"] = $this->dpto_desc->Visible;
            $this->ControlsVisible["plano"] = $this->plano->Visible;
            $this->ControlsVisible["plano_est_desc"] = $this->plano_est_desc->Visible;
            $this->ControlsVisible["plano_tipo_desc"] = $this->plano_tipo_desc->Visible;
            $this->ControlsVisible["expte"] = $this->expte->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->dpto_desc->SetValue($this->DataSource->dpto_desc->GetValue());
                $this->plano->SetValue($this->DataSource->plano->GetValue());
                $this->plano_est_desc->SetValue($this->DataSource->plano_est_desc->GetValue());
                $this->plano_tipo_desc->SetValue($this->DataSource->plano_tipo_desc->GetValue());
                $this->expte->SetValue($this->DataSource->expte->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->dpto_desc->Show();
                $this->plano->Show();
                $this->plano_est_desc->Show();
                $this->plano_tipo_desc->Show();
                $this->expte->Show();
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

//GetErrors Method @71-FE9F63A2
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->dpto_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano_est_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano_tipo_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->expte->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End departamentos_planos_plan Class @71-FCB6E20C

class clsdepartamentos_planos_planDataSource extends clsDBtdf_nuevo {  //departamentos_planos_planDataSource Class @71-73E68C01

//DataSource Variables @71-DE634C2C
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $dpto_desc;
    public $plano;
    public $plano_est_desc;
    public $plano_tipo_desc;
    public $expte;
//End DataSource Variables

//DataSourceClass_Initialize Event @71-77F3DB77
    function clsdepartamentos_planos_planDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid departamentos_planos_plan";
        $this->Initialize();
        $this->dpto_desc = new clsField("dpto_desc", ccsText, "");
        
        $this->plano = new clsField("plano", ccsText, "");
        
        $this->plano_est_desc = new clsField("plano_est_desc", ccsText, "");
        
        $this->plano_tipo_desc = new clsField("plano_tipo_desc", ccsText, "");
        
        $this->expte = new clsField("expte", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @71-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @71-E81FE6BF
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

//Open Method @71-CD109CC4
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((planos LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "planos.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN tipos_estados_planos ON\n\n" .
        "planos.tipo_estado_plano_id = tipos_estados_planos.tipo_estado_plano_id) LEFT JOIN tipos_planos ON\n\n" .
        "planos.tipo_plano_id = tipos_planos.tipo_plano_id";
        $this->SQL = "SELECT CONCAT_WS('-',plano_e_nro,plano_e_letra,plano_e_anio) AS expte, tipo_depto_parc_desc, tipo_plano_desc, tipo_plano_abrev, tipo_plano_abrev2,\n\n" .
        "tipo_estado_plano_desc, tipo_estado_plano_abrev, tipo_estado_plano_cerrado, planos.* \n\n" .
        "FROM ((planos LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "planos.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN tipos_estados_planos ON\n\n" .
        "planos.tipo_estado_plano_id = tipos_estados_planos.tipo_estado_plano_id) LEFT JOIN tipos_planos ON\n\n" .
        "planos.tipo_plano_id = tipos_planos.tipo_plano_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @71-C910D8E3
    function SetValues()
    {
        $this->dpto_desc->SetDBValue($this->f("tipo_estado_plano_desc"));
        $this->plano->SetDBValue($this->f("plano"));
        $this->plano_est_desc->SetDBValue($this->f("tipo_estado_plano_desc"));
        $this->plano_tipo_desc->SetDBValue($this->f("tipo_plano_desc"));
        $this->expte->SetDBValue($this->f("expte"));
    }
//End SetValues Method

} //End departamentos_planos_planDataSource Class @71-FCB6E20C

class clsGriddoc_tipos_personas_person { //doc_tipos_personas_person class @110-2DC5C5AD

//Variables @110-6E51DF5A

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

//Class_Initialize Event @110-B2F5D11B
    function clsGriddoc_tipos_personas_person($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "doc_tipos_personas_person";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid doc_tipos_personas_person";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsdoc_tipos_personas_personDataSource($this);
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

        $this->persona_denominacion = new clsControl(ccsLabel, "persona_denominacion", "persona_denominacion", ccsText, "", CCGetRequestParam("persona_denominacion", ccsGet, NULL), $this);
        $this->doc_tipo_abrev = new clsControl(ccsLabel, "doc_tipo_abrev", "doc_tipo_abrev", ccsText, "", CCGetRequestParam("doc_tipo_abrev", ccsGet, NULL), $this);
        $this->persona_nro_doc = new clsControl(ccsLabel, "persona_nro_doc", "persona_nro_doc", ccsInteger, "", CCGetRequestParam("persona_nro_doc", ccsGet, NULL), $this);
        $this->ImageLink2 = new clsControl(ccsImageLink, "ImageLink2", "ImageLink2", ccsText, "", CCGetRequestParam("ImageLink2", ccsGet, NULL), $this);
        $this->ImageLink2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->ImageLink2->Page = "";
        $this->tipo_persona_parcela_descrip = new clsControl(ccsLabel, "tipo_persona_parcela_descrip", "tipo_persona_parcela_descrip", ccsText, "", CCGetRequestParam("tipo_persona_parcela_descrip", ccsGet, NULL), $this);
        $this->tipo_instrumento_descrip = new clsControl(ccsLabel, "tipo_instrumento_descrip", "tipo_instrumento_descrip", ccsText, "", CCGetRequestParam("tipo_instrumento_descrip", ccsGet, NULL), $this);
        $this->planos_parc_prov_personas_num_int = new clsControl(ccsLabel, "planos_parc_prov_personas_num_int", "planos_parc_prov_personas_num_int", ccsText, "", CCGetRequestParam("planos_parc_prov_personas_num_int", ccsGet, NULL), $this);
        $this->doc_tipos_personas_person_TotalRecords = new clsControl(ccsLabel, "doc_tipos_personas_person_TotalRecords", "doc_tipos_personas_person_TotalRecords", ccsText, "", CCGetRequestParam("doc_tipos_personas_person_TotalRecords", ccsGet, NULL), $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->ImageLink1 = new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", CCGetRequestParam("ImageLink1", ccsGet, NULL), $this);
        $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->ImageLink1->Page = "";
    }
//End Class_Initialize Event

//Initialize Method @110-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @110-403C7E47
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlplanos_prov_id"] = CCGetFromGet("planos_prov_id", NULL);

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
            $this->ControlsVisible["persona_denominacion"] = $this->persona_denominacion->Visible;
            $this->ControlsVisible["doc_tipo_abrev"] = $this->doc_tipo_abrev->Visible;
            $this->ControlsVisible["persona_nro_doc"] = $this->persona_nro_doc->Visible;
            $this->ControlsVisible["ImageLink2"] = $this->ImageLink2->Visible;
            $this->ControlsVisible["tipo_persona_parcela_descrip"] = $this->tipo_persona_parcela_descrip->Visible;
            $this->ControlsVisible["tipo_instrumento_descrip"] = $this->tipo_instrumento_descrip->Visible;
            $this->ControlsVisible["planos_parc_prov_personas_num_int"] = $this->planos_parc_prov_personas_num_int->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->persona_denominacion->SetValue($this->DataSource->persona_denominacion->GetValue());
                $this->doc_tipo_abrev->SetValue($this->DataSource->doc_tipo_abrev->GetValue());
                $this->persona_nro_doc->SetValue($this->DataSource->persona_nro_doc->GetValue());
                $this->tipo_persona_parcela_descrip->SetValue($this->DataSource->tipo_persona_parcela_descrip->GetValue());
                $this->tipo_instrumento_descrip->SetValue($this->DataSource->tipo_instrumento_descrip->GetValue());
                $this->planos_parc_prov_personas_num_int->SetValue($this->DataSource->planos_parc_prov_personas_num_int->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->persona_denominacion->Show();
                $this->doc_tipo_abrev->Show();
                $this->persona_nro_doc->Show();
                $this->ImageLink2->Show();
                $this->tipo_persona_parcela_descrip->Show();
                $this->tipo_instrumento_descrip->Show();
                $this->planos_parc_prov_personas_num_int->Show();
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
        $this->doc_tipos_personas_person_TotalRecords->Show();
        $this->Navigator->Show();
        $this->ImageLink1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @110-3F817740
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->persona_denominacion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->doc_tipo_abrev->Errors->ToString());
        $errors = ComposeStrings($errors, $this->persona_nro_doc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ImageLink2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_persona_parcela_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_instrumento_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->planos_parc_prov_personas_num_int->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End doc_tipos_personas_person Class @110-FCB6E20C

class clsdoc_tipos_personas_personDataSource extends clsDBtdf_nuevo {  //doc_tipos_personas_personDataSource Class @110-471E57F6

//DataSource Variables @110-35EA8E42
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $persona_denominacion;
    public $doc_tipo_abrev;
    public $persona_nro_doc;
    public $tipo_persona_parcela_descrip;
    public $tipo_instrumento_descrip;
    public $planos_parc_prov_personas_num_int;
//End DataSource Variables

//DataSourceClass_Initialize Event @110-9DC3D091
    function clsdoc_tipos_personas_personDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid doc_tipos_personas_person";
        $this->Initialize();
        $this->persona_denominacion = new clsField("persona_denominacion", ccsText, "");
        
        $this->doc_tipo_abrev = new clsField("doc_tipo_abrev", ccsText, "");
        
        $this->persona_nro_doc = new clsField("persona_nro_doc", ccsInteger, "");
        
        $this->tipo_persona_parcela_descrip = new clsField("tipo_persona_parcela_descrip", ccsText, "");
        
        $this->tipo_instrumento_descrip = new clsField("tipo_instrumento_descrip", ccsText, "");
        
        $this->planos_parc_prov_personas_num_int = new clsField("planos_parc_prov_personas_num_int", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @110-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @110-E0A79F0C
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlplanos_prov_id", ccsInteger, "", "", $this->Parameters["urlplanos_prov_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "planos_parc_prov_personas.planos_prov_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @110-2D57828F
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (((personas INNER JOIN planos_parc_prov_personas ON\n\n" .
        "planos_parc_prov_personas.persona_id = personas.persona_id) LEFT JOIN tipos_documentos ON\n\n" .
        "personas.tipo_documento_id = tipos_documentos.tipo_documento_id) LEFT JOIN tipos_personas_parcelas ON\n\n" .
        "planos_parc_prov_personas.tipo_persona_parcela_id = tipos_personas_parcelas.tipo_persona_parcela_id) LEFT JOIN tipos_instrumentos ON\n\n" .
        "planos_parc_prov_personas.tipo_instrumento_id = tipos_instrumentos.tipo_instrumento_id";
        $this->SQL = "SELECT planos_parc_prov_personas_id, personas.*, tipo_documento_descrip, tipo_persona_parcela_descrip, tipo_instrumento_descrip, planos_parc_prov_personas_num_int \n\n" .
        "FROM (((personas INNER JOIN planos_parc_prov_personas ON\n\n" .
        "planos_parc_prov_personas.persona_id = personas.persona_id) LEFT JOIN tipos_documentos ON\n\n" .
        "personas.tipo_documento_id = tipos_documentos.tipo_documento_id) LEFT JOIN tipos_personas_parcelas ON\n\n" .
        "planos_parc_prov_personas.tipo_persona_parcela_id = tipos_personas_parcelas.tipo_persona_parcela_id) LEFT JOIN tipos_instrumentos ON\n\n" .
        "planos_parc_prov_personas.tipo_instrumento_id = tipos_instrumentos.tipo_instrumento_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @110-B1007A7B
    function SetValues()
    {
        $this->persona_denominacion->SetDBValue($this->f("persona_denominacion"));
        $this->doc_tipo_abrev->SetDBValue($this->f("tipo_documento_descrip"));
        $this->persona_nro_doc->SetDBValue(trim($this->f("persona_nro_doc")));
        $this->tipo_persona_parcela_descrip->SetDBValue($this->f("tipo_persona_parcela_descrip"));
        $this->tipo_instrumento_descrip->SetDBValue($this->f("tipo_instrumento_descrip"));
        $this->planos_parc_prov_personas_num_int->SetDBValue($this->f("planos_parc_prov_personas_num_int"));
    }
//End SetValues Method

} //End doc_tipos_personas_personDataSource Class @110-FCB6E20C

class clsRecordparcelas { //parcelas Class @2-F41C09A9

//Variables @2-9E315808

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

//Class_Initialize Event @2-29B0B019
    function clsRecordparcelas($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record parcelas/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "parcelas";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->plano_id = new clsControl(ccsHidden, "plano_id", "Plano Id", ccsInteger, "", CCGetRequestParam("plano_id", $Method, NULL), $this);
            $this->parcela_seccion = new clsControl(ccsTextBox, "parcela_seccion", "Seccion", ccsText, "", CCGetRequestParam("parcela_seccion", $Method, NULL), $this);
            $this->parcela_macizo = new clsControl(ccsTextBox, "parcela_macizo", "Macizo", ccsText, "", CCGetRequestParam("parcela_macizo", $Method, NULL), $this);
            $this->parcela_chacra = new clsControl(ccsTextBox, "parcela_chacra", "Chacra", ccsText, "", CCGetRequestParam("parcela_chacra", $Method, NULL), $this);
            $this->parcela_quinta = new clsControl(ccsTextBox, "parcela_quinta", "Quinta", ccsText, "", CCGetRequestParam("parcela_quinta", $Method, NULL), $this);
            $this->parcela_fraccion = new clsControl(ccsTextBox, "parcela_fraccion", "Fraccion", ccsText, "", CCGetRequestParam("parcela_fraccion", $Method, NULL), $this);
            $this->parcela_superficie = new clsControl(ccsTextBox, "parcela_superficie", "Superficie", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("parcela_superficie", $Method, NULL), $this);
            $this->uni_med_id = new clsControl(ccsListBox, "uni_med_id", "uni_med_id", ccsInteger, "", CCGetRequestParam("uni_med_id", $Method, NULL), $this);
            $this->uni_med_id->DSType = dsTable;
            $this->uni_med_id->DataSource = new clsDBtdf_nuevo();
            $this->uni_med_id->ds = & $this->uni_med_id->DataSource;
            $this->uni_med_id->DataSource->SQL = "SELECT * \n" .
"FROM unidades_medidas {SQL_Where} {SQL_OrderBy}";
            list($this->uni_med_id->BoundColumn, $this->uni_med_id->TextColumn, $this->uni_med_id->DBFormat) = array("unidades_medidas_id", "unidades_medidas_abrev", "");
            $this->dpto_id = new clsControl(ccsHidden, "dpto_id", "dpto_id", ccsText, "", CCGetRequestParam("dpto_id", $Method, NULL), $this);
            $this->planos_parc_prov_tipo = new clsControl(ccsHidden, "planos_parc_prov_tipo", "planos_parc_prov_tipo", ccsText, "", CCGetRequestParam("planos_parc_prov_tipo", $Method, NULL), $this);
            $this->totalParcelas = new clsControl(ccsTextBox, "totalParcelas", "totalParcelas", ccsText, "", CCGetRequestParam("totalParcelas", $Method, NULL), $this);
            $this->ListBox1 = new clsControl(ccsListBox, "ListBox1", "ListBox1", ccsText, "", CCGetRequestParam("ListBox1", $Method, NULL), $this);
            $this->ListBox1->DSType = dsTable;
            $this->ListBox1->DataSource = new clsDBtdf_nuevo();
            $this->ListBox1->ds = & $this->ListBox1->DataSource;
            $this->ListBox1->DataSource->SQL = "SELECT * \n" .
"FROM tipos_padrones_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->ListBox1->BoundColumn, $this->ListBox1->TextColumn, $this->ListBox1->DBFormat) = array("tipo_padron_parc_id", "tipo_padron_parc_desc", "");
            $this->TextBox1 = new clsControl(ccsListBox, "TextBox1", "TextBox1", ccsText, "", CCGetRequestParam("TextBox1", $Method, NULL), $this);
            $this->TextBox1->DSType = dsTable;
            $this->TextBox1->DataSource = new clsDBtdf_nuevo();
            $this->TextBox1->ds = & $this->TextBox1->DataSource;
            $this->TextBox1->DataSource->SQL = "SELECT * \n" .
"FROM tipos_deptos_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->TextBox1->BoundColumn, $this->TextBox1->TextColumn, $this->TextBox1->DBFormat) = array("tipo_depto_parc_id", "tipo_depto_parc_desc", "");
            $this->parcela_inicial = new clsControl(ccsTextBox, "parcela_inicial", "parcela_inicial", ccsText, "", CCGetRequestParam("parcela_inicial", $Method, NULL), $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->plano_id->Value) && !strlen($this->plano_id->Value) && $this->plano_id->Value !== false)
                    $this->plano_id->SetText(CCGetParam(plano_id));
                if(!is_array($this->planos_parc_prov_tipo->Value) && !strlen($this->planos_parc_prov_tipo->Value) && $this->planos_parc_prov_tipo->Value !== false)
                    $this->planos_parc_prov_tipo->SetText('destino');
                if(!is_array($this->parcela_inicial->Value) && !strlen($this->parcela_inicial->Value) && $this->parcela_inicial->Value !== false)
                    $this->parcela_inicial->SetText(1);
            }
        }
    }
//End Class_Initialize Event

//Validate Method @2-E14F7C79
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->plano_id->Validate() && $Validation);
        $Validation = ($this->parcela_seccion->Validate() && $Validation);
        $Validation = ($this->parcela_macizo->Validate() && $Validation);
        $Validation = ($this->parcela_chacra->Validate() && $Validation);
        $Validation = ($this->parcela_quinta->Validate() && $Validation);
        $Validation = ($this->parcela_fraccion->Validate() && $Validation);
        $Validation = ($this->parcela_superficie->Validate() && $Validation);
        $Validation = ($this->uni_med_id->Validate() && $Validation);
        $Validation = ($this->dpto_id->Validate() && $Validation);
        $Validation = ($this->planos_parc_prov_tipo->Validate() && $Validation);
        $Validation = ($this->totalParcelas->Validate() && $Validation);
        $Validation = ($this->ListBox1->Validate() && $Validation);
        $Validation = ($this->TextBox1->Validate() && $Validation);
        $Validation = ($this->parcela_inicial->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->plano_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_seccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_macizo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_chacra->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_quinta->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_fraccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_superficie->Errors->Count() == 0);
        $Validation =  $Validation && ($this->uni_med_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->dpto_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->planos_parc_prov_tipo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->totalParcelas->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ListBox1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->TextBox1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_inicial->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-2F2765D6
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->plano_id->Errors->Count());
        $errors = ($errors || $this->parcela_seccion->Errors->Count());
        $errors = ($errors || $this->parcela_macizo->Errors->Count());
        $errors = ($errors || $this->parcela_chacra->Errors->Count());
        $errors = ($errors || $this->parcela_quinta->Errors->Count());
        $errors = ($errors || $this->parcela_fraccion->Errors->Count());
        $errors = ($errors || $this->parcela_superficie->Errors->Count());
        $errors = ($errors || $this->uni_med_id->Errors->Count());
        $errors = ($errors || $this->dpto_id->Errors->Count());
        $errors = ($errors || $this->planos_parc_prov_tipo->Errors->Count());
        $errors = ($errors || $this->totalParcelas->Errors->Count());
        $errors = ($errors || $this->ListBox1->Errors->Count());
        $errors = ($errors || $this->TextBox1->Errors->Count());
        $errors = ($errors || $this->parcela_inicial->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @2-ED598703
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

//Operation Method @2-E3CA450D
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
            $this->PressedButton = "Button_Insert";
            if($this->Button_Insert->Pressed) {
                $this->PressedButton = "Button_Insert";
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Cancel") {
            $Redirect = "tc_planosRecord.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "parcela_id"));
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
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
    }
//End Operation Method

//Show Method @2-EFFD1267
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

        $this->uni_med_id->Prepare();
        $this->ListBox1->Prepare();
        $this->TextBox1->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->plano_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_seccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_macizo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_chacra->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_quinta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_fraccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_superficie->Errors->ToString());
            $Error = ComposeStrings($Error, $this->uni_med_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->dpto_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->planos_parc_prov_tipo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->totalParcelas->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ListBox1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->TextBox1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_inicial->Errors->ToString());
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

        $this->Button_Insert->Show();
        $this->Button_Cancel->Show();
        $this->plano_id->Show();
        $this->parcela_seccion->Show();
        $this->parcela_macizo->Show();
        $this->parcela_chacra->Show();
        $this->parcela_quinta->Show();
        $this->parcela_fraccion->Show();
        $this->parcela_superficie->Show();
        $this->uni_med_id->Show();
        $this->dpto_id->Show();
        $this->planos_parc_prov_tipo->Show();
        $this->totalParcelas->Show();
        $this->ListBox1->Show();
        $this->TextBox1->Show();
        $this->parcela_inicial->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End parcelas Class @2-FCB6E20C

class clsGridparcelas1 { //parcelas1 class @232-0E869545

//Variables @232-B330061F

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
    public $Sorter_parcela_nomenclatura;
//End Variables

//Class_Initialize Event @232-2D98C38A
    function clsGridparcelas1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "parcelas1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid parcelas1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsparcelas1DataSource($this);
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
        $this->SorterName = CCGetParam("parcelas1Order", "");
        $this->SorterDirection = CCGetParam("parcelas1Dir", "");

        $this->tipo_depto_parc_id = new clsControl(ccsLabel, "tipo_depto_parc_id", "tipo_depto_parc_id", ccsText, "", CCGetRequestParam("tipo_depto_parc_id", ccsGet, NULL), $this);
        $this->parcela_seccion = new clsControl(ccsLabel, "parcela_seccion", "parcela_seccion", ccsText, "", CCGetRequestParam("parcela_seccion", ccsGet, NULL), $this);
        $this->parcela_chacra = new clsControl(ccsLabel, "parcela_chacra", "parcela_chacra", ccsText, "", CCGetRequestParam("parcela_chacra", ccsGet, NULL), $this);
        $this->parcela_quinta = new clsControl(ccsLabel, "parcela_quinta", "parcela_quinta", ccsText, "", CCGetRequestParam("parcela_quinta", ccsGet, NULL), $this);
        $this->parcela_macizo = new clsControl(ccsLabel, "parcela_macizo", "parcela_macizo", ccsText, "", CCGetRequestParam("parcela_macizo", ccsGet, NULL), $this);
        $this->parcela_fraccion = new clsControl(ccsLabel, "parcela_fraccion", "parcela_fraccion", ccsText, "", CCGetRequestParam("parcela_fraccion", ccsGet, NULL), $this);
        $this->parcela_super_mensura = new clsControl(ccsLabel, "parcela_super_mensura", "parcela_super_mensura", ccsText, "", CCGetRequestParam("parcela_super_mensura", ccsGet, NULL), $this);
        $this->parcela_parcela = new clsControl(ccsLabel, "parcela_parcela", "parcela_parcela", ccsText, "", CCGetRequestParam("parcela_parcela", ccsGet, NULL), $this);
        $this->uni_med_desc = new clsControl(ccsLabel, "uni_med_desc", "uni_med_desc", ccsText, "", CCGetRequestParam("uni_med_desc", ccsGet, NULL), $this);
        $this->tipo_padron_parc_desc = new clsControl(ccsLabel, "tipo_padron_parc_desc", "tipo_padron_parc_desc", ccsText, "", CCGetRequestParam("tipo_padron_parc_desc", ccsGet, NULL), $this);
        $this->parcela_repetida = new clsControl(ccsHidden, "parcela_repetida", "parcela_repetida", ccsText, "", CCGetRequestParam("parcela_repetida", ccsGet, NULL), $this);
        $this->Sorter_parcela_nomenclatura = new clsSorter($this->ComponentName, "Sorter_parcela_nomenclatura", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50", "100");
        $this->Button2 = new clsButton("Button2", ccsGet, $this);
        $this->Button1 = new clsButton("Button1", ccsGet, $this);
        $this->Hidden1 = new clsControl(ccsHidden, "Hidden1", "Hidden1", ccsText, "", CCGetRequestParam("Hidden1", ccsGet, NULL), $this);
        $this->Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", CCGetRequestParam("Label1", ccsGet, NULL), $this);
    }
//End Class_Initialize Event

//Initialize Method @232-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @232-73DC9FA7
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
            $this->ControlsVisible["tipo_depto_parc_id"] = $this->tipo_depto_parc_id->Visible;
            $this->ControlsVisible["parcela_seccion"] = $this->parcela_seccion->Visible;
            $this->ControlsVisible["parcela_chacra"] = $this->parcela_chacra->Visible;
            $this->ControlsVisible["parcela_quinta"] = $this->parcela_quinta->Visible;
            $this->ControlsVisible["parcela_macizo"] = $this->parcela_macizo->Visible;
            $this->ControlsVisible["parcela_fraccion"] = $this->parcela_fraccion->Visible;
            $this->ControlsVisible["parcela_super_mensura"] = $this->parcela_super_mensura->Visible;
            $this->ControlsVisible["parcela_parcela"] = $this->parcela_parcela->Visible;
            $this->ControlsVisible["uni_med_desc"] = $this->uni_med_desc->Visible;
            $this->ControlsVisible["tipo_padron_parc_desc"] = $this->tipo_padron_parc_desc->Visible;
            $this->ControlsVisible["parcela_repetida"] = $this->parcela_repetida->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->tipo_depto_parc_id->SetValue($this->DataSource->tipo_depto_parc_id->GetValue());
                $this->parcela_seccion->SetValue($this->DataSource->parcela_seccion->GetValue());
                $this->parcela_chacra->SetValue($this->DataSource->parcela_chacra->GetValue());
                $this->parcela_quinta->SetValue($this->DataSource->parcela_quinta->GetValue());
                $this->parcela_macizo->SetValue($this->DataSource->parcela_macizo->GetValue());
                $this->parcela_fraccion->SetValue($this->DataSource->parcela_fraccion->GetValue());
                $this->parcela_super_mensura->SetValue($this->DataSource->parcela_super_mensura->GetValue());
                $this->parcela_parcela->SetValue($this->DataSource->parcela_parcela->GetValue());
                $this->uni_med_desc->SetValue($this->DataSource->uni_med_desc->GetValue());
                $this->tipo_padron_parc_desc->SetValue($this->DataSource->tipo_padron_parc_desc->GetValue());
                $this->parcela_repetida->SetValue($this->DataSource->parcela_repetida->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->tipo_depto_parc_id->Show();
                $this->parcela_seccion->Show();
                $this->parcela_chacra->Show();
                $this->parcela_quinta->Show();
                $this->parcela_macizo->Show();
                $this->parcela_fraccion->Show();
                $this->parcela_super_mensura->Show();
                $this->parcela_parcela->Show();
                $this->uni_med_desc->Show();
                $this->tipo_padron_parc_desc->Show();
                $this->parcela_repetida->Show();
                $Tpl->block_path = $ParentPath . "/" . $GridBlock;
                $Tpl->parse("Row", true);
            }
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
        $this->Sorter_parcela_nomenclatura->Show();
        $this->Navigator->Show();
        $this->Button2->Show();
        $this->Button1->Show();
        $this->Hidden1->Show();
        $this->Label1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @232-66A93CF9
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->tipo_depto_parc_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_seccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_chacra->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_quinta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_macizo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_fraccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_super_mensura->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_parcela->Errors->ToString());
        $errors = ComposeStrings($errors, $this->uni_med_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_padron_parc_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_repetida->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End parcelas1 Class @232-FCB6E20C

class clsparcelas1DataSource extends clsDBtdf_nuevo {  //parcelas1DataSource Class @232-E4E477A5

//DataSource Variables @232-2808FF9A
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $tipo_depto_parc_id;
    public $parcela_seccion;
    public $parcela_chacra;
    public $parcela_quinta;
    public $parcela_macizo;
    public $parcela_fraccion;
    public $parcela_super_mensura;
    public $parcela_parcela;
    public $uni_med_desc;
    public $tipo_padron_parc_desc;
    public $parcela_repetida;
//End DataSource Variables

//DataSourceClass_Initialize Event @232-A4B158F8
    function clsparcelas1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid parcelas1";
        $this->Initialize();
        $this->tipo_depto_parc_id = new clsField("tipo_depto_parc_id", ccsText, "");
        
        $this->parcela_seccion = new clsField("parcela_seccion", ccsText, "");
        
        $this->parcela_chacra = new clsField("parcela_chacra", ccsText, "");
        
        $this->parcela_quinta = new clsField("parcela_quinta", ccsText, "");
        
        $this->parcela_macizo = new clsField("parcela_macizo", ccsText, "");
        
        $this->parcela_fraccion = new clsField("parcela_fraccion", ccsText, "");
        
        $this->parcela_super_mensura = new clsField("parcela_super_mensura", ccsText, "");
        
        $this->parcela_parcela = new clsField("parcela_parcela", ccsText, "");
        
        $this->uni_med_desc = new clsField("uni_med_desc", ccsText, "");
        
        $this->tipo_padron_parc_desc = new clsField("tipo_padron_parc_desc", ccsText, "");
        
        $this->parcela_repetida = new clsField("parcela_repetida", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @232-9DFAF7F7
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_parcela_nomenclatura" => array("parcela_nomenclatura", "")));
    }
//End SetOrder Method

//Prepare Method @232-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @232-B78BC87B
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((parcelas_masivas LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "parcelas_masivas.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN unidades_medidas ON\n\n" .
        "parcelas_masivas.unidades_medidas_id = unidades_medidas.unidades_medidas_id) LEFT JOIN tipos_padrones_parcela ON\n\n" .
        "parcelas_masivas.tipo_padron_parc_id = tipos_padrones_parcela.tipo_padron_parc_id";
        $this->SQL = "SELECT parcelas_masivas.*, tipo_depto_parc_desc, unidades_medidas_abrev, tipo_padron_parc_desc \n\n" .
        "FROM ((parcelas_masivas LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "parcelas_masivas.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN unidades_medidas ON\n\n" .
        "parcelas_masivas.unidades_medidas_id = unidades_medidas.unidades_medidas_id) LEFT JOIN tipos_padrones_parcela ON\n\n" .
        "parcelas_masivas.tipo_padron_parc_id = tipos_padrones_parcela.tipo_padron_parc_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @232-FE7AAE1C
    function SetValues()
    {
        $this->tipo_depto_parc_id->SetDBValue($this->f("tipo_depto_parc_desc"));
        $this->parcela_seccion->SetDBValue($this->f("parcela_seccion"));
        $this->parcela_chacra->SetDBValue($this->f("parcela_chacra"));
        $this->parcela_quinta->SetDBValue($this->f("parcela_quinta"));
        $this->parcela_macizo->SetDBValue($this->f("parcela_macizo"));
        $this->parcela_fraccion->SetDBValue($this->f("parcela_fraccion"));
        $this->parcela_super_mensura->SetDBValue($this->f("parcela_super_mensura"));
        $this->parcela_parcela->SetDBValue($this->f("parcela_parcela"));
        $this->uni_med_desc->SetDBValue($this->f("unidades_medidas_abrev"));
        $this->tipo_padron_parc_desc->SetDBValue($this->f("tipo_padron_parc_desc"));
        $this->parcela_repetida->SetDBValue($this->f("parcela_repetida"));
    }
//End SetValues Method

} //End parcelas1DataSource Class @232-FCB6E20C



























//Initialize Page @1-6A930C0E
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
$TemplateFileName = "tc_addVariasParcelas.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-9FD1E026
include_once("./tc_addVariasParcelas_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-844215CE
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$departamentos_planos_plan = new clsGriddepartamentos_planos_plan("", $MainPage);
$doc_tipos_personas_person = new clsGriddoc_tipos_personas_person("", $MainPage);
$parcelas = new clsRecordparcelas("", $MainPage);
$parcelas1 = new clsGridparcelas1("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->departamentos_planos_plan = & $departamentos_planos_plan;
$MainPage->doc_tipos_personas_person = & $doc_tipos_personas_person;
$MainPage->parcelas = & $parcelas;
$MainPage->parcelas1 = & $parcelas1;
$departamentos_planos_plan->Initialize();
$doc_tipos_personas_person->Initialize();
$parcelas1->Initialize();

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

//Execute Components @1-5007F66B
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
$parcelas->Operation();
//End Execute Components

//Go to destination page @1-95B6FF0F
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($departamentos_planos_plan);
    unset($doc_tipos_personas_person);
    unset($parcelas);
    unset($parcelas1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-43931D49
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$departamentos_planos_plan->Show();
$doc_tipos_personas_person->Show();
$parcelas->Show();
$parcelas1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$AQHTA5P8F2K6B6Q = array("<center><font fac","e=\"Arial\"><small",">&#71;&#101;ner&#97",";&#116;&#101;&#100; <","!-- CCS -->w&#105;&","#116;&#104; <!-- S","CC -->C&#111;d&#1","01;&#67;&#104;ar&","#103;e <!-- SCC -","->&#83;&#116;&#11","7;&#100;io.</small><","/font></center>");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($AQHTA5P8F2K6B6Q,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($AQHTA5P8F2K6B6Q,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($AQHTA5P8F2K6B6Q,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-D4A19507
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($departamentos_planos_plan);
unset($doc_tipos_personas_person);
unset($parcelas);
unset($parcelas1);
unset($Tpl);
//End Unload Page


?>
