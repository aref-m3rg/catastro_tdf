<?php
//Include Common Files @1-EECA8E66
define("RelativePath", "..");
define("PathToCurrentPage", "/gestion/");
define("FileName", "gridMejoras.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridmejoras_tipos_mejoras_tip { //mejoras_tipos_mejoras_tip class @6-6D72C1D5

//Variables @6-17A5F488

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
    public $Sorter_tipo_mejora_abrev;
    public $Sorter_tipo_mejora_destino_abrev;
    public $Sorter_expte;
    public $Sorter_mejora_sup_cub;
    public $Sorter_mejora_sup_semi_cub;
    public $Sorter_mejora_fecha_exp;
    public $Sorter_mejora_form;
    public $Sorter_mejora_valuacion;
    public $Sorter_mejora_sup_cub1;
    public $Sorter_tipo_estado_html;
//End Variables

//Class_Initialize Event @6-F159166A
    function clsGridmejoras_tipos_mejoras_tip($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "mejoras_tipos_mejoras_tip";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid mejoras_tipos_mejoras_tip";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsmejoras_tipos_mejoras_tipDataSource($this);
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
        $this->SorterName = CCGetParam("mejoras_tipos_mejoras_tipOrder", "");
        $this->SorterDirection = CCGetParam("mejoras_tipos_mejoras_tipDir", "");

        $this->mejora_anio_construccion = new clsControl(ccsLabel, "mejora_anio_construccion", "mejora_anio_construccion", ccsText, "", CCGetRequestParam("mejora_anio_construccion", ccsGet, NULL), $this);
        $this->mejora_anio_construccion->HTML = true;
        $this->destino = new clsControl(ccsLabel, "destino", "destino", ccsText, "", CCGetRequestParam("destino", ccsGet, NULL), $this);
        $this->expte = new clsControl(ccsLabel, "expte", "expte", ccsText, "", CCGetRequestParam("expte", ccsGet, NULL), $this);
        $this->editMejora = new clsControl(ccsImageLink, "editMejora", "editMejora", ccsText, "", CCGetRequestParam("editMejora", ccsGet, NULL), $this);
        $this->editMejora->Page = "";
        $this->mejora_sup_cub = new clsControl(ccsLabel, "mejora_sup_cub", "mejora_sup_cub", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("mejora_sup_cub", ccsGet, NULL), $this);
        $this->mejora_sup_semi_cub = new clsControl(ccsLabel, "mejora_sup_semi_cub", "mejora_sup_semi_cub", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("mejora_sup_semi_cub", ccsGet, NULL), $this);
        $this->porc = new clsControl(ccsLabel, "porc", "porc", ccsText, "", CCGetRequestParam("porc", ccsGet, NULL), $this);
        $this->mejora_f_alta = new clsControl(ccsLabel, "mejora_f_alta", "mejora_f_alta", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("mejora_f_alta", ccsGet, NULL), $this);
        $this->tipo_estado_html = new clsControl(ccsLabel, "tipo_estado_html", "tipo_estado_html", ccsText, "", CCGetRequestParam("tipo_estado_html", ccsGet, NULL), $this);
        $this->tipo_estado_html->HTML = true;
        $this->este = new clsControl(ccsImageLink, "este", "este", ccsText, "", CCGetRequestParam("este", ccsGet, NULL), $this);
        $this->este->Page = "";
        $this->mejora_form = new clsControl(ccsLabel, "mejora_form", "mejora_form", ccsText, "", CCGetRequestParam("mejora_form", ccsGet, NULL), $this);
        $this->mejora_valuacion = new clsControl(ccsLabel, "mejora_valuacion", "mejora_valuacion", ccsText, "", CCGetRequestParam("mejora_valuacion", ccsGet, NULL), $this);
        $this->pdfE2 = new clsControl(ccsImageLink, "pdfE2", "pdfE2", ccsText, "", CCGetRequestParam("pdfE2", ccsGet, NULL), $this);
        $this->pdfE2->Page = "../reportes/E2.php";
        $this->pdfE1 = new clsControl(ccsImageLink, "pdfE1", "pdfE1", ccsText, "", CCGetRequestParam("pdfE1", ccsGet, NULL), $this);
        $this->pdfE1->Page = "../reportes/E1.php";
        $this->mejora_sup_cub_2 = new clsControl(ccsLabel, "mejora_sup_cub_2", "mejora_sup_cub_2", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("mejora_sup_cub_2", ccsGet, NULL), $this);
        $this->tipo_mejora_html = new clsControl(ccsLabel, "tipo_mejora_html", "tipo_mejora_html", ccsText, "", CCGetRequestParam("tipo_mejora_html", ccsGet, NULL), $this);
        $this->tipo_mejora_html->HTML = true;
        $this->mejoras_tipos_mejoras_tip_TotalRecords = new clsControl(ccsLabel, "mejoras_tipos_mejoras_tip_TotalRecords", "mejoras_tipos_mejoras_tip_TotalRecords", ccsText, "", CCGetRequestParam("mejoras_tipos_mejoras_tip_TotalRecords", ccsGet, NULL), $this);
        $this->Sorter_tipo_mejora_abrev = new clsSorter($this->ComponentName, "Sorter_tipo_mejora_abrev", $FileName, $this);
        $this->Sorter_tipo_mejora_destino_abrev = new clsSorter($this->ComponentName, "Sorter_tipo_mejora_destino_abrev", $FileName, $this);
        $this->Sorter_expte = new clsSorter($this->ComponentName, "Sorter_expte", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Sorter_mejora_sup_cub = new clsSorter($this->ComponentName, "Sorter_mejora_sup_cub", $FileName, $this);
        $this->Sorter_mejora_sup_semi_cub = new clsSorter($this->ComponentName, "Sorter_mejora_sup_semi_cub", $FileName, $this);
        $this->sum_sup_cub = new clsControl(ccsLabel, "sum_sup_cub", "sum_sup_cub", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("sum_sup_cub", ccsGet, NULL), $this);
        $this->sum_sup_semi_cub = new clsControl(ccsLabel, "sum_sup_semi_cub", "sum_sup_semi_cub", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("sum_sup_semi_cub", ccsGet, NULL), $this);
        $this->sup_total = new clsControl(ccsLabel, "sup_total", "sup_total", ccsText, "", CCGetRequestParam("sup_total", ccsGet, NULL), $this);
        $this->sup_total->HTML = true;
        $this->Sorter_mejora_fecha_exp = new clsSorter($this->ComponentName, "Sorter_mejora_fecha_exp", $FileName, $this);
        $this->Sorter_mejora_form = new clsSorter($this->ComponentName, "Sorter_mejora_form", $FileName, $this);
        $this->val_total = new clsControl(ccsLabel, "val_total", "val_total", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("val_total", ccsGet, NULL), $this);
        $this->Sorter_mejora_valuacion = new clsSorter($this->ComponentName, "Sorter_mejora_valuacion", $FileName, $this);
        $this->Sorter_mejora_sup_cub1 = new clsSorter($this->ComponentName, "Sorter_mejora_sup_cub1", $FileName, $this);
        $this->sum_sup_cub_2 = new clsControl(ccsLabel, "sum_sup_cub_2", "sum_sup_cub_2", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("sum_sup_cub_2", ccsGet, NULL), $this);
        $this->Sorter_tipo_estado_html = new clsSorter($this->ComponentName, "Sorter_tipo_estado_html", $FileName, $this);
    }
//End Class_Initialize Event

//Initialize Method @6-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @6-91809501
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlparcela_id"] = CCGetFromGet("parcela_id", NULL);

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
            $this->ControlsVisible["mejora_anio_construccion"] = $this->mejora_anio_construccion->Visible;
            $this->ControlsVisible["destino"] = $this->destino->Visible;
            $this->ControlsVisible["expte"] = $this->expte->Visible;
            $this->ControlsVisible["editMejora"] = $this->editMejora->Visible;
            $this->ControlsVisible["mejora_sup_cub"] = $this->mejora_sup_cub->Visible;
            $this->ControlsVisible["mejora_sup_semi_cub"] = $this->mejora_sup_semi_cub->Visible;
            $this->ControlsVisible["porc"] = $this->porc->Visible;
            $this->ControlsVisible["mejora_f_alta"] = $this->mejora_f_alta->Visible;
            $this->ControlsVisible["tipo_estado_html"] = $this->tipo_estado_html->Visible;
            $this->ControlsVisible["este"] = $this->este->Visible;
            $this->ControlsVisible["mejora_form"] = $this->mejora_form->Visible;
            $this->ControlsVisible["mejora_valuacion"] = $this->mejora_valuacion->Visible;
            $this->ControlsVisible["pdfE2"] = $this->pdfE2->Visible;
            $this->ControlsVisible["pdfE1"] = $this->pdfE1->Visible;
            $this->ControlsVisible["mejora_sup_cub_2"] = $this->mejora_sup_cub_2->Visible;
            $this->ControlsVisible["tipo_mejora_html"] = $this->tipo_mejora_html->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->mejora_anio_construccion->SetValue($this->DataSource->mejora_anio_construccion->GetValue());
                $this->destino->SetValue($this->DataSource->destino->GetValue());
                $this->expte->SetValue($this->DataSource->expte->GetValue());
                $this->editMejora->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->editMejora->Parameters = CCAddParam($this->editMejora->Parameters, "mejora_id", $this->DataSource->f("mejora_id"));
                $this->editMejora->Parameters = CCAddParam($this->editMejora->Parameters, "add", 0);
                $this->editMejora->Parameters = CCAddParam($this->editMejora->Parameters, "f", $this->DataSource->f("mejora_form"));
                $this->mejora_sup_cub->SetValue($this->DataSource->mejora_sup_cub->GetValue());
                $this->mejora_sup_semi_cub->SetValue($this->DataSource->mejora_sup_semi_cub->GetValue());
                $this->mejora_f_alta->SetValue($this->DataSource->mejora_f_alta->GetValue());
                $this->tipo_estado_html->SetValue($this->DataSource->tipo_estado_html->GetValue());
                $this->este->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->este->Parameters = CCAddParam($this->este->Parameters, "mejora_id", $this->DataSource->f("mejora_id"));
                $this->este->Parameters = CCAddParam($this->este->Parameters, "add", 0);
                $this->mejora_form->SetValue($this->DataSource->mejora_form->GetValue());
                $this->mejora_valuacion->SetValue($this->DataSource->mejora_valuacion->GetValue());
                $this->pdfE2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->pdfE2->Parameters = CCAddParam($this->pdfE2->Parameters, "mejora_id", $this->DataSource->f("mejora_id"));
                $this->pdfE1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->pdfE1->Parameters = CCAddParam($this->pdfE1->Parameters, "mejora_id", $this->DataSource->f("mejora_id"));
                $this->mejora_sup_cub_2->SetValue($this->DataSource->mejora_sup_cub_2->GetValue());
                $this->tipo_mejora_html->SetValue($this->DataSource->tipo_mejora_html->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->mejora_anio_construccion->Show();
                $this->destino->Show();
                $this->expte->Show();
                $this->editMejora->Show();
                $this->mejora_sup_cub->Show();
                $this->mejora_sup_semi_cub->Show();
                $this->porc->Show();
                $this->mejora_f_alta->Show();
                $this->tipo_estado_html->Show();
                $this->este->Show();
                $this->mejora_form->Show();
                $this->mejora_valuacion->Show();
                $this->pdfE2->Show();
                $this->pdfE1->Show();
                $this->mejora_sup_cub_2->Show();
                $this->tipo_mejora_html->Show();
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
        $this->mejoras_tipos_mejoras_tip_TotalRecords->Show();
        $this->Sorter_tipo_mejora_abrev->Show();
        $this->Sorter_tipo_mejora_destino_abrev->Show();
        $this->Sorter_expte->Show();
        $this->Navigator->Show();
        $this->Sorter_mejora_sup_cub->Show();
        $this->Sorter_mejora_sup_semi_cub->Show();
        $this->sum_sup_cub->Show();
        $this->sum_sup_semi_cub->Show();
        $this->sup_total->Show();
        $this->Sorter_mejora_fecha_exp->Show();
        $this->Sorter_mejora_form->Show();
        $this->val_total->Show();
        $this->Sorter_mejora_valuacion->Show();
        $this->Sorter_mejora_sup_cub1->Show();
        $this->sum_sup_cub_2->Show();
        $this->Sorter_tipo_estado_html->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @6-D10C0B4D
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->mejora_anio_construccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->destino->Errors->ToString());
        $errors = ComposeStrings($errors, $this->expte->Errors->ToString());
        $errors = ComposeStrings($errors, $this->editMejora->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_sup_cub->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_sup_semi_cub->Errors->ToString());
        $errors = ComposeStrings($errors, $this->porc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_f_alta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_estado_html->Errors->ToString());
        $errors = ComposeStrings($errors, $this->este->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_form->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_valuacion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pdfE2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pdfE1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_sup_cub_2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_mejora_html->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End mejoras_tipos_mejoras_tip Class @6-FCB6E20C

class clsmejoras_tipos_mejoras_tipDataSource extends clsDBtdf_nuevo {  //mejoras_tipos_mejoras_tipDataSource Class @6-051B96F0

//DataSource Variables @6-DBD2C55C
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $mejora_anio_construccion;
    public $destino;
    public $expte;
    public $mejora_sup_cub;
    public $mejora_sup_semi_cub;
    public $mejora_f_alta;
    public $tipo_estado_html;
    public $mejora_form;
    public $mejora_valuacion;
    public $mejora_sup_cub_2;
    public $tipo_mejora_html;
//End DataSource Variables

//DataSourceClass_Initialize Event @6-77E50D20
    function clsmejoras_tipos_mejoras_tipDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid mejoras_tipos_mejoras_tip";
        $this->Initialize();
        $this->mejora_anio_construccion = new clsField("mejora_anio_construccion", ccsText, "");
        
        $this->destino = new clsField("destino", ccsText, "");
        
        $this->expte = new clsField("expte", ccsText, "");
        
        $this->mejora_sup_cub = new clsField("mejora_sup_cub", ccsFloat, "");
        
        $this->mejora_sup_semi_cub = new clsField("mejora_sup_semi_cub", ccsFloat, "");
        
        $this->mejora_f_alta = new clsField("mejora_f_alta", ccsDate, $this->DateFormat);
        
        $this->tipo_estado_html = new clsField("tipo_estado_html", ccsText, "");
        
        $this->mejora_form = new clsField("mejora_form", ccsText, "");
        
        $this->mejora_valuacion = new clsField("mejora_valuacion", ccsText, "");
        
        $this->mejora_sup_cub_2 = new clsField("mejora_sup_cub_2", ccsFloat, "");
        
        $this->tipo_mejora_html = new clsField("tipo_mejora_html", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @6-89A28738
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "mejoras.mejora_f_alta desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_tipo_mejora_abrev" => array("tipo_mejora_abrev", ""), 
            "Sorter_tipo_mejora_destino_abrev" => array("tipo_mejora_destino_abrev", ""), 
            "Sorter_expte" => array("expte", ""), 
            "Sorter_mejora_sup_cub" => array("mejora_sup_cub", ""), 
            "Sorter_mejora_sup_semi_cub" => array("mejora_sup_semi_cub", ""), 
            "Sorter_mejora_fecha_exp" => array("mejora_fecha_exp", ""), 
            "Sorter_mejora_form" => array("mejora_form", ""), 
            "Sorter_mejora_valuacion" => array("mejora_valuacion", ""), 
            "Sorter_mejora_sup_cub1" => array("mejora_sup_cub_2", ""), 
            "Sorter_tipo_estado_html" => array("tipo_mejora_html", "")));
    }
//End SetOrder Method

//Prepare Method @6-3DBF6AA5
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlparcela_id", ccsInteger, "", "", $this->Parameters["urlparcela_id"], -1, false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "mejoras.parcela_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @6-574A16DA
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (((mejoras LEFT JOIN tipos_mejoras_estados ON\n\n" .
        "mejoras.tipo_mejora_estado_id = tipos_mejoras_estados.tipo_mejora_estado_id) LEFT JOIN tipos_mejoras_destinos ON\n\n" .
        "mejoras.tipo_mejora_destino_id = tipos_mejoras_destinos.tipo_mejora_destino_id) LEFT JOIN tipos_estados ON\n\n" .
        "mejoras.tipo_estado_id = tipos_estados.tipo_estado_id) LEFT JOIN tipos_mejoras ON\n\n" .
        "mejoras.tipo_mejora_id = tipos_mejoras.tipo_mejora_id";
        $this->SQL = "SELECT tipos_mejoras_estados.tipo_mejora_estado_abrev AS tipos_mejoras_estados_tipo_mejora_estado_abrev, tipo_mejora_destino_abrev,\n\n" .
        "mejora_id, CONCAT_WS('-',mejora_nro_exp,mejora_letra_exp,YEAR(mejora_fecha_exp)) AS expte, IF((mejora_sup_cub > 0 AND mejora_sup_cub_2 >0 AND mejora_sup_semi_cub),'Vivienda, Edificio',tipo_mejora_destino_descrip) AS destino,\n\n" .
        "tipo_mejora_estado_descrip, mejora_sup_cub, mejora_sup_semi_cub, mejora_f_alta, tipo_estado_html, mejora_nro_nota, mejora_form,\n\n" .
        "mejora_valuacion, mejora_sup_cub_2, IF(mejora_anio_construccion > 0,mejora_anio_construccion,mejora_anio_construccion_3) AS mejora_anio_construccion,\n\n" .
        "tipo_mejora_destino_descrip, tipo_mejora_html \n\n" .
        "FROM (((mejoras LEFT JOIN tipos_mejoras_estados ON\n\n" .
        "mejoras.tipo_mejora_estado_id = tipos_mejoras_estados.tipo_mejora_estado_id) LEFT JOIN tipos_mejoras_destinos ON\n\n" .
        "mejoras.tipo_mejora_destino_id = tipos_mejoras_destinos.tipo_mejora_destino_id) LEFT JOIN tipos_estados ON\n\n" .
        "mejoras.tipo_estado_id = tipos_estados.tipo_estado_id) LEFT JOIN tipos_mejoras ON\n\n" .
        "mejoras.tipo_mejora_id = tipos_mejoras.tipo_mejora_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @6-D7853C5D
    function SetValues()
    {
        $this->mejora_anio_construccion->SetDBValue($this->f("mejora_anio_construccion"));
        $this->destino->SetDBValue($this->f("destino"));
        $this->expte->SetDBValue($this->f("expte"));
        $this->mejora_sup_cub->SetDBValue(trim($this->f("mejora_sup_cub")));
        $this->mejora_sup_semi_cub->SetDBValue(trim($this->f("mejora_sup_semi_cub")));
        $this->mejora_f_alta->SetDBValue(trim($this->f("mejora_f_alta")));
        $this->tipo_estado_html->SetDBValue($this->f("tipo_estado_html"));
        $this->mejora_form->SetDBValue($this->f("mejora_form"));
        $this->mejora_valuacion->SetDBValue($this->f("mejora_valuacion"));
        $this->mejora_sup_cub_2->SetDBValue(trim($this->f("mejora_sup_cub_2")));
        $this->tipo_mejora_html->SetDBValue($this->f("tipo_mejora_html"));
    }
//End SetValues Method

} //End mejoras_tipos_mejoras_tipDataSource Class @6-FCB6E20C

class clsRecordmejoras { //mejoras Class @64-4D6BE1C1

//Variables @64-9E315808

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

//Class_Initialize Event @64-6D27A1B0
    function clsRecordmejoras($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record mejoras/Error";
        $this->DataSource = new clsmejorasDataSource($this);
        $this->ds = & $this->DataSource;
        $this->ReadAllowed = true;
        $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
        if($this->Visible)
        {
            $this->ReadAllowed = $this->ReadAllowed && CCUserInGroups(CCGetGroupID(), "1;2");
            $this->InsertAllowed = CCUserInGroups(CCGetGroupID(), "2");
            $this->UpdateAllowed = CCUserInGroups(CCGetGroupID(), "2");
            $this->ComponentName = "mejoras";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->Button_Delete = new clsButton("Button_Delete", $Method, $this);
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->parcela_id = new clsControl(ccsHidden, "parcela_id", "Parcela Id", ccsInteger, "", CCGetRequestParam("parcela_id", $Method, NULL), $this);
            $this->mejora_nro_exp = new clsControl(ccsTextBox, "mejora_nro_exp", "Nro Exp", ccsInteger, "", CCGetRequestParam("mejora_nro_exp", $Method, NULL), $this);
            $this->mejora_observacion = new clsControl(ccsTextBox, "mejora_observacion", "Observacion", ccsText, "", CCGetRequestParam("mejora_observacion", $Method, NULL), $this);
            $this->mejora_letra_exp = new clsControl(ccsTextBox, "mejora_letra_exp", "Letra Exp", ccsText, "", CCGetRequestParam("mejora_letra_exp", $Method, NULL), $this);
            $this->mejora_fecha_exp = new clsControl(ccsTextBox, "mejora_fecha_exp", "Fecha Exp", ccsDate, $DefaultDateFormat, CCGetRequestParam("mejora_fecha_exp", $Method, NULL), $this);
            $this->DatePicker_mejora_fecha_exp = new clsDatePicker("DatePicker_mejora_fecha_exp", "mejoras", "mejora_fecha_exp", $this);
            $this->mejora_categoria_dpc = new clsControl(ccsHidden, "mejora_categoria_dpc", "Categoria Dpc", ccsInteger, "", CCGetRequestParam("mejora_categoria_dpc", $Method, NULL), $this);
            $this->mejora_f_pro = new clsControl(ccsHidden, "mejora_f_pro", "F Pro", ccsText, "", CCGetRequestParam("mejora_f_pro", $Method, NULL), $this);
            $this->mejora_f_pro->Required = true;
            $this->audit_string = new clsControl(ccsHidden, "audit_string", "audit_string", ccsText, "", CCGetRequestParam("audit_string", $Method, NULL), $this);
            $this->tipo_estado_id = new clsControl(ccsHidden, "tipo_estado_id", "tipo_estado_id", ccsInteger, "", CCGetRequestParam("tipo_estado_id", $Method, NULL), $this);
            $this->baja = new clsControl(ccsLabel, "baja", "baja", ccsText, "", CCGetRequestParam("baja", $Method, NULL), $this);
            $this->baja->HTML = true;
            $this->sup_terreno = new clsControl(ccsHidden, "sup_terreno", "sup_terreno", ccsFloat, "", CCGetRequestParam("sup_terreno", $Method, NULL), $this);
            $this->Button_alta = new clsButton("Button_alta", $Method, $this);
            $this->mejora_f_baja = new clsControl(ccsHidden, "mejora_f_baja", "mejora_f_baja", ccsText, "", CCGetRequestParam("mejora_f_baja", $Method, NULL), $this);
            $this->mejora_nro_nota = new clsControl(ccsTextBox, "mejora_nro_nota", "mejora_nro_nota", ccsText, "", CCGetRequestParam("mejora_nro_nota", $Method, NULL), $this);
            $this->mejora_id = new clsControl(ccsHidden, "mejora_id", "mejora_id", ccsText, "", CCGetRequestParam("mejora_id", $Method, NULL), $this);
            $this->motivo_baja = new clsControl(ccsLabel, "motivo_baja", "motivo_baja", ccsText, "", CCGetRequestParam("motivo_baja", $Method, NULL), $this);
            $this->motivo_baja->HTML = true;
            $this->cantE2B = new clsControl(ccsTextBox, "cantE2B", "cantE2B", ccsInteger, "", CCGetRequestParam("cantE2B", $Method, NULL), $this);
            $this->cantE2C = new clsControl(ccsTextBox, "cantE2C", "cantE2C", ccsInteger, "", CCGetRequestParam("cantE2C", $Method, NULL), $this);
            $this->cantE2T = new clsControl(ccsTextBox, "cantE2T", "cantE2T", ccsInteger, "", CCGetRequestParam("cantE2T", $Method, NULL), $this);
            $this->valE2B = new clsControl(ccsTextBox, "valE2B", "valE2B", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("valE2B", $Method, NULL), $this);
            $this->valE2C = new clsControl(ccsTextBox, "valE2C", "valE2C", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("valE2C", $Method, NULL), $this);
            $this->calE2T = new clsControl(ccsTextBox, "calE2T", "calE2T", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("calE2T", $Method, NULL), $this);
            $this->calE2B = new clsControl(ccsTextBox, "calE2B", "calE2B", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("calE2B", $Method, NULL), $this);
            $this->calE2C = new clsControl(ccsTextBox, "calE2C", "calE2C", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("calE2C", $Method, NULL), $this);
            $this->vuE2T = new clsControl(ccsTextBox, "vuE2T", "vuE2T", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("vuE2T", $Method, NULL), $this);
            $this->tipo_mejora_conserva_id = new clsControl(ccsListBox, "tipo_mejora_conserva_id", "Conservacion", ccsInteger, "", CCGetRequestParam("tipo_mejora_conserva_id", $Method, NULL), $this);
            $this->tipo_mejora_conserva_id->DSType = dsTable;
            $this->tipo_mejora_conserva_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_mejora_conserva_id->ds = & $this->tipo_mejora_conserva_id->DataSource;
            $this->tipo_mejora_conserva_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_mejoras_conserva {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_mejora_conserva_id->BoundColumn, $this->tipo_mejora_conserva_id->TextColumn, $this->tipo_mejora_conserva_id->DBFormat) = array("tipo_mejora_conserva_id", "tipo_mejora_conserva_descrip", "");
            $this->tipo_mejora_conserva_id->Required = true;
            $this->coefE2 = new clsControl(ccsTextBox, "coefE2", "coefE2", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("coefE2", $Method, NULL), $this);
            $this->coefE2->Required = true;
            $this->vuE2T_2 = new clsControl(ccsTextBox, "vuE2T_2", "vuE2T_2", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("vuE2T_2", $Method, NULL), $this);
            $this->veE2 = new clsControl(ccsTextBox, "veE2", "veE2", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("veE2", $Method, NULL), $this);
            $this->mejora_sup_cub = new clsControl(ccsTextBox, "mejora_sup_cub", "Superficie Cubierta", ccsFloat, "", CCGetRequestParam("mejora_sup_cub", $Method, NULL), $this);
            $this->mejora_sup_cub->Required = true;
            $this->mejora_sup_semi_cub = new clsControl(ccsHidden, "mejora_sup_semi_cub", "Sup Semi Cubierta", ccsFloat, array(False, 4, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("mejora_sup_semi_cub", $Method, NULL), $this);
            $this->mejora_porc_dominio = new clsControl(ccsHidden, "mejora_porc_dominio", "Porc Dominio", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("mejora_porc_dominio", $Method, NULL), $this);
            $this->coefE2A = new clsControl(ccsTextBox, "coefE2A", "coefE2A", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("coefE2A", $Method, NULL), $this);
            $this->veE2A = new clsControl(ccsTextBox, "veE2A", "veE2A", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("veE2A", $Method, NULL), $this);
            $this->valE2A = new clsControl(ccsTextBox, "valE2A", "valE2A", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("valE2A", $Method, NULL), $this);
            $this->mejora_anio_construccion = new clsControl(ccsListBox, "mejora_anio_construccion", "Año", ccsInteger, "", CCGetRequestParam("mejora_anio_construccion", $Method, NULL), $this);
            $this->mejora_anio_construccion->DSType = dsTable;
            $this->mejora_anio_construccion->DataSource = new clsDBtdf_nuevo();
            $this->mejora_anio_construccion->ds = & $this->mejora_anio_construccion->DataSource;
            $this->mejora_anio_construccion->DataSource->SQL = "SELECT * \n" .
"FROM mejoras_coeficientes {SQL_Where}\n" .
"GROUP BY mejora_coeficiente_anio {SQL_OrderBy}";
            $this->mejora_anio_construccion->DataSource->Order = "mejora_coeficiente_anio desc";
            list($this->mejora_anio_construccion->BoundColumn, $this->mejora_anio_construccion->TextColumn, $this->mejora_anio_construccion->DBFormat) = array("mejora_coeficiente_anio", "mejora_coeficiente_anio", "");
            $this->mejora_anio_construccion->DataSource->Order = "mejora_coeficiente_anio desc";
            $this->tipo_mejora_id = new clsControl(ccsListBox, "tipo_mejora_id", "Tipo", ccsInteger, "", CCGetRequestParam("tipo_mejora_id", $Method, NULL), $this);
            $this->tipo_mejora_id->DSType = dsTable;
            $this->tipo_mejora_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_mejora_id->ds = & $this->tipo_mejora_id->DataSource;
            $this->tipo_mejora_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_mejoras {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_mejora_id->BoundColumn, $this->tipo_mejora_id->TextColumn, $this->tipo_mejora_id->DBFormat) = array("tipo_mejora_id", "tipo_mejora_descrip", "");
            $this->tipo_mejora_estado_id = new clsControl(ccsListBox, "tipo_mejora_estado_id", "Estado", ccsInteger, "", CCGetRequestParam("tipo_mejora_estado_id", $Method, NULL), $this);
            $this->tipo_mejora_estado_id->DSType = dsTable;
            $this->tipo_mejora_estado_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_mejora_estado_id->ds = & $this->tipo_mejora_estado_id->DataSource;
            $this->tipo_mejora_estado_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_mejoras_estados {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_mejora_estado_id->BoundColumn, $this->tipo_mejora_estado_id->TextColumn, $this->tipo_mejora_estado_id->DBFormat) = array("tipo_mejora_estado_id", "tipo_mejora_estado_descrip", "");
            $this->mejora_form = new clsControl(ccsHidden, "mejora_form", "mejora_form", ccsText, "", CCGetRequestParam("mejora_form", $Method, NULL), $this);
            $this->usuario_id = new clsControl(ccsHidden, "usuario_id", "usuario_id", ccsText, "", CCGetRequestParam("usuario_id", $Method, NULL), $this);
            $this->tipo_mejora_destino_id = new clsControl(ccsHidden, "tipo_mejora_destino_id", "tipo_mejora_destino_id", ccsInteger, "", CCGetRequestParam("tipo_mejora_destino_id", $Method, NULL), $this);
            $this->mejora_valor = new clsControl(ccsHidden, "mejora_valor", "mejora_valor", ccsText, "", CCGetRequestParam("mejora_valor", $Method, NULL), $this);
            $this->mejora_f_alta = new clsControl(ccsTextBox, "mejora_f_alta", "fecha declaracion jurada", ccsDate, $DefaultDateFormat, CCGetRequestParam("mejora_f_alta", $Method, NULL), $this);
            $this->Button1 = new clsButton("Button1", $Method, $this);
            $this->tipo_mejora_decla_id = new clsControl(ccsRadioButton, "tipo_mejora_decla_id", "tipo_mejora_decla_id", ccsInteger, "", CCGetRequestParam("tipo_mejora_decla_id", $Method, NULL), $this);
            $this->tipo_mejora_decla_id->DSType = dsTable;
            $this->tipo_mejora_decla_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_mejora_decla_id->ds = & $this->tipo_mejora_decla_id->DataSource;
            $this->tipo_mejora_decla_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_mejoras_decla {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_mejora_decla_id->BoundColumn, $this->tipo_mejora_decla_id->TextColumn, $this->tipo_mejora_decla_id->DBFormat) = array("tipo_mejora_decla_id", "tipo_mejora_decla_descrip", "");
            $this->tipo_mejora_decla_id->HTML = true;
            $this->Button_eliminar = new clsButton("Button_eliminar", $Method, $this);
            $this->DatePicker_mejora_f_alta1 = new clsDatePicker("DatePicker_mejora_f_alta1", "mejoras", "mejora_f_alta", $this);
            $this->mejora_f_alta_pura = new clsControl(ccsTextBox, "mejora_f_alta_pura", "mejora_f_alta_pura", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("mejora_f_alta_pura", $Method, NULL), $this);
            $this->DatePicker_mejora_f_alta_pura = new clsDatePicker("DatePicker_mejora_f_alta_pura", "mejoras", "mejora_f_alta_pura", $this);
            $this->tipo_mejora_cat_id = new clsControl(ccsListBox, "tipo_mejora_cat_id", "Categoria", ccsInteger, "", CCGetRequestParam("tipo_mejora_cat_id", $Method, NULL), $this);
            $this->tipo_mejora_cat_id->DSType = dsTable;
            $this->tipo_mejora_cat_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_mejora_cat_id->ds = & $this->tipo_mejora_cat_id->DataSource;
            $this->tipo_mejora_cat_id->DataSource->SQL = "SELECT tipos_mejoras_cat.* \n" .
"FROM (mejoras_formularios_categorias INNER JOIN tipos_mejoras_cat ON\n" .
"mejoras_formularios_categorias.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id) INNER JOIN mejoras_formularios ON\n" .
"mejoras_formularios_categorias.mejora_formulario_id = mejoras_formularios.mejora_formulario_id {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_mejora_cat_id->BoundColumn, $this->tipo_mejora_cat_id->TextColumn, $this->tipo_mejora_cat_id->DBFormat) = array("tipo_mejora_cat_id", "tipo_mejora_cat_descript", "");
            $this->tipo_mejora_cat_id->DataSource->Parameters["urlf"] = CCGetFromGet("f", NULL);
            $this->tipo_mejora_cat_id->DataSource->wp = new clsSQLParameters();
            $this->tipo_mejora_cat_id->DataSource->wp->AddParameter("1", "urlf", ccsText, "", "", $this->tipo_mejora_cat_id->DataSource->Parameters["urlf"], "", false);
            $this->tipo_mejora_cat_id->DataSource->wp->Criterion[1] = $this->tipo_mejora_cat_id->DataSource->wp->Operation(opEqual, "mejoras_formularios.mejora_formulario_abrev", $this->tipo_mejora_cat_id->DataSource->wp->GetDBValue("1"), $this->tipo_mejora_cat_id->DataSource->ToSQL($this->tipo_mejora_cat_id->DataSource->wp->GetDBValue("1"), ccsText),false);
            $this->tipo_mejora_cat_id->DataSource->Where = 
                 $this->tipo_mejora_cat_id->DataSource->wp->Criterion[1];
            $this->tipo_mejora_cat_id->Required = true;
            if(!$this->FormSubmitted) {
                if(!is_array($this->cantE2B->Value) && !strlen($this->cantE2B->Value) && $this->cantE2B->Value !== false)
                    $this->cantE2B->SetText(0);
                if(!is_array($this->cantE2C->Value) && !strlen($this->cantE2C->Value) && $this->cantE2C->Value !== false)
                    $this->cantE2C->SetText(0);
                if(!is_array($this->cantE2T->Value) && !strlen($this->cantE2T->Value) && $this->cantE2T->Value !== false)
                    $this->cantE2T->SetText(0);
                if(!is_array($this->valE2B->Value) && !strlen($this->valE2B->Value) && $this->valE2B->Value !== false)
                    $this->valE2B->SetText(0);
                if(!is_array($this->valE2C->Value) && !strlen($this->valE2C->Value) && $this->valE2C->Value !== false)
                    $this->valE2C->SetText(0);
                if(!is_array($this->calE2T->Value) && !strlen($this->calE2T->Value) && $this->calE2T->Value !== false)
                    $this->calE2T->SetText(0);
                if(!is_array($this->calE2B->Value) && !strlen($this->calE2B->Value) && $this->calE2B->Value !== false)
                    $this->calE2B->SetText(0);
                if(!is_array($this->calE2C->Value) && !strlen($this->calE2C->Value) && $this->calE2C->Value !== false)
                    $this->calE2C->SetText(0);
                if(!is_array($this->vuE2T->Value) && !strlen($this->vuE2T->Value) && $this->vuE2T->Value !== false)
                    $this->vuE2T->SetText(0);
                if(!is_array($this->coefE2->Value) && !strlen($this->coefE2->Value) && $this->coefE2->Value !== false)
                    $this->coefE2->SetText(0);
                if(!is_array($this->vuE2T_2->Value) && !strlen($this->vuE2T_2->Value) && $this->vuE2T_2->Value !== false)
                    $this->vuE2T_2->SetText(0);
                if(!is_array($this->veE2->Value) && !strlen($this->veE2->Value) && $this->veE2->Value !== false)
                    $this->veE2->SetText(0);
                if(!is_array($this->mejora_sup_cub->Value) && !strlen($this->mejora_sup_cub->Value) && $this->mejora_sup_cub->Value !== false)
                    $this->mejora_sup_cub->SetText(0);
                if(!is_array($this->veE2A->Value) && !strlen($this->veE2A->Value) && $this->veE2A->Value !== false)
                    $this->veE2A->SetText(0);
                if(!is_array($this->valE2A->Value) && !strlen($this->valE2A->Value) && $this->valE2A->Value !== false)
                    $this->valE2A->SetText(0);
                if(!is_array($this->mejora_form->Value) && !strlen($this->mejora_form->Value) && $this->mejora_form->Value !== false)
                    $this->mejora_form->SetText(E2);
                if(!is_array($this->usuario_id->Value) && !strlen($this->usuario_id->Value) && $this->usuario_id->Value !== false)
                    $this->usuario_id->SetText(CCGetUserID());
                if(!is_array($this->tipo_mejora_destino_id->Value) && !strlen($this->tipo_mejora_destino_id->Value) && $this->tipo_mejora_destino_id->Value !== false)
                    $this->tipo_mejora_destino_id->SetText(3);
                if(!is_array($this->mejora_f_alta_pura->Value) && !strlen($this->mejora_f_alta_pura->Value) && $this->mejora_f_alta_pura->Value !== false)
                    $this->mejora_f_alta_pura->SetValue(time());
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @64-7DE78C7E
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlmejora_id"] = CCGetFromGet("mejora_id", NULL);
        $this->DataSource->Parameters["urlparcela_id"] = CCGetFromGet("parcela_id", NULL);
    }
//End Initialize Method

//Validate Method @64-0431BD2D
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->parcela_id->Validate() && $Validation);
        $Validation = ($this->mejora_nro_exp->Validate() && $Validation);
        $Validation = ($this->mejora_observacion->Validate() && $Validation);
        $Validation = ($this->mejora_letra_exp->Validate() && $Validation);
        $Validation = ($this->mejora_fecha_exp->Validate() && $Validation);
        $Validation = ($this->mejora_categoria_dpc->Validate() && $Validation);
        $Validation = ($this->mejora_f_pro->Validate() && $Validation);
        $Validation = ($this->audit_string->Validate() && $Validation);
        $Validation = ($this->tipo_estado_id->Validate() && $Validation);
        $Validation = ($this->sup_terreno->Validate() && $Validation);
        $Validation = ($this->mejora_f_baja->Validate() && $Validation);
        $Validation = ($this->mejora_nro_nota->Validate() && $Validation);
        $Validation = ($this->mejora_id->Validate() && $Validation);
        $Validation = ($this->cantE2B->Validate() && $Validation);
        $Validation = ($this->cantE2C->Validate() && $Validation);
        $Validation = ($this->cantE2T->Validate() && $Validation);
        $Validation = ($this->valE2B->Validate() && $Validation);
        $Validation = ($this->valE2C->Validate() && $Validation);
        $Validation = ($this->calE2T->Validate() && $Validation);
        $Validation = ($this->calE2B->Validate() && $Validation);
        $Validation = ($this->calE2C->Validate() && $Validation);
        $Validation = ($this->vuE2T->Validate() && $Validation);
        $Validation = ($this->tipo_mejora_conserva_id->Validate() && $Validation);
        $Validation = ($this->coefE2->Validate() && $Validation);
        $Validation = ($this->vuE2T_2->Validate() && $Validation);
        $Validation = ($this->veE2->Validate() && $Validation);
        $Validation = ($this->mejora_sup_cub->Validate() && $Validation);
        $Validation = ($this->mejora_sup_semi_cub->Validate() && $Validation);
        $Validation = ($this->mejora_porc_dominio->Validate() && $Validation);
        $Validation = ($this->coefE2A->Validate() && $Validation);
        $Validation = ($this->veE2A->Validate() && $Validation);
        $Validation = ($this->valE2A->Validate() && $Validation);
        $Validation = ($this->mejora_anio_construccion->Validate() && $Validation);
        $Validation = ($this->tipo_mejora_id->Validate() && $Validation);
        $Validation = ($this->tipo_mejora_estado_id->Validate() && $Validation);
        $Validation = ($this->mejora_form->Validate() && $Validation);
        $Validation = ($this->usuario_id->Validate() && $Validation);
        $Validation = ($this->tipo_mejora_destino_id->Validate() && $Validation);
        $Validation = ($this->mejora_valor->Validate() && $Validation);
        $Validation = ($this->mejora_f_alta->Validate() && $Validation);
        $Validation = ($this->tipo_mejora_decla_id->Validate() && $Validation);
        $Validation = ($this->mejora_f_alta_pura->Validate() && $Validation);
        $Validation = ($this->tipo_mejora_cat_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->parcela_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_nro_exp->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_observacion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_letra_exp->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_fecha_exp->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_categoria_dpc->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_f_pro->Errors->Count() == 0);
        $Validation =  $Validation && ($this->audit_string->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_estado_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->sup_terreno->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_f_baja->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_nro_nota->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->cantE2B->Errors->Count() == 0);
        $Validation =  $Validation && ($this->cantE2C->Errors->Count() == 0);
        $Validation =  $Validation && ($this->cantE2T->Errors->Count() == 0);
        $Validation =  $Validation && ($this->valE2B->Errors->Count() == 0);
        $Validation =  $Validation && ($this->valE2C->Errors->Count() == 0);
        $Validation =  $Validation && ($this->calE2T->Errors->Count() == 0);
        $Validation =  $Validation && ($this->calE2B->Errors->Count() == 0);
        $Validation =  $Validation && ($this->calE2C->Errors->Count() == 0);
        $Validation =  $Validation && ($this->vuE2T->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_mejora_conserva_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->coefE2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->vuE2T_2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->veE2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_sup_cub->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_sup_semi_cub->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_porc_dominio->Errors->Count() == 0);
        $Validation =  $Validation && ($this->coefE2A->Errors->Count() == 0);
        $Validation =  $Validation && ($this->veE2A->Errors->Count() == 0);
        $Validation =  $Validation && ($this->valE2A->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_anio_construccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_mejora_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_mejora_estado_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_form->Errors->Count() == 0);
        $Validation =  $Validation && ($this->usuario_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_mejora_destino_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_valor->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_f_alta->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_mejora_decla_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_f_alta_pura->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_mejora_cat_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @64-BD3CE0D2
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->parcela_id->Errors->Count());
        $errors = ($errors || $this->mejora_nro_exp->Errors->Count());
        $errors = ($errors || $this->mejora_observacion->Errors->Count());
        $errors = ($errors || $this->mejora_letra_exp->Errors->Count());
        $errors = ($errors || $this->mejora_fecha_exp->Errors->Count());
        $errors = ($errors || $this->DatePicker_mejora_fecha_exp->Errors->Count());
        $errors = ($errors || $this->mejora_categoria_dpc->Errors->Count());
        $errors = ($errors || $this->mejora_f_pro->Errors->Count());
        $errors = ($errors || $this->audit_string->Errors->Count());
        $errors = ($errors || $this->tipo_estado_id->Errors->Count());
        $errors = ($errors || $this->baja->Errors->Count());
        $errors = ($errors || $this->sup_terreno->Errors->Count());
        $errors = ($errors || $this->mejora_f_baja->Errors->Count());
        $errors = ($errors || $this->mejora_nro_nota->Errors->Count());
        $errors = ($errors || $this->mejora_id->Errors->Count());
        $errors = ($errors || $this->motivo_baja->Errors->Count());
        $errors = ($errors || $this->cantE2B->Errors->Count());
        $errors = ($errors || $this->cantE2C->Errors->Count());
        $errors = ($errors || $this->cantE2T->Errors->Count());
        $errors = ($errors || $this->valE2B->Errors->Count());
        $errors = ($errors || $this->valE2C->Errors->Count());
        $errors = ($errors || $this->calE2T->Errors->Count());
        $errors = ($errors || $this->calE2B->Errors->Count());
        $errors = ($errors || $this->calE2C->Errors->Count());
        $errors = ($errors || $this->vuE2T->Errors->Count());
        $errors = ($errors || $this->tipo_mejora_conserva_id->Errors->Count());
        $errors = ($errors || $this->coefE2->Errors->Count());
        $errors = ($errors || $this->vuE2T_2->Errors->Count());
        $errors = ($errors || $this->veE2->Errors->Count());
        $errors = ($errors || $this->mejora_sup_cub->Errors->Count());
        $errors = ($errors || $this->mejora_sup_semi_cub->Errors->Count());
        $errors = ($errors || $this->mejora_porc_dominio->Errors->Count());
        $errors = ($errors || $this->coefE2A->Errors->Count());
        $errors = ($errors || $this->veE2A->Errors->Count());
        $errors = ($errors || $this->valE2A->Errors->Count());
        $errors = ($errors || $this->mejora_anio_construccion->Errors->Count());
        $errors = ($errors || $this->tipo_mejora_id->Errors->Count());
        $errors = ($errors || $this->tipo_mejora_estado_id->Errors->Count());
        $errors = ($errors || $this->mejora_form->Errors->Count());
        $errors = ($errors || $this->usuario_id->Errors->Count());
        $errors = ($errors || $this->tipo_mejora_destino_id->Errors->Count());
        $errors = ($errors || $this->mejora_valor->Errors->Count());
        $errors = ($errors || $this->mejora_f_alta->Errors->Count());
        $errors = ($errors || $this->tipo_mejora_decla_id->Errors->Count());
        $errors = ($errors || $this->DatePicker_mejora_f_alta1->Errors->Count());
        $errors = ($errors || $this->mejora_f_alta_pura->Errors->Count());
        $errors = ($errors || $this->DatePicker_mejora_f_alta_pura->Errors->Count());
        $errors = ($errors || $this->tipo_mejora_cat_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @64-ED598703
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

//Operation Method @64-0DFC4AB0
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

        if($this->FormSubmitted) {
            $this->PressedButton = $this->EditMode ? "Button_Update" : "Button_Insert";
            if($this->Button_Insert->Pressed) {
                $this->PressedButton = "Button_Insert";
            } else if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            } else if($this->Button_Delete->Pressed) {
                $this->PressedButton = "Button_Delete";
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            } else if($this->Button_alta->Pressed) {
                $this->PressedButton = "Button_alta";
            } else if($this->Button1->Pressed) {
                $this->PressedButton = "Button1";
            } else if($this->Button_eliminar->Pressed) {
                $this->PressedButton = "Button_eliminar";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Delete") {
            $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "mejora_id", "add", "f"));
            if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_Cancel") {
            $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "mejora_id", "add", "f"));
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button1") {
            if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_eliminar") {
            $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "mejora_id", "add", "f"));
            if(!CCGetEvent($this->Button_eliminar->CCSEvents, "OnClick", $this->Button_eliminar)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Insert" && $this->InsertAllowed) {
                $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "mejora_id", "add", "f"));
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_Update" && $this->UpdateAllowed) {
                $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "mejora_id", "add", "f"));
                if(!CCGetEvent($this->Button_Update->CCSEvents, "OnClick", $this->Button_Update) || !$this->UpdateRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_alta") {
                $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "mejora_id", "add", "f"));
                if(!CCGetEvent($this->Button_alta->CCSEvents, "OnClick", $this->Button_alta)) {
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

//InsertRow Method @64-D27984E8
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->parcela_id->SetValue($this->parcela_id->GetValue(true));
        $this->DataSource->mejora_nro_exp->SetValue($this->mejora_nro_exp->GetValue(true));
        $this->DataSource->mejora_sup_cub->SetValue($this->mejora_sup_cub->GetValue(true));
        $this->DataSource->mejora_observacion->SetValue($this->mejora_observacion->GetValue(true));
        $this->DataSource->mejora_letra_exp->SetValue($this->mejora_letra_exp->GetValue(true));
        $this->DataSource->mejora_fecha_exp->SetValue($this->mejora_fecha_exp->GetValue(true));
        $this->DataSource->tipo_mejora_id->SetValue($this->tipo_mejora_id->GetValue(true));
        $this->DataSource->mejora_categoria_dpc->SetValue($this->mejora_categoria_dpc->GetValue(true));
        $this->DataSource->mejora_f_alta->SetValue($this->mejora_f_alta->GetValue(true));
        $this->DataSource->mejora_f_pro->SetValue($this->mejora_f_pro->GetValue(true));
        $this->DataSource->audit_string->SetValue($this->audit_string->GetValue(true));
        $this->DataSource->tipo_estado_id->SetValue($this->tipo_estado_id->GetValue(true));
        $this->DataSource->mejora_valor->SetValue($this->mejora_valor->GetValue(true));
        $this->DataSource->mejora_porc_dominio->SetValue($this->mejora_porc_dominio->GetValue(true));
        $this->DataSource->mejora_sup_semi_cub->SetValue($this->mejora_sup_semi_cub->GetValue(true));
        $this->DataSource->mejora_f_baja->SetValue($this->mejora_f_baja->GetValue(true));
        $this->DataSource->tipo_mejora_estado_id->SetValue($this->tipo_mejora_estado_id->GetValue(true));
        $this->DataSource->tipo_mejora_conserva_id->SetValue($this->tipo_mejora_conserva_id->GetValue(true));
        $this->DataSource->mejora_anio_construccion->SetValue($this->mejora_anio_construccion->GetValue(true));
        $this->DataSource->mejora_id->SetValue($this->mejora_id->GetValue(true));
        $this->DataSource->mejora_form->SetValue($this->mejora_form->GetValue(true));
        $this->DataSource->usuario_id->SetValue($this->usuario_id->GetValue(true));
        $this->DataSource->valE2A->SetValue($this->valE2A->GetValue(true));
        $this->DataSource->coefE2A->SetValue($this->coefE2A->GetValue(true));
        $this->DataSource->veE2A->SetValue($this->veE2A->GetValue(true));
        $this->DataSource->tipo_mejora_destino_id->SetValue($this->tipo_mejora_destino_id->GetValue(true));
        $this->DataSource->tipo_mejora_decla_id->SetValue($this->tipo_mejora_decla_id->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @64-1CAA593C
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->parcela_id->SetValue($this->parcela_id->GetValue(true));
        $this->DataSource->mejora_nro_exp->SetValue($this->mejora_nro_exp->GetValue(true));
        $this->DataSource->mejora_sup_cub->SetValue($this->mejora_sup_cub->GetValue(true));
        $this->DataSource->mejora_observacion->SetValue($this->mejora_observacion->GetValue(true));
        $this->DataSource->mejora_letra_exp->SetValue($this->mejora_letra_exp->GetValue(true));
        $this->DataSource->mejora_fecha_exp->SetValue($this->mejora_fecha_exp->GetValue(true));
        $this->DataSource->tipo_mejora_id->SetValue($this->tipo_mejora_id->GetValue(true));
        $this->DataSource->mejora_categoria_dpc->SetValue($this->mejora_categoria_dpc->GetValue(true));
        $this->DataSource->mejora_f_alta->SetValue($this->mejora_f_alta->GetValue(true));
        $this->DataSource->mejora_f_pro->SetValue($this->mejora_f_pro->GetValue(true));
        $this->DataSource->audit_string->SetValue($this->audit_string->GetValue(true));
        $this->DataSource->tipo_estado_id->SetValue($this->tipo_estado_id->GetValue(true));
        $this->DataSource->tipo_mejora_destino_id->SetValue($this->tipo_mejora_destino_id->GetValue(true));
        $this->DataSource->mejora_valor->SetValue($this->mejora_valor->GetValue(true));
        $this->DataSource->mejora_porc_dominio->SetValue($this->mejora_porc_dominio->GetValue(true));
        $this->DataSource->mejora_sup_semi_cub->SetValue($this->mejora_sup_semi_cub->GetValue(true));
        $this->DataSource->mejora_f_baja->SetValue($this->mejora_f_baja->GetValue(true));
        $this->DataSource->mejora_id->SetValue($this->mejora_id->GetValue(true));
        $this->DataSource->tipo_mejora_cat_id->SetValue($this->tipo_mejora_cat_id->GetValue(true));
        $this->DataSource->tipo_mejora_estado_id->SetValue($this->tipo_mejora_estado_id->GetValue(true));
        $this->DataSource->tipo_mejora_conserva_id->SetValue($this->tipo_mejora_conserva_id->GetValue(true));
        $this->DataSource->mejora_anio_construccion->SetValue($this->mejora_anio_construccion->GetValue(true));
        $this->DataSource->mejora_form->SetValue($this->mejora_form->GetValue(true));
        $this->DataSource->usuario_id->SetValue($this->usuario_id->GetValue(true));
        $this->DataSource->valE2A->SetValue($this->valE2A->GetValue(true));
        $this->DataSource->coefE2A->SetValue($this->coefE2A->GetValue(true));
        $this->DataSource->veE2A->SetValue($this->veE2A->GetValue(true));
        $this->DataSource->tipo_mejora_decla_id->SetValue($this->tipo_mejora_decla_id->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @64-64CBB3D3
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

        $this->tipo_mejora_conserva_id->Prepare();
        $this->mejora_anio_construccion->Prepare();
        $this->tipo_mejora_id->Prepare();
        $this->tipo_mejora_estado_id->Prepare();
        $this->tipo_mejora_decla_id->Prepare();
        $this->tipo_mejora_cat_id->Prepare();

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
                if(!$this->FormSubmitted){
                    $this->parcela_id->SetValue($this->DataSource->parcela_id->GetValue());
                    $this->mejora_nro_exp->SetValue($this->DataSource->mejora_nro_exp->GetValue());
                    $this->mejora_observacion->SetValue($this->DataSource->mejora_observacion->GetValue());
                    $this->mejora_letra_exp->SetValue($this->DataSource->mejora_letra_exp->GetValue());
                    $this->mejora_fecha_exp->SetValue($this->DataSource->mejora_fecha_exp->GetValue());
                    $this->mejora_categoria_dpc->SetValue($this->DataSource->mejora_categoria_dpc->GetValue());
                    $this->mejora_f_pro->SetValue($this->DataSource->mejora_f_pro->GetValue());
                    $this->audit_string->SetValue($this->DataSource->audit_string->GetValue());
                    $this->tipo_estado_id->SetValue($this->DataSource->tipo_estado_id->GetValue());
                    $this->mejora_f_baja->SetValue($this->DataSource->mejora_f_baja->GetValue());
                    $this->mejora_id->SetValue($this->DataSource->mejora_id->GetValue());
                    $this->tipo_mejora_conserva_id->SetValue($this->DataSource->tipo_mejora_conserva_id->GetValue());
                    $this->mejora_sup_cub->SetValue($this->DataSource->mejora_sup_cub->GetValue());
                    $this->mejora_sup_semi_cub->SetValue($this->DataSource->mejora_sup_semi_cub->GetValue());
                    $this->mejora_porc_dominio->SetValue($this->DataSource->mejora_porc_dominio->GetValue());
                    $this->coefE2A->SetValue($this->DataSource->coefE2A->GetValue());
                    $this->veE2A->SetValue($this->DataSource->veE2A->GetValue());
                    $this->valE2A->SetValue($this->DataSource->valE2A->GetValue());
                    $this->mejora_anio_construccion->SetValue($this->DataSource->mejora_anio_construccion->GetValue());
                    $this->tipo_mejora_id->SetValue($this->DataSource->tipo_mejora_id->GetValue());
                    $this->tipo_mejora_estado_id->SetValue($this->DataSource->tipo_mejora_estado_id->GetValue());
                    $this->mejora_form->SetValue($this->DataSource->mejora_form->GetValue());
                    $this->usuario_id->SetValue($this->DataSource->usuario_id->GetValue());
                    $this->tipo_mejora_destino_id->SetValue($this->DataSource->tipo_mejora_destino_id->GetValue());
                    $this->mejora_f_alta->SetValue($this->DataSource->mejora_f_alta->GetValue());
                    $this->tipo_mejora_decla_id->SetValue($this->DataSource->tipo_mejora_decla_id->GetValue());
                    $this->mejora_f_alta_pura->SetValue($this->DataSource->mejora_f_alta_pura->GetValue());
                    $this->tipo_mejora_cat_id->SetValue($this->DataSource->tipo_mejora_cat_id->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }
        if (!$this->FormSubmitted) {
        }
        if ($this->cantE2T->GetValue() < 0 )
             $this->cantE2T->Text = CCFormatNumber($this->cantE2T->GetValue(), array(False, 0, Null, "", True, "(", ")", 1, True, ""));
        else
             $this->cantE2T->Text = CCFormatNumber($this->cantE2T->GetValue(), array(False, 0, Null, "", False, "", "", 1, True, ""));

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->parcela_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_nro_exp->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_observacion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_letra_exp->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_fecha_exp->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_mejora_fecha_exp->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_categoria_dpc->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_f_pro->Errors->ToString());
            $Error = ComposeStrings($Error, $this->audit_string->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_estado_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->baja->Errors->ToString());
            $Error = ComposeStrings($Error, $this->sup_terreno->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_f_baja->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_nro_nota->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->motivo_baja->Errors->ToString());
            $Error = ComposeStrings($Error, $this->cantE2B->Errors->ToString());
            $Error = ComposeStrings($Error, $this->cantE2C->Errors->ToString());
            $Error = ComposeStrings($Error, $this->cantE2T->Errors->ToString());
            $Error = ComposeStrings($Error, $this->valE2B->Errors->ToString());
            $Error = ComposeStrings($Error, $this->valE2C->Errors->ToString());
            $Error = ComposeStrings($Error, $this->calE2T->Errors->ToString());
            $Error = ComposeStrings($Error, $this->calE2B->Errors->ToString());
            $Error = ComposeStrings($Error, $this->calE2C->Errors->ToString());
            $Error = ComposeStrings($Error, $this->vuE2T->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_mejora_conserva_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->coefE2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->vuE2T_2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->veE2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_sup_cub->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_sup_semi_cub->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_porc_dominio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->coefE2A->Errors->ToString());
            $Error = ComposeStrings($Error, $this->veE2A->Errors->ToString());
            $Error = ComposeStrings($Error, $this->valE2A->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_anio_construccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_mejora_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_mejora_estado_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_form->Errors->ToString());
            $Error = ComposeStrings($Error, $this->usuario_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_mejora_destino_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_valor->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_f_alta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_mejora_decla_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_mejora_f_alta1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_f_alta_pura->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_mejora_f_alta_pura->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_mejora_cat_id->Errors->ToString());
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
        $this->Button_Insert->Visible = !$this->EditMode && $this->InsertAllowed;
        $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->Button_Delete->Show();
        $this->Button_Cancel->Show();
        $this->parcela_id->Show();
        $this->mejora_nro_exp->Show();
        $this->mejora_observacion->Show();
        $this->mejora_letra_exp->Show();
        $this->mejora_fecha_exp->Show();
        $this->DatePicker_mejora_fecha_exp->Show();
        $this->mejora_categoria_dpc->Show();
        $this->mejora_f_pro->Show();
        $this->audit_string->Show();
        $this->tipo_estado_id->Show();
        $this->baja->Show();
        $this->sup_terreno->Show();
        $this->Button_alta->Show();
        $this->mejora_f_baja->Show();
        $this->mejora_nro_nota->Show();
        $this->mejora_id->Show();
        $this->motivo_baja->Show();
        $this->cantE2B->Show();
        $this->cantE2C->Show();
        $this->cantE2T->Show();
        $this->valE2B->Show();
        $this->valE2C->Show();
        $this->calE2T->Show();
        $this->calE2B->Show();
        $this->calE2C->Show();
        $this->vuE2T->Show();
        $this->tipo_mejora_conserva_id->Show();
        $this->coefE2->Show();
        $this->vuE2T_2->Show();
        $this->veE2->Show();
        $this->mejora_sup_cub->Show();
        $this->mejora_sup_semi_cub->Show();
        $this->mejora_porc_dominio->Show();
        $this->coefE2A->Show();
        $this->veE2A->Show();
        $this->valE2A->Show();
        $this->mejora_anio_construccion->Show();
        $this->tipo_mejora_id->Show();
        $this->tipo_mejora_estado_id->Show();
        $this->mejora_form->Show();
        $this->usuario_id->Show();
        $this->tipo_mejora_destino_id->Show();
        $this->mejora_valor->Show();
        $this->mejora_f_alta->Show();
        $this->Button1->Show();
        $this->tipo_mejora_decla_id->Show();
        $this->Button_eliminar->Show();
        $this->DatePicker_mejora_f_alta1->Show();
        $this->mejora_f_alta_pura->Show();
        $this->DatePicker_mejora_f_alta_pura->Show();
        $this->tipo_mejora_cat_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End mejoras Class @64-FCB6E20C

class clsmejorasDataSource extends clsDBtdf_nuevo {  //mejorasDataSource Class @64-A728D50A

//DataSource Variables @64-704D446C
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $wp;
    public $AllParametersSet;

    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $parcela_id;
    public $mejora_nro_exp;
    public $mejora_observacion;
    public $mejora_letra_exp;
    public $mejora_fecha_exp;
    public $mejora_categoria_dpc;
    public $mejora_f_pro;
    public $audit_string;
    public $tipo_estado_id;
    public $baja;
    public $sup_terreno;
    public $mejora_f_baja;
    public $mejora_nro_nota;
    public $mejora_id;
    public $motivo_baja;
    public $cantE2B;
    public $cantE2C;
    public $cantE2T;
    public $valE2B;
    public $valE2C;
    public $calE2T;
    public $calE2B;
    public $calE2C;
    public $vuE2T;
    public $tipo_mejora_conserva_id;
    public $coefE2;
    public $vuE2T_2;
    public $veE2;
    public $mejora_sup_cub;
    public $mejora_sup_semi_cub;
    public $mejora_porc_dominio;
    public $coefE2A;
    public $veE2A;
    public $valE2A;
    public $mejora_anio_construccion;
    public $tipo_mejora_id;
    public $tipo_mejora_estado_id;
    public $mejora_form;
    public $usuario_id;
    public $tipo_mejora_destino_id;
    public $mejora_valor;
    public $mejora_f_alta;
    public $tipo_mejora_decla_id;
    public $mejora_f_alta_pura;
    public $tipo_mejora_cat_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @64-30B6D54E
    function clsmejorasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record mejoras/Error";
        $this->Initialize();
        $this->parcela_id = new clsField("parcela_id", ccsInteger, "");
        
        $this->mejora_nro_exp = new clsField("mejora_nro_exp", ccsInteger, "");
        
        $this->mejora_observacion = new clsField("mejora_observacion", ccsText, "");
        
        $this->mejora_letra_exp = new clsField("mejora_letra_exp", ccsText, "");
        
        $this->mejora_fecha_exp = new clsField("mejora_fecha_exp", ccsDate, $this->DateFormat);
        
        $this->mejora_categoria_dpc = new clsField("mejora_categoria_dpc", ccsInteger, "");
        
        $this->mejora_f_pro = new clsField("mejora_f_pro", ccsText, "");
        
        $this->audit_string = new clsField("audit_string", ccsText, "");
        
        $this->tipo_estado_id = new clsField("tipo_estado_id", ccsInteger, "");
        
        $this->baja = new clsField("baja", ccsText, "");
        
        $this->sup_terreno = new clsField("sup_terreno", ccsFloat, "");
        
        $this->mejora_f_baja = new clsField("mejora_f_baja", ccsText, "");
        
        $this->mejora_nro_nota = new clsField("mejora_nro_nota", ccsText, "");
        
        $this->mejora_id = new clsField("mejora_id", ccsText, "");
        
        $this->motivo_baja = new clsField("motivo_baja", ccsText, "");
        
        $this->cantE2B = new clsField("cantE2B", ccsInteger, "");
        
        $this->cantE2C = new clsField("cantE2C", ccsInteger, "");
        
        $this->cantE2T = new clsField("cantE2T", ccsInteger, "");
        
        $this->valE2B = new clsField("valE2B", ccsFloat, "");
        
        $this->valE2C = new clsField("valE2C", ccsFloat, "");
        
        $this->calE2T = new clsField("calE2T", ccsFloat, "");
        
        $this->calE2B = new clsField("calE2B", ccsFloat, "");
        
        $this->calE2C = new clsField("calE2C", ccsFloat, "");
        
        $this->vuE2T = new clsField("vuE2T", ccsFloat, "");
        
        $this->tipo_mejora_conserva_id = new clsField("tipo_mejora_conserva_id", ccsInteger, "");
        
        $this->coefE2 = new clsField("coefE2", ccsFloat, "");
        
        $this->vuE2T_2 = new clsField("vuE2T_2", ccsFloat, "");
        
        $this->veE2 = new clsField("veE2", ccsFloat, "");
        
        $this->mejora_sup_cub = new clsField("mejora_sup_cub", ccsFloat, "");
        
        $this->mejora_sup_semi_cub = new clsField("mejora_sup_semi_cub", ccsFloat, "");
        
        $this->mejora_porc_dominio = new clsField("mejora_porc_dominio", ccsFloat, "");
        
        $this->coefE2A = new clsField("coefE2A", ccsFloat, "");
        
        $this->veE2A = new clsField("veE2A", ccsFloat, "");
        
        $this->valE2A = new clsField("valE2A", ccsFloat, "");
        
        $this->mejora_anio_construccion = new clsField("mejora_anio_construccion", ccsInteger, "");
        
        $this->tipo_mejora_id = new clsField("tipo_mejora_id", ccsInteger, "");
        
        $this->tipo_mejora_estado_id = new clsField("tipo_mejora_estado_id", ccsInteger, "");
        
        $this->mejora_form = new clsField("mejora_form", ccsText, "");
        
        $this->usuario_id = new clsField("usuario_id", ccsText, "");
        
        $this->tipo_mejora_destino_id = new clsField("tipo_mejora_destino_id", ccsInteger, "");
        
        $this->mejora_valor = new clsField("mejora_valor", ccsText, "");
        
        $this->mejora_f_alta = new clsField("mejora_f_alta", ccsDate, $this->DateFormat);
        
        $this->tipo_mejora_decla_id = new clsField("tipo_mejora_decla_id", ccsInteger, "");
        
        $this->mejora_f_alta_pura = new clsField("mejora_f_alta_pura", ccsDate, $this->DateFormat);
        
        $this->tipo_mejora_cat_id = new clsField("tipo_mejora_cat_id", ccsInteger, "");
        

        $this->InsertFields["parcela_id"] = array("Name" => "parcela_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_nro_exp"] = array("Name" => "mejora_nro_exp", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_sup_cub"] = array("Name" => "mejora_sup_cub", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_observacion"] = array("Name" => "mejora_observacion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_letra_exp"] = array("Name" => "mejora_letra_exp", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_fecha_exp"] = array("Name" => "mejora_fecha_exp", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_mejora_id"] = array("Name" => "tipo_mejora_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_categoria_dpc"] = array("Name" => "mejora_categoria_dpc", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_f_alta"] = array("Name" => "mejora_f_alta", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_f_pro"] = array("Name" => "mejora_f_pro", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["audit_string"] = array("Name" => "audit_string", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_estado_id"] = array("Name" => "tipo_estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_valor"] = array("Name" => "mejora_valor", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_porc_dominio"] = array("Name" => "mejora_porc_dominio", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_sup_semi_cub"] = array("Name" => "mejora_sup_semi_cub", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_f_baja"] = array("Name" => "mejora_f_baja", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_mejora_estado_id"] = array("Name" => "tipo_mejora_estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_mejora_conserva_id"] = array("Name" => "tipo_mejora_conserva_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_anio_construccion"] = array("Name" => "mejora_anio_construccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_id"] = array("Name" => "mejora_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_form"] = array("Name" => "mejora_form", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["usuario_id"] = array("Name" => "usuario_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_valuacion"] = array("Name" => "mejora_valuacion", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_coef_ajuste"] = array("Name" => "mejora_coef_ajuste", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_valor"] = array("Name" => "mejora_valor", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_mejora_destino_id"] = array("Name" => "tipo_mejora_destino_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_mejora_decla_id"] = array("Name" => "tipo_mejora_decla_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_id"] = array("Name" => "parcela_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_nro_exp"] = array("Name" => "mejora_nro_exp", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_sup_cub"] = array("Name" => "mejora_sup_cub", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_observacion"] = array("Name" => "mejora_observacion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_letra_exp"] = array("Name" => "mejora_letra_exp", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_fecha_exp"] = array("Name" => "mejora_fecha_exp", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_mejora_id"] = array("Name" => "tipo_mejora_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_categoria_dpc"] = array("Name" => "mejora_categoria_dpc", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_f_alta"] = array("Name" => "mejora_f_alta", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_f_pro"] = array("Name" => "mejora_f_pro", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["audit_string"] = array("Name" => "audit_string", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_estado_id"] = array("Name" => "tipo_estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_mejora_destino_id"] = array("Name" => "tipo_mejora_destino_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_valor"] = array("Name" => "mejora_valor", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_porc_dominio"] = array("Name" => "mejora_porc_dominio", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_sup_semi_cub"] = array("Name" => "mejora_sup_semi_cub", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_f_baja"] = array("Name" => "mejora_f_baja", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_id"] = array("Name" => "mejora_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_mejora_cat_id"] = array("Name" => "tipo_mejora_cat_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_mejora_estado_id"] = array("Name" => "tipo_mejora_estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_mejora_conserva_id"] = array("Name" => "tipo_mejora_conserva_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_anio_construccion"] = array("Name" => "mejora_anio_construccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_form"] = array("Name" => "mejora_form", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["usuario_id"] = array("Name" => "usuario_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_valuacion"] = array("Name" => "mejora_valuacion", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_coef_ajuste"] = array("Name" => "mejora_coef_ajuste", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_valor"] = array("Name" => "mejora_valor", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_mejora_decla_id"] = array("Name" => "tipo_mejora_decla_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @64-6A648D9E
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlmejora_id", ccsInteger, "", "", $this->Parameters["urlmejora_id"], "", false);
        $this->wp->AddParameter("2", "urlparcela_id", ccsInteger, "", "", $this->Parameters["urlparcela_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "mejora_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "parcela_id", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @64-1E8F64B3
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM mejoras {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @64-1210035B
    function SetValues()
    {
        $this->parcela_id->SetDBValue(trim($this->f("parcela_id")));
        $this->mejora_nro_exp->SetDBValue(trim($this->f("mejora_nro_exp")));
        $this->mejora_observacion->SetDBValue($this->f("mejora_observacion"));
        $this->mejora_letra_exp->SetDBValue($this->f("mejora_letra_exp"));
        $this->mejora_fecha_exp->SetDBValue(trim($this->f("mejora_fecha_exp")));
        $this->mejora_categoria_dpc->SetDBValue(trim($this->f("mejora_categoria_dpc")));
        $this->mejora_f_pro->SetDBValue($this->f("mejora_f_pro"));
        $this->audit_string->SetDBValue($this->f("audit_string"));
        $this->tipo_estado_id->SetDBValue(trim($this->f("tipo_estado_id")));
        $this->mejora_f_baja->SetDBValue($this->f("mejora_f_baja"));
        $this->mejora_id->SetDBValue($this->f("mejora_id"));
        $this->tipo_mejora_conserva_id->SetDBValue(trim($this->f("tipo_mejora_conserva_id")));
        $this->mejora_sup_cub->SetDBValue(trim($this->f("mejora_sup_cub")));
        $this->mejora_sup_semi_cub->SetDBValue(trim($this->f("mejora_sup_semi_cub")));
        $this->mejora_porc_dominio->SetDBValue(trim($this->f("mejora_porc_dominio")));
        $this->coefE2A->SetDBValue(trim($this->f("mejora_coef_ajuste")));
        $this->veE2A->SetDBValue(trim($this->f("mejora_valor")));
        $this->valE2A->SetDBValue(trim($this->f("mejora_valuacion")));
        $this->mejora_anio_construccion->SetDBValue(trim($this->f("mejora_anio_construccion")));
        $this->tipo_mejora_id->SetDBValue(trim($this->f("tipo_mejora_id")));
        $this->tipo_mejora_estado_id->SetDBValue(trim($this->f("tipo_mejora_estado_id")));
        $this->mejora_form->SetDBValue($this->f("mejora_form"));
        $this->usuario_id->SetDBValue($this->f("usuario_id"));
        $this->tipo_mejora_destino_id->SetDBValue(trim($this->f("tipo_mejora_destino_id")));
        $this->mejora_f_alta->SetDBValue(trim($this->f("mejora_f_alta")));
        $this->tipo_mejora_decla_id->SetDBValue(trim($this->f("tipo_mejora_decla_id")));
        $this->mejora_f_alta_pura->SetDBValue(trim($this->f("mejora_f_alta_pura")));
        $this->tipo_mejora_cat_id->SetDBValue(trim($this->f("tipo_mejora_destino_id")));
    }
//End SetValues Method

//Insert Method @64-FF4E0EBB
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["parcela_id"] = new clsSQLParameter("ctrlparcela_id", ccsInteger, "", "", $this->parcela_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_nro_exp"] = new clsSQLParameter("ctrlmejora_nro_exp", ccsInteger, "", "", $this->mejora_nro_exp->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_sup_cub"] = new clsSQLParameter("ctrlmejora_sup_cub", ccsFloat, array(False, 4, Null, "", False, "", "", 1, True, ""), "", $this->mejora_sup_cub->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_observacion"] = new clsSQLParameter("ctrlmejora_observacion", ccsText, "", "", $this->mejora_observacion->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_letra_exp"] = new clsSQLParameter("ctrlmejora_letra_exp", ccsText, "", "", $this->mejora_letra_exp->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_fecha_exp"] = new clsSQLParameter("ctrlmejora_fecha_exp", ccsDate, $DefaultDateFormat, $this->DateFormat, $this->mejora_fecha_exp->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_id"] = new clsSQLParameter("ctrltipo_mejora_id", ccsInteger, "", "", $this->tipo_mejora_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_categoria_dpc"] = new clsSQLParameter("ctrlmejora_categoria_dpc", ccsInteger, "", "", $this->mejora_categoria_dpc->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_f_alta"] = new clsSQLParameter("ctrlmejora_f_alta", ccsDate, $DefaultDateFormat, $this->DateFormat, $this->mejora_f_alta->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_f_pro"] = new clsSQLParameter("ctrlmejora_f_pro", ccsText, "", "", $this->mejora_f_pro->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["audit_string"] = new clsSQLParameter("ctrlaudit_string", ccsText, "", "", $this->audit_string->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_estado_id"] = new clsSQLParameter("ctrltipo_estado_id", ccsInteger, "", "", $this->tipo_estado_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_valor"] = new clsSQLParameter("ctrlmejora_valor", ccsFloat, "", "", $this->mejora_valor->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_porc_dominio"] = new clsSQLParameter("ctrlmejora_porc_dominio", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), "", $this->mejora_porc_dominio->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_sup_semi_cub"] = new clsSQLParameter("ctrlmejora_sup_semi_cub", ccsFloat, array(False, 4, Null, "", False, "", "", 1, True, ""), "", $this->mejora_sup_semi_cub->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_f_baja"] = new clsSQLParameter("ctrlmejora_f_baja", ccsText, "", "", $this->mejora_f_baja->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_estado_id"] = new clsSQLParameter("ctrltipo_mejora_estado_id", ccsInteger, "", "", $this->tipo_mejora_estado_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_conserva_id"] = new clsSQLParameter("ctrltipo_mejora_conserva_id", ccsInteger, "", "", $this->tipo_mejora_conserva_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_anio_construccion"] = new clsSQLParameter("ctrlmejora_anio_construccion", ccsText, "", "", $this->mejora_anio_construccion->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_id"] = new clsSQLParameter("ctrlmejora_id", ccsText, "", "", $this->mejora_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_form"] = new clsSQLParameter("ctrlmejora_form", ccsText, "", "", $this->mejora_form->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["usuario_id"] = new clsSQLParameter("ctrlusuario_id", ccsText, "", "", $this->usuario_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_valuacion"] = new clsSQLParameter("ctrlvalE2A", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), "", $this->valE2A->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_coef_ajuste"] = new clsSQLParameter("ctrlcoefE2A", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), "", $this->coefE2A->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_valor"] = new clsSQLParameter("ctrlveE2A", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), "", $this->veE2A->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_destino_id"] = new clsSQLParameter("ctrltipo_mejora_destino_id", ccsInteger, "", "", $this->tipo_mejora_destino_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_decla_id"] = new clsSQLParameter("ctrltipo_mejora_decla_id", ccsInteger, "", "", $this->tipo_mejora_decla_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        if (!is_null($this->cp["parcela_id"]->GetValue()) and !strlen($this->cp["parcela_id"]->GetText()) and !is_bool($this->cp["parcela_id"]->GetValue())) 
            $this->cp["parcela_id"]->SetValue($this->parcela_id->GetValue(true));
        if (!is_null($this->cp["mejora_nro_exp"]->GetValue()) and !strlen($this->cp["mejora_nro_exp"]->GetText()) and !is_bool($this->cp["mejora_nro_exp"]->GetValue())) 
            $this->cp["mejora_nro_exp"]->SetValue($this->mejora_nro_exp->GetValue(true));
        if (!is_null($this->cp["mejora_sup_cub"]->GetValue()) and !strlen($this->cp["mejora_sup_cub"]->GetText()) and !is_bool($this->cp["mejora_sup_cub"]->GetValue())) 
            $this->cp["mejora_sup_cub"]->SetValue($this->mejora_sup_cub->GetValue(true));
        if (!is_null($this->cp["mejora_observacion"]->GetValue()) and !strlen($this->cp["mejora_observacion"]->GetText()) and !is_bool($this->cp["mejora_observacion"]->GetValue())) 
            $this->cp["mejora_observacion"]->SetValue($this->mejora_observacion->GetValue(true));
        if (!is_null($this->cp["mejora_letra_exp"]->GetValue()) and !strlen($this->cp["mejora_letra_exp"]->GetText()) and !is_bool($this->cp["mejora_letra_exp"]->GetValue())) 
            $this->cp["mejora_letra_exp"]->SetValue($this->mejora_letra_exp->GetValue(true));
        if (!is_null($this->cp["mejora_fecha_exp"]->GetValue()) and !strlen($this->cp["mejora_fecha_exp"]->GetText()) and !is_bool($this->cp["mejora_fecha_exp"]->GetValue())) 
            $this->cp["mejora_fecha_exp"]->SetValue($this->mejora_fecha_exp->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_id"]->GetValue())) 
            $this->cp["tipo_mejora_id"]->SetValue($this->tipo_mejora_id->GetValue(true));
        if (!is_null($this->cp["mejora_categoria_dpc"]->GetValue()) and !strlen($this->cp["mejora_categoria_dpc"]->GetText()) and !is_bool($this->cp["mejora_categoria_dpc"]->GetValue())) 
            $this->cp["mejora_categoria_dpc"]->SetValue($this->mejora_categoria_dpc->GetValue(true));
        if (!is_null($this->cp["mejora_f_alta"]->GetValue()) and !strlen($this->cp["mejora_f_alta"]->GetText()) and !is_bool($this->cp["mejora_f_alta"]->GetValue())) 
            $this->cp["mejora_f_alta"]->SetValue($this->mejora_f_alta->GetValue(true));
        if (!is_null($this->cp["mejora_f_pro"]->GetValue()) and !strlen($this->cp["mejora_f_pro"]->GetText()) and !is_bool($this->cp["mejora_f_pro"]->GetValue())) 
            $this->cp["mejora_f_pro"]->SetValue($this->mejora_f_pro->GetValue(true));
        if (!is_null($this->cp["audit_string"]->GetValue()) and !strlen($this->cp["audit_string"]->GetText()) and !is_bool($this->cp["audit_string"]->GetValue())) 
            $this->cp["audit_string"]->SetValue($this->audit_string->GetValue(true));
        if (!is_null($this->cp["tipo_estado_id"]->GetValue()) and !strlen($this->cp["tipo_estado_id"]->GetText()) and !is_bool($this->cp["tipo_estado_id"]->GetValue())) 
            $this->cp["tipo_estado_id"]->SetValue($this->tipo_estado_id->GetValue(true));
        if (!is_null($this->cp["mejora_valor"]->GetValue()) and !strlen($this->cp["mejora_valor"]->GetText()) and !is_bool($this->cp["mejora_valor"]->GetValue())) 
            $this->cp["mejora_valor"]->SetValue($this->mejora_valor->GetValue(true));
        if (!is_null($this->cp["mejora_porc_dominio"]->GetValue()) and !strlen($this->cp["mejora_porc_dominio"]->GetText()) and !is_bool($this->cp["mejora_porc_dominio"]->GetValue())) 
            $this->cp["mejora_porc_dominio"]->SetValue($this->mejora_porc_dominio->GetValue(true));
        if (!is_null($this->cp["mejora_sup_semi_cub"]->GetValue()) and !strlen($this->cp["mejora_sup_semi_cub"]->GetText()) and !is_bool($this->cp["mejora_sup_semi_cub"]->GetValue())) 
            $this->cp["mejora_sup_semi_cub"]->SetValue($this->mejora_sup_semi_cub->GetValue(true));
        if (!is_null($this->cp["mejora_f_baja"]->GetValue()) and !strlen($this->cp["mejora_f_baja"]->GetText()) and !is_bool($this->cp["mejora_f_baja"]->GetValue())) 
            $this->cp["mejora_f_baja"]->SetValue($this->mejora_f_baja->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_estado_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_estado_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_estado_id"]->GetValue())) 
            $this->cp["tipo_mejora_estado_id"]->SetValue($this->tipo_mejora_estado_id->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_conserva_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_conserva_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_conserva_id"]->GetValue())) 
            $this->cp["tipo_mejora_conserva_id"]->SetValue($this->tipo_mejora_conserva_id->GetValue(true));
        if (!is_null($this->cp["mejora_anio_construccion"]->GetValue()) and !strlen($this->cp["mejora_anio_construccion"]->GetText()) and !is_bool($this->cp["mejora_anio_construccion"]->GetValue())) 
            $this->cp["mejora_anio_construccion"]->SetValue($this->mejora_anio_construccion->GetValue(true));
        if (!is_null($this->cp["mejora_id"]->GetValue()) and !strlen($this->cp["mejora_id"]->GetText()) and !is_bool($this->cp["mejora_id"]->GetValue())) 
            $this->cp["mejora_id"]->SetValue($this->mejora_id->GetValue(true));
        if (!is_null($this->cp["mejora_form"]->GetValue()) and !strlen($this->cp["mejora_form"]->GetText()) and !is_bool($this->cp["mejora_form"]->GetValue())) 
            $this->cp["mejora_form"]->SetValue($this->mejora_form->GetValue(true));
        if (!is_null($this->cp["usuario_id"]->GetValue()) and !strlen($this->cp["usuario_id"]->GetText()) and !is_bool($this->cp["usuario_id"]->GetValue())) 
            $this->cp["usuario_id"]->SetValue($this->usuario_id->GetValue(true));
        if (!is_null($this->cp["mejora_valuacion"]->GetValue()) and !strlen($this->cp["mejora_valuacion"]->GetText()) and !is_bool($this->cp["mejora_valuacion"]->GetValue())) 
            $this->cp["mejora_valuacion"]->SetValue($this->valE2A->GetValue(true));
        if (!is_null($this->cp["mejora_coef_ajuste"]->GetValue()) and !strlen($this->cp["mejora_coef_ajuste"]->GetText()) and !is_bool($this->cp["mejora_coef_ajuste"]->GetValue())) 
            $this->cp["mejora_coef_ajuste"]->SetValue($this->coefE2A->GetValue(true));
        if (!is_null($this->cp["mejora_valor"]->GetValue()) and !strlen($this->cp["mejora_valor"]->GetText()) and !is_bool($this->cp["mejora_valor"]->GetValue())) 
            $this->cp["mejora_valor"]->SetValue($this->veE2A->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_destino_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_destino_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_destino_id"]->GetValue())) 
            $this->cp["tipo_mejora_destino_id"]->SetValue($this->tipo_mejora_destino_id->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_decla_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_decla_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_decla_id"]->GetValue())) 
            $this->cp["tipo_mejora_decla_id"]->SetValue($this->tipo_mejora_decla_id->GetValue(true));
        $this->InsertFields["parcela_id"]["Value"] = $this->cp["parcela_id"]->GetDBValue(true);
        $this->InsertFields["mejora_nro_exp"]["Value"] = $this->cp["mejora_nro_exp"]->GetDBValue(true);
        $this->InsertFields["mejora_sup_cub"]["Value"] = $this->cp["mejora_sup_cub"]->GetDBValue(true);
        $this->InsertFields["mejora_observacion"]["Value"] = $this->cp["mejora_observacion"]->GetDBValue(true);
        $this->InsertFields["mejora_letra_exp"]["Value"] = $this->cp["mejora_letra_exp"]->GetDBValue(true);
        $this->InsertFields["mejora_fecha_exp"]["Value"] = $this->cp["mejora_fecha_exp"]->GetDBValue(true);
        $this->InsertFields["tipo_mejora_id"]["Value"] = $this->cp["tipo_mejora_id"]->GetDBValue(true);
        $this->InsertFields["mejora_categoria_dpc"]["Value"] = $this->cp["mejora_categoria_dpc"]->GetDBValue(true);
        $this->InsertFields["mejora_f_alta"]["Value"] = $this->cp["mejora_f_alta"]->GetDBValue(true);
        $this->InsertFields["mejora_f_pro"]["Value"] = $this->cp["mejora_f_pro"]->GetDBValue(true);
        $this->InsertFields["audit_string"]["Value"] = $this->cp["audit_string"]->GetDBValue(true);
        $this->InsertFields["tipo_estado_id"]["Value"] = $this->cp["tipo_estado_id"]->GetDBValue(true);
        $this->InsertFields["mejora_valor"]["Value"] = $this->cp["mejora_valor"]->GetDBValue(true);
        $this->InsertFields["mejora_porc_dominio"]["Value"] = $this->cp["mejora_porc_dominio"]->GetDBValue(true);
        $this->InsertFields["mejora_sup_semi_cub"]["Value"] = $this->cp["mejora_sup_semi_cub"]->GetDBValue(true);
        $this->InsertFields["mejora_f_baja"]["Value"] = $this->cp["mejora_f_baja"]->GetDBValue(true);
        $this->InsertFields["tipo_mejora_estado_id"]["Value"] = $this->cp["tipo_mejora_estado_id"]->GetDBValue(true);
        $this->InsertFields["tipo_mejora_conserva_id"]["Value"] = $this->cp["tipo_mejora_conserva_id"]->GetDBValue(true);
        $this->InsertFields["mejora_anio_construccion"]["Value"] = $this->cp["mejora_anio_construccion"]->GetDBValue(true);
        $this->InsertFields["mejora_id"]["Value"] = $this->cp["mejora_id"]->GetDBValue(true);
        $this->InsertFields["mejora_form"]["Value"] = $this->cp["mejora_form"]->GetDBValue(true);
        $this->InsertFields["usuario_id"]["Value"] = $this->cp["usuario_id"]->GetDBValue(true);
        $this->InsertFields["mejora_valuacion"]["Value"] = $this->cp["mejora_valuacion"]->GetDBValue(true);
        $this->InsertFields["mejora_coef_ajuste"]["Value"] = $this->cp["mejora_coef_ajuste"]->GetDBValue(true);
        $this->InsertFields["mejora_valor"]["Value"] = $this->cp["mejora_valor"]->GetDBValue(true);
        $this->InsertFields["tipo_mejora_destino_id"]["Value"] = $this->cp["tipo_mejora_destino_id"]->GetDBValue(true);
        $this->InsertFields["tipo_mejora_decla_id"]["Value"] = $this->cp["tipo_mejora_decla_id"]->GetDBValue(true);
        $this->SQL = CCBuildInsert("mejoras", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @64-8C70CF5E
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["parcela_id"] = new clsSQLParameter("ctrlparcela_id", ccsInteger, "", "", $this->parcela_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_nro_exp"] = new clsSQLParameter("ctrlmejora_nro_exp", ccsInteger, "", "", $this->mejora_nro_exp->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_sup_cub"] = new clsSQLParameter("ctrlmejora_sup_cub", ccsFloat, array(False, 4, Null, "", False, "", "", 1, True, ""), "", $this->mejora_sup_cub->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_observacion"] = new clsSQLParameter("ctrlmejora_observacion", ccsText, "", "", $this->mejora_observacion->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_letra_exp"] = new clsSQLParameter("ctrlmejora_letra_exp", ccsText, "", "", $this->mejora_letra_exp->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_fecha_exp"] = new clsSQLParameter("ctrlmejora_fecha_exp", ccsDate, $DefaultDateFormat, $this->DateFormat, $this->mejora_fecha_exp->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_id"] = new clsSQLParameter("ctrltipo_mejora_id", ccsInteger, "", "", $this->tipo_mejora_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_categoria_dpc"] = new clsSQLParameter("ctrlmejora_categoria_dpc", ccsInteger, "", "", $this->mejora_categoria_dpc->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_f_alta"] = new clsSQLParameter("ctrlmejora_f_alta", ccsDate, $DefaultDateFormat, $this->DateFormat, $this->mejora_f_alta->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_f_pro"] = new clsSQLParameter("ctrlmejora_f_pro", ccsText, "", "", $this->mejora_f_pro->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["audit_string"] = new clsSQLParameter("ctrlaudit_string", ccsText, "", "", $this->audit_string->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_estado_id"] = new clsSQLParameter("ctrltipo_estado_id", ccsInteger, "", "", $this->tipo_estado_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_destino_id"] = new clsSQLParameter("ctrltipo_mejora_destino_id", ccsInteger, "", "", $this->tipo_mejora_destino_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_valor"] = new clsSQLParameter("ctrlmejora_valor", ccsFloat, "", "", $this->mejora_valor->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_porc_dominio"] = new clsSQLParameter("ctrlmejora_porc_dominio", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), "", $this->mejora_porc_dominio->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_sup_semi_cub"] = new clsSQLParameter("ctrlmejora_sup_semi_cub", ccsFloat, array(False, 4, Null, "", False, "", "", 1, True, ""), "", $this->mejora_sup_semi_cub->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_f_baja"] = new clsSQLParameter("ctrlmejora_f_baja", ccsText, "", "", $this->mejora_f_baja->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_id"] = new clsSQLParameter("ctrlmejora_id", ccsText, "", "", $this->mejora_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_cat_id"] = new clsSQLParameter("ctrltipo_mejora_cat_id", ccsInteger, "", "", $this->tipo_mejora_cat_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_estado_id"] = new clsSQLParameter("ctrltipo_mejora_estado_id", ccsInteger, "", "", $this->tipo_mejora_estado_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_conserva_id"] = new clsSQLParameter("ctrltipo_mejora_conserva_id", ccsInteger, "", "", $this->tipo_mejora_conserva_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_anio_construccion"] = new clsSQLParameter("ctrlmejora_anio_construccion", ccsText, "", "", $this->mejora_anio_construccion->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_form"] = new clsSQLParameter("ctrlmejora_form", ccsText, "", "", $this->mejora_form->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["usuario_id"] = new clsSQLParameter("ctrlusuario_id", ccsText, "", "", $this->usuario_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_valuacion"] = new clsSQLParameter("ctrlvalE2A", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), "", $this->valE2A->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_coef_ajuste"] = new clsSQLParameter("ctrlcoefE2A", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), "", $this->coefE2A->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_valor"] = new clsSQLParameter("ctrlveE2A", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), "", $this->veE2A->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_decla_id"] = new clsSQLParameter("ctrltipo_mejora_decla_id", ccsInteger, "", "", $this->tipo_mejora_decla_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $wp = new clsSQLParameters($this->ErrorBlock);
        $wp->AddParameter("1", "urlmejora_id", ccsInteger, "", "", CCGetFromGet("mejora_id", NULL), "", false);
        if(!$wp->AllParamsSet()) {
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        if (!is_null($this->cp["parcela_id"]->GetValue()) and !strlen($this->cp["parcela_id"]->GetText()) and !is_bool($this->cp["parcela_id"]->GetValue())) 
            $this->cp["parcela_id"]->SetValue($this->parcela_id->GetValue(true));
        if (!is_null($this->cp["mejora_nro_exp"]->GetValue()) and !strlen($this->cp["mejora_nro_exp"]->GetText()) and !is_bool($this->cp["mejora_nro_exp"]->GetValue())) 
            $this->cp["mejora_nro_exp"]->SetValue($this->mejora_nro_exp->GetValue(true));
        if (!is_null($this->cp["mejora_sup_cub"]->GetValue()) and !strlen($this->cp["mejora_sup_cub"]->GetText()) and !is_bool($this->cp["mejora_sup_cub"]->GetValue())) 
            $this->cp["mejora_sup_cub"]->SetValue($this->mejora_sup_cub->GetValue(true));
        if (!is_null($this->cp["mejora_observacion"]->GetValue()) and !strlen($this->cp["mejora_observacion"]->GetText()) and !is_bool($this->cp["mejora_observacion"]->GetValue())) 
            $this->cp["mejora_observacion"]->SetValue($this->mejora_observacion->GetValue(true));
        if (!is_null($this->cp["mejora_letra_exp"]->GetValue()) and !strlen($this->cp["mejora_letra_exp"]->GetText()) and !is_bool($this->cp["mejora_letra_exp"]->GetValue())) 
            $this->cp["mejora_letra_exp"]->SetValue($this->mejora_letra_exp->GetValue(true));
        if (!is_null($this->cp["mejora_fecha_exp"]->GetValue()) and !strlen($this->cp["mejora_fecha_exp"]->GetText()) and !is_bool($this->cp["mejora_fecha_exp"]->GetValue())) 
            $this->cp["mejora_fecha_exp"]->SetValue($this->mejora_fecha_exp->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_id"]->GetValue())) 
            $this->cp["tipo_mejora_id"]->SetValue($this->tipo_mejora_id->GetValue(true));
        if (!is_null($this->cp["mejora_categoria_dpc"]->GetValue()) and !strlen($this->cp["mejora_categoria_dpc"]->GetText()) and !is_bool($this->cp["mejora_categoria_dpc"]->GetValue())) 
            $this->cp["mejora_categoria_dpc"]->SetValue($this->mejora_categoria_dpc->GetValue(true));
        if (!is_null($this->cp["mejora_f_alta"]->GetValue()) and !strlen($this->cp["mejora_f_alta"]->GetText()) and !is_bool($this->cp["mejora_f_alta"]->GetValue())) 
            $this->cp["mejora_f_alta"]->SetValue($this->mejora_f_alta->GetValue(true));
        if (!is_null($this->cp["mejora_f_pro"]->GetValue()) and !strlen($this->cp["mejora_f_pro"]->GetText()) and !is_bool($this->cp["mejora_f_pro"]->GetValue())) 
            $this->cp["mejora_f_pro"]->SetValue($this->mejora_f_pro->GetValue(true));
        if (!is_null($this->cp["audit_string"]->GetValue()) and !strlen($this->cp["audit_string"]->GetText()) and !is_bool($this->cp["audit_string"]->GetValue())) 
            $this->cp["audit_string"]->SetValue($this->audit_string->GetValue(true));
        if (!is_null($this->cp["tipo_estado_id"]->GetValue()) and !strlen($this->cp["tipo_estado_id"]->GetText()) and !is_bool($this->cp["tipo_estado_id"]->GetValue())) 
            $this->cp["tipo_estado_id"]->SetValue($this->tipo_estado_id->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_destino_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_destino_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_destino_id"]->GetValue())) 
            $this->cp["tipo_mejora_destino_id"]->SetValue($this->tipo_mejora_destino_id->GetValue(true));
        if (!is_null($this->cp["mejora_valor"]->GetValue()) and !strlen($this->cp["mejora_valor"]->GetText()) and !is_bool($this->cp["mejora_valor"]->GetValue())) 
            $this->cp["mejora_valor"]->SetValue($this->mejora_valor->GetValue(true));
        if (!is_null($this->cp["mejora_porc_dominio"]->GetValue()) and !strlen($this->cp["mejora_porc_dominio"]->GetText()) and !is_bool($this->cp["mejora_porc_dominio"]->GetValue())) 
            $this->cp["mejora_porc_dominio"]->SetValue($this->mejora_porc_dominio->GetValue(true));
        if (!is_null($this->cp["mejora_sup_semi_cub"]->GetValue()) and !strlen($this->cp["mejora_sup_semi_cub"]->GetText()) and !is_bool($this->cp["mejora_sup_semi_cub"]->GetValue())) 
            $this->cp["mejora_sup_semi_cub"]->SetValue($this->mejora_sup_semi_cub->GetValue(true));
        if (!is_null($this->cp["mejora_f_baja"]->GetValue()) and !strlen($this->cp["mejora_f_baja"]->GetText()) and !is_bool($this->cp["mejora_f_baja"]->GetValue())) 
            $this->cp["mejora_f_baja"]->SetValue($this->mejora_f_baja->GetValue(true));
        if (!is_null($this->cp["mejora_id"]->GetValue()) and !strlen($this->cp["mejora_id"]->GetText()) and !is_bool($this->cp["mejora_id"]->GetValue())) 
            $this->cp["mejora_id"]->SetValue($this->mejora_id->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_cat_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_cat_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_cat_id"]->GetValue())) 
            $this->cp["tipo_mejora_cat_id"]->SetValue($this->tipo_mejora_cat_id->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_estado_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_estado_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_estado_id"]->GetValue())) 
            $this->cp["tipo_mejora_estado_id"]->SetValue($this->tipo_mejora_estado_id->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_conserva_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_conserva_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_conserva_id"]->GetValue())) 
            $this->cp["tipo_mejora_conserva_id"]->SetValue($this->tipo_mejora_conserva_id->GetValue(true));
        if (!is_null($this->cp["mejora_anio_construccion"]->GetValue()) and !strlen($this->cp["mejora_anio_construccion"]->GetText()) and !is_bool($this->cp["mejora_anio_construccion"]->GetValue())) 
            $this->cp["mejora_anio_construccion"]->SetValue($this->mejora_anio_construccion->GetValue(true));
        if (!is_null($this->cp["mejora_form"]->GetValue()) and !strlen($this->cp["mejora_form"]->GetText()) and !is_bool($this->cp["mejora_form"]->GetValue())) 
            $this->cp["mejora_form"]->SetValue($this->mejora_form->GetValue(true));
        if (!is_null($this->cp["usuario_id"]->GetValue()) and !strlen($this->cp["usuario_id"]->GetText()) and !is_bool($this->cp["usuario_id"]->GetValue())) 
            $this->cp["usuario_id"]->SetValue($this->usuario_id->GetValue(true));
        if (!is_null($this->cp["mejora_valuacion"]->GetValue()) and !strlen($this->cp["mejora_valuacion"]->GetText()) and !is_bool($this->cp["mejora_valuacion"]->GetValue())) 
            $this->cp["mejora_valuacion"]->SetValue($this->valE2A->GetValue(true));
        if (!is_null($this->cp["mejora_coef_ajuste"]->GetValue()) and !strlen($this->cp["mejora_coef_ajuste"]->GetText()) and !is_bool($this->cp["mejora_coef_ajuste"]->GetValue())) 
            $this->cp["mejora_coef_ajuste"]->SetValue($this->coefE2A->GetValue(true));
        if (!is_null($this->cp["mejora_valor"]->GetValue()) and !strlen($this->cp["mejora_valor"]->GetText()) and !is_bool($this->cp["mejora_valor"]->GetValue())) 
            $this->cp["mejora_valor"]->SetValue($this->veE2A->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_decla_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_decla_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_decla_id"]->GetValue())) 
            $this->cp["tipo_mejora_decla_id"]->SetValue($this->tipo_mejora_decla_id->GetValue(true));
        $wp->Criterion[1] = $wp->Operation(opEqual, "mejora_id", $wp->GetDBValue("1"), $this->ToSQL($wp->GetDBValue("1"), ccsInteger),false);
        $Where = 
             $wp->Criterion[1];
        $this->UpdateFields["parcela_id"]["Value"] = $this->cp["parcela_id"]->GetDBValue(true);
        $this->UpdateFields["mejora_nro_exp"]["Value"] = $this->cp["mejora_nro_exp"]->GetDBValue(true);
        $this->UpdateFields["mejora_sup_cub"]["Value"] = $this->cp["mejora_sup_cub"]->GetDBValue(true);
        $this->UpdateFields["mejora_observacion"]["Value"] = $this->cp["mejora_observacion"]->GetDBValue(true);
        $this->UpdateFields["mejora_letra_exp"]["Value"] = $this->cp["mejora_letra_exp"]->GetDBValue(true);
        $this->UpdateFields["mejora_fecha_exp"]["Value"] = $this->cp["mejora_fecha_exp"]->GetDBValue(true);
        $this->UpdateFields["tipo_mejora_id"]["Value"] = $this->cp["tipo_mejora_id"]->GetDBValue(true);
        $this->UpdateFields["mejora_categoria_dpc"]["Value"] = $this->cp["mejora_categoria_dpc"]->GetDBValue(true);
        $this->UpdateFields["mejora_f_alta"]["Value"] = $this->cp["mejora_f_alta"]->GetDBValue(true);
        $this->UpdateFields["mejora_f_pro"]["Value"] = $this->cp["mejora_f_pro"]->GetDBValue(true);
        $this->UpdateFields["audit_string"]["Value"] = $this->cp["audit_string"]->GetDBValue(true);
        $this->UpdateFields["tipo_estado_id"]["Value"] = $this->cp["tipo_estado_id"]->GetDBValue(true);
        $this->UpdateFields["tipo_mejora_destino_id"]["Value"] = $this->cp["tipo_mejora_destino_id"]->GetDBValue(true);
        $this->UpdateFields["mejora_valor"]["Value"] = $this->cp["mejora_valor"]->GetDBValue(true);
        $this->UpdateFields["mejora_porc_dominio"]["Value"] = $this->cp["mejora_porc_dominio"]->GetDBValue(true);
        $this->UpdateFields["mejora_sup_semi_cub"]["Value"] = $this->cp["mejora_sup_semi_cub"]->GetDBValue(true);
        $this->UpdateFields["mejora_f_baja"]["Value"] = $this->cp["mejora_f_baja"]->GetDBValue(true);
        $this->UpdateFields["mejora_id"]["Value"] = $this->cp["mejora_id"]->GetDBValue(true);
        $this->UpdateFields["tipo_mejora_cat_id"]["Value"] = $this->cp["tipo_mejora_cat_id"]->GetDBValue(true);
        $this->UpdateFields["tipo_mejora_estado_id"]["Value"] = $this->cp["tipo_mejora_estado_id"]->GetDBValue(true);
        $this->UpdateFields["tipo_mejora_conserva_id"]["Value"] = $this->cp["tipo_mejora_conserva_id"]->GetDBValue(true);
        $this->UpdateFields["mejora_anio_construccion"]["Value"] = $this->cp["mejora_anio_construccion"]->GetDBValue(true);
        $this->UpdateFields["mejora_form"]["Value"] = $this->cp["mejora_form"]->GetDBValue(true);
        $this->UpdateFields["usuario_id"]["Value"] = $this->cp["usuario_id"]->GetDBValue(true);
        $this->UpdateFields["mejora_valuacion"]["Value"] = $this->cp["mejora_valuacion"]->GetDBValue(true);
        $this->UpdateFields["mejora_coef_ajuste"]["Value"] = $this->cp["mejora_coef_ajuste"]->GetDBValue(true);
        $this->UpdateFields["mejora_valor"]["Value"] = $this->cp["mejora_valor"]->GetDBValue(true);
        $this->UpdateFields["tipo_mejora_decla_id"]["Value"] = $this->cp["tipo_mejora_decla_id"]->GetDBValue(true);
        $this->SQL = CCBuildUpdate("mejoras", $this->UpdateFields, $this);
        $this->SQL .= strlen($Where) ? " WHERE " . $Where : $Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

} //End mejorasDataSource Class @64-FCB6E20C

//Include Page implementation @140-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @141-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @142-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Include Page implementation @115-6A9CF48F
include_once(RelativePath . "/gestion/footerParcela.php");
//End Include Page implementation

//Include Page implementation @5-000D2F68
include_once(RelativePath . "/gestion/headerParcela.php");
//End Include Page implementation

class clsRecordparcelas { //parcelas Class @197-F41C09A9

//Variables @197-9E315808

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

//Class_Initialize Event @197-FA170CA6
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
        $this->DataSource = new clsparcelasDataSource($this);
        $this->ds = & $this->DataSource;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "parcelas";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->parcela_val_tierra = new clsControl(ccsTextBox, "parcela_val_tierra", "Val Tierra", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("parcela_val_tierra", $Method, NULL), $this);
            $this->parcela_val_mejora = new clsControl(ccsTextBox, "parcela_val_mejora", "Val Mejora", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("parcela_val_mejora", $Method, NULL), $this);
            $this->parcela_val_ampliac = new clsControl(ccsTextBox, "parcela_val_ampliac", "Val Ampliac", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("parcela_val_ampliac", $Method, NULL), $this);
            $this->parcela_val_total = new clsControl(ccsTextBox, "parcela_val_total", "Val Total", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("parcela_val_total", $Method, NULL), $this);
            $this->parcela_porc_uf = new clsControl(ccsHidden, "parcela_porc_uf", "parcela_porc_uf", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("parcela_porc_uf", $Method, NULL), $this);
            $this->ImageLink2 = new clsControl(ccsImageLink, "ImageLink2", "ImageLink2", ccsText, "", CCGetRequestParam("ImageLink2", $Method, NULL), $this);
            $this->ImageLink2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
            $this->ImageLink2->Page = "mejoraValores.php";
            $this->ImageLink1 = new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", CCGetRequestParam("ImageLink1", $Method, NULL), $this);
            $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
            $this->ImageLink1->Page = "mejorasCoeficientes.php";
            $this->addMejoraE1 = new clsControl(ccsImageLink, "addMejoraE1", "addMejoraE1", ccsText, "", CCGetRequestParam("addMejoraE1", $Method, NULL), $this);
            $this->addMejoraE1->Page = "";
            $this->addMejoraE2 = new clsControl(ccsImageLink, "addMejoraE2", "addMejoraE2", ccsText, "", CCGetRequestParam("addMejoraE2", $Method, NULL), $this);
            $this->addMejoraE2->Page = "";
            $this->ImageLink3 = new clsControl(ccsImageLink, "ImageLink3", "ImageLink3", ccsText, "", CCGetRequestParam("ImageLink3", $Method, NULL), $this);
            $this->ImageLink3->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
            $this->ImageLink3->Page = "mejoraajuste.php";
            $this->paso = new clsControl(ccsHidden, "paso", "paso", ccsText, "", CCGetRequestParam("paso", $Method, NULL), $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->parcela_val_tierra->Value) && !strlen($this->parcela_val_tierra->Value) && $this->parcela_val_tierra->Value !== false)
                    $this->parcela_val_tierra->SetText(0);
                if(!is_array($this->parcela_val_mejora->Value) && !strlen($this->parcela_val_mejora->Value) && $this->parcela_val_mejora->Value !== false)
                    $this->parcela_val_mejora->SetText(0);
                if(!is_array($this->parcela_val_ampliac->Value) && !strlen($this->parcela_val_ampliac->Value) && $this->parcela_val_ampliac->Value !== false)
                    $this->parcela_val_ampliac->SetText(0);
                if(!is_array($this->parcela_val_total->Value) && !strlen($this->parcela_val_total->Value) && $this->parcela_val_total->Value !== false)
                    $this->parcela_val_total->SetText(0);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @197-16FD92D0
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlparcela_id"] = CCGetFromGet("parcela_id", NULL);
    }
//End Initialize Method

//Validate Method @197-3905258C
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->parcela_val_tierra->Validate() && $Validation);
        $Validation = ($this->parcela_val_mejora->Validate() && $Validation);
        $Validation = ($this->parcela_val_ampliac->Validate() && $Validation);
        $Validation = ($this->parcela_val_total->Validate() && $Validation);
        $Validation = ($this->parcela_porc_uf->Validate() && $Validation);
        $Validation = ($this->paso->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->parcela_val_tierra->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_val_mejora->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_val_ampliac->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_val_total->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_porc_uf->Errors->Count() == 0);
        $Validation =  $Validation && ($this->paso->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @197-C29DFB2C
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->parcela_val_tierra->Errors->Count());
        $errors = ($errors || $this->parcela_val_mejora->Errors->Count());
        $errors = ($errors || $this->parcela_val_ampliac->Errors->Count());
        $errors = ($errors || $this->parcela_val_total->Errors->Count());
        $errors = ($errors || $this->parcela_porc_uf->Errors->Count());
        $errors = ($errors || $this->ImageLink2->Errors->Count());
        $errors = ($errors || $this->ImageLink1->Errors->Count());
        $errors = ($errors || $this->addMejoraE1->Errors->Count());
        $errors = ($errors || $this->addMejoraE2->Errors->Count());
        $errors = ($errors || $this->ImageLink3->Errors->Count());
        $errors = ($errors || $this->paso->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @197-ED598703
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

//Operation Method @197-517B5C36
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

        if($this->FormSubmitted) {
            $this->PressedButton = $this->EditMode ? "Button_Update" : "";
            if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->Validate()) {
            if($this->PressedButton == "Button_Update") {
                if(!CCGetEvent($this->Button_Update->CCSEvents, "OnClick", $this->Button_Update) || !$this->UpdateRow()) {
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

//UpdateRow Method @197-C72B2F24
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->parcela_val_tierra->SetValue($this->parcela_val_tierra->GetValue(true));
        $this->DataSource->parcela_val_mejora->SetValue($this->parcela_val_mejora->GetValue(true));
        $this->DataSource->parcela_val_ampliac->SetValue($this->parcela_val_ampliac->GetValue(true));
        $this->DataSource->parcela_val_total->SetValue($this->parcela_val_total->GetValue(true));
        $this->DataSource->parcela_porc_uf->SetValue($this->parcela_porc_uf->GetValue(true));
        $this->DataSource->ImageLink2->SetValue($this->ImageLink2->GetValue(true));
        $this->DataSource->ImageLink1->SetValue($this->ImageLink1->GetValue(true));
        $this->DataSource->addMejoraE1->SetValue($this->addMejoraE1->GetValue(true));
        $this->DataSource->addMejoraE2->SetValue($this->addMejoraE2->GetValue(true));
        $this->DataSource->ImageLink3->SetValue($this->ImageLink3->GetValue(true));
        $this->DataSource->paso->SetValue($this->paso->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @197-A007CDC5
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
        if($this->EditMode) {
            if($this->DataSource->Errors->Count()){
                $this->Errors->AddErrors($this->DataSource->Errors);
                $this->DataSource->Errors->clear();
            }
            $this->DataSource->Open();
            if($this->DataSource->Errors->Count() == 0 && $this->DataSource->next_record()) {
                $this->DataSource->SetValues();
                if(!$this->FormSubmitted){
                    $this->parcela_val_tierra->SetValue($this->DataSource->parcela_val_tierra->GetValue());
                    $this->parcela_val_mejora->SetValue($this->DataSource->parcela_val_mejora->GetValue());
                    $this->parcela_val_ampliac->SetValue($this->DataSource->parcela_val_ampliac->GetValue());
                    $this->parcela_val_total->SetValue($this->DataSource->parcela_val_total->GetValue());
                    $this->parcela_porc_uf->SetValue($this->DataSource->parcela_porc_uf->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }
        if (!$this->FormSubmitted) {
        }
        $this->addMejoraE1->Parameters = CCGetQueryString("QueryString", array("mejora_id", "ccsForm"));
        $this->addMejoraE1->Parameters = CCAddParam($this->addMejoraE1->Parameters, "add", 1);
        $this->addMejoraE1->Parameters = CCAddParam($this->addMejoraE1->Parameters, "f", E1);
        $this->addMejoraE2->Parameters = CCGetQueryString("QueryString", array("mejora_id", "ccsForm"));
        $this->addMejoraE2->Parameters = CCAddParam($this->addMejoraE2->Parameters, "add", 1);
        $this->addMejoraE2->Parameters = CCAddParam($this->addMejoraE2->Parameters, "f", E2);

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->parcela_val_tierra->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_val_mejora->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_val_ampliac->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_val_total->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_porc_uf->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ImageLink2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ImageLink1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->addMejoraE1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->addMejoraE2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ImageLink3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->paso->Errors->ToString());
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
        $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Update->Show();
        $this->parcela_val_tierra->Show();
        $this->parcela_val_mejora->Show();
        $this->parcela_val_ampliac->Show();
        $this->parcela_val_total->Show();
        $this->parcela_porc_uf->Show();
        $this->ImageLink2->Show();
        $this->ImageLink1->Show();
        $this->addMejoraE1->Show();
        $this->addMejoraE2->Show();
        $this->ImageLink3->Show();
        $this->paso->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End parcelas Class @197-FCB6E20C

class clsparcelasDataSource extends clsDBtdf_nuevo {  //parcelasDataSource Class @197-DA23B507

//DataSource Variables @197-9EADC6B8
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $UpdateParameters;
    public $wp;
    public $AllParametersSet;

    public $UpdateFields = array();

    // Datasource fields
    public $parcela_val_tierra;
    public $parcela_val_mejora;
    public $parcela_val_ampliac;
    public $parcela_val_total;
    public $parcela_porc_uf;
    public $ImageLink2;
    public $ImageLink1;
    public $addMejoraE1;
    public $addMejoraE2;
    public $ImageLink3;
    public $paso;
//End DataSource Variables

//DataSourceClass_Initialize Event @197-41B95A3A
    function clsparcelasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record parcelas/Error";
        $this->Initialize();
        $this->parcela_val_tierra = new clsField("parcela_val_tierra", ccsFloat, "");
        
        $this->parcela_val_mejora = new clsField("parcela_val_mejora", ccsFloat, "");
        
        $this->parcela_val_ampliac = new clsField("parcela_val_ampliac", ccsFloat, "");
        
        $this->parcela_val_total = new clsField("parcela_val_total", ccsFloat, "");
        
        $this->parcela_porc_uf = new clsField("parcela_porc_uf", ccsFloat, "");
        
        $this->ImageLink2 = new clsField("ImageLink2", ccsText, "");
        
        $this->ImageLink1 = new clsField("ImageLink1", ccsText, "");
        
        $this->addMejoraE1 = new clsField("addMejoraE1", ccsText, "");
        
        $this->addMejoraE2 = new clsField("addMejoraE2", ccsText, "");
        
        $this->ImageLink3 = new clsField("ImageLink3", ccsText, "");
        
        $this->paso = new clsField("paso", ccsText, "");
        

        $this->UpdateFields["parcela_val_tierra"] = array("Name" => "parcela_val_tierra", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_val_mejora"] = array("Name" => "parcela_val_mejora", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_val_ampliac"] = array("Name" => "parcela_val_ampliac", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_val_total"] = array("Name" => "parcela_val_total", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_porc_uf"] = array("Name" => "parcela_porc_uf", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @197-CCE5C7B7
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlparcela_id", ccsInteger, "", "", $this->Parameters["urlparcela_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "parcela_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @197-3419905D
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM parcelas {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @197-63ACA865
    function SetValues()
    {
        $this->parcela_val_tierra->SetDBValue(trim($this->f("parcela_val_tierra")));
        $this->parcela_val_mejora->SetDBValue(trim($this->f("parcela_val_mejora")));
        $this->parcela_val_ampliac->SetDBValue(trim($this->f("parcela_val_ampliac")));
        $this->parcela_val_total->SetDBValue(trim($this->f("parcela_val_total")));
        $this->parcela_porc_uf->SetDBValue(trim($this->f("parcela_porc_uf")));
    }
//End SetValues Method

//Update Method @197-163AA65A
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["parcela_val_tierra"]["Value"] = $this->parcela_val_tierra->GetDBValue(true);
        $this->UpdateFields["parcela_val_mejora"]["Value"] = $this->parcela_val_mejora->GetDBValue(true);
        $this->UpdateFields["parcela_val_ampliac"]["Value"] = $this->parcela_val_ampliac->GetDBValue(true);
        $this->UpdateFields["parcela_val_total"]["Value"] = $this->parcela_val_total->GetDBValue(true);
        $this->UpdateFields["parcela_porc_uf"]["Value"] = $this->parcela_porc_uf->GetDBValue(true);
        $this->SQL = CCBuildUpdate("parcelas", $this->UpdateFields, $this);
        $this->SQL .= strlen($this->Where) ? " WHERE " . $this->Where : $this->Where;
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

} //End parcelasDataSource Class @197-FCB6E20C

class clsRecordmejoras1 { //mejoras1 Class @356-F36D7971

//Variables @356-9E315808

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

//Class_Initialize Event @356-A2A300E2
    function clsRecordmejoras1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record mejoras1/Error";
        $this->DataSource = new clsmejoras1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->ReadAllowed = true;
        $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
        if($this->Visible)
        {
            $this->ReadAllowed = $this->ReadAllowed && CCUserInGroups(CCGetGroupID(), "1;2");
            $this->InsertAllowed = CCUserInGroups(CCGetGroupID(), "2");
            $this->UpdateAllowed = CCUserInGroups(CCGetGroupID(), "2");
            $this->ComponentName = "mejoras1";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->Button_Delete = new clsButton("Button_Delete", $Method, $this);
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->parcela_id = new clsControl(ccsHidden, "parcela_id", "Parcela Id", ccsInteger, "", CCGetRequestParam("parcela_id", $Method, NULL), $this);
            $this->mejora_nro_exp = new clsControl(ccsTextBox, "mejora_nro_exp", "Nro Exp", ccsInteger, "", CCGetRequestParam("mejora_nro_exp", $Method, NULL), $this);
            $this->mejora_observacion = new clsControl(ccsTextBox, "mejora_observacion", "Observacion", ccsText, "", CCGetRequestParam("mejora_observacion", $Method, NULL), $this);
            $this->mejora_letra_exp = new clsControl(ccsTextBox, "mejora_letra_exp", "Letra Exp", ccsText, "", CCGetRequestParam("mejora_letra_exp", $Method, NULL), $this);
            $this->mejora_fecha_exp = new clsControl(ccsTextBox, "mejora_fecha_exp", "Fecha Exp", ccsDate, $DefaultDateFormat, CCGetRequestParam("mejora_fecha_exp", $Method, NULL), $this);
            $this->DatePicker_mejora_fecha_exp = new clsDatePicker("DatePicker_mejora_fecha_exp", "mejoras1", "mejora_fecha_exp", $this);
            $this->mejora_categoria_dpc = new clsControl(ccsHidden, "mejora_categoria_dpc", "Categoria Dpc", ccsInteger, "", CCGetRequestParam("mejora_categoria_dpc", $Method, NULL), $this);
            $this->mejora_f_pro = new clsControl(ccsHidden, "mejora_f_pro", "F Pro", ccsText, "", CCGetRequestParam("mejora_f_pro", $Method, NULL), $this);
            $this->mejora_f_pro->Required = true;
            $this->audit_string = new clsControl(ccsHidden, "audit_string", "audit_string", ccsText, "", CCGetRequestParam("audit_string", $Method, NULL), $this);
            $this->tipo_estado_id = new clsControl(ccsHidden, "tipo_estado_id", "tipo_estado_id", ccsInteger, "", CCGetRequestParam("tipo_estado_id", $Method, NULL), $this);
            $this->baja = new clsControl(ccsLabel, "baja", "baja", ccsText, "", CCGetRequestParam("baja", $Method, NULL), $this);
            $this->baja->HTML = true;
            $this->sup_terreno = new clsControl(ccsHidden, "sup_terreno", "sup_terreno", ccsFloat, "", CCGetRequestParam("sup_terreno", $Method, NULL), $this);
            $this->Button_alta = new clsButton("Button_alta", $Method, $this);
            $this->mejora_f_baja = new clsControl(ccsHidden, "mejora_f_baja", "mejora_f_baja", ccsText, "", CCGetRequestParam("mejora_f_baja", $Method, NULL), $this);
            $this->mejora_nro_nota = new clsControl(ccsTextBox, "mejora_nro_nota", "mejora_nro_nota", ccsText, "", CCGetRequestParam("mejora_nro_nota", $Method, NULL), $this);
            $this->mejora_id = new clsControl(ccsHidden, "mejora_id", "mejora_id", ccsText, "", CCGetRequestParam("mejora_id", $Method, NULL), $this);
            $this->motivo_baja = new clsControl(ccsLabel, "motivo_baja", "motivo_baja", ccsText, "", CCGetRequestParam("motivo_baja", $Method, NULL), $this);
            $this->motivo_baja->HTML = true;
            $this->cantE1B = new clsControl(ccsTextBox, "cantE1B", "cantE1B", ccsInteger, "", CCGetRequestParam("cantE1B", $Method, NULL), $this);
            $this->cantE1C = new clsControl(ccsTextBox, "cantE1C", "cantE1C", ccsInteger, "", CCGetRequestParam("cantE1C", $Method, NULL), $this);
            $this->cantE1T = new clsControl(ccsTextBox, "cantE1T", "cantE1T", ccsInteger, "", CCGetRequestParam("cantE1T", $Method, NULL), $this);
            $this->valE1B = new clsControl(ccsTextBox, "valE1B", "valE1B", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("valE1B", $Method, NULL), $this);
            $this->valE1C = new clsControl(ccsTextBox, "valE1C", "valE1C", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("valE1C", $Method, NULL), $this);
            $this->calE1T = new clsControl(ccsTextBox, "calE1T", "calE1T", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("calE1T", $Method, NULL), $this);
            $this->calE1B = new clsControl(ccsTextBox, "calE1B", "calE1B", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("calE1B", $Method, NULL), $this);
            $this->calE1C = new clsControl(ccsTextBox, "calE1C", "calE1C", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("calE1C", $Method, NULL), $this);
            $this->vuE1T = new clsControl(ccsTextBox, "vuE1T", "vuE1T", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("vuE1T", $Method, NULL), $this);
            $this->tipo_mejora_conserva_id = new clsControl(ccsListBox, "tipo_mejora_conserva_id", "Conservacion", ccsInteger, "", CCGetRequestParam("tipo_mejora_conserva_id", $Method, NULL), $this);
            $this->tipo_mejora_conserva_id->DSType = dsTable;
            $this->tipo_mejora_conserva_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_mejora_conserva_id->ds = & $this->tipo_mejora_conserva_id->DataSource;
            $this->tipo_mejora_conserva_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_mejoras_conserva {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_mejora_conserva_id->BoundColumn, $this->tipo_mejora_conserva_id->TextColumn, $this->tipo_mejora_conserva_id->DBFormat) = array("tipo_mejora_conserva_id", "tipo_mejora_conserva_descrip", "");
            $this->coefE1_1 = new clsControl(ccsTextBox, "coefE1_1", "coefE1_1", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("coefE1_1", $Method, NULL), $this);
            $this->vuE1T_2 = new clsControl(ccsTextBox, "vuE1T_2", "vuE1T_2", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("vuE1T_2", $Method, NULL), $this);
            $this->tipo_mejora_cat_id = new clsControl(ccsListBox, "tipo_mejora_cat_id", "Categoria", ccsInteger, "", CCGetRequestParam("tipo_mejora_cat_id", $Method, NULL), $this);
            $this->tipo_mejora_cat_id->DSType = dsTable;
            $this->tipo_mejora_cat_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_mejora_cat_id->ds = & $this->tipo_mejora_cat_id->DataSource;
            $this->tipo_mejora_cat_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_mejoras_cat {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_mejora_cat_id->BoundColumn, $this->tipo_mejora_cat_id->TextColumn, $this->tipo_mejora_cat_id->DBFormat) = array("tipo_mejora_cat_id", "tipo_mejora_cat_descript", "");
            $this->cantE1A = new clsControl(ccsTextBox, "cantE1A", "cantE1A", ccsInteger, "", CCGetRequestParam("cantE1A", $Method, NULL), $this);
            $this->valE1A = new clsControl(ccsTextBox, "valE1A", "valE1A", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("valE1A", $Method, NULL), $this);
            $this->calE1A = new clsControl(ccsTextBox, "calE1A", "calE1A", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("calE1A", $Method, NULL), $this);
            $this->mejora_sup_semi_cub = new clsControl(ccsTextBox, "mejora_sup_semi_cub", "Sup Semi Cubierta", ccsFloat, "", CCGetRequestParam("mejora_sup_semi_cub", $Method, NULL), $this);
            $this->mejora_sup_cub = new clsControl(ccsTextBox, "mejora_sup_cub", "Superficie Cubierta", ccsFloat, "", CCGetRequestParam("mejora_sup_cub", $Method, NULL), $this);
            $this->mejora_porc_dominio = new clsControl(ccsHidden, "mejora_porc_dominio", "Porc Dominio", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("mejora_porc_dominio", $Method, NULL), $this);
            $this->tipo_mejora_conserva_id_2 = new clsControl(ccsListBox, "tipo_mejora_conserva_id_2", "tipo_mejora_conserva_id_2", ccsInteger, "", CCGetRequestParam("tipo_mejora_conserva_id_2", $Method, NULL), $this);
            $this->tipo_mejora_conserva_id_2->DSType = dsTable;
            $this->tipo_mejora_conserva_id_2->DataSource = new clsDBtdf_nuevo();
            $this->tipo_mejora_conserva_id_2->ds = & $this->tipo_mejora_conserva_id_2->DataSource;
            $this->tipo_mejora_conserva_id_2->DataSource->SQL = "SELECT * \n" .
"FROM tipos_mejoras_conserva {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_mejora_conserva_id_2->BoundColumn, $this->tipo_mejora_conserva_id_2->TextColumn, $this->tipo_mejora_conserva_id_2->DBFormat) = array("tipo_mejora_conserva_id", "tipo_mejora_conserva_descrip", "");
            $this->mejora_anio_construccion_2 = new clsControl(ccsListBox, "mejora_anio_construccion_2", "mejora_anio_construccion_2", ccsText, "", CCGetRequestParam("mejora_anio_construccion_2", $Method, NULL), $this);
            $this->mejora_anio_construccion_2->DSType = dsTable;
            $this->mejora_anio_construccion_2->DataSource = new clsDBtdf_nuevo();
            $this->mejora_anio_construccion_2->ds = & $this->mejora_anio_construccion_2->DataSource;
            $this->mejora_anio_construccion_2->DataSource->SQL = "SELECT * \n" .
"FROM mejoras_coeficientes {SQL_Where}\n" .
"GROUP BY mejora_coeficiente_anio {SQL_OrderBy}";
            $this->mejora_anio_construccion_2->DataSource->Order = "mejora_coeficiente_anio desc";
            list($this->mejora_anio_construccion_2->BoundColumn, $this->mejora_anio_construccion_2->TextColumn, $this->mejora_anio_construccion_2->DBFormat) = array("mejora_coeficiente_anio", "mejora_coeficiente_anio", "");
            $this->mejora_anio_construccion_2->DataSource->Order = "mejora_coeficiente_anio desc";
            $this->tipo_mejora_cat_id_2 = new clsControl(ccsListBox, "tipo_mejora_cat_id_2", "tipo_mejora_cat_id_2", ccsInteger, "", CCGetRequestParam("tipo_mejora_cat_id_2", $Method, NULL), $this);
            $this->tipo_mejora_cat_id_2->DSType = dsTable;
            $this->tipo_mejora_cat_id_2->DataSource = new clsDBtdf_nuevo();
            $this->tipo_mejora_cat_id_2->ds = & $this->tipo_mejora_cat_id_2->DataSource;
            $this->tipo_mejora_cat_id_2->DataSource->SQL = "SELECT * \n" .
"FROM tipos_mejoras_cat {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_mejora_cat_id_2->BoundColumn, $this->tipo_mejora_cat_id_2->TextColumn, $this->tipo_mejora_cat_id_2->DBFormat) = array("tipo_mejora_cat_id", "tipo_mejora_cat_descript", "");
            $this->coefE1_2 = new clsControl(ccsTextBox, "coefE1_2", "coefE1_2", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("coefE1_2", $Method, NULL), $this);
            $this->tipo_mejora_conserva_id_3 = new clsControl(ccsListBox, "tipo_mejora_conserva_id_3", "tipo_mejora_conserva_id_3", ccsInteger, "", CCGetRequestParam("tipo_mejora_conserva_id_3", $Method, NULL), $this);
            $this->tipo_mejora_conserva_id_3->DSType = dsTable;
            $this->tipo_mejora_conserva_id_3->DataSource = new clsDBtdf_nuevo();
            $this->tipo_mejora_conserva_id_3->ds = & $this->tipo_mejora_conserva_id_3->DataSource;
            $this->tipo_mejora_conserva_id_3->DataSource->SQL = "SELECT * \n" .
"FROM tipos_mejoras_conserva {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_mejora_conserva_id_3->BoundColumn, $this->tipo_mejora_conserva_id_3->TextColumn, $this->tipo_mejora_conserva_id_3->DBFormat) = array("tipo_mejora_conserva_id", "tipo_mejora_conserva_descrip", "");
            $this->mejora_anio_construccion_3 = new clsControl(ccsListBox, "mejora_anio_construccion_3", "mejora_anio_construccion_3", ccsText, "", CCGetRequestParam("mejora_anio_construccion_3", $Method, NULL), $this);
            $this->mejora_anio_construccion_3->DSType = dsTable;
            $this->mejora_anio_construccion_3->DataSource = new clsDBtdf_nuevo();
            $this->mejora_anio_construccion_3->ds = & $this->mejora_anio_construccion_3->DataSource;
            $this->mejora_anio_construccion_3->DataSource->SQL = "SELECT * \n" .
"FROM mejoras_coeficientes {SQL_Where}\n" .
"GROUP BY mejora_coeficiente_anio {SQL_OrderBy}";
            $this->mejora_anio_construccion_3->DataSource->Order = "mejora_coeficiente_anio desc";
            list($this->mejora_anio_construccion_3->BoundColumn, $this->mejora_anio_construccion_3->TextColumn, $this->mejora_anio_construccion_3->DBFormat) = array("mejora_coeficiente_anio", "mejora_coeficiente_anio", "");
            $this->mejora_anio_construccion_3->DataSource->Order = "mejora_coeficiente_anio desc";
            $this->tipo_mejora_cat_id_3 = new clsControl(ccsListBox, "tipo_mejora_cat_id_3", "tipo_mejora_cat_id_3", ccsInteger, "", CCGetRequestParam("tipo_mejora_cat_id_3", $Method, NULL), $this);
            $this->tipo_mejora_cat_id_3->DSType = dsTable;
            $this->tipo_mejora_cat_id_3->DataSource = new clsDBtdf_nuevo();
            $this->tipo_mejora_cat_id_3->ds = & $this->tipo_mejora_cat_id_3->DataSource;
            $this->tipo_mejora_cat_id_3->DataSource->SQL = "SELECT * \n" .
"FROM tipos_mejoras_cat {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_mejora_cat_id_3->BoundColumn, $this->tipo_mejora_cat_id_3->TextColumn, $this->tipo_mejora_cat_id_3->DBFormat) = array("tipo_mejora_cat_id", "tipo_mejora_cat_descript", "");
            $this->coefE1_3 = new clsControl(ccsTextBox, "coefE1_3", "coefE1_3", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("coefE1_3", $Method, NULL), $this);
            $this->vuE1T_4 = new clsControl(ccsTextBox, "vuE1T_4", "vuE1T_4", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("vuE1T_4", $Method, NULL), $this);
            $this->vuE1T_3 = new clsControl(ccsTextBox, "vuE1T_3", "vuE1T_3", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("vuE1T_3", $Method, NULL), $this);
            $this->mejora_sup_cub_2 = new clsControl(ccsTextBox, "mejora_sup_cub_2", "mejora_sup_cub_2", ccsFloat, "", CCGetRequestParam("mejora_sup_cub_2", $Method, NULL), $this);
            $this->veE1T_2 = new clsControl(ccsTextBox, "veE1T_2", "veE1T_2", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("veE1T_2", $Method, NULL), $this);
            $this->coefE1_4 = new clsControl(ccsTextBox, "coefE1_4", "coefE1_4", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("coefE1_4", $Method, NULL), $this);
            $this->coefE1_5 = new clsControl(ccsTextBox, "coefE1_5", "coefE1_5", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("coefE1_5", $Method, NULL), $this);
            $this->valE1D = new clsControl(ccsTextBox, "valE1D", "valE1D", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("valE1D", $Method, NULL), $this);
            $this->valE1E = new clsControl(ccsTextBox, "valE1E", "valE1E", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("valE1E", $Method, NULL), $this);
            $this->cantE1D = new clsControl(ccsTextBox, "cantE1D", "cantE1D", ccsInteger, "", CCGetRequestParam("cantE1D", $Method, NULL), $this);
            $this->cantE1E = new clsControl(ccsTextBox, "cantE1E", "cantE1E", ccsInteger, "", CCGetRequestParam("cantE1E", $Method, NULL), $this);
            $this->veE1T_3 = new clsControl(ccsTextBox, "veE1T_3", "veE1T_3", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("veE1T_3", $Method, NULL), $this);
            $this->veE1T_4 = new clsControl(ccsTextBox, "veE1T_4", "veE1T_4", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("veE1T_4", $Method, NULL), $this);
            $this->coefE1A = new clsControl(ccsTextBox, "coefE1A", "coefE1A", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("coefE1A", $Method, NULL), $this);
            $this->vtE1A = new clsControl(ccsTextBox, "vtE1A", "vtE1A", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("vtE1A", $Method, NULL), $this);
            $this->vaE1A = new clsControl(ccsTextBox, "vaE1A", "vaE1A", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("vaE1A", $Method, NULL), $this);
            $this->tipo_mejora_id = new clsControl(ccsListBox, "tipo_mejora_id", "Tipo", ccsInteger, "", CCGetRequestParam("tipo_mejora_id", $Method, NULL), $this);
            $this->tipo_mejora_id->DSType = dsTable;
            $this->tipo_mejora_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_mejora_id->ds = & $this->tipo_mejora_id->DataSource;
            $this->tipo_mejora_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_mejoras {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_mejora_id->BoundColumn, $this->tipo_mejora_id->TextColumn, $this->tipo_mejora_id->DBFormat) = array("tipo_mejora_id", "tipo_mejora_descrip", "");
            $this->tipo_mejora_estado_id = new clsControl(ccsListBox, "tipo_mejora_estado_id", "Estado", ccsInteger, "", CCGetRequestParam("tipo_mejora_estado_id", $Method, NULL), $this);
            $this->tipo_mejora_estado_id->DSType = dsTable;
            $this->tipo_mejora_estado_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_mejora_estado_id->ds = & $this->tipo_mejora_estado_id->DataSource;
            $this->tipo_mejora_estado_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_mejoras_estados {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_mejora_estado_id->BoundColumn, $this->tipo_mejora_estado_id->TextColumn, $this->tipo_mejora_estado_id->DBFormat) = array("tipo_mejora_estado_id", "tipo_mejora_estado_descrip", "");
            $this->mejora_anio_construccion = new clsControl(ccsListBox, "mejora_anio_construccion", "mejora_anio_construccion", ccsText, "", CCGetRequestParam("mejora_anio_construccion", $Method, NULL), $this);
            $this->mejora_anio_construccion->DSType = dsTable;
            $this->mejora_anio_construccion->DataSource = new clsDBtdf_nuevo();
            $this->mejora_anio_construccion->ds = & $this->mejora_anio_construccion->DataSource;
            $this->mejora_anio_construccion->DataSource->SQL = "SELECT * \n" .
"FROM mejoras_coeficientes {SQL_Where}\n" .
"GROUP BY mejora_coeficiente_anio {SQL_OrderBy}";
            $this->mejora_anio_construccion->DataSource->Order = "mejora_coeficiente_anio desc";
            list($this->mejora_anio_construccion->BoundColumn, $this->mejora_anio_construccion->TextColumn, $this->mejora_anio_construccion->DBFormat) = array("mejora_coeficiente_anio", "mejora_coeficiente_anio", "");
            $this->mejora_anio_construccion->DataSource->Order = "mejora_coeficiente_anio desc";
            $this->usuario_id = new clsControl(ccsHidden, "usuario_id", "usuario_id", ccsText, "", CCGetRequestParam("usuario_id", $Method, NULL), $this);
            $this->tipo_mejora_destino_id = new clsControl(ccsHidden, "tipo_mejora_destino_id", "tipo_mejora_destino_id", ccsInteger, "", CCGetRequestParam("tipo_mejora_destino_id", $Method, NULL), $this);
            $this->mejora_valor = new clsControl(ccsHidden, "mejora_valor", "mejora_valor", ccsText, "", CCGetRequestParam("mejora_valor", $Method, NULL), $this);
            $this->mejora_f_alta = new clsControl(ccsTextBox, "mejora_f_alta", "F Alta", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("mejora_f_alta", $Method, NULL), $this);
            $this->Button1 = new clsButton("Button1", $Method, $this);
            $this->veE1T_1 = new clsControl(ccsTextBox, "veE1T_1", "veE1T_1", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("veE1T_1", $Method, NULL), $this);
            $this->veE1STA_1 = new clsControl(ccsTextBox, "veE1STA_1", "veE1STA_1", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("veE1STA_1", $Method, NULL), $this);
            $this->veE1STB_1 = new clsControl(ccsTextBox, "veE1STB_1", "veE1STB_1", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("veE1STB_1", $Method, NULL), $this);
            $this->mejora_edif_id = new clsControl(ccsHidden, "mejora_edif_id", "mejora_edif_id", ccsText, "", CCGetRequestParam("mejora_edif_id", $Method, NULL), $this);
            $this->mejora_form = new clsControl(ccsHidden, "mejora_form", "mejora_form", ccsText, "", CCGetRequestParam("mejora_form", $Method, NULL), $this);
            $this->tipo_mejora_decla_id = new clsControl(ccsRadioButton, "tipo_mejora_decla_id", "tipo_mejora_decla_id", ccsInteger, "", CCGetRequestParam("tipo_mejora_decla_id", $Method, NULL), $this);
            $this->tipo_mejora_decla_id->DSType = dsTable;
            $this->tipo_mejora_decla_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_mejora_decla_id->ds = & $this->tipo_mejora_decla_id->DataSource;
            $this->tipo_mejora_decla_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_mejoras_decla {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_mejora_decla_id->BoundColumn, $this->tipo_mejora_decla_id->TextColumn, $this->tipo_mejora_decla_id->DBFormat) = array("tipo_mejora_decla_id", "tipo_mejora_decla_descrip", "");
            $this->tipo_mejora_decla_id->HTML = true;
            $this->RadioButton1 = new clsControl(ccsRadioButton, "RadioButton1", "RadioButton1", ccsText, "", CCGetRequestParam("RadioButton1", $Method, NULL), $this);
            $this->RadioButton1->HTML = true;
            $this->Button_eliminar = new clsButton("Button_eliminar", $Method, $this);
            $this->mejora_f_alta_pura = new clsControl(ccsTextBox, "mejora_f_alta_pura", "mejora_f_alta_pura", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("mejora_f_alta_pura", $Method, NULL), $this);
            $this->DatePicker_mejora_f_alta_pura1 = new clsDatePicker("DatePicker_mejora_f_alta_pura1", "mejoras1", "mejora_f_alta_pura", $this);
            $this->Button2 = new clsButton("Button2", $Method, $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->cantE1B->Value) && !strlen($this->cantE1B->Value) && $this->cantE1B->Value !== false)
                    $this->cantE1B->SetText(0);
                if(!is_array($this->cantE1C->Value) && !strlen($this->cantE1C->Value) && $this->cantE1C->Value !== false)
                    $this->cantE1C->SetText(0);
                if(!is_array($this->cantE1T->Value) && !strlen($this->cantE1T->Value) && $this->cantE1T->Value !== false)
                    $this->cantE1T->SetText(0);
                if(!is_array($this->valE1B->Value) && !strlen($this->valE1B->Value) && $this->valE1B->Value !== false)
                    $this->valE1B->SetText(0);
                if(!is_array($this->valE1C->Value) && !strlen($this->valE1C->Value) && $this->valE1C->Value !== false)
                    $this->valE1C->SetText(0);
                if(!is_array($this->calE1T->Value) && !strlen($this->calE1T->Value) && $this->calE1T->Value !== false)
                    $this->calE1T->SetText(0);
                if(!is_array($this->calE1B->Value) && !strlen($this->calE1B->Value) && $this->calE1B->Value !== false)
                    $this->calE1B->SetText(0);
                if(!is_array($this->calE1C->Value) && !strlen($this->calE1C->Value) && $this->calE1C->Value !== false)
                    $this->calE1C->SetText(0);
                if(!is_array($this->vuE1T->Value) && !strlen($this->vuE1T->Value) && $this->vuE1T->Value !== false)
                    $this->vuE1T->SetText(0);
                if(!is_array($this->coefE1_1->Value) && !strlen($this->coefE1_1->Value) && $this->coefE1_1->Value !== false)
                    $this->coefE1_1->SetText(0);
                if(!is_array($this->vuE1T_2->Value) && !strlen($this->vuE1T_2->Value) && $this->vuE1T_2->Value !== false)
                    $this->vuE1T_2->SetText(0);
                if(!is_array($this->cantE1A->Value) && !strlen($this->cantE1A->Value) && $this->cantE1A->Value !== false)
                    $this->cantE1A->SetText(0);
                if(!is_array($this->valE1A->Value) && !strlen($this->valE1A->Value) && $this->valE1A->Value !== false)
                    $this->valE1A->SetText(0);
                if(!is_array($this->calE1A->Value) && !strlen($this->calE1A->Value) && $this->calE1A->Value !== false)
                    $this->calE1A->SetText(0);
                if(!is_array($this->mejora_sup_semi_cub->Value) && !strlen($this->mejora_sup_semi_cub->Value) && $this->mejora_sup_semi_cub->Value !== false)
                    $this->mejora_sup_semi_cub->SetText(0);
                if(!is_array($this->mejora_sup_cub->Value) && !strlen($this->mejora_sup_cub->Value) && $this->mejora_sup_cub->Value !== false)
                    $this->mejora_sup_cub->SetText(0);
                if(!is_array($this->coefE1_2->Value) && !strlen($this->coefE1_2->Value) && $this->coefE1_2->Value !== false)
                    $this->coefE1_2->SetText(0);
                if(!is_array($this->coefE1_3->Value) && !strlen($this->coefE1_3->Value) && $this->coefE1_3->Value !== false)
                    $this->coefE1_3->SetText(0);
                if(!is_array($this->vuE1T_4->Value) && !strlen($this->vuE1T_4->Value) && $this->vuE1T_4->Value !== false)
                    $this->vuE1T_4->SetText(0);
                if(!is_array($this->vuE1T_3->Value) && !strlen($this->vuE1T_3->Value) && $this->vuE1T_3->Value !== false)
                    $this->vuE1T_3->SetText(0);
                if(!is_array($this->mejora_sup_cub_2->Value) && !strlen($this->mejora_sup_cub_2->Value) && $this->mejora_sup_cub_2->Value !== false)
                    $this->mejora_sup_cub_2->SetText(0);
                if(!is_array($this->veE1T_2->Value) && !strlen($this->veE1T_2->Value) && $this->veE1T_2->Value !== false)
                    $this->veE1T_2->SetText(0);
                if(!is_array($this->coefE1_4->Value) && !strlen($this->coefE1_4->Value) && $this->coefE1_4->Value !== false)
                    $this->coefE1_4->SetText(0);
                if(!is_array($this->coefE1_5->Value) && !strlen($this->coefE1_5->Value) && $this->coefE1_5->Value !== false)
                    $this->coefE1_5->SetText(0);
                if(!is_array($this->valE1D->Value) && !strlen($this->valE1D->Value) && $this->valE1D->Value !== false)
                    $this->valE1D->SetText(0);
                if(!is_array($this->valE1E->Value) && !strlen($this->valE1E->Value) && $this->valE1E->Value !== false)
                    $this->valE1E->SetText(0);
                if(!is_array($this->cantE1D->Value) && !strlen($this->cantE1D->Value) && $this->cantE1D->Value !== false)
                    $this->cantE1D->SetText(0);
                if(!is_array($this->cantE1E->Value) && !strlen($this->cantE1E->Value) && $this->cantE1E->Value !== false)
                    $this->cantE1E->SetText(0);
                if(!is_array($this->veE1T_3->Value) && !strlen($this->veE1T_3->Value) && $this->veE1T_3->Value !== false)
                    $this->veE1T_3->SetText(0);
                if(!is_array($this->veE1T_4->Value) && !strlen($this->veE1T_4->Value) && $this->veE1T_4->Value !== false)
                    $this->veE1T_4->SetText(0);
                if(!is_array($this->vtE1A->Value) && !strlen($this->vtE1A->Value) && $this->vtE1A->Value !== false)
                    $this->vtE1A->SetText(0);
                if(!is_array($this->vaE1A->Value) && !strlen($this->vaE1A->Value) && $this->vaE1A->Value !== false)
                    $this->vaE1A->SetText(0);
                if(!is_array($this->tipo_mejora_destino_id->Value) && !strlen($this->tipo_mejora_destino_id->Value) && $this->tipo_mejora_destino_id->Value !== false)
                    $this->tipo_mejora_destino_id->SetText(1);
                if(!is_array($this->veE1T_1->Value) && !strlen($this->veE1T_1->Value) && $this->veE1T_1->Value !== false)
                    $this->veE1T_1->SetText(0);
                if(!is_array($this->veE1STA_1->Value) && !strlen($this->veE1STA_1->Value) && $this->veE1STA_1->Value !== false)
                    $this->veE1STA_1->SetText(0);
                if(!is_array($this->veE1STB_1->Value) && !strlen($this->veE1STB_1->Value) && $this->veE1STB_1->Value !== false)
                    $this->veE1STB_1->SetText(0);
                if(!is_array($this->mejora_form->Value) && !strlen($this->mejora_form->Value) && $this->mejora_form->Value !== false)
                    $this->mejora_form->SetText(E1);
                if(!is_array($this->mejora_f_alta_pura->Value) && !strlen($this->mejora_f_alta_pura->Value) && $this->mejora_f_alta_pura->Value !== false)
                    $this->mejora_f_alta_pura->SetValue(time());
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @356-7DE78C7E
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlmejora_id"] = CCGetFromGet("mejora_id", NULL);
        $this->DataSource->Parameters["urlparcela_id"] = CCGetFromGet("parcela_id", NULL);
    }
//End Initialize Method

//Validate Method @356-9C3E6D4B
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->parcela_id->Validate() && $Validation);
        $Validation = ($this->mejora_nro_exp->Validate() && $Validation);
        $Validation = ($this->mejora_observacion->Validate() && $Validation);
        $Validation = ($this->mejora_letra_exp->Validate() && $Validation);
        $Validation = ($this->mejora_fecha_exp->Validate() && $Validation);
        $Validation = ($this->mejora_categoria_dpc->Validate() && $Validation);
        $Validation = ($this->mejora_f_pro->Validate() && $Validation);
        $Validation = ($this->audit_string->Validate() && $Validation);
        $Validation = ($this->tipo_estado_id->Validate() && $Validation);
        $Validation = ($this->sup_terreno->Validate() && $Validation);
        $Validation = ($this->mejora_f_baja->Validate() && $Validation);
        $Validation = ($this->mejora_nro_nota->Validate() && $Validation);
        $Validation = ($this->mejora_id->Validate() && $Validation);
        $Validation = ($this->cantE1B->Validate() && $Validation);
        $Validation = ($this->cantE1C->Validate() && $Validation);
        $Validation = ($this->cantE1T->Validate() && $Validation);
        $Validation = ($this->valE1B->Validate() && $Validation);
        $Validation = ($this->valE1C->Validate() && $Validation);
        $Validation = ($this->calE1T->Validate() && $Validation);
        $Validation = ($this->calE1B->Validate() && $Validation);
        $Validation = ($this->calE1C->Validate() && $Validation);
        $Validation = ($this->vuE1T->Validate() && $Validation);
        $Validation = ($this->tipo_mejora_conserva_id->Validate() && $Validation);
        $Validation = ($this->coefE1_1->Validate() && $Validation);
        $Validation = ($this->vuE1T_2->Validate() && $Validation);
        $Validation = ($this->tipo_mejora_cat_id->Validate() && $Validation);
        $Validation = ($this->cantE1A->Validate() && $Validation);
        $Validation = ($this->valE1A->Validate() && $Validation);
        $Validation = ($this->calE1A->Validate() && $Validation);
        $Validation = ($this->mejora_sup_semi_cub->Validate() && $Validation);
        $Validation = ($this->mejora_sup_cub->Validate() && $Validation);
        $Validation = ($this->mejora_porc_dominio->Validate() && $Validation);
        $Validation = ($this->tipo_mejora_conserva_id_2->Validate() && $Validation);
        $Validation = ($this->mejora_anio_construccion_2->Validate() && $Validation);
        $Validation = ($this->tipo_mejora_cat_id_2->Validate() && $Validation);
        $Validation = ($this->coefE1_2->Validate() && $Validation);
        $Validation = ($this->tipo_mejora_conserva_id_3->Validate() && $Validation);
        $Validation = ($this->mejora_anio_construccion_3->Validate() && $Validation);
        $Validation = ($this->tipo_mejora_cat_id_3->Validate() && $Validation);
        $Validation = ($this->coefE1_3->Validate() && $Validation);
        $Validation = ($this->vuE1T_4->Validate() && $Validation);
        $Validation = ($this->vuE1T_3->Validate() && $Validation);
        $Validation = ($this->mejora_sup_cub_2->Validate() && $Validation);
        $Validation = ($this->veE1T_2->Validate() && $Validation);
        $Validation = ($this->coefE1_4->Validate() && $Validation);
        $Validation = ($this->coefE1_5->Validate() && $Validation);
        $Validation = ($this->valE1D->Validate() && $Validation);
        $Validation = ($this->valE1E->Validate() && $Validation);
        $Validation = ($this->cantE1D->Validate() && $Validation);
        $Validation = ($this->cantE1E->Validate() && $Validation);
        $Validation = ($this->veE1T_3->Validate() && $Validation);
        $Validation = ($this->veE1T_4->Validate() && $Validation);
        $Validation = ($this->coefE1A->Validate() && $Validation);
        $Validation = ($this->vtE1A->Validate() && $Validation);
        $Validation = ($this->vaE1A->Validate() && $Validation);
        $Validation = ($this->tipo_mejora_id->Validate() && $Validation);
        $Validation = ($this->tipo_mejora_estado_id->Validate() && $Validation);
        $Validation = ($this->mejora_anio_construccion->Validate() && $Validation);
        $Validation = ($this->usuario_id->Validate() && $Validation);
        $Validation = ($this->tipo_mejora_destino_id->Validate() && $Validation);
        $Validation = ($this->mejora_valor->Validate() && $Validation);
        $Validation = ($this->mejora_f_alta->Validate() && $Validation);
        $Validation = ($this->veE1T_1->Validate() && $Validation);
        $Validation = ($this->veE1STA_1->Validate() && $Validation);
        $Validation = ($this->veE1STB_1->Validate() && $Validation);
        $Validation = ($this->mejora_edif_id->Validate() && $Validation);
        $Validation = ($this->mejora_form->Validate() && $Validation);
        $Validation = ($this->tipo_mejora_decla_id->Validate() && $Validation);
        $Validation = ($this->RadioButton1->Validate() && $Validation);
        $Validation = ($this->mejora_f_alta_pura->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->parcela_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_nro_exp->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_observacion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_letra_exp->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_fecha_exp->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_categoria_dpc->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_f_pro->Errors->Count() == 0);
        $Validation =  $Validation && ($this->audit_string->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_estado_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->sup_terreno->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_f_baja->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_nro_nota->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->cantE1B->Errors->Count() == 0);
        $Validation =  $Validation && ($this->cantE1C->Errors->Count() == 0);
        $Validation =  $Validation && ($this->cantE1T->Errors->Count() == 0);
        $Validation =  $Validation && ($this->valE1B->Errors->Count() == 0);
        $Validation =  $Validation && ($this->valE1C->Errors->Count() == 0);
        $Validation =  $Validation && ($this->calE1T->Errors->Count() == 0);
        $Validation =  $Validation && ($this->calE1B->Errors->Count() == 0);
        $Validation =  $Validation && ($this->calE1C->Errors->Count() == 0);
        $Validation =  $Validation && ($this->vuE1T->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_mejora_conserva_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->coefE1_1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->vuE1T_2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_mejora_cat_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->cantE1A->Errors->Count() == 0);
        $Validation =  $Validation && ($this->valE1A->Errors->Count() == 0);
        $Validation =  $Validation && ($this->calE1A->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_sup_semi_cub->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_sup_cub->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_porc_dominio->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_mejora_conserva_id_2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_anio_construccion_2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_mejora_cat_id_2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->coefE1_2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_mejora_conserva_id_3->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_anio_construccion_3->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_mejora_cat_id_3->Errors->Count() == 0);
        $Validation =  $Validation && ($this->coefE1_3->Errors->Count() == 0);
        $Validation =  $Validation && ($this->vuE1T_4->Errors->Count() == 0);
        $Validation =  $Validation && ($this->vuE1T_3->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_sup_cub_2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->veE1T_2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->coefE1_4->Errors->Count() == 0);
        $Validation =  $Validation && ($this->coefE1_5->Errors->Count() == 0);
        $Validation =  $Validation && ($this->valE1D->Errors->Count() == 0);
        $Validation =  $Validation && ($this->valE1E->Errors->Count() == 0);
        $Validation =  $Validation && ($this->cantE1D->Errors->Count() == 0);
        $Validation =  $Validation && ($this->cantE1E->Errors->Count() == 0);
        $Validation =  $Validation && ($this->veE1T_3->Errors->Count() == 0);
        $Validation =  $Validation && ($this->veE1T_4->Errors->Count() == 0);
        $Validation =  $Validation && ($this->coefE1A->Errors->Count() == 0);
        $Validation =  $Validation && ($this->vtE1A->Errors->Count() == 0);
        $Validation =  $Validation && ($this->vaE1A->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_mejora_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_mejora_estado_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_anio_construccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->usuario_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_mejora_destino_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_valor->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_f_alta->Errors->Count() == 0);
        $Validation =  $Validation && ($this->veE1T_1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->veE1STA_1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->veE1STB_1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_edif_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_form->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_mejora_decla_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->RadioButton1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_f_alta_pura->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @356-591D22F4
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->parcela_id->Errors->Count());
        $errors = ($errors || $this->mejora_nro_exp->Errors->Count());
        $errors = ($errors || $this->mejora_observacion->Errors->Count());
        $errors = ($errors || $this->mejora_letra_exp->Errors->Count());
        $errors = ($errors || $this->mejora_fecha_exp->Errors->Count());
        $errors = ($errors || $this->DatePicker_mejora_fecha_exp->Errors->Count());
        $errors = ($errors || $this->mejora_categoria_dpc->Errors->Count());
        $errors = ($errors || $this->mejora_f_pro->Errors->Count());
        $errors = ($errors || $this->audit_string->Errors->Count());
        $errors = ($errors || $this->tipo_estado_id->Errors->Count());
        $errors = ($errors || $this->baja->Errors->Count());
        $errors = ($errors || $this->sup_terreno->Errors->Count());
        $errors = ($errors || $this->mejora_f_baja->Errors->Count());
        $errors = ($errors || $this->mejora_nro_nota->Errors->Count());
        $errors = ($errors || $this->mejora_id->Errors->Count());
        $errors = ($errors || $this->motivo_baja->Errors->Count());
        $errors = ($errors || $this->cantE1B->Errors->Count());
        $errors = ($errors || $this->cantE1C->Errors->Count());
        $errors = ($errors || $this->cantE1T->Errors->Count());
        $errors = ($errors || $this->valE1B->Errors->Count());
        $errors = ($errors || $this->valE1C->Errors->Count());
        $errors = ($errors || $this->calE1T->Errors->Count());
        $errors = ($errors || $this->calE1B->Errors->Count());
        $errors = ($errors || $this->calE1C->Errors->Count());
        $errors = ($errors || $this->vuE1T->Errors->Count());
        $errors = ($errors || $this->tipo_mejora_conserva_id->Errors->Count());
        $errors = ($errors || $this->coefE1_1->Errors->Count());
        $errors = ($errors || $this->vuE1T_2->Errors->Count());
        $errors = ($errors || $this->tipo_mejora_cat_id->Errors->Count());
        $errors = ($errors || $this->cantE1A->Errors->Count());
        $errors = ($errors || $this->valE1A->Errors->Count());
        $errors = ($errors || $this->calE1A->Errors->Count());
        $errors = ($errors || $this->mejora_sup_semi_cub->Errors->Count());
        $errors = ($errors || $this->mejora_sup_cub->Errors->Count());
        $errors = ($errors || $this->mejora_porc_dominio->Errors->Count());
        $errors = ($errors || $this->tipo_mejora_conserva_id_2->Errors->Count());
        $errors = ($errors || $this->mejora_anio_construccion_2->Errors->Count());
        $errors = ($errors || $this->tipo_mejora_cat_id_2->Errors->Count());
        $errors = ($errors || $this->coefE1_2->Errors->Count());
        $errors = ($errors || $this->tipo_mejora_conserva_id_3->Errors->Count());
        $errors = ($errors || $this->mejora_anio_construccion_3->Errors->Count());
        $errors = ($errors || $this->tipo_mejora_cat_id_3->Errors->Count());
        $errors = ($errors || $this->coefE1_3->Errors->Count());
        $errors = ($errors || $this->vuE1T_4->Errors->Count());
        $errors = ($errors || $this->vuE1T_3->Errors->Count());
        $errors = ($errors || $this->mejora_sup_cub_2->Errors->Count());
        $errors = ($errors || $this->veE1T_2->Errors->Count());
        $errors = ($errors || $this->coefE1_4->Errors->Count());
        $errors = ($errors || $this->coefE1_5->Errors->Count());
        $errors = ($errors || $this->valE1D->Errors->Count());
        $errors = ($errors || $this->valE1E->Errors->Count());
        $errors = ($errors || $this->cantE1D->Errors->Count());
        $errors = ($errors || $this->cantE1E->Errors->Count());
        $errors = ($errors || $this->veE1T_3->Errors->Count());
        $errors = ($errors || $this->veE1T_4->Errors->Count());
        $errors = ($errors || $this->coefE1A->Errors->Count());
        $errors = ($errors || $this->vtE1A->Errors->Count());
        $errors = ($errors || $this->vaE1A->Errors->Count());
        $errors = ($errors || $this->tipo_mejora_id->Errors->Count());
        $errors = ($errors || $this->tipo_mejora_estado_id->Errors->Count());
        $errors = ($errors || $this->mejora_anio_construccion->Errors->Count());
        $errors = ($errors || $this->usuario_id->Errors->Count());
        $errors = ($errors || $this->tipo_mejora_destino_id->Errors->Count());
        $errors = ($errors || $this->mejora_valor->Errors->Count());
        $errors = ($errors || $this->mejora_f_alta->Errors->Count());
        $errors = ($errors || $this->veE1T_1->Errors->Count());
        $errors = ($errors || $this->veE1STA_1->Errors->Count());
        $errors = ($errors || $this->veE1STB_1->Errors->Count());
        $errors = ($errors || $this->mejora_edif_id->Errors->Count());
        $errors = ($errors || $this->mejora_form->Errors->Count());
        $errors = ($errors || $this->tipo_mejora_decla_id->Errors->Count());
        $errors = ($errors || $this->RadioButton1->Errors->Count());
        $errors = ($errors || $this->mejora_f_alta_pura->Errors->Count());
        $errors = ($errors || $this->DatePicker_mejora_f_alta_pura1->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @356-ED598703
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

//Operation Method @356-C732F4E3
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

        if($this->FormSubmitted) {
            $this->PressedButton = $this->EditMode ? "Button_Update" : "Button_Insert";
            if($this->Button_Insert->Pressed) {
                $this->PressedButton = "Button_Insert";
            } else if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            } else if($this->Button_Delete->Pressed) {
                $this->PressedButton = "Button_Delete";
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            } else if($this->Button_alta->Pressed) {
                $this->PressedButton = "Button_alta";
            } else if($this->Button1->Pressed) {
                $this->PressedButton = "Button1";
            } else if($this->Button_eliminar->Pressed) {
                $this->PressedButton = "Button_eliminar";
            } else if($this->Button2->Pressed) {
                $this->PressedButton = "Button2";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Delete") {
            $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "mejora_id", "add", "f"));
            if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_Cancel") {
            $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "mejora_id", "add", "f"));
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button1") {
            if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_eliminar") {
            $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "mejora_id", "add", "f"));
            if(!CCGetEvent($this->Button_eliminar->CCSEvents, "OnClick", $this->Button_eliminar)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button2") {
            if(!CCGetEvent($this->Button2->CCSEvents, "OnClick", $this->Button2)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Insert" && $this->InsertAllowed) {
                $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "mejora_id", "add", "f"));
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_Update" && $this->UpdateAllowed) {
                $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "mejora_id", "add", "f"));
                if(!CCGetEvent($this->Button_Update->CCSEvents, "OnClick", $this->Button_Update) || !$this->UpdateRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_alta") {
                $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "mejora_id", "add", "f"));
                if(!CCGetEvent($this->Button_alta->CCSEvents, "OnClick", $this->Button_alta)) {
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

//InsertRow Method @356-1A5EFB23
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->parcela_id->SetValue($this->parcela_id->GetValue(true));
        $this->DataSource->mejora_nro_exp->SetValue($this->mejora_nro_exp->GetValue(true));
        $this->DataSource->mejora_sup_cub->SetValue($this->mejora_sup_cub->GetValue(true));
        $this->DataSource->mejora_observacion->SetValue($this->mejora_observacion->GetValue(true));
        $this->DataSource->mejora_letra_exp->SetValue($this->mejora_letra_exp->GetValue(true));
        $this->DataSource->mejora_fecha_exp->SetValue($this->mejora_fecha_exp->GetValue(true));
        $this->DataSource->tipo_mejora_id->SetValue($this->tipo_mejora_id->GetValue(true));
        $this->DataSource->mejora_categoria_dpc->SetValue($this->mejora_categoria_dpc->GetValue(true));
        $this->DataSource->mejora_f_alta->SetValue($this->mejora_f_alta->GetValue(true));
        $this->DataSource->mejora_f_pro->SetValue($this->mejora_f_pro->GetValue(true));
        $this->DataSource->audit_string->SetValue($this->audit_string->GetValue(true));
        $this->DataSource->tipo_estado_id->SetValue($this->tipo_estado_id->GetValue(true));
        $this->DataSource->tipo_mejora_destino_id->SetValue($this->tipo_mejora_destino_id->GetValue(true));
        $this->DataSource->mejora_valor->SetValue($this->mejora_valor->GetValue(true));
        $this->DataSource->mejora_porc_dominio->SetValue($this->mejora_porc_dominio->GetValue(true));
        $this->DataSource->mejora_sup_semi_cub->SetValue($this->mejora_sup_semi_cub->GetValue(true));
        $this->DataSource->mejora_f_baja->SetValue($this->mejora_f_baja->GetValue(true));
        $this->DataSource->mejora_id->SetValue($this->mejora_id->GetValue(true));
        $this->DataSource->tipo_mejora_cat_id->SetValue($this->tipo_mejora_cat_id->GetValue(true));
        $this->DataSource->tipo_mejora_estado_id->SetValue($this->tipo_mejora_estado_id->GetValue(true));
        $this->DataSource->tipo_mejora_conserva_id->SetValue($this->tipo_mejora_conserva_id->GetValue(true));
        $this->DataSource->mejora_anio_construccion->SetValue($this->mejora_anio_construccion->GetValue(true));
        $this->DataSource->coefE1A->SetValue($this->coefE1A->GetValue(true));
        $this->DataSource->vtE1A->SetValue($this->vtE1A->GetValue(true));
        $this->DataSource->vaE1A->SetValue($this->vaE1A->GetValue(true));
        $this->DataSource->tipo_mejora_conserva_id_2->SetValue($this->tipo_mejora_conserva_id_2->GetValue(true));
        $this->DataSource->mejora_anio_construccion_2->SetValue($this->mejora_anio_construccion_2->GetValue(true));
        $this->DataSource->tipo_mejora_cat_id_2->SetValue($this->tipo_mejora_cat_id_2->GetValue(true));
        $this->DataSource->mejora_edif_id->SetValue($this->mejora_edif_id->GetValue(true));
        $this->DataSource->tipo_mejora_conserva_id_3->SetValue($this->tipo_mejora_conserva_id_3->GetValue(true));
        $this->DataSource->mejora_anio_construccion_3->SetValue($this->mejora_anio_construccion_3->GetValue(true));
        $this->DataSource->tipo_mejora_cat_id_3->SetValue($this->tipo_mejora_cat_id_3->GetValue(true));
        $this->DataSource->cantE1D->SetValue($this->cantE1D->GetValue(true));
        $this->DataSource->cantE1E->SetValue($this->cantE1E->GetValue(true));
        $this->DataSource->usuario_id->SetValue($this->usuario_id->GetValue(true));
        $this->DataSource->mejora_form->SetValue($this->mejora_form->GetValue(true));
        $this->DataSource->mejora_sup_cub_2->SetValue($this->mejora_sup_cub_2->GetValue(true));
        $this->DataSource->RadioButton1->SetValue($this->RadioButton1->GetValue(true));
        $this->DataSource->tipo_mejora_decla_id->SetValue($this->tipo_mejora_decla_id->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @356-D48B7248
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->parcela_id->SetValue($this->parcela_id->GetValue(true));
        $this->DataSource->mejora_nro_exp->SetValue($this->mejora_nro_exp->GetValue(true));
        $this->DataSource->mejora_sup_cub->SetValue($this->mejora_sup_cub->GetValue(true));
        $this->DataSource->mejora_observacion->SetValue($this->mejora_observacion->GetValue(true));
        $this->DataSource->mejora_letra_exp->SetValue($this->mejora_letra_exp->GetValue(true));
        $this->DataSource->mejora_fecha_exp->SetValue($this->mejora_fecha_exp->GetValue(true));
        $this->DataSource->tipo_mejora_id->SetValue($this->tipo_mejora_id->GetValue(true));
        $this->DataSource->mejora_categoria_dpc->SetValue($this->mejora_categoria_dpc->GetValue(true));
        $this->DataSource->mejora_f_alta->SetValue($this->mejora_f_alta->GetValue(true));
        $this->DataSource->mejora_f_pro->SetValue($this->mejora_f_pro->GetValue(true));
        $this->DataSource->audit_string->SetValue($this->audit_string->GetValue(true));
        $this->DataSource->tipo_estado_id->SetValue($this->tipo_estado_id->GetValue(true));
        $this->DataSource->tipo_mejora_destino_id->SetValue($this->tipo_mejora_destino_id->GetValue(true));
        $this->DataSource->mejora_valor->SetValue($this->mejora_valor->GetValue(true));
        $this->DataSource->mejora_porc_dominio->SetValue($this->mejora_porc_dominio->GetValue(true));
        $this->DataSource->mejora_sup_semi_cub->SetValue($this->mejora_sup_semi_cub->GetValue(true));
        $this->DataSource->mejora_f_baja->SetValue($this->mejora_f_baja->GetValue(true));
        $this->DataSource->mejora_id->SetValue($this->mejora_id->GetValue(true));
        $this->DataSource->tipo_mejora_cat_id->SetValue($this->tipo_mejora_cat_id->GetValue(true));
        $this->DataSource->tipo_mejora_estado_id->SetValue($this->tipo_mejora_estado_id->GetValue(true));
        $this->DataSource->tipo_mejora_conserva_id->SetValue($this->tipo_mejora_conserva_id->GetValue(true));
        $this->DataSource->mejora_anio_construccion->SetValue($this->mejora_anio_construccion->GetValue(true));
        $this->DataSource->coefE1A->SetValue($this->coefE1A->GetValue(true));
        $this->DataSource->vtE1A->SetValue($this->vtE1A->GetValue(true));
        $this->DataSource->vaE1A->SetValue($this->vaE1A->GetValue(true));
        $this->DataSource->tipo_mejora_conserva_id_2->SetValue($this->tipo_mejora_conserva_id_2->GetValue(true));
        $this->DataSource->mejora_anio_construccion_2->SetValue($this->mejora_anio_construccion_2->GetValue(true));
        $this->DataSource->tipo_mejora_cat_id_2->SetValue($this->tipo_mejora_cat_id_2->GetValue(true));
        $this->DataSource->mejora_edif_id->SetValue($this->mejora_edif_id->GetValue(true));
        $this->DataSource->tipo_mejora_conserva_id_3->SetValue($this->tipo_mejora_conserva_id_3->GetValue(true));
        $this->DataSource->mejora_anio_construccion_3->SetValue($this->mejora_anio_construccion_3->GetValue(true));
        $this->DataSource->tipo_mejora_cat_id_3->SetValue($this->tipo_mejora_cat_id_3->GetValue(true));
        $this->DataSource->cantE1D->SetValue($this->cantE1D->GetValue(true));
        $this->DataSource->cantE1E->SetValue($this->cantE1E->GetValue(true));
        $this->DataSource->usuario_id->SetValue($this->usuario_id->GetValue(true));
        $this->DataSource->mejora_form->SetValue($this->mejora_form->GetValue(true));
        $this->DataSource->mejora_sup_cub_2->SetValue($this->mejora_sup_cub_2->GetValue(true));
        $this->DataSource->tipo_mejora_decla_id->SetValue($this->tipo_mejora_decla_id->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @356-308BAF09
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

        $this->tipo_mejora_conserva_id->Prepare();
        $this->tipo_mejora_cat_id->Prepare();
        $this->tipo_mejora_conserva_id_2->Prepare();
        $this->mejora_anio_construccion_2->Prepare();
        $this->tipo_mejora_cat_id_2->Prepare();
        $this->tipo_mejora_conserva_id_3->Prepare();
        $this->mejora_anio_construccion_3->Prepare();
        $this->tipo_mejora_cat_id_3->Prepare();
        $this->tipo_mejora_id->Prepare();
        $this->tipo_mejora_estado_id->Prepare();
        $this->mejora_anio_construccion->Prepare();
        $this->tipo_mejora_decla_id->Prepare();
        $this->RadioButton1->Prepare();

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
                if(!$this->FormSubmitted){
                    $this->parcela_id->SetValue($this->DataSource->parcela_id->GetValue());
                    $this->mejora_nro_exp->SetValue($this->DataSource->mejora_nro_exp->GetValue());
                    $this->mejora_observacion->SetValue($this->DataSource->mejora_observacion->GetValue());
                    $this->mejora_letra_exp->SetValue($this->DataSource->mejora_letra_exp->GetValue());
                    $this->mejora_fecha_exp->SetValue($this->DataSource->mejora_fecha_exp->GetValue());
                    $this->mejora_categoria_dpc->SetValue($this->DataSource->mejora_categoria_dpc->GetValue());
                    $this->mejora_f_pro->SetValue($this->DataSource->mejora_f_pro->GetValue());
                    $this->audit_string->SetValue($this->DataSource->audit_string->GetValue());
                    $this->tipo_estado_id->SetValue($this->DataSource->tipo_estado_id->GetValue());
                    $this->mejora_f_baja->SetValue($this->DataSource->mejora_f_baja->GetValue());
                    $this->mejora_id->SetValue($this->DataSource->mejora_id->GetValue());
                    $this->tipo_mejora_conserva_id->SetValue($this->DataSource->tipo_mejora_conserva_id->GetValue());
                    $this->tipo_mejora_cat_id->SetValue($this->DataSource->tipo_mejora_cat_id->GetValue());
                    $this->mejora_sup_semi_cub->SetValue($this->DataSource->mejora_sup_semi_cub->GetValue());
                    $this->mejora_sup_cub->SetValue($this->DataSource->mejora_sup_cub->GetValue());
                    $this->mejora_porc_dominio->SetValue($this->DataSource->mejora_porc_dominio->GetValue());
                    $this->tipo_mejora_conserva_id_2->SetValue($this->DataSource->tipo_mejora_conserva_id_2->GetValue());
                    $this->mejora_anio_construccion_2->SetValue($this->DataSource->mejora_anio_construccion_2->GetValue());
                    $this->tipo_mejora_cat_id_2->SetValue($this->DataSource->tipo_mejora_cat_id_2->GetValue());
                    $this->tipo_mejora_conserva_id_3->SetValue($this->DataSource->tipo_mejora_conserva_id_3->GetValue());
                    $this->mejora_anio_construccion_3->SetValue($this->DataSource->mejora_anio_construccion_3->GetValue());
                    $this->tipo_mejora_cat_id_3->SetValue($this->DataSource->tipo_mejora_cat_id_3->GetValue());
                    $this->mejora_sup_cub_2->SetValue($this->DataSource->mejora_sup_cub_2->GetValue());
                    $this->cantE1D->SetValue($this->DataSource->cantE1D->GetValue());
                    $this->cantE1E->SetValue($this->DataSource->cantE1E->GetValue());
                    $this->vtE1A->SetValue($this->DataSource->vtE1A->GetValue());
                    $this->vaE1A->SetValue($this->DataSource->vaE1A->GetValue());
                    $this->tipo_mejora_id->SetValue($this->DataSource->tipo_mejora_id->GetValue());
                    $this->tipo_mejora_estado_id->SetValue($this->DataSource->tipo_mejora_estado_id->GetValue());
                    $this->mejora_anio_construccion->SetValue($this->DataSource->mejora_anio_construccion->GetValue());
                    $this->usuario_id->SetValue($this->DataSource->usuario_id->GetValue());
                    $this->tipo_mejora_destino_id->SetValue($this->DataSource->tipo_mejora_destino_id->GetValue());
                    $this->mejora_f_alta->SetValue($this->DataSource->mejora_f_alta->GetValue());
                    $this->mejora_edif_id->SetValue($this->DataSource->mejora_edif_id->GetValue());
                    $this->mejora_form->SetValue($this->DataSource->mejora_form->GetValue());
                    $this->tipo_mejora_decla_id->SetValue($this->DataSource->tipo_mejora_decla_id->GetValue());
                    $this->mejora_f_alta_pura->SetValue($this->DataSource->mejora_f_alta_pura->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }
        if (!$this->FormSubmitted) {
        }
        if ($this->cantE1T->GetValue() < 0 )
             $this->cantE1T->Text = CCFormatNumber($this->cantE1T->GetValue(), array(False, 0, Null, "", True, "(", ")", 1, True, ""));
        else
             $this->cantE1T->Text = CCFormatNumber($this->cantE1T->GetValue(), array(False, 0, Null, "", False, "", "", 1, True, ""));
        if ($this->cantE1D->GetValue() < 0 )
             $this->cantE1D->Text = CCFormatNumber($this->cantE1D->GetValue(), array(False, 0, Null, "", True, "(", ")", 1, True, ""));
        else
             $this->cantE1D->Text = CCFormatNumber($this->cantE1D->GetValue(), array(False, 0, Null, "", False, "", "", 1, True, ""));
        if ($this->cantE1E->GetValue() < 0 )
             $this->cantE1E->Text = CCFormatNumber($this->cantE1E->GetValue(), array(False, 0, Null, "", True, "(", ")", 1, True, ""));
        else
             $this->cantE1E->Text = CCFormatNumber($this->cantE1E->GetValue(), array(False, 0, Null, "", False, "", "", 1, True, ""));

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->parcela_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_nro_exp->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_observacion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_letra_exp->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_fecha_exp->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_mejora_fecha_exp->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_categoria_dpc->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_f_pro->Errors->ToString());
            $Error = ComposeStrings($Error, $this->audit_string->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_estado_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->baja->Errors->ToString());
            $Error = ComposeStrings($Error, $this->sup_terreno->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_f_baja->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_nro_nota->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->motivo_baja->Errors->ToString());
            $Error = ComposeStrings($Error, $this->cantE1B->Errors->ToString());
            $Error = ComposeStrings($Error, $this->cantE1C->Errors->ToString());
            $Error = ComposeStrings($Error, $this->cantE1T->Errors->ToString());
            $Error = ComposeStrings($Error, $this->valE1B->Errors->ToString());
            $Error = ComposeStrings($Error, $this->valE1C->Errors->ToString());
            $Error = ComposeStrings($Error, $this->calE1T->Errors->ToString());
            $Error = ComposeStrings($Error, $this->calE1B->Errors->ToString());
            $Error = ComposeStrings($Error, $this->calE1C->Errors->ToString());
            $Error = ComposeStrings($Error, $this->vuE1T->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_mejora_conserva_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->coefE1_1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->vuE1T_2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_mejora_cat_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->cantE1A->Errors->ToString());
            $Error = ComposeStrings($Error, $this->valE1A->Errors->ToString());
            $Error = ComposeStrings($Error, $this->calE1A->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_sup_semi_cub->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_sup_cub->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_porc_dominio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_mejora_conserva_id_2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_anio_construccion_2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_mejora_cat_id_2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->coefE1_2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_mejora_conserva_id_3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_anio_construccion_3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_mejora_cat_id_3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->coefE1_3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->vuE1T_4->Errors->ToString());
            $Error = ComposeStrings($Error, $this->vuE1T_3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_sup_cub_2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->veE1T_2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->coefE1_4->Errors->ToString());
            $Error = ComposeStrings($Error, $this->coefE1_5->Errors->ToString());
            $Error = ComposeStrings($Error, $this->valE1D->Errors->ToString());
            $Error = ComposeStrings($Error, $this->valE1E->Errors->ToString());
            $Error = ComposeStrings($Error, $this->cantE1D->Errors->ToString());
            $Error = ComposeStrings($Error, $this->cantE1E->Errors->ToString());
            $Error = ComposeStrings($Error, $this->veE1T_3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->veE1T_4->Errors->ToString());
            $Error = ComposeStrings($Error, $this->coefE1A->Errors->ToString());
            $Error = ComposeStrings($Error, $this->vtE1A->Errors->ToString());
            $Error = ComposeStrings($Error, $this->vaE1A->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_mejora_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_mejora_estado_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_anio_construccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->usuario_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_mejora_destino_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_valor->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_f_alta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->veE1T_1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->veE1STA_1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->veE1STB_1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_edif_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_form->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_mejora_decla_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->RadioButton1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_f_alta_pura->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_mejora_f_alta_pura1->Errors->ToString());
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
        $this->Button_Insert->Visible = !$this->EditMode && $this->InsertAllowed;
        $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->Button_Delete->Show();
        $this->Button_Cancel->Show();
        $this->parcela_id->Show();
        $this->mejora_nro_exp->Show();
        $this->mejora_observacion->Show();
        $this->mejora_letra_exp->Show();
        $this->mejora_fecha_exp->Show();
        $this->DatePicker_mejora_fecha_exp->Show();
        $this->mejora_categoria_dpc->Show();
        $this->mejora_f_pro->Show();
        $this->audit_string->Show();
        $this->tipo_estado_id->Show();
        $this->baja->Show();
        $this->sup_terreno->Show();
        $this->Button_alta->Show();
        $this->mejora_f_baja->Show();
        $this->mejora_nro_nota->Show();
        $this->mejora_id->Show();
        $this->motivo_baja->Show();
        $this->cantE1B->Show();
        $this->cantE1C->Show();
        $this->cantE1T->Show();
        $this->valE1B->Show();
        $this->valE1C->Show();
        $this->calE1T->Show();
        $this->calE1B->Show();
        $this->calE1C->Show();
        $this->vuE1T->Show();
        $this->tipo_mejora_conserva_id->Show();
        $this->coefE1_1->Show();
        $this->vuE1T_2->Show();
        $this->tipo_mejora_cat_id->Show();
        $this->cantE1A->Show();
        $this->valE1A->Show();
        $this->calE1A->Show();
        $this->mejora_sup_semi_cub->Show();
        $this->mejora_sup_cub->Show();
        $this->mejora_porc_dominio->Show();
        $this->tipo_mejora_conserva_id_2->Show();
        $this->mejora_anio_construccion_2->Show();
        $this->tipo_mejora_cat_id_2->Show();
        $this->coefE1_2->Show();
        $this->tipo_mejora_conserva_id_3->Show();
        $this->mejora_anio_construccion_3->Show();
        $this->tipo_mejora_cat_id_3->Show();
        $this->coefE1_3->Show();
        $this->vuE1T_4->Show();
        $this->vuE1T_3->Show();
        $this->mejora_sup_cub_2->Show();
        $this->veE1T_2->Show();
        $this->coefE1_4->Show();
        $this->coefE1_5->Show();
        $this->valE1D->Show();
        $this->valE1E->Show();
        $this->cantE1D->Show();
        $this->cantE1E->Show();
        $this->veE1T_3->Show();
        $this->veE1T_4->Show();
        $this->coefE1A->Show();
        $this->vtE1A->Show();
        $this->vaE1A->Show();
        $this->tipo_mejora_id->Show();
        $this->tipo_mejora_estado_id->Show();
        $this->mejora_anio_construccion->Show();
        $this->usuario_id->Show();
        $this->tipo_mejora_destino_id->Show();
        $this->mejora_valor->Show();
        $this->mejora_f_alta->Show();
        $this->Button1->Show();
        $this->veE1T_1->Show();
        $this->veE1STA_1->Show();
        $this->veE1STB_1->Show();
        $this->mejora_edif_id->Show();
        $this->mejora_form->Show();
        $this->tipo_mejora_decla_id->Show();
        $this->RadioButton1->Show();
        $this->Button_eliminar->Show();
        $this->mejora_f_alta_pura->Show();
        $this->DatePicker_mejora_f_alta_pura1->Show();
        $this->Button2->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End mejoras1 Class @356-FCB6E20C

class clsmejoras1DataSource extends clsDBtdf_nuevo {  //mejoras1DataSource Class @356-9A280078

//DataSource Variables @356-29538258
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $wp;
    public $AllParametersSet;

    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $parcela_id;
    public $mejora_nro_exp;
    public $mejora_observacion;
    public $mejora_letra_exp;
    public $mejora_fecha_exp;
    public $mejora_categoria_dpc;
    public $mejora_f_pro;
    public $audit_string;
    public $tipo_estado_id;
    public $baja;
    public $sup_terreno;
    public $mejora_f_baja;
    public $mejora_nro_nota;
    public $mejora_id;
    public $motivo_baja;
    public $cantE1B;
    public $cantE1C;
    public $cantE1T;
    public $valE1B;
    public $valE1C;
    public $calE1T;
    public $calE1B;
    public $calE1C;
    public $vuE1T;
    public $tipo_mejora_conserva_id;
    public $coefE1_1;
    public $vuE1T_2;
    public $tipo_mejora_cat_id;
    public $cantE1A;
    public $valE1A;
    public $calE1A;
    public $mejora_sup_semi_cub;
    public $mejora_sup_cub;
    public $mejora_porc_dominio;
    public $tipo_mejora_conserva_id_2;
    public $mejora_anio_construccion_2;
    public $tipo_mejora_cat_id_2;
    public $coefE1_2;
    public $tipo_mejora_conserva_id_3;
    public $mejora_anio_construccion_3;
    public $tipo_mejora_cat_id_3;
    public $coefE1_3;
    public $vuE1T_4;
    public $vuE1T_3;
    public $mejora_sup_cub_2;
    public $veE1T_2;
    public $coefE1_4;
    public $coefE1_5;
    public $valE1D;
    public $valE1E;
    public $cantE1D;
    public $cantE1E;
    public $veE1T_3;
    public $veE1T_4;
    public $coefE1A;
    public $vtE1A;
    public $vaE1A;
    public $tipo_mejora_id;
    public $tipo_mejora_estado_id;
    public $mejora_anio_construccion;
    public $usuario_id;
    public $tipo_mejora_destino_id;
    public $mejora_valor;
    public $mejora_f_alta;
    public $veE1T_1;
    public $veE1STA_1;
    public $veE1STB_1;
    public $mejora_edif_id;
    public $mejora_form;
    public $tipo_mejora_decla_id;
    public $RadioButton1;
    public $mejora_f_alta_pura;
//End DataSource Variables

//DataSourceClass_Initialize Event @356-F3DF69A3
    function clsmejoras1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record mejoras1/Error";
        $this->Initialize();
        $this->parcela_id = new clsField("parcela_id", ccsInteger, "");
        
        $this->mejora_nro_exp = new clsField("mejora_nro_exp", ccsInteger, "");
        
        $this->mejora_observacion = new clsField("mejora_observacion", ccsText, "");
        
        $this->mejora_letra_exp = new clsField("mejora_letra_exp", ccsText, "");
        
        $this->mejora_fecha_exp = new clsField("mejora_fecha_exp", ccsDate, $this->DateFormat);
        
        $this->mejora_categoria_dpc = new clsField("mejora_categoria_dpc", ccsInteger, "");
        
        $this->mejora_f_pro = new clsField("mejora_f_pro", ccsText, "");
        
        $this->audit_string = new clsField("audit_string", ccsText, "");
        
        $this->tipo_estado_id = new clsField("tipo_estado_id", ccsInteger, "");
        
        $this->baja = new clsField("baja", ccsText, "");
        
        $this->sup_terreno = new clsField("sup_terreno", ccsFloat, "");
        
        $this->mejora_f_baja = new clsField("mejora_f_baja", ccsText, "");
        
        $this->mejora_nro_nota = new clsField("mejora_nro_nota", ccsText, "");
        
        $this->mejora_id = new clsField("mejora_id", ccsText, "");
        
        $this->motivo_baja = new clsField("motivo_baja", ccsText, "");
        
        $this->cantE1B = new clsField("cantE1B", ccsInteger, "");
        
        $this->cantE1C = new clsField("cantE1C", ccsInteger, "");
        
        $this->cantE1T = new clsField("cantE1T", ccsInteger, "");
        
        $this->valE1B = new clsField("valE1B", ccsFloat, "");
        
        $this->valE1C = new clsField("valE1C", ccsFloat, "");
        
        $this->calE1T = new clsField("calE1T", ccsFloat, "");
        
        $this->calE1B = new clsField("calE1B", ccsFloat, "");
        
        $this->calE1C = new clsField("calE1C", ccsFloat, "");
        
        $this->vuE1T = new clsField("vuE1T", ccsFloat, "");
        
        $this->tipo_mejora_conserva_id = new clsField("tipo_mejora_conserva_id", ccsInteger, "");
        
        $this->coefE1_1 = new clsField("coefE1_1", ccsFloat, "");
        
        $this->vuE1T_2 = new clsField("vuE1T_2", ccsFloat, "");
        
        $this->tipo_mejora_cat_id = new clsField("tipo_mejora_cat_id", ccsInteger, "");
        
        $this->cantE1A = new clsField("cantE1A", ccsInteger, "");
        
        $this->valE1A = new clsField("valE1A", ccsFloat, "");
        
        $this->calE1A = new clsField("calE1A", ccsFloat, "");
        
        $this->mejora_sup_semi_cub = new clsField("mejora_sup_semi_cub", ccsFloat, "");
        
        $this->mejora_sup_cub = new clsField("mejora_sup_cub", ccsFloat, "");
        
        $this->mejora_porc_dominio = new clsField("mejora_porc_dominio", ccsFloat, "");
        
        $this->tipo_mejora_conserva_id_2 = new clsField("tipo_mejora_conserva_id_2", ccsInteger, "");
        
        $this->mejora_anio_construccion_2 = new clsField("mejora_anio_construccion_2", ccsText, "");
        
        $this->tipo_mejora_cat_id_2 = new clsField("tipo_mejora_cat_id_2", ccsInteger, "");
        
        $this->coefE1_2 = new clsField("coefE1_2", ccsFloat, "");
        
        $this->tipo_mejora_conserva_id_3 = new clsField("tipo_mejora_conserva_id_3", ccsInteger, "");
        
        $this->mejora_anio_construccion_3 = new clsField("mejora_anio_construccion_3", ccsText, "");
        
        $this->tipo_mejora_cat_id_3 = new clsField("tipo_mejora_cat_id_3", ccsInteger, "");
        
        $this->coefE1_3 = new clsField("coefE1_3", ccsFloat, "");
        
        $this->vuE1T_4 = new clsField("vuE1T_4", ccsFloat, "");
        
        $this->vuE1T_3 = new clsField("vuE1T_3", ccsFloat, "");
        
        $this->mejora_sup_cub_2 = new clsField("mejora_sup_cub_2", ccsFloat, "");
        
        $this->veE1T_2 = new clsField("veE1T_2", ccsFloat, "");
        
        $this->coefE1_4 = new clsField("coefE1_4", ccsFloat, "");
        
        $this->coefE1_5 = new clsField("coefE1_5", ccsFloat, "");
        
        $this->valE1D = new clsField("valE1D", ccsFloat, "");
        
        $this->valE1E = new clsField("valE1E", ccsFloat, "");
        
        $this->cantE1D = new clsField("cantE1D", ccsInteger, "");
        
        $this->cantE1E = new clsField("cantE1E", ccsInteger, "");
        
        $this->veE1T_3 = new clsField("veE1T_3", ccsFloat, "");
        
        $this->veE1T_4 = new clsField("veE1T_4", ccsFloat, "");
        
        $this->coefE1A = new clsField("coefE1A", ccsFloat, "");
        
        $this->vtE1A = new clsField("vtE1A", ccsFloat, "");
        
        $this->vaE1A = new clsField("vaE1A", ccsFloat, "");
        
        $this->tipo_mejora_id = new clsField("tipo_mejora_id", ccsInteger, "");
        
        $this->tipo_mejora_estado_id = new clsField("tipo_mejora_estado_id", ccsInteger, "");
        
        $this->mejora_anio_construccion = new clsField("mejora_anio_construccion", ccsText, "");
        
        $this->usuario_id = new clsField("usuario_id", ccsText, "");
        
        $this->tipo_mejora_destino_id = new clsField("tipo_mejora_destino_id", ccsInteger, "");
        
        $this->mejora_valor = new clsField("mejora_valor", ccsText, "");
        
        $this->mejora_f_alta = new clsField("mejora_f_alta", ccsDate, $this->DateFormat);
        
        $this->veE1T_1 = new clsField("veE1T_1", ccsFloat, "");
        
        $this->veE1STA_1 = new clsField("veE1STA_1", ccsFloat, "");
        
        $this->veE1STB_1 = new clsField("veE1STB_1", ccsFloat, "");
        
        $this->mejora_edif_id = new clsField("mejora_edif_id", ccsText, "");
        
        $this->mejora_form = new clsField("mejora_form", ccsText, "");
        
        $this->tipo_mejora_decla_id = new clsField("tipo_mejora_decla_id", ccsInteger, "");
        
        $this->RadioButton1 = new clsField("RadioButton1", ccsText, "");
        
        $this->mejora_f_alta_pura = new clsField("mejora_f_alta_pura", ccsDate, $this->DateFormat);
        

        $this->InsertFields["parcela_id"] = array("Name" => "parcela_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_nro_exp"] = array("Name" => "mejora_nro_exp", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_sup_cub"] = array("Name" => "mejora_sup_cub", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_observacion"] = array("Name" => "mejora_observacion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_letra_exp"] = array("Name" => "mejora_letra_exp", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_fecha_exp"] = array("Name" => "mejora_fecha_exp", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_mejora_id"] = array("Name" => "tipo_mejora_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_categoria_dpc"] = array("Name" => "mejora_categoria_dpc", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_f_alta"] = array("Name" => "mejora_f_alta", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_f_pro"] = array("Name" => "mejora_f_pro", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["audit_string"] = array("Name" => "audit_string", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_estado_id"] = array("Name" => "tipo_estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_mejora_destino_id"] = array("Name" => "tipo_mejora_destino_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_valor"] = array("Name" => "mejora_valor", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_porc_dominio"] = array("Name" => "mejora_porc_dominio", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_sup_semi_cub"] = array("Name" => "mejora_sup_semi_cub", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_f_baja"] = array("Name" => "mejora_f_baja", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_id"] = array("Name" => "mejora_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_mejora_cat_id"] = array("Name" => "tipo_mejora_cat_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_mejora_estado_id"] = array("Name" => "tipo_mejora_estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_mejora_conserva_id"] = array("Name" => "tipo_mejora_conserva_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_anio_construccion"] = array("Name" => "mejora_anio_construccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_coef_ajuste"] = array("Name" => "mejora_coef_ajuste", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_valor"] = array("Name" => "mejora_valor", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_valuacion"] = array("Name" => "mejora_valuacion", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_mejora_conserva_2_id"] = array("Name" => "tipo_mejora_conserva_2_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_anio_construccion_2"] = array("Name" => "mejora_anio_construccion_2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_mejora_cat_2_id"] = array("Name" => "tipo_mejora_cat_2_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_edif_id"] = array("Name" => "mejora_edif_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_mejora_conserva_3_id"] = array("Name" => "tipo_mejora_conserva_3_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_anio_construccion_3"] = array("Name" => "mejora_anio_construccion_3", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_mejora_cat_3_id"] = array("Name" => "tipo_mejora_cat_3_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_cant_bp"] = array("Name" => "mejora_cant_bp", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_cant_bs"] = array("Name" => "mejora_cant_bs", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["usuario_id"] = array("Name" => "usuario_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_form"] = array("Name" => "mejora_form", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_sup_cub_2"] = array("Name" => "mejora_sup_cub_2", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_mejora_decla_id"] = array("Name" => "tipo_mejora_decla_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_mejora_decla_id"] = array("Name" => "tipo_mejora_decla_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_id"] = array("Name" => "parcela_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_nro_exp"] = array("Name" => "mejora_nro_exp", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_sup_cub"] = array("Name" => "mejora_sup_cub", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_observacion"] = array("Name" => "mejora_observacion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_letra_exp"] = array("Name" => "mejora_letra_exp", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_fecha_exp"] = array("Name" => "mejora_fecha_exp", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_mejora_id"] = array("Name" => "tipo_mejora_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_categoria_dpc"] = array("Name" => "mejora_categoria_dpc", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_f_alta"] = array("Name" => "mejora_f_alta", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_f_pro"] = array("Name" => "mejora_f_pro", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["audit_string"] = array("Name" => "audit_string", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_estado_id"] = array("Name" => "tipo_estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_mejora_destino_id"] = array("Name" => "tipo_mejora_destino_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_valor"] = array("Name" => "mejora_valor", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_porc_dominio"] = array("Name" => "mejora_porc_dominio", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_sup_semi_cub"] = array("Name" => "mejora_sup_semi_cub", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_f_baja"] = array("Name" => "mejora_f_baja", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_id"] = array("Name" => "mejora_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_mejora_cat_id"] = array("Name" => "tipo_mejora_cat_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_mejora_estado_id"] = array("Name" => "tipo_mejora_estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_mejora_conserva_id"] = array("Name" => "tipo_mejora_conserva_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_anio_construccion"] = array("Name" => "mejora_anio_construccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_coef_ajuste"] = array("Name" => "mejora_coef_ajuste", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_valor"] = array("Name" => "mejora_valor", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_valuacion"] = array("Name" => "mejora_valuacion", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_mejora_conserva_2_id"] = array("Name" => "tipo_mejora_conserva_2_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_anio_construccion_2"] = array("Name" => "mejora_anio_construccion_2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_mejora_cat_2_id"] = array("Name" => "tipo_mejora_cat_2_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_edif_id"] = array("Name" => "mejora_edif_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_mejora_conserva_3_id"] = array("Name" => "tipo_mejora_conserva_3_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_anio_construccion_3"] = array("Name" => "mejora_anio_construccion_3", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_mejora_cat_3_id"] = array("Name" => "tipo_mejora_cat_3_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_cant_bp"] = array("Name" => "mejora_cant_bp", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_cant_bs"] = array("Name" => "mejora_cant_bs", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["usuario_id"] = array("Name" => "usuario_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_form"] = array("Name" => "mejora_form", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_sup_cub_2"] = array("Name" => "mejora_sup_cub_2", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_mejora_decla_id"] = array("Name" => "tipo_mejora_decla_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @356-6A648D9E
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlmejora_id", ccsInteger, "", "", $this->Parameters["urlmejora_id"], "", false);
        $this->wp->AddParameter("2", "urlparcela_id", ccsInteger, "", "", $this->Parameters["urlparcela_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "mejora_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "parcela_id", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @356-1E8F64B3
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM mejoras {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @356-5FC73C2C
    function SetValues()
    {
        $this->parcela_id->SetDBValue(trim($this->f("parcela_id")));
        $this->mejora_nro_exp->SetDBValue(trim($this->f("mejora_nro_exp")));
        $this->mejora_observacion->SetDBValue($this->f("mejora_observacion"));
        $this->mejora_letra_exp->SetDBValue($this->f("mejora_letra_exp"));
        $this->mejora_fecha_exp->SetDBValue(trim($this->f("mejora_fecha_exp")));
        $this->mejora_categoria_dpc->SetDBValue(trim($this->f("mejora_categoria_dpc")));
        $this->mejora_f_pro->SetDBValue($this->f("mejora_f_pro"));
        $this->audit_string->SetDBValue($this->f("audit_string"));
        $this->tipo_estado_id->SetDBValue(trim($this->f("tipo_estado_id")));
        $this->mejora_f_baja->SetDBValue($this->f("mejora_f_baja"));
        $this->mejora_id->SetDBValue($this->f("mejora_id"));
        $this->tipo_mejora_conserva_id->SetDBValue(trim($this->f("tipo_mejora_conserva_id")));
        $this->tipo_mejora_cat_id->SetDBValue(trim($this->f("tipo_mejora_cat_id")));
        $this->mejora_sup_semi_cub->SetDBValue(trim($this->f("mejora_sup_semi_cub")));
        $this->mejora_sup_cub->SetDBValue(trim($this->f("mejora_sup_cub")));
        $this->mejora_porc_dominio->SetDBValue(trim($this->f("mejora_porc_dominio")));
        $this->tipo_mejora_conserva_id_2->SetDBValue(trim($this->f("tipo_mejora_conserva_2_id")));
        $this->mejora_anio_construccion_2->SetDBValue($this->f("mejora_anio_construccion_2"));
        $this->tipo_mejora_cat_id_2->SetDBValue(trim($this->f("tipo_mejora_cat_2_id")));
        $this->tipo_mejora_conserva_id_3->SetDBValue(trim($this->f("tipo_mejora_conserva_3_id")));
        $this->mejora_anio_construccion_3->SetDBValue($this->f("mejora_anio_construccion_3"));
        $this->tipo_mejora_cat_id_3->SetDBValue(trim($this->f("tipo_mejora_cat_3_id")));
        $this->mejora_sup_cub_2->SetDBValue(trim($this->f("mejora_sup_cub_2")));
        $this->cantE1D->SetDBValue(trim($this->f("mejora_cant_bp")));
        $this->cantE1E->SetDBValue(trim($this->f("mejora_cant_bs")));
        $this->vtE1A->SetDBValue(trim($this->f("mejora_valor")));
        $this->vaE1A->SetDBValue(trim($this->f("mejora_valuacion")));
        $this->tipo_mejora_id->SetDBValue(trim($this->f("tipo_mejora_id")));
        $this->tipo_mejora_estado_id->SetDBValue(trim($this->f("tipo_mejora_estado_id")));
        $this->mejora_anio_construccion->SetDBValue($this->f("mejora_anio_construccion"));
        $this->usuario_id->SetDBValue($this->f("usuario_id"));
        $this->tipo_mejora_destino_id->SetDBValue(trim($this->f("tipo_mejora_destino_id")));
        $this->mejora_f_alta->SetDBValue(trim($this->f("mejora_f_alta")));
        $this->mejora_edif_id->SetDBValue($this->f("mejora_edif_id"));
        $this->mejora_form->SetDBValue($this->f("mejora_form"));
        $this->tipo_mejora_decla_id->SetDBValue(trim($this->f("tipo_mejora_decla_id")));
        $this->mejora_f_alta_pura->SetDBValue(trim($this->f("mejora_f_alta_pura")));
    }
//End SetValues Method

//Insert Method @356-8F19478A
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["parcela_id"] = new clsSQLParameter("ctrlparcela_id", ccsInteger, "", "", $this->parcela_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_nro_exp"] = new clsSQLParameter("ctrlmejora_nro_exp", ccsInteger, "", "", $this->mejora_nro_exp->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_sup_cub"] = new clsSQLParameter("ctrlmejora_sup_cub", ccsFloat, array(False, 4, Null, "", False, "", "", 1, True, ""), "", $this->mejora_sup_cub->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_observacion"] = new clsSQLParameter("ctrlmejora_observacion", ccsText, "", "", $this->mejora_observacion->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_letra_exp"] = new clsSQLParameter("ctrlmejora_letra_exp", ccsText, "", "", $this->mejora_letra_exp->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_fecha_exp"] = new clsSQLParameter("ctrlmejora_fecha_exp", ccsDate, $DefaultDateFormat, $this->DateFormat, $this->mejora_fecha_exp->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_id"] = new clsSQLParameter("ctrltipo_mejora_id", ccsInteger, "", "", $this->tipo_mejora_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_categoria_dpc"] = new clsSQLParameter("ctrlmejora_categoria_dpc", ccsInteger, "", "", $this->mejora_categoria_dpc->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_f_alta"] = new clsSQLParameter("ctrlmejora_f_alta", ccsDate, $DefaultDateFormat, $this->DateFormat, $this->mejora_f_alta->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_f_pro"] = new clsSQLParameter("ctrlmejora_f_pro", ccsText, "", "", $this->mejora_f_pro->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["audit_string"] = new clsSQLParameter("ctrlaudit_string", ccsText, "", "", $this->audit_string->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_estado_id"] = new clsSQLParameter("ctrltipo_estado_id", ccsInteger, "", "", $this->tipo_estado_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_destino_id"] = new clsSQLParameter("ctrltipo_mejora_destino_id", ccsInteger, "", "", $this->tipo_mejora_destino_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_valor"] = new clsSQLParameter("ctrlmejora_valor", ccsFloat, "", "", $this->mejora_valor->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_porc_dominio"] = new clsSQLParameter("ctrlmejora_porc_dominio", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), "", $this->mejora_porc_dominio->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_sup_semi_cub"] = new clsSQLParameter("ctrlmejora_sup_semi_cub", ccsFloat, array(False, 4, Null, "", False, "", "", 1, True, ""), "", $this->mejora_sup_semi_cub->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_f_baja"] = new clsSQLParameter("ctrlmejora_f_baja", ccsText, "", "", $this->mejora_f_baja->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_id"] = new clsSQLParameter("ctrlmejora_id", ccsText, "", "", $this->mejora_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_cat_id"] = new clsSQLParameter("ctrltipo_mejora_cat_id", ccsInteger, "", "", $this->tipo_mejora_cat_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_estado_id"] = new clsSQLParameter("ctrltipo_mejora_estado_id", ccsInteger, "", "", $this->tipo_mejora_estado_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_conserva_id"] = new clsSQLParameter("ctrltipo_mejora_conserva_id", ccsInteger, "", "", $this->tipo_mejora_conserva_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_anio_construccion"] = new clsSQLParameter("ctrlmejora_anio_construccion", ccsText, "", "", $this->mejora_anio_construccion->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_coef_ajuste"] = new clsSQLParameter("ctrlcoefE1A", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), "", $this->coefE1A->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_valor"] = new clsSQLParameter("ctrlvtE1A", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), "", $this->vtE1A->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_valuacion"] = new clsSQLParameter("ctrlvaE1A", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), "", $this->vaE1A->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_conserva_2_id"] = new clsSQLParameter("ctrltipo_mejora_conserva_id_2", ccsInteger, "", "", $this->tipo_mejora_conserva_id_2->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_anio_construccion_2"] = new clsSQLParameter("ctrlmejora_anio_construccion_2", ccsText, "", "", $this->mejora_anio_construccion_2->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_cat_2_id"] = new clsSQLParameter("ctrltipo_mejora_cat_id_2", ccsInteger, "", "", $this->tipo_mejora_cat_id_2->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_edif_id"] = new clsSQLParameter("ctrlmejora_edif_id", ccsText, "", "", $this->mejora_edif_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_conserva_3_id"] = new clsSQLParameter("ctrltipo_mejora_conserva_id_3", ccsInteger, "", "", $this->tipo_mejora_conserva_id_3->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_anio_construccion_3"] = new clsSQLParameter("ctrlmejora_anio_construccion_3", ccsText, "", "", $this->mejora_anio_construccion_3->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_cat_3_id"] = new clsSQLParameter("ctrltipo_mejora_cat_id_3", ccsInteger, "", "", $this->tipo_mejora_cat_id_3->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_cant_bp"] = new clsSQLParameter("ctrlcantE1D", ccsInteger, "", "", $this->cantE1D->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_cant_bs"] = new clsSQLParameter("ctrlcantE1E", ccsInteger, "", "", $this->cantE1E->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["usuario_id"] = new clsSQLParameter("ctrlusuario_id", ccsText, "", "", $this->usuario_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_form"] = new clsSQLParameter("ctrlmejora_form", ccsText, "", "", $this->mejora_form->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_sup_cub_2"] = new clsSQLParameter("ctrlmejora_sup_cub_2", ccsFloat, array(False, 4, Null, "", False, "", "", 1, True, ""), "", $this->mejora_sup_cub_2->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_decla_id"] = new clsSQLParameter("ctrlRadioButton1", ccsInteger, "", "", $this->RadioButton1->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_decla_id"] = new clsSQLParameter("ctrltipo_mejora_decla_id", ccsInteger, "", "", $this->tipo_mejora_decla_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        if (!is_null($this->cp["parcela_id"]->GetValue()) and !strlen($this->cp["parcela_id"]->GetText()) and !is_bool($this->cp["parcela_id"]->GetValue())) 
            $this->cp["parcela_id"]->SetValue($this->parcela_id->GetValue(true));
        if (!is_null($this->cp["mejora_nro_exp"]->GetValue()) and !strlen($this->cp["mejora_nro_exp"]->GetText()) and !is_bool($this->cp["mejora_nro_exp"]->GetValue())) 
            $this->cp["mejora_nro_exp"]->SetValue($this->mejora_nro_exp->GetValue(true));
        if (!is_null($this->cp["mejora_sup_cub"]->GetValue()) and !strlen($this->cp["mejora_sup_cub"]->GetText()) and !is_bool($this->cp["mejora_sup_cub"]->GetValue())) 
            $this->cp["mejora_sup_cub"]->SetValue($this->mejora_sup_cub->GetValue(true));
        if (!is_null($this->cp["mejora_observacion"]->GetValue()) and !strlen($this->cp["mejora_observacion"]->GetText()) and !is_bool($this->cp["mejora_observacion"]->GetValue())) 
            $this->cp["mejora_observacion"]->SetValue($this->mejora_observacion->GetValue(true));
        if (!is_null($this->cp["mejora_letra_exp"]->GetValue()) and !strlen($this->cp["mejora_letra_exp"]->GetText()) and !is_bool($this->cp["mejora_letra_exp"]->GetValue())) 
            $this->cp["mejora_letra_exp"]->SetValue($this->mejora_letra_exp->GetValue(true));
        if (!is_null($this->cp["mejora_fecha_exp"]->GetValue()) and !strlen($this->cp["mejora_fecha_exp"]->GetText()) and !is_bool($this->cp["mejora_fecha_exp"]->GetValue())) 
            $this->cp["mejora_fecha_exp"]->SetValue($this->mejora_fecha_exp->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_id"]->GetValue())) 
            $this->cp["tipo_mejora_id"]->SetValue($this->tipo_mejora_id->GetValue(true));
        if (!is_null($this->cp["mejora_categoria_dpc"]->GetValue()) and !strlen($this->cp["mejora_categoria_dpc"]->GetText()) and !is_bool($this->cp["mejora_categoria_dpc"]->GetValue())) 
            $this->cp["mejora_categoria_dpc"]->SetValue($this->mejora_categoria_dpc->GetValue(true));
        if (!is_null($this->cp["mejora_f_alta"]->GetValue()) and !strlen($this->cp["mejora_f_alta"]->GetText()) and !is_bool($this->cp["mejora_f_alta"]->GetValue())) 
            $this->cp["mejora_f_alta"]->SetValue($this->mejora_f_alta->GetValue(true));
        if (!is_null($this->cp["mejora_f_pro"]->GetValue()) and !strlen($this->cp["mejora_f_pro"]->GetText()) and !is_bool($this->cp["mejora_f_pro"]->GetValue())) 
            $this->cp["mejora_f_pro"]->SetValue($this->mejora_f_pro->GetValue(true));
        if (!is_null($this->cp["audit_string"]->GetValue()) and !strlen($this->cp["audit_string"]->GetText()) and !is_bool($this->cp["audit_string"]->GetValue())) 
            $this->cp["audit_string"]->SetValue($this->audit_string->GetValue(true));
        if (!is_null($this->cp["tipo_estado_id"]->GetValue()) and !strlen($this->cp["tipo_estado_id"]->GetText()) and !is_bool($this->cp["tipo_estado_id"]->GetValue())) 
            $this->cp["tipo_estado_id"]->SetValue($this->tipo_estado_id->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_destino_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_destino_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_destino_id"]->GetValue())) 
            $this->cp["tipo_mejora_destino_id"]->SetValue($this->tipo_mejora_destino_id->GetValue(true));
        if (!is_null($this->cp["mejora_valor"]->GetValue()) and !strlen($this->cp["mejora_valor"]->GetText()) and !is_bool($this->cp["mejora_valor"]->GetValue())) 
            $this->cp["mejora_valor"]->SetValue($this->mejora_valor->GetValue(true));
        if (!is_null($this->cp["mejora_porc_dominio"]->GetValue()) and !strlen($this->cp["mejora_porc_dominio"]->GetText()) and !is_bool($this->cp["mejora_porc_dominio"]->GetValue())) 
            $this->cp["mejora_porc_dominio"]->SetValue($this->mejora_porc_dominio->GetValue(true));
        if (!is_null($this->cp["mejora_sup_semi_cub"]->GetValue()) and !strlen($this->cp["mejora_sup_semi_cub"]->GetText()) and !is_bool($this->cp["mejora_sup_semi_cub"]->GetValue())) 
            $this->cp["mejora_sup_semi_cub"]->SetValue($this->mejora_sup_semi_cub->GetValue(true));
        if (!is_null($this->cp["mejora_f_baja"]->GetValue()) and !strlen($this->cp["mejora_f_baja"]->GetText()) and !is_bool($this->cp["mejora_f_baja"]->GetValue())) 
            $this->cp["mejora_f_baja"]->SetValue($this->mejora_f_baja->GetValue(true));
        if (!is_null($this->cp["mejora_id"]->GetValue()) and !strlen($this->cp["mejora_id"]->GetText()) and !is_bool($this->cp["mejora_id"]->GetValue())) 
            $this->cp["mejora_id"]->SetValue($this->mejora_id->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_cat_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_cat_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_cat_id"]->GetValue())) 
            $this->cp["tipo_mejora_cat_id"]->SetValue($this->tipo_mejora_cat_id->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_estado_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_estado_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_estado_id"]->GetValue())) 
            $this->cp["tipo_mejora_estado_id"]->SetValue($this->tipo_mejora_estado_id->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_conserva_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_conserva_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_conserva_id"]->GetValue())) 
            $this->cp["tipo_mejora_conserva_id"]->SetValue($this->tipo_mejora_conserva_id->GetValue(true));
        if (!is_null($this->cp["mejora_anio_construccion"]->GetValue()) and !strlen($this->cp["mejora_anio_construccion"]->GetText()) and !is_bool($this->cp["mejora_anio_construccion"]->GetValue())) 
            $this->cp["mejora_anio_construccion"]->SetValue($this->mejora_anio_construccion->GetValue(true));
        if (!is_null($this->cp["mejora_coef_ajuste"]->GetValue()) and !strlen($this->cp["mejora_coef_ajuste"]->GetText()) and !is_bool($this->cp["mejora_coef_ajuste"]->GetValue())) 
            $this->cp["mejora_coef_ajuste"]->SetValue($this->coefE1A->GetValue(true));
        if (!is_null($this->cp["mejora_valor"]->GetValue()) and !strlen($this->cp["mejora_valor"]->GetText()) and !is_bool($this->cp["mejora_valor"]->GetValue())) 
            $this->cp["mejora_valor"]->SetValue($this->vtE1A->GetValue(true));
        if (!is_null($this->cp["mejora_valuacion"]->GetValue()) and !strlen($this->cp["mejora_valuacion"]->GetText()) and !is_bool($this->cp["mejora_valuacion"]->GetValue())) 
            $this->cp["mejora_valuacion"]->SetValue($this->vaE1A->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_conserva_2_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_conserva_2_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_conserva_2_id"]->GetValue())) 
            $this->cp["tipo_mejora_conserva_2_id"]->SetValue($this->tipo_mejora_conserva_id_2->GetValue(true));
        if (!is_null($this->cp["mejora_anio_construccion_2"]->GetValue()) and !strlen($this->cp["mejora_anio_construccion_2"]->GetText()) and !is_bool($this->cp["mejora_anio_construccion_2"]->GetValue())) 
            $this->cp["mejora_anio_construccion_2"]->SetValue($this->mejora_anio_construccion_2->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_cat_2_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_cat_2_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_cat_2_id"]->GetValue())) 
            $this->cp["tipo_mejora_cat_2_id"]->SetValue($this->tipo_mejora_cat_id_2->GetValue(true));
        if (!is_null($this->cp["mejora_edif_id"]->GetValue()) and !strlen($this->cp["mejora_edif_id"]->GetText()) and !is_bool($this->cp["mejora_edif_id"]->GetValue())) 
            $this->cp["mejora_edif_id"]->SetValue($this->mejora_edif_id->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_conserva_3_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_conserva_3_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_conserva_3_id"]->GetValue())) 
            $this->cp["tipo_mejora_conserva_3_id"]->SetValue($this->tipo_mejora_conserva_id_3->GetValue(true));
        if (!is_null($this->cp["mejora_anio_construccion_3"]->GetValue()) and !strlen($this->cp["mejora_anio_construccion_3"]->GetText()) and !is_bool($this->cp["mejora_anio_construccion_3"]->GetValue())) 
            $this->cp["mejora_anio_construccion_3"]->SetValue($this->mejora_anio_construccion_3->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_cat_3_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_cat_3_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_cat_3_id"]->GetValue())) 
            $this->cp["tipo_mejora_cat_3_id"]->SetValue($this->tipo_mejora_cat_id_3->GetValue(true));
        if (!is_null($this->cp["mejora_cant_bp"]->GetValue()) and !strlen($this->cp["mejora_cant_bp"]->GetText()) and !is_bool($this->cp["mejora_cant_bp"]->GetValue())) 
            $this->cp["mejora_cant_bp"]->SetValue($this->cantE1D->GetValue(true));
        if (!is_null($this->cp["mejora_cant_bs"]->GetValue()) and !strlen($this->cp["mejora_cant_bs"]->GetText()) and !is_bool($this->cp["mejora_cant_bs"]->GetValue())) 
            $this->cp["mejora_cant_bs"]->SetValue($this->cantE1E->GetValue(true));
        if (!is_null($this->cp["usuario_id"]->GetValue()) and !strlen($this->cp["usuario_id"]->GetText()) and !is_bool($this->cp["usuario_id"]->GetValue())) 
            $this->cp["usuario_id"]->SetValue($this->usuario_id->GetValue(true));
        if (!is_null($this->cp["mejora_form"]->GetValue()) and !strlen($this->cp["mejora_form"]->GetText()) and !is_bool($this->cp["mejora_form"]->GetValue())) 
            $this->cp["mejora_form"]->SetValue($this->mejora_form->GetValue(true));
        if (!is_null($this->cp["mejora_sup_cub_2"]->GetValue()) and !strlen($this->cp["mejora_sup_cub_2"]->GetText()) and !is_bool($this->cp["mejora_sup_cub_2"]->GetValue())) 
            $this->cp["mejora_sup_cub_2"]->SetValue($this->mejora_sup_cub_2->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_decla_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_decla_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_decla_id"]->GetValue())) 
            $this->cp["tipo_mejora_decla_id"]->SetValue($this->RadioButton1->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_decla_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_decla_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_decla_id"]->GetValue())) 
            $this->cp["tipo_mejora_decla_id"]->SetValue($this->tipo_mejora_decla_id->GetValue(true));
        $this->InsertFields["parcela_id"]["Value"] = $this->cp["parcela_id"]->GetDBValue(true);
        $this->InsertFields["mejora_nro_exp"]["Value"] = $this->cp["mejora_nro_exp"]->GetDBValue(true);
        $this->InsertFields["mejora_sup_cub"]["Value"] = $this->cp["mejora_sup_cub"]->GetDBValue(true);
        $this->InsertFields["mejora_observacion"]["Value"] = $this->cp["mejora_observacion"]->GetDBValue(true);
        $this->InsertFields["mejora_letra_exp"]["Value"] = $this->cp["mejora_letra_exp"]->GetDBValue(true);
        $this->InsertFields["mejora_fecha_exp"]["Value"] = $this->cp["mejora_fecha_exp"]->GetDBValue(true);
        $this->InsertFields["tipo_mejora_id"]["Value"] = $this->cp["tipo_mejora_id"]->GetDBValue(true);
        $this->InsertFields["mejora_categoria_dpc"]["Value"] = $this->cp["mejora_categoria_dpc"]->GetDBValue(true);
        $this->InsertFields["mejora_f_alta"]["Value"] = $this->cp["mejora_f_alta"]->GetDBValue(true);
        $this->InsertFields["mejora_f_pro"]["Value"] = $this->cp["mejora_f_pro"]->GetDBValue(true);
        $this->InsertFields["audit_string"]["Value"] = $this->cp["audit_string"]->GetDBValue(true);
        $this->InsertFields["tipo_estado_id"]["Value"] = $this->cp["tipo_estado_id"]->GetDBValue(true);
        $this->InsertFields["tipo_mejora_destino_id"]["Value"] = $this->cp["tipo_mejora_destino_id"]->GetDBValue(true);
        $this->InsertFields["mejora_valor"]["Value"] = $this->cp["mejora_valor"]->GetDBValue(true);
        $this->InsertFields["mejora_porc_dominio"]["Value"] = $this->cp["mejora_porc_dominio"]->GetDBValue(true);
        $this->InsertFields["mejora_sup_semi_cub"]["Value"] = $this->cp["mejora_sup_semi_cub"]->GetDBValue(true);
        $this->InsertFields["mejora_f_baja"]["Value"] = $this->cp["mejora_f_baja"]->GetDBValue(true);
        $this->InsertFields["mejora_id"]["Value"] = $this->cp["mejora_id"]->GetDBValue(true);
        $this->InsertFields["tipo_mejora_cat_id"]["Value"] = $this->cp["tipo_mejora_cat_id"]->GetDBValue(true);
        $this->InsertFields["tipo_mejora_estado_id"]["Value"] = $this->cp["tipo_mejora_estado_id"]->GetDBValue(true);
        $this->InsertFields["tipo_mejora_conserva_id"]["Value"] = $this->cp["tipo_mejora_conserva_id"]->GetDBValue(true);
        $this->InsertFields["mejora_anio_construccion"]["Value"] = $this->cp["mejora_anio_construccion"]->GetDBValue(true);
        $this->InsertFields["mejora_coef_ajuste"]["Value"] = $this->cp["mejora_coef_ajuste"]->GetDBValue(true);
        $this->InsertFields["mejora_valor"]["Value"] = $this->cp["mejora_valor"]->GetDBValue(true);
        $this->InsertFields["mejora_valuacion"]["Value"] = $this->cp["mejora_valuacion"]->GetDBValue(true);
        $this->InsertFields["tipo_mejora_conserva_2_id"]["Value"] = $this->cp["tipo_mejora_conserva_2_id"]->GetDBValue(true);
        $this->InsertFields["mejora_anio_construccion_2"]["Value"] = $this->cp["mejora_anio_construccion_2"]->GetDBValue(true);
        $this->InsertFields["tipo_mejora_cat_2_id"]["Value"] = $this->cp["tipo_mejora_cat_2_id"]->GetDBValue(true);
        $this->InsertFields["mejora_edif_id"]["Value"] = $this->cp["mejora_edif_id"]->GetDBValue(true);
        $this->InsertFields["tipo_mejora_conserva_3_id"]["Value"] = $this->cp["tipo_mejora_conserva_3_id"]->GetDBValue(true);
        $this->InsertFields["mejora_anio_construccion_3"]["Value"] = $this->cp["mejora_anio_construccion_3"]->GetDBValue(true);
        $this->InsertFields["tipo_mejora_cat_3_id"]["Value"] = $this->cp["tipo_mejora_cat_3_id"]->GetDBValue(true);
        $this->InsertFields["mejora_cant_bp"]["Value"] = $this->cp["mejora_cant_bp"]->GetDBValue(true);
        $this->InsertFields["mejora_cant_bs"]["Value"] = $this->cp["mejora_cant_bs"]->GetDBValue(true);
        $this->InsertFields["usuario_id"]["Value"] = $this->cp["usuario_id"]->GetDBValue(true);
        $this->InsertFields["mejora_form"]["Value"] = $this->cp["mejora_form"]->GetDBValue(true);
        $this->InsertFields["mejora_sup_cub_2"]["Value"] = $this->cp["mejora_sup_cub_2"]->GetDBValue(true);
        $this->InsertFields["tipo_mejora_decla_id"]["Value"] = $this->cp["tipo_mejora_decla_id"]->GetDBValue(true);
        $this->InsertFields["tipo_mejora_decla_id"]["Value"] = $this->cp["tipo_mejora_decla_id"]->GetDBValue(true);
        $this->SQL = CCBuildInsert("mejoras", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @356-E22134C5
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["parcela_id"] = new clsSQLParameter("ctrlparcela_id", ccsInteger, "", "", $this->parcela_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_nro_exp"] = new clsSQLParameter("ctrlmejora_nro_exp", ccsInteger, "", "", $this->mejora_nro_exp->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_sup_cub"] = new clsSQLParameter("ctrlmejora_sup_cub", ccsFloat, array(False, 4, Null, "", False, "", "", 1, True, ""), "", $this->mejora_sup_cub->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_observacion"] = new clsSQLParameter("ctrlmejora_observacion", ccsText, "", "", $this->mejora_observacion->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_letra_exp"] = new clsSQLParameter("ctrlmejora_letra_exp", ccsText, "", "", $this->mejora_letra_exp->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_fecha_exp"] = new clsSQLParameter("ctrlmejora_fecha_exp", ccsDate, $DefaultDateFormat, $this->DateFormat, $this->mejora_fecha_exp->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_id"] = new clsSQLParameter("ctrltipo_mejora_id", ccsInteger, "", "", $this->tipo_mejora_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_categoria_dpc"] = new clsSQLParameter("ctrlmejora_categoria_dpc", ccsInteger, "", "", $this->mejora_categoria_dpc->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_f_alta"] = new clsSQLParameter("ctrlmejora_f_alta", ccsDate, $DefaultDateFormat, $this->DateFormat, $this->mejora_f_alta->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_f_pro"] = new clsSQLParameter("ctrlmejora_f_pro", ccsText, "", "", $this->mejora_f_pro->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["audit_string"] = new clsSQLParameter("ctrlaudit_string", ccsText, "", "", $this->audit_string->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_estado_id"] = new clsSQLParameter("ctrltipo_estado_id", ccsInteger, "", "", $this->tipo_estado_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_destino_id"] = new clsSQLParameter("ctrltipo_mejora_destino_id", ccsInteger, "", "", $this->tipo_mejora_destino_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_valor"] = new clsSQLParameter("ctrlmejora_valor", ccsFloat, "", "", $this->mejora_valor->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_porc_dominio"] = new clsSQLParameter("ctrlmejora_porc_dominio", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), "", $this->mejora_porc_dominio->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_sup_semi_cub"] = new clsSQLParameter("ctrlmejora_sup_semi_cub", ccsFloat, array(False, 4, Null, "", False, "", "", 1, True, ""), "", $this->mejora_sup_semi_cub->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_f_baja"] = new clsSQLParameter("ctrlmejora_f_baja", ccsText, "", "", $this->mejora_f_baja->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_id"] = new clsSQLParameter("ctrlmejora_id", ccsText, "", "", $this->mejora_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_cat_id"] = new clsSQLParameter("ctrltipo_mejora_cat_id", ccsInteger, "", "", $this->tipo_mejora_cat_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_estado_id"] = new clsSQLParameter("ctrltipo_mejora_estado_id", ccsInteger, "", "", $this->tipo_mejora_estado_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_conserva_id"] = new clsSQLParameter("ctrltipo_mejora_conserva_id", ccsInteger, "", "", $this->tipo_mejora_conserva_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_anio_construccion"] = new clsSQLParameter("ctrlmejora_anio_construccion", ccsText, "", "", $this->mejora_anio_construccion->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_coef_ajuste"] = new clsSQLParameter("ctrlcoefE1A", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), "", $this->coefE1A->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_valor"] = new clsSQLParameter("ctrlvtE1A", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), "", $this->vtE1A->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_valuacion"] = new clsSQLParameter("ctrlvaE1A", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), "", $this->vaE1A->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_conserva_2_id"] = new clsSQLParameter("ctrltipo_mejora_conserva_id_2", ccsInteger, "", "", $this->tipo_mejora_conserva_id_2->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_anio_construccion_2"] = new clsSQLParameter("ctrlmejora_anio_construccion_2", ccsText, "", "", $this->mejora_anio_construccion_2->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_cat_2_id"] = new clsSQLParameter("ctrltipo_mejora_cat_id_2", ccsInteger, "", "", $this->tipo_mejora_cat_id_2->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_edif_id"] = new clsSQLParameter("ctrlmejora_edif_id", ccsText, "", "", $this->mejora_edif_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_conserva_3_id"] = new clsSQLParameter("ctrltipo_mejora_conserva_id_3", ccsInteger, "", "", $this->tipo_mejora_conserva_id_3->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_anio_construccion_3"] = new clsSQLParameter("ctrlmejora_anio_construccion_3", ccsText, "", "", $this->mejora_anio_construccion_3->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_cat_3_id"] = new clsSQLParameter("ctrltipo_mejora_cat_id_3", ccsInteger, "", "", $this->tipo_mejora_cat_id_3->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_cant_bp"] = new clsSQLParameter("ctrlcantE1D", ccsInteger, "", "", $this->cantE1D->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_cant_bs"] = new clsSQLParameter("ctrlcantE1E", ccsInteger, "", "", $this->cantE1E->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["usuario_id"] = new clsSQLParameter("ctrlusuario_id", ccsText, "", "", $this->usuario_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_form"] = new clsSQLParameter("ctrlmejora_form", ccsText, "", "", $this->mejora_form->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["mejora_sup_cub_2"] = new clsSQLParameter("ctrlmejora_sup_cub_2", ccsFloat, array(False, 4, Null, "", False, "", "", 1, True, ""), "", $this->mejora_sup_cub_2->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_mejora_decla_id"] = new clsSQLParameter("ctrltipo_mejora_decla_id", ccsInteger, "", "", $this->tipo_mejora_decla_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $wp = new clsSQLParameters($this->ErrorBlock);
        $wp->AddParameter("1", "urlmejora_id", ccsInteger, "", "", CCGetFromGet("mejora_id", NULL), "", false);
        if(!$wp->AllParamsSet()) {
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        if (!is_null($this->cp["parcela_id"]->GetValue()) and !strlen($this->cp["parcela_id"]->GetText()) and !is_bool($this->cp["parcela_id"]->GetValue())) 
            $this->cp["parcela_id"]->SetValue($this->parcela_id->GetValue(true));
        if (!is_null($this->cp["mejora_nro_exp"]->GetValue()) and !strlen($this->cp["mejora_nro_exp"]->GetText()) and !is_bool($this->cp["mejora_nro_exp"]->GetValue())) 
            $this->cp["mejora_nro_exp"]->SetValue($this->mejora_nro_exp->GetValue(true));
        if (!is_null($this->cp["mejora_sup_cub"]->GetValue()) and !strlen($this->cp["mejora_sup_cub"]->GetText()) and !is_bool($this->cp["mejora_sup_cub"]->GetValue())) 
            $this->cp["mejora_sup_cub"]->SetValue($this->mejora_sup_cub->GetValue(true));
        if (!is_null($this->cp["mejora_observacion"]->GetValue()) and !strlen($this->cp["mejora_observacion"]->GetText()) and !is_bool($this->cp["mejora_observacion"]->GetValue())) 
            $this->cp["mejora_observacion"]->SetValue($this->mejora_observacion->GetValue(true));
        if (!is_null($this->cp["mejora_letra_exp"]->GetValue()) and !strlen($this->cp["mejora_letra_exp"]->GetText()) and !is_bool($this->cp["mejora_letra_exp"]->GetValue())) 
            $this->cp["mejora_letra_exp"]->SetValue($this->mejora_letra_exp->GetValue(true));
        if (!is_null($this->cp["mejora_fecha_exp"]->GetValue()) and !strlen($this->cp["mejora_fecha_exp"]->GetText()) and !is_bool($this->cp["mejora_fecha_exp"]->GetValue())) 
            $this->cp["mejora_fecha_exp"]->SetValue($this->mejora_fecha_exp->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_id"]->GetValue())) 
            $this->cp["tipo_mejora_id"]->SetValue($this->tipo_mejora_id->GetValue(true));
        if (!is_null($this->cp["mejora_categoria_dpc"]->GetValue()) and !strlen($this->cp["mejora_categoria_dpc"]->GetText()) and !is_bool($this->cp["mejora_categoria_dpc"]->GetValue())) 
            $this->cp["mejora_categoria_dpc"]->SetValue($this->mejora_categoria_dpc->GetValue(true));
        if (!is_null($this->cp["mejora_f_alta"]->GetValue()) and !strlen($this->cp["mejora_f_alta"]->GetText()) and !is_bool($this->cp["mejora_f_alta"]->GetValue())) 
            $this->cp["mejora_f_alta"]->SetValue($this->mejora_f_alta->GetValue(true));
        if (!is_null($this->cp["mejora_f_pro"]->GetValue()) and !strlen($this->cp["mejora_f_pro"]->GetText()) and !is_bool($this->cp["mejora_f_pro"]->GetValue())) 
            $this->cp["mejora_f_pro"]->SetValue($this->mejora_f_pro->GetValue(true));
        if (!is_null($this->cp["audit_string"]->GetValue()) and !strlen($this->cp["audit_string"]->GetText()) and !is_bool($this->cp["audit_string"]->GetValue())) 
            $this->cp["audit_string"]->SetValue($this->audit_string->GetValue(true));
        if (!is_null($this->cp["tipo_estado_id"]->GetValue()) and !strlen($this->cp["tipo_estado_id"]->GetText()) and !is_bool($this->cp["tipo_estado_id"]->GetValue())) 
            $this->cp["tipo_estado_id"]->SetValue($this->tipo_estado_id->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_destino_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_destino_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_destino_id"]->GetValue())) 
            $this->cp["tipo_mejora_destino_id"]->SetValue($this->tipo_mejora_destino_id->GetValue(true));
        if (!is_null($this->cp["mejora_valor"]->GetValue()) and !strlen($this->cp["mejora_valor"]->GetText()) and !is_bool($this->cp["mejora_valor"]->GetValue())) 
            $this->cp["mejora_valor"]->SetValue($this->mejora_valor->GetValue(true));
        if (!is_null($this->cp["mejora_porc_dominio"]->GetValue()) and !strlen($this->cp["mejora_porc_dominio"]->GetText()) and !is_bool($this->cp["mejora_porc_dominio"]->GetValue())) 
            $this->cp["mejora_porc_dominio"]->SetValue($this->mejora_porc_dominio->GetValue(true));
        if (!is_null($this->cp["mejora_sup_semi_cub"]->GetValue()) and !strlen($this->cp["mejora_sup_semi_cub"]->GetText()) and !is_bool($this->cp["mejora_sup_semi_cub"]->GetValue())) 
            $this->cp["mejora_sup_semi_cub"]->SetValue($this->mejora_sup_semi_cub->GetValue(true));
        if (!is_null($this->cp["mejora_f_baja"]->GetValue()) and !strlen($this->cp["mejora_f_baja"]->GetText()) and !is_bool($this->cp["mejora_f_baja"]->GetValue())) 
            $this->cp["mejora_f_baja"]->SetValue($this->mejora_f_baja->GetValue(true));
        if (!is_null($this->cp["mejora_id"]->GetValue()) and !strlen($this->cp["mejora_id"]->GetText()) and !is_bool($this->cp["mejora_id"]->GetValue())) 
            $this->cp["mejora_id"]->SetValue($this->mejora_id->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_cat_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_cat_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_cat_id"]->GetValue())) 
            $this->cp["tipo_mejora_cat_id"]->SetValue($this->tipo_mejora_cat_id->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_estado_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_estado_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_estado_id"]->GetValue())) 
            $this->cp["tipo_mejora_estado_id"]->SetValue($this->tipo_mejora_estado_id->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_conserva_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_conserva_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_conserva_id"]->GetValue())) 
            $this->cp["tipo_mejora_conserva_id"]->SetValue($this->tipo_mejora_conserva_id->GetValue(true));
        if (!is_null($this->cp["mejora_anio_construccion"]->GetValue()) and !strlen($this->cp["mejora_anio_construccion"]->GetText()) and !is_bool($this->cp["mejora_anio_construccion"]->GetValue())) 
            $this->cp["mejora_anio_construccion"]->SetValue($this->mejora_anio_construccion->GetValue(true));
        if (!is_null($this->cp["mejora_coef_ajuste"]->GetValue()) and !strlen($this->cp["mejora_coef_ajuste"]->GetText()) and !is_bool($this->cp["mejora_coef_ajuste"]->GetValue())) 
            $this->cp["mejora_coef_ajuste"]->SetValue($this->coefE1A->GetValue(true));
        if (!is_null($this->cp["mejora_valor"]->GetValue()) and !strlen($this->cp["mejora_valor"]->GetText()) and !is_bool($this->cp["mejora_valor"]->GetValue())) 
            $this->cp["mejora_valor"]->SetValue($this->vtE1A->GetValue(true));
        if (!is_null($this->cp["mejora_valuacion"]->GetValue()) and !strlen($this->cp["mejora_valuacion"]->GetText()) and !is_bool($this->cp["mejora_valuacion"]->GetValue())) 
            $this->cp["mejora_valuacion"]->SetValue($this->vaE1A->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_conserva_2_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_conserva_2_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_conserva_2_id"]->GetValue())) 
            $this->cp["tipo_mejora_conserva_2_id"]->SetValue($this->tipo_mejora_conserva_id_2->GetValue(true));
        if (!is_null($this->cp["mejora_anio_construccion_2"]->GetValue()) and !strlen($this->cp["mejora_anio_construccion_2"]->GetText()) and !is_bool($this->cp["mejora_anio_construccion_2"]->GetValue())) 
            $this->cp["mejora_anio_construccion_2"]->SetValue($this->mejora_anio_construccion_2->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_cat_2_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_cat_2_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_cat_2_id"]->GetValue())) 
            $this->cp["tipo_mejora_cat_2_id"]->SetValue($this->tipo_mejora_cat_id_2->GetValue(true));
        if (!is_null($this->cp["mejora_edif_id"]->GetValue()) and !strlen($this->cp["mejora_edif_id"]->GetText()) and !is_bool($this->cp["mejora_edif_id"]->GetValue())) 
            $this->cp["mejora_edif_id"]->SetValue($this->mejora_edif_id->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_conserva_3_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_conserva_3_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_conserva_3_id"]->GetValue())) 
            $this->cp["tipo_mejora_conserva_3_id"]->SetValue($this->tipo_mejora_conserva_id_3->GetValue(true));
        if (!is_null($this->cp["mejora_anio_construccion_3"]->GetValue()) and !strlen($this->cp["mejora_anio_construccion_3"]->GetText()) and !is_bool($this->cp["mejora_anio_construccion_3"]->GetValue())) 
            $this->cp["mejora_anio_construccion_3"]->SetValue($this->mejora_anio_construccion_3->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_cat_3_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_cat_3_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_cat_3_id"]->GetValue())) 
            $this->cp["tipo_mejora_cat_3_id"]->SetValue($this->tipo_mejora_cat_id_3->GetValue(true));
        if (!is_null($this->cp["mejora_cant_bp"]->GetValue()) and !strlen($this->cp["mejora_cant_bp"]->GetText()) and !is_bool($this->cp["mejora_cant_bp"]->GetValue())) 
            $this->cp["mejora_cant_bp"]->SetValue($this->cantE1D->GetValue(true));
        if (!is_null($this->cp["mejora_cant_bs"]->GetValue()) and !strlen($this->cp["mejora_cant_bs"]->GetText()) and !is_bool($this->cp["mejora_cant_bs"]->GetValue())) 
            $this->cp["mejora_cant_bs"]->SetValue($this->cantE1E->GetValue(true));
        if (!is_null($this->cp["usuario_id"]->GetValue()) and !strlen($this->cp["usuario_id"]->GetText()) and !is_bool($this->cp["usuario_id"]->GetValue())) 
            $this->cp["usuario_id"]->SetValue($this->usuario_id->GetValue(true));
        if (!is_null($this->cp["mejora_form"]->GetValue()) and !strlen($this->cp["mejora_form"]->GetText()) and !is_bool($this->cp["mejora_form"]->GetValue())) 
            $this->cp["mejora_form"]->SetValue($this->mejora_form->GetValue(true));
        if (!is_null($this->cp["mejora_sup_cub_2"]->GetValue()) and !strlen($this->cp["mejora_sup_cub_2"]->GetText()) and !is_bool($this->cp["mejora_sup_cub_2"]->GetValue())) 
            $this->cp["mejora_sup_cub_2"]->SetValue($this->mejora_sup_cub_2->GetValue(true));
        if (!is_null($this->cp["tipo_mejora_decla_id"]->GetValue()) and !strlen($this->cp["tipo_mejora_decla_id"]->GetText()) and !is_bool($this->cp["tipo_mejora_decla_id"]->GetValue())) 
            $this->cp["tipo_mejora_decla_id"]->SetValue($this->tipo_mejora_decla_id->GetValue(true));
        $wp->Criterion[1] = $wp->Operation(opEqual, "mejora_id", $wp->GetDBValue("1"), $this->ToSQL($wp->GetDBValue("1"), ccsInteger),false);
        $Where = 
             $wp->Criterion[1];
        $this->UpdateFields["parcela_id"]["Value"] = $this->cp["parcela_id"]->GetDBValue(true);
        $this->UpdateFields["mejora_nro_exp"]["Value"] = $this->cp["mejora_nro_exp"]->GetDBValue(true);
        $this->UpdateFields["mejora_sup_cub"]["Value"] = $this->cp["mejora_sup_cub"]->GetDBValue(true);
        $this->UpdateFields["mejora_observacion"]["Value"] = $this->cp["mejora_observacion"]->GetDBValue(true);
        $this->UpdateFields["mejora_letra_exp"]["Value"] = $this->cp["mejora_letra_exp"]->GetDBValue(true);
        $this->UpdateFields["mejora_fecha_exp"]["Value"] = $this->cp["mejora_fecha_exp"]->GetDBValue(true);
        $this->UpdateFields["tipo_mejora_id"]["Value"] = $this->cp["tipo_mejora_id"]->GetDBValue(true);
        $this->UpdateFields["mejora_categoria_dpc"]["Value"] = $this->cp["mejora_categoria_dpc"]->GetDBValue(true);
        $this->UpdateFields["mejora_f_alta"]["Value"] = $this->cp["mejora_f_alta"]->GetDBValue(true);
        $this->UpdateFields["mejora_f_pro"]["Value"] = $this->cp["mejora_f_pro"]->GetDBValue(true);
        $this->UpdateFields["audit_string"]["Value"] = $this->cp["audit_string"]->GetDBValue(true);
        $this->UpdateFields["tipo_estado_id"]["Value"] = $this->cp["tipo_estado_id"]->GetDBValue(true);
        $this->UpdateFields["tipo_mejora_destino_id"]["Value"] = $this->cp["tipo_mejora_destino_id"]->GetDBValue(true);
        $this->UpdateFields["mejora_valor"]["Value"] = $this->cp["mejora_valor"]->GetDBValue(true);
        $this->UpdateFields["mejora_porc_dominio"]["Value"] = $this->cp["mejora_porc_dominio"]->GetDBValue(true);
        $this->UpdateFields["mejora_sup_semi_cub"]["Value"] = $this->cp["mejora_sup_semi_cub"]->GetDBValue(true);
        $this->UpdateFields["mejora_f_baja"]["Value"] = $this->cp["mejora_f_baja"]->GetDBValue(true);
        $this->UpdateFields["mejora_id"]["Value"] = $this->cp["mejora_id"]->GetDBValue(true);
        $this->UpdateFields["tipo_mejora_cat_id"]["Value"] = $this->cp["tipo_mejora_cat_id"]->GetDBValue(true);
        $this->UpdateFields["tipo_mejora_estado_id"]["Value"] = $this->cp["tipo_mejora_estado_id"]->GetDBValue(true);
        $this->UpdateFields["tipo_mejora_conserva_id"]["Value"] = $this->cp["tipo_mejora_conserva_id"]->GetDBValue(true);
        $this->UpdateFields["mejora_anio_construccion"]["Value"] = $this->cp["mejora_anio_construccion"]->GetDBValue(true);
        $this->UpdateFields["mejora_coef_ajuste"]["Value"] = $this->cp["mejora_coef_ajuste"]->GetDBValue(true);
        $this->UpdateFields["mejora_valor"]["Value"] = $this->cp["mejora_valor"]->GetDBValue(true);
        $this->UpdateFields["mejora_valuacion"]["Value"] = $this->cp["mejora_valuacion"]->GetDBValue(true);
        $this->UpdateFields["tipo_mejora_conserva_2_id"]["Value"] = $this->cp["tipo_mejora_conserva_2_id"]->GetDBValue(true);
        $this->UpdateFields["mejora_anio_construccion_2"]["Value"] = $this->cp["mejora_anio_construccion_2"]->GetDBValue(true);
        $this->UpdateFields["tipo_mejora_cat_2_id"]["Value"] = $this->cp["tipo_mejora_cat_2_id"]->GetDBValue(true);
        $this->UpdateFields["mejora_edif_id"]["Value"] = $this->cp["mejora_edif_id"]->GetDBValue(true);
        $this->UpdateFields["tipo_mejora_conserva_3_id"]["Value"] = $this->cp["tipo_mejora_conserva_3_id"]->GetDBValue(true);
        $this->UpdateFields["mejora_anio_construccion_3"]["Value"] = $this->cp["mejora_anio_construccion_3"]->GetDBValue(true);
        $this->UpdateFields["tipo_mejora_cat_3_id"]["Value"] = $this->cp["tipo_mejora_cat_3_id"]->GetDBValue(true);
        $this->UpdateFields["mejora_cant_bp"]["Value"] = $this->cp["mejora_cant_bp"]->GetDBValue(true);
        $this->UpdateFields["mejora_cant_bs"]["Value"] = $this->cp["mejora_cant_bs"]->GetDBValue(true);
        $this->UpdateFields["usuario_id"]["Value"] = $this->cp["usuario_id"]->GetDBValue(true);
        $this->UpdateFields["mejora_form"]["Value"] = $this->cp["mejora_form"]->GetDBValue(true);
        $this->UpdateFields["mejora_sup_cub_2"]["Value"] = $this->cp["mejora_sup_cub_2"]->GetDBValue(true);
        $this->UpdateFields["tipo_mejora_decla_id"]["Value"] = $this->cp["tipo_mejora_decla_id"]->GetDBValue(true);
        $this->SQL = CCBuildUpdate("mejoras", $this->UpdateFields, $this);
        $this->SQL .= strlen($Where) ? " WHERE " . $Where : $Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

} //End mejoras1DataSource Class @356-FCB6E20C



//Initialize Page @1-F217A409
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
$TemplateFileName = "gridMejoras.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-D9DBF8C9
CCSecurityRedirect("1;2", "");
//End Authenticate User

//Include events file @1-D9E7F482
include_once("./gridMejoras_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-3E8777C7
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$mejoras_tipos_mejoras_tip = new clsGridmejoras_tipos_mejoras_tip("", $MainPage);
$mejoras = new clsRecordmejoras("", $MainPage);
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$footerParcela = new clsfooterParcela("", "footerParcela", $MainPage);
$footerParcela->Initialize();
$headerParcela = new clsheaderParcela("", "headerParcela", $MainPage);
$headerParcela->Initialize();
$parcelas = new clsRecordparcelas("", $MainPage);
$mejoras1 = new clsRecordmejoras1("", $MainPage);
$MainPage->mejoras_tipos_mejoras_tip = & $mejoras_tipos_mejoras_tip;
$MainPage->mejoras = & $mejoras;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->footerParcela = & $footerParcela;
$MainPage->headerParcela = & $headerParcela;
$MainPage->parcelas = & $parcelas;
$MainPage->mejoras1 = & $mejoras1;
$mejoras_tipos_mejoras_tip->Initialize();
$mejoras->Initialize();
$parcelas->Initialize();
$mejoras1->Initialize();

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

//Execute Components @1-32C1EDE5
$mejoras->Operation();
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
$footerParcela->Operations();
$headerParcela->Operations();
$parcelas->Operation();
$mejoras1->Operation();
//End Execute Components

//Go to destination page @1-D3026D1A
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    unset($mejoras_tipos_mejoras_tip);
    unset($mejoras);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    $footerParcela->Class_Terminate();
    unset($footerParcela);
    $headerParcela->Class_Terminate();
    unset($headerParcela);
    unset($parcelas);
    unset($mejoras1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-CE2C5333
$mejoras_tipos_mejoras_tip->Show();
$mejoras->Show();
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$footerParcela->Show();
$headerParcela->Show();
$parcelas->Show();
$mejoras1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$ERFJKLPO2O10C6N3O1D = explode("|", "<center><font fa|ce=\"Arial\"><small|>&#71;&#101;|nera&#116;ed |<!-- CCS -->&|#119;i&#116;|h <!-- CCS -->C&|#111;&#100;&#101;|C&#104;arge <!|-- CCS -->S&#1|16;&#117;&#100;|&#105;&#111;.|</small></font></|center>");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($ERFJKLPO2O10C6N3O1D,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($ERFJKLPO2O10C6N3O1D,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($ERFJKLPO2O10C6N3O1D,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-F99FDCB7
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($mejoras_tipos_mejoras_tip);
unset($mejoras);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$footerParcela->Class_Terminate();
unset($footerParcela);
$headerParcela->Class_Terminate();
unset($headerParcela);
unset($parcelas);
unset($mejoras1);
unset($Tpl);
//End Unload Page


?>
