<?php
//BindEvents Method @1-F4694BC6
function BindEvents()
{
    global $enviadas;
    global $recibidas;
    global $area;
    global $cant_ext_pend;
    global $Panel1;
    global $CCSEvents;
    $enviadas->Label1->CCSEvents["BeforeShow"] = "enviadas_Label1_BeforeShow";
    $enviadas->CCSEvents["BeforeShowRow"] = "enviadas_BeforeShowRow";
    $recibidas->Label1->CCSEvents["BeforeShow"] = "recibidas_Label1_BeforeShow";
    $recibidas->CCSEvents["BeforeShowRow"] = "recibidas_BeforeShowRow";
    $area->Label1->CCSEvents["BeforeShow"] = "area_Label1_BeforeShow";
    $area->CCSEvents["BeforeShowRow"] = "area_BeforeShowRow";
    $cant_ext_pend->CCSEvents["BeforeShow"] = "cant_ext_pend_BeforeShow";
    $Panel1->CCSEvents["BeforeShow"] = "Panel1_BeforeShow";
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
}
//End BindEvents Method

//enviadas_Label1_BeforeShow @437-65BC4565
function enviadas_Label1_BeforeShow(& $sender)
{
    $enviadas_Label1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $enviadas; //Compatibility
//End enviadas_Label1_BeforeShow

//Custom Code @439-2A29BDB7
// -------------------------
    $db = new clsDBmesa();
	$SQL= "SELECT COUNT(*) AS cant
			FROM piezas
			INNER JOIN pases ON piezas.pieza_id = pases.pieza_id
			INNER JOIN piezas_tipos ON piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id
			LEFT JOIN adjuntos ON piezas.pieza_id = adjuntos.adj_pieza_id
			INNER JOIN unidades_param ON pases.des_unidad_id = unidades_param.unidad_id
			WHERE pases.pase_activo = 1
			AND pases.ori_unidad_id = ".CCGetSession('unidad_id')." 
			AND pases.pase_confirmado = 0
			AND unidades_param.unidad_p_activo = 1
			AND adjuntos.adjunto_id IS NULL  ";
	$db->query($SQL);
	if($db->next_record()){
		$enviadas->Label1->SetValue("(".$db->f('cant').")");
	}
	$db->close();
// -------------------------
//End Custom Code

//Close enviadas_Label1_BeforeShow @437-105FAD27
    return $enviadas_Label1_BeforeShow;
}
//End Close enviadas_Label1_BeforeShow

//enviadas_BeforeShowRow @20-9F7EEFF9
function enviadas_BeforeShowRow(& $sender)
{
    $enviadas_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $enviadas; //Compatibility
//End enviadas_BeforeShowRow

//Custom Code @259-2A29BDB7
// -------------------------
    // Write your own code here.
	$qs = CCAddParam('pieza_id=' . $Component->ds->f('pieza_id'),'pase_id',$Component->ds->f('pase_id'));
	$lnk = 'msa_cancel.php?' . $qs;
	$newlnk="$lnk\" onclick=\"javascript:window.open(this.href,'cancelar','width=430,height=200,top='+(screen.height-200)/2+',left='+(screen.width-430)/2+',scrollbars=no,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no');return false;";
	$Component->canceLnk->SetLink($newlnk);
// -------------------------
//End Custom Code

//Close enviadas_BeforeShowRow @20-02C4DED1
    return $enviadas_BeforeShowRow;
}
//End Close enviadas_BeforeShowRow

//recibidas_Label1_BeforeShow @434-0E697B98
function recibidas_Label1_BeforeShow(& $sender)
{
    $recibidas_Label1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $recibidas; //Compatibility
//End recibidas_Label1_BeforeShow

//Custom Code @435-2A29BDB7
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
			AND pases.pase_confirmado = 0
			AND unidades_param.unidad_p_activo = 1
			AND pases.des_unidad_id = ".CCGetSession('unidad_id')."
			AND adjuntos.adjunto_id IS NULL ";
	$db->query($SQL);
	if($db->next_record()){
		$recibidas->Label1->SetValue("(".$db->f('cant').")");
	}
	$db->close();
// -------------------------
//End Custom Code

//Close recibidas_Label1_BeforeShow @434-3098B603
    return $recibidas_Label1_BeforeShow;
}
//End Close recibidas_Label1_BeforeShow

