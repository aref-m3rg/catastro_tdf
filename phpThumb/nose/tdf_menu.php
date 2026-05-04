<?php

class clsMenutdf_menuMenu1 extends clsMenu { //Menu1 class @16-25BB2247

//Class_Initialize Event @16-11A2450E
    function clsMenutdf_menuMenu1($RelativePath, & $Parent)
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
        $this->StaticItems[] = array("item_id" => "MenuItem1", "item_id_parent" => null, "item_caption" => "Inicio", "item_url" => array("Page" => $this->RelativePath . "panel/pn_inicio.php", "Parameters" => null), "item_target" => "", "item_title" => "");
        $this->StaticItems[] = array("item_id" => "MenuItem1Item1", "item_id_parent" => "MenuItem1", "item_caption" => "Cerrar Sesión", "item_url" => array("Page" => $this->RelativePath . "tdf_login.php", "Parameters" => array("Logout" => "True")), "item_target" => "", "item_title" => "Finalizar Sesión");
        $this->StaticItems[] = array("item_id" => "MenuItem1Item2", "item_id_parent" => "MenuItem1", "item_caption" => "Cambiar Password", "item_url" => array("Page" => $this->RelativePath . "panel/pn_recordPwd.php", "Parameters" => null), "item_target" => "", "item_title" => "Cambiar password de ingreso");
        $this->StaticItems[] = array("item_id" => "MenuItem9", "item_id_parent" => null, "item_caption" => "Piezas Administrativas", "item_url" => array("Page" => $this->RelativePath . "piezas/msa_principal.php", "Parameters" => null), "item_target" => "", "item_title" => "Seguimiento de Piezas");
        $this->StaticItems[] = array("item_id" => "MenuItem7", "item_id_parent" => null, "item_caption" => "Técnica", "item_url" => array("Page" => $this->RelativePath . "tecnica/tc_planosGrid.php", "Parameters" => null), "item_target" => "", "item_title" => "");
        $this->StaticItems[] = array("item_id" => "MenuItem7Item1", "item_id_parent" => "MenuItem7", "item_caption" => "Planos", "item_url" => array("Page" => $this->RelativePath . "tecnica/tc_planosGrid.php", "Parameters" => null), "item_target" => "", "item_title" => "Administración de Planos");
        $this->StaticItems[] = array("item_id" => "MenuItem7Item2", "item_id_parent" => "MenuItem7", "item_caption" => "Profesionales", "item_url" => array("Page" => $this->RelativePath . "tecnica/tc_gridProfesionales.php", "Parameters" => null), "item_target" => "", "item_title" => "Registro de Profesionales");
        $this->StaticItems[] = array("item_id" => "MenuItem2", "item_id_parent" => null, "item_caption" => "Actualizacion Catastral", "item_url" => array("Page" => $this->RelativePath . "actualizacion/ac_parcelasGrid.php", "Parameters" => null), "item_target" => "", "item_title" => "");
        $this->StaticItems[] = array("item_id" => "MenuItem2Item1", "item_id_parent" => "MenuItem2", "item_caption" => "Parcelas", "item_url" => array("Page" => $this->RelativePath . "actualizacion/ac_parcelasGrid.php", "Parameters" => null), "item_target" => "", "item_title" => "Administrar parcelas");
        $this->StaticItems[] = array("item_id" => "MenuItem2Item2", "item_id_parent" => "MenuItem2", "item_caption" => "Parámetros", "item_url" => array("Page" => $this->RelativePath . "administracion/adm_parametros.php", "Parameters" => null), "item_target" => "", "item_title" => "Administración de parámetros del sistema");
        $this->StaticItems[] = array("item_id" => "MenuItem4", "item_id_parent" => null, "item_caption" => "Cartografía", "item_url" => array("Page" => $this->RelativePath . "panel/pn_inicio.php", "Parameters" => null), "item_target" => "", "item_title" => "");
        $this->StaticItems[] = array("item_id" => "MenuItem4Item5", "item_id_parent" => "MenuItem4", "item_caption" => "Consulta Geográfica", "item_url" => array("Page" => $this->RelativePath . "cartografia/gis_geoSearch.php", "Parameters" => null), "item_target" => "", "item_title" => "Consulta Geográfica");
        $this->StaticItems[] = array("item_id" => "MenuItem4Item6", "item_id_parent" => "MenuItem4", "item_caption" => "Consulta Geográfica Alternativa", "item_url" => array("Page" => $this->RelativePath . "cartografia/gis_geoFlex.php", "Parameters" => null), "item_target" => "", "item_title" => "Consulta Geográfica");
        $this->StaticItems[] = array("item_id" => "MenuItem6", "item_id_parent" => null, "item_caption" => "Planchetas", "item_url" => array("Page" => $this->RelativePath . "planchetas/pl_planchetasGrid.php", "Parameters" => null), "item_target" => "", "item_title" => "");
        $this->StaticItems[] = array("item_id" => "MenuItem6Item1", "item_id_parent" => "MenuItem6", "item_caption" => "Planchetas", "item_url" => array("Page" => $this->RelativePath . "planchetas/pl_planchetasGrid.php", "Parameters" => null), "item_target" => "", "item_title" => "Administrar planchetas");
        $this->StaticItems[] = array("item_id" => "MenuItem8", "item_id_parent" => null, "item_caption" => "Consultas Generales", "item_url" => array("Page" => $this->RelativePath . "consultas/cg_gridParcelas.php", "Parameters" => null), "item_target" => "", "item_title" => "");
        $this->StaticItems[] = array("item_id" => "MenuItem8Item1", "item_id_parent" => "MenuItem8", "item_caption" => "Parcelas", "item_url" => array("Page" => $this->RelativePath . "consultas/cg_gridParcelas.php", "Parameters" => null), "item_target" => "", "item_title" => "Consultas de parcelas");
        $this->StaticItems[] = array("item_id" => "MenuItem8Item2", "item_id_parent" => "MenuItem8", "item_caption" => "Personas", "item_url" => array("Page" => $this->RelativePath . "consultas/cg_gridPersonas.php", "Parameters" => null), "item_target" => "", "item_title" => "Consulta de Personas");
        $this->StaticItems[] = array("item_id" => "MenuItem3", "item_id_parent" => null, "item_caption" => "Configuración", "item_url" => array("Page" => $this->RelativePath . "panel/pn_inicio.php", "Parameters" => null), "item_target" => "", "item_title" => "");
        $this->StaticItems[] = array("item_id" => "MenuItem3Item1", "item_id_parent" => "MenuItem3", "item_caption" => "Usuarios", "item_url" => array("Page" => $this->RelativePath . "administracion/adm_usuarios.php", "Parameters" => null), "item_target" => "", "item_title" => "");
        $this->StaticItems[] = array("item_id" => "MenuItem3Item2", "item_id_parent" => "MenuItem3", "item_caption" => "Areas Administrativas", "item_url" => array("Page" => $this->RelativePath . "administracion/gridUnidades.php", "Parameters" => null), "item_target" => "", "item_title" => "Administrar Areas de Piezas Administrativas");

