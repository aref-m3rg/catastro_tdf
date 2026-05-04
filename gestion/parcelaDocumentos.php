<?php
//Include Common Files @1-5DE89A74
define("RelativePath", "..");
define("PathToCurrentPage", "/gestion/");
define("FileName", "parcelaDocumentos.php");
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

class clsRecordparcelas_documentos { //parcelas_documentos Class @6-86B68EDC

//Variables @6-9E315808

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

//Class_Initialize Event @6-00B97F7A
    function clsRecordparcelas_documentos($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record parcelas_documentos/Error";
        $this->DataSource = new clsparcelas_documentosDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "parcelas_documentos";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "multipart/form-data";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->parcela_document_descrip = new clsControl(ccsTextBox, "parcela_document_descrip", "Parcela Document Descrip", ccsText, "", CCGetRequestParam("parcela_document_descrip", $Method, NULL), $this);
            $this->parcela_document_descrip->Required = true;
            $this->tipo_doc_id = new clsControl(ccsListBox, "tipo_doc_id", "Tipo Doc Id", ccsInteger, "", CCGetRequestParam("tipo_doc_id", $Method, NULL), $this);
            $this->tipo_doc_id->DSType = dsTable;
            $this->tipo_doc_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_doc_id->ds = & $this->tipo_doc_id->DataSource;
            $this->tipo_doc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_documentacion {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_doc_id->BoundColumn, $this->tipo_doc_id->TextColumn, $this->tipo_doc_id->DBFormat) = array("tipo_doc_id", "tipo_doc_descrip", "");
            $this->tipo_doc_id->Required = true;
            $this->FileUpload1 = new clsFileUpload("FileUpload1", "Archivo", "../tmp/", "parceladocs/", "*", "", 3145728, $this);
            $this->FileUpload1->Required = true;
            $this->parcela_id = new clsControl(ccsHidden, "parcela_id", "parcela_id", ccsText, "", CCGetRequestParam("parcela_id", $Method, NULL), $this);
            $this->parcela_document_f_proc = new clsControl(ccsHidden, "parcela_document_f_proc", "parcela_document_f_proc", ccsText, "", CCGetRequestParam("parcela_document_f_proc", $Method, NULL), $this);
            $this->ButtonLimpia = new clsButton("ButtonLimpia", $Method, $this);
            $this->Button_Search = new clsButton("Button_Search", $Method, $this);
            $this->Button_Delete = new clsButton("Button_Delete", $Method, $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @6-B6E577AF
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlparcela_document_id"] = CCGetFromGet("parcela_document_id", NULL);
    }
//End Initialize Method

//Validate Method @6-0ADE1784
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->parcela_document_descrip->Validate() && $Validation);
        $Validation = ($this->tipo_doc_id->Validate() && $Validation);
        $Validation = ($this->FileUpload1->Validate() && $Validation);
        $Validation = ($this->parcela_id->Validate() && $Validation);
        $Validation = ($this->parcela_document_f_proc->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->parcela_document_descrip->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_doc_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->FileUpload1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_document_f_proc->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @6-C5FE9A1C
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->parcela_document_descrip->Errors->Count());
        $errors = ($errors || $this->tipo_doc_id->Errors->Count());
        $errors = ($errors || $this->FileUpload1->Errors->Count());
        $errors = ($errors || $this->parcela_id->Errors->Count());
        $errors = ($errors || $this->parcela_document_f_proc->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @6-ED598703
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

//Operation Method @6-B75F909E
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

        $this->FileUpload1->Upload();

        if($this->FormSubmitted) {
            $this->PressedButton = $this->EditMode ? "Button_Update" : "Button_Insert";
            if($this->Button_Insert->Pressed) {
                $this->PressedButton = "Button_Insert";
            } else if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            } else if($this->ButtonLimpia->Pressed) {
                $this->PressedButton = "ButtonLimpia";
            } else if($this->Button_Search->Pressed) {
                $this->PressedButton = "Button_Search";
            } else if($this->Button_Delete->Pressed) {
                $this->PressedButton = "Button_Delete";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "ButtonLimpia") {
            $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "parcela_document_id"));
            if(!CCGetEvent($this->ButtonLimpia->CCSEvents, "OnClick", $this->ButtonLimpia)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_Search") {
            $Redirect = "recordParcela.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_Insert", "Button_Insert_x", "Button_Insert_y", "Button_Update", "Button_Update_x", "Button_Update_y", "ButtonLimpia", "ButtonLimpia_x", "ButtonLimpia_y", "Button_Search", "Button_Search_x", "Button_Search_y", "Button_Delete", "Button_Delete_x", "Button_Delete_y", "parcela_document_descrip", "tipo_doc_id", "FileUpload1", "parcela_document_f_proc")), CCGetQueryString("QueryString", array("parcela_document_descrip", "tipo_doc_id", "FileUpload1", "parcela_id", "parcela_document_f_proc", "ccsForm", "parcela_document_descrip", "tipo_doc_id", "FileUpload1", "parcela_document_f_proc")));
            if(!CCGetEvent($this->Button_Search->CCSEvents, "OnClick", $this->Button_Search)) {
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
            } else if($this->PressedButton == "Button_Delete") {
                $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "parcela_document_id"));
                if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete) || !$this->DeleteRow()) {
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

//InsertRow Method @6-D817BF8A
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->parcela_document_descrip->SetValue($this->parcela_document_descrip->GetValue(true));
        $this->DataSource->tipo_doc_id->SetValue($this->tipo_doc_id->GetValue(true));
        $this->DataSource->FileUpload1->SetValue($this->FileUpload1->GetValue(true));
        $this->DataSource->parcela_id->SetValue($this->parcela_id->GetValue(true));
        $this->DataSource->parcela_document_f_proc->SetValue($this->parcela_document_f_proc->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        if($this->DataSource->Errors->Count() == 0) {
            $this->FileUpload1->Move();
        }
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @6-CE38C25A
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->parcela_document_descrip->SetValue($this->parcela_document_descrip->GetValue(true));
        $this->DataSource->tipo_doc_id->SetValue($this->tipo_doc_id->GetValue(true));
        $this->DataSource->FileUpload1->SetValue($this->FileUpload1->GetValue(true));
        $this->DataSource->parcela_id->SetValue($this->parcela_id->GetValue(true));
        $this->DataSource->parcela_document_f_proc->SetValue($this->parcela_document_f_proc->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        if($this->DataSource->Errors->Count() == 0) {
            $this->FileUpload1->Move();
        }
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @6-2B077D44
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        if($this->DataSource->Errors->Count() == 0) {
            $this->FileUpload1->Delete();
        }
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @6-2075EAFE
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

        $this->tipo_doc_id->Prepare();

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
                    $this->parcela_document_descrip->SetValue($this->DataSource->parcela_document_descrip->GetValue());
                    $this->tipo_doc_id->SetValue($this->DataSource->tipo_doc_id->GetValue());
                    $this->FileUpload1->SetValue($this->DataSource->FileUpload1->GetValue());
                    $this->parcela_id->SetValue($this->DataSource->parcela_id->GetValue());
                    $this->parcela_document_f_proc->SetValue($this->DataSource->parcela_document_f_proc->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->parcela_document_descrip->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_doc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->FileUpload1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_document_f_proc->Errors->ToString());
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
        $this->Button_Delete->Visible = $this->EditMode && $this->DeleteAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->parcela_document_descrip->Show();
        $this->tipo_doc_id->Show();
        $this->FileUpload1->Show();
        $this->parcela_id->Show();
        $this->parcela_document_f_proc->Show();
        $this->ButtonLimpia->Show();
        $this->Button_Search->Show();
        $this->Button_Delete->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End parcelas_documentos Class @6-FCB6E20C

class clsparcelas_documentosDataSource extends clsDBtdf_nuevo {  //parcelas_documentosDataSource Class @6-598F320F

//DataSource Variables @6-BDEEF23B
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $DeleteParameters;
    public $wp;
    public $AllParametersSet;

    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $parcela_document_descrip;
    public $tipo_doc_id;
    public $FileUpload1;
    public $parcela_id;
    public $parcela_document_f_proc;
//End DataSource Variables

//DataSourceClass_Initialize Event @6-F19472C7
    function clsparcelas_documentosDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record parcelas_documentos/Error";
        $this->Initialize();
        $this->parcela_document_descrip = new clsField("parcela_document_descrip", ccsText, "");
        
        $this->tipo_doc_id = new clsField("tipo_doc_id", ccsInteger, "");
        
        $this->FileUpload1 = new clsField("FileUpload1", ccsText, "");
        
        $this->parcela_id = new clsField("parcela_id", ccsText, "");
        
        $this->parcela_document_f_proc = new clsField("parcela_document_f_proc", ccsText, "");
        

        $this->InsertFields["parcela_document_descrip"] = array("Name" => "parcela_document_descrip", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_doc_id"] = array("Name" => "tipo_doc_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_document_archivo"] = array("Name" => "parcela_document_archivo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_id"] = array("Name" => "parcela_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_document_f_proc"] = array("Name" => "parcela_document_f_proc", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_document_descrip"] = array("Name" => "parcela_document_descrip", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_doc_id"] = array("Name" => "tipo_doc_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_document_archivo"] = array("Name" => "parcela_document_archivo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_id"] = array("Name" => "parcela_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_document_f_proc"] = array("Name" => "parcela_document_f_proc", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @6-960643EC
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlparcela_document_id", ccsInteger, "", "", $this->Parameters["urlparcela_document_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "parcela_document_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @6-27FA0C47
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM parcelas_documentos {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @6-D408161E
    function SetValues()
    {
        $this->parcela_document_descrip->SetDBValue($this->f("parcela_document_descrip"));
        $this->tipo_doc_id->SetDBValue(trim($this->f("tipo_doc_id")));
        $this->FileUpload1->SetDBValue($this->f("parcela_document_archivo"));
        $this->parcela_id->SetDBValue($this->f("parcela_id"));
        $this->parcela_document_f_proc->SetDBValue($this->f("parcela_document_f_proc"));
    }
//End SetValues Method

//Insert Method @6-DF4F948C
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["parcela_document_descrip"]["Value"] = $this->parcela_document_descrip->GetDBValue(true);
        $this->InsertFields["tipo_doc_id"]["Value"] = $this->tipo_doc_id->GetDBValue(true);
        $this->InsertFields["parcela_document_archivo"]["Value"] = $this->FileUpload1->GetDBValue(true);
        $this->InsertFields["parcela_id"]["Value"] = $this->parcela_id->GetDBValue(true);
        $this->InsertFields["parcela_document_f_proc"]["Value"] = $this->parcela_document_f_proc->GetDBValue(true);
        $this->SQL = CCBuildInsert("parcelas_documentos", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @6-3C473D3C
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["parcela_document_descrip"]["Value"] = $this->parcela_document_descrip->GetDBValue(true);
        $this->UpdateFields["tipo_doc_id"]["Value"] = $this->tipo_doc_id->GetDBValue(true);
        $this->UpdateFields["parcela_document_archivo"]["Value"] = $this->FileUpload1->GetDBValue(true);
        $this->UpdateFields["parcela_id"]["Value"] = $this->parcela_id->GetDBValue(true);
        $this->UpdateFields["parcela_document_f_proc"]["Value"] = $this->parcela_document_f_proc->GetDBValue(true);
        $this->SQL = CCBuildUpdate("parcelas_documentos", $this->UpdateFields, $this);
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

//Delete Method @6-53CF89DA
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM parcelas_documentos";
        $this->SQL = CCBuildSQL($this->SQL, $this->Where, "");
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete", $this->Parent);
        }
    }
//End Delete Method

} //End parcelas_documentosDataSource Class @6-FCB6E20C

class clsGridparcelas_documentos1 { //parcelas_documentos1 class @17-BA3AB338

//Variables @17-276DFA59

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
    public $Sorter_parcela_document_f_proc;
    public $Sorter_parcela_document_descrip;
    public $Sorter_tipo_doc_id;
    public $Sorter_parcela_document_archivo;
//End Variables

//Class_Initialize Event @17-3197097A
    function clsGridparcelas_documentos1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "parcelas_documentos1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid parcelas_documentos1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsparcelas_documentos1DataSource($this);
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
        $this->SorterName = CCGetParam("parcelas_documentos1Order", "");
        $this->SorterDirection = CCGetParam("parcelas_documentos1Dir", "");

        $this->parcela_document_f_proc = new clsControl(ccsLink, "parcela_document_f_proc", "parcela_document_f_proc", ccsDate, array("GeneralDate"), CCGetRequestParam("parcela_document_f_proc", ccsGet, NULL), $this);
        $this->parcela_document_f_proc->Page = "";
        $this->parcela_document_descrip = new clsControl(ccsLabel, "parcela_document_descrip", "parcela_document_descrip", ccsText, "", CCGetRequestParam("parcela_document_descrip", ccsGet, NULL), $this);
        $this->tipo_doc_descrip = new clsControl(ccsLabel, "tipo_doc_descrip", "tipo_doc_descrip", ccsText, "", CCGetRequestParam("tipo_doc_descrip", ccsGet, NULL), $this);
        $this->parcela_document_archivo = new clsControl(ccsLabel, "parcela_document_archivo", "parcela_document_archivo", ccsText, "", CCGetRequestParam("parcela_document_archivo", ccsGet, NULL), $this);
        $this->parcela_document_archivo->HTML = true;
        $this->tamano = new clsControl(ccsLabel, "tamano", "tamano", ccsText, "", CCGetRequestParam("tamano", ccsGet, NULL), $this);
        $this->Sorter_parcela_document_f_proc = new clsSorter($this->ComponentName, "Sorter_parcela_document_f_proc", $FileName, $this);
        $this->Sorter_parcela_document_descrip = new clsSorter($this->ComponentName, "Sorter_parcela_document_descrip", $FileName, $this);
        $this->Sorter_tipo_doc_id = new clsSorter($this->ComponentName, "Sorter_tipo_doc_id", $FileName, $this);
        $this->Sorter_parcela_document_archivo = new clsSorter($this->ComponentName, "Sorter_parcela_document_archivo", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @17-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @17-9E755C29
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
            $this->ControlsVisible["parcela_document_f_proc"] = $this->parcela_document_f_proc->Visible;
            $this->ControlsVisible["parcela_document_descrip"] = $this->parcela_document_descrip->Visible;
            $this->ControlsVisible["tipo_doc_descrip"] = $this->tipo_doc_descrip->Visible;
            $this->ControlsVisible["parcela_document_archivo"] = $this->parcela_document_archivo->Visible;
            $this->ControlsVisible["tamano"] = $this->tamano->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->parcela_document_f_proc->SetValue($this->DataSource->parcela_document_f_proc->GetValue());
                $this->parcela_document_f_proc->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->parcela_document_f_proc->Parameters = CCAddParam($this->parcela_document_f_proc->Parameters, "parcela_document_id", $this->DataSource->f("parcela_document_id"));
                $this->parcela_document_descrip->SetValue($this->DataSource->parcela_document_descrip->GetValue());
                $this->tipo_doc_descrip->SetValue($this->DataSource->tipo_doc_descrip->GetValue());
                $this->parcela_document_archivo->SetValue($this->DataSource->parcela_document_archivo->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->parcela_document_f_proc->Show();
                $this->parcela_document_descrip->Show();
                $this->tipo_doc_descrip->Show();
                $this->parcela_document_archivo->Show();
                $this->tamano->Show();
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
        $this->Sorter_parcela_document_f_proc->Show();
        $this->Sorter_parcela_document_descrip->Show();
        $this->Sorter_tipo_doc_id->Show();
        $this->Sorter_parcela_document_archivo->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @17-36A4B792
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->parcela_document_f_proc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_document_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_doc_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_document_archivo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tamano->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End parcelas_documentos1 Class @17-FCB6E20C

class clsparcelas_documentos1DataSource extends clsDBtdf_nuevo {  //parcelas_documentos1DataSource Class @17-EABC5310

//DataSource Variables @17-83FD327D
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $parcela_document_f_proc;
    public $parcela_document_descrip;
    public $tipo_doc_descrip;
    public $parcela_document_archivo;
//End DataSource Variables

//DataSourceClass_Initialize Event @17-649681B5
    function clsparcelas_documentos1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid parcelas_documentos1";
        $this->Initialize();
        $this->parcela_document_f_proc = new clsField("parcela_document_f_proc", ccsDate, $this->DateFormat);
        
        $this->parcela_document_descrip = new clsField("parcela_document_descrip", ccsText, "");
        
        $this->tipo_doc_descrip = new clsField("tipo_doc_descrip", ccsText, "");
        
        $this->parcela_document_archivo = new clsField("parcela_document_archivo", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @17-B6914AC9
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "parcelas_documentos.parcela_document_f_proc desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_parcela_document_f_proc" => array("parcela_document_f_proc", ""), 
            "Sorter_parcela_document_descrip" => array("parcela_document_descrip", ""), 
            "Sorter_tipo_doc_id" => array("tipo_doc_id", ""), 
            "Sorter_parcela_document_archivo" => array("parcela_document_archivo", "")));
    }
//End SetOrder Method

//Prepare Method @17-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @17-B576FB52
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM parcelas_documentos LEFT JOIN tipos_documentacion ON\n\n" .
        "parcelas_documentos.tipo_doc_id = tipos_documentacion.tipo_doc_id {SQL_Where} {SQL_OrderBy}";
        $this->SQL = "SELECT parcelas_documentos.*, tipo_doc_descrip \n\n" .
        "FROM parcelas_documentos LEFT JOIN tipos_documentacion ON\n\n" .
        "parcelas_documentos.tipo_doc_id = tipos_documentacion.tipo_doc_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @17-8CB3B1A3
    function SetValues()
    {
        $this->parcela_document_f_proc->SetDBValue(trim($this->f("parcela_document_f_proc")));
        $this->parcela_document_descrip->SetDBValue($this->f("parcela_document_descrip"));
        $this->tipo_doc_descrip->SetDBValue($this->f("tipo_doc_descrip"));
        $this->parcela_document_archivo->SetDBValue($this->f("parcela_document_archivo"));
    }
//End SetValues Method

} //End parcelas_documentos1DataSource Class @17-FCB6E20C

//Initialize Page @1-C471C1B5
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
$TemplateFileName = "parcelaDocumentos.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-F58A7057
include_once("./parcelaDocumentos_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-D0F32EB5
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../../01_administracion/", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("../../01_administracion/", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$tdf_menu = new clstdf_menu("../../01_administracion/", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$parcelas_documentos = new clsRecordparcelas_documentos("", $MainPage);
$parcelas_documentos1 = new clsGridparcelas_documentos1("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->parcelas_documentos = & $parcelas_documentos;
$MainPage->parcelas_documentos1 = & $parcelas_documentos1;
$parcelas_documentos->Initialize();
$parcelas_documentos1->Initialize();

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

//Execute Components @1-0EC1F30F
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
$parcelas_documentos->Operation();
//End Execute Components

//Go to destination page @1-4BEE8A1B
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
    unset($parcelas_documentos);
    unset($parcelas_documentos1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-DEA9525A
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$parcelas_documentos->Show();
$parcelas_documentos1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$DDDC6M4A1F3P = array("<center><font face=\"Ar","ial\"><small>&#71;en","er&#97;&#116;ed <!--"," CCS -->&#119;i&#","116;h <!-- CCS -->Code","&#67;ha&#114;g&#101;"," <!-- CCS -->&#83;tudi","o.</small></font></ce","nter>");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($DDDC6M4A1F3P,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($DDDC6M4A1F3P,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($DDDC6M4A1F3P,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-CCDACFA2
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($parcelas_documentos);
unset($parcelas_documentos1);
unset($Tpl);
//End Unload Page


?>
