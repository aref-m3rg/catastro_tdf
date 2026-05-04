<?php
//Include Common Files @1-4AB22D9A
define("RelativePath", "..");
define("PathToCurrentPage", "/gestion/");
define("FileName", "recordParcela.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @118-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @119-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @120-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Include Page implementation @77-6A9CF48F
include_once(RelativePath . "/gestion/footerParcela.php");
//End Include Page implementation

class clsRecordparcela { //parcela Class @2-C90D0079

//Variables @2-9E315808

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

//Class_Initialize Event @2-24D0DD01
    function clsRecordparcela($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record parcela/Error";
        $this->DataSource = new clsparcelaDataSource($this);
        $this->ds = & $this->DataSource;
        $this->ReadAllowed = true;
        $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
        if($this->Visible)
        {
            $this->ReadAllowed = $this->ReadAllowed && CCUserInGroups(CCGetGroupID(), "1;2");
            $this->InsertAllowed = CCUserInGroups(CCGetGroupID(), "2");
            $this->UpdateAllowed = CCUserInGroups(CCGetGroupID(), "2");
            $this->ComponentName = "parcela";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->parcela_sup_uf = new clsControl(ccsTextBox, "parcela_sup_uf", "parcela_sup_uf", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("parcela_sup_uf", $Method, NULL), $this);
            $this->parcela_porc_uf = new clsControl(ccsTextBox, "parcela_porc_uf", "parcela_porc_uf", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("parcela_porc_uf", $Method, NULL), $this);
            $this->destino = new clsControl(ccsLabel, "destino", "destino", ccsText, "", CCGetRequestParam("destino", $Method, NULL), $this);
            $this->destino->HTML = true;
            $this->origen = new clsControl(ccsLabel, "origen", "origen", ccsText, "", CCGetRequestParam("origen", $Method, NULL), $this);
            $this->origen->HTML = true;
            $this->parcela_rte = new clsControl(ccsTextBox, "parcela_rte", "parcela_rte", ccsText, "", CCGetRequestParam("parcela_rte", $Method, NULL), $this);
            $this->nueva = new clsControl(ccsLabel, "nueva", "nueva", ccsText, "", CCGetRequestParam("nueva", $Method, NULL), $this);
            $this->nueva->HTML = true;
            $this->tipo_parcela_id = new clsControl(ccsListBox, "tipo_parcela_id", "tipo_parcela_id", ccsText, "", CCGetRequestParam("tipo_parcela_id", $Method, NULL), $this);
            $this->tipo_parcela_id->DSType = dsTable;
            $this->tipo_parcela_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_parcela_id->ds = & $this->tipo_parcela_id->DataSource;
            $this->tipo_parcela_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_parcelas {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_parcela_id->BoundColumn, $this->tipo_parcela_id->TextColumn, $this->tipo_parcela_id->DBFormat) = array("tipo_parcela_id", "tipo_parcela_descrip", "");
            $this->tipo_est_parc_id = new clsControl(ccsListBox, "tipo_est_parc_id", "tipo_est_parc_id", ccsText, "", CCGetRequestParam("tipo_est_parc_id", $Method, NULL), $this);
            $this->tipo_est_parc_id->DSType = dsTable;
            $this->tipo_est_parc_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_est_parc_id->ds = & $this->tipo_est_parc_id->DataSource;
            $this->tipo_est_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_estados_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_est_parc_id->BoundColumn, $this->tipo_est_parc_id->TextColumn, $this->tipo_est_parc_id->DBFormat) = array("tipo_est_parc_id", "tipo_est_parc_descr", "");
            $this->tipo_parcela_uso_id = new clsControl(ccsListBox, "tipo_parcela_uso_id", "tipo_parcela_uso_id", ccsText, "", CCGetRequestParam("tipo_parcela_uso_id", $Method, NULL), $this);
            $this->tipo_parcela_uso_id->DSType = dsTable;
            $this->tipo_parcela_uso_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_parcela_uso_id->ds = & $this->tipo_parcela_uso_id->DataSource;
            $this->tipo_parcela_uso_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_parcelas_usos {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_parcela_uso_id->BoundColumn, $this->tipo_parcela_uso_id->TextColumn, $this->tipo_parcela_uso_id->DBFormat) = array("tipo_parcela_uso_id", "tipo_parcela_uso_descrip", "");
            $this->parcela_id = new clsControl(ccsHidden, "parcela_id", "parcela_id", ccsText, "", CCGetRequestParam("parcela_id", $Method, NULL), $this);
            $this->tipo_parcela_alta_id = new clsControl(ccsHidden, "tipo_parcela_alta_id", "tipo_parcela_alta_id", ccsText, "", CCGetRequestParam("tipo_parcela_alta_id", $Method, NULL), $this);
            $this->parcela_nomenclatura = new clsControl(ccsHidden, "parcela_nomenclatura", "parcela_nomenclatura", ccsText, "", CCGetRequestParam("parcela_nomenclatura", $Method, NULL), $this);
            $this->audit_string = new clsControl(ccsHidden, "audit_string", "audit_string", ccsText, "", CCGetRequestParam("audit_string", $Method, NULL), $this);
            $this->Insert_Button = new clsButton("Insert_Button", $Method, $this);
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->Button1 = new clsButton("Button1", $Method, $this);
            $this->usuario = new clsControl(ccsLabel, "usuario", "usuario", ccsText, "", CCGetRequestParam("usuario", $Method, NULL), $this);
            $this->parcela_f_proceso = new clsControl(ccsHidden, "parcela_f_proceso", "parcela_f_proceso", ccsText, "", CCGetRequestParam("parcela_f_proceso", $Method, NULL), $this);
            $this->parcela_f_proceso->Required = true;
            $this->fecha_ultima_modificacion = new clsControl(ccsLabel, "fecha_ultima_modificacion", "fecha_ultima_modificacion", ccsDate, array("GeneralDate"), CCGetRequestParam("fecha_ultima_modificacion", $Method, NULL), $this);
            $this->usuario_id = new clsControl(ccsHidden, "usuario_id", "usuario_id", ccsText, "", CCGetRequestParam("usuario_id", $Method, NULL), $this);
            $this->parcela_dist_pto = new clsControl(ccsTextBox, "parcela_dist_pto", "parcela_dist_pto", ccsFloat, "", CCGetRequestParam("parcela_dist_pto", $Method, NULL), $this);
            $this->usos_suelo = new clsControl(ccsCheckBoxList, "usos_suelo", "usos_suelo", ccsText, "", CCGetRequestParam("usos_suelo", $Method, NULL), $this);
            $this->usos_suelo->Multiple = true;
            $this->usos_suelo->DSType = dsTable;
            $this->usos_suelo->DataSource = new clsDBtdf_nuevo();
            $this->usos_suelo->ds = & $this->usos_suelo->DataSource;
            $this->usos_suelo->DataSource->SQL = "SELECT * \n" .
"FROM tipos_usos_suelo {SQL_Where} {SQL_OrderBy}";
            list($this->usos_suelo->BoundColumn, $this->usos_suelo->TextColumn, $this->usos_suelo->DBFormat) = array("tipo_uso_suelo_id", "tipo_uso_suelo_descrip", "");
            $this->usos_suelo->DataSource->Parameters["expr229"] = 1;
            $this->usos_suelo->DataSource->wp = new clsSQLParameters();
            $this->usos_suelo->DataSource->wp->AddParameter("1", "expr229", ccsInteger, "", "", $this->usos_suelo->DataSource->Parameters["expr229"], "", false);
            $this->usos_suelo->DataSource->wp->Criterion[1] = $this->usos_suelo->DataSource->wp->Operation(opEqual, "tipo_estado_id", $this->usos_suelo->DataSource->wp->GetDBValue("1"), $this->usos_suelo->DataSource->ToSQL($this->usos_suelo->DataSource->wp->GetDBValue("1"), ccsInteger),false);
            $this->usos_suelo->DataSource->Where = 
                 $this->usos_suelo->DataSource->wp->Criterion[1];
            $this->usos_suelo->HTML = true;
            $this->parcela_notas_nom = new clsControl(ccsTextArea, "parcela_notas_nom", "parcela_notas_nom", ccsMemo, "", CCGetRequestParam("parcela_notas_nom", $Method, NULL), $this);
            $this->parcela_observa = new clsControl(ccsTextArea, "parcela_observa", "Observaciones", ccsMemo, "", CCGetRequestParam("parcela_observa", $Method, NULL), $this);
            $this->tipo_depto_parcela_nw_id = new clsControl(ccsListBox, "tipo_depto_parcela_nw_id", "tipo_depto_parcela_nw_id", ccsInteger, "", CCGetRequestParam("tipo_depto_parcela_nw_id", $Method, NULL), $this);
            $this->tipo_depto_parcela_nw_id->DSType = dsTable;
            $this->tipo_depto_parcela_nw_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_depto_parcela_nw_id->ds = & $this->tipo_depto_parcela_nw_id->DataSource;
            $this->tipo_depto_parcela_nw_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_depto_parcela_nw {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_depto_parcela_nw_id->BoundColumn, $this->tipo_depto_parcela_nw_id->TextColumn, $this->tipo_depto_parcela_nw_id->DBFormat) = array("tipo_depto_parcela_nw_id", "tipo_depto_parcela_nw_cod", "");
            $this->tipo_ubica_parcela_nw_id = new clsControl(ccsListBox, "tipo_ubica_parcela_nw_id", "tipo_ubica_parcela_nw_id", ccsInteger, "", CCGetRequestParam("tipo_ubica_parcela_nw_id", $Method, NULL), $this);
            $this->tipo_ubica_parcela_nw_id->DSType = dsTable;
            $this->tipo_ubica_parcela_nw_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_ubica_parcela_nw_id->ds = & $this->tipo_ubica_parcela_nw_id->DataSource;
            $this->tipo_ubica_parcela_nw_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_ubica_parcela_nw {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_ubica_parcela_nw_id->BoundColumn, $this->tipo_ubica_parcela_nw_id->TextColumn, $this->tipo_ubica_parcela_nw_id->DBFormat) = array("tipo_ubica_parcela_nw_cod", "tipo_ubica_parcela_nw_cod", "");
            $this->tipo_secc_parcela_id = new clsControl(ccsListBox, "tipo_secc_parcela_id", "tipo_secc_parcela_id", ccsInteger, "", CCGetRequestParam("tipo_secc_parcela_id", $Method, NULL), $this);
            $this->tipo_secc_parcela_id->DSType = dsTable;
            $this->tipo_secc_parcela_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_secc_parcela_id->ds = & $this->tipo_secc_parcela_id->DataSource;
            $this->tipo_secc_parcela_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_seccion_parcela_nw {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_secc_parcela_id->BoundColumn, $this->tipo_secc_parcela_id->TextColumn, $this->tipo_secc_parcela_id->DBFormat) = array("tipo_secc_parcela_id", "tipo_secc_parcela_cod", "");
            $this->parcela_subparcela = new clsControl(ccsTextBox, "parcela_subparcela", "parcela_subparcela", ccsText, "", CCGetRequestParam("parcela_subparcela", $Method, NULL), $this);
            $this->parcela_manzana = new clsControl(ccsTextBox, "parcela_manzana", "parcela_manzana", ccsText, "", CCGetRequestParam("parcela_manzana", $Method, NULL), $this);
            $this->parcela_seccion = new clsControl(ccsTextBox, "parcela_seccion", "Seccion", ccsText, "", CCGetRequestParam("parcela_seccion", $Method, NULL), $this);
            $this->depto = new clsControl(ccsHidden, "depto", "depto", ccsText, "", CCGetRequestParam("depto", $Method, NULL), $this);
            $this->parcela_chacra = new clsControl(ccsTextBox, "parcela_chacra", "chacra", ccsText, "", CCGetRequestParam("parcela_chacra", $Method, NULL), $this);
            $this->parcela_quinta = new clsControl(ccsTextBox, "parcela_quinta", "Quinta", ccsText, "", CCGetRequestParam("parcela_quinta", $Method, NULL), $this);
            $this->parcela_macizo = new clsControl(ccsTextBox, "parcela_macizo", "Macizo", ccsText, "", CCGetRequestParam("parcela_macizo", $Method, NULL), $this);
            $this->parcela_fraccion = new clsControl(ccsTextBox, "parcela_fraccion", "Fraccion", ccsText, "", CCGetRequestParam("parcela_fraccion", $Method, NULL), $this);
            $this->parcela_parcela = new clsControl(ccsTextBox, "parcela_parcela", "Parcela", ccsText, "", CCGetRequestParam("parcela_parcela", $Method, NULL), $this);
            $this->parcela_uf = new clsControl(ccsTextBox, "parcela_uf", "parcela_uf", ccsText, "", CCGetRequestParam("parcela_uf", $Method, NULL), $this);
            $this->parcela_predio = new clsControl(ccsTextBox, "parcela_predio", "parcela_predio", ccsText, "", CCGetRequestParam("parcela_predio", $Method, NULL), $this);
            $this->parcela_coord_y = new clsControl(ccsTextBox, "parcela_coord_y", "parcela_coord_y", ccsText, "", CCGetRequestParam("parcela_coord_y", $Method, NULL), $this);
            $this->parcela_coord_x = new clsControl(ccsTextBox, "parcela_coord_x", "parcela_coord_x", ccsText, "", CCGetRequestParam("parcela_coord_x", $Method, NULL), $this);
            $this->parcela_parcela_nw = new clsControl(ccsTextBox, "parcela_parcela_nw", "parcela_parcela_nw", ccsText, "", CCGetRequestParam("parcela_parcela_nw", $Method, NULL), $this);
            $this->tipo_padron_parc_id = new clsControl(ccsListBox, "tipo_padron_parc_id", "Padron", ccsInteger, "", CCGetRequestParam("tipo_padron_parc_id", $Method, NULL), $this);
            $this->tipo_padron_parc_id->DSType = dsTable;
            $this->tipo_padron_parc_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_padron_parc_id->ds = & $this->tipo_padron_parc_id->DataSource;
            $this->tipo_padron_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_padrones_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_padron_parc_id->BoundColumn, $this->tipo_padron_parc_id->TextColumn, $this->tipo_padron_parc_id->DBFormat) = array("tipo_padron_parc_id", "tipo_padron_parc_desc", "");
            $this->tipo_depto_parc_id = new clsControl(ccsListBox, "tipo_depto_parc_id", "Depto", ccsInteger, "", CCGetRequestParam("tipo_depto_parc_id", $Method, NULL), $this);
            $this->tipo_depto_parc_id->DSType = dsTable;
            $this->tipo_depto_parc_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_depto_parc_id->ds = & $this->tipo_depto_parc_id->DataSource;
            $this->tipo_depto_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_deptos_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_depto_parc_id->BoundColumn, $this->tipo_depto_parc_id->TextColumn, $this->tipo_depto_parc_id->DBFormat) = array("tipo_depto_parc_id", "tipo_depto_parc_desc", "");
            $this->unidades_medidas_id = new clsControl(ccsListBox, "unidades_medidas_id", "unidades_medidas_id", ccsText, "", CCGetRequestParam("unidades_medidas_id", $Method, NULL), $this);
            $this->unidades_medidas_id->DSType = dsTable;
            $this->unidades_medidas_id->DataSource = new clsDBtdf_nuevo();
            $this->unidades_medidas_id->ds = & $this->unidades_medidas_id->DataSource;
            $this->unidades_medidas_id->DataSource->SQL = "SELECT * \n" .
"FROM unidades_medidas {SQL_Where} {SQL_OrderBy}";
            list($this->unidades_medidas_id->BoundColumn, $this->unidades_medidas_id->TextColumn, $this->unidades_medidas_id->DBFormat) = array("unidades_medidas_id", "unidades_medidas_abrev", "");
            $this->nomenclatura = new clsControl(ccsLabel, "nomenclatura", "nomenclatura", ccsText, "", CCGetRequestParam("nomenclatura", $Method, NULL), $this);
            $this->parcela_super_mensura = new clsControl(ccsHidden, "parcela_super_mensura", "parcela_super_mensura", ccsFloat, "", CCGetRequestParam("parcela_super_mensura", $Method, NULL), $this);
            $this->general = new clsControl(ccsTextBox, "general", "general", ccsFloat, array(False, 6, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("general", $Method, NULL), $this);
            $this->parcela_partida = new clsControl(ccsTextBox, "parcela_partida", "parcela_partida", ccsText, "", CCGetRequestParam("parcela_partida", $Method, NULL), $this);
            $this->parcela_partida->Required = true;
            $this->a = new clsControl(ccsTextBox, "a", "a", ccsText, "", CCGetRequestParam("a", $Method, NULL), $this);
            $this->ades = new clsControl(ccsTextBox, "ades", "ades", ccsText, "", CCGetRequestParam("ades", $Method, NULL), $this);
            $this->ha = new clsControl(ccsTextBox, "ha", "ha", ccsText, "", CCGetRequestParam("ha", $Method, NULL), $this);
            $this->hades = new clsControl(ccsTextBox, "hades", "hades", ccsText, "", CCGetRequestParam("hades", $Method, NULL), $this);
            $this->parcela_val_tierra_l = new clsControl(ccsLabel, "parcela_val_tierra_l", "parcela_val_tierra_l", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("parcela_val_tierra_l", $Method, NULL), $this);
            $this->parcela_val_mejora_l = new clsControl(ccsLabel, "parcela_val_mejora_l", "parcela_val_mejora_l", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("parcela_val_mejora_l", $Method, NULL), $this);
            $this->parcela_val_ampliac_l = new clsControl(ccsLabel, "parcela_val_ampliac_l", "parcela_val_ampliac_l", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("parcela_val_ampliac_l", $Method, NULL), $this);
            $this->ImageLink2 = new clsControl(ccsImageLink, "ImageLink2", "ImageLink2", ccsText, "", CCGetRequestParam("ImageLink2", $Method, NULL), $this);
            $this->ImageLink2->Page = "inscdominio.php";
            $this->tipo_instrumento_id = new clsControl(ccsHidden, "tipo_instrumento_id", "tipo_instrumento_id", ccsText, "", CCGetRequestParam("tipo_instrumento_id", $Method, NULL), $this);
            $this->parcela_instrumento = new clsControl(ccsHidden, "parcela_instrumento", "parcela_instrumento", ccsText, "", CCGetRequestParam("parcela_instrumento", $Method, NULL), $this);
            $this->ImageLink1 = new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", CCGetRequestParam("ImageLink1", $Method, NULL), $this);
            $this->ImageLink1->Page = "parcelaDocumentos.php";
            $this->cantDoc = new clsControl(ccsLabel, "cantDoc", "cantDoc", ccsText, "", CCGetRequestParam("cantDoc", $Method, NULL), $this);
            $this->cantDoc->HTML = true;
            $this->plano = new clsControl(ccsLabel, "plano", "plano", ccsText, "", CCGetRequestParam("plano", $Method, NULL), $this);
            $this->ImageLink3 = new clsControl(ccsImageLink, "ImageLink3", "ImageLink3", ccsText, "", CCGetRequestParam("ImageLink3", $Method, NULL), $this);
            $this->ImageLink3->Page = "regdominio.php";
            $this->cantReg = new clsControl(ccsLabel, "cantReg", "cantReg", ccsText, "", CCGetRequestParam("cantReg", $Method, NULL), $this);
            $this->cantReg->HTML = true;
            $this->inscripcionDominial = new clsControl(ccsLabel, "inscripcionDominial", "inscripcionDominial", ccsText, "", CCGetRequestParam("inscripcionDominial", $Method, NULL), $this);
            $this->parcela_descrip = new clsControl(ccsTextArea, "parcela_descrip", "Descripcion", ccsMemo, "", CCGetRequestParam("parcela_descrip", $Method, NULL), $this);
            $this->parcela_restr = new clsControl(ccsTextArea, "parcela_restr", "Restricciones", ccsMemo, "", CCGetRequestParam("parcela_restr", $Method, NULL), $this);
            $this->ImageLink4 = new clsControl(ccsImageLink, "ImageLink4", "ImageLink4", ccsText, "", CCGetRequestParam("ImageLink4", $Method, NULL), $this);
            $this->ImageLink4->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
            $this->ImageLink4->Page = "restricciones.php";
            $this->restricciones = new clsControl(ccsLabel, "restricciones", "restricciones", ccsText, "", CCGetRequestParam("restricciones", $Method, NULL), $this);
            $this->restricciones->HTML = true;
            $this->plancheta = new clsControl(ccsLabel, "plancheta", "plancheta", ccsText, "", CCGetRequestParam("plancheta", $Method, NULL), $this);
            $this->plancheta->HTML = true;
            $this->parcela_receptividad = new clsControl(ccsTextBox, "parcela_receptividad", "Receptividad", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("parcela_receptividad", $Method, NULL), $this);
            $this->parcela_val_tierra = new clsControl(ccsHidden, "parcela_val_tierra", "parcela_val_tierra", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("parcela_val_tierra", $Method, NULL), $this);
            $this->parcela_val_mejora = new clsControl(ccsHidden, "parcela_val_mejora", "parcela_val_mejora", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("parcela_val_mejora", $Method, NULL), $this);
            $this->parcela_val_ampliac = new clsControl(ccsHidden, "parcela_val_ampliac", "parcela_val_ampliac", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("parcela_val_ampliac", $Method, NULL), $this);
            $this->parcela_val_total = new clsControl(ccsTextBox, "parcela_val_total", "parcela_val_total", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("parcela_val_total", $Method, NULL), $this);
            $this->Button_baja = new clsButton("Button_baja", $Method, $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->usuario_id->Value) && !strlen($this->usuario_id->Value) && $this->usuario_id->Value !== false)
                    $this->usuario_id->SetText(CCGetUserID());
                if(!is_array($this->parcela_partida->Value) && !strlen($this->parcela_partida->Value) && $this->parcela_partida->Value !== false)
                    $this->parcela_partida->SetText(0);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @2-16FD92D0
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlparcela_id"] = CCGetFromGet("parcela_id", NULL);
    }
