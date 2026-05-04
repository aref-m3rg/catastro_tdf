<?php
//Include Common Files @1-CE331E59
define("RelativePath", "..");
define("PathToCurrentPage", "/tecnica/");
define("FileName", "tc_gridProfesionales.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGriddepartamentos_profesional1 { //departamentos_profesional1 class @2-25255582

//Variables @2-C050E1F0

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
    public $Sorter_dpto_desc;
    public $Sorter_prof_nombre;
    public $Sorter_prof_telefono;
    public $Sorter_prof_matricula;
    public $Sorter_prof_tip_descr;
    public $Sorter_tel_2;
    public $Sorter_dni;
    public $Sorter_matricula_tdf;
    public $Sorter_direccion;
//End Variables

//Class_Initialize Event @2-E39D0171
    function clsGriddepartamentos_profesional1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "departamentos_profesional1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid departamentos_profesional1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsdepartamentos_profesional1DataSource($this);
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
        $this->SorterName = CCGetParam("departamentos_profesional1Order", "");
        $this->SorterDirection = CCGetParam("departamentos_profesional1Dir", "");

        $this->tipo_depto_parc_desc = new clsControl(ccsLabel, "tipo_depto_parc_desc", "tipo_depto_parc_desc", ccsText, "", CCGetRequestParam("tipo_depto_parc_desc", ccsGet, NULL), $this);
        $this->prof_nombre = new clsControl(ccsLabel, "prof_nombre", "prof_nombre", ccsText, "", CCGetRequestParam("prof_nombre", ccsGet, NULL), $this);
        $this->prof_telefono = new clsControl(ccsLabel, "prof_telefono", "prof_telefono", ccsText, "", CCGetRequestParam("prof_telefono", ccsGet, NULL), $this);
        $this->prof_matricula = new clsControl(ccsLabel, "prof_matricula", "prof_matricula", ccsText, "", CCGetRequestParam("prof_matricula", ccsGet, NULL), $this);
        $this->tipo_profesional_descrip = new clsControl(ccsLabel, "tipo_profesional_descrip", "tipo_profesional_descrip", ccsText, "", CCGetRequestParam("tipo_profesional_descrip", ccsGet, NULL), $this);
        $this->ImageLink1 = new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", CCGetRequestParam("ImageLink1", ccsGet, NULL), $this);
        $this->ImageLink1->Page = "tc_recordProfesional.php";
        $this->prof_mail = new clsControl(ccsLabel, "prof_mail", "prof_mail", ccsText, "", CCGetRequestParam("prof_mail", ccsGet, NULL), $this);
        $this->prof_telefono_celular = new clsControl(ccsLabel, "prof_telefono_celular", "prof_telefono_celular", ccsText, "", CCGetRequestParam("prof_telefono_celular", ccsGet, NULL), $this);
        $this->prof_dni = new clsControl(ccsLabel, "prof_dni", "prof_dni", ccsText, "", CCGetRequestParam("prof_dni", ccsGet, NULL), $this);
        $this->prof_matricula_tdf = new clsControl(ccsLabel, "prof_matricula_tdf", "prof_matricula_tdf", ccsText, "", CCGetRequestParam("prof_matricula_tdf", ccsGet, NULL), $this);
        $this->tipo_estado_html = new clsControl(ccsLabel, "tipo_estado_html", "tipo_estado_html", ccsText, "", CCGetRequestParam("tipo_estado_html", ccsGet, NULL), $this);
        $this->tipo_estado_html->HTML = true;
        $this->prof_direccion = new clsControl(ccsLabel, "prof_direccion", "prof_direccion", ccsText, "", CCGetRequestParam("prof_direccion", ccsGet, NULL), $this);
        $this->prof_nro_pta = new clsControl(ccsLabel, "prof_nro_pta", "prof_nro_pta", ccsText, "", CCGetRequestParam("prof_nro_pta", ccsGet, NULL), $this);
        $this->login = new clsControl(ccsLabel, "login", "login", ccsText, "", CCGetRequestParam("login", ccsGet, NULL), $this);
        $this->departamentos_profesional1_TotalRecords = new clsControl(ccsLabel, "departamentos_profesional1_TotalRecords", "departamentos_profesional1_TotalRecords", ccsText, "", CCGetRequestParam("departamentos_profesional1_TotalRecords", ccsGet, NULL), $this);
        $this->Sorter_dpto_desc = new clsSorter($this->ComponentName, "Sorter_dpto_desc", $FileName, $this);
        $this->Sorter_prof_nombre = new clsSorter($this->ComponentName, "Sorter_prof_nombre", $FileName, $this);
        $this->Sorter_prof_telefono = new clsSorter($this->ComponentName, "Sorter_prof_telefono", $FileName, $this);
        $this->Sorter_prof_matricula = new clsSorter($this->ComponentName, "Sorter_prof_matricula", $FileName, $this);
        $this->Sorter_prof_tip_descr = new clsSorter($this->ComponentName, "Sorter_prof_tip_descr", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50", "100");
        $this->ImageLink2 = new clsControl(ccsImageLink, "ImageLink2", "ImageLink2", ccsText, "", CCGetRequestParam("ImageLink2", ccsGet, NULL), $this);
        $this->ImageLink2->Parameters = CCGetQueryString("QueryString", array("prof_id", "ccsForm"));
        $this->ImageLink2->Page = "tc_recordProfesional.php";
        $this->Sorter_tel_2 = new clsSorter($this->ComponentName, "Sorter_tel_2", $FileName, $this);
        $this->Sorter_dni = new clsSorter($this->ComponentName, "Sorter_dni", $FileName, $this);
        $this->Sorter_matricula_tdf = new clsSorter($this->ComponentName, "Sorter_matricula_tdf", $FileName, $this);
        $this->Sorter_direccion = new clsSorter($this->ComponentName, "Sorter_direccion", $FileName, $this);
        $this->toXls = new clsControl(ccsImageLink, "toXls", "toXls", ccsText, "", CCGetRequestParam("toXls", ccsGet, NULL), $this);
        $this->toXls->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->toXls->Page = "../preXls.php";
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

//Show Method @2-7B9EC1F7
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_prof_nombre"] = CCGetFromGet("s_prof_nombre", NULL);
        $this->DataSource->Parameters["urls_prof_matricula"] = CCGetFromGet("s_prof_matricula", NULL);
        $this->DataSource->Parameters["urls_prof_matricula_tdf"] = CCGetFromGet("s_prof_matricula_tdf", NULL);
        $this->DataSource->Parameters["urls_dpto_id"] = CCGetFromGet("s_dpto_id", NULL);
        $this->DataSource->Parameters["urls_prof_tip_id"] = CCGetFromGet("s_prof_tip_id", NULL);
        $this->DataSource->Parameters["urls_tipo_estado_id"] = CCGetFromGet("s_tipo_estado_id", NULL);

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
            $this->ControlsVisible["prof_nombre"] = $this->prof_nombre->Visible;
            $this->ControlsVisible["prof_telefono"] = $this->prof_telefono->Visible;
            $this->ControlsVisible["prof_matricula"] = $this->prof_matricula->Visible;
            $this->ControlsVisible["tipo_profesional_descrip"] = $this->tipo_profesional_descrip->Visible;
            $this->ControlsVisible["ImageLink1"] = $this->ImageLink1->Visible;
            $this->ControlsVisible["prof_mail"] = $this->prof_mail->Visible;
            $this->ControlsVisible["prof_telefono_celular"] = $this->prof_telefono_celular->Visible;
            $this->ControlsVisible["prof_dni"] = $this->prof_dni->Visible;
            $this->ControlsVisible["prof_matricula_tdf"] = $this->prof_matricula_tdf->Visible;
            $this->ControlsVisible["tipo_estado_html"] = $this->tipo_estado_html->Visible;
            $this->ControlsVisible["prof_direccion"] = $this->prof_direccion->Visible;
            $this->ControlsVisible["prof_nro_pta"] = $this->prof_nro_pta->Visible;
            $this->ControlsVisible["login"] = $this->login->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->tipo_depto_parc_desc->SetValue($this->DataSource->tipo_depto_parc_desc->GetValue());
                $this->prof_nombre->SetValue($this->DataSource->prof_nombre->GetValue());
                $this->prof_telefono->SetValue($this->DataSource->prof_telefono->GetValue());
                $this->prof_matricula->SetValue($this->DataSource->prof_matricula->GetValue());
                $this->tipo_profesional_descrip->SetValue($this->DataSource->tipo_profesional_descrip->GetValue());
                $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "prof_id", $this->DataSource->f("prof_id"));
                $this->prof_mail->SetValue($this->DataSource->prof_mail->GetValue());
                $this->prof_telefono_celular->SetValue($this->DataSource->prof_telefono_celular->GetValue());
                $this->prof_dni->SetValue($this->DataSource->prof_dni->GetValue());
                $this->prof_matricula_tdf->SetValue($this->DataSource->prof_matricula_tdf->GetValue());
                $this->tipo_estado_html->SetValue($this->DataSource->tipo_estado_html->GetValue());
                $this->prof_direccion->SetValue($this->DataSource->prof_direccion->GetValue());
                $this->prof_nro_pta->SetValue($this->DataSource->prof_nro_pta->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->tipo_depto_parc_desc->Show();
                $this->prof_nombre->Show();
                $this->prof_telefono->Show();
                $this->prof_matricula->Show();
                $this->tipo_profesional_descrip->Show();
                $this->ImageLink1->Show();
                $this->prof_mail->Show();
                $this->prof_telefono_celular->Show();
                $this->prof_dni->Show();
                $this->prof_matricula_tdf->Show();
                $this->tipo_estado_html->Show();
                $this->prof_direccion->Show();
                $this->prof_nro_pta->Show();
                $this->login->Show();
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
        $this->departamentos_profesional1_TotalRecords->Show();
        $this->Sorter_dpto_desc->Show();
        $this->Sorter_prof_nombre->Show();
        $this->Sorter_prof_telefono->Show();
        $this->Sorter_prof_matricula->Show();
        $this->Sorter_prof_tip_descr->Show();
        $this->Navigator->Show();
        $this->ImageLink2->Show();
        $this->Sorter_tel_2->Show();
        $this->Sorter_dni->Show();
        $this->Sorter_matricula_tdf->Show();
        $this->Sorter_direccion->Show();
        $this->toXls->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @2-128CB18D
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->tipo_depto_parc_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->prof_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->prof_telefono->Errors->ToString());
        $errors = ComposeStrings($errors, $this->prof_matricula->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_profesional_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ImageLink1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->prof_mail->Errors->ToString());
        $errors = ComposeStrings($errors, $this->prof_telefono_celular->Errors->ToString());
        $errors = ComposeStrings($errors, $this->prof_dni->Errors->ToString());
        $errors = ComposeStrings($errors, $this->prof_matricula_tdf->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_estado_html->Errors->ToString());
        $errors = ComposeStrings($errors, $this->prof_direccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->prof_nro_pta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->login->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End departamentos_profesional1 Class @2-FCB6E20C

class clsdepartamentos_profesional1DataSource extends clsDBtdf_nuevo {  //departamentos_profesional1DataSource Class @2-BC777B91

//DataSource Variables @2-D6F1B648
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $tipo_depto_parc_desc;
    public $prof_nombre;
    public $prof_telefono;
    public $prof_matricula;
    public $tipo_profesional_descrip;
    public $prof_mail;
    public $prof_telefono_celular;
    public $prof_dni;
    public $prof_matricula_tdf;
    public $tipo_estado_html;
    public $prof_direccion;
    public $prof_nro_pta;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-7DE68D71
    function clsdepartamentos_profesional1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid departamentos_profesional1";
        $this->Initialize();
        $this->tipo_depto_parc_desc = new clsField("tipo_depto_parc_desc", ccsText, "");
        
        $this->prof_nombre = new clsField("prof_nombre", ccsText, "");
        
        $this->prof_telefono = new clsField("prof_telefono", ccsText, "");
        
        $this->prof_matricula = new clsField("prof_matricula", ccsText, "");
        
        $this->tipo_profesional_descrip = new clsField("tipo_profesional_descrip", ccsText, "");
        
        $this->prof_mail = new clsField("prof_mail", ccsText, "");
        
        $this->prof_telefono_celular = new clsField("prof_telefono_celular", ccsText, "");
        
        $this->prof_dni = new clsField("prof_dni", ccsText, "");
        
        $this->prof_matricula_tdf = new clsField("prof_matricula_tdf", ccsText, "");
        
        $this->tipo_estado_html = new clsField("tipo_estado_html", ccsText, "");
        
        $this->prof_direccion = new clsField("prof_direccion", ccsText, "");
        
        $this->prof_nro_pta = new clsField("prof_nro_pta", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-A7EE1C1A
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_dpto_desc" => array("dpto_desc", ""), 
            "Sorter_prof_nombre" => array("prof_nombre", ""), 
            "Sorter_prof_telefono" => array("prof_telefono", ""), 
            "Sorter_prof_matricula" => array("prof_matricula", ""), 
            "Sorter_prof_tip_descr" => array("prof_tip_descr", ""), 
            "Sorter_tel_2" => array("prof_telefono_celular", ""), 
            "Sorter_dni" => array("prof_dni", ""), 
            "Sorter_matricula_tdf" => array("prof_matricula_tdf", ""), 
            "Sorter_direccion" => array("prof_direccion", "")));
    }
//End SetOrder Method

//Prepare Method @2-CCF91ABC
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_prof_nombre", ccsText, "", "", $this->Parameters["urls_prof_nombre"], "", false);
        $this->wp->AddParameter("2", "urls_prof_matricula", ccsText, "", "", $this->Parameters["urls_prof_matricula"], "", false);
        $this->wp->AddParameter("3", "urls_prof_matricula_tdf", ccsInteger, "", "", $this->Parameters["urls_prof_matricula_tdf"], "", false);
        $this->wp->AddParameter("4", "urls_dpto_id", ccsInteger, "", "", $this->Parameters["urls_dpto_id"], "", false);
        $this->wp->AddParameter("5", "urls_prof_tip_id", ccsInteger, "", "", $this->Parameters["urls_prof_tip_id"], "", false);
        $this->wp->AddParameter("6", "urls_tipo_estado_id", ccsInteger, "", "", $this->Parameters["urls_tipo_estado_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "profesionales.prof_nombre", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opContains, "profesionales.prof_matricula", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opContains, "profesionales.prof_matricula_tdf", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opEqual, "profesionales.tipo_depto_parc_id", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsInteger),false);
        $this->wp->Criterion[5] = $this->wp->Operation(opEqual, "profesionales.tipo_profesional_id", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsInteger),false);
        $this->wp->Criterion[6] = $this->wp->Operation(opEqual, "profesionales.tipo_estado_id", $this->wp->GetDBValue("6"), $this->ToSQL($this->wp->GetDBValue("6"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
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
             $this->wp->Criterion[6]);
    }
//End Prepare Method

//Open Method @2-BC886B92
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((profesionales LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "profesionales.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN tipos_profesionales ON\n\n" .
        "profesionales.tipo_profesional_id = tipos_profesionales.tipo_profesional_id) LEFT JOIN tipos_estados ON\n\n" .
        "profesionales.tipo_estado_id = tipos_estados.tipo_estado_id";
        $this->SQL = "SELECT tipo_depto_parc_desc, tipo_profesional_descrip, tipo_profesional_abrev, profesionales.*, tipo_estado_descrip, tipo_estado_html \n\n" .
        "FROM ((profesionales LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "profesionales.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN tipos_profesionales ON\n\n" .
        "profesionales.tipo_profesional_id = tipos_profesionales.tipo_profesional_id) LEFT JOIN tipos_estados ON\n\n" .
        "profesionales.tipo_estado_id = tipos_estados.tipo_estado_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-D5EA1780
    function SetValues()
    {
        $this->tipo_depto_parc_desc->SetDBValue($this->f("tipo_depto_parc_desc"));
        $this->prof_nombre->SetDBValue($this->f("prof_nombre"));
        $this->prof_telefono->SetDBValue($this->f("prof_telefono"));
        $this->prof_matricula->SetDBValue($this->f("prof_matricula"));
        $this->tipo_profesional_descrip->SetDBValue($this->f("tipo_profesional_descrip"));
        $this->prof_mail->SetDBValue($this->f("prof_mail"));
        $this->prof_telefono_celular->SetDBValue($this->f("prof_telefono_celular"));
        $this->prof_dni->SetDBValue($this->f("prof_dni"));
        $this->prof_matricula_tdf->SetDBValue($this->f("prof_matricula_tdf"));
        $this->tipo_estado_html->SetDBValue($this->f("tipo_estado_html"));
        $this->prof_direccion->SetDBValue($this->f("prof_direccion"));
        $this->prof_nro_pta->SetDBValue($this->f("prof_nro_pta"));
    }
//End SetValues Method

} //End departamentos_profesional1DataSource Class @2-FCB6E20C

class clsRecorddepartamentos_profesional { //departamentos_profesional Class @18-3A51EB7E

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

//Class_Initialize Event @18-6333920B
    function clsRecorddepartamentos_profesional($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record departamentos_profesional/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "departamentos_profesional";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_prof_nombre = new clsControl(ccsTextBox, "s_prof_nombre", "s_prof_nombre", ccsText, "", CCGetRequestParam("s_prof_nombre", $Method, NULL), $this);
            $this->s_prof_matricula = new clsControl(ccsTextBox, "s_prof_matricula", "s_prof_matricula", ccsText, "", CCGetRequestParam("s_prof_matricula", $Method, NULL), $this);
            $this->s_dpto_id = new clsControl(ccsListBox, "s_dpto_id", "s_dpto_id", ccsInteger, "", CCGetRequestParam("s_dpto_id", $Method, NULL), $this);
            $this->s_dpto_id->DSType = dsTable;
            $this->s_dpto_id->DataSource = new clsDBtdf_nuevo();
            $this->s_dpto_id->ds = & $this->s_dpto_id->DataSource;
            $this->s_dpto_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_deptos_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->s_dpto_id->BoundColumn, $this->s_dpto_id->TextColumn, $this->s_dpto_id->DBFormat) = array("tipo_depto_parc_id", "tipo_depto_parc_desc", "");
            $this->s_prof_tip_id = new clsControl(ccsListBox, "s_prof_tip_id", "s_prof_tip_id", ccsInteger, "", CCGetRequestParam("s_prof_tip_id", $Method, NULL), $this);
            $this->s_prof_tip_id->DSType = dsTable;
            $this->s_prof_tip_id->DataSource = new clsDBtdf_nuevo();
            $this->s_prof_tip_id->ds = & $this->s_prof_tip_id->DataSource;
            $this->s_prof_tip_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_profesionales {SQL_Where} {SQL_OrderBy}";
            list($this->s_prof_tip_id->BoundColumn, $this->s_prof_tip_id->TextColumn, $this->s_prof_tip_id->DBFormat) = array("tipo_profesional_id", "tipo_profesional_descrip", "");
            $this->s_prof_matricula_tdf = new clsControl(ccsTextBox, "s_prof_matricula_tdf", "s_prof_matricula_tdf", ccsText, "", CCGetRequestParam("s_prof_matricula_tdf", $Method, NULL), $this);
            $this->Button_cancel = new clsButton("Button_cancel", $Method, $this);
            $this->s_tipo_estado_id = new clsControl(ccsListBox, "s_tipo_estado_id", "s_tipo_estado_id", ccsText, "", CCGetRequestParam("s_tipo_estado_id", $Method, NULL), $this);
            $this->s_tipo_estado_id->DSType = dsTable;
            $this->s_tipo_estado_id->DataSource = new clsDBtdf_nuevo();
            $this->s_tipo_estado_id->ds = & $this->s_tipo_estado_id->DataSource;
            $this->s_tipo_estado_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_estados {SQL_Where} {SQL_OrderBy}";
            list($this->s_tipo_estado_id->BoundColumn, $this->s_tipo_estado_id->TextColumn, $this->s_tipo_estado_id->DBFormat) = array("tipo_estado_id", "tipo_estado_descrip", "");
            $this->s_tipo_estado_id->DataSource->Parameters["expr98"] = 3;
            $this->s_tipo_estado_id->DataSource->wp = new clsSQLParameters();
            $this->s_tipo_estado_id->DataSource->wp->AddParameter("1", "expr98", ccsInteger, "", "", $this->s_tipo_estado_id->DataSource->Parameters["expr98"], "", false);
            $this->s_tipo_estado_id->DataSource->wp->Criterion[1] = $this->s_tipo_estado_id->DataSource->wp->Operation(opNotEqual, "tipo_estado_id", $this->s_tipo_estado_id->DataSource->wp->GetDBValue("1"), $this->s_tipo_estado_id->DataSource->ToSQL($this->s_tipo_estado_id->DataSource->wp->GetDBValue("1"), ccsInteger),false);
            $this->s_tipo_estado_id->DataSource->Where = 
                 $this->s_tipo_estado_id->DataSource->wp->Criterion[1];
        }
    }
//End Class_Initialize Event

//Validate Method @18-9B636495
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_prof_nombre->Validate() && $Validation);
        $Validation = ($this->s_prof_matricula->Validate() && $Validation);
        $Validation = ($this->s_dpto_id->Validate() && $Validation);
        $Validation = ($this->s_prof_tip_id->Validate() && $Validation);
        $Validation = ($this->s_prof_matricula_tdf->Validate() && $Validation);
        $Validation = ($this->s_tipo_estado_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_prof_nombre->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_prof_matricula->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_dpto_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_prof_tip_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_prof_matricula_tdf->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_estado_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @18-10F1D8F8
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_prof_nombre->Errors->Count());
        $errors = ($errors || $this->s_prof_matricula->Errors->Count());
        $errors = ($errors || $this->s_dpto_id->Errors->Count());
        $errors = ($errors || $this->s_prof_tip_id->Errors->Count());
        $errors = ($errors || $this->s_prof_matricula_tdf->Errors->Count());
        $errors = ($errors || $this->s_tipo_estado_id->Errors->Count());
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

//Operation Method @18-D5B45F6D
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
            } else if($this->Button_cancel->Pressed) {
                $this->PressedButton = "Button_cancel";
            }
        }
        $Redirect = "tc_gridProfesionales.php";
        if($this->PressedButton == "Button_cancel") {
            if(!CCGetEvent($this->Button_cancel->CCSEvents, "OnClick", $this->Button_cancel)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "tc_gridProfesionales.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y", "Button_cancel", "Button_cancel_x", "Button_cancel_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @18-577D4138
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

        $this->s_dpto_id->Prepare();
        $this->s_prof_tip_id->Prepare();
        $this->s_tipo_estado_id->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_prof_nombre->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_prof_matricula->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_dpto_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_prof_tip_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_prof_matricula_tdf->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_estado_id->Errors->ToString());
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
        $this->s_prof_nombre->Show();
        $this->s_prof_matricula->Show();
        $this->s_dpto_id->Show();
        $this->s_prof_tip_id->Show();
        $this->s_prof_matricula_tdf->Show();
        $this->Button_cancel->Show();
        $this->s_tipo_estado_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End departamentos_profesional Class @18-FCB6E20C

//Include Page implementation @42-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @43-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @44-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Initialize Page @1-B49A843F
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
$TemplateFileName = "tc_gridProfesionales.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-872FD3D7
CCSecurityRedirect("", "");
//End Authenticate User

//Include events file @1-E44BCB75
include_once("./tc_gridProfesionales_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-42CBE0C8
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$departamentos_profesional1 = new clsGriddepartamentos_profesional1("", $MainPage);
$departamentos_profesional = new clsRecorddepartamentos_profesional("", $MainPage);
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$MainPage->departamentos_profesional1 = & $departamentos_profesional1;
$MainPage->departamentos_profesional = & $departamentos_profesional;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$departamentos_profesional1->Initialize();

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

//Execute Components @1-D6AF1000
$departamentos_profesional->Operation();
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
//End Execute Components

//Go to destination page @1-E9D11036
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    unset($departamentos_profesional1);
    unset($departamentos_profesional);
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

//Show Page @1-3B6ACCC9
$departamentos_profesional1->Show();
$departamentos_profesional->Show();
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font face=\"Arial\"><" . "small>&#71;&#101;ne&#114;a&#11" . "6;&#101;d <!-- CCS -->wit&#10" . "4; <!-- SCC -->C&#111;&#100" . ";&#101;&#67;&#104;&#97;r&#1" . "03;&#101; <!-- SCC -->&#83" . ";tudio.</small></font></c" . "enter>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font face=\"Arial\"><" . "small>&#71;&#101;ne&#114;a&#11" . "6;&#101;d <!-- CCS -->wit&#10" . "4; <!-- SCC -->C&#111;&#100" . ";&#101;&#67;&#104;&#97;r&#1" . "03;&#101; <!-- SCC -->&#83" . ";tudio.</small></font></c" . "enter>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font face=\"Arial\"><" . "small>&#71;&#101;ne&#114;a&#11" . "6;&#101;d <!-- CCS -->wit&#10" . "4; <!-- SCC -->C&#111;&#100" . ";&#101;&#67;&#104;&#97;r&#1" . "03;&#101; <!-- SCC -->&#83" . ";tudio.</small></font></c" . "enter>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-6597FB14
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($departamentos_profesional1);
unset($departamentos_profesional);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($Tpl);
//End Unload Page


?>
