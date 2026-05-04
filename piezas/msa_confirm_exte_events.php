<?php

//BindEvents Method @1-E0213923
function BindEvents()
{
    global $confirmacion_ext;
    global $CCSEvents;
    $confirmacion_ext->CCSEvents["BeforeShow"] = "confirmacion_ext_BeforeShow";
    $confirmacion_ext->ds->CCSEvents["AfterExecuteUpdate"] = "confirmacion_ext_ds_AfterExecuteUpdate";
    $confirmacion_ext->CCSEvents["OnValidate"] = "confirmacion_ext_OnValidate";
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
    // Write your own code here.
	//echo CCGetParam('pieza_id') . " " . CCGetParam('pase_id');
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
	//confirmar_pase_ext($pieza_id,$receptor);
	CCSetSession('cerrar_ventana', 1);
// -------------------------
//End Custom Code

//Close confirmacion_ext_ds_AfterExecuteUpdate @4-2AE93F8B
    return $confirmacion_ext_ds_AfterExecuteUpdate;
}
//End Close confirmacion_ext_ds_AfterExecuteUpdate

//confirmacion_ext_OnValidate @4-60F8E0EE
function confirmacion_ext_OnValidate(& $sender)
{
    $confirmacion_ext_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $confirmacion_ext; //Compatibility
//End confirmacion_ext_OnValidate

//Custom Code @16-2A29BDB7
// -------------------------
    // Write your own code here.
	//controlar que efectivamente se este confirmande ese pase y no otro
	/*
	if(CCGetParam(pieza_id) && CCGetParam(pase_id)){

		$pieza_id = CCGetParam(pieza_id);
		$pase_id = CCGetParam(pase_id);
		$confirmado = CCDLookUp('pase_confirmado','pases',"pase_id = $pase_id", new clsDBmesa());
		if($confirmado == 1){
			$Component->Errors->AddError("Parece que este pase ya ha sido confirmado. Por favor verifique");
		}
		
	}
	*/
// -------------------------
//End Custom Code

//Close confirmacion_ext_OnValidate @4-B5814937
    return $confirmacion_ext_OnValidate;
}
//End Close confirmacion_ext_OnValidate

//Page_BeforeInitialize @1-797173AB
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $msa_confirm_exte; //Compatibility
//End Page_BeforeInitialize

//Custom Code @41-2A29BDB7
// -------------------------
	if ( CCGetSession('cerrar_ventana') == 1 ) {
		$Component->confirmacion_ext->close_window->SetValue(1);
		CCSetSession('cerrar_ventana', 0);
	}
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
