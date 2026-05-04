<?php

//BindEvents Method @1-B634EE8D
function BindEvents()
{
    global $mejoras_valores1;
    global $CCSEvents;
    $mejoras_valores1->tipo_mejora_cat_id->CCSEvents["BeforeShow"] = "mejoras_valores1_tipo_mejora_cat_id_BeforeShow";
    $mejoras_valores1->CCSEvents["OnValidate"] = "mejoras_valores1_OnValidate";
    $mejoras_valores1->CCSEvents["BeforeShow"] = "mejoras_valores1_BeforeShow";
    $mejoras_valores1->CCSEvents["BeforeInsert"] = "mejoras_valores1_BeforeInsert";
    $mejoras_valores1->CCSEvents["AfterInsert"] = "mejoras_valores1_AfterInsert";
}
//End BindEvents Method

//mejoras_valores1_tipo_mejora_cat_id_BeforeShow @39-ED541352
function mejoras_valores1_tipo_mejora_cat_id_BeforeShow(& $sender)
{
    $mejoras_valores1_tipo_mejora_cat_id_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras_valores1; //Compatibility
//End mejoras_valores1_tipo_mejora_cat_id_BeforeShow

//Close mejoras_valores1_tipo_mejora_cat_id_BeforeShow @39-6496BC0E
    return $mejoras_valores1_tipo_mejora_cat_id_BeforeShow;
}
//End Close mejoras_valores1_tipo_mejora_cat_id_BeforeShow

//mejoras_valores1_OnValidate @29-F95D542F
function mejoras_valores1_OnValidate(& $sender)
{
    $mejoras_valores1_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras_valores1; //Compatibility
//End mejoras_valores1_OnValidate

//Custom Code @71-2A29BDB7
// -------------------------
    $db = new clsDBtdf_nuevo();
	$mejora_formulario_id = $mejoras_valores1->mejora_formulario_id->GetValue();
	$tipo_mejora_cat_id = $mejoras_valores1->tipo_mejora_cat_id->GetValue();
	$mejora_construccion_id = $mejoras_valores1->mejora_construccion_id->GetValue();
	$mejora_valor_valor = $mejoras_valores1->mejora_valor_valor->GetValue();

	$mejora_valor_id = CCDLookUp("mejora_valor_id","mejoras_valores","mejora_formulario_id = $mejora_formulario_id AND tipo_mejora_cat_id = $tipo_mejora_cat_id AND mejora_construccion_id = $mejora_construccion_id AND mejora_valor_valor = $mejora_valor_valor AND mejora_valor_f_fin IS NULL",$db);
	if($mejora_valor_id && CCGetParam('mejora_valor_id') == ''){
		$mejoras_valores1->Errors->addError("Ya existe un registro con el mismo valor ($) y caracteristicas");
	}
	$db->close();
// -------------------------
//End Custom Code

//Close mejoras_valores1_OnValidate @29-0739B484
    return $mejoras_valores1_OnValidate;
}
//End Close mejoras_valores1_OnValidate

//mejoras_valores1_BeforeShow @29-0F352D26
function mejoras_valores1_BeforeShow(& $sender)
{
    $mejoras_valores1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras_valores1; //Compatibility
//End mejoras_valores1_BeforeShow

//Custom Code @73-2A29BDB7
// -------------------------
    if(CCGetParam('parcela_id')){
		$mejoras_valores1->volver->Visible=true;
	}else{
		$mejoras_valores1->volver->Visible=false;
	}
// -------------------------
//End Custom Code

//Close mejoras_valores1_BeforeShow @29-38C2D00D
    return $mejoras_valores1_BeforeShow;
}
//End Close mejoras_valores1_BeforeShow

//mejoras_valores1_BeforeInsert @29-018898A6
function mejoras_valores1_BeforeInsert(& $sender)
{
    $mejoras_valores1_BeforeInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras_valores1; //Compatibility
//End mejoras_valores1_BeforeInsert

//Custom Code @74-2A29BDB7
// -------------------------
    $db = new clsDBtdf_nuevo();
	$mejora_formulario_id = $mejoras_valores1->mejora_formulario_id->GetValue();
	$tipo_mejora_cat_id = $mejoras_valores1->tipo_mejora_cat_id->GetValue();
	$mejora_construccion_id = $mejoras_valores1->mejora_construccion_id->GetValue();
	$mejora_valor_id = CCDLookUp("MAX(mejora_valor_id)","mejoras_valores","mejora_formulario_id = $mejora_formulario_id AND tipo_mejora_cat_id = $tipo_mejora_cat_id AND mejora_construccion_id = $mejora_construccion_id AND mejora_valor_f_fin IN NULL",$db);
	$SQL = "UPDATE mejoras_valores SET mejora_valor_f_fin = DATE_SUB(CURDATE(), INTERVAL 1 DAY) WHERE mejora_valor_id = $mejora_valor_id";
	$db->query($SQL);
	$db->close();
// -------------------------
//End Custom Code

//Close mejoras_valores1_BeforeInsert @29-69F056FE
    return $mejoras_valores1_BeforeInsert;
}
//End Close mejoras_valores1_BeforeInsert

//mejoras_valores1_AfterInsert @29-4C06CF82
function mejoras_valores1_AfterInsert(& $sender)
{
    $mejoras_valores1_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras_valores1; //Compatibility
//End mejoras_valores1_AfterInsert

//Custom Code @109-2A29BDB7
// -------------------------
    $db = new clsDBtdf_nuevo();
	$SQL="DELETE FROM mejoras_valores WHERE mejora_valor_f_fin <= mejora_valor_f_ini";
	$db->query($SQL);
	$db->close();
// -------------------------
//End Custom Code

//Close mejoras_valores1_AfterInsert @29-072484A2
    return $mejoras_valores1_AfterInsert;
}
//End Close mejoras_valores1_AfterInsert

//Page_BeforeInitialize @1-79D4DC31
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoraValores; //Compatibility
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
