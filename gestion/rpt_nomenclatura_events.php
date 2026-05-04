<?php
//BindEvents Method @1-BDE8F681
function BindEvents()
{
    global $pre;
    global $CCSEvents;
    $pre->Button_DoSearch->CCSEvents["OnClick"] = "pre_Button_DoSearch_OnClick";
    $pre->CCSEvents["BeforeShow"] = "pre_BeforeShow";
}
//End BindEvents Method

//pre_Button_DoSearch_OnClick @4-99FB1ED6
function pre_Button_DoSearch_OnClick(& $sender)
{
    $pre_Button_DoSearch_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $pre; //Compatibility
//End pre_Button_DoSearch_OnClick

//Custom Code @84-2A29BDB7
// -------------------------
	global $Redirect;
	$plano = $pre->plano->GetValue();
	$parcela_id = $pre->parcela_id->GetValue();
	$obs = $pre->obs->GetValue();
	if(CCGetParam('parcela_id')){
		$db = new clsDBtdf_nuevo();
		$SQL = "UPDATE parcelas SET parcela_cert = '".mysql_real_escape_string($obs)."' WHERE parcela_id = ".CCGetParam('parcela_id');
		$db->query($SQL);
		$db->close();
		$Redirect = "../reportes/rpt_nom_pdf.php?plano=".$plano."&parcela_id=".$parcela_id."&obs=1&descrip=".$pre->descrip->GetValue();
	}
// -------------------------
//End Custom Code

//Close pre_Button_DoSearch_OnClick @4-694D868C
    return $pre_Button_DoSearch_OnClick;
}
//End Close pre_Button_DoSearch_OnClick

//pre_BeforeShow @2-66DBE798
function pre_BeforeShow(& $sender)
{
    $pre_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $pre; //Compatibility
//End pre_BeforeShow

//Custom Code @63-2A29BDB7
// -------------------------
    $parcela_id = $Component->parcela_id->GetValue();
	$db = new clsDBtdf_nuevo();
	//$Component->plano->SetValue(CCDLookUp("IF(plano_nro,CONCAT('T.F. ',CONCAT_WS('-',tipo_depto_parc_plano_nro,CONCAT(tipo_plano_abrev,plano_nro),RIGHT(plano_anio,2))),'') AS plano","parcelas_planos LEFT JOIN planos ON parcelas_planos.plano_id = planos.plano_id LEFT JOIN tipos_planos ON planos.tipo_plano_id = tipos_planos.tipo_plano_id LEFT JOIN tipos_deptos_parcela ON planos.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id","parcelas_planos.parcela_id = $parcela_id",$db));
	$Component->plano->SetValue(obtenerPlano(false,CCGetParam('parcela_id'),false, $db));
	$db->close();
// -------------------------
//End Custom Code

//Close pre_BeforeShow @2-20E685CF
    return $pre_BeforeShow;
}
//End Close pre_BeforeShow

//Page_BeforeInitialize @1-20D5744D
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $rpt_nomenclatura; //Compatibility
//End Page_BeforeInitialize

//Custom Code @89-2A29BDB7
// -------------------------
	include_once(RelativePath . "/scripts/myFunctions.php");

    include_once(RelativePath . "/scripts/permisos1.php");
// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