//End Initialize Method

//Validate Method @2-F100C3B2
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->parcela_sup_uf->Validate() && $Validation);
        $Validation = ($this->parcela_porc_uf->Validate() && $Validation);
        $Validation = ($this->parcela_rte->Validate() && $Validation);
        $Validation = ($this->tipo_parcela_id->Validate() && $Validation);
        $Validation = ($this->tipo_est_parc_id->Validate() && $Validation);
        $Validation = ($this->tipo_parcela_uso_id->Validate() && $Validation);
        $Validation = ($this->parcela_id->Validate() && $Validation);
        $Validation = ($this->tipo_parcela_alta_id->Validate() && $Validation);
        $Validation = ($this->parcela_nomenclatura->Validate() && $Validation);
        $Validation = ($this->audit_string->Validate() && $Validation);
        $Validation = ($this->parcela_f_proceso->Validate() && $Validation);
        $Validation = ($this->usuario_id->Validate() && $Validation);
        $Validation = ($this->parcela_dist_pto->Validate() && $Validation);
        $Validation = ($this->usos_suelo->Validate() && $Validation);
        $Validation = ($this->parcela_notas_nom->Validate() && $Validation);
        $Validation = ($this->parcela_observa->Validate() && $Validation);
        $Validation = ($this->tipo_depto_parcela_nw_id->Validate() && $Validation);
        $Validation = ($this->tipo_ubica_parcela_nw_id->Validate() && $Validation);
        $Validation = ($this->tipo_secc_parcela_id->Validate() && $Validation);
        $Validation = ($this->parcela_subparcela->Validate() && $Validation);
        $Validation = ($this->parcela_manzana->Validate() && $Validation);
        $Validation = ($this->parcela_seccion->Validate() && $Validation);
        $Validation = ($this->depto->Validate() && $Validation);
        $Validation = ($this->parcela_chacra->Validate() && $Validation);
        $Validation = ($this->parcela_quinta->Validate() && $Validation);
        $Validation = ($this->parcela_macizo->Validate() && $Validation);
        $Validation = ($this->parcela_fraccion->Validate() && $Validation);
        $Validation = ($this->parcela_parcela->Validate() && $Validation);
        $Validation = ($this->parcela_uf->Validate() && $Validation);
        $Validation = ($this->parcela_predio->Validate() && $Validation);
        $Validation = ($this->parcela_coord_y->Validate() && $Validation);
        $Validation = ($this->parcela_coord_x->Validate() && $Validation);
        $Validation = ($this->parcela_parcela_nw->Validate() && $Validation);
        $Validation = ($this->tipo_padron_parc_id->Validate() && $Validation);
        $Validation = ($this->tipo_depto_parc_id->Validate() && $Validation);
        $Validation = ($this->unidades_medidas_id->Validate() && $Validation);
        $Validation = ($this->parcela_super_mensura->Validate() && $Validation);
        $Validation = ($this->general->Validate() && $Validation);
        $Validation = ($this->parcela_partida->Validate() && $Validation);
        $Validation = ($this->a->Validate() && $Validation);
        $Validation = ($this->ades->Validate() && $Validation);
        $Validation = ($this->ha->Validate() && $Validation);
        $Validation = ($this->hades->Validate() && $Validation);
        $Validation = ($this->tipo_instrumento_id->Validate() && $Validation);
        $Validation = ($this->parcela_instrumento->Validate() && $Validation);
        $Validation = ($this->parcela_descrip->Validate() && $Validation);
        $Validation = ($this->parcela_restr->Validate() && $Validation);
        $Validation = ($this->parcela_receptividad->Validate() && $Validation);
        $Validation = ($this->parcela_val_tierra->Validate() && $Validation);
        $Validation = ($this->parcela_val_mejora->Validate() && $Validation);
        $Validation = ($this->parcela_val_ampliac->Validate() && $Validation);
        $Validation = ($this->parcela_val_total->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->parcela_sup_uf->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_porc_uf->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_rte->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_parcela_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_est_parc_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_parcela_uso_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_parcela_alta_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_nomenclatura->Errors->Count() == 0);
        $Validation =  $Validation && ($this->audit_string->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_f_proceso->Errors->Count() == 0);
        $Validation =  $Validation && ($this->usuario_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_dist_pto->Errors->Count() == 0);
        $Validation =  $Validation && ($this->usos_suelo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_notas_nom->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_observa->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_depto_parcela_nw_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_ubica_parcela_nw_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_secc_parcela_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_subparcela->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_manzana->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_seccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->depto->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_chacra->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_quinta->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_macizo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_fraccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_parcela->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_uf->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_predio->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_coord_y->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_coord_x->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_parcela_nw->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_padron_parc_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_depto_parc_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->unidades_medidas_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_super_mensura->Errors->Count() == 0);
        $Validation =  $Validation && ($this->general->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_partida->Errors->Count() == 0);
        $Validation =  $Validation && ($this->a->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ades->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ha->Errors->Count() == 0);
        $Validation =  $Validation && ($this->hades->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_instrumento_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_instrumento->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_descrip->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_restr->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_receptividad->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_val_tierra->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_val_mejora->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_val_ampliac->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_val_total->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-410906A1
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->parcela_sup_uf->Errors->Count());
        $errors = ($errors || $this->parcela_porc_uf->Errors->Count());
        $errors = ($errors || $this->destino->Errors->Count());
        $errors = ($errors || $this->origen->Errors->Count());
        $errors = ($errors || $this->parcela_rte->Errors->Count());
        $errors = ($errors || $this->nueva->Errors->Count());
        $errors = ($errors || $this->tipo_parcela_id->Errors->Count());
        $errors = ($errors || $this->tipo_est_parc_id->Errors->Count());
        $errors = ($errors || $this->tipo_parcela_uso_id->Errors->Count());
        $errors = ($errors || $this->parcela_id->Errors->Count());
        $errors = ($errors || $this->tipo_parcela_alta_id->Errors->Count());
        $errors = ($errors || $this->parcela_nomenclatura->Errors->Count());
        $errors = ($errors || $this->audit_string->Errors->Count());
        $errors = ($errors || $this->usuario->Errors->Count());
        $errors = ($errors || $this->parcela_f_proceso->Errors->Count());
        $errors = ($errors || $this->fecha_ultima_modificacion->Errors->Count());
        $errors = ($errors || $this->usuario_id->Errors->Count());
        $errors = ($errors || $this->parcela_dist_pto->Errors->Count());
        $errors = ($errors || $this->usos_suelo->Errors->Count());
        $errors = ($errors || $this->parcela_notas_nom->Errors->Count());
        $errors = ($errors || $this->parcela_observa->Errors->Count());
        $errors = ($errors || $this->tipo_depto_parcela_nw_id->Errors->Count());
        $errors = ($errors || $this->tipo_ubica_parcela_nw_id->Errors->Count());
        $errors = ($errors || $this->tipo_secc_parcela_id->Errors->Count());
        $errors = ($errors || $this->parcela_subparcela->Errors->Count());
        $errors = ($errors || $this->parcela_manzana->Errors->Count());
        $errors = ($errors || $this->parcela_seccion->Errors->Count());
        $errors = ($errors || $this->depto->Errors->Count());
        $errors = ($errors || $this->parcela_chacra->Errors->Count());
        $errors = ($errors || $this->parcela_quinta->Errors->Count());
        $errors = ($errors || $this->parcela_macizo->Errors->Count());
        $errors = ($errors || $this->parcela_fraccion->Errors->Count());
        $errors = ($errors || $this->parcela_parcela->Errors->Count());
        $errors = ($errors || $this->parcela_uf->Errors->Count());
        $errors = ($errors || $this->parcela_predio->Errors->Count());
        $errors = ($errors || $this->parcela_coord_y->Errors->Count());
        $errors = ($errors || $this->parcela_coord_x->Errors->Count());
        $errors = ($errors || $this->parcela_parcela_nw->Errors->Count());
        $errors = ($errors || $this->tipo_padron_parc_id->Errors->Count());
        $errors = ($errors || $this->tipo_depto_parc_id->Errors->Count());
        $errors = ($errors || $this->unidades_medidas_id->Errors->Count());
        $errors = ($errors || $this->nomenclatura->Errors->Count());
        $errors = ($errors || $this->parcela_super_mensura->Errors->Count());
        $errors = ($errors || $this->general->Errors->Count());
        $errors = ($errors || $this->parcela_partida->Errors->Count());
        $errors = ($errors || $this->a->Errors->Count());
        $errors = ($errors || $this->ades->Errors->Count());
        $errors = ($errors || $this->ha->Errors->Count());
        $errors = ($errors || $this->hades->Errors->Count());
        $errors = ($errors || $this->parcela_val_tierra_l->Errors->Count());
        $errors = ($errors || $this->parcela_val_mejora_l->Errors->Count());
        $errors = ($errors || $this->parcela_val_ampliac_l->Errors->Count());
        $errors = ($errors || $this->ImageLink2->Errors->Count());
        $errors = ($errors || $this->tipo_instrumento_id->Errors->Count());
        $errors = ($errors || $this->parcela_instrumento->Errors->Count());
        $errors = ($errors || $this->ImageLink1->Errors->Count());
        $errors = ($errors || $this->cantDoc->Errors->Count());
        $errors = ($errors || $this->plano->Errors->Count());
        $errors = ($errors || $this->ImageLink3->Errors->Count());
        $errors = ($errors || $this->cantReg->Errors->Count());
        $errors = ($errors || $this->inscripcionDominial->Errors->Count());
        $errors = ($errors || $this->parcela_descrip->Errors->Count());
        $errors = ($errors || $this->parcela_restr->Errors->Count());
        $errors = ($errors || $this->ImageLink4->Errors->Count());
        $errors = ($errors || $this->restricciones->Errors->Count());
        $errors = ($errors || $this->plancheta->Errors->Count());
        $errors = ($errors || $this->parcela_receptividad->Errors->Count());
        $errors = ($errors || $this->parcela_val_tierra->Errors->Count());
        $errors = ($errors || $this->parcela_val_mejora->Errors->Count());
        $errors = ($errors || $this->parcela_val_ampliac->Errors->Count());
        $errors = ($errors || $this->parcela_val_total->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @2-ED598703
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

//Operation Method @2-33DCB728
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
            $this->PressedButton = $this->EditMode ? "Button_Update" : "Insert_Button";
            if($this->Insert_Button->Pressed) {
                $this->PressedButton = "Insert_Button";
            } else if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            } else if($this->Button1->Pressed) {
                $this->PressedButton = "Button1";
            } else if($this->Button_baja->Pressed) {
                $this->PressedButton = "Button_baja";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button1") {
            $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "calcular", "new"));
            if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_baja") {
            if(!CCGetEvent($this->Button_baja->CCSEvents, "OnClick", $this->Button_baja)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Insert_Button" && $this->InsertAllowed) {
                if(!CCGetEvent($this->Insert_Button->CCSEvents, "OnClick", $this->Insert_Button) || !$this->InsertRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_Update" && $this->UpdateAllowed) {
                $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "calcular", "new"));
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

