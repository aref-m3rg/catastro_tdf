<?php
//BindEvents Method @1-5751DB08
function BindEvents()
{
    global $departamentos_doc_tipos_f;
    global $CCSEvents;
    $departamentos_doc_tipos_f->CCSEvents["BeforeShowRow"] = "departamentos_doc_tipos_f_BeforeShowRow";
    $departamentos_doc_tipos_f->CCSEvents["BeforeShow"] = "departamentos_doc_tipos_f_BeforeShow";
}
//End BindEvents Method

//departamentos_doc_tipos_f_BeforeShowRow @2-7EF514BC
function departamentos_doc_tipos_f_BeforeShowRow(& $sender)
{
    $departamentos_doc_tipos_f_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $departamentos_doc_tipos_f; //Compatibility
//End departamentos_doc_tipos_f_BeforeShowRow

//Set Row Style @177-07645FFB
    $styles = array("Row", "AltRow");
    if (count($styles)) {
        $Style = $styles[($Component->RowNumber - 1) % count($styles)];
        if (strlen($Style) && !strpos($Style, "="))
            $Style = (strpos($Style, ":") ? 'style="' : 'class="'). $Style . '"';
        $Component->Attributes->SetValue("estilo", $Style);
    }
//End Set Row Style

//Custom Code @193-2A29BDB7
// -------------------------
	$persona_parcela_id = $Component->ds->f('persona_parcela_id');
	$persona_id = $Component->ds->f('persona_id');
	$db = new clsDBtdf_nuevo();
	$Component->tipo_persona_parcela_descrip->SetValue(CCDLookUp("tipo_persona_parcela_descrip","personas_parcelas LEFT JOIN tipos_personas_parcelas ON personas_parcelas.tipo_persona_parcela_id = tipos_personas_parcelas.tipo_persona_parcela_id","persona_parcela_id = $persona_parcela_id",$db));
	$Component->tipo_documento_abrev->SetValue(CCDLookUp("tipo_documento_abrev","personas LEFT JOIN tipos_documentos ON personas.tipo_documento_id = tipos_documentos.tipo_documento_id","persona_id = $persona_id",$db));
	$Component->instrumento->SetValue(CCDLookUp("CONCAT(tipo_instrumento_abrev,' ',persona_parcela_num_int,' ',persona_parcela_descrip_num)","personas_parcelas LEFT JOIN tipos_instrumentos ON personas_parcelas.tipo_instrumento_id = tipos_instrumentos.tipo_instrumento_id","persona_parcela_id = $persona_parcela_id",$db));
	$db->close();
// -------------------------
//End Custom Code

//Close departamentos_doc_tipos_f_BeforeShowRow @2-30BC910C
    return $departamentos_doc_tipos_f_BeforeShowRow;
}
//End Close departamentos_doc_tipos_f_BeforeShowRow

//departamentos_doc_tipos_f_BeforeShow @2-FAB72641
function departamentos_doc_tipos_f_BeforeShow(& $sender)
{
    $departamentos_doc_tipos_f_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $departamentos_doc_tipos_f; //Compatibility
//End departamentos_doc_tipos_f_BeforeShow

//Custom Code @449-2A29BDB7
// -------------------------
	$db = new clsDBtdf_nuevo();
	$parcela_id = CCDLookUp("parcela_id","parcelas","tipo_depto_parc_id = ".CCGetParam('dpto_id')." AND parcela_partida = ".CCGetParam('parcela_partida'),$db);
	$Component->tipo_instrumento_abrev->SetValue(CCDLookUp("tipo_instrumento_abrev","parcelas LEFT JOIN tipos_instrumentos ON parcelas.tipo_instrumento_id = tipos_instrumentos.tipo_instrumento_id","parcela_id = $parcela_id",$db));
	//$Component->planete->SetValue(CCDLookUp("IF(planos.plano_nro,CONCAT('T.F. ',CONCAT_WS('-',tipos_deptos_parcela.tipo_depto_parc_plano_nro,CONCAT(tipos_planos.tipo_plano_abrev,planos.plano_nro),RIGHT(planos.plano_anio,2))),IFNULL(planos.tmp_plano,'Sin Mensura')) AS plano","parcelas_planos LEFT JOIN planos ON parcelas_planos.plano_id = planos.plano_id LEFT JOIN tipos_planos ON planos.tipo_plano_id = tipos_planos.tipo_plano_id LEFT JOIN tipos_deptos_parcela ON planos.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id","parcelas_planos.parcela_id = $parcela_id",$db));
	$Component->planete->SetValue(CCGetParam('plano'));
	$Component->plano_est_desc->SetValue(CCDLookUp("tipos_estados_planos.tipo_estado_plano_desc","parcelas_planos LEFT JOIN planos ON parcelas_planos.plano_id = planos.plano_id LEFT JOIN tipos_estados_planos ON planos.tipo_estado_plano_id = tipos_estados_planos.tipo_estado_plano_id","parcelas_planos.parcela_id = $parcela_id",$db));
	$db->close();
// -------------------------
//End Custom Code

//Close departamentos_doc_tipos_f_BeforeShow @2-BFC59507
    return $departamentos_doc_tipos_f_BeforeShow;
}
//End Close departamentos_doc_tipos_f_BeforeShow

//Page_BeforeInitialize @1-1AFE86E2
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $gis_info; //Compatibility
//End Page_BeforeInitialize

//Custom Code @455-2A29BDB7
// -------------------------
    include_once(RelativePath . "/scripts/permisos1.php");
// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize

?>