//recibidas_BeforeShowRow @80-DF5613EF
function recibidas_BeforeShowRow(& $sender)
{
    $recibidas_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $recibidas; //Compatibility
//End recibidas_BeforeShowRow

//Custom Code @249-2A29BDB7
// -------------------------
    // Write your own code here.

	$qs = CCAddParam('pieza_id=' . $Component->ds->f('pieza_id'),'pase_id',$Component->ds->f('pase_id'));
	$lnk = 'msa_confirm.php?' . $qs;
	$newlnk="$lnk\" onclick=\"javascript:window.open(this.href,'confirm','width=430,height=200,top='+(screen.height-200)/2+',left='+(screen.width-430)/2+',scrollbars=no,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no');return false;";
	$Component->confirmLnk->SetLink($newlnk);

// -------------------------
//End Custom Code

//Close recibidas_BeforeShowRow @80-29E40000
    return $recibidas_BeforeShowRow;
}
//End Close recibidas_BeforeShowRow

//area_Label1_BeforeShow @436-AB3E1FFC
function area_Label1_BeforeShow(& $sender)
{
    $area_Label1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $area; //Compatibility
//End area_Label1_BeforeShow

//Custom Code @438-2A29BDB7
// -------------------------
//cantidad de piezas en el area
    $db = new clsDBmesa();
	$SQL= "SELECT COUNT(*) AS cant
			FROM piezas INNER JOIN pases ON pases.pieza_id = piezas.pieza_id
			INNER JOIN piezas_tipos ON piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id
			LEFT JOIN adjuntos ON piezas.pieza_id = adjuntos.adj_pieza_id
			INNER JOIN entornos ON piezas.entorno_id = entornos.entorno_id
			WHERE pases.pase_confirmado = 1
			AND pases.pase_activo = 1
			AND pases.des_unidad_id = ".CCGetSession('unidad_id')." 
			AND adjuntos.adjunto_id IS NULL 
			AND piezas.pieza_archivada <> 1 ";
	$db->query($SQL);
	if($db->next_record()){
		$area->Label1->SetValue("(".$db->f('cant').")");
	}
	$db->close();
// -------------------------
//End Custom Code

//Close area_Label1_BeforeShow @436-41A82FB2
    return $area_Label1_BeforeShow;
}
//End Close area_Label1_BeforeShow

//area_BeforeShowRow @102-E835437A
function area_BeforeShowRow(& $sender)
{
    $area_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $area; //Compatibility
//End area_BeforeShowRow

//Custom Code @260-2A29BDB7
// -------------------------
    // Write your own code here.
	$db = new clsDBmesa();
	$qs = 'pieza_id=' . $Component->ds->f('pieza_id');

	//Link archivar
	$lnk = 'msa_archivar.php?' . $qs;
	$newlnk = "$lnk\" onclick=\"javascript:window.open(this.href,'ruta','width=450,height=150,top='+(screen.height-500)/2+',left='+(screen.width-600)/2+',scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no');return false;";
	$Component->archLnk->SetLink($newlnk);

	//Link Ruta
	$lnk = 'msa_ruta.php?' . $qs;
	$newlnk = "$lnk\" onclick=\"javascript:window.open(this.href,'ruta','width=600,height=500,top='+(screen.height-500)/2+',left='+(screen.width-600)/2+',scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no');return false;";
	$Component->rutaLnk->SetLink($newlnk);
	
	//Link Adjuntos
	$lnk = 'msa_adjuntos.php?' . $qs;
	$newlnk = "$lnk\" onclick=\"javascript:window.open(this.href,'ruta','width=600,height=500,top='+(screen.height-500)/2+',left='+(screen.width-600)/2+',scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no');return false;";
	$Component->adjLnk->SetLink($newlnk);

	//Link tomos

	$lnk = 'msa_newTomo.php?' . $qs;
	$newlnk = "$lnk\" onclick=\"javascript:window.open(this.href,'ruta','width=500,height=300,top='+(screen.height-500)/2+',left='+(screen.width-600)/2+',scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no');return false;";
	$Component->tmoAddLnk->SetLink($newlnk);

	//mostrar o no los links
	//Adjuntos, si no tiene adjuntos no se muestra
	//por defecto invisible
	$Component->adjLnk->Visible = False;
	$adj = CCDLookUp('COUNT(*)','adjuntos','ppal_pieza_id = ' . $Component->ds->f('pieza_id'),$db);
	if($adj > 0){$Component->adjLnk->Visible = True;}

	//tomos, si es expediente si no tiene el tomo 1 no puede crear tomos
	$Component->tmoAddLnk->Visible = False;
	if(($Component->ds->f('pieza_tm_nro') == 1) && ($Component->ds->f('pieza_tipo_id') == 1)){
		$Component->tmoAddLnk->Visible = True;
	}
// -------------------------
//End Custom Code

//Close area_BeforeShowRow @102-B8056EE6
    return $area_BeforeShowRow;
}
//End Close area_BeforeShowRow

