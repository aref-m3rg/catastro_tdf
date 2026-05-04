<?php
//BindEvents Method @1-3D426412
function BindEvents()
{
    global $piezas_piezas_tipos;
    global $pase;
    global $CCSEvents;
    $piezas_piezas_tipos->externo->CCSEvents["BeforeShow"] = "piezas_piezas_tipos_externo_BeforeShow";
    $pase->des_unidad_id->CCSEvents["BeforeShow"] = "pase_des_unidad_id_BeforeShow";
    $pase->CCSEvents["OnValidate"] = "pase_OnValidate";
    $pase->CCSEvents["AfterInsert"] = "pase_AfterInsert";
    $pase->CCSEvents["BeforeShow"] = "pase_BeforeShow";
}
//End BindEvents Method

//piezas_piezas_tipos_externo_BeforeShow @80-C199E7E2
function piezas_piezas_tipos_externo_BeforeShow(& $sender)
{
    $piezas_piezas_tipos_externo_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $piezas_piezas_tipos; //Compatibility
//End piezas_piezas_tipos_externo_BeforeShow

//Custom Code @81-2A29BDB7
// -------------------------

	$db = new clsDBmesa();
	$db2 = new clsDBmesa();
	$pieza_id = CCGetParam('pieza_id');
	$unidad_autorizada = CCDLookUp("unidad_id","unidades","unidad_pase_externo = '1' AND unidad_id = " . CCGetSession(unidad_id), $db2);
	$SQL = "SELECT pendiente_unidad_id, pase_confir_ext  FROM pases WHERE pieza_id = $pieza_id AND pendiente_unidad_id > 0";
	$db->query($SQL);

	$html="";

	if($db->next_record() && $unidad_autorizada > 0){
		
		$unidad_destino = CCDLookUp("unidad_nombre","unidades","unidad_id = " . $db->f('pendiente_unidad_id'), $db2);

		if($db->f('pase_confir_ext')){
			$confirma="SI";
		}else{
			$confirma="NO";
		}

	    $html="<tr class='Row'>
	            <th scope='row' class='th'>Unidad Extrerna</th>
				<td><b>$unidad_destino&nbsp;</b></td>
	           </tr>
			   <tr class='Row'>
	            <th scope='row' class='th'>Requiere Confirmacion</th>
				<td><b>$confirma&nbsp;</b></td>
	           </tr>
			   ";		
	}
	$piezas_piezas_tipos->externo->SetValue($html);
	

	$db->close();
	$db2->close();
// -------------------------
//End Custom Code

//Close piezas_piezas_tipos_externo_BeforeShow @80-37B159A2
    return $piezas_piezas_tipos_externo_BeforeShow;
}
//End Close piezas_piezas_tipos_externo_BeforeShow

//pase_des_unidad_id_BeforeShow @56-A06D2005
function pase_des_unidad_id_BeforeShow(& $sender)
{
    $pase_des_unidad_id_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $pase; //Compatibility
//End pase_des_unidad_id_BeforeShow

//Close pase_des_unidad_id_BeforeShow @56-3D8CA23C
    return $pase_des_unidad_id_BeforeShow;
}
//End Close pase_des_unidad_id_BeforeShow

//pase_OnValidate @22-223D6FA4
function pase_OnValidate(& $sender)
{
    $pase_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $pase; //Compatibility
//End pase_OnValidate

//Custom Code @51-2A29BDB7
// -------------------------
    // Write your own code here.
	//validar que no se pase 2 veces seguidas del mismo origen
	$db = new clsDBmesa();
	$pieza_id = CCGetParam('pieza_id');
	$ultimo_origen = CCDLookUp("ori_unidad_id","pases","pieza_id = $pieza_id AND pase_nro IS NULL  ORDER BY pase_id DESC LIMIT 1",$db);
	
	if($ultimo_origen == CCGetSession(unidad_id)){
		$Component->Errors->AddError('Esta pieza ya ha sido pasada, por favor verifique.');
	}
/*
	$tipo_tramite_id = CCDLookUp("tipo_tramites_id","piezas","pieza_id = $pieza_id",$db);
	$pasa = CCDLookUp("COUNT(*)","unidades_tipo_tramites","tipo_tramites_id = $tipo_tramite_id AND unidad_id = ".$Component->des_unidad_id->GetValue(),$db);
	//echo "tipo tramite: ".$tipo_tramite_id."| unidad_id".$Component->des_unidad_id->GetValue();exit;
	if($pasa == 0){
		//$Component->Errors->AddError('La pieza no se puede pasar a un area no asignada.');
	}*/
	$db->close();

// -------------------------
//End Custom Code

//Close pase_OnValidate @22-94849C92
    return $pase_OnValidate;
}
//End Close pase_OnValidate

//pase_AfterInsert @22-1934C77C
function pase_AfterInsert(& $sender)
{
    $pase_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $pase; //Compatibility
//End pase_AfterInsert

//Custom Code @52-2A29BDB7
// -------------------------
    // Write your own code here.

	
	$pieza = CCGetParam(pieza_id); //pieza a pasar
	$fojas = $Component->pase_n_fojas->GetValue();//cantidad de fojas
	$origen = CCGetSession('unidad_id');//unidad desde donde se pasa
	$destino = $Component->des_unidad_id->GetValue();//unidad destino del pase
	$comentario	= $Component->pase_comentario->GetValue();//comentario en pase
	$conf_ext = $pase->pase_confir_ext->GetValue();//si se espera confirmacion externa
	if($conf_ext == ''){
		$conf_ext = 0;
	}
	include_once(RelativePath . "/scripts/myFunctions.php");
	pasar_pieza($pieza,$fojas,$origen,$destino,$comentario,$conf_ext);
	
// -------------------------
//End Custom Code

//Close pase_AfterInsert @22-F3638CDB
    return $pase_AfterInsert;
}
//End Close pase_AfterInsert

//pase_BeforeShow @22-60D305BF
function pase_BeforeShow(& $sender)
{
    $pase_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $pase; //Compatibility
//End pase_BeforeShow

//Custom Code @69-2A29BDB7
// -------------------------
	$db = new clsDBunidades();
	$pase_externo = CCDLookUp('unidad_pase_externo','unidades','unidad_id = ' . CCGetSession(unidad_id),$db);
	$unidad_autorizada = CCDLookUp("unidad_id","unidades","unidad_pase_externo = '1' AND unidad_id = " . CCGetSession(unidad_id), $db);
	$Component->unidad_id->SetValue($unidad_autorizada);
	if(!$pase_externo){
		//$Component->Panel1->Visible = false;
	}
// -------------------------
//End Custom Code

//Close pase_BeforeShow @22-AB7FF81B
    return $pase_BeforeShow;
}
//End Close pase_BeforeShow

//Page_BeforeInitialize @1-D9A2D1A8
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $msa_pase; //Compatibility
//End Page_BeforeInitialize

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
