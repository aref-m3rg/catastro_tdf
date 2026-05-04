<?php

//BindEvents Method @1-DD4570FA
function BindEvents()
{
    global $tipos_coef_ajustes1;
    global $CCSEvents;
    $tipos_coef_ajustes1->CCSEvents["BeforeShow"] = "tipos_coef_ajustes1_BeforeShow";
    $tipos_coef_ajustes1->CCSEvents["BeforeInsert"] = "tipos_coef_ajustes1_BeforeInsert";
    $tipos_coef_ajustes1->CCSEvents["OnValidate"] = "tipos_coef_ajustes1_OnValidate";
    $tipos_coef_ajustes1->CCSEvents["AfterInsert"] = "tipos_coef_ajustes1_AfterInsert";
}
//End BindEvents Method

//tipos_coef_ajustes1_BeforeShow @20-8DBD3D99
function tipos_coef_ajustes1_BeforeShow(& $sender)
{
    $tipos_coef_ajustes1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tipos_coef_ajustes1; //Compatibility
//End tipos_coef_ajustes1_BeforeShow

//Custom Code @46-2A29BDB7
// -------------------------
    if(CCGetParam('parcela_id')){
		$tipos_coef_ajustes1->Button_Cancel->Visible=true;
	}else{
		$tipos_coef_ajustes1->Button_Cancel->Visible=false;
	}
// -------------------------
//End Custom Code

//Close tipos_coef_ajustes1_BeforeShow @20-0D6B15B9
    return $tipos_coef_ajustes1_BeforeShow;
}
//End Close tipos_coef_ajustes1_BeforeShow

//tipos_coef_ajustes1_BeforeInsert @20-7C8C3FCF
function tipos_coef_ajustes1_BeforeInsert(& $sender)
{
    $tipos_coef_ajustes1_BeforeInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tipos_coef_ajustes1; //Compatibility
//End tipos_coef_ajustes1_BeforeInsert

//Custom Code @47-2A29BDB7
// -------------------------
    $db = new clsDBtdf_nuevo();
	$tipo_coef_ajuste_id = CCDLookUp("MAX(tipo_coef_ajuste_id)","tipos_coef_ajustes","tipo_coef_ajuste_f_fin IS NULL",$db);
	$SQL = "UPDATE tipos_coef_ajustes SET tipo_coef_ajuste_f_fin = DATE_SUB(CURDATE(), INTERVAL 1 DAY) WHERE tipo_coef_ajuste_id = $tipo_coef_ajuste_id";
	$db->query($SQL);
	$db->close();
// -------------------------
//End Custom Code

//Close tipos_coef_ajustes1_BeforeInsert @20-02573ED4
    return $tipos_coef_ajustes1_BeforeInsert;
}
//End Close tipos_coef_ajustes1_BeforeInsert

//tipos_coef_ajustes1_OnValidate @20-CEA3C23C
function tipos_coef_ajustes1_OnValidate(& $sender)
{
    $tipos_coef_ajustes1_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tipos_coef_ajustes1; //Compatibility
//End tipos_coef_ajustes1_OnValidate

//Custom Code @48-2A29BDB7
// -------------------------
    $db = new clsDBtdf_nuevo();
	$tipo_coef_ajuste_valor = $tipos_coef_ajustes1->tipo_coef_ajuste_valor->GetValue();
	$tipo_coef_ajuste_id = CCDLookUp("tipo_coef_ajuste_id","tipos_coef_ajustes","tipo_coef_ajuste_valor = $tipo_coef_ajuste_valor AND tipo_coef_ajuste_f_fin IS NULL",$db);
	if($tipo_coef_ajuste_id && CCGetParam('tipo_coef_ajuste_id') == ''){
		$tipos_coef_ajustes1->Errors->addError("Ya existe un registro vigente con el mismo valor ($)");
	}
	$db->close();
// -------------------------
//End Custom Code

//Close tipos_coef_ajustes1_OnValidate @20-32907130
    return $tipos_coef_ajustes1_OnValidate;
}
//End Close tipos_coef_ajustes1_OnValidate

//tipos_coef_ajustes1_AfterInsert @20-3BF68FC1
function tipos_coef_ajustes1_AfterInsert(& $sender)
{
    $tipos_coef_ajustes1_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tipos_coef_ajustes1; //Compatibility
//End tipos_coef_ajustes1_AfterInsert

//Custom Code @50-2A29BDB7
// -------------------------
    $db = new clsDBtdf_nuevo();
	$SQL="DELETE FROM tipos_coef_ajustes WHERE tipo_coef_ajuste_f_fin <= tipo_coef_ajuste_f_ini";
	$db->query($SQL);
	$db->close();
// -------------------------
//End Custom Code

//Close tipos_coef_ajustes1_AfterInsert @20-CB1D5AF2
    return $tipos_coef_ajustes1_AfterInsert;
}
//End Close tipos_coef_ajustes1_AfterInsert

//Page_BeforeInitialize @1-4CD5FB3D
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoraajuste; //Compatibility
//End Page_BeforeInitialize

//Custom Code @5-2A29BDB7
// -------------------------

	// Incluye el archivo de funciones generales
	include_once(RelativePath . "/scripts/myFunctions.php");


	// Incluye la gestión de permisos
	include_once(RelativePath . "/scripts/permisos1.php");

// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize
?>
