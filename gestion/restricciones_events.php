<?php

//BindEvents Method @1-7E4B8B61
function BindEvents()
{
    global $restricciones;
    global $CCSEvents;
    $restricciones->Button_Update->CCSEvents["OnClick"] = "restricciones_Button_Update_OnClick";
    $restricciones->CCSEvents["BeforeShow"] = "restricciones_BeforeShow";
}
//End BindEvents Method

//restricciones_Button_Update_OnClick @9-03DE4749
function restricciones_Button_Update_OnClick(& $sender)
{
    $restricciones_Button_Update_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $restricciones; //Compatibility
//End restricciones_Button_Update_OnClick

//Custom Code @14-2A29BDB7
// -------------------------
	$db = new clsDBtdf_nuevo();
	$parcela_id=CCGetParam(parcela_id);
  	$SQL = "DELETE FROM parcelas_tipos_restricc WHERE parcela_id = " . $parcela_id;
  	$db->query($SQL);

  	if(CCGetParam(restriccion)){
		$s = CCGetParam(restriccion);
		while (list ($clave, $val) = each ($s)) {
	   		$SQL = "INSERT INTO parcelas_tipos_restricc
		   			  SET parcela_id = $parcela_id,
					      tipo_restricc_parcela_id = $val";
		   $db->query($SQL);
		} 
  	}
	$db->close();
// -------------------------
//End Custom Code

//Close restricciones_Button_Update_OnClick @9-9389527C
    return $restricciones_Button_Update_OnClick;
}
//End Close restricciones_Button_Update_OnClick

//restricciones_BeforeShow @7-53C6CB03
function restricciones_BeforeShow(& $sender)
{
    $restricciones_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $restricciones; //Compatibility
//End restricciones_BeforeShow

//Custom Code @13-2A29BDB7
// -------------------------
  	$db = new clsDBtdf_nuevo();
	$SQL = "SELECT * 
			FROM parcelas_tipos_restricc 
			WHERE parcela_id = " . CCGetParam(parcela_id);
	$db->query($SQL);
	while($db->next_record()){
		$a[] = $db->f('tipo_restricc_parcela_id');
	}
	
	//print_r($a);
	$Component->restriccion->Value = $a;
	$db->close();
// -------------------------
//End Custom Code

//Close restricciones_BeforeShow @7-AFA96FFA
    return $restricciones_BeforeShow;
}
//End Close restricciones_BeforeShow

//Page_BeforeInitialize @1-46BDF86C
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $restricciones; //Compatibility
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
