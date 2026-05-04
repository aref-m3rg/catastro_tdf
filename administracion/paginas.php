<?php
//Include Common Files @1-9D32906B
define("RelativePath", "..");
define("PathToCurrentPage", "/administracion/");
define("FileName", "paginas.php");
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

class clsGridmenu1 { //menu1 class @19-1C93394E

//Variables @19-2E11F7FB

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
    public $Sorter_menu_descripcion;
    public $Sorter_menu_title;
    public $Sorter_menu_link;
    public $Sorter1;
//End Variables

//Class_Initialize Event @19-4DC53E6D
    function clsGridmenu1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "menu1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid menu1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsmenu1DataSource($this);
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
        $this->SorterName = CCGetParam("menu1Order", "");
        $this->SorterDirection = CCGetParam("menu1Dir", "");

        $this->Detail = new clsControl(ccsLink, "Detail", "Detail", ccsText, "", CCGetRequestParam("Detail", ccsGet, NULL), $this);
        $this->Detail->Page = "paginas.php";
        $this->menu_descripcion = new clsControl(ccsLabel, "menu_descripcion", "menu_descripcion", ccsText, "", CCGetRequestParam("menu_descripcion", ccsGet, NULL), $this);
        $this->menu_title = new clsControl(ccsLabel, "menu_title", "menu_title", ccsText, "", CCGetRequestParam("menu_title", ccsGet, NULL), $this);
        $this->menu_link = new clsControl(ccsLabel, "menu_link", "menu_link", ccsText, "", CCGetRequestParam("menu_link", ccsGet, NULL), $this);
        $this->visible = new clsControl(ccsLabel, "visible", "visible", ccsText, "", CCGetRequestParam("visible", ccsGet, NULL), $this);
        $this->Link1 = new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $this);
        $this->Link1->Page = "subpaginas.php";
        $this->menu1_Insert = new clsControl(ccsLink, "menu1_Insert", "menu1_Insert", ccsText, "", CCGetRequestParam("menu1_Insert", ccsGet, NULL), $this);
        $this->menu1_Insert->Parameters = CCGetQueryString("QueryString", array("menu_id_id", "ccsForm"));
        $this->menu1_Insert->Page = "paginas.php";
        $this->Sorter_menu_descripcion = new clsSorter($this->ComponentName, "Sorter_menu_descripcion", $FileName, $this);
        $this->Sorter_menu_title = new clsSorter($this->ComponentName, "Sorter_menu_title", $FileName, $this);
        $this->Sorter_menu_link = new clsSorter($this->ComponentName, "Sorter_menu_link", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Sorter1 = new clsSorter($this->ComponentName, "Sorter1", $FileName, $this);
    }
//End Class_Initialize Event

