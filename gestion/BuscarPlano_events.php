<?php

//BindEvents Method @1-F32B4C4C
function BindEvents()
{
    global $planos;
    global $CCSEvents;
    $planos->Button_Insert->CCSEvents["OnClick"] = "planos_Button_Insert_OnClick";
    $planos->ds->CCSEvents["BeforeExecuteUpdate"] = "planos_ds_BeforeExecuteUpdate";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
}
//End BindEvents Method

//planos_Button_Insert_OnClick @55-B84721C5
function planos_Button_Insert_OnClick(& $sender)
{
    $planos_Button_Insert_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planos; //Compatibility
//End planos_Button_Insert_OnClick

//Custom Code @68-2A29BDB7
// -------------------------
    // Write your own code here.

CCSetSession('cerrar_ventana', 1);

// -------------------------
//End Custom Code

//Close planos_Button_Insert_OnClick @55-C1CCE9B1
    return $planos_Button_Insert_OnClick;
}
//End Close planos_Button_Insert_OnClick

//planos_ds_BeforeExecuteUpdate @54-BCB2721C
function planos_ds_BeforeExecuteUpdate(& $sender)
{
    $planos_ds_BeforeExecuteUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planos; //Compatibility
//End planos_ds_BeforeExecuteUpdate

//Custom Code @66-2A29BDB7
// -------------------------
    // Write your own code here.
	
	unset($_SESSION['plano_id']);
	$plano_id = CCGetParam("plano_id");
	CCSetSession("plano_id",$plano_id);

	$planos->ds->SQL = "Select 1";
	//echo $planos->ds->SQL;
	//exit;


// -------------------------
//End Custom Code

//Close planos_ds_BeforeExecuteUpdate @54-D66C1A91
    return $planos_ds_BeforeExecuteUpdate;
}
//End Close planos_ds_BeforeExecuteUpdate

//DEL  // -------------------------
//DEL  
//DEL  	// Incluye el archivo de funciones generales
//DEL  	//include_once(RelativePath . "/scripts/myFunctions.php");
//DEL  
//DEL  
//DEL  	// Incluye la gestión de permisos
//DEL  	//include_once(RelativePath . "/scripts/permisos1.php");
//DEL  
//DEL  // -------------------------

//Page_AfterInitialize @1-DEFD75DB
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $BuscarPlano; //Compatibility
//End Page_AfterInitialize

//Custom Code @69-2A29BDB7
// -------------------------
    // Write your own code here.

global $planos;

if ( CCGetSession('cerrar_ventana') == 1 ) {
	$planos->close_window->SetValue(1);
	CCSetSession('cerrar_ventana', 0);
	}



// -------------------------
//End Custom Code

//Close Page_AfterInitialize @1-379D319D
    return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize
?>
