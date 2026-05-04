<?php

//BindEvents Method @1-7A61C1DD
function BindEvents()
{
    global $tramites;
    global $tipos_tramites;
    global $CCSEvents;
    $tramites->s_tipo_tramites_id->CCSEvents["BeforeShow"] = "tramites_s_tipo_tramites_id_BeforeShow";
    $tipos_tramites->Button1->CCSEvents["OnClick"] = "tipos_tramites_Button1_OnClick";
    $tipos_tramites->CCSEvents["BeforeShow"] = "tipos_tramites_BeforeShow";
}
//End BindEvents Method

//tramites_s_tipo_tramites_id_BeforeShow @9-C24431EA
function tramites_s_tipo_tramites_id_BeforeShow(& $sender)
{
    $tramites_s_tipo_tramites_id_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tramites; //Compatibility
//End tramites_s_tipo_tramites_id_BeforeShow

//Close tramites_s_tipo_tramites_id_BeforeShow @9-284AFC41
    return $tramites_s_tipo_tramites_id_BeforeShow;
}
//End Close tramites_s_tipo_tramites_id_BeforeShow

//tipos_tramites_Button1_OnClick @19-CDE9F45B
function tipos_tramites_Button1_OnClick(& $sender)
{
    $tipos_tramites_Button1_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tipos_tramites; //Compatibility
//End tipos_tramites_Button1_OnClick

//Custom Code @20-2A29BDB7
// -------------------------
    $tipo_tramites_id = CCGetParam('s_tipo_tramites_id');
  	$db = new clsDBmesa();
  
  	$SQL = "DELETE FROM unidades_tipo_tramites WHERE tipo_tramites_id = " . $tipo_tramites_id;
  	$db->query($SQL);
  	
  	if(CCGetParam(unidad_id)){
  		$s = CCGetParam(unidad_id);
  		while (list ($clave, $val) = each ($s)) {
   	   		$SQL = "INSERT INTO unidades_tipo_tramites
  		   			  SET tipo_tramites_id = $tipo_tramites_id,
  					      unidad_id = $val";
  
  		   $db->query($SQL);
  		} 
  	}
  	$db->close();
// -------------------------
//End Custom Code

//Close tipos_tramites_Button1_OnClick @19-8D3F09DC
    return $tipos_tramites_Button1_OnClick;
}
//End Close tipos_tramites_Button1_OnClick

//tipos_tramites_BeforeShow @12-3DE37728
function tipos_tramites_BeforeShow(& $sender)
{
    $tipos_tramites_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tipos_tramites; //Compatibility
//End tipos_tramites_BeforeShow

//Custom Code @18-2A29BDB7
// -------------------------
    if(!CCGetParam('s_tipo_tramites_id')){
		$tipos_tramites->Visible=false;
	}
	$db = new clsDBmesa();
	$SQL = "SELECT * 
			FROM unidades_tipo_tramites 
			WHERE tipo_tramites_id = " . CCGetParam('s_tipo_tramites_id');
	$db->query($SQL);
	while($db->next_record()){
		$a[] = $db->f('unidad_id');
	}
	$db->close();
	//print_r($a);
  	$Component->unidad_id->Value = $a;
// -------------------------
//End Custom Code

//Close tipos_tramites_BeforeShow @12-A44DFD7A
    return $tipos_tramites_BeforeShow;
}
//End Close tipos_tramites_BeforeShow

//Page_BeforeInitialize @1-CFAD6A62
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $pa_mesa_tipos_unidades; //Compatibility
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
