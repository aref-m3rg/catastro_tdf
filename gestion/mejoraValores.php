<?php
//Include Common Files @1-A55AFAAC
define("RelativePath", "..");
define("PathToCurrentPage", "/gestion/");
define("FileName", "mejoraValores.php");
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

class clsGridmejoras_valores { //mejoras_valores class @6-A39A7976

//Variables @6-737EAEF2

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
    public $Sorter_mejora_valor_f_fin;
    public $Sorter_mejora_valor_f_ini;
    public $Sorter_mejora_formulario_id;
    public $Sorter_tipo_mejora_cat_id;
    public $Sorter_mejora_construccion_id;
    public $Sorter_mejora_valor_valor;
//End Variables

//Class_Initialize Event @6-E88A8D33
    function clsGridmejoras_valores($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "mejoras_valores";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid mejoras_valores";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsmejoras_valoresDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 25;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("mejoras_valoresOrder", "");
        $this->SorterDirection = CCGetParam("mejoras_valoresDir", "");

        $this->mejora_valor_f_fin = new clsControl(ccsLabel, "mejora_valor_f_fin", "mejora_valor_f_fin", ccsText, "", CCGetRequestParam("mejora_valor_f_fin", ccsGet, NULL), $this);
        $this->mejora_valor_f_ini = new clsControl(ccsLink, "mejora_valor_f_ini", "mejora_valor_f_ini", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("mejora_valor_f_ini", ccsGet, NULL), $this);
        $this->mejora_valor_f_ini->Page = "mejoraValores.php";
        $this->mejora_formulario_abrev = new clsControl(ccsLabel, "mejora_formulario_abrev", "mejora_formulario_abrev", ccsText, "", CCGetRequestParam("mejora_formulario_abrev", ccsGet, NULL), $this);
        $this->tipo_mejora_cat_descript = new clsControl(ccsLabel, "tipo_mejora_cat_descript", "tipo_mejora_cat_descript", ccsText, "", CCGetRequestParam("tipo_mejora_cat_descript", ccsGet, NULL), $this);
        $this->mejora_contruccion_descrip = new clsControl(ccsLabel, "mejora_contruccion_descrip", "mejora_contruccion_descrip", ccsText, "", CCGetRequestParam("mejora_contruccion_descrip", ccsGet, NULL), $this);
        $this->mejora_valor_valor = new clsControl(ccsLabel, "mejora_valor_valor", "mejora_valor_valor", ccsSingle, "", CCGetRequestParam("mejora_valor_valor", ccsGet, NULL), $this);
        $this->Sorter_mejora_valor_f_fin = new clsSorter($this->ComponentName, "Sorter_mejora_valor_f_fin", $FileName, $this);
        $this->Sorter_mejora_valor_f_ini = new clsSorter($this->ComponentName, "Sorter_mejora_valor_f_ini", $FileName, $this);
        $this->Sorter_mejora_formulario_id = new clsSorter($this->ComponentName, "Sorter_mejora_formulario_id", $FileName, $this);
        $this->Sorter_tipo_mejora_cat_id = new clsSorter($this->ComponentName, "Sorter_tipo_mejora_cat_id", $FileName, $this);
        $this->Sorter_mejora_construccion_id = new clsSorter($this->ComponentName, "Sorter_mejora_construccion_id", $FileName, $this);
        $this->Sorter_mejora_valor_valor = new clsSorter($this->ComponentName, "Sorter_mejora_valor_valor", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
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

//Show Method @6-B77576B6
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
            $this->ControlsVisible["mejora_valor_f_fin"] = $this->mejora_valor_f_fin->Visible;
            $this->ControlsVisible["mejora_valor_f_ini"] = $this->mejora_valor_f_ini->Visible;
            $this->ControlsVisible["mejora_formulario_abrev"] = $this->mejora_formulario_abrev->Visible;
            $this->ControlsVisible["tipo_mejora_cat_descript"] = $this->tipo_mejora_cat_descript->Visible;
            $this->ControlsVisible["mejora_contruccion_descrip"] = $this->mejora_contruccion_descrip->Visible;
            $this->ControlsVisible["mejora_valor_valor"] = $this->mejora_valor_valor->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                if(!is_array($this->mejora_valor_f_fin->Value) && !strlen($this->mejora_valor_f_fin->Value) && $this->mejora_valor_f_fin->Value !== false)
                    $this->mejora_valor_f_fin->SetText("a la fecha actual");
                $this->mejora_valor_f_ini->SetValue($this->DataSource->mejora_valor_f_ini->GetValue());
                $this->mejora_valor_f_ini->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->mejora_valor_f_ini->Parameters = CCAddParam($this->mejora_valor_f_ini->Parameters, "mejora_valor_id", $this->DataSource->f("mejora_valor_id"));
                $this->mejora_formulario_abrev->SetValue($this->DataSource->mejora_formulario_abrev->GetValue());
                $this->tipo_mejora_cat_descript->SetValue($this->DataSource->tipo_mejora_cat_descript->GetValue());
                $this->mejora_contruccion_descrip->SetValue($this->DataSource->mejora_contruccion_descrip->GetValue());
                $this->mejora_valor_valor->SetValue($this->DataSource->mejora_valor_valor->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->mejora_valor_f_fin->Show();
                $this->mejora_valor_f_ini->Show();
                $this->mejora_formulario_abrev->Show();
                $this->tipo_mejora_cat_descript->Show();
                $this->mejora_contruccion_descrip->Show();
                $this->mejora_valor_valor->Show();
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
        $this->Sorter_mejora_valor_f_fin->Show();
        $this->Sorter_mejora_valor_f_ini->Show();
        $this->Sorter_mejora_formulario_id->Show();
        $this->Sorter_tipo_mejora_cat_id->Show();
        $this->Sorter_mejora_construccion_id->Show();
        $this->Sorter_mejora_valor_valor->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @6-67ED6018
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->mejora_valor_f_fin->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_valor_f_ini->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_formulario_abrev->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_mejora_cat_descript->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_contruccion_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_valor_valor->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End mejoras_valores Class @6-FCB6E20C

class clsmejoras_valoresDataSource extends clsDBtdf_nuevo {  //mejoras_valoresDataSource Class @6-8EBCB09F

//DataSource Variables @6-B5BA37F8
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $mejora_valor_f_ini;
    public $mejora_formulario_abrev;
    public $tipo_mejora_cat_descript;
    public $mejora_contruccion_descrip;
    public $mejora_valor_valor;
//End DataSource Variables

//DataSourceClass_Initialize Event @6-8F2AFA02
    function clsmejoras_valoresDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid mejoras_valores";
        $this->Initialize();
        $this->mejora_valor_f_ini = new clsField("mejora_valor_f_ini", ccsDate, $this->DateFormat);
        
        $this->mejora_formulario_abrev = new clsField("mejora_formulario_abrev", ccsText, "");
        
        $this->tipo_mejora_cat_descript = new clsField("tipo_mejora_cat_descript", ccsText, "");
        
        $this->mejora_contruccion_descrip = new clsField("mejora_contruccion_descrip", ccsText, "");
        
        $this->mejora_valor_valor = new clsField("mejora_valor_valor", ccsSingle, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @6-EE97D8BA
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "mejoras_valores.mejora_formulario_id, mejora_construccion_id, mejoras_valores.tipo_mejora_cat_id";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_mejora_valor_f_fin" => array("mejora_valor_f_fin", ""), 
            "Sorter_mejora_valor_f_ini" => array("mejora_valor_f_ini", ""), 
            "Sorter_mejora_formulario_id" => array("mejora_formulario_id", ""), 
            "Sorter_tipo_mejora_cat_id" => array("tipo_mejora_cat_id", ""), 
            "Sorter_mejora_construccion_id" => array("mejora_construccion_id", ""), 
            "Sorter_mejora_valor_valor" => array("mejora_valor_valor", "")));
    }
//End SetOrder Method

//Prepare Method @6-B2F3A2FA
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->Criterion[1] = "( mejoras_valores.mejora_valor_f_fin IS NULL )";
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @6-58D507E6
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((mejoras_valores LEFT JOIN mejoras_formularios ON\n\n" .
        "mejoras_valores.mejora_formulario_id = mejoras_formularios.mejora_formulario_id) LEFT JOIN tipos_mejoras_cat ON\n\n" .
        "mejoras_valores.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id) LEFT JOIN mejoras_contrucciones ON\n\n" .
        "mejoras_valores.mejora_construccion_id = mejoras_contrucciones.mejora_contruccion_id";
        $this->SQL = "SELECT mejora_formulario_abrev, tipo_mejora_cat_descript, mejora_contruccion_descrip, mejoras_valores.* \n\n" .
        "FROM ((mejoras_valores LEFT JOIN mejoras_formularios ON\n\n" .
        "mejoras_valores.mejora_formulario_id = mejoras_formularios.mejora_formulario_id) LEFT JOIN tipos_mejoras_cat ON\n\n" .
        "mejoras_valores.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id) LEFT JOIN mejoras_contrucciones ON\n\n" .
        "mejoras_valores.mejora_construccion_id = mejoras_contrucciones.mejora_contruccion_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @6-EE778831
    function SetValues()
    {
        $this->mejora_valor_f_ini->SetDBValue(trim($this->f("mejora_valor_f_ini")));
        $this->mejora_formulario_abrev->SetDBValue($this->f("mejora_formulario_abrev"));
        $this->tipo_mejora_cat_descript->SetDBValue($this->f("tipo_mejora_cat_descript"));
        $this->mejora_contruccion_descrip->SetDBValue($this->f("mejora_contruccion_descrip"));
        $this->mejora_valor_valor->SetDBValue(trim($this->f("mejora_valor_valor")));
    }
//End SetValues Method

} //End mejoras_valoresDataSource Class @6-FCB6E20C

class clsRecordmejoras_valores1 { //mejoras_valores1 Class @29-8895C8A8

//Variables @29-9E315808

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

//Class_Initialize Event @29-3E14AB68
    function clsRecordmejoras_valores1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record mejoras_valores1/Error";
        $this->DataSource = new clsmejoras_valores1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "mejoras_valores1";
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
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->mejora_formulario_id = new clsControl(ccsListBox, "mejora_formulario_id", "Formulario", ccsInteger, "", CCGetRequestParam("mejora_formulario_id", $Method, NULL), $this);
            $this->mejora_formulario_id->DSType = dsTable;
            $this->mejora_formulario_id->DataSource = new clsDBtdf_nuevo();
            $this->mejora_formulario_id->ds = & $this->mejora_formulario_id->DataSource;
            $this->mejora_formulario_id->DataSource->SQL = "SELECT * \n" .
"FROM mejoras_formularios {SQL_Where} {SQL_OrderBy}";
            list($this->mejora_formulario_id->BoundColumn, $this->mejora_formulario_id->TextColumn, $this->mejora_formulario_id->DBFormat) = array("mejora_formulario_id", "mejora_formulario_abrev", "");
            $this->mejora_formulario_id->Required = true;
            $this->tipo_mejora_cat_id = new clsControl(ccsListBox, "tipo_mejora_cat_id", "Categoria", ccsInteger, "", CCGetRequestParam("tipo_mejora_cat_id", $Method, NULL), $this);
            $this->tipo_mejora_cat_id->DSType = dsTable;
            $this->tipo_mejora_cat_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_mejora_cat_id->ds = & $this->tipo_mejora_cat_id->DataSource;
            $this->tipo_mejora_cat_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_mejoras_cat {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_mejora_cat_id->BoundColumn, $this->tipo_mejora_cat_id->TextColumn, $this->tipo_mejora_cat_id->DBFormat) = array("tipo_mejora_cat_id", "tipo_mejora_cat_descript", "");
            $this->tipo_mejora_cat_id->Required = true;
            $this->mejora_construccion_id = new clsControl(ccsListBox, "mejora_construccion_id", "Construccion", ccsInteger, "", CCGetRequestParam("mejora_construccion_id", $Method, NULL), $this);
            $this->mejora_construccion_id->DSType = dsTable;
            $this->mejora_construccion_id->DataSource = new clsDBtdf_nuevo();
            $this->mejora_construccion_id->ds = & $this->mejora_construccion_id->DataSource;
            $this->mejora_construccion_id->DataSource->SQL = "SELECT * \n" .
"FROM mejoras_contrucciones {SQL_Where} {SQL_OrderBy}";
            list($this->mejora_construccion_id->BoundColumn, $this->mejora_construccion_id->TextColumn, $this->mejora_construccion_id->DBFormat) = array("mejora_contruccion_id", "mejora_contruccion_descrip", "");
            $this->mejora_construccion_id->Required = true;
            $this->mejora_valor_valor = new clsControl(ccsTextBox, "mejora_valor_valor", "Mejora Valor Valor", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("mejora_valor_valor", $Method, NULL), $this);
            $this->mejora_valor_valor->Required = true;
            $this->volver = new clsButton("volver", $Method, $this);
            $this->mejora_valor_f_fin = new clsControl(ccsHidden, "mejora_valor_f_fin", "Mejora Valor F Fin", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("mejora_valor_f_fin", $Method, NULL), $this);
            $this->mejora_valor_f_ini = new clsControl(ccsHidden, "mejora_valor_f_ini", "Mejora Valor F Ini", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("mejora_valor_f_ini", $Method, NULL), $this);
            $this->mejora_valor_f_ini->Required = true;
            if(!$this->FormSubmitted) {
                if(!is_array($this->mejora_valor_f_ini->Value) && !strlen($this->mejora_valor_f_ini->Value) && $this->mejora_valor_f_ini->Value !== false)
                    $this->mejora_valor_f_ini->SetValue(time());
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @29-9B160F1B
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlmejora_valor_id"] = CCGetFromGet("mejora_valor_id", NULL);
    }
//End Initialize Method

//Validate Method @29-20B62195
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->mejora_formulario_id->Validate() && $Validation);
        $Validation = ($this->tipo_mejora_cat_id->Validate() && $Validation);
        $Validation = ($this->mejora_construccion_id->Validate() && $Validation);
        $Validation = ($this->mejora_valor_valor->Validate() && $Validation);
        $Validation = ($this->mejora_valor_f_fin->Validate() && $Validation);
        $Validation = ($this->mejora_valor_f_ini->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->mejora_formulario_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_mejora_cat_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_construccion_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_valor_valor->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_valor_f_fin->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_valor_f_ini->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @29-29B47AEA
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->mejora_formulario_id->Errors->Count());
        $errors = ($errors || $this->tipo_mejora_cat_id->Errors->Count());
        $errors = ($errors || $this->mejora_construccion_id->Errors->Count());
        $errors = ($errors || $this->mejora_valor_valor->Errors->Count());
        $errors = ($errors || $this->mejora_valor_f_fin->Errors->Count());
        $errors = ($errors || $this->mejora_valor_f_ini->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @29-ED598703
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

//Operation Method @29-4DC23BE5
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
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            } else if($this->volver->Pressed) {
                $this->PressedButton = "volver";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Cancel") {
            $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "mejora_valor_id"));
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "volver") {
            $Redirect = "gridMejoras.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
            if(!CCGetEvent($this->volver->CCSEvents, "OnClick", $this->volver)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Insert") {
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_Update") {
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

//InsertRow Method @29-597171DC
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->mejora_formulario_id->SetValue($this->mejora_formulario_id->GetValue(true));
        $this->DataSource->tipo_mejora_cat_id->SetValue($this->tipo_mejora_cat_id->GetValue(true));
        $this->DataSource->mejora_construccion_id->SetValue($this->mejora_construccion_id->GetValue(true));
        $this->DataSource->mejora_valor_valor->SetValue($this->mejora_valor_valor->GetValue(true));
        $this->DataSource->mejora_valor_f_fin->SetValue($this->mejora_valor_f_fin->GetValue(true));
        $this->DataSource->mejora_valor_f_ini->SetValue($this->mejora_valor_f_ini->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @29-F6D0D1C7
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->mejora_formulario_id->SetValue($this->mejora_formulario_id->GetValue(true));
        $this->DataSource->tipo_mejora_cat_id->SetValue($this->tipo_mejora_cat_id->GetValue(true));
        $this->DataSource->mejora_construccion_id->SetValue($this->mejora_construccion_id->GetValue(true));
        $this->DataSource->mejora_valor_valor->SetValue($this->mejora_valor_valor->GetValue(true));
        $this->DataSource->mejora_valor_f_fin->SetValue($this->mejora_valor_f_fin->GetValue(true));
        $this->DataSource->mejora_valor_f_ini->SetValue($this->mejora_valor_f_ini->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @29-F3DD0BE1
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

        $this->mejora_formulario_id->Prepare();
        $this->tipo_mejora_cat_id->Prepare();
        $this->mejora_construccion_id->Prepare();

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
                    $this->mejora_formulario_id->SetValue($this->DataSource->mejora_formulario_id->GetValue());
                    $this->tipo_mejora_cat_id->SetValue($this->DataSource->tipo_mejora_cat_id->GetValue());
                    $this->mejora_construccion_id->SetValue($this->DataSource->mejora_construccion_id->GetValue());
                    $this->mejora_valor_valor->SetValue($this->DataSource->mejora_valor_valor->GetValue());
                    $this->mejora_valor_f_fin->SetValue($this->DataSource->mejora_valor_f_fin->GetValue());
                    $this->mejora_valor_f_ini->SetValue($this->DataSource->mejora_valor_f_ini->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->mejora_formulario_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_mejora_cat_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_construccion_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_valor_valor->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_valor_f_fin->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_valor_f_ini->Errors->ToString());
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
        $this->Button_Cancel->Show();
        $this->mejora_formulario_id->Show();
        $this->tipo_mejora_cat_id->Show();
        $this->mejora_construccion_id->Show();
        $this->mejora_valor_valor->Show();
        $this->volver->Show();
        $this->mejora_valor_f_fin->Show();
        $this->mejora_valor_f_ini->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End mejoras_valores1 Class @29-FCB6E20C

class clsmejoras_valores1DataSource extends clsDBtdf_nuevo {  //mejoras_valores1DataSource Class @29-1A64F3D6

//DataSource Variables @29-6D51B106
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
    public $mejora_formulario_id;
    public $tipo_mejora_cat_id;
    public $mejora_construccion_id;
    public $mejora_valor_valor;
    public $mejora_valor_f_fin;
    public $mejora_valor_f_ini;
//End DataSource Variables

//DataSourceClass_Initialize Event @29-58A3A499
    function clsmejoras_valores1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record mejoras_valores1/Error";
        $this->Initialize();
        $this->mejora_formulario_id = new clsField("mejora_formulario_id", ccsInteger, "");
        
        $this->tipo_mejora_cat_id = new clsField("tipo_mejora_cat_id", ccsInteger, "");
        
        $this->mejora_construccion_id = new clsField("mejora_construccion_id", ccsInteger, "");
        
        $this->mejora_valor_valor = new clsField("mejora_valor_valor", ccsFloat, "");
        
        $this->mejora_valor_f_fin = new clsField("mejora_valor_f_fin", ccsDate, $this->DateFormat);
        
        $this->mejora_valor_f_ini = new clsField("mejora_valor_f_ini", ccsDate, $this->DateFormat);
        

        $this->InsertFields["mejora_formulario_id"] = array("Name" => "mejora_formulario_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_mejora_cat_id"] = array("Name" => "tipo_mejora_cat_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_construccion_id"] = array("Name" => "mejora_construccion_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_valor_valor"] = array("Name" => "mejora_valor_valor", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_valor_f_fin"] = array("Name" => "mejora_valor_f_fin", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_valor_f_ini"] = array("Name" => "mejora_valor_f_ini", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_formulario_id"] = array("Name" => "mejora_formulario_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_mejora_cat_id"] = array("Name" => "tipo_mejora_cat_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_construccion_id"] = array("Name" => "mejora_construccion_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_valor_valor"] = array("Name" => "mejora_valor_valor", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_valor_f_fin"] = array("Name" => "mejora_valor_f_fin", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_valor_f_ini"] = array("Name" => "mejora_valor_f_ini", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @29-9D8CF8C6
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlmejora_valor_id", ccsInteger, "", "", $this->Parameters["urlmejora_valor_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "mejora_valor_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @29-1C983131
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM mejoras_valores {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @29-DC3D698E
    function SetValues()
    {
        $this->mejora_formulario_id->SetDBValue(trim($this->f("mejora_formulario_id")));
        $this->tipo_mejora_cat_id->SetDBValue(trim($this->f("tipo_mejora_cat_id")));
        $this->mejora_construccion_id->SetDBValue(trim($this->f("mejora_construccion_id")));
        $this->mejora_valor_valor->SetDBValue(trim($this->f("mejora_valor_valor")));
        $this->mejora_valor_f_fin->SetDBValue(trim($this->f("mejora_valor_f_fin")));
        $this->mejora_valor_f_ini->SetDBValue(trim($this->f("mejora_valor_f_ini")));
    }
//End SetValues Method

//Insert Method @29-39C810A3
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["mejora_formulario_id"]["Value"] = $this->mejora_formulario_id->GetDBValue(true);
        $this->InsertFields["tipo_mejora_cat_id"]["Value"] = $this->tipo_mejora_cat_id->GetDBValue(true);
        $this->InsertFields["mejora_construccion_id"]["Value"] = $this->mejora_construccion_id->GetDBValue(true);
        $this->InsertFields["mejora_valor_valor"]["Value"] = $this->mejora_valor_valor->GetDBValue(true);
        $this->InsertFields["mejora_valor_f_fin"]["Value"] = $this->mejora_valor_f_fin->GetDBValue(true);
        $this->InsertFields["mejora_valor_f_ini"]["Value"] = $this->mejora_valor_f_ini->GetDBValue(true);
        $this->SQL = CCBuildInsert("mejoras_valores", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @29-2623DAF7
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["mejora_formulario_id"]["Value"] = $this->mejora_formulario_id->GetDBValue(true);
        $this->UpdateFields["tipo_mejora_cat_id"]["Value"] = $this->tipo_mejora_cat_id->GetDBValue(true);
        $this->UpdateFields["mejora_construccion_id"]["Value"] = $this->mejora_construccion_id->GetDBValue(true);
        $this->UpdateFields["mejora_valor_valor"]["Value"] = $this->mejora_valor_valor->GetDBValue(true);
        $this->UpdateFields["mejora_valor_f_fin"]["Value"] = $this->mejora_valor_f_fin->GetDBValue(true);
        $this->UpdateFields["mejora_valor_f_ini"]["Value"] = $this->mejora_valor_f_ini->GetDBValue(true);
        $this->SQL = CCBuildUpdate("mejoras_valores", $this->UpdateFields, $this);
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

} //End mejoras_valores1DataSource Class @29-FCB6E20C

class clsGridmejoras_valores2 { //mejoras_valores2 class @76-8DABFD05

//Variables @76-737EAEF2

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
    public $Sorter_mejora_valor_f_fin;
    public $Sorter_mejora_valor_f_ini;
    public $Sorter_mejora_formulario_id;
    public $Sorter_tipo_mejora_cat_id;
    public $Sorter_mejora_construccion_id;
    public $Sorter_mejora_valor_valor;
//End Variables

//Class_Initialize Event @76-C0331058
    function clsGridmejoras_valores2($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "mejoras_valores2";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid mejoras_valores2";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsmejoras_valores2DataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 25;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("mejoras_valores2Order", "");
        $this->SorterDirection = CCGetParam("mejoras_valores2Dir", "");

        $this->mejora_valor_f_fin = new clsControl(ccsLabel, "mejora_valor_f_fin", "mejora_valor_f_fin", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("mejora_valor_f_fin", ccsGet, NULL), $this);
        $this->mejora_valor_f_ini = new clsControl(ccsLabel, "mejora_valor_f_ini", "mejora_valor_f_ini", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("mejora_valor_f_ini", ccsGet, NULL), $this);
        $this->mejora_formulario_abrev = new clsControl(ccsLabel, "mejora_formulario_abrev", "mejora_formulario_abrev", ccsText, "", CCGetRequestParam("mejora_formulario_abrev", ccsGet, NULL), $this);
        $this->tipo_mejora_cat_descript = new clsControl(ccsLabel, "tipo_mejora_cat_descript", "tipo_mejora_cat_descript", ccsText, "", CCGetRequestParam("tipo_mejora_cat_descript", ccsGet, NULL), $this);
        $this->mejora_contruccion_descrip = new clsControl(ccsLabel, "mejora_contruccion_descrip", "mejora_contruccion_descrip", ccsText, "", CCGetRequestParam("mejora_contruccion_descrip", ccsGet, NULL), $this);
        $this->mejora_valor_valor = new clsControl(ccsLabel, "mejora_valor_valor", "mejora_valor_valor", ccsSingle, "", CCGetRequestParam("mejora_valor_valor", ccsGet, NULL), $this);
        $this->Sorter_mejora_valor_f_fin = new clsSorter($this->ComponentName, "Sorter_mejora_valor_f_fin", $FileName, $this);
        $this->Sorter_mejora_valor_f_ini = new clsSorter($this->ComponentName, "Sorter_mejora_valor_f_ini", $FileName, $this);
        $this->Sorter_mejora_formulario_id = new clsSorter($this->ComponentName, "Sorter_mejora_formulario_id", $FileName, $this);
        $this->Sorter_tipo_mejora_cat_id = new clsSorter($this->ComponentName, "Sorter_tipo_mejora_cat_id", $FileName, $this);
        $this->Sorter_mejora_construccion_id = new clsSorter($this->ComponentName, "Sorter_mejora_construccion_id", $FileName, $this);
        $this->Sorter_mejora_valor_valor = new clsSorter($this->ComponentName, "Sorter_mejora_valor_valor", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @76-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @76-6AA067A2
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
            $this->ControlsVisible["mejora_valor_f_fin"] = $this->mejora_valor_f_fin->Visible;
            $this->ControlsVisible["mejora_valor_f_ini"] = $this->mejora_valor_f_ini->Visible;
            $this->ControlsVisible["mejora_formulario_abrev"] = $this->mejora_formulario_abrev->Visible;
            $this->ControlsVisible["tipo_mejora_cat_descript"] = $this->tipo_mejora_cat_descript->Visible;
            $this->ControlsVisible["mejora_contruccion_descrip"] = $this->mejora_contruccion_descrip->Visible;
            $this->ControlsVisible["mejora_valor_valor"] = $this->mejora_valor_valor->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->mejora_valor_f_fin->SetValue($this->DataSource->mejora_valor_f_fin->GetValue());
                $this->mejora_valor_f_ini->SetValue($this->DataSource->mejora_valor_f_ini->GetValue());
                $this->mejora_formulario_abrev->SetValue($this->DataSource->mejora_formulario_abrev->GetValue());
                $this->tipo_mejora_cat_descript->SetValue($this->DataSource->tipo_mejora_cat_descript->GetValue());
                $this->mejora_contruccion_descrip->SetValue($this->DataSource->mejora_contruccion_descrip->GetValue());
                $this->mejora_valor_valor->SetValue($this->DataSource->mejora_valor_valor->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->mejora_valor_f_fin->Show();
                $this->mejora_valor_f_ini->Show();
                $this->mejora_formulario_abrev->Show();
                $this->tipo_mejora_cat_descript->Show();
                $this->mejora_contruccion_descrip->Show();
                $this->mejora_valor_valor->Show();
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
        $this->Sorter_mejora_valor_f_fin->Show();
        $this->Sorter_mejora_valor_f_ini->Show();
        $this->Sorter_mejora_formulario_id->Show();
        $this->Sorter_tipo_mejora_cat_id->Show();
        $this->Sorter_mejora_construccion_id->Show();
        $this->Sorter_mejora_valor_valor->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @76-67ED6018
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->mejora_valor_f_fin->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_valor_f_ini->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_formulario_abrev->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_mejora_cat_descript->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_contruccion_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_valor_valor->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End mejoras_valores2 Class @76-FCB6E20C

class clsmejoras_valores2DataSource extends clsDBtdf_nuevo {  //mejoras_valores2DataSource Class @76-417342C3

//DataSource Variables @76-A7F6D376
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $mejora_valor_f_fin;
    public $mejora_valor_f_ini;
    public $mejora_formulario_abrev;
    public $tipo_mejora_cat_descript;
    public $mejora_contruccion_descrip;
    public $mejora_valor_valor;
//End DataSource Variables

//DataSourceClass_Initialize Event @76-CDC15107
    function clsmejoras_valores2DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid mejoras_valores2";
        $this->Initialize();
        $this->mejora_valor_f_fin = new clsField("mejora_valor_f_fin", ccsDate, $this->DateFormat);
        
        $this->mejora_valor_f_ini = new clsField("mejora_valor_f_ini", ccsDate, $this->DateFormat);
        
        $this->mejora_formulario_abrev = new clsField("mejora_formulario_abrev", ccsText, "");
        
        $this->tipo_mejora_cat_descript = new clsField("tipo_mejora_cat_descript", ccsText, "");
        
        $this->mejora_contruccion_descrip = new clsField("mejora_contruccion_descrip", ccsText, "");
        
        $this->mejora_valor_valor = new clsField("mejora_valor_valor", ccsSingle, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @76-97AE2E38
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "mejora_valor_f_ini desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_mejora_valor_f_fin" => array("mejora_valor_f_fin", ""), 
            "Sorter_mejora_valor_f_ini" => array("mejora_valor_f_ini", ""), 
            "Sorter_mejora_formulario_id" => array("mejora_formulario_id", ""), 
            "Sorter_tipo_mejora_cat_id" => array("tipo_mejora_cat_id", ""), 
            "Sorter_mejora_construccion_id" => array("mejora_construccion_id", ""), 
            "Sorter_mejora_valor_valor" => array("mejora_valor_valor", "")));
    }
//End SetOrder Method

//Prepare Method @76-C72A2A7A
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->Criterion[1] = "( mejoras_valores.mejora_valor_f_fin IS NOT NULL )";
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @76-96A19305
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((mejoras_valores LEFT JOIN mejoras_formularios ON\n\n" .
        "mejoras_valores.mejora_formulario_id = mejoras_formularios.mejora_formulario_id) LEFT JOIN tipos_mejoras_cat ON\n\n" .
        "mejoras_valores.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id) LEFT JOIN mejoras_contrucciones ON\n\n" .
        "mejoras_valores.mejora_construccion_id = mejoras_contrucciones.mejora_contruccion_id";
        $this->SQL = "SELECT mejora_valor_id, mejora_valor_f_fin, mejora_valor_f_ini, mejora_valor_valor, mejora_formulario_abrev, tipo_mejora_cat_descript,\n\n" .
        "mejora_contruccion_descrip \n\n" .
        "FROM ((mejoras_valores LEFT JOIN mejoras_formularios ON\n\n" .
        "mejoras_valores.mejora_formulario_id = mejoras_formularios.mejora_formulario_id) LEFT JOIN tipos_mejoras_cat ON\n\n" .
        "mejoras_valores.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id) LEFT JOIN mejoras_contrucciones ON\n\n" .
        "mejoras_valores.mejora_construccion_id = mejoras_contrucciones.mejora_contruccion_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @76-7E670DEB
    function SetValues()
    {
        $this->mejora_valor_f_fin->SetDBValue(trim($this->f("mejora_valor_f_fin")));
        $this->mejora_valor_f_ini->SetDBValue(trim($this->f("mejora_valor_f_ini")));
        $this->mejora_formulario_abrev->SetDBValue($this->f("mejora_formulario_abrev"));
        $this->tipo_mejora_cat_descript->SetDBValue($this->f("tipo_mejora_cat_descript"));
        $this->mejora_contruccion_descrip->SetDBValue($this->f("mejora_contruccion_descrip"));
        $this->mejora_valor_valor->SetDBValue(trim($this->f("mejora_valor_valor")));
    }
//End SetValues Method

} //End mejoras_valores2DataSource Class @76-FCB6E20C



//Initialize Page @1-CDEEFFE6
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
$TemplateFileName = "mejoraValores.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-59FD78D0
include_once("./mejoraValores_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-47430B28
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
$mejoras_valores = new clsGridmejoras_valores("", $MainPage);
$mejoras_valores1 = new clsRecordmejoras_valores1("", $MainPage);
$mejoras_valores2 = new clsGridmejoras_valores2("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->mejoras_valores = & $mejoras_valores;
$MainPage->mejoras_valores1 = & $mejoras_valores1;
$MainPage->mejoras_valores2 = & $mejoras_valores2;
$mejoras_valores->Initialize();
$mejoras_valores1->Initialize();
$mejoras_valores2->Initialize();

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

//Execute Components @1-1E7FA6EA
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
$mejoras_valores1->Operation();
//End Execute Components

//Go to destination page @1-44D6DFA6
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
    unset($mejoras_valores);
    unset($mejoras_valores1);
    unset($mejoras_valores2);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-270105A1
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$mejoras_valores->Show();
$mejoras_valores1->Show();
$mejoras_valores2->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$RSJM5I3F2D10H6I = ">retnec/<>tnof/<>llams/<.;111#&i;001#&;711#&t;38#&>-- CCS --!< ;101#&;301#&;411#&ah;76#&;101#&d;111#&;76#&>-- SCC --!< h;611#&;501#&w>-- CCS --!< d;101#&t;79#&;411#&ene;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<";
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", strrev($RSJM5I3F2D10H6I) . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", strrev($RSJM5I3F2D10H6I) . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= strrev($RSJM5I3F2D10H6I);
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-6E453B22
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($mejoras_valores);
unset($mejoras_valores1);
unset($mejoras_valores2);
unset($Tpl);
//End Unload Page


?>
