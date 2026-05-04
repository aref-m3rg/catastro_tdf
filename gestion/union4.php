<?php
//Include Common Files @1-BBFE0F3D
define("RelativePath", "..");
define("PathToCurrentPage", "/gestion/");
define("FileName", "union4.php");
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

class clsGridparcelas { //parcelas class @10-C47EAFDB

//Variables @10-10C8FD28

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
    public $Sorter_parcela_partida;
    public $Sorter_parcela_nomenclatura;
//End Variables

//Class_Initialize Event @10-B6DD8710
    function clsGridparcelas($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "parcelas";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid parcelas";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsparcelasDataSource($this);
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
        $this->SorterName = CCGetParam("parcelasOrder", "");
        $this->SorterDirection = CCGetParam("parcelasDir", "");

        $this->parcela_partida = new clsControl(ccsLabel, "parcela_partida", "parcela_partida", ccsInteger, "", CCGetRequestParam("parcela_partida", ccsGet, NULL), $this);
        $this->parcela_nomenclatura = new clsControl(ccsLabel, "parcela_nomenclatura", "parcela_nomenclatura", ccsText, "", CCGetRequestParam("parcela_nomenclatura", ccsGet, NULL), $this);
        $this->Link1 = new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $this);
        $this->Link1->Page = "union4.php";
        $this->Sorter_parcela_partida = new clsSorter($this->ComponentName, "Sorter_parcela_partida", $FileName, $this);
        $this->Sorter_parcela_nomenclatura = new clsSorter($this->ComponentName, "Sorter_parcela_nomenclatura", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @10-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @10-E4E23950
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_parcela_partida"] = CCGetFromGet("s_parcela_partida", NULL);

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
            $this->ControlsVisible["parcela_partida"] = $this->parcela_partida->Visible;
            $this->ControlsVisible["parcela_nomenclatura"] = $this->parcela_nomenclatura->Visible;
            $this->ControlsVisible["Link1"] = $this->Link1->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
                $this->parcela_nomenclatura->SetValue($this->DataSource->parcela_nomenclatura->GetValue());
                $this->Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "parcela_id_a", $this->DataSource->f("parcela_id"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->parcela_partida->Show();
                $this->parcela_nomenclatura->Show();
                $this->Link1->Show();
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
        $this->Sorter_parcela_partida->Show();
        $this->Sorter_parcela_nomenclatura->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @10-FEDF2306
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->parcela_partida->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_nomenclatura->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End parcelas Class @10-FCB6E20C

class clsparcelasDataSource extends clsDBtdf_nuevo {  //parcelasDataSource Class @10-DA23B507

//DataSource Variables @10-39371997
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $parcela_partida;
    public $parcela_nomenclatura;
//End DataSource Variables

//DataSourceClass_Initialize Event @10-F4020F21
    function clsparcelasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid parcelas";
        $this->Initialize();
        $this->parcela_partida = new clsField("parcela_partida", ccsInteger, "");
        
        $this->parcela_nomenclatura = new clsField("parcela_nomenclatura", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @10-6F6EDCD9
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_parcela_partida" => array("parcela_partida", ""), 
            "Sorter_parcela_nomenclatura" => array("parcela_nomenclatura", "")));
    }
//End SetOrder Method

//Prepare Method @10-38B3DCBB
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_parcela_partida", ccsInteger, "", "", $this->Parameters["urls_parcela_partida"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "parcela_partida", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @10-6E2C0151
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM parcelas";
        $this->SQL = "SELECT * \n\n" .
        "FROM parcelas {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @10-DBE407AE
    function SetValues()
    {
        $this->parcela_partida->SetDBValue(trim($this->f("parcela_partida")));
        $this->parcela_nomenclatura->SetDBValue($this->f("parcela_nomenclatura"));
    }
//End SetValues Method

} //End parcelasDataSource Class @10-FCB6E20C

class clsRecordparcelasSearch { //parcelasSearch Class @11-CBAE5345

//Variables @11-9E315808

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

//Class_Initialize Event @11-4F18AFB6
    function clsRecordparcelasSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record parcelasSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "parcelasSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_parcela_partida = new clsControl(ccsTextBox, "s_parcela_partida", "s_parcela_partida", ccsInteger, "", CCGetRequestParam("s_parcela_partida", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @11-157AE69C
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_parcela_partida->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_parcela_partida->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @11-219B33AC
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_parcela_partida->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @11-ED598703
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

//Operation Method @11-6948C301
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
            }
        }
        $Redirect = "union4.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "union4.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @11-3C1DA7B8
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
            $Error = ComposeStrings($Error, $this->s_parcela_partida->Errors->ToString());
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
        $this->s_parcela_partida->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End parcelasSearch Class @11-FCB6E20C

