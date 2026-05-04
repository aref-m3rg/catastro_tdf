<?php
//BindEvents Method @1-6E503B33
function BindEvents()
{
    global $confirmacion;
    global $CCSEvents;
    $confirmacion->CCSEvents["BeforeShow"] = "confirmacion_BeforeShow";
    $confirmacion->ds->CCSEvents["AfterExecuteUpdate"] = "confirmacion_ds_AfterExecuteUpdate";
    $confirmacion->CCSEvents["OnValidate"] = "confirmacion_OnValidate";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
}
//End BindEvents Method

//confirmacion_BeforeShow @4-0B01A899
function confirmacion_BeforeShow(& $sender)
{
    $confirmacion_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $confirmacion; //Compatibility
//End confirmacion_BeforeShow

//Custom Code @34-2A29BDB7
// -------------------------
    // Write your own code here.
	//echo CCGetParam('pieza_id') . " " . CCGetParam('pase_id');
// -------------------------
//End Custom Code

//Close confirmacion_BeforeShow @4-D8584216
    return $confirmacion_BeforeShow;
}
//End Close confirmacion_BeforeShow

//confirmacion_ds_AfterExecuteUpdate @4-FF564F92
function confirmacion_ds_AfterExecuteUpdate(& $sender)
{
    $confirmacion_ds_AfterExecuteUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $confirmacion; //Compatibility
//End confirmacion_ds_AfterExecuteUpdate

//Custom Code @36-2A29BDB7
// -------------------------
    // Write your own code here.
	include_once(RelativePath . "/scripts/myFunctions.php");
	cancelar_pase(CCGetParam('pieza_id'));

	//para cerrar ventana
	CCSetSession('cerrar_ventana', 1);
// -------------------------
//End Custom Code

//Close confirmacion_ds_AfterExecuteUpdate @4-FABF65E5
    return $confirmacion_ds_AfterExecuteUpdate;
}
//End Close confirmacion_ds_AfterExecuteUpdate

//confirmacion_OnValidate @4-BD4945FD
function confirmacion_OnValidate(& $sender)
{
    $confirmacion_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $confirmacion; //Compatibility
//End confirmacion_OnValidate

//Custom Code @41-2A29BDB7
// -------------------------
    // Write your own code here.
	//controlar que no haya sido confirmado ya en destino
	if(CCGetParam(pieza_id) && CCGetParam(pase_id)){

		$pieza_id = CCGetParam(pieza_id);
		$pase_id = CCGetParam(pase_id);
		$confirmado = CCDLookUp('pase_confirmado','pases',"pase_id = $pase_id", new clsDBmesa());
		//echo $activo;
		if($confirmado == 1){
			$Component->Errors->AddError("Parece que este pase ya ha sido confirmado en destino. Por favor verifique");
		}
		
	}
// -------------------------
//End Custom Code

//Close confirmacion_OnValidate @4-E7A3269F
    return $confirmacion_OnValidate;
}
//End Close confirmacion_OnValidate

//Page_AfterInitialize @1-112A48F6
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $msa_cancel; //Compatibility
//End Page_AfterInitialize

//Custom Code @35-2A29BDB7
// -------------------------
    // Write your own code here.
	
	if ( CCGetSession('cerrar_ventana') == 1 ) {
		$Component->confirmacion->close_window->SetValue(1);
		CCSetSession('cerrar_ventana', 0);
	}
// -------------------------
//End Custom Code

//Close Page_AfterInitialize @1-379D319D
    return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize


?>
