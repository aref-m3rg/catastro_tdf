<?php
// //Events @1-F81417CB

//DEL  // -------------------------
//DEL  
//DEL  // -------------------------

//msa_pend_ext_recibidas_BeforeShowRow @2-9399CCF4
function msa_pend_ext_recibidas_BeforeShowRow(& $sender)
{
    $msa_pend_ext_recibidas_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $msa_pend_ext; //Compatibility
//End msa_pend_ext_recibidas_BeforeShowRow

//Custom Code @15-2A29BDB7
// -------------------------
    // Write your own code here.

	$qs = CCAddParam('pieza_id=' . $Component->ds->f('pieza_id'),'pase_id',$Component->ds->f('pase_id'));
	$lnk = 'msa_confirm.php?' . $qs;
	$newlnk="$lnk\" onclick=\"javascript:window.open(this.href,'confirm','width=430,height=200,top='+(screen.height-200)/2+',left='+(screen.width-430)/2+',scrollbars=no,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no');return false;";
	$Component->confirmLnk->SetLink($newlnk);

// -------------------------
//End Custom Code

//Close msa_pend_ext_recibidas_BeforeShowRow @2-113DBC01
    return $msa_pend_ext_recibidas_BeforeShowRow;
}
//End Close msa_pend_ext_recibidas_BeforeShowRow

//msa_pend_ext_recibidas_BeforeShow @2-C0F7F3EF
function msa_pend_ext_recibidas_BeforeShow(& $sender)
{
    $msa_pend_ext_recibidas_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $msa_pend_ext; //Compatibility
//End msa_pend_ext_recibidas_BeforeShow

//Custom Code @48-2A29BDB7
// -------------------------
//cantidad de pases realizado al area actual que no estan confirmados
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

//Close msa_pend_ext_recibidas_BeforeShow @2-A99E5053
    return $msa_pend_ext_recibidas_BeforeShow;
}
//End Close msa_pend_ext_recibidas_BeforeShow


?>
