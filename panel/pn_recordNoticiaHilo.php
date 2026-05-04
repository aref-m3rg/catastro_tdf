<?php
//Include Common Files @1-679567E2
define("RelativePath", "..");
define("PathToCurrentPage", "/panel/");
define("FileName", "pn_recordNoticiaHilo.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @31-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @32-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @33-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

class clsGridnoticias_noticias_categor { //noticias_noticias_categor class @2-8B686606

//Variables @2-6E51DF5A

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
//End Variables

//Class_Initialize Event @2-67B4681E
    function clsGridnoticias_noticias_categor($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "noticias_noticias_categor";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid noticias_noticias_categor";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsnoticias_noticias_categorDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 2;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 2)
            $this->PageSize = 2;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->usuario_nombre = new clsControl(ccsLabel, "usuario_nombre", "usuario_nombre", ccsText, "", CCGetRequestParam("usuario_nombre", ccsGet, NULL), $this);
        $this->noticias_fecha = new clsControl(ccsLabel, "noticias_fecha", "noticias_fecha", ccsDate, array("dd", "/", "mm", "/", "yy", " ", "H", ":", "nn"), CCGetRequestParam("noticias_fecha", ccsGet, NULL), $this);
        $this->noti_cat_abrev = new clsControl(ccsLabel, "noti_cat_abrev", "noti_cat_abrev", ccsText, "", CCGetRequestParam("noti_cat_abrev", ccsGet, NULL), $this);
        $this->noti_cat_icono = new clsControl(ccsImage, "noti_cat_icono", "noti_cat_icono", ccsText, "", CCGetRequestParam("noti_cat_icono", ccsGet, NULL), $this);
        $this->noticia_id = new clsControl(ccsLabel, "noticia_id", "noticia_id", ccsInteger, "", CCGetRequestParam("noticia_id", ccsGet, NULL), $this);
        $this->noticias_asunto = new clsControl(ccsLabel, "noticias_asunto", "noticias_asunto", ccsText, "", CCGetRequestParam("noticias_asunto", ccsGet, NULL), $this);
        $this->noticias_texto = new clsControl(ccsLabel, "noticias_texto", "noticias_texto", ccsText, "", CCGetRequestParam("noticias_texto", ccsGet, NULL), $this);
        $this->noticias_texto->HTML = true;
        $this->ImageLink1 = new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", CCGetRequestParam("ImageLink1", ccsGet, NULL), $this);
        $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("noticia_id", "ccsForm"));
        $this->ImageLink1->Page = "pn_inicio.php";
    }
//End Class_Initialize Event

//Initialize Method @2-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @2-7D1AA32E
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlnoticia_id"] = CCGetFromGet("noticia_id", NULL);

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
            $this->ControlsVisible["usuario_nombre"] = $this->usuario_nombre->Visible;
            $this->ControlsVisible["noticias_fecha"] = $this->noticias_fecha->Visible;
            $this->ControlsVisible["noti_cat_abrev"] = $this->noti_cat_abrev->Visible;
            $this->ControlsVisible["noti_cat_icono"] = $this->noti_cat_icono->Visible;
            $this->ControlsVisible["noticia_id"] = $this->noticia_id->Visible;
            $this->ControlsVisible["noticias_asunto"] = $this->noticias_asunto->Visible;
            $this->ControlsVisible["noticias_texto"] = $this->noticias_texto->Visible;
            $this->ControlsVisible["ImageLink1"] = $this->ImageLink1->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->usuario_nombre->SetValue($this->DataSource->usuario_nombre->GetValue());
                $this->noticias_fecha->SetValue($this->DataSource->noticias_fecha->GetValue());
                $this->noti_cat_abrev->SetValue($this->DataSource->noti_cat_abrev->GetValue());
                $this->noti_cat_icono->SetValue($this->DataSource->noti_cat_icono->GetValue());
                $this->noticia_id->SetValue($this->DataSource->noticia_id->GetValue());
                $this->noticias_asunto->SetValue($this->DataSource->noticias_asunto->GetValue());
                $this->noticias_texto->SetValue($this->DataSource->noticias_texto->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->usuario_nombre->Show();
                $this->noticias_fecha->Show();
                $this->noti_cat_abrev->Show();
                $this->noti_cat_icono->Show();
                $this->noticia_id->Show();
                $this->noticias_asunto->Show();
                $this->noticias_texto->Show();
                $this->ImageLink1->Show();
                $Tpl->block_path = $ParentPath . "/" . $GridBlock;
                $Tpl->parse("Row", true);
            }
        }

        $errors = $this->GetErrors();
        if(strlen($errors))
        {
            $Tpl->replaceblock("", $errors);
            $Tpl->block_path = $ParentPath;
            return;
        }
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @2-C89BDE99
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->usuario_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->noticias_fecha->Errors->ToString());
        $errors = ComposeStrings($errors, $this->noti_cat_abrev->Errors->ToString());
        $errors = ComposeStrings($errors, $this->noti_cat_icono->Errors->ToString());
        $errors = ComposeStrings($errors, $this->noticia_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->noticias_asunto->Errors->ToString());
        $errors = ComposeStrings($errors, $this->noticias_texto->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ImageLink1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End noticias_noticias_categor Class @2-FCB6E20C

class clsnoticias_noticias_categorDataSource extends clsDBtdf_nuevo {  //noticias_noticias_categorDataSource Class @2-E685C8BA

//DataSource Variables @2-CF4F8151
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $usuario_nombre;
    public $noticias_fecha;
    public $noti_cat_abrev;
    public $noti_cat_icono;
    public $noticia_id;
    public $noticias_asunto;
    public $noticias_texto;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-42662467
    function clsnoticias_noticias_categorDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid noticias_noticias_categor";
        $this->Initialize();
        $this->usuario_nombre = new clsField("usuario_nombre", ccsText, "");
        
        $this->noticias_fecha = new clsField("noticias_fecha", ccsDate, $this->DateFormat);
        
        $this->noti_cat_abrev = new clsField("noti_cat_abrev", ccsText, "");
        
        $this->noti_cat_icono = new clsField("noti_cat_icono", ccsText, "");
        
        $this->noticia_id = new clsField("noticia_id", ccsInteger, "");
        
        $this->noticias_asunto = new clsField("noticias_asunto", ccsText, "");
        
        $this->noticias_texto = new clsField("noticias_texto", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-F0AA685A
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlnoticia_id", ccsInteger, "", "", $this->Parameters["urlnoticia_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "noticias.noticia_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-9FE3315E
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (noticias INNER JOIN noticias_categoria ON\n\n" .
        "noticias.noti_cat_id = noticias_categoria.noti_cat_id) INNER JOIN _usuarios ON\n\n" .
        "noticias.usuario_id = _usuarios.usuario_id";
        $this->SQL = "SELECT noticias_texto AS noticias_texto, noticias_fecha, noti_cat_icono, noti_cat_abrev, noti_cat_descr, noticias_asunto, noticia_id,\n\n" .
        "_usuarios.usuario_id AS _usuarios_usuario_id, usuario_nombre \n\n" .
        "FROM (noticias INNER JOIN noticias_categoria ON\n\n" .
        "noticias.noti_cat_id = noticias_categoria.noti_cat_id) INNER JOIN _usuarios ON\n\n" .
        "noticias.usuario_id = _usuarios.usuario_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-6936E117
    function SetValues()
    {
        $this->usuario_nombre->SetDBValue($this->f("usuario_nombre"));
        $this->noticias_fecha->SetDBValue(trim($this->f("noticias_fecha")));
        $this->noti_cat_abrev->SetDBValue($this->f("noti_cat_descr"));
        $this->noti_cat_icono->SetDBValue($this->f("noti_cat_icono"));
        $this->noticia_id->SetDBValue(trim($this->f("noticia_id")));
        $this->noticias_asunto->SetDBValue($this->f("noticias_asunto"));
        $this->noticias_texto->SetDBValue($this->f("noticias_texto"));
    }
//End SetValues Method

} //End noticias_noticias_categorDataSource Class @2-FCB6E20C

class clsRecordhilo { //hilo Class @36-D3B594F4

//Variables @36-9E315808

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

//Class_Initialize Event @36-32D83657
    function clsRecordhilo($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record hilo/Error";
        $this->DataSource = new clshiloDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "hilo";
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
            $this->noti_hilo_texto = new clsControl(ccsTextArea, "noti_hilo_texto", "Texto", ccsText, "", CCGetRequestParam("noti_hilo_texto", $Method, NULL), $this);
            $this->noti_hilo_texto->Required = true;
            $this->not_h_est_id = new clsControl(ccsListBox, "not_h_est_id", "Estado", ccsInteger, "", CCGetRequestParam("not_h_est_id", $Method, NULL), $this);
            $this->not_h_est_id->DSType = dsTable;
            $this->not_h_est_id->DataSource = new clsDBtdf_nuevo();
            $this->not_h_est_id->ds = & $this->not_h_est_id->DataSource;
            $this->not_h_est_id->DataSource->SQL = "SELECT * \n" .
"FROM noticias_h_estados {SQL_Where} {SQL_OrderBy}";
            $this->not_h_est_id->DataSource->Order = "not_h_orden";
            list($this->not_h_est_id->BoundColumn, $this->not_h_est_id->TextColumn, $this->not_h_est_id->DBFormat) = array("not_h_est_id", "not_h_desc", "");
            $this->not_h_est_id->DataSource->Parameters["expr53"] = 1;
            $this->not_h_est_id->DataSource->wp = new clsSQLParameters();
            $this->not_h_est_id->DataSource->wp->AddParameter("1", "expr53", ccsInteger, "", "", $this->not_h_est_id->DataSource->Parameters["expr53"], "", false);
            $this->not_h_est_id->DataSource->wp->Criterion[1] = $this->not_h_est_id->DataSource->wp->Operation(opEqual, "not_h_seg", $this->not_h_est_id->DataSource->wp->GetDBValue("1"), $this->not_h_est_id->DataSource->ToSQL($this->not_h_est_id->DataSource->wp->GetDBValue("1"), ccsInteger),false);
            $this->not_h_est_id->DataSource->Where = 
                 $this->not_h_est_id->DataSource->wp->Criterion[1];
            $this->not_h_est_id->DataSource->Order = "not_h_orden";
            $this->not_h_est_id->Required = true;
        }
    }
//End Class_Initialize Event

//Initialize Method @36-E946FA45
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlnoti_hilo_id"] = CCGetFromGet("noti_hilo_id", NULL);
    }
//End Initialize Method

//Validate Method @36-3F5B8D19
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->noti_hilo_texto->Validate() && $Validation);
        $Validation = ($this->not_h_est_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->noti_hilo_texto->Errors->Count() == 0);
        $Validation =  $Validation && ($this->not_h_est_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @36-33DA7288
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->noti_hilo_texto->Errors->Count());
        $errors = ($errors || $this->not_h_est_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @36-ED598703
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

//Operation Method @36-E955BD63
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

//InsertRow Method @36-CB09C7AF
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->noti_hilo_texto->SetValue($this->noti_hilo_texto->GetValue(true));
        $this->DataSource->not_h_est_id->SetValue($this->not_h_est_id->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @36-C04196EE
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->noti_hilo_texto->SetValue($this->noti_hilo_texto->GetValue(true));
        $this->DataSource->not_h_est_id->SetValue($this->not_h_est_id->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @36-41D7B71A
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

        $this->not_h_est_id->Prepare();

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
                    $this->noti_hilo_texto->SetValue($this->DataSource->noti_hilo_texto->GetValue());
                    $this->not_h_est_id->SetValue($this->DataSource->not_h_est_id->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->noti_hilo_texto->Errors->ToString());
            $Error = ComposeStrings($Error, $this->not_h_est_id->Errors->ToString());
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
        $this->noti_hilo_texto->Show();
        $this->not_h_est_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End hilo Class @36-FCB6E20C

class clshiloDataSource extends clsDBtdf_nuevo {  //hiloDataSource Class @36-07D69126

//DataSource Variables @36-0BF3C11F
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
    public $noti_hilo_texto;
    public $not_h_est_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @36-758F8AFC
    function clshiloDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record hilo/Error";
        $this->Initialize();
        $this->noti_hilo_texto = new clsField("noti_hilo_texto", ccsText, "");
        
        $this->not_h_est_id = new clsField("not_h_est_id", ccsInteger, "");
        

        $this->InsertFields["noti_hilo_texto"] = array("Name" => "noti_hilo_texto", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["noticia_id"] = array("Name" => "noticia_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["usuario_id"] = array("Name" => "usuario_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["noti_hilo_fecha"] = array("Name" => "noti_hilo_fecha", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["not_h_est_id"] = array("Name" => "not_h_est_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["noti_hilo_texto"] = array("Name" => "noti_hilo_texto", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["not_h_est_id"] = array("Name" => "not_h_est_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @36-FFB643D5
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlnoti_hilo_id", ccsInteger, "", "", $this->Parameters["urlnoti_hilo_id"], -1, false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "noti_hilo_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @36-8066B739
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM noticias_hilos {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @36-B701962C
    function SetValues()
    {
        $this->noti_hilo_texto->SetDBValue($this->f("noti_hilo_texto"));
        $this->not_h_est_id->SetDBValue(trim($this->f("not_h_est_id")));
    }
//End SetValues Method

//Insert Method @36-22C8CEE0
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["noti_hilo_texto"] = new clsSQLParameter("ctrlnoti_hilo_texto", ccsText, "", "", $this->noti_hilo_texto->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["noticia_id"] = new clsSQLParameter("urlnoticia_id", ccsInteger, "", "", CCGetFromGet("noticia_id", NULL), NULL, false, $this->ErrorBlock);
        $this->cp["usuario_id"] = new clsSQLParameter("expr45", ccsInteger, "", "", CCGetUserID(), NULL, false, $this->ErrorBlock);
        $this->cp["noti_hilo_fecha"] = new clsSQLParameter("expr46", ccsText, "", "", date('Y-m-d H:i:s'), NULL, false, $this->ErrorBlock);
        $this->cp["not_h_est_id"] = new clsSQLParameter("ctrlnot_h_est_id", ccsInteger, "", "", $this->not_h_est_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        if (!is_null($this->cp["noti_hilo_texto"]->GetValue()) and !strlen($this->cp["noti_hilo_texto"]->GetText()) and !is_bool($this->cp["noti_hilo_texto"]->GetValue())) 
            $this->cp["noti_hilo_texto"]->SetValue($this->noti_hilo_texto->GetValue(true));
        if (!is_null($this->cp["noticia_id"]->GetValue()) and !strlen($this->cp["noticia_id"]->GetText()) and !is_bool($this->cp["noticia_id"]->GetValue())) 
            $this->cp["noticia_id"]->SetText(CCGetFromGet("noticia_id", NULL));
        if (!is_null($this->cp["usuario_id"]->GetValue()) and !strlen($this->cp["usuario_id"]->GetText()) and !is_bool($this->cp["usuario_id"]->GetValue())) 
            $this->cp["usuario_id"]->SetValue(CCGetUserID());
        if (!is_null($this->cp["noti_hilo_fecha"]->GetValue()) and !strlen($this->cp["noti_hilo_fecha"]->GetText()) and !is_bool($this->cp["noti_hilo_fecha"]->GetValue())) 
            $this->cp["noti_hilo_fecha"]->SetValue(date('Y-m-d H:i:s'));
        if (!is_null($this->cp["not_h_est_id"]->GetValue()) and !strlen($this->cp["not_h_est_id"]->GetText()) and !is_bool($this->cp["not_h_est_id"]->GetValue())) 
            $this->cp["not_h_est_id"]->SetValue($this->not_h_est_id->GetValue(true));
        $this->InsertFields["noti_hilo_texto"]["Value"] = $this->cp["noti_hilo_texto"]->GetDBValue(true);
        $this->InsertFields["noticia_id"]["Value"] = $this->cp["noticia_id"]->GetDBValue(true);
        $this->InsertFields["usuario_id"]["Value"] = $this->cp["usuario_id"]->GetDBValue(true);
        $this->InsertFields["noti_hilo_fecha"]["Value"] = $this->cp["noti_hilo_fecha"]->GetDBValue(true);
        $this->InsertFields["not_h_est_id"]["Value"] = $this->cp["not_h_est_id"]->GetDBValue(true);
        $this->SQL = CCBuildInsert("noticias_hilos", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @36-F815A5B8
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["noti_hilo_texto"]["Value"] = $this->noti_hilo_texto->GetDBValue(true);
        $this->UpdateFields["not_h_est_id"]["Value"] = $this->not_h_est_id->GetDBValue(true);
        $this->SQL = CCBuildUpdate("noticias_hilos", $this->UpdateFields, $this);
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

} //End hiloDataSource Class @36-FCB6E20C

//Initialize Page @1-4841E01F
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
$TemplateFileName = "pn_recordNoticiaHilo.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-136DC916
include_once("./pn_recordNoticiaHilo_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-726D7BF6
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
$noticias_noticias_categor = new clsGridnoticias_noticias_categor("", $MainPage);
$iframe = new clsControl(ccsLabel, "iframe", "iframe", ccsText, "", CCGetRequestParam("iframe", ccsGet, NULL), $MainPage);
$iframe->HTML = true;
$hilo = new clsRecordhilo("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->noticias_noticias_categor = & $noticias_noticias_categor;
$MainPage->iframe = & $iframe;
$MainPage->hilo = & $hilo;
$noticias_noticias_categor->Initialize();
$hilo->Initialize();

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

//Execute Components @1-A6174E7B
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
$hilo->Operation();
//End Execute Components

//Go to destination page @1-AC4D264E
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
    unset($noticias_noticias_categor);
    unset($hilo);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-7D772B99
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$noticias_noticias_categor->Show();
$hilo->Show();
$iframe->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", implode(array("<center><font face=\"Ar", "ial\"><small>&#71;&#101", ";n&#101;r&#97;&#1", "16;ed <!-- SCC --", ">&#119;&#105;&#11", "6;h <!-- CCS -->&", "#67;&#111;d&#101;&#67", ";&#104;arg&#101; <!-- ", "SCC -->Studio.</smal", "l></font></center>"), "") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", implode(array("<center><font face=\"Ar", "ial\"><small>&#71;&#101", ";n&#101;r&#97;&#1", "16;ed <!-- SCC --", ">&#119;&#105;&#11", "6;h <!-- CCS -->&", "#67;&#111;d&#101;&#67", ";&#104;arg&#101; <!-- ", "SCC -->Studio.</smal", "l></font></center>"), "") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= implode(array("<center><font face=\"Ar", "ial\"><small>&#71;&#101", ";n&#101;r&#97;&#1", "16;ed <!-- SCC --", ">&#119;&#105;&#11", "6;h <!-- CCS -->&", "#67;&#111;d&#101;&#67", ";&#104;arg&#101; <!-- ", "SCC -->Studio.</smal", "l></font></center>"), "");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-75AEB570
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($noticias_noticias_categor);
unset($hilo);
unset($Tpl);
//End Unload Page


?>
