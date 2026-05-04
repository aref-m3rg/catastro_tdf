<?php

//BindEvents Method @1-0FA88256
function BindEvents()
{
    global $confirmacion_ext;
    global $CCSEvents;
    $confirmacion_ext->CCSEvents["BeforeShow"] = "confirmacion_ext_BeforeShow";
    $confirmacion_ext->ds->CCSEvents["AfterExecuteUpdate"] = "confirmacion_ext_ds_AfterExecuteUpdate";
}
//End BindEvents Method

//confirmacion_ext_BeforeShow @4-969099E7
function confirmacion_ext_BeforeShow(& $sender)
{
    $confirmacion_ext_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $confirmacion_ext; //Compatibility
//End confirmacion_ext_BeforeShow

//Custom Code @14-2A29BDB7
// -------------------------
	if ( CCGetSession('cerrar_ventana') == 1 ) {
		$Component->close_window->SetValue(1);
		CCSetSession('cerrar_ventana', 0);
	}
// -------------------------
//End Custom Code

//Close confirmacion_ext_BeforeShow @4-8A7A2DBE
    return $confirmacion_ext_BeforeShow;
}
//End Close confirmacion_ext_BeforeShow

//confirmacion_ext_ds_AfterExecuteUpdate @4-5AFDE566
function confirmacion_ext_ds_AfterExecuteUpdate(& $sender)
{
    $confirmacion_ext_ds_AfterExecuteUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $confirmacion_ext; //Compatibility
//End confirmacion_ext_ds_AfterExecuteUpdate

//Custom Code @15-2A29BDB7
// -------------------------
    // Write your own code here.
	include_once(RelativePath . "/scripts/myFunctions.php");
	$receptor = $Component->pase_receptor->GetValue();
	$pieza_id = CCGetParam(pieza_id);
	$pase_id = CCGetParam(pase_id);
	confirmar_pase_ext($pieza_id,$receptor,$pase_id);
	CCSetSession('cerrar_ventana', 1);
// -------------------------
//End Custom Code

//Close confirmacion_ext_ds_AfterExecuteUpdate @4-2AE93F8B
    return $confirmacion_ext_ds_AfterExecuteUpdate;
}
//End Close confirmacion_ext_ds_AfterExecuteUpdate

//Page_BeforeInitialize @1-A31C8A29
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $msa_confirm_ext; //Compatibility
//End Page_BeforeInitialize

//Custom Code @41-2A29BDB7
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