//Initialize Method @19-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @19-0984469C
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlmenu_idp"] = CCGetFromGet("menu_idp", NULL);
        $this->DataSource->Parameters["urlmenu_parent_id"] = CCGetFromGet("menu_parent_id", NULL);

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
            $this->ControlsVisible["Detail"] = $this->Detail->Visible;
            $this->ControlsVisible["menu_descripcion"] = $this->menu_descripcion->Visible;
            $this->ControlsVisible["menu_title"] = $this->menu_title->Visible;
            $this->ControlsVisible["menu_link"] = $this->menu_link->Visible;
            $this->ControlsVisible["visible"] = $this->visible->Visible;
            $this->ControlsVisible["Link1"] = $this->Link1->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->Detail->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->Detail->Parameters = CCAddParam($this->Detail->Parameters, "menu_id_id", $this->DataSource->f("menu_id"));
                $this->menu_descripcion->SetValue($this->DataSource->menu_descripcion->GetValue());
                $this->menu_title->SetValue($this->DataSource->menu_title->GetValue());
                $this->menu_link->SetValue($this->DataSource->menu_link->GetValue());
                $this->visible->SetValue($this->DataSource->visible->GetValue());
                $this->Link1->Parameters = "";
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "menu_p_id", $this->DataSource->f("menu_id"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->Detail->Show();
                $this->menu_descripcion->Show();
                $this->menu_title->Show();
                $this->menu_link->Show();
                $this->visible->Show();
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
        $this->menu1_Insert->Show();
        $this->Sorter_menu_descripcion->Show();
        $this->Sorter_menu_title->Show();
        $this->Sorter_menu_link->Show();
        $this->Navigator->Show();
        $this->Sorter1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @19-A8DEEF6E
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->Detail->Errors->ToString());
        $errors = ComposeStrings($errors, $this->menu_descripcion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->menu_title->Errors->ToString());
        $errors = ComposeStrings($errors, $this->menu_link->Errors->ToString());
        $errors = ComposeStrings($errors, $this->visible->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End menu1 Class @19-FCB6E20C

class clsmenu1DataSource extends clsDBtdf_nuevo {  //menu1DataSource Class @19-D99F2729

//DataSource Variables @19-FF03799F
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $menu_descripcion;
    public $menu_title;
    public $menu_link;
    public $visible;
//End DataSource Variables

//DataSourceClass_Initialize Event @19-91C48A78
    function clsmenu1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid menu1";
        $this->Initialize();
        $this->menu_descripcion = new clsField("menu_descripcion", ccsText, "");
        
        $this->menu_title = new clsField("menu_title", ccsText, "");
        
        $this->menu_link = new clsField("menu_link", ccsText, "");
        
        $this->visible = new clsField("visible", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @19-B4302B18
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "menu.menu_id";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_menu_descripcion" => array("menu_descripcion", ""), 
            "Sorter_menu_title" => array("menu_title", ""), 
            "Sorter_menu_link" => array("menu_link", ""), 
            "Sorter1" => array("menu_visible_id", "menu_visible_id")));
    }
//End SetOrder Method

//Prepare Method @19-69268A68
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlmenu_idp", ccsInteger, "", "", $this->Parameters["urlmenu_idp"], "", true);
        $this->wp->AddParameter("2", "urlmenu_parent_id", ccsInteger, "", "", $this->Parameters["urlmenu_parent_id"], "", true);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "menu.menu_parent_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),true);
        $this->wp->Criterion[2] = $this->wp->Operation(opNotNull, "menu.menu_parent_id", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),true);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @19-7076AD19
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM menu INNER JOIN menus_visibles ON\n\n" .
        "menu.menu_visible_id = menus_visibles.menu_visible_id";
        $this->SQL = "SELECT menu_id, menu_descripcion, menu_title, menu_link, menu.menu_visible_id AS menu_menu_visible_id, menu_visible_abrev \n\n" .
        "FROM menu INNER JOIN menus_visibles ON\n\n" .
        "menu.menu_visible_id = menus_visibles.menu_visible_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @19-F51F54C2
    function SetValues()
    {
        $this->menu_descripcion->SetDBValue($this->f("menu_descripcion"));
        $this->menu_title->SetDBValue($this->f("menu_title"));
        $this->menu_link->SetDBValue($this->f("menu_link"));
        $this->visible->SetDBValue($this->f("menu_visible_abrev"));
    }
//End SetValues Method

} //End menu1DataSource Class @19-FCB6E20C

