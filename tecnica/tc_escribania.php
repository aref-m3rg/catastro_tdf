<?php
//Include Common Files @1-8286F5CE
define("RelativePath", "..");
define("PathToCurrentPage", "/tecnica/");
define("FileName", "tc_escribania.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @2-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @3-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @4-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

class clsGridescribanias { //escribanias class @6-1E6925BB

//Variables @6-35EC4580

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
    public $Sorter_escribania_nombre;
    public $Sorter_escribania_direccion;
    public $Sorter_escribania_telefonos;
    public $Sorter_escribania_horarios_atencion;
    public $Sorter1;
//End Variables

//Class_Initialize Event @6-3DB84B36
    function clsGridescribanias($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "escribanias";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid escribanias";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsescribaniasDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 50;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("escribaniasOrder", "");
        $this->SorterDirection = CCGetParam("escribaniasDir", "");

        $this->escribania_nombre = new clsControl(ccsLink, "escribania_nombre", "escribania_nombre", ccsText, "", CCGetRequestParam("escribania_nombre", ccsGet, NULL), $this);
        $this->escribania_nombre->Page = "tc_escribania.php";
        $this->escribania_direccion = new clsControl(ccsLabel, "escribania_direccion", "escribania_direccion", ccsText, "", CCGetRequestParam("escribania_direccion", ccsGet, NULL), $this);
        $this->escribania_telefonos = new clsControl(ccsLabel, "escribania_telefonos", "escribania_telefonos", ccsText, "", CCGetRequestParam("escribania_telefonos", ccsGet, NULL), $this);
        $this->escribania_horarios_atencion = new clsControl(ccsLabel, "escribania_horarios_atencion", "escribania_horarios_atencion", ccsText, "", CCGetRequestParam("escribania_horarios_atencion", ccsGet, NULL), $this);
        $this->dpto_desc = new clsControl(ccsLabel, "dpto_desc", "dpto_desc", ccsText, "", CCGetRequestParam("dpto_desc", ccsGet, NULL), $this);
        $this->Sorter_escribania_nombre = new clsSorter($this->ComponentName, "Sorter_escribania_nombre", $FileName, $this);
        $this->Sorter_escribania_direccion = new clsSorter($this->ComponentName, "Sorter_escribania_direccion", $FileName, $this);
        $this->Sorter_escribania_telefonos = new clsSorter($this->ComponentName, "Sorter_escribania_telefonos", $FileName, $this);
        $this->Sorter_escribania_horarios_atencion = new clsSorter($this->ComponentName, "Sorter_escribania_horarios_atencion", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Sorter1 = new clsSorter($this->ComponentName, "Sorter1", $FileName, $this);
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

//Show Method @6-428E0BF2
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
            $this->ControlsVisible["escribania_nombre"] = $this->escribania_nombre->Visible;
            $this->ControlsVisible["escribania_direccion"] = $this->escribania_direccion->Visible;
            $this->ControlsVisible["escribania_telefonos"] = $this->escribania_telefonos->Visible;
            $this->ControlsVisible["escribania_horarios_atencion"] = $this->escribania_horarios_atencion->Visible;
            $this->ControlsVisible["dpto_desc"] = $this->dpto_desc->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->escribania_nombre->SetValue($this->DataSource->escribania_nombre->GetValue());
                $this->escribania_nombre->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->escribania_nombre->Parameters = CCAddParam($this->escribania_nombre->Parameters, "escribania_id", $this->DataSource->f("escribania_id"));
                $this->escribania_direccion->SetValue($this->DataSource->escribania_direccion->GetValue());
                $this->escribania_telefonos->SetValue($this->DataSource->escribania_telefonos->GetValue());
                $this->escribania_horarios_atencion->SetValue($this->DataSource->escribania_horarios_atencion->GetValue());
                $this->dpto_desc->SetValue($this->DataSource->dpto_desc->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->escribania_nombre->Show();
                $this->escribania_direccion->Show();
                $this->escribania_telefonos->Show();
                $this->escribania_horarios_atencion->Show();
                $this->dpto_desc->Show();
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
        $this->Sorter_escribania_nombre->Show();
        $this->Sorter_escribania_direccion->Show();
        $this->Sorter_escribania_telefonos->Show();
        $this->Sorter_escribania_horarios_atencion->Show();
        $this->Navigator->Show();
        $this->Sorter1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @6-B41B0FE1
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->escribania_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->escribania_direccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->escribania_telefonos->Errors->ToString());
        $errors = ComposeStrings($errors, $this->escribania_horarios_atencion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->dpto_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End escribanias Class @6-FCB6E20C

class clsescribaniasDataSource extends clsDBtdf_nuevo {  //escribaniasDataSource Class @6-FA804BE6

//DataSource Variables @6-9902BE9C
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $escribania_nombre;
    public $escribania_direccion;
    public $escribania_telefonos;
    public $escribania_horarios_atencion;
    public $dpto_desc;
//End DataSource Variables

//DataSourceClass_Initialize Event @6-5E81C9A1
    function clsescribaniasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid escribanias";
        $this->Initialize();
        $this->escribania_nombre = new clsField("escribania_nombre", ccsText, "");
        
        $this->escribania_direccion = new clsField("escribania_direccion", ccsText, "");
        
        $this->escribania_telefonos = new clsField("escribania_telefonos", ccsText, "");
        
        $this->escribania_horarios_atencion = new clsField("escribania_horarios_atencion", ccsText, "");
        
        $this->dpto_desc = new clsField("dpto_desc", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @6-F4157751
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_escribania_nombre" => array("escribania_nombre", ""), 
            "Sorter_escribania_direccion" => array("escribania_direccion", ""), 
            "Sorter_escribania_telefonos" => array("escribania_telefonos", ""), 
            "Sorter_escribania_horarios_atencion" => array("escribania_horarios_atencion", ""), 
            "Sorter1" => array("dpto_desc", "")));
    }
//End SetOrder Method

//Prepare Method @6-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @6-C8A88E5A
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM escribanias LEFT JOIN departamentos ON\n\n" .
        "escribanias.dpto_id = departamentos.dpto_id";
        $this->SQL = "SELECT escribanias.*, dpto_desc \n\n" .
        "FROM escribanias LEFT JOIN departamentos ON\n\n" .
        "escribanias.dpto_id = departamentos.dpto_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @6-0F793F4E
    function SetValues()
    {
        $this->escribania_nombre->SetDBValue($this->f("escribania_nombre"));
        $this->escribania_direccion->SetDBValue($this->f("escribania_direccion"));
        $this->escribania_telefonos->SetDBValue($this->f("escribania_telefonos"));
        $this->escribania_horarios_atencion->SetDBValue($this->f("escribania_horarios_atencion"));
        $this->dpto_desc->SetDBValue($this->f("dpto_desc"));
    }
//End SetValues Method

} //End escribaniasDataSource Class @6-FCB6E20C

class clsRecordescribanias1 { //escribanias1 Class @23-2E3F93DB

//Variables @23-9E315808

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

//Class_Initialize Event @23-032F0260
    function clsRecordescribanias1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record escribanias1/Error";
        $this->DataSource = new clsescribanias1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "escribanias1";
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
            $this->escribania_nombre = new clsControl(ccsTextBox, "escribania_nombre", "Nombre de la Escribania", ccsText, "", CCGetRequestParam("escribania_nombre", $Method, NULL), $this);
            $this->escribania_nombre->Required = true;
            $this->escribania_direccion = new clsControl(ccsTextBox, "escribania_direccion", "Direccion", ccsText, "", CCGetRequestParam("escribania_direccion", $Method, NULL), $this);
            $this->escribania_direccion->Required = true;
            $this->escribania_telefonos = new clsControl(ccsTextBox, "escribania_telefonos", "Telefonos", ccsText, "", CCGetRequestParam("escribania_telefonos", $Method, NULL), $this);
            $this->escribania_telefonos->Required = true;
            $this->escribania_horarios_atencion = new clsControl(ccsTextBox, "escribania_horarios_atencion", "Horarios Atencion", ccsText, "", CCGetRequestParam("escribania_horarios_atencion", $Method, NULL), $this);
            $this->escribania_horarios_atencion->Required = true;
            $this->ListBox1 = new clsControl(ccsListBox, "ListBox1", "ListBox1", ccsText, "", CCGetRequestParam("ListBox1", $Method, NULL), $this);
            $this->ListBox1->DSType = dsTable;
            $this->ListBox1->DataSource = new clsDBtdf_nuevo();
            $this->ListBox1->ds = & $this->ListBox1->DataSource;
            $this->ListBox1->DataSource->SQL = "SELECT * \n" .
"FROM departamentos {SQL_Where} {SQL_OrderBy}";
            list($this->ListBox1->BoundColumn, $this->ListBox1->TextColumn, $this->ListBox1->DBFormat) = array("dpto_id", "dpto_desc", "");
            $this->escribanias_Insert = new clsControl(ccsLink, "escribanias_Insert", "escribanias_Insert", ccsText, "", CCGetRequestParam("escribanias_Insert", $Method, NULL), $this);
            $this->escribanias_Insert->Parameters = CCGetQueryString("QueryString", array("escribania_id", "ccsForm"));
            $this->escribanias_Insert->Page = "tc_escribania.php";
        }
    }
//End Class_Initialize Event

//Initialize Method @23-ABCA2743
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlescribania_id"] = CCGetFromGet("escribania_id", NULL);
    }
//End Initialize Method

//Validate Method @23-88D38733
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->escribania_nombre->Validate() && $Validation);
        $Validation = ($this->escribania_direccion->Validate() && $Validation);
        $Validation = ($this->escribania_telefonos->Validate() && $Validation);
        $Validation = ($this->escribania_horarios_atencion->Validate() && $Validation);
        $Validation = ($this->ListBox1->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->escribania_nombre->Errors->Count() == 0);
        $Validation =  $Validation && ($this->escribania_direccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->escribania_telefonos->Errors->Count() == 0);
        $Validation =  $Validation && ($this->escribania_horarios_atencion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ListBox1->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @23-F1CB2A41
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->escribania_nombre->Errors->Count());
        $errors = ($errors || $this->escribania_direccion->Errors->Count());
        $errors = ($errors || $this->escribania_telefonos->Errors->Count());
        $errors = ($errors || $this->escribania_horarios_atencion->Errors->Count());
        $errors = ($errors || $this->ListBox1->Errors->Count());
        $errors = ($errors || $this->escribanias_Insert->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @23-ED598703
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

//Operation Method @23-0BF2B389
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
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Cancel") {
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
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

//InsertRow Method @23-C216EEE5
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->escribania_nombre->SetValue($this->escribania_nombre->GetValue(true));
        $this->DataSource->escribania_direccion->SetValue($this->escribania_direccion->GetValue(true));
        $this->DataSource->escribania_telefonos->SetValue($this->escribania_telefonos->GetValue(true));
        $this->DataSource->escribania_horarios_atencion->SetValue($this->escribania_horarios_atencion->GetValue(true));
        $this->DataSource->ListBox1->SetValue($this->ListBox1->GetValue(true));
        $this->DataSource->escribanias_Insert->SetValue($this->escribanias_Insert->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @23-96CB73AB
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->escribania_nombre->SetValue($this->escribania_nombre->GetValue(true));
        $this->DataSource->escribania_direccion->SetValue($this->escribania_direccion->GetValue(true));
        $this->DataSource->escribania_telefonos->SetValue($this->escribania_telefonos->GetValue(true));
        $this->DataSource->escribania_horarios_atencion->SetValue($this->escribania_horarios_atencion->GetValue(true));
        $this->DataSource->ListBox1->SetValue($this->ListBox1->GetValue(true));
        $this->DataSource->escribanias_Insert->SetValue($this->escribanias_Insert->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @23-82EF65F5
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

        $this->ListBox1->Prepare();

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
                    $this->escribania_nombre->SetValue($this->DataSource->escribania_nombre->GetValue());
                    $this->escribania_direccion->SetValue($this->DataSource->escribania_direccion->GetValue());
                    $this->escribania_telefonos->SetValue($this->DataSource->escribania_telefonos->GetValue());
                    $this->escribania_horarios_atencion->SetValue($this->DataSource->escribania_horarios_atencion->GetValue());
                    $this->ListBox1->SetValue($this->DataSource->ListBox1->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->escribania_nombre->Errors->ToString());
            $Error = ComposeStrings($Error, $this->escribania_direccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->escribania_telefonos->Errors->ToString());
            $Error = ComposeStrings($Error, $this->escribania_horarios_atencion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ListBox1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->escribanias_Insert->Errors->ToString());
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
        $this->escribania_nombre->Show();
        $this->escribania_direccion->Show();
        $this->escribania_telefonos->Show();
        $this->escribania_horarios_atencion->Show();
        $this->ListBox1->Show();
        $this->escribanias_Insert->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End escribanias1 Class @23-FCB6E20C

class clsescribanias1DataSource extends clsDBtdf_nuevo {  //escribanias1DataSource Class @23-33C906B5

//DataSource Variables @23-64EA9D12
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
    public $escribania_nombre;
    public $escribania_direccion;
    public $escribania_telefonos;
    public $escribania_horarios_atencion;
    public $ListBox1;
    public $escribanias_Insert;
//End DataSource Variables

//DataSourceClass_Initialize Event @23-BFEA1FC1
    function clsescribanias1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record escribanias1/Error";
        $this->Initialize();
        $this->escribania_nombre = new clsField("escribania_nombre", ccsText, "");
        
        $this->escribania_direccion = new clsField("escribania_direccion", ccsText, "");
        
        $this->escribania_telefonos = new clsField("escribania_telefonos", ccsText, "");
        
        $this->escribania_horarios_atencion = new clsField("escribania_horarios_atencion", ccsText, "");
        
        $this->ListBox1 = new clsField("ListBox1", ccsText, "");
        
        $this->escribanias_Insert = new clsField("escribanias_Insert", ccsText, "");
        

        $this->InsertFields["escribania_nombre"] = array("Name" => "escribania_nombre", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["escribania_direccion"] = array("Name" => "escribania_direccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["escribania_telefonos"] = array("Name" => "escribania_telefonos", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["escribania_horarios_atencion"] = array("Name" => "escribania_horarios_atencion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["dpto_id"] = array("Name" => "dpto_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["escribania_nombre"] = array("Name" => "escribania_nombre", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["escribania_direccion"] = array("Name" => "escribania_direccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["escribania_telefonos"] = array("Name" => "escribania_telefonos", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["escribania_horarios_atencion"] = array("Name" => "escribania_horarios_atencion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["dpto_id"] = array("Name" => "dpto_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @23-7F810ECA
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlescribania_id", ccsInteger, "", "", $this->Parameters["urlescribania_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "escribania_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @23-FA621B9A
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM escribanias {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @23-DBF8D97C
    function SetValues()
    {
        $this->escribania_nombre->SetDBValue($this->f("escribania_nombre"));
        $this->escribania_direccion->SetDBValue($this->f("escribania_direccion"));
        $this->escribania_telefonos->SetDBValue($this->f("escribania_telefonos"));
        $this->escribania_horarios_atencion->SetDBValue($this->f("escribania_horarios_atencion"));
        $this->ListBox1->SetDBValue($this->f("dpto_id"));
    }
//End SetValues Method

//Insert Method @23-7F0E3AEB
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["escribania_nombre"]["Value"] = $this->escribania_nombre->GetDBValue(true);
        $this->InsertFields["escribania_direccion"]["Value"] = $this->escribania_direccion->GetDBValue(true);
        $this->InsertFields["escribania_telefonos"]["Value"] = $this->escribania_telefonos->GetDBValue(true);
        $this->InsertFields["escribania_horarios_atencion"]["Value"] = $this->escribania_horarios_atencion->GetDBValue(true);
        $this->InsertFields["dpto_id"]["Value"] = $this->ListBox1->GetDBValue(true);
        $this->SQL = CCBuildInsert("escribanias", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @23-D74BEBD4
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["escribania_nombre"]["Value"] = $this->escribania_nombre->GetDBValue(true);
        $this->UpdateFields["escribania_direccion"]["Value"] = $this->escribania_direccion->GetDBValue(true);
        $this->UpdateFields["escribania_telefonos"]["Value"] = $this->escribania_telefonos->GetDBValue(true);
        $this->UpdateFields["escribania_horarios_atencion"]["Value"] = $this->escribania_horarios_atencion->GetDBValue(true);
        $this->UpdateFields["dpto_id"]["Value"] = $this->ListBox1->GetDBValue(true);
        $this->SQL = CCBuildUpdate("escribanias", $this->UpdateFields, $this);
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

} //End escribanias1DataSource Class @23-FCB6E20C

//Initialize Page @1-776AB9B6
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
$TemplateFileName = "tc_escribania.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-C0765CA9
include_once("./tc_escribania_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-6FF0CEFF
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
$escribanias = new clsGridescribanias("", $MainPage);
$escribanias1 = new clsRecordescribanias1("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->escribanias = & $escribanias;
$MainPage->escribanias1 = & $escribanias1;
$escribanias->Initialize();
$escribanias1->Initialize();

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

//Execute Components @1-2DE2DB3A
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
$escribanias1->Operation();
//End Execute Components

//Go to destination page @1-8B8D234C
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
    unset($escribanias);
    unset($escribanias1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-FB0FADA6
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$escribanias->Show();
$escribanias1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$STJRE8D9F3R = explode("|", "<center><font fac|e=\"Arial\"><smal|l>Ge&#110;e&#1|14;&#97;t&#101;&|#100; <!-- CCS -->|&#119;ith <!-- SC|C -->C&#111;d&|#101;&#67;ha&#|114;&#103;&#101; <|!-- CCS -->&#83;t|ud&#105;&#111;.</|small></font></cen|ter>");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($STJRE8D9F3R,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($STJRE8D9F3R,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($STJRE8D9F3R,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-786140A1
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($escribanias);
unset($escribanias1);
unset($Tpl);
//End Unload Page


?>