//InsertRow Method @2-FD3FF7B3
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->parcela_sup_uf->SetValue($this->parcela_sup_uf->GetValue(true));
        $this->DataSource->parcela_porc_uf->SetValue($this->parcela_porc_uf->GetValue(true));
        $this->DataSource->destino->SetValue($this->destino->GetValue(true));
        $this->DataSource->origen->SetValue($this->origen->GetValue(true));
        $this->DataSource->parcela_rte->SetValue($this->parcela_rte->GetValue(true));
        $this->DataSource->nueva->SetValue($this->nueva->GetValue(true));
        $this->DataSource->tipo_parcela_id->SetValue($this->tipo_parcela_id->GetValue(true));
        $this->DataSource->tipo_est_parc_id->SetValue($this->tipo_est_parc_id->GetValue(true));
        $this->DataSource->tipo_parcela_uso_id->SetValue($this->tipo_parcela_uso_id->GetValue(true));
        $this->DataSource->parcela_id->SetValue($this->parcela_id->GetValue(true));
        $this->DataSource->tipo_parcela_alta_id->SetValue($this->tipo_parcela_alta_id->GetValue(true));
        $this->DataSource->parcela_nomenclatura->SetValue($this->parcela_nomenclatura->GetValue(true));
        $this->DataSource->audit_string->SetValue($this->audit_string->GetValue(true));
        $this->DataSource->usuario->SetValue($this->usuario->GetValue(true));
        $this->DataSource->parcela_f_proceso->SetValue($this->parcela_f_proceso->GetValue(true));
        $this->DataSource->fecha_ultima_modificacion->SetValue($this->fecha_ultima_modificacion->GetValue(true));
        $this->DataSource->usuario_id->SetValue($this->usuario_id->GetValue(true));
        $this->DataSource->parcela_dist_pto->SetValue($this->parcela_dist_pto->GetValue(true));
        $this->DataSource->usos_suelo->SetValue($this->usos_suelo->GetValue(true));
        $this->DataSource->parcela_notas_nom->SetValue($this->parcela_notas_nom->GetValue(true));
        $this->DataSource->parcela_observa->SetValue($this->parcela_observa->GetValue(true));
        $this->DataSource->tipo_depto_parcela_nw_id->SetValue($this->tipo_depto_parcela_nw_id->GetValue(true));
        $this->DataSource->tipo_ubica_parcela_nw_id->SetValue($this->tipo_ubica_parcela_nw_id->GetValue(true));
        $this->DataSource->tipo_secc_parcela_id->SetValue($this->tipo_secc_parcela_id->GetValue(true));
        $this->DataSource->parcela_subparcela->SetValue($this->parcela_subparcela->GetValue(true));
        $this->DataSource->parcela_manzana->SetValue($this->parcela_manzana->GetValue(true));
        $this->DataSource->parcela_seccion->SetValue($this->parcela_seccion->GetValue(true));
        $this->DataSource->depto->SetValue($this->depto->GetValue(true));
        $this->DataSource->parcela_chacra->SetValue($this->parcela_chacra->GetValue(true));
        $this->DataSource->parcela_quinta->SetValue($this->parcela_quinta->GetValue(true));
        $this->DataSource->parcela_macizo->SetValue($this->parcela_macizo->GetValue(true));
        $this->DataSource->parcela_fraccion->SetValue($this->parcela_fraccion->GetValue(true));
        $this->DataSource->parcela_parcela->SetValue($this->parcela_parcela->GetValue(true));
        $this->DataSource->parcela_uf->SetValue($this->parcela_uf->GetValue(true));
        $this->DataSource->parcela_predio->SetValue($this->parcela_predio->GetValue(true));
        $this->DataSource->parcela_coord_y->SetValue($this->parcela_coord_y->GetValue(true));
        $this->DataSource->parcela_coord_x->SetValue($this->parcela_coord_x->GetValue(true));
        $this->DataSource->parcela_parcela_nw->SetValue($this->parcela_parcela_nw->GetValue(true));
        $this->DataSource->tipo_padron_parc_id->SetValue($this->tipo_padron_parc_id->GetValue(true));
        $this->DataSource->tipo_depto_parc_id->SetValue($this->tipo_depto_parc_id->GetValue(true));
        $this->DataSource->unidades_medidas_id->SetValue($this->unidades_medidas_id->GetValue(true));
        $this->DataSource->nomenclatura->SetValue($this->nomenclatura->GetValue(true));
        $this->DataSource->parcela_super_mensura->SetValue($this->parcela_super_mensura->GetValue(true));
        $this->DataSource->general->SetValue($this->general->GetValue(true));
        $this->DataSource->parcela_partida->SetValue($this->parcela_partida->GetValue(true));
        $this->DataSource->a->SetValue($this->a->GetValue(true));
        $this->DataSource->ades->SetValue($this->ades->GetValue(true));
        $this->DataSource->ha->SetValue($this->ha->GetValue(true));
        $this->DataSource->hades->SetValue($this->hades->GetValue(true));
        $this->DataSource->parcela_val_tierra_l->SetValue($this->parcela_val_tierra_l->GetValue(true));
        $this->DataSource->parcela_val_mejora_l->SetValue($this->parcela_val_mejora_l->GetValue(true));
        $this->DataSource->parcela_val_ampliac_l->SetValue($this->parcela_val_ampliac_l->GetValue(true));
        $this->DataSource->ImageLink2->SetValue($this->ImageLink2->GetValue(true));
        $this->DataSource->tipo_instrumento_id->SetValue($this->tipo_instrumento_id->GetValue(true));
        $this->DataSource->parcela_instrumento->SetValue($this->parcela_instrumento->GetValue(true));
        $this->DataSource->ImageLink1->SetValue($this->ImageLink1->GetValue(true));
        $this->DataSource->cantDoc->SetValue($this->cantDoc->GetValue(true));
        $this->DataSource->plano->SetValue($this->plano->GetValue(true));
        $this->DataSource->ImageLink3->SetValue($this->ImageLink3->GetValue(true));
        $this->DataSource->cantReg->SetValue($this->cantReg->GetValue(true));
        $this->DataSource->inscripcionDominial->SetValue($this->inscripcionDominial->GetValue(true));
        $this->DataSource->parcela_descrip->SetValue($this->parcela_descrip->GetValue(true));
        $this->DataSource->parcela_restr->SetValue($this->parcela_restr->GetValue(true));
        $this->DataSource->ImageLink4->SetValue($this->ImageLink4->GetValue(true));
        $this->DataSource->restricciones->SetValue($this->restricciones->GetValue(true));
        $this->DataSource->plancheta->SetValue($this->plancheta->GetValue(true));
        $this->DataSource->parcela_receptividad->SetValue($this->parcela_receptividad->GetValue(true));
        $this->DataSource->parcela_val_tierra->SetValue($this->parcela_val_tierra->GetValue(true));
        $this->DataSource->parcela_val_mejora->SetValue($this->parcela_val_mejora->GetValue(true));
        $this->DataSource->parcela_val_ampliac->SetValue($this->parcela_val_ampliac->GetValue(true));
        $this->DataSource->parcela_val_total->SetValue($this->parcela_val_total->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @2-034F9142
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->parcela_sup_uf->SetValue($this->parcela_sup_uf->GetValue(true));
        $this->DataSource->parcela_porc_uf->SetValue($this->parcela_porc_uf->GetValue(true));
        $this->DataSource->destino->SetValue($this->destino->GetValue(true));
        $this->DataSource->origen->SetValue($this->origen->GetValue(true));
        $this->DataSource->parcela_rte->SetValue($this->parcela_rte->GetValue(true));
        $this->DataSource->nueva->SetValue($this->nueva->GetValue(true));
        $this->DataSource->tipo_parcela_id->SetValue($this->tipo_parcela_id->GetValue(true));
        $this->DataSource->tipo_est_parc_id->SetValue($this->tipo_est_parc_id->GetValue(true));
        $this->DataSource->tipo_parcela_uso_id->SetValue($this->tipo_parcela_uso_id->GetValue(true));
        $this->DataSource->parcela_id->SetValue($this->parcela_id->GetValue(true));
        $this->DataSource->tipo_parcela_alta_id->SetValue($this->tipo_parcela_alta_id->GetValue(true));
        $this->DataSource->parcela_nomenclatura->SetValue($this->parcela_nomenclatura->GetValue(true));
        $this->DataSource->audit_string->SetValue($this->audit_string->GetValue(true));
        $this->DataSource->usuario->SetValue($this->usuario->GetValue(true));
        $this->DataSource->parcela_f_proceso->SetValue($this->parcela_f_proceso->GetValue(true));
        $this->DataSource->fecha_ultima_modificacion->SetValue($this->fecha_ultima_modificacion->GetValue(true));
        $this->DataSource->usuario_id->SetValue($this->usuario_id->GetValue(true));
        $this->DataSource->parcela_dist_pto->SetValue($this->parcela_dist_pto->GetValue(true));
        $this->DataSource->usos_suelo->SetValue($this->usos_suelo->GetValue(true));
        $this->DataSource->parcela_notas_nom->SetValue($this->parcela_notas_nom->GetValue(true));
        $this->DataSource->parcela_observa->SetValue($this->parcela_observa->GetValue(true));
        $this->DataSource->tipo_depto_parcela_nw_id->SetValue($this->tipo_depto_parcela_nw_id->GetValue(true));
        $this->DataSource->tipo_ubica_parcela_nw_id->SetValue($this->tipo_ubica_parcela_nw_id->GetValue(true));
        $this->DataSource->tipo_secc_parcela_id->SetValue($this->tipo_secc_parcela_id->GetValue(true));
        $this->DataSource->parcela_subparcela->SetValue($this->parcela_subparcela->GetValue(true));
        $this->DataSource->parcela_manzana->SetValue($this->parcela_manzana->GetValue(true));
        $this->DataSource->parcela_seccion->SetValue($this->parcela_seccion->GetValue(true));
        $this->DataSource->depto->SetValue($this->depto->GetValue(true));
        $this->DataSource->parcela_chacra->SetValue($this->parcela_chacra->GetValue(true));
        $this->DataSource->parcela_quinta->SetValue($this->parcela_quinta->GetValue(true));
        $this->DataSource->parcela_macizo->SetValue($this->parcela_macizo->GetValue(true));
        $this->DataSource->parcela_fraccion->SetValue($this->parcela_fraccion->GetValue(true));
        $this->DataSource->parcela_parcela->SetValue($this->parcela_parcela->GetValue(true));
        $this->DataSource->parcela_uf->SetValue($this->parcela_uf->GetValue(true));
        $this->DataSource->parcela_predio->SetValue($this->parcela_predio->GetValue(true));
        $this->DataSource->parcela_coord_y->SetValue($this->parcela_coord_y->GetValue(true));
        $this->DataSource->parcela_coord_x->SetValue($this->parcela_coord_x->GetValue(true));
        $this->DataSource->parcela_parcela_nw->SetValue($this->parcela_parcela_nw->GetValue(true));
        $this->DataSource->tipo_padron_parc_id->SetValue($this->tipo_padron_parc_id->GetValue(true));
        $this->DataSource->tipo_depto_parc_id->SetValue($this->tipo_depto_parc_id->GetValue(true));
        $this->DataSource->unidades_medidas_id->SetValue($this->unidades_medidas_id->GetValue(true));
        $this->DataSource->nomenclatura->SetValue($this->nomenclatura->GetValue(true));
        $this->DataSource->parcela_super_mensura->SetValue($this->parcela_super_mensura->GetValue(true));
        $this->DataSource->general->SetValue($this->general->GetValue(true));
        $this->DataSource->parcela_partida->SetValue($this->parcela_partida->GetValue(true));
        $this->DataSource->a->SetValue($this->a->GetValue(true));
        $this->DataSource->ades->SetValue($this->ades->GetValue(true));
        $this->DataSource->ha->SetValue($this->ha->GetValue(true));
        $this->DataSource->hades->SetValue($this->hades->GetValue(true));
        $this->DataSource->parcela_val_tierra_l->SetValue($this->parcela_val_tierra_l->GetValue(true));
        $this->DataSource->parcela_val_mejora_l->SetValue($this->parcela_val_mejora_l->GetValue(true));
        $this->DataSource->parcela_val_ampliac_l->SetValue($this->parcela_val_ampliac_l->GetValue(true));
        $this->DataSource->ImageLink2->SetValue($this->ImageLink2->GetValue(true));
        $this->DataSource->tipo_instrumento_id->SetValue($this->tipo_instrumento_id->GetValue(true));
        $this->DataSource->parcela_instrumento->SetValue($this->parcela_instrumento->GetValue(true));
        $this->DataSource->ImageLink1->SetValue($this->ImageLink1->GetValue(true));
        $this->DataSource->cantDoc->SetValue($this->cantDoc->GetValue(true));
        $this->DataSource->plano->SetValue($this->plano->GetValue(true));
        $this->DataSource->ImageLink3->SetValue($this->ImageLink3->GetValue(true));
        $this->DataSource->cantReg->SetValue($this->cantReg->GetValue(true));
        $this->DataSource->inscripcionDominial->SetValue($this->inscripcionDominial->GetValue(true));
        $this->DataSource->parcela_descrip->SetValue($this->parcela_descrip->GetValue(true));
        $this->DataSource->parcela_restr->SetValue($this->parcela_restr->GetValue(true));
        $this->DataSource->ImageLink4->SetValue($this->ImageLink4->GetValue(true));
        $this->DataSource->restricciones->SetValue($this->restricciones->GetValue(true));
        $this->DataSource->plancheta->SetValue($this->plancheta->GetValue(true));
        $this->DataSource->parcela_receptividad->SetValue($this->parcela_receptividad->GetValue(true));
        $this->DataSource->parcela_val_tierra->SetValue($this->parcela_val_tierra->GetValue(true));
        $this->DataSource->parcela_val_mejora->SetValue($this->parcela_val_mejora->GetValue(true));
        $this->DataSource->parcela_val_ampliac->SetValue($this->parcela_val_ampliac->GetValue(true));
        $this->DataSource->parcela_val_total->SetValue($this->parcela_val_total->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @2-09C1FCE6
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

        $this->tipo_parcela_id->Prepare();
        $this->tipo_est_parc_id->Prepare();
        $this->tipo_parcela_uso_id->Prepare();
        $this->usos_suelo->Prepare();
        $this->tipo_depto_parcela_nw_id->Prepare();
        $this->tipo_ubica_parcela_nw_id->Prepare();
        $this->tipo_secc_parcela_id->Prepare();
        $this->tipo_padron_parc_id->Prepare();
        $this->tipo_depto_parc_id->Prepare();
        $this->unidades_medidas_id->Prepare();

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
                $this->fecha_ultima_modificacion->SetValue($this->DataSource->fecha_ultima_modificacion->GetValue());
                $this->nomenclatura->SetValue($this->DataSource->nomenclatura->GetValue());
                $this->parcela_val_tierra_l->SetValue($this->DataSource->parcela_val_tierra_l->GetValue());
                $this->parcela_val_mejora_l->SetValue($this->DataSource->parcela_val_mejora_l->GetValue());
                $this->parcela_val_ampliac_l->SetValue($this->DataSource->parcela_val_ampliac_l->GetValue());
                if(!$this->FormSubmitted){
                    $this->parcela_sup_uf->SetValue($this->DataSource->parcela_sup_uf->GetValue());
                    $this->parcela_porc_uf->SetValue($this->DataSource->parcela_porc_uf->GetValue());
                    $this->parcela_rte->SetValue($this->DataSource->parcela_rte->GetValue());
                    $this->tipo_parcela_id->SetValue($this->DataSource->tipo_parcela_id->GetValue());
                    $this->tipo_est_parc_id->SetValue($this->DataSource->tipo_est_parc_id->GetValue());
                    $this->tipo_parcela_uso_id->SetValue($this->DataSource->tipo_parcela_uso_id->GetValue());
                    $this->parcela_id->SetValue($this->DataSource->parcela_id->GetValue());
                    $this->tipo_parcela_alta_id->SetValue($this->DataSource->tipo_parcela_alta_id->GetValue());
                    $this->parcela_nomenclatura->SetValue($this->DataSource->parcela_nomenclatura->GetValue());
                    $this->audit_string->SetValue($this->DataSource->audit_string->GetValue());
                    $this->parcela_f_proceso->SetValue($this->DataSource->parcela_f_proceso->GetValue());
                    $this->usuario_id->SetValue($this->DataSource->usuario_id->GetValue());
                    $this->parcela_dist_pto->SetValue($this->DataSource->parcela_dist_pto->GetValue());
                    $this->parcela_notas_nom->SetValue($this->DataSource->parcela_notas_nom->GetValue());
                    $this->parcela_observa->SetValue($this->DataSource->parcela_observa->GetValue());
                    $this->tipo_depto_parcela_nw_id->SetValue($this->DataSource->tipo_depto_parcela_nw_id->GetValue());
                    $this->tipo_secc_parcela_id->SetValue($this->DataSource->tipo_secc_parcela_id->GetValue());
                    $this->parcela_subparcela->SetValue($this->DataSource->parcela_subparcela->GetValue());
                    $this->parcela_manzana->SetValue($this->DataSource->parcela_manzana->GetValue());
                    $this->parcela_seccion->SetValue($this->DataSource->parcela_seccion->GetValue());
                    $this->parcela_chacra->SetValue($this->DataSource->parcela_chacra->GetValue());
                    $this->parcela_quinta->SetValue($this->DataSource->parcela_quinta->GetValue());
                    $this->parcela_macizo->SetValue($this->DataSource->parcela_macizo->GetValue());
                    $this->parcela_fraccion->SetValue($this->DataSource->parcela_fraccion->GetValue());
                    $this->parcela_parcela->SetValue($this->DataSource->parcela_parcela->GetValue());
                    $this->parcela_uf->SetValue($this->DataSource->parcela_uf->GetValue());
                    $this->parcela_predio->SetValue($this->DataSource->parcela_predio->GetValue());
                    $this->parcela_coord_y->SetValue($this->DataSource->parcela_coord_y->GetValue());
                    $this->parcela_coord_x->SetValue($this->DataSource->parcela_coord_x->GetValue());
                    $this->parcela_parcela_nw->SetValue($this->DataSource->parcela_parcela_nw->GetValue());
                    $this->tipo_padron_parc_id->SetValue($this->DataSource->tipo_padron_parc_id->GetValue());
                    $this->tipo_depto_parc_id->SetValue($this->DataSource->tipo_depto_parc_id->GetValue());
                    $this->unidades_medidas_id->SetValue($this->DataSource->unidades_medidas_id->GetValue());
                    $this->parcela_super_mensura->SetValue($this->DataSource->parcela_super_mensura->GetValue());
                    $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
                    $this->tipo_instrumento_id->SetValue($this->DataSource->tipo_instrumento_id->GetValue());
                    $this->parcela_instrumento->SetValue($this->DataSource->parcela_instrumento->GetValue());
                    $this->parcela_descrip->SetValue($this->DataSource->parcela_descrip->GetValue());
                    $this->parcela_restr->SetValue($this->DataSource->parcela_restr->GetValue());
                    $this->parcela_receptividad->SetValue($this->DataSource->parcela_receptividad->GetValue());
                    $this->parcela_val_tierra->SetValue($this->DataSource->parcela_val_tierra->GetValue());
                    $this->parcela_val_mejora->SetValue($this->DataSource->parcela_val_mejora->GetValue());
                    $this->parcela_val_ampliac->SetValue($this->DataSource->parcela_val_ampliac->GetValue());
                    $this->parcela_val_total->SetValue($this->DataSource->parcela_val_total->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }
        if (!$this->FormSubmitted) {
        }
        $this->ImageLink2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->ImageLink2->Parameters = CCAddParam($this->ImageLink2->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
        $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
        $this->ImageLink3->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->ImageLink3->Parameters = CCAddParam($this->ImageLink3->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->parcela_sup_uf->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_porc_uf->Errors->ToString());
            $Error = ComposeStrings($Error, $this->destino->Errors->ToString());
            $Error = ComposeStrings($Error, $this->origen->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_rte->Errors->ToString());
            $Error = ComposeStrings($Error, $this->nueva->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_parcela_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_est_parc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_parcela_uso_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_parcela_alta_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_nomenclatura->Errors->ToString());
            $Error = ComposeStrings($Error, $this->audit_string->Errors->ToString());
            $Error = ComposeStrings($Error, $this->usuario->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_f_proceso->Errors->ToString());
            $Error = ComposeStrings($Error, $this->fecha_ultima_modificacion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->usuario_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_dist_pto->Errors->ToString());
            $Error = ComposeStrings($Error, $this->usos_suelo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_notas_nom->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_observa->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_depto_parcela_nw_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_ubica_parcela_nw_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_secc_parcela_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_subparcela->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_manzana->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_seccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->depto->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_chacra->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_quinta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_macizo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_fraccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_parcela->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_uf->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_predio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_coord_y->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_coord_x->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_parcela_nw->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_padron_parc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_depto_parc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->unidades_medidas_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->nomenclatura->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_super_mensura->Errors->ToString());
            $Error = ComposeStrings($Error, $this->general->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_partida->Errors->ToString());
            $Error = ComposeStrings($Error, $this->a->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ades->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ha->Errors->ToString());
            $Error = ComposeStrings($Error, $this->hades->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_val_tierra_l->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_val_mejora_l->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_val_ampliac_l->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ImageLink2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_instrumento_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_instrumento->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ImageLink1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->cantDoc->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ImageLink3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->cantReg->Errors->ToString());
            $Error = ComposeStrings($Error, $this->inscripcionDominial->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_descrip->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_restr->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ImageLink4->Errors->ToString());
            $Error = ComposeStrings($Error, $this->restricciones->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plancheta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_receptividad->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_val_tierra->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_val_mejora->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_val_ampliac->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_val_total->Errors->ToString());
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
        $this->Insert_Button->Visible = !$this->EditMode && $this->InsertAllowed;
        $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->parcela_sup_uf->Show();
        $this->parcela_porc_uf->Show();
        $this->destino->Show();
        $this->origen->Show();
        $this->parcela_rte->Show();
        $this->nueva->Show();
        $this->tipo_parcela_id->Show();
        $this->tipo_est_parc_id->Show();
        $this->tipo_parcela_uso_id->Show();
        $this->parcela_id->Show();
        $this->tipo_parcela_alta_id->Show();
        $this->parcela_nomenclatura->Show();
        $this->audit_string->Show();
        $this->Insert_Button->Show();
        $this->Button_Update->Show();
        $this->Button1->Show();
        $this->usuario->Show();
        $this->parcela_f_proceso->Show();
        $this->fecha_ultima_modificacion->Show();
        $this->usuario_id->Show();
        $this->parcela_dist_pto->Show();
        $this->usos_suelo->Show();
        $this->parcela_notas_nom->Show();
        $this->parcela_observa->Show();
        $this->tipo_depto_parcela_nw_id->Show();
        $this->tipo_ubica_parcela_nw_id->Show();
        $this->tipo_secc_parcela_id->Show();
        $this->parcela_subparcela->Show();
        $this->parcela_manzana->Show();
        $this->parcela_seccion->Show();
        $this->depto->Show();
        $this->parcela_chacra->Show();
        $this->parcela_quinta->Show();
        $this->parcela_macizo->Show();
        $this->parcela_fraccion->Show();
        $this->parcela_parcela->Show();
        $this->parcela_uf->Show();
        $this->parcela_predio->Show();
        $this->parcela_coord_y->Show();
        $this->parcela_coord_x->Show();
        $this->parcela_parcela_nw->Show();
        $this->tipo_padron_parc_id->Show();
        $this->tipo_depto_parc_id->Show();
        $this->unidades_medidas_id->Show();
        $this->nomenclatura->Show();
        $this->parcela_super_mensura->Show();
        $this->general->Show();
        $this->parcela_partida->Show();
        $this->a->Show();
        $this->ades->Show();
        $this->ha->Show();
        $this->hades->Show();
        $this->parcela_val_tierra_l->Show();
        $this->parcela_val_mejora_l->Show();
        $this->parcela_val_ampliac_l->Show();
        $this->ImageLink2->Show();
        $this->tipo_instrumento_id->Show();
        $this->parcela_instrumento->Show();
        $this->ImageLink1->Show();
        $this->cantDoc->Show();
        $this->plano->Show();
        $this->ImageLink3->Show();
        $this->cantReg->Show();
        $this->inscripcionDominial->Show();
        $this->parcela_descrip->Show();
        $this->parcela_restr->Show();
        $this->ImageLink4->Show();
        $this->restricciones->Show();
        $this->plancheta->Show();
        $this->parcela_receptividad->Show();
        $this->parcela_val_tierra->Show();
        $this->parcela_val_mejora->Show();
        $this->parcela_val_ampliac->Show();
        $this->parcela_val_total->Show();
        $this->Button_baja->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End parcela Class @2-FCB6E20C

class clsparcelaDataSource extends clsDBtdf_nuevo {  //parcelaDataSource Class @2-3E367A51

//DataSource Variables @2-34F6CDB9
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
    public $parcela_sup_uf;
    public $parcela_porc_uf;
    public $destino;
    public $origen;
    public $parcela_rte;
    public $nueva;
    public $tipo_parcela_id;
    public $tipo_est_parc_id;
    public $tipo_parcela_uso_id;
    public $parcela_id;
    public $tipo_parcela_alta_id;
    public $parcela_nomenclatura;
    public $audit_string;
    public $usuario;
    public $parcela_f_proceso;
    public $fecha_ultima_modificacion;
    public $usuario_id;
    public $parcela_dist_pto;
    public $usos_suelo;
    public $parcela_notas_nom;
    public $parcela_observa;
    public $tipo_depto_parcela_nw_id;
    public $tipo_ubica_parcela_nw_id;
    public $tipo_secc_parcela_id;
    public $parcela_subparcela;
    public $parcela_manzana;
    public $parcela_seccion;
    public $depto;
    public $parcela_chacra;
    public $parcela_quinta;
    public $parcela_macizo;
    public $parcela_fraccion;
    public $parcela_parcela;
    public $parcela_uf;
    public $parcela_predio;
    public $parcela_coord_y;
    public $parcela_coord_x;
    public $parcela_parcela_nw;
    public $tipo_padron_parc_id;
    public $tipo_depto_parc_id;
    public $unidades_medidas_id;
    public $nomenclatura;
    public $parcela_super_mensura;
    public $general;
    public $parcela_partida;
    public $a;
    public $ades;
    public $ha;
    public $hades;
    public $parcela_val_tierra_l;
    public $parcela_val_mejora_l;
    public $parcela_val_ampliac_l;
    public $ImageLink2;
    public $tipo_instrumento_id;
    public $parcela_instrumento;
    public $ImageLink1;
    public $cantDoc;
    public $plano;
    public $ImageLink3;
    public $cantReg;
    public $inscripcionDominial;
    public $parcela_descrip;
    public $parcela_restr;
    public $ImageLink4;
    public $restricciones;
    public $plancheta;
    public $parcela_receptividad;
    public $parcela_val_tierra;
    public $parcela_val_mejora;
    public $parcela_val_ampliac;
    public $parcela_val_total;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-D71DF0B9
    function clsparcelaDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record parcela/Error";
        $this->Initialize();
        $this->parcela_sup_uf = new clsField("parcela_sup_uf", ccsFloat, "");
        
        $this->parcela_porc_uf = new clsField("parcela_porc_uf", ccsFloat, "");
        
        $this->destino = new clsField("destino", ccsText, "");
        
        $this->origen = new clsField("origen", ccsText, "");
        
        $this->parcela_rte = new clsField("parcela_rte", ccsText, "");
        
        $this->nueva = new clsField("nueva", ccsText, "");
        
        $this->tipo_parcela_id = new clsField("tipo_parcela_id", ccsText, "");
        
        $this->tipo_est_parc_id = new clsField("tipo_est_parc_id", ccsText, "");
        
        $this->tipo_parcela_uso_id = new clsField("tipo_parcela_uso_id", ccsText, "");
        
        $this->parcela_id = new clsField("parcela_id", ccsText, "");
        
        $this->tipo_parcela_alta_id = new clsField("tipo_parcela_alta_id", ccsText, "");
        
        $this->parcela_nomenclatura = new clsField("parcela_nomenclatura", ccsText, "");
        
        $this->audit_string = new clsField("audit_string", ccsText, "");
        
        $this->usuario = new clsField("usuario", ccsText, "");
        
        $this->parcela_f_proceso = new clsField("parcela_f_proceso", ccsText, "");
        
        $this->fecha_ultima_modificacion = new clsField("fecha_ultima_modificacion", ccsDate, $this->DateFormat);
        
        $this->usuario_id = new clsField("usuario_id", ccsText, "");
        
        $this->parcela_dist_pto = new clsField("parcela_dist_pto", ccsFloat, "");
        
        $this->usos_suelo = new clsField("usos_suelo", ccsText, "");
        
        $this->parcela_notas_nom = new clsField("parcela_notas_nom", ccsMemo, "");
        
        $this->parcela_observa = new clsField("parcela_observa", ccsMemo, "");
        
        $this->tipo_depto_parcela_nw_id = new clsField("tipo_depto_parcela_nw_id", ccsInteger, "");
        
        $this->tipo_ubica_parcela_nw_id = new clsField("tipo_ubica_parcela_nw_id", ccsInteger, "");
        
        $this->tipo_secc_parcela_id = new clsField("tipo_secc_parcela_id", ccsInteger, "");
        
        $this->parcela_subparcela = new clsField("parcela_subparcela", ccsText, "");
        
        $this->parcela_manzana = new clsField("parcela_manzana", ccsText, "");
        
        $this->parcela_seccion = new clsField("parcela_seccion", ccsText, "");
        
        $this->depto = new clsField("depto", ccsText, "");
        
        $this->parcela_chacra = new clsField("parcela_chacra", ccsText, "");
        
        $this->parcela_quinta = new clsField("parcela_quinta", ccsText, "");
        
        $this->parcela_macizo = new clsField("parcela_macizo", ccsText, "");
        
        $this->parcela_fraccion = new clsField("parcela_fraccion", ccsText, "");
        
        $this->parcela_parcela = new clsField("parcela_parcela", ccsText, "");
        
        $this->parcela_uf = new clsField("parcela_uf", ccsText, "");
        
        $this->parcela_predio = new clsField("parcela_predio", ccsText, "");
        
        $this->parcela_coord_y = new clsField("parcela_coord_y", ccsText, "");
        
        $this->parcela_coord_x = new clsField("parcela_coord_x", ccsText, "");
        
        $this->parcela_parcela_nw = new clsField("parcela_parcela_nw", ccsText, "");
        
        $this->tipo_padron_parc_id = new clsField("tipo_padron_parc_id", ccsInteger, "");
        
        $this->tipo_depto_parc_id = new clsField("tipo_depto_parc_id", ccsInteger, "");
        
        $this->unidades_medidas_id = new clsField("unidades_medidas_id", ccsText, "");
        
        $this->nomenclatura = new clsField("nomenclatura", ccsText, "");
        
        $this->parcela_super_mensura = new clsField("parcela_super_mensura", ccsFloat, "");
        
        $this->general = new clsField("general", ccsFloat, "");
        
        $this->parcela_partida = new clsField("parcela_partida", ccsText, "");
        
        $this->a = new clsField("a", ccsText, "");
        
        $this->ades = new clsField("ades", ccsText, "");
        
        $this->ha = new clsField("ha", ccsText, "");
        
        $this->hades = new clsField("hades", ccsText, "");
        
        $this->parcela_val_tierra_l = new clsField("parcela_val_tierra_l", ccsFloat, "");
        
        $this->parcela_val_mejora_l = new clsField("parcela_val_mejora_l", ccsFloat, "");
        
        $this->parcela_val_ampliac_l = new clsField("parcela_val_ampliac_l", ccsFloat, "");
        
        $this->ImageLink2 = new clsField("ImageLink2", ccsText, "");
        
        $this->tipo_instrumento_id = new clsField("tipo_instrumento_id", ccsText, "");
        
        $this->parcela_instrumento = new clsField("parcela_instrumento", ccsText, "");
        
        $this->ImageLink1 = new clsField("ImageLink1", ccsText, "");
        
        $this->cantDoc = new clsField("cantDoc", ccsText, "");
        
        $this->plano = new clsField("plano", ccsText, "");
        
        $this->ImageLink3 = new clsField("ImageLink3", ccsText, "");
        
        $this->cantReg = new clsField("cantReg", ccsText, "");
        
        $this->inscripcionDominial = new clsField("inscripcionDominial", ccsText, "");
        
        $this->parcela_descrip = new clsField("parcela_descrip", ccsMemo, "");
        
        $this->parcela_restr = new clsField("parcela_restr", ccsMemo, "");
        
        $this->ImageLink4 = new clsField("ImageLink4", ccsText, "");
        
        $this->restricciones = new clsField("restricciones", ccsText, "");
        
        $this->plancheta = new clsField("plancheta", ccsText, "");
        
        $this->parcela_receptividad = new clsField("parcela_receptividad", ccsFloat, "");
        
        $this->parcela_val_tierra = new clsField("parcela_val_tierra", ccsFloat, "");
        
        $this->parcela_val_mejora = new clsField("parcela_val_mejora", ccsFloat, "");
        
        $this->parcela_val_ampliac = new clsField("parcela_val_ampliac", ccsFloat, "");
        
        $this->parcela_val_total = new clsField("parcela_val_total", ccsFloat, "");
        

        $this->InsertFields["parcela_sup_uf"] = array("Name" => "parcela_sup_uf", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_porc_uf"] = array("Name" => "parcela_porc_uf", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_rte"] = array("Name" => "parcela_rte", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_parcela_id"] = array("Name" => "tipo_parcela_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_est_parc_id"] = array("Name" => "tipo_est_parc_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_parcela_uso_id"] = array("Name" => "tipo_parcela_uso_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_id"] = array("Name" => "parcela_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_parcela_alta_id"] = array("Name" => "tipo_parcela_alta_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_nomenclatura"] = array("Name" => "parcela_nomenclatura", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["audit_string"] = array("Name" => "audit_string", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_f_proceso"] = array("Name" => "parcela_f_proceso", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["usuario_id"] = array("Name" => "usuario_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_dist_pto"] = array("Name" => "parcela_dist_pto", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_notas_nom"] = array("Name" => "parcela_notas_nom", "Value" => "", "DataType" => ccsMemo, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_observa"] = array("Name" => "parcela_observa", "Value" => "", "DataType" => ccsMemo, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_depto_parcela_nw_id"] = array("Name" => "tipo_depto_parcela_nw_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_secc_parcela_id"] = array("Name" => "tipo_secc_parcela_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_subparcela"] = array("Name" => "parcela_subparcela", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_manzana"] = array("Name" => "parcela_manzana", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_seccion"] = array("Name" => "parcela_seccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_chacra"] = array("Name" => "parcela_chacra", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_quinta"] = array("Name" => "parcela_quinta", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_macizo"] = array("Name" => "parcela_macizo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_fraccion"] = array("Name" => "parcela_fraccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_parcela"] = array("Name" => "parcela_parcela", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_uf"] = array("Name" => "parcela_uf", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_predio"] = array("Name" => "parcela_predio", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_coord_y"] = array("Name" => "parcela_coord_y", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_coord_x"] = array("Name" => "parcela_coord_x", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_parcela_nw"] = array("Name" => "parcela_parcela_nw", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_padron_parc_id"] = array("Name" => "tipo_padron_parc_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_depto_parc_id"] = array("Name" => "tipo_depto_parc_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["unidades_medidas_id"] = array("Name" => "unidades_medidas_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_super_mensura"] = array("Name" => "parcela_super_mensura", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_partida"] = array("Name" => "parcela_partida", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_instrumento_id"] = array("Name" => "tipo_instrumento_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_instrumento"] = array("Name" => "parcela_instrumento", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_descrip"] = array("Name" => "parcela_descrip", "Value" => "", "DataType" => ccsMemo, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_restr"] = array("Name" => "parcela_restr", "Value" => "", "DataType" => ccsMemo, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_receptividad"] = array("Name" => "parcela_receptividad", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_val_tierra"] = array("Name" => "parcela_val_tierra", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_val_mejora"] = array("Name" => "parcela_val_mejora", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_val_ampliac"] = array("Name" => "parcela_val_ampliac", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_val_total"] = array("Name" => "parcela_val_total", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_sup_uf"] = array("Name" => "parcela_sup_uf", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_porc_uf"] = array("Name" => "parcela_porc_uf", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_rte"] = array("Name" => "parcela_rte", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_parcela_id"] = array("Name" => "tipo_parcela_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_est_parc_id"] = array("Name" => "tipo_est_parc_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_parcela_uso_id"] = array("Name" => "tipo_parcela_uso_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_id"] = array("Name" => "parcela_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_parcela_alta_id"] = array("Name" => "tipo_parcela_alta_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_nomenclatura"] = array("Name" => "parcela_nomenclatura", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["audit_string"] = array("Name" => "audit_string", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_f_proceso"] = array("Name" => "parcela_f_proceso", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["usuario_id"] = array("Name" => "usuario_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_dist_pto"] = array("Name" => "parcela_dist_pto", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_notas_nom"] = array("Name" => "parcela_notas_nom", "Value" => "", "DataType" => ccsMemo, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_observa"] = array("Name" => "parcela_observa", "Value" => "", "DataType" => ccsMemo, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_depto_parcela_nw_id"] = array("Name" => "tipo_depto_parcela_nw_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_secc_parcela_id"] = array("Name" => "tipo_secc_parcela_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_subparcela"] = array("Name" => "parcela_subparcela", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_manzana"] = array("Name" => "parcela_manzana", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_seccion"] = array("Name" => "parcela_seccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_chacra"] = array("Name" => "parcela_chacra", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_quinta"] = array("Name" => "parcela_quinta", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_macizo"] = array("Name" => "parcela_macizo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_fraccion"] = array("Name" => "parcela_fraccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_parcela"] = array("Name" => "parcela_parcela", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_uf"] = array("Name" => "parcela_uf", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_predio"] = array("Name" => "parcela_predio", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_coord_y"] = array("Name" => "parcela_coord_y", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_coord_x"] = array("Name" => "parcela_coord_x", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_parcela_nw"] = array("Name" => "parcela_parcela_nw", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_padron_parc_id"] = array("Name" => "tipo_padron_parc_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_depto_parc_id"] = array("Name" => "tipo_depto_parc_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["unidades_medidas_id"] = array("Name" => "unidades_medidas_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_super_mensura"] = array("Name" => "parcela_super_mensura", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_partida"] = array("Name" => "parcela_partida", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_instrumento_id"] = array("Name" => "tipo_instrumento_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_instrumento"] = array("Name" => "parcela_instrumento", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_descrip"] = array("Name" => "parcela_descrip", "Value" => "", "DataType" => ccsMemo, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_restr"] = array("Name" => "parcela_restr", "Value" => "", "DataType" => ccsMemo, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_receptividad"] = array("Name" => "parcela_receptividad", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_val_tierra"] = array("Name" => "parcela_val_tierra", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_val_mejora"] = array("Name" => "parcela_val_mejora", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_val_ampliac"] = array("Name" => "parcela_val_ampliac", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_val_total"] = array("Name" => "parcela_val_total", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-CCE5C7B7
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlparcela_id", ccsInteger, "", "", $this->Parameters["urlparcela_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "parcela_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-3419905D
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM parcelas {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-9D8D370B
    function SetValues()
    {
        $this->parcela_sup_uf->SetDBValue(trim($this->f("parcela_sup_uf")));
        $this->parcela_porc_uf->SetDBValue(trim($this->f("parcela_porc_uf")));
        $this->parcela_rte->SetDBValue($this->f("parcela_rte"));
        $this->tipo_parcela_id->SetDBValue($this->f("tipo_parcela_id"));
        $this->tipo_est_parc_id->SetDBValue($this->f("tipo_est_parc_id"));
        $this->tipo_parcela_uso_id->SetDBValue($this->f("tipo_parcela_uso_id"));
        $this->parcela_id->SetDBValue($this->f("parcela_id"));
        $this->tipo_parcela_alta_id->SetDBValue($this->f("tipo_parcela_alta_id"));
        $this->parcela_nomenclatura->SetDBValue($this->f("parcela_nomenclatura"));
        $this->audit_string->SetDBValue($this->f("audit_string"));
        $this->parcela_f_proceso->SetDBValue($this->f("parcela_f_proceso"));
        $this->fecha_ultima_modificacion->SetDBValue(trim($this->f("parcela_f_proceso")));
        $this->usuario_id->SetDBValue($this->f("usuario_id"));
        $this->parcela_dist_pto->SetDBValue(trim($this->f("parcela_dist_pto")));
        $this->parcela_notas_nom->SetDBValue($this->f("parcela_notas_nom"));
        $this->parcela_observa->SetDBValue($this->f("parcela_observa"));
        $this->tipo_depto_parcela_nw_id->SetDBValue(trim($this->f("tipo_depto_parcela_nw_id")));
        $this->tipo_secc_parcela_id->SetDBValue(trim($this->f("tipo_secc_parcela_id")));
        $this->parcela_subparcela->SetDBValue($this->f("parcela_subparcela"));
        $this->parcela_manzana->SetDBValue($this->f("parcela_manzana"));
        $this->parcela_seccion->SetDBValue($this->f("parcela_seccion"));
        $this->parcela_chacra->SetDBValue($this->f("parcela_chacra"));
        $this->parcela_quinta->SetDBValue($this->f("parcela_quinta"));
        $this->parcela_macizo->SetDBValue($this->f("parcela_macizo"));
        $this->parcela_fraccion->SetDBValue($this->f("parcela_fraccion"));
        $this->parcela_parcela->SetDBValue($this->f("parcela_parcela"));
        $this->parcela_uf->SetDBValue($this->f("parcela_uf"));
        $this->parcela_predio->SetDBValue($this->f("parcela_predio"));
        $this->parcela_coord_y->SetDBValue($this->f("parcela_coord_y"));
        $this->parcela_coord_x->SetDBValue($this->f("parcela_coord_x"));
        $this->parcela_parcela_nw->SetDBValue($this->f("parcela_parcela_nw"));
        $this->tipo_padron_parc_id->SetDBValue(trim($this->f("tipo_padron_parc_id")));
        $this->tipo_depto_parc_id->SetDBValue(trim($this->f("tipo_depto_parc_id")));
        $this->unidades_medidas_id->SetDBValue($this->f("unidades_medidas_id"));
        $this->nomenclatura->SetDBValue($this->f("parcela_nomenclatura"));
        $this->parcela_super_mensura->SetDBValue(trim($this->f("parcela_super_mensura")));
        $this->parcela_partida->SetDBValue($this->f("parcela_partida"));
        $this->parcela_val_tierra_l->SetDBValue(trim($this->f("parcela_val_tierra")));
        $this->parcela_val_mejora_l->SetDBValue(trim($this->f("parcela_val_mejora")));
        $this->parcela_val_ampliac_l->SetDBValue(trim($this->f("parcela_val_ampliac")));
        $this->tipo_instrumento_id->SetDBValue($this->f("tipo_instrumento_id"));
        $this->parcela_instrumento->SetDBValue($this->f("parcela_instrumento"));
        $this->parcela_descrip->SetDBValue($this->f("parcela_descrip"));
        $this->parcela_restr->SetDBValue($this->f("parcela_restr"));
        $this->parcela_receptividad->SetDBValue(trim($this->f("parcela_receptividad")));
        $this->parcela_val_tierra->SetDBValue(trim($this->f("parcela_val_tierra")));
        $this->parcela_val_mejora->SetDBValue(trim($this->f("parcela_val_mejora")));
        $this->parcela_val_ampliac->SetDBValue(trim($this->f("parcela_val_ampliac")));
        $this->parcela_val_total->SetDBValue(trim($this->f("parcela_val_total")));
    }
//End SetValues Method

//Insert Method @2-E122D36C
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["parcela_sup_uf"]["Value"] = $this->parcela_sup_uf->GetDBValue(true);
        $this->InsertFields["parcela_porc_uf"]["Value"] = $this->parcela_porc_uf->GetDBValue(true);
        $this->InsertFields["parcela_rte"]["Value"] = $this->parcela_rte->GetDBValue(true);
        $this->InsertFields["tipo_parcela_id"]["Value"] = $this->tipo_parcela_id->GetDBValue(true);
        $this->InsertFields["tipo_est_parc_id"]["Value"] = $this->tipo_est_parc_id->GetDBValue(true);
        $this->InsertFields["tipo_parcela_uso_id"]["Value"] = $this->tipo_parcela_uso_id->GetDBValue(true);
        $this->InsertFields["parcela_id"]["Value"] = $this->parcela_id->GetDBValue(true);
        $this->InsertFields["tipo_parcela_alta_id"]["Value"] = $this->tipo_parcela_alta_id->GetDBValue(true);
        $this->InsertFields["parcela_nomenclatura"]["Value"] = $this->parcela_nomenclatura->GetDBValue(true);
        $this->InsertFields["audit_string"]["Value"] = $this->audit_string->GetDBValue(true);
        $this->InsertFields["parcela_f_proceso"]["Value"] = $this->parcela_f_proceso->GetDBValue(true);
        $this->InsertFields["usuario_id"]["Value"] = $this->usuario_id->GetDBValue(true);
        $this->InsertFields["parcela_dist_pto"]["Value"] = $this->parcela_dist_pto->GetDBValue(true);
        $this->InsertFields["parcela_notas_nom"]["Value"] = $this->parcela_notas_nom->GetDBValue(true);
        $this->InsertFields["parcela_observa"]["Value"] = $this->parcela_observa->GetDBValue(true);
        $this->InsertFields["tipo_depto_parcela_nw_id"]["Value"] = $this->tipo_depto_parcela_nw_id->GetDBValue(true);
        $this->InsertFields["tipo_secc_parcela_id"]["Value"] = $this->tipo_secc_parcela_id->GetDBValue(true);
        $this->InsertFields["parcela_subparcela"]["Value"] = $this->parcela_subparcela->GetDBValue(true);
        $this->InsertFields["parcela_manzana"]["Value"] = $this->parcela_manzana->GetDBValue(true);
        $this->InsertFields["parcela_seccion"]["Value"] = $this->parcela_seccion->GetDBValue(true);
        $this->InsertFields["parcela_chacra"]["Value"] = $this->parcela_chacra->GetDBValue(true);
        $this->InsertFields["parcela_quinta"]["Value"] = $this->parcela_quinta->GetDBValue(true);
        $this->InsertFields["parcela_macizo"]["Value"] = $this->parcela_macizo->GetDBValue(true);
        $this->InsertFields["parcela_fraccion"]["Value"] = $this->parcela_fraccion->GetDBValue(true);
        $this->InsertFields["parcela_parcela"]["Value"] = $this->parcela_parcela->GetDBValue(true);
        $this->InsertFields["parcela_uf"]["Value"] = $this->parcela_uf->GetDBValue(true);
        $this->InsertFields["parcela_predio"]["Value"] = $this->parcela_predio->GetDBValue(true);
        $this->InsertFields["parcela_coord_y"]["Value"] = $this->parcela_coord_y->GetDBValue(true);
        $this->InsertFields["parcela_coord_x"]["Value"] = $this->parcela_coord_x->GetDBValue(true);
        $this->InsertFields["parcela_parcela_nw"]["Value"] = $this->parcela_parcela_nw->GetDBValue(true);
        $this->InsertFields["tipo_padron_parc_id"]["Value"] = $this->tipo_padron_parc_id->GetDBValue(true);
        $this->InsertFields["tipo_depto_parc_id"]["Value"] = $this->tipo_depto_parc_id->GetDBValue(true);
        $this->InsertFields["unidades_medidas_id"]["Value"] = $this->unidades_medidas_id->GetDBValue(true);
        $this->InsertFields["parcela_super_mensura"]["Value"] = $this->parcela_super_mensura->GetDBValue(true);
        $this->InsertFields["parcela_partida"]["Value"] = $this->parcela_partida->GetDBValue(true);
        $this->InsertFields["tipo_instrumento_id"]["Value"] = $this->tipo_instrumento_id->GetDBValue(true);
        $this->InsertFields["parcela_instrumento"]["Value"] = $this->parcela_instrumento->GetDBValue(true);
        $this->InsertFields["parcela_descrip"]["Value"] = $this->parcela_descrip->GetDBValue(true);
        $this->InsertFields["parcela_restr"]["Value"] = $this->parcela_restr->GetDBValue(true);
        $this->InsertFields["parcela_receptividad"]["Value"] = $this->parcela_receptividad->GetDBValue(true);
        $this->InsertFields["parcela_val_tierra"]["Value"] = $this->parcela_val_tierra->GetDBValue(true);
        $this->InsertFields["parcela_val_mejora"]["Value"] = $this->parcela_val_mejora->GetDBValue(true);
        $this->InsertFields["parcela_val_ampliac"]["Value"] = $this->parcela_val_ampliac->GetDBValue(true);
        $this->InsertFields["parcela_val_total"]["Value"] = $this->parcela_val_total->GetDBValue(true);
        $this->SQL = CCBuildInsert("parcelas", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-127B17F2
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["parcela_sup_uf"]["Value"] = $this->parcela_sup_uf->GetDBValue(true);
        $this->UpdateFields["parcela_porc_uf"]["Value"] = $this->parcela_porc_uf->GetDBValue(true);
        $this->UpdateFields["parcela_rte"]["Value"] = $this->parcela_rte->GetDBValue(true);
        $this->UpdateFields["tipo_parcela_id"]["Value"] = $this->tipo_parcela_id->GetDBValue(true);
        $this->UpdateFields["tipo_est_parc_id"]["Value"] = $this->tipo_est_parc_id->GetDBValue(true);
        $this->UpdateFields["tipo_parcela_uso_id"]["Value"] = $this->tipo_parcela_uso_id->GetDBValue(true);
        $this->UpdateFields["parcela_id"]["Value"] = $this->parcela_id->GetDBValue(true);
        $this->UpdateFields["tipo_parcela_alta_id"]["Value"] = $this->tipo_parcela_alta_id->GetDBValue(true);
        $this->UpdateFields["parcela_nomenclatura"]["Value"] = $this->parcela_nomenclatura->GetDBValue(true);
        $this->UpdateFields["audit_string"]["Value"] = $this->audit_string->GetDBValue(true);
        $this->UpdateFields["parcela_f_proceso"]["Value"] = $this->parcela_f_proceso->GetDBValue(true);
        $this->UpdateFields["usuario_id"]["Value"] = $this->usuario_id->GetDBValue(true);
        $this->UpdateFields["parcela_dist_pto"]["Value"] = $this->parcela_dist_pto->GetDBValue(true);
        $this->UpdateFields["parcela_notas_nom"]["Value"] = $this->parcela_notas_nom->GetDBValue(true);
        $this->UpdateFields["parcela_observa"]["Value"] = $this->parcela_observa->GetDBValue(true);
        $this->UpdateFields["tipo_depto_parcela_nw_id"]["Value"] = $this->tipo_depto_parcela_nw_id->GetDBValue(true);
        $this->UpdateFields["tipo_secc_parcela_id"]["Value"] = $this->tipo_secc_parcela_id->GetDBValue(true);
        $this->UpdateFields["parcela_subparcela"]["Value"] = $this->parcela_subparcela->GetDBValue(true);
        $this->UpdateFields["parcela_manzana"]["Value"] = $this->parcela_manzana->GetDBValue(true);
        $this->UpdateFields["parcela_seccion"]["Value"] = $this->parcela_seccion->GetDBValue(true);
        $this->UpdateFields["parcela_chacra"]["Value"] = $this->parcela_chacra->GetDBValue(true);
        $this->UpdateFields["parcela_quinta"]["Value"] = $this->parcela_quinta->GetDBValue(true);
        $this->UpdateFields["parcela_macizo"]["Value"] = $this->parcela_macizo->GetDBValue(true);
        $this->UpdateFields["parcela_fraccion"]["Value"] = $this->parcela_fraccion->GetDBValue(true);
        $this->UpdateFields["parcela_parcela"]["Value"] = $this->parcela_parcela->GetDBValue(true);
        $this->UpdateFields["parcela_uf"]["Value"] = $this->parcela_uf->GetDBValue(true);
        $this->UpdateFields["parcela_predio"]["Value"] = $this->parcela_predio->GetDBValue(true);
        $this->UpdateFields["parcela_coord_y"]["Value"] = $this->parcela_coord_y->GetDBValue(true);
        $this->UpdateFields["parcela_coord_x"]["Value"] = $this->parcela_coord_x->GetDBValue(true);
        $this->UpdateFields["parcela_parcela_nw"]["Value"] = $this->parcela_parcela_nw->GetDBValue(true);
        $this->UpdateFields["tipo_padron_parc_id"]["Value"] = $this->tipo_padron_parc_id->GetDBValue(true);
        $this->UpdateFields["tipo_depto_parc_id"]["Value"] = $this->tipo_depto_parc_id->GetDBValue(true);
        $this->UpdateFields["unidades_medidas_id"]["Value"] = $this->unidades_medidas_id->GetDBValue(true);
        $this->UpdateFields["parcela_super_mensura"]["Value"] = $this->parcela_super_mensura->GetDBValue(true);
        $this->UpdateFields["parcela_partida"]["Value"] = $this->parcela_partida->GetDBValue(true);
        $this->UpdateFields["tipo_instrumento_id"]["Value"] = $this->tipo_instrumento_id->GetDBValue(true);
        $this->UpdateFields["parcela_instrumento"]["Value"] = $this->parcela_instrumento->GetDBValue(true);
        $this->UpdateFields["parcela_descrip"]["Value"] = $this->parcela_descrip->GetDBValue(true);
        $this->UpdateFields["parcela_restr"]["Value"] = $this->parcela_restr->GetDBValue(true);
        $this->UpdateFields["parcela_receptividad"]["Value"] = $this->parcela_receptividad->GetDBValue(true);
        $this->UpdateFields["parcela_val_tierra"]["Value"] = $this->parcela_val_tierra->GetDBValue(true);
        $this->UpdateFields["parcela_val_mejora"]["Value"] = $this->parcela_val_mejora->GetDBValue(true);
        $this->UpdateFields["parcela_val_ampliac"]["Value"] = $this->parcela_val_ampliac->GetDBValue(true);
        $this->UpdateFields["parcela_val_total"]["Value"] = $this->parcela_val_total->GetDBValue(true);
        $this->SQL = CCBuildUpdate("parcelas", $this->UpdateFields, $this);
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

} //End parcelaDataSource Class @2-FCB6E20C

//Initialize Page @1-47BE932A
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
$TemplateFileName = "recordParcela.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-BE702396
include_once("./recordParcela_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-FF0C8742
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
$footerParcela = new clsfooterParcela("", "footerParcela", $MainPage);
$footerParcela->Initialize();
$cartel = new clsControl(ccsLabel, "cartel", "cartel", ccsText, "", CCGetRequestParam("cartel", ccsGet, NULL), $MainPage);
$cartel->HTML = true;
$parcela = new clsRecordparcela("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->footerParcela = & $footerParcela;
$MainPage->cartel = & $cartel;
$MainPage->parcela = & $parcela;
$parcela->Initialize();

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

//Execute Components @1-A105C45F
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
$footerParcela->Operations();
$parcela->Operation();
//End Execute Components

//Go to destination page @1-CCD54FE4
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
    $footerParcela->Class_Terminate();
    unset($footerParcela);
    unset($parcela);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-921FFA45
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$footerParcela->Show();
$parcela->Show();
$cartel->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$FHMA8J0N3B = ">retnec/<>tnof/<>llams/<.;111#&;501#&dutS>-- CCS --!< ;101#&gra;401#&;76#&ed;111#&C>-- CCS --!< h;611#&;501#&;911#&>-- SCC --!< ;001#&;101#&;611#&;79#&;411#&;101#&n;101#&;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<";
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", strrev($FHMA8J0N3B) . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", strrev($FHMA8J0N3B) . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= strrev($FHMA8J0N3B);
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-F89A7BB7
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$footerParcela->Class_Terminate();
unset($footerParcela);
unset($parcela);
unset($Tpl);
//End Unload Page


?>