class clsRecordmenu2 { //menu2 Class @35-A0E8A27B

//Variables @35-9E315808

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

//Class_Initialize Event @35-2A67BA7D
    function clsRecordmenu2($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record menu2/Error";
        $this->DataSource = new clsmenu2DataSource($this);
        $this->ds = & $this->DataSource;
        $this->ReadAllowed = true;
        $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
        if($this->Visible)
        {
            $this->ReadAllowed = $this->ReadAllowed && CCUserInGroups(CCGetGroupID(), "1;2");
            $this->InsertAllowed = CCUserInGroups(CCGetGroupID(), "2");
            $this->UpdateAllowed = CCUserInGroups(CCGetGroupID(), "2");
            $this->DeleteAllowed = CCUserInGroups(CCGetGroupID(), "2");
            $this->ComponentName = "menu2";
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
            $this->menu_descripcion = new clsControl(ccsTextBox, "menu_descripcion", "Descripcion", ccsText, "", CCGetRequestParam("menu_descripcion", $Method, NULL), $this);
            $this->menu_descripcion->Required = true;
            $this->menu_title = new clsControl(ccsTextBox, "menu_title", "Title", ccsText, "", CCGetRequestParam("menu_title", $Method, NULL), $this);
            $this->menu_parent_id = new clsControl(ccsHidden, "menu_parent_id", "Parent Id", ccsInteger, "", CCGetRequestParam("menu_parent_id", $Method, NULL), $this);
            $this->link = new clsControl(ccsTextBox, "link", "Link", ccsText, "", CCGetRequestParam("link", $Method, NULL), $this);
            $this->menu_orden = new clsControl(ccsHidden, "menu_orden", "Orden", ccsInteger, "", CCGetRequestParam("menu_orden", $Method, NULL), $this);
            $this->LBVisible = new clsControl(ccsListBox, "LBVisible", "LBVisible", ccsText, "", CCGetRequestParam("LBVisible", $Method, NULL), $this);
            $this->LBVisible->DSType = dsTable;
            $this->LBVisible->DataSource = new clsDBtdf_nuevo();
            $this->LBVisible->ds = & $this->LBVisible->DataSource;
            $this->LBVisible->DataSource->SQL = "SELECT * \n" .
"FROM menus_visibles {SQL_Where} {SQL_OrderBy}";
            list($this->LBVisible->BoundColumn, $this->LBVisible->TextColumn, $this->LBVisible->DBFormat) = array("menu_visible_id", "menu_visible_descrip", "");
            $this->LBVisible->Required = true;
        }
    }
//End Class_Initialize Event

//Initialize Method @35-776C0CBF
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlmenu_id_id"] = CCGetFromGet("menu_id_id", NULL);
    }
//End Initialize Method

//Validate Method @35-1650C8C0
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->menu_descripcion->Validate() && $Validation);
        $Validation = ($this->menu_title->Validate() && $Validation);
        $Validation = ($this->menu_parent_id->Validate() && $Validation);
        $Validation = ($this->link->Validate() && $Validation);
        $Validation = ($this->menu_orden->Validate() && $Validation);
        $Validation = ($this->LBVisible->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->menu_descripcion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->menu_title->Errors->Count() == 0);
        $Validation =  $Validation && ($this->menu_parent_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->link->Errors->Count() == 0);
        $Validation =  $Validation && ($this->menu_orden->Errors->Count() == 0);
        $Validation =  $Validation && ($this->LBVisible->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @35-5A15E3D0
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->menu_descripcion->Errors->Count());
        $errors = ($errors || $this->menu_title->Errors->Count());
        $errors = ($errors || $this->menu_parent_id->Errors->Count());
        $errors = ($errors || $this->link->Errors->Count());
        $errors = ($errors || $this->menu_orden->Errors->Count());
        $errors = ($errors || $this->LBVisible->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @35-ED598703
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

//Operation Method @35-AEA49113
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
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Delete" && $this->DeleteAllowed) {
            if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete) || !$this->DeleteRow()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_Cancel") {
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Insert" && $this->InsertAllowed) {
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_Update" && $this->UpdateAllowed) {
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

