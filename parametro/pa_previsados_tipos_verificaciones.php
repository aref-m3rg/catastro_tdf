<?php
//Include Common Files @1-57B47528
define("RelativePath", "..");
define("PathToCurrentPage", "/parametro/");
define("FileName", "pa_previsados_tipos_verificaciones.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @2-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @4-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

class clsGridprevisados_tipos_verifica { //previsados_tipos_verifica class @5-A0B6D4DF

//Variables @5-7FFAB6B5

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
    public $Sorter_previsado_tipo_verif_orden;
    public $Sorter_previsado_tipo_verif_descrip;
//End Variables

//Class_Initialize Event @5-FA1C6634
    function clsGridprevisados_tipos_verifica($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "previsados_tipos_verifica";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid previsados_tipos_verifica";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsprevisados_tipos_verificaDataSource($this);
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
        $this->SorterName = CCGetParam("previsados_tipos_verificaOrder", "");
        $this->SorterDirection = CCGetParam("previsados_tipos_verificaDir", "");

        $this->previsado_tipo_verif_orden = new clsControl(ccsLink, "previsado_tipo_verif_orden", "previsado_tipo_verif_orden", ccsInteger, "", CCGetRequestParam("previsado_tipo_verif_orden", ccsGet, NULL), $this);
        $this->previsado_tipo_verif_orden->Page = "pa_previsados_tipos_verificaciones.php";
        $this->previsado_tipo_verif_descrip = new clsControl(ccsLabel, "previsado_tipo_verif_descrip", "previsado_tipo_verif_descrip", ccsText, "", CCGetRequestParam("previsado_tipo_verif_descrip", ccsGet, NULL), $this);
        $this->tipo_estado_html = new clsControl(ccsLabel, "tipo_estado_html", "tipo_estado_html", ccsText, "", CCGetRequestParam("tipo_estado_html", ccsGet, NULL), $this);
        $this->tipo_estado_html->HTML = true;
        $this->Sorter_previsado_tipo_verif_orden = new clsSorter($this->ComponentName, "Sorter_previsado_tipo_verif_orden", $FileName, $this);
        $this->Sorter_previsado_tipo_verif_descrip = new clsSorter($this->ComponentName, "Sorter_previsado_tipo_verif_descrip", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->previsados_tipos_verifica_Insert = new clsControl(ccsLink, "previsados_tipos_verifica_Insert", "previsados_tipos_verifica_Insert", ccsText, "", CCGetRequestParam("previsados_tipos_verifica_Insert", ccsGet, NULL), $this);
        $this->previsados_tipos_verifica_Insert->Parameters = CCGetQueryString("QueryString", array("previsado_tipo_verif_id", "ccsForm"));
        $this->previsados_tipos_verifica_Insert->Page = "pa_previsados_tipos_verificaciones.php";
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

//Show Method @5-90902947
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
            $this->ControlsVisible["previsado_tipo_verif_orden"] = $this->previsado_tipo_verif_orden->Visible;
            $this->ControlsVisible["previsado_tipo_verif_descrip"] = $this->previsado_tipo_verif_descrip->Visible;
            $this->ControlsVisible["tipo_estado_html"] = $this->tipo_estado_html->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->previsado_tipo_verif_orden->SetValue($this->DataSource->previsado_tipo_verif_orden->GetValue());
                $this->previsado_tipo_verif_orden->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->previsado_tipo_verif_orden->Parameters = CCAddParam($this->previsado_tipo_verif_orden->Parameters, "previsado_tipo_verif_id", $this->DataSource->f("previsado_tipo_verif_id"));
                $this->previsado_tipo_verif_descrip->SetValue($this->DataSource->previsado_tipo_verif_descrip->GetValue());
                $this->tipo_estado_html->SetValue($this->DataSource->tipo_estado_html->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->previsado_tipo_verif_orden->Show();
                $this->previsado_tipo_verif_descrip->Show();
                $this->tipo_estado_html->Show();
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
        $this->Sorter_previsado_tipo_verif_orden->Show();
        $this->Sorter_previsado_tipo_verif_descrip->Show();
        $this->Navigator->Show();
        $this->previsados_tipos_verifica_Insert->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @5-4C35014B
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->previsado_tipo_verif_orden->Errors->ToString());
        $errors = ComposeStrings($errors, $this->previsado_tipo_verif_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_estado_html->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End previsados_tipos_verifica Class @5-FCB6E20C

class clsprevisados_tipos_verificaDataSource extends clsDBtdf_nuevo {  //previsados_tipos_verificaDataSource Class @5-A3155B19

//DataSource Variables @5-C35E3FD5
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $previsado_tipo_verif_orden;
    public $previsado_tipo_verif_descrip;
    public $tipo_estado_html;
//End DataSource Variables

//DataSourceClass_Initialize Event @5-9E6D038B
    function clsprevisados_tipos_verificaDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid previsados_tipos_verifica";
        $this->Initialize();
        $this->previsado_tipo_verif_orden = new clsField("previsado_tipo_verif_orden", ccsInteger, "");
        
        $this->previsado_tipo_verif_descrip = new clsField("previsado_tipo_verif_descrip", ccsText, "");
        
        $this->tipo_estado_html = new clsField("tipo_estado_html", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @5-A8C3DD7B
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_previsado_tipo_verif_orden" => array("previsado_tipo_verif_orden", ""), 
            "Sorter_previsado_tipo_verif_descrip" => array("previsado_tipo_verif_descrip", "")));
    }
//End SetOrder Method

//Prepare Method @5-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @5-571564EB
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM previsados_tipos_verificaciones INNER JOIN tipos_estados ON\n\n" .
        "previsados_tipos_verificaciones.tipo_estado_id = tipos_estados.tipo_estado_id";
        $this->SQL = "SELECT previsados_tipos_verificaciones.*, tipo_estado_descrip, tipo_estado_html \n\n" .
        "FROM previsados_tipos_verificaciones INNER JOIN tipos_estados ON\n\n" .
        "previsados_tipos_verificaciones.tipo_estado_id = tipos_estados.tipo_estado_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @5-C314E877
    function SetValues()
    {
        $this->previsado_tipo_verif_orden->SetDBValue(trim($this->f("previsado_tipo_verif_orden")));
        $this->previsado_tipo_verif_descrip->SetDBValue($this->f("previsado_tipo_verif_descrip"));
        $this->tipo_estado_html->SetDBValue($this->f("tipo_estado_html"));
    }
//End SetValues Method

} //End previsados_tipos_verificaDataSource Class @5-FCB6E20C

class clsRecordprevisados_tipos_verifica1 { //previsados_tipos_verifica1 Class @16-846E21C3

//Variables @16-9E315808

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

//Class_Initialize Event @16-EB3CC0B5
    function clsRecordprevisados_tipos_verifica1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record previsados_tipos_verifica1/Error";
        $this->DataSource = new clsprevisados_tipos_verifica1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "previsados_tipos_verifica1";
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
            $this->previsado_tipo_verif_orden = new clsControl(ccsTextBox, "previsado_tipo_verif_orden", "Previsado Tipo Verif Orden", ccsInteger, "", CCGetRequestParam("previsado_tipo_verif_orden", $Method, NULL), $this);
            $this->previsado_tipo_verif_descrip = new clsControl(ccsTextBox, "previsado_tipo_verif_descrip", "Previsado Tipo Verif Descrip", ccsText, "", CCGetRequestParam("previsado_tipo_verif_descrip", $Method, NULL), $this);
            $this->tipo_estado_id = new clsControl(ccsListBox, "tipo_estado_id", "Estado", ccsInteger, "", CCGetRequestParam("tipo_estado_id", $Method, NULL), $this);
            $this->tipo_estado_id->DSType = dsTable;
            $this->tipo_estado_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_estado_id->ds = & $this->tipo_estado_id->DataSource;
            $this->tipo_estado_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_estados {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_estado_id->BoundColumn, $this->tipo_estado_id->TextColumn, $this->tipo_estado_id->DBFormat) = array("tipo_estado_id", "tipo_estado_descrip", "");
            $this->tipo_estado_id->DataSource->Parameters["expr35"] = 3;
            $this->tipo_estado_id->DataSource->wp = new clsSQLParameters();
            $this->tipo_estado_id->DataSource->wp->AddParameter("1", "expr35", ccsInteger, "", "", $this->tipo_estado_id->DataSource->Parameters["expr35"], "", false);
            $this->tipo_estado_id->DataSource->wp->Criterion[1] = $this->tipo_estado_id->DataSource->wp->Operation(opNotEqual, "tipo_estado_id", $this->tipo_estado_id->DataSource->wp->GetDBValue("1"), $this->tipo_estado_id->DataSource->ToSQL($this->tipo_estado_id->DataSource->wp->GetDBValue("1"), ccsInteger),false);
            $this->tipo_estado_id->DataSource->Where = 
                 $this->tipo_estado_id->DataSource->wp->Criterion[1];
            $this->Button1 = new clsButton("Button1", $Method, $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @16-7552A53C
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlprevisado_tipo_verif_id"] = CCGetFromGet("previsado_tipo_verif_id", NULL);
    }
//End Initialize Method

//Validate Method @16-4EFBE6AC
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->previsado_tipo_verif_orden->Validate() && $Validation);
        $Validation = ($this->previsado_tipo_verif_descrip->Validate() && $Validation);
        $Validation = ($this->tipo_estado_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->previsado_tipo_verif_orden->Errors->Count() == 0);
        $Validation =  $Validation && ($this->previsado_tipo_verif_descrip->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_estado_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @16-C3E8B7AE
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->previsado_tipo_verif_orden->Errors->Count());
        $errors = ($errors || $this->previsado_tipo_verif_descrip->Errors->Count());
        $errors = ($errors || $this->tipo_estado_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @16-ED598703
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

//Operation Method @16-8785961B
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
            } else if($this->Button1->Pressed) {
                $this->PressedButton = "Button1";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button1") {
            $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "previsado_tipo_verif_id"));
            if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
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

//InsertRow Method @16-6B0E3156
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->previsado_tipo_verif_orden->SetValue($this->previsado_tipo_verif_orden->GetValue(true));
        $this->DataSource->previsado_tipo_verif_descrip->SetValue($this->previsado_tipo_verif_descrip->GetValue(true));
        $this->DataSource->tipo_estado_id->SetValue($this->tipo_estado_id->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @16-261C4A74
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->previsado_tipo_verif_orden->SetValue($this->previsado_tipo_verif_orden->GetValue(true));
        $this->DataSource->previsado_tipo_verif_descrip->SetValue($this->previsado_tipo_verif_descrip->GetValue(true));
        $this->DataSource->tipo_estado_id->SetValue($this->tipo_estado_id->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @16-CBF9E23C
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
                    $this->previsado_tipo_verif_orden->SetValue($this->DataSource->previsado_tipo_verif_orden->GetValue());
                    $this->previsado_tipo_verif_descrip->SetValue($this->DataSource->previsado_tipo_verif_descrip->GetValue());
                    $this->tipo_estado_id->SetValue($this->DataSource->tipo_estado_id->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->previsado_tipo_verif_orden->Errors->ToString());
            $Error = ComposeStrings($Error, $this->previsado_tipo_verif_descrip->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_estado_id->Errors->ToString());
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
        $this->previsado_tipo_verif_orden->Show();
        $this->previsado_tipo_verif_descrip->Show();
        $this->tipo_estado_id->Show();
        $this->Button1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End previsados_tipos_verifica1 Class @16-FCB6E20C

class clsprevisados_tipos_verifica1DataSource extends clsDBtdf_nuevo {  //previsados_tipos_verifica1DataSource Class @16-1E927C28

//DataSource Variables @16-3BD073AD
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
    public $previsado_tipo_verif_orden;
    public $previsado_tipo_verif_descrip;
    public $tipo_estado_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @16-FA392D41
    function clsprevisados_tipos_verifica1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record previsados_tipos_verifica1/Error";
        $this->Initialize();
        $this->previsado_tipo_verif_orden = new clsField("previsado_tipo_verif_orden", ccsInteger, "");
        
        $this->previsado_tipo_verif_descrip = new clsField("previsado_tipo_verif_descrip", ccsText, "");
        
        $this->tipo_estado_id = new clsField("tipo_estado_id", ccsInteger, "");
        

        $this->InsertFields["previsado_tipo_verif_orden"] = array("Name" => "previsado_tipo_verif_orden", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["previsado_tipo_verif_descrip"] = array("Name" => "previsado_tipo_verif_descrip", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_estado_id"] = array("Name" => "tipo_estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["previsado_tipo_verif_orden"] = array("Name" => "previsado_tipo_verif_orden", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["previsado_tipo_verif_descrip"] = array("Name" => "previsado_tipo_verif_descrip", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_estado_id"] = array("Name" => "tipo_estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @16-0B0EA86A
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlprevisado_tipo_verif_id", ccsInteger, "", "", $this->Parameters["urlprevisado_tipo_verif_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "previsado_tipo_verif_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @16-399D237D
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM previsados_tipos_verificaciones {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @16-8E983560
    function SetValues()
    {
        $this->previsado_tipo_verif_orden->SetDBValue(trim($this->f("previsado_tipo_verif_orden")));
        $this->previsado_tipo_verif_descrip->SetDBValue($this->f("previsado_tipo_verif_descrip"));
        $this->tipo_estado_id->SetDBValue(trim($this->f("tipo_estado_id")));
    }
//End SetValues Method

//Insert Method @16-E92A08AC
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["previsado_tipo_verif_orden"]["Value"] = $this->previsado_tipo_verif_orden->GetDBValue(true);
        $this->InsertFields["previsado_tipo_verif_descrip"]["Value"] = $this->previsado_tipo_verif_descrip->GetDBValue(true);
        $this->InsertFields["tipo_estado_id"]["Value"] = $this->tipo_estado_id->GetDBValue(true);
        $this->SQL = CCBuildInsert("previsados_tipos_verificaciones", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @16-A29A204F
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["previsado_tipo_verif_orden"]["Value"] = $this->previsado_tipo_verif_orden->GetDBValue(true);
        $this->UpdateFields["previsado_tipo_verif_descrip"]["Value"] = $this->previsado_tipo_verif_descrip->GetDBValue(true);
        $this->UpdateFields["tipo_estado_id"]["Value"] = $this->tipo_estado_id->GetDBValue(true);
        $this->SQL = CCBuildUpdate("previsados_tipos_verificaciones", $this->UpdateFields, $this);
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

} //End previsados_tipos_verifica1DataSource Class @16-FCB6E20C

class clsMenuMenu1 extends clsMenu { //Menu1 class @22-FEAC4CDE

//Class_Initialize Event @22-5DB84325
    function clsMenuMenu1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "Menu1";
        $this->Visible = True;
        $this->controls = array();
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->ErrorBlock = "Menu Menu1";

        $this->StaticItems = array();
        $this->StaticItems[] = array("item_id" => "MenuItem1", "item_id_parent" => null, "item_caption" => "Previsado", "item_url" => array("Page" => "", "Parameters" => null), "item_target" => "", "item_title" => "");
        $this->StaticItems[] = array("item_id" => "MenuItem2", "item_id_parent" => null, "item_caption" => "Administracion", "item_url" => array("Page" => "", "Parameters" => null), "item_target" => "", "item_title" => "");
        $this->StaticItems[] = array("item_id" => "MenuItem2Item1", "item_id_parent" => "MenuItem2", "item_caption" => "Tipos de plano", "item_url" => array("Page" => "pa_previsados_tipos_planos.php", "Parameters" => null), "item_target" => "", "item_title" => "");
        $this->StaticItems[] = array("item_id" => "MenuItem2Item2", "item_id_parent" => "MenuItem2", "item_caption" => "Verificacion plano", "item_url" => array("Page" => "pa_previsados_tipos_verificaciones.php", "Parameters" => null), "item_target" => "", "item_title" => "");
        $this->StaticItems[] = array("item_id" => "MenuItem2Item4", "item_id_parent" => "MenuItem2", "item_caption" => "Documentacion", "item_url" => array("Page" => "pa_previsados_tipos_planos_requisitos.php", "Parameters" => null), "item_target" => "", "item_title" => "");

        $this->DataSource = new clsMenu1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->DataSource->SetProvider(array("DBLib" => "Array"));

        parent::clsMenu("item_id_parent", "item_id", null);

        $this->ItemLink = new clsControl(ccsLink, "ItemLink", "ItemLink", ccsText, "", CCGetRequestParam("ItemLink", ccsGet, NULL), $this);
        $this->controls["ItemLink"] = & $this->ItemLink;
        $this->ItemLink->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->ItemLink->Page = "";
        $this->LinkStartParameters = $this->ItemLink->Parameters;
    }
//End Class_Initialize Event

//SetControlValues Method @22-B7BF812B
    function SetControlValues() {
        $this->ItemLink->SetValue($this->DataSource->ItemLink->GetValue());
        $LinkUrl = $this->DataSource->f("item_url");
        $this->ItemLink->Page = $LinkUrl["Page"];
        $this->ItemLink->Parameters = $this->SetParamsFromDB($this->LinkStartParameters, $LinkUrl["Parameters"]);
    }
//End SetControlValues Method

//ShowAttributes @22-17684C76
    function ShowAttributes() {
        $this->Attributes->SetValue("MenuType", "menu_htb");
        $this->Attributes->Show();
    }
//End ShowAttributes

} //End Menu1 Class @22-FCB6E20C

//Menu1DataSource Class @22-201CC8D7
class clsMenu1DataSource extends DB_Adapter {
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;
    var $wp;
    var $Record = array();
    var $Index;
    var $FieldsList = array();

    function clsMenu1DataSource($parent) {
        $this->Parent = & $parent;
        $this->ErrorBlock = "Menu Menu1";
        $this->ItemLink = new clsField("ItemLink", ccsText, "");
        $this->FieldsList["ItemLink"] = & $this->ItemLink;
    }

    function Prepare()
    {
    }

    function Open()
    {
        $this->query($this->Parent->StaticItems);
    }

    function SetValues()
    {
        $this->ItemLink->SetDBValue($this->f("item_caption"));
    }
}
//End Menu1DataSource Class

//Initialize Page @1-1285EF12
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
$TemplateFileName = "pa_previsados_tipos_verificaciones.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-A4540CD3
include_once("./pa_previsados_tipos_verificaciones_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-CFF99FAE
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$previsados_tipos_verifica = new clsGridprevisados_tipos_verifica("", $MainPage);
$previsados_tipos_verifica1 = new clsRecordprevisados_tipos_verifica1("", $MainPage);
$Menu1 = new clsMenuMenu1("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->previsados_tipos_verifica = & $previsados_tipos_verifica;
$MainPage->previsados_tipos_verifica1 = & $previsados_tipos_verifica1;
$MainPage->Menu1 = & $Menu1;
$previsados_tipos_verifica->Initialize();
$previsados_tipos_verifica1->Initialize();

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

//Execute Components @1-D1CDA070
$tdf_header->Operations();
$tdf_footer->Operations();
$previsados_tipos_verifica1->Operation();
//End Execute Components

//Go to destination page @1-946E73B6
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($previsados_tipos_verifica);
    unset($previsados_tipos_verifica1);
    unset($Menu1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-80EFFB04
$tdf_header->Show();
$tdf_footer->Show();
$previsados_tipos_verifica->Show();
$previsados_tipos_verifica1->Show();
$Menu1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$BRAETKAB1Q2A8F7C7G = explode("|", "<center><font face=\"Ari|al\"><small>G&#101;ne&|#114;at&#101;d <!-- |CCS -->&#119;i&#116;&#1|04; <!-- SCC -->C&|#111;d&#101;&#67;&|#104;arge <!-- SCC |-->&#83;tud&#105;&#1|11;.</small></font>|</center>");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($BRAETKAB1Q2A8F7C7G,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($BRAETKAB1Q2A8F7C7G,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($BRAETKAB1Q2A8F7C7G,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-28EB9A05
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($previsados_tipos_verifica);
unset($previsados_tipos_verifica1);
unset($Menu1);
unset($Tpl);
//End Unload Page


?>
