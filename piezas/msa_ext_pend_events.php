<?php

//BindEvents Method @1-B696F519
function BindEvents()
{
    global $recibidas;
    global $CCSEvents;
    $recibidas->CCSEvents["BeforeShowRow"] = "recibidas_BeforeShowRow";
    $recibidas->CCSEvents["BeforeShow"] = "recibidas_BeforeShow";
}
//End BindEvents Method

//recibidas_BeforeShowRow @6-DF5613EF
function recibidas_BeforeShowRow(& $sender)
{
    $recibidas_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $recibidas; //Compatibility
//End recibidas_BeforeShowRow

//Custom Code @18-2A29BDB7
// -------------------------
    // Write your own code here.

	$qs = CCAddParam('pieza_id=' . $Component->ds->f('pieza_id'),'pase_id',$Component->ds->f('pase_id'));
	$lnk = 'msa_confirm_ext.php?' . $qs;
	$newlnk="$lnk\" onclick=\"javascript:window.open(this.href,'confirm_externo','width=430,height=200,top='+(screen.height-200)/2+',left='+(screen.width-430)/2+',scrollbars=no,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no');return false;";
	$Component->confirmLnk->SetLink($newlnk);
	if($recibidas->pase_confir_ext->GetValue() == 1){
		$recibidas->pase_confir_ext->SetValue("<font color='green'><b>SI</b></font>");
	}else{
		$recibidas->pase_confir_ext->SetValue("<font color='red'><b>NO</b></font>");
	}
// -------------------------
//End Custom Code

//Close recibidas_BeforeShowRow @6-29E40000
    return $recibidas_BeforeShowRow;
}
//End Close recibidas_BeforeShowRow

//recibidas_BeforeShow @6-8ED81E8A
function recibidas_BeforeShow(& $sender)
{
    $recibidas_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $recibidas; //Compatibility
//End recibidas_BeforeShow

//Custom Code @19-2A29BDB7
// -------------------------
//cantidad de pases realizado externamente al area actual que no estan confirmados
    $db = new clsDBmesa();
	$SQL= "SELECT count(*) AS cant
			FROM piezas
			INNER JOIN pases ON pases.pieza_id = piezas.pieza_id
			INNER JOIN piezas_tipos ON piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id
			INNER JOIN unidades_param ON pases.ori_unidad_id = unidades_param.unidad_id
			LEFT JOIN adjuntos ON piezas.pieza_id = adjuntos.adj_pieza_id
			WHERE pases.pase_activo = 1
			AND pases.pase_confirmado = 1
			AND pases.pase_confir_ext = 1
			AND unidades_param.unidad_p_activo = 1
			AND pases.ori_unidad_id = ".CCGetSession('unidad_id')."
			AND adjuntos.adjunto_id IS NULL ";
	$db->query($SQL);
	if($db->next_record()){
		$Component->cant_pend_ext->SetValue("(".$db->f('cant').")");
	}
	$db->close();
// -------------------------
//End Custom Code

//Close recibidas_BeforeShow @6-178F7A74
    return $recibidas_BeforeShow;
}
//End Close recibidas_BeforeShow

//Page_BeforeInitialize @1-98917CEF
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $msa_ext_pend; //Compatibility
//End Page_BeforeInitialize

//Custom Code @5-2A29BDB7
// -------------------------
	if(CCGetParam('cambio')){
		header("Location: msa_principal.php");
	}
	// Incluye el archivo de funciones generales
	include_once(RelativePath . "/scripts/myFunctions.php");


	// Incluye la gestión de permisos
	//include_once(RelativePath . "/scripts/permisos1.php");

// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize
?>
