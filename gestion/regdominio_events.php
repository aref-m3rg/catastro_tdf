<?php

//BindEvents Method @1-8806DAC8
function BindEvents()
{
    global $parcelas_dominiales1;
    global $CCSEvents;
    $parcelas_dominiales1->CCSEvents["BeforeShow"] = "parcelas_dominiales1_BeforeShow";
}
//End BindEvents Method

//parcelas_dominiales1_BeforeShow @54-8DED24CE
function parcelas_dominiales1_BeforeShow(& $sender)
{
    $parcelas_dominiales1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_dominiales1; //Compatibility
//End parcelas_dominiales1_BeforeShow

//Custom Code @100-2A29BDB7
// -------------------------
    $db = new clsDBtdf_nuevo();
	$SQL="SELECT * FROM parcelas WHERE parcela_id = ".CCGetParam('parcela_id');
	$db->query($SQL);
	if($db->next_record() && CCGetParam('parcela_dominial_id') == ''){
		$parcelas_dominiales1->tipo_depto_parc_id->SetValue($db->f('tipo_depto_parc_id'));
		$parcelas_dominiales1->tipo_padron_parc_id->SetValue($db->f('tipo_padron_parc_id'));
		$parcelas_dominiales1->parcela_dominial_seccion->SetValue($db->f('parcela_seccion'));
		$parcelas_dominiales1->parcela_dominial_macizo->SetValue($db->f('parcela_macizo'));
	}
	$db->close();
// -------------------------
//End Custom Code

//Close parcelas_dominiales1_BeforeShow @54-89A3776A
    return $parcelas_dominiales1_BeforeShow;
}
//End Close parcelas_dominiales1_BeforeShow

//Page_BeforeInitialize @1-04292A8B
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $regdominio; //Compatibility
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
