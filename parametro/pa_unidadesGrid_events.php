<?php
//BindEvents Method @1-ADDA990E
function BindEvents()
{
    global $unidades;
    global $CCSEvents;
    $unidades->unidades_TotalRecords->CCSEvents["BeforeShow"] = "unidades_unidades_TotalRecords_BeforeShow";
    $unidades->unidad_pase_externo->CCSEvents["BeforeShow"] = "unidades_unidad_pase_externo_BeforeShow";
}
//End BindEvents Method

//unidades_unidades_TotalRecords_BeforeShow @12-C01CF781
function unidades_unidades_TotalRecords_BeforeShow(& $sender)
{
    $unidades_unidades_TotalRecords_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $unidades; //Compatibility
//End unidades_unidades_TotalRecords_BeforeShow

//Retrieve number of records @13-ABE656B4
    $Component->SetValue($Container->DataSource->RecordsCount);
//End Retrieve number of records

//Close unidades_unidades_TotalRecords_BeforeShow @12-27FA0E33
    return $unidades_unidades_TotalRecords_BeforeShow;
}
//End Close unidades_unidades_TotalRecords_BeforeShow

//unidades_unidad_pase_externo_BeforeShow @29-2F280E1D
function unidades_unidad_pase_externo_BeforeShow(& $sender)
{
    $unidades_unidad_pase_externo_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $unidades; //Compatibility
//End unidades_unidad_pase_externo_BeforeShow

//Custom Code @46-2A29BDB7
// -------------------------

	/* Modifica el contenido del campo para mostrar el estado
	 * para mostrarlo de forma humana
	-----------------------------------------------------------*/
	$currentValue = $Component->GetValue();

	if ( $currentValue ) {
		$Component->SetValue('Sí');
	} else {
		$Component->SetValue('No');
	}


// -------------------------
//End Custom Code

//Close unidades_unidad_pase_externo_BeforeShow @29-9B3F55AA
    return $unidades_unidad_pase_externo_BeforeShow;
}
//End Close unidades_unidad_pase_externo_BeforeShow

//Page_BeforeInitialize @1-1250E0FD
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $pa_unidadesGrid; //Compatibility
//End Page_BeforeInitialize

//Custom Code @55-2A29BDB7
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
