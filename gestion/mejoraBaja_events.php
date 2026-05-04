<?php
//BindEvents Method @1-8D6BD13C
function BindEvents()
{
    global $mejoras;
    global $CCSEvents;
    $mejoras->ds->CCSEvents["AfterExecuteUpdate"] = "mejoras_ds_AfterExecuteUpdate";
    $mejoras->CCSEvents["AfterUpdate"] = "mejoras_AfterUpdate";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
}
//End BindEvents Method

//mejoras_ds_AfterExecuteUpdate @2-7A069D26
function mejoras_ds_AfterExecuteUpdate(& $sender)
{
    $mejoras_ds_AfterExecuteUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras; //Compatibility
//End mejoras_ds_AfterExecuteUpdate

//Custom Code @12-2A29BDB7
// -------------------------
	CCSetSession('cerrar_ventana', 1);
// -------------------------
//End Custom Code

//Close mejoras_ds_AfterExecuteUpdate @2-66CCB8AC
    return $mejoras_ds_AfterExecuteUpdate;
}
//End Close mejoras_ds_AfterExecuteUpdate

//mejoras_AfterUpdate @2-C6123E85
function mejoras_AfterUpdate(& $sender)
{
    $mejoras_AfterUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras; //Compatibility
//End mejoras_AfterUpdate

//Custom Code @13-2A29BDB7
// -------------------------
    $db = new clsDBtdf_nuevo();
	$db->query("UPDATE mejoras SET tipo_estado_id = 2, mejora_f_baja = '".date('Y-m-d H:i:s')."' WHERE mejora_id = ".CCGetParam('mejora_id'));
	$db->close();
// -------------------------
//End Custom Code

//Close mejoras_AfterUpdate @2-A35E555D
    return $mejoras_AfterUpdate;
}
//End Close mejoras_AfterUpdate

//Page_AfterInitialize @1-4C025E96
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoraBaja; //Compatibility
//End Page_AfterInitialize

//Custom Code @11-2A29BDB7
// -------------------------
    if ( CCGetSession('cerrar_ventana') == 1 ) {
		$Component->mejoras->close_window->SetValue(1);
		CCSetSession('cerrar_ventana', 0);
	}
// -------------------------
//End Custom Code

//Close Page_AfterInitialize @1-379D319D
    return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize


?>
