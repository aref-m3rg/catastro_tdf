<?php

//BindEvents Method @1-0370DB51
function BindEvents()
{
    global $previsados_contestaciones;
    global $CCSEvents;
    $previsados_contestaciones->CCSEvents["BeforeShowRow"] = "previsados_contestaciones_BeforeShowRow";
}
//End BindEvents Method

//previsados_contestaciones_BeforeShowRow @6-BC366AC6
function previsados_contestaciones_BeforeShowRow(& $sender)
{
    $previsados_contestaciones_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_contestaciones; //Compatibility
//End previsados_contestaciones_BeforeShowRow

//Custom Code @17-2A29BDB7
// -------------------------
	$db = new clsDBtdf_nuevo();
    if($previsados_contestaciones->DataSource->f('user_id')){
		$nombre = CCDLookUp("prof_nombre","profesionales","user_id=".$previsados_contestaciones->DataSource->f('user_id'),$db);
		$previsados_contestaciones->usuario_nombre->SetValue($nombre);
	}elseif($previsados_contestaciones->DataSource->f('usuario_id')){
		$nombre = CCDLookUp("usuario_nombre","_usuarios","usuario_id=".$previsados_contestaciones->DataSource->f('usuario_id'),$db);
		$previsados_contestaciones->usuario_nombre->SetValue($nombre);
	}else{
		$previsados_contestaciones->usuario_nombre->SetValue("NS/NC");
	}
	if($previsados_contestaciones->DataSource->f('previsado_contesta_arch_ubica') != ''){
		$nombre_archivo = $previsados_contestaciones->DataSource->f('previsado_contesta_arch_nom');
		$nombre_guardado = $previsados_contestaciones->DataSource->f('previsado_contesta_arch_ubica');
		$previsados_contestaciones->previsado_contestacion_texto->SetValue($previsados_contestaciones->previsado_contestacion_texto->GetValue()."<br><br><b>Adjunto: <a href='../../catastro_tdf_nuevo/previsado/archivos_observaciones/$nombre_guardado' download='$nombre_archivo'>$nombre_archivo</a></b>");
	}
// -------------------------
//End Custom Code

//Close previsados_contestaciones_BeforeShowRow @6-C0ECD3E7
    return $previsados_contestaciones_BeforeShowRow;
}
//End Close previsados_contestaciones_BeforeShowRow

//Page_BeforeInitialize @1-A5BA8935
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsado_ifame_contestaciones; //Compatibility
//End Page_BeforeInitialize

//Custom Code @5-2A29BDB7
// -------------------------
    // Write your own code here.
	include_once(RelativePath . "/scripts/permisos1.php");
// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize
?>