        $this->DataSource = new clstdf_menuMenu1DataSource($this);
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

//SetControlValues Method @16-B7BF812B
    function SetControlValues() {
        $this->ItemLink->SetValue($this->DataSource->ItemLink->GetValue());
        $LinkUrl = $this->DataSource->f("item_url");
        $this->ItemLink->Page = $LinkUrl["Page"];
        $this->ItemLink->Parameters = $this->SetParamsFromDB($this->LinkStartParameters, $LinkUrl["Parameters"]);
    }
//End SetControlValues Method

//ShowAttributes @16-17684C76
    function ShowAttributes() {
        $this->Attributes->SetValue("MenuType", "menu_htb");
        $this->Attributes->Show();
    }
//End ShowAttributes

} //End Menu1 Class @16-FCB6E20C

//tdf_menuMenu1DataSource Class @16-22015A20
class clstdf_menuMenu1DataSource extends DB_Adapter {
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;
    var $wp;
    var $Record = array();
    var $Index;
    var $FieldsList = array();

    function clstdf_menuMenu1DataSource($parent) {
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
//End tdf_menuMenu1DataSource Class

class clstdf_menu { //tdf_menu class @1-53A6B7BE

//Variables @1-51D7F06F
    public $ComponentType = "IncludablePage";
    public $Connections = array();
    public $FileName = "";
    public $Redirect = "";
    public $Tpl = "";
    public $TemplateFileName = "";
    public $BlockToParse = "";
    public $ComponentName = "";
    public $Attributes = "";

    // Events;
    public $CCSEvents = "";
    public $CCSEventResult = "";
    public $RelativePath;
    public $Visible;
    public $Parent;
//End Variables

//Class_Initialize Event @1-52DB67F9
    function clstdf_menu($RelativePath, $ComponentName, & $Parent)
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = $ComponentName;
        $this->RelativePath = $RelativePath;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->FileName = "tdf_menu.php";
        $this->Redirect = "";
        $this->TemplateFileName = "tdf_menu.html";
        $this->BlockToParse = "main";
        $this->TemplateEncoding = "CP1252";
        $this->ContentType = "text/html";
    }
//End Class_Initialize Event

//Class_Terminate Event @1-D27CC112
    function Class_Terminate()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUnload", $this);
        unset($this->Menu1);
    }
//End Class_Terminate Event

//BindEvents Method @1-6C2BB472
    function BindEvents()
    {
        $this->Menu1->CCSEvents["BeforeShowRow"] = "tdf_menu_Menu1_BeforeShowRow";
        $this->CCSEvents["AfterInitialize"] = "tdf_menu_AfterInitialize";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInitialize", $this);
    }
//End BindEvents Method

//Operations Method @1-7E2A14CF
    function Operations()
    {
        global $Redirect;
        if(!$this->Visible)
            return "";
    }
//End Operations Method

//Initialize Method @1-6C86F76F
    function Initialize()
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInitialize", $this);
        if(!$this->Visible)
            return "";
        $this->Attributes = & $this->Parent->Attributes;

