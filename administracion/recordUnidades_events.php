<?php
//BindEvents Method @1-7876EA54
function BindEvents()
{
    global $unidades;
    global $unidades_param;
    $unidades->CCSEvents["AfterInsert"] = "unidades_AfterInsert";
    $unidades_param->unidades_param_TotalRecords->CCSEvents["BeforeShow"] = "unidades_param_unidades_param_TotalRecords_BeforeShow";
    $unidades_param->CCSEvents["BeforeShow"] = "unidades_param_BeforeShow";
    $unidades_param->CCSEvents["AfterSubmit"] = "unidades_param_AfterSubmit";
}
//End BindEvents Method

//unidades_AfterInsert @2-F6EF35EB
function unidades_AfterInsert(& $sender)
{
    $unidades_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $unidades; //Compatibility
//End unidades_AfterInsert

//Custom Code @50-2A29BDB7
// -------------------------
    // Write your own code here.
	global $Redirect;
	$unidad_id = mysql_insert_id();
	$Redirect = "recordUnidades.php?unidad_id=$unidad_id";
// -------------------------
//End Custom Code

//Close unidades_AfterInsert @2-181E73E4
    return $unidades_AfterInsert;
}
//End Close unidades_AfterInsert

//unidades_param_unidades_param_TotalRecords_BeforeShow @18-7AD03D5D
function unidades_param_unidades_param_TotalRecords_BeforeShow(& $sender)
{
    $unidades_param_unidades_param_TotalRecords_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $unidades_param; //Compatibility
//End unidades_param_unidades_param_TotalRecords_BeforeShow

//Retrieve number of records @19-ABE656B4
    $Component->SetValue($Container->DataSource->RecordsCount);
//End Retrieve number of records

//Close unidades_param_unidades_param_TotalRecords_BeforeShow @18-567342B8
    return $unidades_param_unidades_param_TotalRecords_BeforeShow;
}
//End Close unidades_param_unidades_param_TotalRecords_BeforeShow

//unidades_param_BeforeShow @16-C7B5EB01
function unidades_param_BeforeShow(& $sender)
{
    $unidades_param_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $unidades_param; //Compatibility
//End unidades_param_BeforeShow

//Custom Code @38-2A29BDB7
// -------------------------
    // Write your own code here.
	if(!CCGetParam(unidad_id)){
		$Component->Visible = False;
	}
// -------------------------
//End Custom Code

//Close unidades_param_BeforeShow @16-5B0F6281
    return $unidades_param_BeforeShow;
}
//End Close unidades_param_BeforeShow

//unidades_param_AfterSubmit @16-D3D42CC8
function unidades_param_AfterSubmit(& $sender)
{
    $unidades_param_AfterSubmit = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $unidades_param; //Compatibility
//End unidades_param_AfterSubmit

//Custom Code @44-2A29BDB7
// -------------------------
    // Write your own code here.
	$db = new clsDBunidades();
	$unidad_id = CCGetParam(unidad_id);
	
	//desactivar todos los parametros
	$SQL_UPD = "UPDATE unidades_param SET unidad_p_activo = 0 WHERE unidad_id = $unidad_id";
	$db->query($SQL_UPD);

	//activar el actual
	$unidad_p_id = CCDLookUp('unidad_p_id','unidades_param',"unidad_id = $unidad_id AND unidad_p_f_vig <= NOW() ORDER BY unidad_p_f_vig DESC LIMIT 1",$db);
	
	if($unidad_p_id){
		$SQL_UPD = "UPDATE unidades_param 
					SET unidad_p_activo = 1 
					WHERE unidad_p_id = $unidad_p_id";
	
		//echo $SQL_UPD;exit();
		$db->query($SQL_UPD);
		
		
	} else {
		//no hay parametros con fecha de vigencia menores a hoy
		$unidad_p_id = CCDLookUp('unidad_p_id','unidades_param',"unidad_id = $unidad_id AND unidad_p_f_vig >= NOW()ORDER BY unidad_p_f_vig ASC LIMIT 1",$db);
		$SQL_UPD = "UPDATE unidades_param 
					SET unidad_p_activo = 1 
					WHERE unidad_p_id = $unidad_p_id";
		
		$db->query($SQL_UPD);
	}

	if($unidad_p_id){
		//el parametro activo toma el nombre
		$SQL = "UPDATE unidades_param
				INNER JOIN unidades USING(unidad_id)
				SET unidad_p_nombre = unidad_nombre
				WHERE unidad_p_id = $unidad_p_id";
		$db->query($SQL);
	}

	$db->close();



// -------------------------
//End Custom Code

//Close unidades_param_AfterSubmit @16-140929AD
    return $unidades_param_AfterSubmit;
}
//End Close unidades_param_AfterSubmit


?>
