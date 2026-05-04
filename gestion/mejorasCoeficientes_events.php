<?php

//BindEvents Method @1-678A5960
function BindEvents()
{
    global $mejoras_coeficientes1;
    global $CCSEvents;
    $mejoras_coeficientes1->CCSEvents["OnValidate"] = "mejoras_coeficientes1_OnValidate";
    $mejoras_coeficientes1->CCSEvents["BeforeShow"] = "mejoras_coeficientes1_BeforeShow";
}
//End BindEvents Method

//mejoras_coeficientes1_OnValidate @23-42593655
function mejoras_coeficientes1_OnValidate(& $sender)
{
    $mejoras_coeficientes1_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras_coeficientes1; //Compatibility
//End mejoras_coeficientes1_OnValidate

//Custom Code @42-2A29BDB7
// -------------------------
    $db = new clsDBtdf_nuevo();
	$mejora_coeficiente_id = CCDLookUp("mejora_coeficiente_id","mejoras_coeficientes","mejora_coeficiente_anio = '".$mejoras_coeficientes1->mejora_coeficiente_anio->GetValue()."' AND tipo_mejora_cat_id = '".$mejoras_coeficientes1->tipo_mejora_cat_id->GetValue()."' AND tipo_mejora_conserva_id = '".$mejoras_coeficientes1->tipo_mejora_conserva_id->GetValue()."'",$db);
	if($mejora_coeficiente_id && CCGetParam('mejora_coeficiente_id') == ''){
		$mejoras_coeficientes1->Errors->addError('Ya existe para este año, categoria y conservacion el coeficiente');			
	}elseif($mejora_coeficiente_id != CCGetParam('mejora_coeficiente_id')){
        $mejoras_coeficientes1->Errors->addError('Ya existe para este año, categoria y conservacion el coeficiente');
	}
	$db->close();
// -------------------------
//End Custom Code

//Close mejoras_coeficientes1_OnValidate @23-C5BA87CC
    return $mejoras_coeficientes1_OnValidate;
}
//End Close mejoras_coeficientes1_OnValidate

//mejoras_coeficientes1_BeforeShow @23-BDCF4EAE
function mejoras_coeficientes1_BeforeShow(& $sender)
{
    $mejoras_coeficientes1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras_coeficientes1; //Compatibility
//End mejoras_coeficientes1_BeforeShow

//Custom Code @45-2A29BDB7
// -------------------------
	//boton volver se oculta sino hay relacion con parcela
    if(CCGetParam('parcela_id')){
		$mejoras_coeficientes1->volver->Visible=true;
	}else{
		$mejoras_coeficientes1->volver->Visible=false;
	}
// -------------------------
//End Custom Code

//Close mejoras_coeficientes1_BeforeShow @23-FA41E345
    return $mejoras_coeficientes1_BeforeShow;
}
//End Close mejoras_coeficientes1_BeforeShow

//Page_BeforeInitialize @1-16984250
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejorasCoeficientes; //Compatibility
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