//InsertRow Method @35-81A9B022
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->menu_descripcion->SetValue($this->menu_descripcion->GetValue(true));
        $this->DataSource->menu_title->SetValue($this->menu_title->GetValue(true));
        $this->DataSource->menu_parent_id->SetValue($this->menu_parent_id->GetValue(true));
        $this->DataSource->link->SetValue($this->link->GetValue(true));
        $this->DataSource->menu_orden->SetValue($this->menu_orden->GetValue(true));
        $this->DataSource->LBVisible->SetValue($this->LBVisible->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @35-CF252A74
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->menu_descripcion->SetValue($this->menu_descripcion->GetValue(true));
        $this->DataSource->menu_title->SetValue($this->menu_title->GetValue(true));
        $this->DataSource->menu_parent_id->SetValue($this->menu_parent_id->GetValue(true));
        $this->DataSource->link->SetValue($this->link->GetValue(true));
        $this->DataSource->menu_orden->SetValue($this->menu_orden->GetValue(true));
        $this->DataSource->LBVisible->SetValue($this->LBVisible->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @35-299D98C3
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @35-87F775EA
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

        $this->LBVisible->Prepare();

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
                    $this->menu_descripcion->SetValue($this->DataSource->menu_descripcion->GetValue());
                    $this->menu_title->SetValue($this->DataSource->menu_title->GetValue());
                    $this->menu_parent_id->SetValue($this->DataSource->menu_parent_id->GetValue());
                    $this->link->SetValue($this->DataSource->link->GetValue());
                    $this->menu_orden->SetValue($this->DataSource->menu_orden->GetValue());
                    $this->LBVisible->SetValue($this->DataSource->LBVisible->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->menu_descripcion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->menu_title->Errors->ToString());
            $Error = ComposeStrings($Error, $this->menu_parent_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->link->Errors->ToString());
            $Error = ComposeStrings($Error, $this->menu_orden->Errors->ToString());
            $Error = ComposeStrings($Error, $this->LBVisible->Errors->ToString());
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
        $this->Button_Delete->Show();
        $this->Button_Cancel->Show();
        $this->menu_descripcion->Show();
        $this->menu_title->Show();
        $this->menu_parent_id->Show();
        $this->link->Show();
        $this->menu_orden->Show();
        $this->LBVisible->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End menu2 Class @35-FCB6E20C

class clsmenu2DataSource extends clsDBtdf_nuevo {  //menu2DataSource Class @35-8288963C

//DataSource Variables @35-C72CD269
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
    public $menu_descripcion;
    public $menu_title;
    public $menu_parent_id;
    public $link;
    public $menu_orden;
    public $LBVisible;
//End DataSource Variables

//DataSourceClass_Initialize Event @35-CF795D90
    function clsmenu2DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record menu2/Error";
        $this->Initialize();
        $this->menu_descripcion = new clsField("menu_descripcion", ccsText, "");
        
        $this->menu_title = new clsField("menu_title", ccsText, "");
        
        $this->menu_parent_id = new clsField("menu_parent_id", ccsInteger, "");
        
        $this->link = new clsField("link", ccsText, "");
        
        $this->menu_orden = new clsField("menu_orden", ccsInteger, "");
        
        $this->LBVisible = new clsField("LBVisible", ccsText, "");
        

        $this->InsertFields["menu_descripcion"] = array("Name" => "menu_descripcion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["menu_title"] = array("Name" => "menu_title", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["menu_parent_id"] = array("Name" => "menu_parent_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["menu_link"] = array("Name" => "menu_link", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["menu_orden"] = array("Name" => "menu_orden", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["menu_visible_id"] = array("Name" => "menu_visible_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["menu_descripcion"] = array("Name" => "menu_descripcion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["menu_title"] = array("Name" => "menu_title", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["menu_parent_id"] = array("Name" => "menu_parent_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["menu_link"] = array("Name" => "menu_link", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["menu_orden"] = array("Name" => "menu_orden", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["menu_visible_id"] = array("Name" => "menu_visible_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @35-CA60A001
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlmenu_id_id", ccsInteger, "", "", $this->Parameters["urlmenu_id_id"], "", true);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "menu_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),true);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @35-F70C27CE
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM menu {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @35-E5298901
    function SetValues()
    {
        $this->menu_descripcion->SetDBValue($this->f("menu_descripcion"));
        $this->menu_title->SetDBValue($this->f("menu_title"));
        $this->menu_parent_id->SetDBValue(trim($this->f("menu_parent_id")));
        $this->link->SetDBValue($this->f("menu_link"));
        $this->menu_orden->SetDBValue(trim($this->f("menu_orden")));
        $this->LBVisible->SetDBValue($this->f("menu_visible_id"));
    }
//End SetValues Method

//Insert Method @35-B7AB193A
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["menu_descripcion"]["Value"] = $this->menu_descripcion->GetDBValue(true);
        $this->InsertFields["menu_title"]["Value"] = $this->menu_title->GetDBValue(true);
        $this->InsertFields["menu_parent_id"]["Value"] = $this->menu_parent_id->GetDBValue(true);
        $this->InsertFields["menu_link"]["Value"] = $this->link->GetDBValue(true);
        $this->InsertFields["menu_orden"]["Value"] = $this->menu_orden->GetDBValue(true);
        $this->InsertFields["menu_visible_id"]["Value"] = $this->LBVisible->GetDBValue(true);
        $this->SQL = CCBuildInsert("menu", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @35-8987CF67
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["menu_descripcion"]["Value"] = $this->menu_descripcion->GetDBValue(true);
        $this->UpdateFields["menu_title"]["Value"] = $this->menu_title->GetDBValue(true);
        $this->UpdateFields["menu_parent_id"]["Value"] = $this->menu_parent_id->GetDBValue(true);
        $this->UpdateFields["menu_link"]["Value"] = $this->link->GetDBValue(true);
        $this->UpdateFields["menu_orden"]["Value"] = $this->menu_orden->GetDBValue(true);
        $this->UpdateFields["menu_visible_id"]["Value"] = $this->LBVisible->GetDBValue(true);
        $this->SQL = CCBuildUpdate("menu", $this->UpdateFields, $this);
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

//Delete Method @35-7215BC2C
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM menu";
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

} //End menu2DataSource Class @35-FCB6E20C

class clsGridmenu { //menu class @5-663BF482

//Variables @5-DF953154

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
    public $Sorter_menu_descripcion;
    public $Sorter_menu_title;
    public $Sorter_menu_link;
    public $Sorter_menu_orden;
//End Variables

//Class_Initialize Event @5-6D62FC41
    function clsGridmenu($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "menu";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid menu";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsmenuDataSource($this);
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
        $this->Visible = (CCSecurityAccessCheck("") == "success");
        $this->SorterName = CCGetParam("menuOrder", "");
        $this->SorterDirection = CCGetParam("menuDir", "");

        $this->menu_descripcion = new clsControl(ccsLabel, "menu_descripcion", "menu_descripcion", ccsText, "", CCGetRequestParam("menu_descripcion", ccsGet, NULL), $this);
        $this->menu_title = new clsControl(ccsLabel, "menu_title", "menu_title", ccsText, "", CCGetRequestParam("menu_title", ccsGet, NULL), $this);
        $this->menu_link = new clsControl(ccsLabel, "menu_link", "menu_link", ccsText, "", CCGetRequestParam("menu_link", ccsGet, NULL), $this);
        $this->menu_orden = new clsControl(ccsLabel, "menu_orden", "menu_orden", ccsInteger, "", CCGetRequestParam("menu_orden", ccsGet, NULL), $this);
        $this->Link1 = new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $this);
        $this->Link1->Page = "paginas.php";
        $this->Link2 = new clsControl(ccsLink, "Link2", "Link2", ccsText, "", CCGetRequestParam("Link2", ccsGet, NULL), $this);
        $this->Link2->Page = "paginas.php";
        $this->Sorter_menu_descripcion = new clsSorter($this->ComponentName, "Sorter_menu_descripcion", $FileName, $this);
        $this->Sorter_menu_title = new clsSorter($this->ComponentName, "Sorter_menu_title", $FileName, $this);
        $this->Sorter_menu_link = new clsSorter($this->ComponentName, "Sorter_menu_link", $FileName, $this);
        $this->Sorter_menu_orden = new clsSorter($this->ComponentName, "Sorter_menu_orden", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
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

//Show Method @5-A8B694D1
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlmenu_parent_id"] = CCGetFromGet("menu_parent_id", NULL);

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
            $this->ControlsVisible["menu_descripcion"] = $this->menu_descripcion->Visible;
            $this->ControlsVisible["menu_title"] = $this->menu_title->Visible;
            $this->ControlsVisible["menu_link"] = $this->menu_link->Visible;
            $this->ControlsVisible["menu_orden"] = $this->menu_orden->Visible;
            $this->ControlsVisible["Link1"] = $this->Link1->Visible;
            $this->ControlsVisible["Link2"] = $this->Link2->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->menu_descripcion->SetValue($this->DataSource->menu_descripcion->GetValue());
                $this->menu_title->SetValue($this->DataSource->menu_title->GetValue());
                $this->menu_link->SetValue($this->DataSource->menu_link->GetValue());
                $this->menu_orden->SetValue($this->DataSource->menu_orden->GetValue());
                $this->Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "menu_idp", $this->DataSource->f("menu_id"));
                $this->Link2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->Link2->Parameters = CCAddParam($this->Link2->Parameters, "menu_idp", $this->DataSource->f("menu_id"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->menu_descripcion->Show();
                $this->menu_title->Show();
                $this->menu_link->Show();
                $this->menu_orden->Show();
                $this->Link1->Show();
                $this->Link2->Show();
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
        $this->Sorter_menu_descripcion->Show();
        $this->Sorter_menu_title->Show();
        $this->Sorter_menu_link->Show();
        $this->Sorter_menu_orden->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @5-07EB972D
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->menu_descripcion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->menu_title->Errors->ToString());
        $errors = ComposeStrings($errors, $this->menu_link->Errors->ToString());
        $errors = ComposeStrings($errors, $this->menu_orden->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End menu Class @5-FCB6E20C

class clsmenuDataSource extends clsDBtdf_nuevo {  //menuDataSource Class @5-79E6EE62

//DataSource Variables @5-856DD3FA
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $menu_descripcion;
    public $menu_title;
    public $menu_link;
    public $menu_orden;
//End DataSource Variables

//DataSourceClass_Initialize Event @5-EA257FB4
    function clsmenuDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid menu";
        $this->Initialize();
        $this->menu_descripcion = new clsField("menu_descripcion", ccsText, "");
        
        $this->menu_title = new clsField("menu_title", ccsText, "");
        
        $this->menu_link = new clsField("menu_link", ccsText, "");
        
        $this->menu_orden = new clsField("menu_orden", ccsInteger, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @5-6F7DF293
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "menu_orden";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_menu_descripcion" => array("menu_descripcion", ""), 
            "Sorter_menu_title" => array("menu_title", ""), 
            "Sorter_menu_link" => array("menu_link", ""), 
            "Sorter_menu_orden" => array("menu_orden", "")));
    }
//End SetOrder Method

//Prepare Method @5-6E14C32D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlmenu_parent_id", ccsInteger, "", "", $this->Parameters["urlmenu_parent_id"], "", true);
        $this->wp->Criterion[1] = $this->wp->Operation(opIsNull, "menu_parent_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),true);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @5-5995FDDD
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM menu";
        $this->SQL = "SELECT * \n\n" .
        "FROM menu {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @5-258EBC77
    function SetValues()
    {
        $this->menu_descripcion->SetDBValue($this->f("menu_descripcion"));
        $this->menu_title->SetDBValue($this->f("menu_title"));
        $this->menu_link->SetDBValue($this->f("menu_link"));
        $this->menu_orden->SetDBValue(trim($this->f("menu_orden")));
    }
//End SetValues Method

} //End menuDataSource Class @5-FCB6E20C

class clsRecordmenu3 { //menu3 Class @51-B9F3933A

//Variables @51-9E315808

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

//Class_Initialize Event @51-0428FD24
    function clsRecordmenu3($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record menu3/Error";
        $this->DataSource = new clsmenu3DataSource($this);
        $this->ds = & $this->DataSource;
        $this->ReadAllowed = true;
        $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
        if($this->Visible)
        {
            $this->ReadAllowed = $this->ReadAllowed && CCUserInGroups(CCGetGroupID(), "1;2");
            $this->InsertAllowed = CCUserInGroups(CCGetGroupID(), "2");
            $this->UpdateAllowed = CCUserInGroups(CCGetGroupID(), "2");
            $this->DeleteAllowed = CCUserInGroups(CCGetGroupID(), "2");
            $this->ComponentName = "menu3";
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
            $this->menu_descripcion = new clsControl(ccsTextBox, "menu_descripcion", "Descripcion", ccsText, "", CCGetRequestParam("menu_descripcion", $Method, NULL), $this);
            $this->menu_descripcion->Required = true;
            $this->menu_title = new clsControl(ccsTextBox, "menu_title", "Title", ccsText, "", CCGetRequestParam("menu_title", $Method, NULL), $this);
            $this->menu_link = new clsControl(ccsTextBox, "menu_link", "Link", ccsText, "", CCGetRequestParam("menu_link", $Method, NULL), $this);
            $this->menu_link->Required = true;
            $this->menu_orden = new clsControl(ccsTextBox, "menu_orden", "Orden", ccsInteger, "", CCGetRequestParam("menu_orden", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @51-14BCDD93
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlmenu_idp"] = CCGetFromGet("menu_idp", NULL);
    }
//End Initialize Method

//Validate Method @51-1C0A7A7C
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->menu_descripcion->Validate() && $Validation);
        $Validation = ($this->menu_title->Validate() && $Validation);
        $Validation = ($this->menu_link->Validate() && $Validation);
        $Validation = ($this->menu_orden->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->menu_descripcion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->menu_title->Errors->Count() == 0);
        $Validation =  $Validation && ($this->menu_link->Errors->Count() == 0);
        $Validation =  $Validation && ($this->menu_orden->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @51-782FF786
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->menu_descripcion->Errors->Count());
        $errors = ($errors || $this->menu_title->Errors->Count());
        $errors = ($errors || $this->menu_link->Errors->Count());
        $errors = ($errors || $this->menu_orden->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @51-ED598703
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

//Operation Method @51-1F98B87A
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
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Delete" && $this->DeleteAllowed) {
            $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "menu_idp"));
            if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete) || !$this->DeleteRow()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_Cancel") {
            $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "menu_idp"));
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Insert" && $this->InsertAllowed) {
                $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "menu_idp"));
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_Update" && $this->UpdateAllowed) {
                $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "menu_idp"));
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

//InsertRow Method @51-780531C7
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->menu_descripcion->SetValue($this->menu_descripcion->GetValue(true));
        $this->DataSource->menu_title->SetValue($this->menu_title->GetValue(true));
        $this->DataSource->menu_link->SetValue($this->menu_link->GetValue(true));
        $this->DataSource->menu_orden->SetValue($this->menu_orden->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @51-A35E9B6D
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->menu_descripcion->SetValue($this->menu_descripcion->GetValue(true));
        $this->DataSource->menu_title->SetValue($this->menu_title->GetValue(true));
        $this->DataSource->menu_link->SetValue($this->menu_link->GetValue(true));
        $this->DataSource->menu_orden->SetValue($this->menu_orden->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @51-299D98C3
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @51-5F027F6C
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
                    $this->menu_descripcion->SetValue($this->DataSource->menu_descripcion->GetValue());
                    $this->menu_title->SetValue($this->DataSource->menu_title->GetValue());
                    $this->menu_link->SetValue($this->DataSource->menu_link->GetValue());
                    $this->menu_orden->SetValue($this->DataSource->menu_orden->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->menu_descripcion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->menu_title->Errors->ToString());
            $Error = ComposeStrings($Error, $this->menu_link->Errors->ToString());
            $Error = ComposeStrings($Error, $this->menu_orden->Errors->ToString());
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
        $this->Button_Delete->Show();
        $this->Button_Cancel->Show();
        $this->menu_descripcion->Show();
        $this->menu_title->Show();
        $this->menu_link->Show();
        $this->menu_orden->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End menu3 Class @51-FCB6E20C

class clsmenu3DataSource extends clsDBtdf_nuevo {  //menu3DataSource Class @51-B47A06CF

//DataSource Variables @51-5B653B79
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
    public $menu_descripcion;
    public $menu_title;
    public $menu_link;
    public $menu_orden;
//End DataSource Variables

//DataSourceClass_Initialize Event @51-7E468A76
    function clsmenu3DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record menu3/Error";
        $this->Initialize();
        $this->menu_descripcion = new clsField("menu_descripcion", ccsText, "");
        
        $this->menu_title = new clsField("menu_title", ccsText, "");
        
        $this->menu_link = new clsField("menu_link", ccsText, "");
        
        $this->menu_orden = new clsField("menu_orden", ccsInteger, "");
        

        $this->InsertFields["menu_descripcion"] = array("Name" => "menu_descripcion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["menu_title"] = array("Name" => "menu_title", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["menu_link"] = array("Name" => "menu_link", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["menu_orden"] = array("Name" => "menu_orden", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["menu_descripcion"] = array("Name" => "menu_descripcion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["menu_title"] = array("Name" => "menu_title", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["menu_link"] = array("Name" => "menu_link", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["menu_orden"] = array("Name" => "menu_orden", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @51-08C91BAB
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlmenu_idp", ccsInteger, "", "", $this->Parameters["urlmenu_idp"], "", true);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "menu_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),true);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @51-F70C27CE
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM menu {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @51-258EBC77
    function SetValues()
    {
        $this->menu_descripcion->SetDBValue($this->f("menu_descripcion"));
        $this->menu_title->SetDBValue($this->f("menu_title"));
        $this->menu_link->SetDBValue($this->f("menu_link"));
        $this->menu_orden->SetDBValue(trim($this->f("menu_orden")));
    }
//End SetValues Method

//Insert Method @51-690B934A
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["menu_descripcion"]["Value"] = $this->menu_descripcion->GetDBValue(true);
        $this->InsertFields["menu_title"]["Value"] = $this->menu_title->GetDBValue(true);
        $this->InsertFields["menu_link"]["Value"] = $this->menu_link->GetDBValue(true);
        $this->InsertFields["menu_orden"]["Value"] = $this->menu_orden->GetDBValue(true);
        $this->SQL = CCBuildInsert("menu", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @51-E60C4514
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["menu_descripcion"]["Value"] = $this->menu_descripcion->GetDBValue(true);
        $this->UpdateFields["menu_title"]["Value"] = $this->menu_title->GetDBValue(true);
        $this->UpdateFields["menu_link"]["Value"] = $this->menu_link->GetDBValue(true);
        $this->UpdateFields["menu_orden"]["Value"] = $this->menu_orden->GetDBValue(true);
        $this->SQL = CCBuildUpdate("menu", $this->UpdateFields, $this);
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

//Delete Method @51-7215BC2C
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM menu";
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

} //End menu3DataSource Class @51-FCB6E20C

//Initialize Page @1-C79033C1
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
$TemplateFileName = "paginas.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-6D0E74AC
include_once("./paginas_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-F4B4253D
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
$menu1 = new clsGridmenu1("", $MainPage);
$menu2 = new clsRecordmenu2("", $MainPage);
$menu = new clsGridmenu("", $MainPage);
$menu3 = new clsRecordmenu3("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->menu1 = & $menu1;
$MainPage->menu2 = & $menu2;
$MainPage->menu = & $menu;
$MainPage->menu3 = & $menu3;
$menu1->Initialize();
$menu2->Initialize();
$menu->Initialize();
$menu3->Initialize();

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

//Execute Components @1-DC906F96
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
$menu2->Operation();
$menu3->Operation();
//End Execute Components

//Go to destination page @1-5A1AE07A
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
    unset($menu1);
    unset($menu2);
    unset($menu);
    unset($menu3);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-1EAA1FBC
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$menu1->Show();
$menu2->Show();
$menu->Show();
$menu3->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", strrev(">retnec/<>tnof/<>llams/<.oi;001#&;711#&t;38#&>-- CCS --!< ;101#&;301#&;411#&;79#&h;76#&e;001#&;111#&;76#&>-- SCC --!< h;611#&iw>-- CCS --!< ;001#&eta;411#&ene;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", strrev(">retnec/<>tnof/<>llams/<.oi;001#&;711#&t;38#&>-- CCS --!< ;101#&;301#&;411#&;79#&h;76#&e;001#&;111#&;76#&>-- SCC --!< h;611#&iw>-- CCS --!< ;001#&eta;411#&ene;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= strrev(">retnec/<>tnof/<>llams/<.oi;001#&;711#&t;38#&>-- CCS --!< ;101#&;301#&;411#&;79#&h;76#&e;001#&;111#&;76#&>-- SCC --!< h;611#&iw>-- CCS --!< ;001#&eta;411#&ene;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-5A4651A5
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($menu1);
unset($menu2);
unset($menu);
unset($menu3);
unset($Tpl);
//End Unload Page


?>
