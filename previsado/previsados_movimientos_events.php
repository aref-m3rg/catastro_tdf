<?php

//BindEvents Method @1-EF57F84B
function BindEvents()
{
    global $previsados_movimientosSearch;
    global $previsados_movimientos;
    global $CCSEvents;
    $previsados_movimientosSearch->CCSEvents["BeforeShow"] = "previsados_movimientosSearch_BeforeShow";
    $previsados_movimientos->CCSEvents["BeforeShow"] = "previsados_movimientos_BeforeShow";
    $previsados_movimientos->CCSEvents["BeforeShowRow"] = "previsados_movimientos_BeforeShowRow";
}
//End BindEvents Method

//previsados_movimientosSearch_BeforeShow @7-709BCB91
function previsados_movimientosSearch_BeforeShow(& $sender)
{
    $previsados_movimientosSearch_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_movimientosSearch; //Compatibility
//End previsados_movimientosSearch_BeforeShow

//Custom Code @25-2A29BDB7
// -------------------------
	if(CCGetParam('origen') != ''){
		$previsados_movimientosSearch->Visible = FALSE;
	}
// -------------------------
//End Custom Code

//Close previsados_movimientosSearch_BeforeShow @7-01F6A3F2
    return $previsados_movimientosSearch_BeforeShow;
}
//End Close previsados_movimientosSearch_BeforeShow

//previsados_movimientos_BeforeShow @6-94B683A0
function previsados_movimientos_BeforeShow(& $sender)
{
    $previsados_movimientos_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_movimientos; //Compatibility
//End previsados_movimientos_BeforeShow

//Custom Code @27-2A29BDB7
// -------------------------
	$previsados_movimientos->Link1->Visible = FALSE;
	if(CCGetParam('origen') != ''){
    	$previsados_movimientos->Link1->Visible = TRUE;
	}
// -------------------------
//End Custom Code

//Close previsados_movimientos_BeforeShow @6-10A27699
    return $previsados_movimientos_BeforeShow;
}
//End Close previsados_movimientos_BeforeShow

//previsados_movimientos_BeforeShowRow @6-E1B11140
function previsados_movimientos_BeforeShowRow(& $sender)
{
    $previsados_movimientos_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_movimientos; //Compatibility
//End previsados_movimientos_BeforeShowRow

//Custom Code @29-2A29BDB7
// -------------------------
	$usuario_id = $previsados_movimientos->DataSource->f('usuario_id');
	$db = new clsDBtdf_nuevo();
	if($previsados_movimientos->DataSource->f('tipo_usuario') == 1){
		$tipo_usuario = "(Profesional)";
		$nombre = CCDLookUp("prof_nombre","profesionales","user_id=$usuario_id",$db);
		$previsados_movimientos->usuario_id->SetValue($nombre);
	}else{
		$nombre = CCDLookUp("usuario_nombre","_usuarios","usuario_id=$usuario_id",$db);
		$tipo_usuario = "(Operador)";
		$previsados_movimientos->usuario_id->SetValue($nombre);
	}
	$previsados_movimientos->tipo_usuario->SetValue($tipo_usuario);
	$db->close();
// -------------------------
//End Custom Code

//Close previsados_movimientos_BeforeShowRow @6-61B4508D
    return $previsados_movimientos_BeforeShowRow;
}
//End Close previsados_movimientos_BeforeShowRow

//Page_BeforeInitialize @1-DCF67E62
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_movimientos; //Compatibility
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
