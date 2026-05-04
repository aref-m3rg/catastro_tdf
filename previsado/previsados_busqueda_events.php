<?php
//BindEvents Method @1-2012244F
function BindEvents()
{
    global $previsados_cargas;
    global $CCSEvents;
    $previsados_cargas->CCSEvents["BeforeShowRow"] = "previsados_cargas_BeforeShowRow";
    $previsados_cargas->ds->CCSEvents["BeforeBuildSelect"] = "previsados_cargas_ds_BeforeBuildSelect";
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
}
//End BindEvents Method

//previsados_cargas_BeforeShowRow @4-6472FF9E
function previsados_cargas_BeforeShowRow(& $sender)
{
    $previsados_cargas_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_cargas; //Compatibility
//End previsados_cargas_BeforeShowRow

//Custom Code @62-2A29BDB7
// -------------------------
    $previsado_carga_id = $previsados_cargas->DataSource->f('previsado_carga_id');
	$db = new clsDBtdf_nuevo();
	//usuario que marco para responder
	$usuario_catastro = CCDLookUp("_usuarios.usuario_nombre","previsados_respuestas INNER JOIN _usuarios ON previsados_respuestas.usuario_id=_usuarios.usuario_id","previsado_carga_id=$previsado_carga_id",$db);
	$previsados_cargas->usuario_catastro->SetValue("<b>".$usuario_catastro."</b>");
	//Lista de titulares
	$SQL="SELECT * FROM previsados_titulares WHERE previsado_carga_id=$previsado_carga_id";	
	$db->query($SQL);
	if($db->num_rows('previsado_titular_id')){
		$html = "<div id='content'><ol style='margin-left:0;margin-top:0;margin-bottom:0;padding-left:0;list-style-position:inside'>";
		while($db->next_record()){
			$html .= "<li>".$db->f('previsado_titular_nombre')."</li>";
		}
		$html .= "</ol></div>";
	}else{
		$html = "<font color='RED'><b>NO TIENE</b></font>";
	}
	$previsados_cargas->titulares->SetValue($html);
	
	
	$previsado_tipo_estado_carga_id = $previsados_cargas->DataSource->f('previsado_tipo_estado_carga_id');
	if($previsado_tipo_estado_carga_id){
		$previsados_cargas->ImageLink1->Visible = TRUE;
	}else{
		$previsados_cargas->ImageLink1->Visible = FALSE;
	}
	//---------------------------icono-----------------------------
	$previsados_cargas->icono->SetValue('');
	$cant = CCDLookUp("COUNT(*)","previsados_movimientos","previsado_carga_id=$previsado_carga_id",$db);
	if($cant){
		$previsados_cargas->icono->SetValue("<a href='previsados_movimientos.php?origen=previsados_busqueda.php&s_previsado_carga_id=$previsado_carga_id'><img src='../iconos/16x16/start-here.gif'><a><b>($cant)</b>");
	}
	$db->close();
// -------------------------
//End Custom Code

//Close previsados_cargas_BeforeShowRow @4-5040DCDB
    return $previsados_cargas_BeforeShowRow;
}
//End Close previsados_cargas_BeforeShowRow

//previsados_cargas_ds_BeforeBuildSelect @4-965DA964
function previsados_cargas_ds_BeforeBuildSelect(& $sender)
{
    $previsados_cargas_ds_BeforeBuildSelect = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_cargas; //Compatibility
//End previsados_cargas_ds_BeforeBuildSelect

//Custom Code @142-2A29BDB7
// -------------------------
    //echo $previsados_cargas->DataSource->Where;
	if(CCGetParam('s_user_id')){
		$db = new clsDBtdf_nuevo();
		$user_id = CCDLookUp("user_id","profesionales","prof_id=".CCGetParam('s_user_id'),$db);
		if(!$user_id){
			$user_id = 0;
		}
		$previsados_cargas->DataSource->Where = str_replace("previsados_cargas.user_id = ".CCGetParam('s_user_id'),"previsados_cargas.user_id = $user_id",$previsados_cargas->DataSource->Where);
	}
// -------------------------
//End Custom Code

//Close previsados_cargas_ds_BeforeBuildSelect @4-325783A5
    return $previsados_cargas_ds_BeforeBuildSelect;
}
//End Close previsados_cargas_ds_BeforeBuildSelect

//Page_BeforeShow @1-8E350A43
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_busqueda; //Compatibility
//End Page_BeforeShow

//Custom Code @63-2A29BDB7
// -------------------------
    CCSetSession('previsado_respuesta_id', '');
// -------------------------
//End Custom Code

//Close Page_BeforeShow @1-4BC230CD
    return $Page_BeforeShow;
}
//End Close Page_BeforeShow

//Page_BeforeInitialize @1-D2CC0CA5
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_busqueda; //Compatibility
//End Page_BeforeInitialize

//Custom Code @67-2A29BDB7
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