//cant_ext_pend_BeforeShow @447-4BF51F6C
function cant_ext_pend_BeforeShow(& $sender)
{
    $cant_ext_pend_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $cant_ext_pend; //Compatibility
//End cant_ext_pend_BeforeShow

//Custom Code @448-2A29BDB7
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
		$cant_ext_pend->SetValue("(".$db->f('cant').")");
	}
	$db->close();
// -------------------------
//End Custom Code

//Close cant_ext_pend_BeforeShow @447-B192472D
    return $cant_ext_pend_BeforeShow;
}
//End Close cant_ext_pend_BeforeShow

//Panel1_BeforeShow @450-AAD8AF72
function Panel1_BeforeShow(& $sender)
{
    $Panel1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Panel1; //Compatibility
//End Panel1_BeforeShow

//Custom Code @451-2A29BDB7
// -------------------------
    $db = new clsDBmesa();
	$unidad_autorizada = CCDLookUp("unidad_id","unidades","unidad_pase_externo = '1' AND unidad_id = ".CCGetSession(unidad_id), $db);
	if($unidad_autorizada){
		$Panel1->Visible=true;
	}else{
		$Panel1->Visible=false;
	}
	$db->close();
// -------------------------
//End Custom Code

//Close Panel1_BeforeShow @450-D21EBA68
    return $Panel1_BeforeShow;
}
//End Close Panel1_BeforeShow

//Page_BeforeShow @1-BF9F5D3A
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $msa_principal; //Compatibility
//End Page_BeforeShow
	global $unidad,$usuario;

//Custom Code @61-2A29BDB7
// -------------------------
    $db = new clsDBmesa();
	$cant = CCDLookUp('COUNT(*)','piezas INNER JOIN pases ON pases.pieza_id = piezas.pieza_id LEFT JOIN adjuntos ON piezas.pieza_id = adjuntos.adj_pieza_id','pases.pase_confirmado = 1 AND pases.pase_activo = 1 AND adjuntos.adjunto_id IS NULL AND piezas.pieza_archivada = 1 AND pases.des_unidad_id = ' . CCGetSession(unidad_id),$db);
	$Component->archivo->SetValue($cant);
	$db->close();
// -------------------------
//End Custom Code

//Close Page_BeforeShow @1-4BC230CD
    return $Page_BeforeShow;
}
//End Close Page_BeforeShow

//Page_AfterInitialize @1-53F7FA5C
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $msa_principal; //Compatibility
//End Page_AfterInitialize

//Custom Code @397-2A29BDB7
// -------------------------
    // Write your own code here.
	global $Redirect;
	if(!CCGetSession(unidad_id)){
		$Redirect = RelativePath . "/tdf_restricted.php";
	}
// -------------------------
//End Custom Code

//Close Page_AfterInitialize @1-379D319D
    return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize


?>
