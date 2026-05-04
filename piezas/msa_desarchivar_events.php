<?php
//BindEvents Method @1-CE41BA4B
function BindEvents()
{
    global $confirmacion;
    global $CCSEvents;
    $confirmacion->CCSEvents["BeforeShow"] = "confirmacion_BeforeShow";
    $confirmacion->ds->CCSEvents["AfterExecuteUpdate"] = "confirmacion_ds_AfterExecuteUpdate";
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
	
	$txt = "";	

	if($Component->ds->f('adjuntos') > 0){
		$txt = " y sus piezas adjuntas (" . $Component->ds->f('adjuntos') . ")";
	}

	$Component->complemento->SetValue($txt);
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
	$pieza_id = CCGetParam(pieza_id);
	desarchivar_pieza($pieza_id);
	CCSetSession('cerrar_ventana', 1);

// -------------------------
//End Custom Code

//Close confirmacion_ds_AfterExecuteUpdate @4-FABF65E5
    return $confirmacion_ds_AfterExecuteUpdate;
}
//End Close confirmacion_ds_AfterExecuteUpdate

//Page_AfterInitialize @1-9E78D547
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $msa_desarchivar; //Compatibility
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
