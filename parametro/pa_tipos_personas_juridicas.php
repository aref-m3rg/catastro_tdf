<?php
//Include Common Files @1-59ED2195
define("RelativePath", "..");
define("PathToCurrentPage", "/parametro/");
define("FileName", "pa_tipos_personas_juridicas.php");
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

class clsGridtipos_personas_juridicas { //tipos_personas_juridicas class @5-E4E492AD

//Variables @5-64DECBB2

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
    public $Sorter_tipo_perso_jur_descrip;
    public $Sorter_tipo_perso_jur_abrev;
    public $Sorter_tipo_estado_id;
//End Variables

//Class_Initialize Event @5-8E52D391
    function clsGridtipos_personas_juridicas($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "tipos_personas_juridicas";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid tipos_personas_juridicas";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clstipos_personas_juridicasDataSource($this);
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
        $this->SorterName = CCGetParam("tipos_personas_juridicasOrder", "");
        $this->SorterDirection = CCGetParam("tipos_personas_juridicasDir", "");

        $this->tipo_perso_jur_descrip = new clsControl(ccsLink, "tipo_perso_jur_descrip", "tipo_perso_jur_descrip", ccsText, "", CCGetRequestParam("tipo_perso_jur_descrip", ccsGet, NULL), $this);
        $this->tipo_perso_jur_descrip->Page = "pa_tipos_personas_juridicas.php";
        $this->tipo_perso_jur_abrev = new clsControl(ccsLabel, "tipo_perso_jur_abrev", "tipo_perso_jur_abrev", ccsText, "", CCGetRequestParam("tipo_perso_jur_abrev", ccsGet, NULL), $this);
        $this->tipo_estado_descrip = new clsControl(ccsLabel, "tipo_estado_descrip", "tipo_estado_descrip", ccsText, "", CCGetRequestParam("tipo_estado_descrip", ccsGet, NULL), $this);
        $this->Sorter_tipo_perso_jur_descrip = new clsSorter($this->ComponentName, "Sorter_tipo_perso_jur_descrip", $FileName, $this);
        $this->Sorter_tipo_perso_jur_abrev = new clsSorter($this->ComponentName, "Sorter_tipo_perso_jur_abrev", $FileName, $this);
        $this->Sorter_tipo_estado_id = new clsSorter($this->ComponentName, "Sorter_tipo_estado_id", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
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

//Show Method @5-00BB56F2
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
            $this->ControlsVisible["tipo_perso_jur_descrip"] = $this->tipo_perso_jur_descrip->Visible;
            $this->ControlsVisible["tipo_perso_jur_abrev"] = $this->tipo_perso_jur_abrev->Visible;
            $this->ControlsVisible["tipo_estado_descrip"] = $this->tipo_estado_descrip->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->tipo_perso_jur_descrip->SetValue($this->DataSource->tipo_perso_jur_descrip->GetValue());
                $this->tipo_perso_jur_descrip->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->tipo_perso_jur_descrip->Parameters = CCAddParam($this->tipo_perso_jur_descrip->Parameters, "tipo_perso_jur_id", $this->DataSource->f("tipo_perso_jur_id"));
                $this->tipo_perso_jur_abrev->SetValue($this->DataSource->tipo_perso_jur_abrev->GetValue());
                $this->tipo_estado_descrip->SetValue($this->DataSource->tipo_estado_descrip->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->tipo_perso_jur_descrip->Show();
                $this->tipo_perso_jur_abrev->Show();
                $this->tipo_estado_descrip->Show();
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
        $this->Sorter_tipo_perso_jur_descrip->Show();
        $this->Sorter_tipo_perso_jur_abrev->Show();
        $this->Sorter_tipo_estado_id->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @5-BF94EF43
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->tipo_perso_jur_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_perso_jur_abrev->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_estado_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End tipos_personas_juridicas Class @5-FCB6E20C

class clstipos_personas_juridicasDataSource extends clsDBtdf_nuevo {  //tipos_personas_juridicasDataSource Class @5-6D97ACFC

//DataSource Variables @5-A604D44C
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $tipo_perso_jur_descrip;
    public $tipo_perso_jur_abrev;
    public $tipo_estado_descrip;
//End DataSource Variables

//DataSourceClass_Initialize Event @5-27B60AB0
    function clstipos_personas_juridicasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid tipos_personas_juridicas";
        $this->Initialize();
        $this->tipo_perso_jur_descrip = new clsField("tipo_perso_jur_descrip", ccsText, "");
        
        $this->tipo_perso_jur_abrev = new clsField("tipo_perso_jur_abrev", ccsText, "");
        
        $this->tipo_estado_descrip = new clsField("tipo_estado_descrip", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @5-80448855
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_tipo_perso_jur_descrip" => array("tipo_perso_jur_descrip", ""), 
            "Sorter_tipo_perso_jur_abrev" => array("tipo_perso_jur_abrev", ""), 
            "Sorter_tipo_estado_id" => array("tipo_estado_id", "")));
    }
//End SetOrder Method

//Prepare Method @5-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @5-6B5FC923
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM tipos_personas_juridicas LEFT JOIN tipos_estados ON\n\n" .
        "tipos_personas_juridicas.tipo_estado_id = tipos_estados.tipo_estado_id";
        $this->SQL = "SELECT tipo_perso_jur_id, tipo_perso_jur_descrip, tipo_perso_jur_abrev, tipos_personas_juridicas.tipo_estado_id AS tipos_personas_juridicas_tipo_estado_id,\n\n" .
        "tipo_estado_descrip \n\n" .
        "FROM tipos_personas_juridicas LEFT JOIN tipos_estados ON\n\n" .
        "tipos_personas_juridicas.tipo_estado_id = tipos_estados.tipo_estado_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @5-645C3B2E
    function SetValues()
    {
        $this->tipo_perso_jur_descrip->SetDBValue($this->f("tipo_perso_jur_descrip"));
        $this->tipo_perso_jur_abrev->SetDBValue($this->f("tipo_perso_jur_abrev"));
        $this->tipo_estado_descrip->SetDBValue($this->f("tipo_estado_descrip"));
    }
//End SetValues Method

} //End tipos_personas_juridicasDataSource Class @5-FCB6E20C

class clsRecordtipos_personas_juridicas1 { //tipos_personas_juridicas1 Class @19-5E75CA6E

//Variables @19-9E315808

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

//Class_Initialize Event @19-224C5BFB
    function clsRecordtipos_personas_juridicas1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record tipos_personas_juridicas1/Error";
        $this->DataSource = new clstipos_personas_juridicas1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "tipos_personas_juridicas1";
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
            $this->tipo_perso_jur_descrip = new clsControl(ccsTextBox, "tipo_perso_jur_descrip", "Descripcion", ccsText, "", CCGetRequestParam("tipo_perso_jur_descrip", $Method, NULL), $this);
            $this->tipo_perso_jur_descrip->Required = true;
            $this->tipo_perso_jur_abrev = new clsControl(ccsTextBox, "tipo_perso_jur_abrev", "Abreviacion", ccsText, "", CCGetRequestParam("tipo_perso_jur_abrev", $Method, NULL), $this);
            $this->tipo_perso_jur_abrev->Required = true;
            $this->tipo_estado_id = new clsControl(ccsListBox, "tipo_estado_id", "Estado", ccsInteger, "", CCGetRequestParam("tipo_estado_id", $Method, NULL), $this);
            $this->tipo_estado_id->DSType = dsTable;
            $this->tipo_estado_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_estado_id->ds = & $this->tipo_estado_id->DataSource;
            $this->tipo_estado_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_estados {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_estado_id->BoundColumn, $this->tipo_estado_id->TextColumn, $this->tipo_estado_id->DBFormat) = array("tipo_estado_id", "tipo_estado_descrip", "");
            $this->tipo_estado_id->Required = true;
            $this->tipos_personas_juridicas_Insert = new clsControl(ccsLink, "tipos_personas_juridicas_Insert", "tipos_personas_juridicas_Insert", ccsText, "", CCGetRequestParam("tipos_personas_juridicas_Insert", $Method, NULL), $this);
            $this->tipos_personas_juridicas_Insert->Parameters = CCGetQueryString("QueryString", array("tipo_perso_jur_id", "ccsForm"));
            $this->tipos_personas_juridicas_Insert->Page = "pa_tipos_personas_juridicas.php";
            if(!$this->FormSubmitted) {
                if(!is_array($this->tipo_estado_id->Value) && !strlen($this->tipo_estado_id->Value) && $this->tipo_estado_id->Value !== false)
                    $this->tipo_estado_id->SetText(1);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @19-938FFD6D
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urltipo_perso_jur_id"] = CCGetFromGet("tipo_perso_jur_id", NULL);
    }
//End Initialize Method

//Validate Method @19-66840981
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->tipo_perso_jur_descrip->Validate() && $Validation);
        $Validation = ($this->tipo_perso_jur_abrev->Validate() && $Validation);
        $Validation = ($this->tipo_estado_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->tipo_perso_jur_descrip->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_perso_jur_abrev->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_estado_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @19-B72A3966
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->tipo_perso_jur_descrip->Errors->Count());
        $errors = ($errors || $this->tipo_perso_jur_abrev->Errors->Count());
        $errors = ($errors || $this->tipo_estado_id->Errors->Count());
        $errors = ($errors || $this->tipos_personas_juridicas_Insert->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @19-ED598703
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

//Operation Method @19-E955BD63
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
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->Validate()) {
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

//InsertRow Method @19-3D70A093
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->tipo_perso_jur_descrip->SetValue($this->tipo_perso_jur_descrip->GetValue(true));
        $this->DataSource->tipo_perso_jur_abrev->SetValue($this->tipo_perso_jur_abrev->GetValue(true));
        $this->DataSource->tipo_estado_id->SetValue($this->tipo_estado_id->GetValue(true));
        $this->DataSource->tipos_personas_juridicas_Insert->SetValue($this->tipos_personas_juridicas_Insert->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @19-5C553DEF
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->tipo_perso_jur_descrip->SetValue($this->tipo_perso_jur_descrip->GetValue(true));
        $this->DataSource->tipo_perso_jur_abrev->SetValue($this->tipo_perso_jur_abrev->GetValue(true));
        $this->DataSource->tipo_estado_id->SetValue($this->tipo_estado_id->GetValue(true));
        $this->DataSource->tipos_personas_juridicas_Insert->SetValue($this->tipos_personas_juridicas_Insert->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @19-0341EDE8
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

        $this->tipo_estado_id->Prepare();

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
                    $this->tipo_perso_jur_descrip->SetValue($this->DataSource->tipo_perso_jur_descrip->GetValue());
                    $this->tipo_perso_jur_abrev->SetValue($this->DataSource->tipo_perso_jur_abrev->GetValue());
                    $this->tipo_estado_id->SetValue($this->DataSource->tipo_estado_id->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->tipo_perso_jur_descrip->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_perso_jur_abrev->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_estado_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipos_personas_juridicas_Insert->Errors->ToString());
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
        $this->tipo_perso_jur_descrip->Show();
        $this->tipo_perso_jur_abrev->Show();
        $this->tipo_estado_id->Show();
        $this->tipos_personas_juridicas_Insert->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End tipos_personas_juridicas1 Class @19-FCB6E20C

class clstipos_personas_juridicas1DataSource extends clsDBtdf_nuevo {  //tipos_personas_juridicas1DataSource Class @19-CE3CE828

//DataSource Variables @19-F4CF32A1
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
    public $tipo_perso_jur_descrip;
    public $tipo_perso_jur_abrev;
    public $tipo_estado_id;
    public $tipos_personas_juridicas_Insert;
//End DataSource Variables

//DataSourceClass_Initialize Event @19-A540F75F
    function clstipos_personas_juridicas1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record tipos_personas_juridicas1/Error";
        $this->Initialize();
        $this->tipo_perso_jur_descrip = new clsField("tipo_perso_jur_descrip", ccsText, "");
        
        $this->tipo_perso_jur_abrev = new clsField("tipo_perso_jur_abrev", ccsText, "");
        
        $this->tipo_estado_id = new clsField("tipo_estado_id", ccsInteger, "");
        
        $this->tipos_personas_juridicas_Insert = new clsField("tipos_personas_juridicas_Insert", ccsText, "");
        

        $this->InsertFields["tipo_perso_jur_descrip"] = array("Name" => "tipo_perso_jur_descrip", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_perso_jur_abrev"] = array("Name" => "tipo_perso_jur_abrev", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_estado_id"] = array("Name" => "tipo_estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_perso_jur_descrip"] = array("Name" => "tipo_perso_jur_descrip", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_perso_jur_abrev"] = array("Name" => "tipo_perso_jur_abrev", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_estado_id"] = array("Name" => "tipo_estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @19-2F36A365
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urltipo_perso_jur_id", ccsInteger, "", "", $this->Parameters["urltipo_perso_jur_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "tipo_perso_jur_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @19-18B33D4D
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM tipos_personas_juridicas {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @19-194D8D46
    function SetValues()
    {
        $this->tipo_perso_jur_descrip->SetDBValue($this->f("tipo_perso_jur_descrip"));
        $this->tipo_perso_jur_abrev->SetDBValue($this->f("tipo_perso_jur_abrev"));
        $this->tipo_estado_id->SetDBValue(trim($this->f("tipo_estado_id")));
    }
//End SetValues Method

//Insert Method @19-92D07378
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["tipo_perso_jur_descrip"]["Value"] = $this->tipo_perso_jur_descrip->GetDBValue(true);
        $this->InsertFields["tipo_perso_jur_abrev"]["Value"] = $this->tipo_perso_jur_abrev->GetDBValue(true);
        $this->InsertFields["tipo_estado_id"]["Value"] = $this->tipo_estado_id->GetDBValue(true);
        $this->SQL = CCBuildInsert("tipos_personas_juridicas", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @19-238A066F
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["tipo_perso_jur_descrip"]["Value"] = $this->tipo_perso_jur_descrip->GetDBValue(true);
        $this->UpdateFields["tipo_perso_jur_abrev"]["Value"] = $this->tipo_perso_jur_abrev->GetDBValue(true);
        $this->UpdateFields["tipo_estado_id"]["Value"] = $this->tipo_estado_id->GetDBValue(true);
        $this->SQL = CCBuildUpdate("tipos_personas_juridicas", $this->UpdateFields, $this);
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

} //End tipos_personas_juridicas1DataSource Class @19-FCB6E20C

//Initialize Page @1-1CD1864A
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
$TemplateFileName = "pa_tipos_personas_juridicas.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-D04208CA
include_once("./pa_tipos_personas_juridicas_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-87D09567
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
$tipos_personas_juridicas = new clsGridtipos_personas_juridicas("", $MainPage);
$tipos_personas_juridicas1 = new clsRecordtipos_personas_juridicas1("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tipos_personas_juridicas = & $tipos_personas_juridicas;
$MainPage->tipos_personas_juridicas1 = & $tipos_personas_juridicas1;
$tipos_personas_juridicas->Initialize();
$tipos_personas_juridicas1->Initialize();

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

//Execute Components @1-A86C07B3
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
$tipos_personas_juridicas1->Operation();
//End Execute Components

//Go to destination page @1-B7CFB8FE
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
    unset($tipos_personas_juridicas);
    unset($tipos_personas_juridicas1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-5A97C8F7
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$tipos_personas_juridicas->Show();
$tipos_personas_juridicas1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font face=\"Arial\"><small>&#71;&#101;&#1" . "10;erate&#100; <!-- CCS -->w&#105;&#116;&#104;" . " <!-- SCC -->C&#111;&#100;&#101;&#67;h&#97;&#1" . "14;ge <!-- SCC -->&#83;&#116;ud&#105;o.</small><" . "/font></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font face=\"Arial\"><small>&#71;&#101;&#1" . "10;erate&#100; <!-- CCS -->w&#105;&#116;&#104;" . " <!-- SCC -->C&#111;&#100;&#101;&#67;h&#97;&#1" . "14;ge <!-- SCC -->&#83;&#116;ud&#105;o.</small><" . "/font></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font face=\"Arial\"><small>&#71;&#101;&#1" . "10;erate&#100; <!-- CCS -->w&#105;&#116;&#104;" . " <!-- SCC -->C&#111;&#100;&#101;&#67;h&#97;&#1" . "14;ge <!-- SCC -->&#83;&#116;ud&#105;o.</small><" . "/font></center>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-8B534805
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($tipos_personas_juridicas);
unset($tipos_personas_juridicas1);
unset($Tpl);
//End Unload Page


?>
