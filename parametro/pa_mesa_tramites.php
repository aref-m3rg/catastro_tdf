<?php
//Include Common Files @1-B6096FF3
define("RelativePath", "..");
define("PathToCurrentPage", "/parametro/");
define("FileName", "pa_mesa_tramites.php");
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

class clsRecordtipos_tramites { //tipos_tramites Class @6-93A875EA

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

//Class_Initialize Event @6-1DBB7480
    function clsRecordtipos_tramites($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record tipos_tramites/Error";
        $this->DataSource = new clstipos_tramitesDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "tipos_tramites";
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
            $this->tramite_id = new clsControl(ccsListBox, "tramite_id", "Tramite Id", ccsInteger, "", CCGetRequestParam("tramite_id", $Method, NULL), $this);
            $this->tramite_id->DSType = dsTable;
            $this->tramite_id->DataSource = new clsDBmesa();
            $this->tramite_id->ds = & $this->tramite_id->DataSource;
            $this->tramite_id->DataSource->SQL = "SELECT * \n" .
"FROM tramites {SQL_Where} {SQL_OrderBy}";
            list($this->tramite_id->BoundColumn, $this->tramite_id->TextColumn, $this->tramite_id->DBFormat) = array("tramite_id", "tramite_desc", "");
            $this->tramite_id->Required = true;
            $this->tipo_tramites_descript = new clsControl(ccsTextBox, "tipo_tramites_descript", "Tipo Tramites Descript", ccsText, "", CCGetRequestParam("tipo_tramites_descript", $Method, NULL), $this);
            $this->tipo_tramites_descript->Required = true;
            $this->ButtonCancel = new clsButton("ButtonCancel", $Method, $this);
            $this->ButtonBuscar = new clsButton("ButtonBuscar", $Method, $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @6-CAFF09AD
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urltipo_tramites_id"] = CCGetFromGet("tipo_tramites_id", NULL);
    }
//End Initialize Method

//Validate Method @6-EFDD7514
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->tramite_id->Validate() && $Validation);
        $Validation = ($this->tipo_tramites_descript->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->tramite_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_tramites_descript->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @6-522E3E00
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->tramite_id->Errors->Count());
        $errors = ($errors || $this->tipo_tramites_descript->Errors->Count());
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

//Operation Method @6-0EAF0D93
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
            } else if($this->ButtonCancel->Pressed) {
                $this->PressedButton = "ButtonCancel";
            } else if($this->ButtonBuscar->Pressed) {
                $this->PressedButton = "ButtonBuscar";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "ButtonCancel") {
            $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "tipo_tramites_id", "tramite_id"));
            if(!CCGetEvent($this->ButtonCancel->CCSEvents, "OnClick", $this->ButtonCancel)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "ButtonBuscar") {
            if(!CCGetEvent($this->ButtonBuscar->CCSEvents, "OnClick", $this->ButtonBuscar)) {
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

//InsertRow Method @6-DB52E353
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->tramite_id->SetValue($this->tramite_id->GetValue(true));
        $this->DataSource->tipo_tramites_descript->SetValue($this->tipo_tramites_descript->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @6-C9B20E73
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->tramite_id->SetValue($this->tramite_id->GetValue(true));
        $this->DataSource->tipo_tramites_descript->SetValue($this->tipo_tramites_descript->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @6-C5AB4157
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

        $this->tramite_id->Prepare();

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
                    $this->tramite_id->SetValue($this->DataSource->tramite_id->GetValue());
                    $this->tipo_tramites_descript->SetValue($this->DataSource->tipo_tramites_descript->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->tramite_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_tramites_descript->Errors->ToString());
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
        $this->tramite_id->Show();
        $this->tipo_tramites_descript->Show();
        $this->ButtonCancel->Show();
        $this->ButtonBuscar->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End tipos_tramites Class @6-FCB6E20C

class clstipos_tramitesDataSource extends clsDBmesa {  //tipos_tramitesDataSource Class @6-5AE9E904

//DataSource Variables @6-9B5E5405
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
    public $tramite_id;
    public $tipo_tramites_descript;
//End DataSource Variables

//DataSourceClass_Initialize Event @6-88F8E595
    function clstipos_tramitesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record tipos_tramites/Error";
        $this->Initialize();
        $this->tramite_id = new clsField("tramite_id", ccsInteger, "");
        
        $this->tipo_tramites_descript = new clsField("tipo_tramites_descript", ccsText, "");
        

        $this->InsertFields["tramite_id"] = array("Name" => "tramite_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_tramites_descript"] = array("Name" => "tipo_tramites_descript", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tramite_id"] = array("Name" => "tramite_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_tramites_descript"] = array("Name" => "tipo_tramites_descript", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @6-EEB827BF
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urltipo_tramites_id", ccsInteger, "", "", $this->Parameters["urltipo_tramites_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "tipo_tramites_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @6-38017D44
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM tipos_tramites {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @6-D0BFA04A
    function SetValues()
    {
        $this->tramite_id->SetDBValue(trim($this->f("tramite_id")));
        $this->tipo_tramites_descript->SetDBValue($this->f("tipo_tramites_descript"));
    }
//End SetValues Method

//Insert Method @6-2E413B8A
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["tramite_id"]["Value"] = $this->tramite_id->GetDBValue(true);
        $this->InsertFields["tipo_tramites_descript"]["Value"] = $this->tipo_tramites_descript->GetDBValue(true);
        $this->SQL = CCBuildInsert("tipos_tramites", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @6-EFE7385B
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["tramite_id"]["Value"] = $this->tramite_id->GetDBValue(true);
        $this->UpdateFields["tipo_tramites_descript"]["Value"] = $this->tipo_tramites_descript->GetDBValue(true);
        $this->SQL = CCBuildUpdate("tipos_tramites", $this->UpdateFields, $this);
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

} //End tipos_tramitesDataSource Class @6-FCB6E20C

//tipos_tramites1 ReportGroup class @12-FB16E98B
class clsReportGrouptipos_tramites1 {
    public $GroupType;
    public $mode; //1 - open, 2 - close
    public $tramite_desc, $_tramite_descAttributes;
    public $tipo_tramites_descript, $_tipo_tramites_descriptPage, $_tipo_tramites_descriptParameters, $_tipo_tramites_descriptAttributes;
    public $ImageLink1, $_ImageLink1Page, $_ImageLink1Parameters, $_ImageLink1Attributes;
    public $Attributes;
    public $ReportTotalIndex = 0;
    public $PageTotalIndex;
    public $PageNumber;
    public $RowNumber;
    public $Parent;
    public $tramite_idTotalIndex;

    function clsReportGrouptipos_tramites1(& $parent) {
        $this->Parent = & $parent;
        $this->Attributes = $this->Parent->Attributes->GetAsArray();
    }
    function SetControls($PrevGroup = "") {
        $this->tramite_desc = $this->Parent->tramite_desc->Value;
        $this->tipo_tramites_descript = $this->Parent->tipo_tramites_descript->Value;
        $this->ImageLink1 = $this->Parent->ImageLink1->Value;
    }

    function SetTotalControls($mode = "", $PrevGroup = "") {
        $this->_tipo_tramites_descriptPage = $this->Parent->tipo_tramites_descript->Page;
        $this->_tipo_tramites_descriptParameters = $this->Parent->tipo_tramites_descript->Parameters;
        $this->_ImageLink1Page = $this->Parent->ImageLink1->Page;
        $this->_ImageLink1Parameters = $this->Parent->ImageLink1->Parameters;
        $this->_Sorter_tipo_tramites_descriptAttributes = $this->Parent->Sorter_tipo_tramites_descript->Attributes->GetAsArray();
        $this->_tramite_descAttributes = $this->Parent->tramite_desc->Attributes->GetAsArray();
        $this->_tipo_tramites_descriptAttributes = $this->Parent->tipo_tramites_descript->Attributes->GetAsArray();
        $this->_ImageLink1Attributes = $this->Parent->ImageLink1->Attributes->GetAsArray();
        $this->_NavigatorAttributes = $this->Parent->Navigator->Attributes->GetAsArray();
    }
    function SyncWithHeader(& $Header) {
        $this->tramite_desc = $Header->tramite_desc;
        $Header->_tramite_descAttributes = $this->_tramite_descAttributes;
        $this->Parent->tramite_desc->Value = $Header->tramite_desc;
        $this->Parent->tramite_desc->Attributes->RestoreFromArray($Header->_tramite_descAttributes);
        $this->tipo_tramites_descript = $Header->tipo_tramites_descript;
        $this->_tipo_tramites_descriptPage = $Header->_tipo_tramites_descriptPage;
        $this->_tipo_tramites_descriptParameters = $Header->_tipo_tramites_descriptParameters;
        $Header->_tipo_tramites_descriptAttributes = $this->_tipo_tramites_descriptAttributes;
        $this->Parent->tipo_tramites_descript->Value = $Header->tipo_tramites_descript;
        $this->Parent->tipo_tramites_descript->Attributes->RestoreFromArray($Header->_tipo_tramites_descriptAttributes);
        $this->ImageLink1 = $Header->ImageLink1;
        $this->_ImageLink1Page = $Header->_ImageLink1Page;
        $this->_ImageLink1Parameters = $Header->_ImageLink1Parameters;
        $Header->_ImageLink1Attributes = $this->_ImageLink1Attributes;
        $this->Parent->ImageLink1->Value = $Header->ImageLink1;
        $this->Parent->ImageLink1->Attributes->RestoreFromArray($Header->_ImageLink1Attributes);
    }
    function ChangeTotalControls() {
    }
}
//End tipos_tramites1 ReportGroup class

//tipos_tramites1 GroupsCollection class @12-6AD2F3F6
class clsGroupsCollectiontipos_tramites1 {
    public $Groups;
    public $mPageCurrentHeaderIndex;
    public $mtramite_idCurrentHeaderIndex;
    public $PageSize;
    public $TotalPages = 0;
    public $TotalRows = 0;
    public $CurrentPageSize = 0;
    public $Pages;
    public $Parent;
    public $LastDetailIndex;

    function clsGroupsCollectiontipos_tramites1(& $parent) {
        $this->Parent = & $parent;
        $this->Groups = array();
        $this->Pages  = array();
        $this->mtramite_idCurrentHeaderIndex = 1;
        $this->mReportTotalIndex = 0;
        $this->mPageTotalIndex = 1;
    }

    function & InitGroup() {
        $group = new clsReportGrouptipos_tramites1($this->Parent);
        $group->RowNumber = $this->TotalRows + 1;
        $group->PageNumber = $this->TotalPages;
        $group->PageTotalIndex = $this->mPageCurrentHeaderIndex;
        $group->tramite_idTotalIndex = $this->mtramite_idCurrentHeaderIndex;
        return $group;
    }

    function RestoreValues() {
        $this->Parent->tramite_desc->Value = $this->Parent->tramite_desc->initialValue;
        $this->Parent->tipo_tramites_descript->Value = $this->Parent->tipo_tramites_descript->initialValue;
        $this->Parent->ImageLink1->Value = $this->Parent->ImageLink1->initialValue;
    }

    function OpenPage() {
        $this->TotalPages++;
        $Group = & $this->InitGroup();
        $this->Parent->Page_Header->CCSEventResult = CCGetEvent($this->Parent->Page_Header->CCSEvents, "OnInitialize", $this->Parent->Page_Header);
        if ($this->Parent->Page_Header->Visible)
            $this->CurrentPageSize = $this->CurrentPageSize + $this->Parent->Page_Header->Height;
        $Group->SetTotalControls("GetNextValue");
        $this->Parent->Page_Header->CCSEventResult = CCGetEvent($this->Parent->Page_Header->CCSEvents, "OnCalculate", $this->Parent->Page_Header);
        $Group->SetControls();
        $Group->Mode = 1;
        $Group->GroupType = "Page";
        $Group->PageTotalIndex = count($this->Groups);
        $this->mPageCurrentHeaderIndex = count($this->Groups);
        $this->Groups[] =  & $Group;
        $this->Pages[] =  count($this->Groups) == 2 ? 0 : count($this->Groups) - 1;
    }

    function OpenGroup($groupName) {
        $Group = "";
        $OpenFlag = false;
        if ($groupName == "Report") {
            $Group = & $this->InitGroup(true);
            $this->Parent->Report_Header->CCSEventResult = CCGetEvent($this->Parent->Report_Header->CCSEvents, "OnInitialize", $this->Parent->Report_Header);
            if ($this->Parent->Report_Header->Visible) 
                $this->CurrentPageSize = $this->CurrentPageSize + $this->Parent->Report_Header->Height;
                $Group->SetTotalControls("GetNextValue");
            $this->Parent->Report_Header->CCSEventResult = CCGetEvent($this->Parent->Report_Header->CCSEvents, "OnCalculate", $this->Parent->Report_Header);
            $Group->SetControls();
            $Group->Mode = 1;
            $Group->GroupType = "Report";
            $this->Groups[] = & $Group;
            $this->OpenPage();
        }
        if ($groupName == "tramite_id") {
            $Grouptramite_id = & $this->InitGroup(true);
            $this->Parent->tramite_id_Header->CCSEventResult = CCGetEvent($this->Parent->tramite_id_Header->CCSEvents, "OnInitialize", $this->Parent->tramite_id_Header);
            if ($this->Parent->Page_Footer->Visible) 
                $OverSize = $this->Parent->tramite_id_Header->Height + $this->Parent->Page_Footer->Height;
            else
                $OverSize = $this->Parent->tramite_id_Header->Height;
            if (($this->PageSize > 0) and $this->Parent->tramite_id_Header->Visible and ($this->CurrentPageSize + $OverSize > $this->PageSize)) {
                $this->ClosePage();
                $this->OpenPage();
            }
            if ($this->Parent->tramite_id_Header->Visible)
                $this->CurrentPageSize = $this->CurrentPageSize + $this->Parent->tramite_id_Header->Height;
                $Grouptramite_id->SetTotalControls("GetNextValue");
            $this->Parent->tramite_id_Header->CCSEventResult = CCGetEvent($this->Parent->tramite_id_Header->CCSEvents, "OnCalculate", $this->Parent->tramite_id_Header);
            $Grouptramite_id->SetControls();
            $Grouptramite_id->Mode = 1;
            $Grouptramite_id->GroupType = "tramite_id";
            $this->mtramite_idCurrentHeaderIndex = count($this->Groups);
            $this->Groups[] = & $Grouptramite_id;
        }
    }

    function ClosePage() {
        $Group = & $this->InitGroup();
        $this->Parent->Page_Footer->CCSEventResult = CCGetEvent($this->Parent->Page_Footer->CCSEvents, "OnInitialize", $this->Parent->Page_Footer);
        $Group->SetTotalControls("GetPrevValue");
        $Group->SyncWithHeader($this->Groups[$this->mPageCurrentHeaderIndex]);
        $this->Parent->Page_Footer->CCSEventResult = CCGetEvent($this->Parent->Page_Footer->CCSEvents, "OnCalculate", $this->Parent->Page_Footer);
        $Group->SetControls();
        $this->RestoreValues();
        $this->CurrentPageSize = 0;
        $Group->Mode = 2;
        $Group->GroupType = "Page";
        $this->Groups[] = & $Group;
    }

    function CloseGroup($groupName)
    {
        $Group = "";
        if ($groupName == "Report") {
            $Group = & $this->InitGroup(true);
            $this->Parent->Report_Footer->CCSEventResult = CCGetEvent($this->Parent->Report_Footer->CCSEvents, "OnInitialize", $this->Parent->Report_Footer);
            if ($this->Parent->Page_Footer->Visible) 
                $OverSize = $this->Parent->Report_Footer->Height + $this->Parent->Page_Footer->Height;
            else
                $OverSize = $this->Parent->Report_Footer->Height;
            if (($this->PageSize > 0) and $this->Parent->Report_Footer->Visible and ($this->CurrentPageSize + $OverSize > $this->PageSize)) {
                $this->ClosePage();
                $this->OpenPage();
            }
            $Group->SetTotalControls("GetPrevValue");
            $Group->SyncWithHeader($this->Groups[0]);
            if ($this->Parent->Report_Footer->Visible)
                $this->CurrentPageSize = $this->CurrentPageSize + $this->Parent->Report_Footer->Height;
            $this->Parent->Report_Footer->CCSEventResult = CCGetEvent($this->Parent->Report_Footer->CCSEvents, "OnCalculate", $this->Parent->Report_Footer);
            $Group->SetControls();
            $this->RestoreValues();
            $Group->Mode = 2;
            $Group->GroupType = "Report";
            $this->Groups[] = & $Group;
            $this->ClosePage();
            return;
        }
        $Grouptramite_id = & $this->InitGroup(true);
        $this->Parent->tramite_id_Footer->CCSEventResult = CCGetEvent($this->Parent->tramite_id_Footer->CCSEvents, "OnInitialize", $this->Parent->tramite_id_Footer);
        if ($this->Parent->Page_Footer->Visible) 
            $OverSize = $this->Parent->tramite_id_Footer->Height + $this->Parent->Page_Footer->Height;
        else
            $OverSize = $this->Parent->tramite_id_Footer->Height;
        if (($this->PageSize > 0) and $this->Parent->tramite_id_Footer->Visible and ($this->CurrentPageSize + $OverSize > $this->PageSize)) {
            $this->ClosePage();
            $this->OpenPage();
        }
        $Grouptramite_id->SetTotalControls("GetPrevValue");
        $Grouptramite_id->SyncWithHeader($this->Groups[$this->mtramite_idCurrentHeaderIndex]);
        if ($this->Parent->tramite_id_Footer->Visible)
            $this->CurrentPageSize = $this->CurrentPageSize + $this->Parent->tramite_id_Footer->Height;
        $this->Parent->tramite_id_Footer->CCSEventResult = CCGetEvent($this->Parent->tramite_id_Footer->CCSEvents, "OnCalculate", $this->Parent->tramite_id_Footer);
        $Grouptramite_id->SetControls();
        $this->RestoreValues();
        $Grouptramite_id->Mode = 2;
        $Grouptramite_id->GroupType ="tramite_id";
        $this->Groups[] = & $Grouptramite_id;
    }

    function AddItem()
    {
        $Group = & $this->InitGroup(true);
        $this->Parent->Detail->CCSEventResult = CCGetEvent($this->Parent->Detail->CCSEvents, "OnInitialize", $this->Parent->Detail);
        if ($this->Parent->Page_Footer->Visible) 
            $OverSize = $this->Parent->Detail->Height + $this->Parent->Page_Footer->Height;
        else
            $OverSize = $this->Parent->Detail->Height;
        if (($this->PageSize > 0) and $this->Parent->Detail->Visible and ($this->CurrentPageSize + $OverSize > $this->PageSize)) {
            $this->ClosePage();
            $this->OpenPage();
        }
        $this->TotalRows++;
        if ($this->LastDetailIndex)
            $PrevGroup = & $this->Groups[$this->LastDetailIndex];
        else
            $PrevGroup = "";
        $Group->SetTotalControls("", $PrevGroup);
        if ($this->Parent->Detail->Visible)
            $this->CurrentPageSize = $this->CurrentPageSize + $this->Parent->Detail->Height;
        $this->Parent->Detail->CCSEventResult = CCGetEvent($this->Parent->Detail->CCSEvents, "OnCalculate", $this->Parent->Detail);
        $Group->SetControls($PrevGroup);
        $this->LastDetailIndex = count($this->Groups);
        $this->Groups[] = & $Group;
    }
}
//End tipos_tramites1 GroupsCollection class

class clsReporttipos_tramites1 { //tipos_tramites1 Class @12-07313C37

//tipos_tramites1 Variables @12-E3C0550D

    public $ComponentType = "Report";
    public $PageSize;
    public $ComponentName;
    public $Visible;
    public $Errors;
    public $CCSEvents = array();
    public $CCSEventResult;
    public $RelativePath = "";
    public $ViewMode = "Web";
    public $TemplateBlock;
    public $PageNumber;
    public $RowNumber;
    public $TotalRows;
    public $TotalPages;
    public $ControlsVisible = array();
    public $IsEmpty;
    public $Attributes;
    public $DetailBlock, $Detail;
    public $Report_FooterBlock, $Report_Footer;
    public $Report_HeaderBlock, $Report_Header;
    public $Page_FooterBlock, $Page_Footer;
    public $Page_HeaderBlock, $Page_Header;
    public $tramite_id_HeaderBlock, $tramite_id_Header;
    public $tramite_id_FooterBlock, $tramite_id_Footer;
    public $SorterName, $SorterDirection;

    public $ds;
    public $DataSource;
    public $UseClientPaging = false;

    //Report Controls
    public $StaticControls, $RowControls, $Report_FooterControls, $Report_HeaderControls;
    public $Page_FooterControls, $Page_HeaderControls;
    public $tramite_id_HeaderControls, $tramite_id_FooterControls;
    public $Sorter_tipo_tramites_descript;
//End tipos_tramites1 Variables

//Class_Initialize Event @12-98A85B3D
    function clsReporttipos_tramites1($RelativePath = "", & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "tipos_tramites1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->Detail = new clsSection($this);
        $MinPageSize = 0;
        $MaxSectionSize = 0;
        $this->Detail->Height = 1;
        $MaxSectionSize = max($MaxSectionSize, $this->Detail->Height);
        $this->Report_Footer = new clsSection($this);
        $this->Report_Header = new clsSection($this);
        $this->Page_Footer = new clsSection($this);
        $this->Page_Footer->Height = 1;
        $MinPageSize += $this->Page_Footer->Height;
        $this->Page_Header = new clsSection($this);
        $this->Page_Header->Height = 1;
        $MinPageSize += $this->Page_Header->Height;
        $this->tramite_id_Footer = new clsSection($this);
        $this->tramite_id_Header = new clsSection($this);
        $this->tramite_id_Header->Height = 1;
        $MaxSectionSize = max($MaxSectionSize, $this->tramite_id_Header->Height);
        $this->Errors = new clsErrors();
        $this->DataSource = new clstipos_tramites1DataSource($this);
        $this->ds = & $this->DataSource;
        $PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(is_numeric($PageSize) && $PageSize > 0) {
            $this->PageSize = $PageSize;
        } else {
            if (!is_numeric($PageSize) || $PageSize < 0)
                $this->PageSize = 40;
             else if ($PageSize == "0")
                $this->PageSize = 100;
             else 
                $this->PageSize = min(100, $PageSize);
        }
        $MinPageSize += $MaxSectionSize;
        if ($this->PageSize && $MinPageSize && $this->PageSize < $MinPageSize)
            $this->PageSize = $MinPageSize;
        $this->PageNumber = $this->ViewMode == "Print" ? 1 : intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0 ) {
            $this->PageNumber = 1;
        }
        $this->SorterName = CCGetParam("tipos_tramites1Order", "");
        $this->SorterDirection = CCGetParam("tipos_tramites1Dir", "");

        $this->Sorter_tipo_tramites_descript = new clsSorter($this->ComponentName, "Sorter_tipo_tramites_descript", $FileName, $this);
        $this->tramite_desc = new clsControl(ccsReportLabel, "tramite_desc", "tramite_desc", ccsText, "", "", $this);
        $this->tipo_tramites_descript = new clsControl(ccsLink, "tipo_tramites_descript", "tipo_tramites_descript", ccsText, "", CCGetRequestParam("tipo_tramites_descript", ccsGet, NULL), $this);
        $this->tipo_tramites_descript->Page = "";
        $this->ImageLink1 = new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", CCGetRequestParam("ImageLink1", ccsGet, NULL), $this);
        $this->ImageLink1->Page = "pa_mesa_tramites_unidades.php";
        $this->NoRecords = new clsPanel("NoRecords", $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @12-6C59EE65
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = $this->PageSize;
        $this->DataSource->AbsolutePage = $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//CheckErrors Method @12-6AF03910
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->tramite_desc->Errors->Count());
        $errors = ($errors || $this->tipo_tramites_descript->Errors->Count());
        $errors = ($errors || $this->ImageLink1->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//GetErrors Method @12-CB75D40C
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->tramite_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_tramites_descript->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ImageLink1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

//Show Method @12-F764F8BB
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $ShownRecords = 0;

        $this->DataSource->Parameters["urltramite_id"] = CCGetFromGet("tramite_id", NULL);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


        $this->DataSource->Prepare();
        $this->DataSource->Open();

        $tramite_idKey = "";
        $Groups = new clsGroupsCollectiontipos_tramites1($this);
        $Groups->PageSize = $this->PageSize > 0 ? $this->PageSize : 0;

        $is_next_record = $this->DataSource->next_record();
        $this->IsEmpty = ! $is_next_record;
        while($is_next_record) {
            $this->DataSource->SetValues();
            $this->tramite_desc->SetValue($this->DataSource->tramite_desc->GetValue());
            $this->tipo_tramites_descript->SetValue($this->DataSource->tipo_tramites_descript->GetValue());
            $this->tipo_tramites_descript->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
            $this->tipo_tramites_descript->Parameters = CCAddParam($this->tipo_tramites_descript->Parameters, "tipo_tramites_id", $this->DataSource->f("tipo_tramites_id"));
            $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("tipo_tramite_id", "tramite_id", "ccsForm"));
            $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "s_tramite_id", $this->DataSource->f("tramite_id"));
            $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "s_tipo_tramites_id", $this->DataSource->f("tipo_tramites_id"));
            if (count($Groups->Groups) == 0) $Groups->OpenGroup("Report");
            if (count($Groups->Groups) == 2 or $tramite_idKey != $this->DataSource->f("tramite_id")) {
                $Groups->OpenGroup("tramite_id");
            }
            $Groups->AddItem();
            $tramite_idKey = $this->DataSource->f("tramite_id");
            $is_next_record = $this->DataSource->next_record();
            if (!$is_next_record || $tramite_idKey != $this->DataSource->f("tramite_id")) {
                $Groups->CloseGroup("tramite_id");
            }
        }
        if (!count($Groups->Groups)) 
            $Groups->OpenGroup("Report");
        else
            $this->NoRecords->Visible = false;
        $Groups->CloseGroup("Report");
        $this->TotalPages = $Groups->TotalPages;
        $this->TotalRows = $Groups->TotalRows;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) return;

        $this->Attributes->Show();
        $ReportBlock = "Report " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $ReportBlock;

        if($this->CheckErrors()) {
            $Tpl->replaceblock("", $this->GetErrors());
            $Tpl->block_path = $ParentPath;
            return;
        } else {
            $items = & $Groups->Groups;
            $i = $Groups->Pages[min($this->PageNumber, $Groups->TotalPages) - 1];
            $this->ControlsVisible["tramite_desc"] = $this->tramite_desc->Visible;
            $this->ControlsVisible["tipo_tramites_descript"] = $this->tipo_tramites_descript->Visible;
            $this->ControlsVisible["ImageLink1"] = $this->ImageLink1->Visible;
            do {
                $this->Attributes->RestoreFromArray($items[$i]->Attributes);
                $this->RowNumber = $items[$i]->RowNumber;
                switch ($items[$i]->GroupType) {
                    Case "":
                        $Tpl->block_path = $ParentPath . "/" . $ReportBlock . "/Section Detail";
                        $this->tipo_tramites_descript->SetValue($items[$i]->tipo_tramites_descript);
                        $this->tipo_tramites_descript->Page = $items[$i]->_tipo_tramites_descriptPage;
                        $this->tipo_tramites_descript->Parameters = $items[$i]->_tipo_tramites_descriptParameters;
                        $this->tipo_tramites_descript->Attributes->RestoreFromArray($items[$i]->_tipo_tramites_descriptAttributes);
                        $this->ImageLink1->SetValue($items[$i]->ImageLink1);
                        $this->ImageLink1->Page = $items[$i]->_ImageLink1Page;
                        $this->ImageLink1->Parameters = $items[$i]->_ImageLink1Parameters;
                        $this->ImageLink1->Attributes->RestoreFromArray($items[$i]->_ImageLink1Attributes);
                        $this->Detail->CCSEventResult = CCGetEvent($this->Detail->CCSEvents, "BeforeShow", $this->Detail);
                        $this->Attributes->Show();
                        $this->tipo_tramites_descript->Show();
                        $this->ImageLink1->Show();
                        $Tpl->block_path = $ParentPath . "/" . $ReportBlock;
                        if ($this->Detail->Visible)
                            $Tpl->parseto("Section Detail", true, "Section Detail");
                        break;
                    case "Report":
                        if ($items[$i]->Mode == 1) {
                            $this->Report_Header->CCSEventResult = CCGetEvent($this->Report_Header->CCSEvents, "BeforeShow", $this->Report_Header);
                            if ($this->Report_Header->Visible) {
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock . "/Section Report_Header";
                                $this->Attributes->Show();
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock;
                                $Tpl->parseto("Section Report_Header", true, "Section Detail");
                            }
                        }
                        if ($items[$i]->Mode == 2) {
                            $this->Report_Footer->CCSEventResult = CCGetEvent($this->Report_Footer->CCSEvents, "BeforeShow", $this->Report_Footer);
                            if ($this->Report_Footer->Visible) {
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock . "/Section Report_Footer";
                                $this->NoRecords->Show();
                                $this->Attributes->Show();
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock;
                                $Tpl->parseto("Section Report_Footer", true, "Section Detail");
                            }
                        }
                        break;
                    case "Page":
                        if ($items[$i]->Mode == 1) {
                            $this->Page_Header->CCSEventResult = CCGetEvent($this->Page_Header->CCSEvents, "BeforeShow", $this->Page_Header);
                            if ($this->Page_Header->Visible) {
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock . "/Section Page_Header";
                                $this->Attributes->Show();
                                $this->Sorter_tipo_tramites_descript->Show();
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock;
                                $Tpl->parseto("Section Page_Header", true, "Section Detail");
                            }
                        }
                        if ($items[$i]->Mode == 2 && !$this->UseClientPaging || $items[$i]->Mode == 1 && $this->UseClientPaging) {
                            $this->Navigator->PageNumber = $items[$i]->PageNumber;
                            $this->Navigator->TotalPages = $Groups->TotalPages;
                            $this->Navigator->Visible = ("Print" != $this->ViewMode);
                            $this->Page_Footer->CCSEventResult = CCGetEvent($this->Page_Footer->CCSEvents, "BeforeShow", $this->Page_Footer);
                            if ($this->Page_Footer->Visible) {
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock . "/Section Page_Footer";
                                $this->Navigator->Show();
                                $this->Attributes->Show();
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock;
                                $Tpl->parseto("Section Page_Footer", true, "Section Detail");
                            }
                        }
                        break;
                    case "tramite_id":
                        if ($items[$i]->Mode == 1) {
                            $this->tramite_desc->SetValue($items[$i]->tramite_desc);
                            $this->tramite_desc->Attributes->RestoreFromArray($items[$i]->_tramite_descAttributes);
                            $this->tramite_id_Header->CCSEventResult = CCGetEvent($this->tramite_id_Header->CCSEvents, "BeforeShow", $this->tramite_id_Header);
                            if ($this->tramite_id_Header->Visible) {
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock . "/Section tramite_id_Header";
                                $this->Attributes->Show();
                                $this->tramite_desc->Show();
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock;
                                $Tpl->parseto("Section tramite_id_Header", true, "Section Detail");
                            }
                        }
                        if ($items[$i]->Mode == 2) {
                            $this->tramite_id_Footer->CCSEventResult = CCGetEvent($this->tramite_id_Footer->CCSEvents, "BeforeShow", $this->tramite_id_Footer);
                            if ($this->tramite_id_Footer->Visible) {
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock . "/Section tramite_id_Footer";
                                $this->Attributes->Show();
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock;
                                $Tpl->parseto("Section tramite_id_Footer", true, "Section Detail");
                            }
                        }
                        break;
                }
                $i++;
            } while ($i < count($items) && ($this->ViewMode == "Print" ||  !($i > 1 && $items[$i]->GroupType == 'Page' && $items[$i]->Mode == 1)));
            $Tpl->block_path = $ParentPath;
            $Tpl->parse($ReportBlock);
            $this->DataSource->close();
        }

    }
//End Show Method

} //End tipos_tramites1 Class @12-FCB6E20C

class clstipos_tramites1DataSource extends clsDBmesa {  //tipos_tramites1DataSource Class @12-1DD38BF0

//DataSource Variables @12-7195DCFE
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $wp;


    // Datasource fields
    public $tramite_desc;
    public $tipo_tramites_descript;
//End DataSource Variables

//DataSourceClass_Initialize Event @12-EDFC47B4
    function clstipos_tramites1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Report tipos_tramites1";
        $this->Initialize();
        $this->tramite_desc = new clsField("tramite_desc", ccsText, "");
        
        $this->tipo_tramites_descript = new clsField("tipo_tramites_descript", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @12-FCD1EC33
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_tipo_tramites_descript" => array("tipo_tramites_descript", "")));
    }
//End SetOrder Method

//Prepare Method @12-30893D37
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urltramite_id", ccsInteger, "", "", $this->Parameters["urltramite_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "tramites.tramite_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @12-839B5F89
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT tipos_tramites.*, tramite_desc \n\n" .
        "FROM tipos_tramites INNER JOIN tramites ON\n\n" .
        "tipos_tramites.tramite_id = tramites.tramite_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->query(CCBuildSQL($this->SQL, $this->Where, "tramite_id asc" .  ($this->Order ? ", " . $this->Order: "")));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @12-A9E07E96
    function SetValues()
    {
        $this->tramite_desc->SetDBValue($this->f("tramite_desc"));
        $this->tipo_tramites_descript->SetDBValue($this->f("tipo_tramites_descript"));
    }
//End SetValues Method

} //End tipos_tramites1DataSource Class @12-FCB6E20C

//Initialize Page @1-E4DD3830
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
$TemplateFileName = "pa_mesa_tramites.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-D9DBF8C9
CCSecurityRedirect("1;2", "");
//End Authenticate User

//Include events file @1-B5B06E20
include_once("./pa_mesa_tramites_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-1139C068
$DBmesa = new clsDBmesa();
$MainPage->Connections["mesa"] = & $DBmesa;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../../01_administracion/", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("../../01_administracion/", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$tdf_menu = new clstdf_menu("../../01_administracion/", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tipos_tramites = new clsRecordtipos_tramites("", $MainPage);
$tipos_tramites1 = new clsReporttipos_tramites1("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tipos_tramites = & $tipos_tramites;
$MainPage->tipos_tramites1 = & $tipos_tramites1;
$tipos_tramites->Initialize();
$tipos_tramites1->Initialize();

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

//Execute Components @1-03C4117E
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
$tipos_tramites->Operation();
//End Execute Components

//Go to destination page @1-80625B6C
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBmesa->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    unset($tipos_tramites);
    unset($tipos_tramites1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-3BA480EE
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$tipos_tramites->Show();
$tipos_tramites1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font face=\"Arial\"><small>G&#101;&#110;&#101;&#114;a&#116;e&#100; <!-- SCC -->&#119;&#105;th <!-- SCC -->Co&#100;&#101;&#67;h&#97;r&#103;e <!-- SCC -->&#83;&#116;&#117;d&#105;o.</small></font></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font face=\"Arial\"><small>G&#101;&#110;&#101;&#114;a&#116;e&#100; <!-- SCC -->&#119;&#105;th <!-- SCC -->Co&#100;&#101;&#67;h&#97;r&#103;e <!-- SCC -->&#83;&#116;&#117;d&#105;o.</small></font></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font face=\"Arial\"><small>G&#101;&#110;&#101;&#114;a&#116;e&#100; <!-- SCC -->&#119;&#105;th <!-- SCC -->Co&#100;&#101;&#67;h&#97;r&#103;e <!-- SCC -->&#83;&#116;&#117;d&#105;o.</small></font></center>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-4F3E8417
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmesa->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($tipos_tramites);
unset($tipos_tramites1);
unset($Tpl);
//End Unload Page


?>
