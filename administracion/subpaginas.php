<?php
//Include Common Files @1-00C96666
define("RelativePath", "..");
define("PathToCurrentPage", "/administracion/");
define("FileName", "subpaginas.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridmenu_menus_visibles { //menu_menus_visibles class @6-D563504E

//Variables @6-C6F34866

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
    public $Sorter_menu_visible_abrev;
    public $Sorter_menu_orden;
//End Variables

//Class_Initialize Event @6-BA42C9D8
    function clsGridmenu_menus_visibles($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "menu_menus_visibles";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid menu_menus_visibles";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsmenu_menus_visiblesDataSource($this);
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
        $this->SorterName = CCGetParam("menu_menus_visiblesOrder", "");
        $this->SorterDirection = CCGetParam("menu_menus_visiblesDir", "");

        $this->menu_descripcion = new clsControl(ccsLink, "menu_descripcion", "menu_descripcion", ccsText, "", CCGetRequestParam("menu_descripcion", ccsGet, NULL), $this);
        $this->menu_descripcion->Page = "subpaginas.php";
        $this->menu_title = new clsControl(ccsLabel, "menu_title", "menu_title", ccsText, "", CCGetRequestParam("menu_title", ccsGet, NULL), $this);
        $this->menu_visible_abrev = new clsControl(ccsLabel, "menu_visible_abrev", "menu_visible_abrev", ccsText, "", CCGetRequestParam("menu_visible_abrev", ccsGet, NULL), $this);
        $this->menu_orden = new clsControl(ccsLabel, "menu_orden", "menu_orden", ccsInteger, "", CCGetRequestParam("menu_orden", ccsGet, NULL), $this);
        $this->menu_menus_visibles_Insert = new clsControl(ccsLink, "menu_menus_visibles_Insert", "menu_menus_visibles_Insert", ccsText, "", CCGetRequestParam("menu_menus_visibles_Insert", ccsGet, NULL), $this);
        $this->menu_menus_visibles_Insert->Parameters = CCGetQueryString("QueryString", array("menu_id", "ccsForm"));
        $this->menu_menus_visibles_Insert->Page = "subpaginas.php";
        $this->Sorter_menu_descripcion = new clsSorter($this->ComponentName, "Sorter_menu_descripcion", $FileName, $this);
        $this->Sorter_menu_title = new clsSorter($this->ComponentName, "Sorter_menu_title", $FileName, $this);
        $this->Sorter_menu_visible_abrev = new clsSorter($this->ComponentName, "Sorter_menu_visible_abrev", $FileName, $this);
        $this->Sorter_menu_orden = new clsSorter($this->ComponentName, "Sorter_menu_orden", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
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

//Show Method @6-3D15F76B
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlmenu_p_id"] = CCGetFromGet("menu_p_id", NULL);

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
            $this->ControlsVisible["menu_visible_abrev"] = $this->menu_visible_abrev->Visible;
            $this->ControlsVisible["menu_orden"] = $this->menu_orden->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->menu_descripcion->SetValue($this->DataSource->menu_descripcion->GetValue());
                $this->menu_descripcion->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->menu_descripcion->Parameters = CCAddParam($this->menu_descripcion->Parameters, "menu_id", $this->DataSource->f("menu_id"));
                $this->menu_title->SetValue($this->DataSource->menu_title->GetValue());
                $this->menu_visible_abrev->SetValue($this->DataSource->menu_visible_abrev->GetValue());
                $this->menu_orden->SetValue($this->DataSource->menu_orden->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->menu_descripcion->Show();
                $this->menu_title->Show();
                $this->menu_visible_abrev->Show();
                $this->menu_orden->Show();
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
        $this->menu_menus_visibles_Insert->Show();
        $this->Sorter_menu_descripcion->Show();
        $this->Sorter_menu_title->Show();
        $this->Sorter_menu_visible_abrev->Show();
        $this->Sorter_menu_orden->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @6-EBA79218
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->menu_descripcion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->menu_title->Errors->ToString());
        $errors = ComposeStrings($errors, $this->menu_visible_abrev->Errors->ToString());
        $errors = ComposeStrings($errors, $this->menu_orden->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End menu_menus_visibles Class @6-FCB6E20C

class clsmenu_menus_visiblesDataSource extends clsDBtdf_nuevo {  //menu_menus_visiblesDataSource Class @6-75619A7C

//DataSource Variables @6-0ADFF3BD
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
    public $menu_visible_abrev;
    public $menu_orden;
//End DataSource Variables

//DataSourceClass_Initialize Event @6-57AE7555
    function clsmenu_menus_visiblesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid menu_menus_visibles";
        $this->Initialize();
        $this->menu_descripcion = new clsField("menu_descripcion", ccsText, "");
        
        $this->menu_title = new clsField("menu_title", ccsText, "");
        
        $this->menu_visible_abrev = new clsField("menu_visible_abrev", ccsText, "");
        
        $this->menu_orden = new clsField("menu_orden", ccsInteger, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @6-43B9B693
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_menu_descripcion" => array("menu_descripcion", ""), 
            "Sorter_menu_title" => array("menu_title", ""), 
            "Sorter_menu_visible_abrev" => array("menu_visible_abrev", ""), 
            "Sorter_menu_orden" => array("menu_orden", "")));
    }
//End SetOrder Method

//Prepare Method @6-E4F2852E
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlmenu_p_id", ccsInteger, "", "", $this->Parameters["urlmenu_p_id"], -1, false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "menu.menu_parent_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @6-9B89D28B
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM menu INNER JOIN menus_visibles ON\n\n" .
        "menu.menu_visible_id = menus_visibles.menu_visible_id";
        $this->SQL = "SELECT menu_id, menu_descripcion, menu_title, menu_visible_abrev, menu_orden \n\n" .
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

//SetValues Method @6-EEF3C390
    function SetValues()
    {
        $this->menu_descripcion->SetDBValue($this->f("menu_descripcion"));
        $this->menu_title->SetDBValue($this->f("menu_title"));
        $this->menu_visible_abrev->SetDBValue($this->f("menu_visible_abrev"));
        $this->menu_orden->SetDBValue(trim($this->f("menu_orden")));
    }
//End SetValues Method

} //End menu_menus_visiblesDataSource Class @6-FCB6E20C

class clsRecordmenu { //menu Class @27-E22A8A89

//Variables @27-9E315808

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

//Class_Initialize Event @27-DA500064
    function clsRecordmenu($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record menu/Error";
        $this->DataSource = new clsmenuDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "menu";
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
            $this->menu_visible_id = new clsControl(ccsListBox, "menu_visible_id", "Visible Id", ccsInteger, "", CCGetRequestParam("menu_visible_id", $Method, NULL), $this);
            $this->menu_visible_id->DSType = dsTable;
            $this->menu_visible_id->DataSource = new clsDBtdf_nuevo();
            $this->menu_visible_id->ds = & $this->menu_visible_id->DataSource;
            $this->menu_visible_id->DataSource->SQL = "SELECT * \n" .
"FROM menus_visibles {SQL_Where} {SQL_OrderBy}";
            list($this->menu_visible_id->BoundColumn, $this->menu_visible_id->TextColumn, $this->menu_visible_id->DBFormat) = array("menu_visible_id", "menu_visible_abrev", "");
            $this->Button1 = new clsButton("Button1", $Method, $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @27-9D9A0FA6
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlmenu_id"] = CCGetFromGet("menu_id", NULL);
    }
//End Initialize Method

//Validate Method @27-BC802211
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->menu_descripcion->Validate() && $Validation);
        $Validation = ($this->menu_title->Validate() && $Validation);
        $Validation = ($this->menu_link->Validate() && $Validation);
        $Validation = ($this->menu_orden->Validate() && $Validation);
        $Validation = ($this->menu_visible_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->menu_descripcion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->menu_title->Errors->Count() == 0);
        $Validation =  $Validation && ($this->menu_link->Errors->Count() == 0);
        $Validation =  $Validation && ($this->menu_orden->Errors->Count() == 0);
        $Validation =  $Validation && ($this->menu_visible_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @27-6DAFAD53
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->menu_descripcion->Errors->Count());
        $errors = ($errors || $this->menu_title->Errors->Count());
        $errors = ($errors || $this->menu_link->Errors->Count());
        $errors = ($errors || $this->menu_orden->Errors->Count());
        $errors = ($errors || $this->menu_visible_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @27-ED598703
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

//Operation Method @27-5B8176F5
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
            } else if($this->Button1->Pressed) {
                $this->PressedButton = "Button1";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Delete") {
            if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete) || !$this->DeleteRow()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_Cancel") {
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
            } else if($this->PressedButton == "Button1") {
                if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
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

//InsertRow Method @27-6B27007F
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->menu_descripcion->SetValue($this->menu_descripcion->GetValue(true));
        $this->DataSource->menu_title->SetValue($this->menu_title->GetValue(true));
        $this->DataSource->menu_link->SetValue($this->menu_link->GetValue(true));
        $this->DataSource->menu_orden->SetValue($this->menu_orden->GetValue(true));
        $this->DataSource->menu_visible_id->SetValue($this->menu_visible_id->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @27-D8FFFC8A
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->menu_descripcion->SetValue($this->menu_descripcion->GetValue(true));
        $this->DataSource->menu_title->SetValue($this->menu_title->GetValue(true));
        $this->DataSource->menu_link->SetValue($this->menu_link->GetValue(true));
        $this->DataSource->menu_orden->SetValue($this->menu_orden->GetValue(true));
        $this->DataSource->menu_visible_id->SetValue($this->menu_visible_id->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @27-299D98C3
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @27-9139F08C
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

        $this->menu_visible_id->Prepare();

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
                    $this->menu_visible_id->SetValue($this->DataSource->menu_visible_id->GetValue());
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
            $Error = ComposeStrings($Error, $this->menu_visible_id->Errors->ToString());
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
        $this->menu_visible_id->Show();
        $this->Button1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End menu Class @27-FCB6E20C

class clsmenuDataSource extends clsDBtdf_nuevo {  //menuDataSource Class @27-79E6EE62

//DataSource Variables @27-FB36DB81
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
    public $menu_visible_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @27-862C1F00
    function clsmenuDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record menu/Error";
        $this->Initialize();
        $this->menu_descripcion = new clsField("menu_descripcion", ccsText, "");
        
        $this->menu_title = new clsField("menu_title", ccsText, "");
        
        $this->menu_link = new clsField("menu_link", ccsText, "");
        
        $this->menu_orden = new clsField("menu_orden", ccsInteger, "");
        
        $this->menu_visible_id = new clsField("menu_visible_id", ccsInteger, "");
        

        $this->InsertFields["menu_descripcion"] = array("Name" => "menu_descripcion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["menu_title"] = array("Name" => "menu_title", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["menu_link"] = array("Name" => "menu_link", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["menu_orden"] = array("Name" => "menu_orden", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["menu_visible_id"] = array("Name" => "menu_visible_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["menu_parent_id"] = array("Name" => "menu_parent_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["menu_descripcion"] = array("Name" => "menu_descripcion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["menu_title"] = array("Name" => "menu_title", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["menu_link"] = array("Name" => "menu_link", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["menu_orden"] = array("Name" => "menu_orden", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["menu_visible_id"] = array("Name" => "menu_visible_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @27-540571B6
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlmenu_id", ccsInteger, "", "", $this->Parameters["urlmenu_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "menu_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @27-F70C27CE
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

//SetValues Method @27-F46D5D18
    function SetValues()
    {
        $this->menu_descripcion->SetDBValue($this->f("menu_descripcion"));
        $this->menu_title->SetDBValue($this->f("menu_title"));
        $this->menu_link->SetDBValue($this->f("menu_link"));
        $this->menu_orden->SetDBValue(trim($this->f("menu_orden")));
        $this->menu_visible_id->SetDBValue(trim($this->f("menu_visible_id")));
    }
//End SetValues Method

//Insert Method @27-20281DA3
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["menu_descripcion"] = new clsSQLParameter("ctrlmenu_descripcion", ccsText, "", "", $this->menu_descripcion->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["menu_title"] = new clsSQLParameter("ctrlmenu_title", ccsText, "", "", $this->menu_title->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["menu_link"] = new clsSQLParameter("ctrlmenu_link", ccsText, "", "", $this->menu_link->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["menu_orden"] = new clsSQLParameter("ctrlmenu_orden", ccsInteger, "", "", $this->menu_orden->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["menu_visible_id"] = new clsSQLParameter("ctrlmenu_visible_id", ccsInteger, "", "", $this->menu_visible_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["menu_parent_id"] = new clsSQLParameter("urlmenu_p_id", ccsInteger, "", "", CCGetFromGet("menu_p_id", NULL), NULL, false, $this->ErrorBlock);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        if (!is_null($this->cp["menu_descripcion"]->GetValue()) and !strlen($this->cp["menu_descripcion"]->GetText()) and !is_bool($this->cp["menu_descripcion"]->GetValue())) 
            $this->cp["menu_descripcion"]->SetValue($this->menu_descripcion->GetValue(true));
        if (!is_null($this->cp["menu_title"]->GetValue()) and !strlen($this->cp["menu_title"]->GetText()) and !is_bool($this->cp["menu_title"]->GetValue())) 
            $this->cp["menu_title"]->SetValue($this->menu_title->GetValue(true));
        if (!is_null($this->cp["menu_link"]->GetValue()) and !strlen($this->cp["menu_link"]->GetText()) and !is_bool($this->cp["menu_link"]->GetValue())) 
            $this->cp["menu_link"]->SetValue($this->menu_link->GetValue(true));
        if (!is_null($this->cp["menu_orden"]->GetValue()) and !strlen($this->cp["menu_orden"]->GetText()) and !is_bool($this->cp["menu_orden"]->GetValue())) 
            $this->cp["menu_orden"]->SetValue($this->menu_orden->GetValue(true));
        if (!is_null($this->cp["menu_visible_id"]->GetValue()) and !strlen($this->cp["menu_visible_id"]->GetText()) and !is_bool($this->cp["menu_visible_id"]->GetValue())) 
            $this->cp["menu_visible_id"]->SetValue($this->menu_visible_id->GetValue(true));
        if (!is_null($this->cp["menu_parent_id"]->GetValue()) and !strlen($this->cp["menu_parent_id"]->GetText()) and !is_bool($this->cp["menu_parent_id"]->GetValue())) 
            $this->cp["menu_parent_id"]->SetText(CCGetFromGet("menu_p_id", NULL));
        $this->InsertFields["menu_descripcion"]["Value"] = $this->cp["menu_descripcion"]->GetDBValue(true);
        $this->InsertFields["menu_title"]["Value"] = $this->cp["menu_title"]->GetDBValue(true);
        $this->InsertFields["menu_link"]["Value"] = $this->cp["menu_link"]->GetDBValue(true);
        $this->InsertFields["menu_orden"]["Value"] = $this->cp["menu_orden"]->GetDBValue(true);
        $this->InsertFields["menu_visible_id"]["Value"] = $this->cp["menu_visible_id"]->GetDBValue(true);
        $this->InsertFields["menu_parent_id"]["Value"] = $this->cp["menu_parent_id"]->GetDBValue(true);
        $this->SQL = CCBuildInsert("menu", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @27-A78CDD56
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
        $this->UpdateFields["menu_visible_id"]["Value"] = $this->menu_visible_id->GetDBValue(true);
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

//Delete Method @27-7215BC2C
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

} //End menuDataSource Class @27-FCB6E20C

//Include Page implementation @39-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Initialize Page @1-8D4001C3
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
$TemplateFileName = "subpaginas.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-E743C608
include_once("./subpaginas_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-5A0154BC
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$menu_menus_visibles = new clsGridmenu_menus_visibles("", $MainPage);
$menu = new clsRecordmenu("", $MainPage);
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$MainPage->menu_menus_visibles = & $menu_menus_visibles;
$MainPage->menu = & $menu;
$MainPage->tdf_footer = & $tdf_footer;
$menu_menus_visibles->Initialize();
$menu->Initialize();

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

//Execute Components @1-5D9ED024
$menu->Operation();
$tdf_footer->Operations();
//End Execute Components

//Go to destination page @1-94E4CBD2
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    unset($menu_menus_visibles);
    unset($menu);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-3474DADE
$menu_menus_visibles->Show();
$menu->Show();
$tdf_footer->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$RPRG3K6E9M7P = explode("|", "<center><font f|ace=\"Arial\"><sm|all>&#71;&#101;n&#|101;&#114;at&#101;|d <!-- SCC -->wi&#|116;h <!-- CCS -->|C&#111;d&#101;&#6|7;h&#97;r&#103|;&#101; <!-- SCC |-->S&#116;&#117;&#|100;&#105;&#111;.|</small></font></|center>|");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($RPRG3K6E9M7P,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($RPRG3K6E9M7P,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($RPRG3K6E9M7P,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-C6C35A2F
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($menu_menus_visibles);
unset($menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($Tpl);
//End Unload Page


?>