class clsGridparcelas_tmp { //parcelas_tmp class @22-577B9E36

//Variables @22-10C8FD28

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
    public $Sorter_parcela_partida;
    public $Sorter_parcela_nomenclatura;
//End Variables

//Class_Initialize Event @22-2944D0FA
    function clsGridparcelas_tmp($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "parcelas_tmp";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid parcelas_tmp";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsparcelas_tmpDataSource($this);
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
        $this->SorterName = CCGetParam("parcelas_tmpOrder", "");
        $this->SorterDirection = CCGetParam("parcelas_tmpDir", "");

        $this->parcela_partida = new clsControl(ccsLabel, "parcela_partida", "parcela_partida", ccsInteger, "", CCGetRequestParam("parcela_partida", ccsGet, NULL), $this);
        $this->parcela_nomenclatura = new clsControl(ccsLabel, "parcela_nomenclatura", "parcela_nomenclatura", ccsText, "", CCGetRequestParam("parcela_nomenclatura", ccsGet, NULL), $this);
        $this->Sorter_parcela_partida = new clsSorter($this->ComponentName, "Sorter_parcela_partida", $FileName, $this);
        $this->Sorter_parcela_nomenclatura = new clsSorter($this->ComponentName, "Sorter_parcela_nomenclatura", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @22-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @22-FCE9313F
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
            $this->ControlsVisible["parcela_partida"] = $this->parcela_partida->Visible;
            $this->ControlsVisible["parcela_nomenclatura"] = $this->parcela_nomenclatura->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
                $this->parcela_nomenclatura->SetValue($this->DataSource->parcela_nomenclatura->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->parcela_partida->Show();
                $this->parcela_nomenclatura->Show();
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
        $this->Sorter_parcela_partida->Show();
        $this->Sorter_parcela_nomenclatura->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @22-DD146A06
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->parcela_partida->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_nomenclatura->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End parcelas_tmp Class @22-FCB6E20C

class clsparcelas_tmpDataSource extends clsDBtdf_nuevo {  //parcelas_tmpDataSource Class @22-1AB92E1D

//DataSource Variables @22-39371997
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $parcela_partida;
    public $parcela_nomenclatura;
//End DataSource Variables

//DataSourceClass_Initialize Event @22-387DDBA5
    function clsparcelas_tmpDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid parcelas_tmp";
        $this->Initialize();
        $this->parcela_partida = new clsField("parcela_partida", ccsInteger, "");
        
        $this->parcela_nomenclatura = new clsField("parcela_nomenclatura", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @22-6F6EDCD9
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_parcela_partida" => array("parcela_partida", ""), 
            "Sorter_parcela_nomenclatura" => array("parcela_nomenclatura", "")));
    }
//End SetOrder Method

//Prepare Method @22-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @22-8A19A27B
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM tmp INNER JOIN parcelas ON\n\n" .
        "tmp.tmp_parcela_id = parcelas.parcela_id";
        $this->SQL = "SELECT * \n\n" .
        "FROM tmp INNER JOIN parcelas ON\n\n" .
        "tmp.tmp_parcela_id = parcelas.parcela_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @22-DBE407AE
    function SetValues()
    {
        $this->parcela_partida->SetDBValue(trim($this->f("parcela_partida")));
        $this->parcela_nomenclatura->SetDBValue($this->f("parcela_nomenclatura"));
    }
//End SetValues Method

} //End parcelas_tmpDataSource Class @22-FCB6E20C

//Initialize Page @1-17228206
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
$TemplateFileName = "union4.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-24C85B44
include_once("./union4_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-4E2E11FB
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
$Panel1 = new clsPanel("Panel1", $MainPage);
$Buscar = new clsPanel("Buscar", $MainPage);
$parcelas = new clsGridparcelas("", $MainPage);
$parcelasSearch = new clsRecordparcelasSearch("", $MainPage);
$ver = new clsPanel("ver", $MainPage);
$parcelas_tmp = new clsGridparcelas_tmp("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->Panel1 = & $Panel1;
$MainPage->Buscar = & $Buscar;
$MainPage->parcelas = & $parcelas;
$MainPage->parcelasSearch = & $parcelasSearch;
$MainPage->ver = & $ver;
$MainPage->parcelas_tmp = & $parcelas_tmp;
$Panel1->AddComponent("Buscar", $Buscar);
$Panel1->AddComponent("ver", $ver);
$Buscar->AddComponent("parcelas", $parcelas);
$Buscar->AddComponent("parcelasSearch", $parcelasSearch);
$ver->AddComponent("parcelas_tmp", $parcelas_tmp);
$parcelas->Initialize();
$parcelas_tmp->Initialize();

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

//Execute Components @1-82DAD84E
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
$parcelasSearch->Operation();
//End Execute Components

//Go to destination page @1-9C655147
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
    unset($parcelas);
    unset($parcelasSearch);
    unset($parcelas_tmp);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-486E8B73
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$Panel1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", strrev(">retnec/<>tnof/<>llams/<.;111#&id;711#&tS>-- SCC --!< eg;411#&;79#&hC;101#&doC>-- SCC --!< ht;501#&;911#&>-- SCC --!< d;101#&;611#&ar;101#&;011#&e;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", strrev(">retnec/<>tnof/<>llams/<.;111#&id;711#&tS>-- SCC --!< eg;411#&;79#&hC;101#&doC>-- SCC --!< ht;501#&;911#&>-- SCC --!< d;101#&;611#&ar;101#&;011#&e;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= strrev(">retnec/<>tnof/<>llams/<.;111#&id;711#&tS>-- SCC --!< eg;411#&;79#&hC;101#&doC>-- SCC --!< ht;501#&;911#&>-- SCC --!< d;101#&;611#&ar;101#&;011#&e;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-07E19D48
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($parcelas);
unset($parcelasSearch);
unset($parcelas_tmp);
unset($Tpl);
//End Unload Page


?>