        // Create Components
        $this->banner = new clsControl(ccsLabel, "banner", "banner", ccsText, "", CCGetRequestParam("banner", ccsGet, NULL), $this);
        $this->banner->HTML = true;
        $this->Menu1 = new clsMenutdf_menuMenu1($this->RelativePath, $this);
        $this->banner0 = new clsControl(ccsLabel, "banner0", "banner0", ccsText, "", CCGetRequestParam("banner0", ccsGet, NULL), $this);
        $this->banner0->HTML = true;
        $this->banner2 = new clsControl(ccsLabel, "banner2", "banner2", ccsText, "", CCGetRequestParam("banner2", ccsGet, NULL), $this);
        $this->banner2->HTML = true;
        $this->BindEvents();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnInitializeView", $this);
    }
//End Initialize Method

//Show Method @1-AF2A7B2C
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        $block_path = $Tpl->block_path;
        $Tpl->LoadTemplate("/" . $this->TemplateFileName, $this->ComponentName, $this->TemplateEncoding, "remove");
        $Tpl->block_path = $Tpl->block_path . "/" . $this->ComponentName;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) {
            $Tpl->block_path = $block_path;
            $Tpl->SetVar($this->ComponentName, "");
            return "";
        }
        $this->Attributes->Show();
        $this->Menu1->Show();
        $this->banner->Show();
        $this->banner0->Show();
        $this->banner2->Show();
        $Tpl->Parse();
        $Tpl->block_path = $block_path;
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeOutput", $this);
        $Tpl->SetVar($this->ComponentName, $Tpl->GetVar($this->ComponentName));
    }
//End Show Method

} //End tdf_menu Class @1-FCB6E20C

//Include Event File @1-1ED465B6
include_once(RelativePath . "/tdf_menu_events.php");
//End Include Event File


?>
