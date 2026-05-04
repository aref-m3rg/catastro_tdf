<?php
//BindEvents Method @1-6843DEAE
function BindEvents()
{
    global $parcela;
    global $CCSEvents;
    $parcela->nueva->CCSEvents["BeforeShow"] = "parcela_nueva_BeforeShow";
    $parcela->cantDoc->CCSEvents["BeforeShow"] = "parcela_cantDoc_BeforeShow";
    $parcela->cantReg->CCSEvents["BeforeShow"] = "parcela_cantReg_BeforeShow";
    $parcela->Button_baja->CCSEvents["OnClick"] = "parcela_Button_baja_OnClick";
    $parcela->Button_baja->CCSEvents["BeforeShow"] = "parcela_Button_baja_BeforeShow";
    $parcela->CCSEvents["AfterInsert"] = "parcela_AfterInsert";
    $parcela->CCSEvents["AfterUpdate"] = "parcela_AfterUpdate";
    $parcela->CCSEvents["BeforeShow"] = "parcela_BeforeShow";
    $parcela->CCSEvents["OnValidate"] = "parcela_OnValidate";
    $parcela->CCSEvents["BeforeUpdate"] = "parcela_BeforeUpdate";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
}
//End BindEvents Method

//parcela_nueva_BeforeShow @115-9BF880AE
function parcela_nueva_BeforeShow(& $sender)
{
    $parcela_nueva_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcela; //Compatibility
//End parcela_nueva_BeforeShow

//Custom Code @267-2A29BDB7
// -------------------------
    if(CCGetParam('new') == 1){
  		$parcela->nueva->SetValue("<font color=GREEN size=3><b>::Parcela recientemente creada</b></font>");
  	}else{
  		$parcela->nueva->SetValue("");
  	}
// -------------------------
//End Custom Code

//Close parcela_nueva_BeforeShow @115-A537A770
    return $parcela_nueva_BeforeShow;
}
//End Close parcela_nueva_BeforeShow

//parcela_cantDoc_BeforeShow @311-53074565
function parcela_cantDoc_BeforeShow(& $sender)
{
    $parcela_cantDoc_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcela; //Compatibility
//End parcela_cantDoc_BeforeShow

//Custom Code @296-2A29BDB7
// -------------------------
    $db = new clsDBtdf_nuevo();
	$cant = CCDLookUp("COUNT(*)","parcelas_documentos","parcela_id=".CCGetParam('parcela_id'),$db);
	if($cant > 0){
		$parcela->cantDoc->SetValue("<b>($cant)</b>");
	}else{
		$parcela->cantDoc->SetValue("<b>(0)</b>");
	}
	$db->close();
// -------------------------
//End Custom Code

//Close parcela_cantDoc_BeforeShow @311-5346169C
    return $parcela_cantDoc_BeforeShow;
}
//End Close parcela_cantDoc_BeforeShow

//parcela_cantReg_BeforeShow @321-89430F02
function parcela_cantReg_BeforeShow(& $sender)
{
    $parcela_cantReg_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcela; //Compatibility
//End parcela_cantReg_BeforeShow

//Custom Code @322-2A29BDB7
// -------------------------
    $db = new clsDBtdf_nuevo();
	$cant = CCDLookUp("COUNT(*)","parcelas_dominiales","parcela_id=".CCGetParam('parcela_id'),$db);
	if($cant > 0){
		$parcela->cantReg->SetValue("<b>($cant)</b>");
	}else{
		$parcela->cantReg->SetValue("<b>(0)</b>");
	}
	$db->close();
// -------------------------
//End Custom Code

//Close parcela_cantReg_BeforeShow @321-9853B3EB
    return $parcela_cantReg_BeforeShow;
}
//End Close parcela_cantReg_BeforeShow

//parcela_Button_baja_OnClick @331-26E42AA6
function parcela_Button_baja_OnClick(& $sender)
{
    $parcela_Button_baja_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcela; //Compatibility
//End parcela_Button_baja_OnClick

//Custom Code @333-2A29BDB7
// -------------------------
    //eliminar parcela
	$parcela_id = CCGetParam('parcela_id');
	if($parcela_id){
		$db = new clsDBtdf_nuevo();
		$direccion_id_real = CCDLookUp("direccion_id_real","parcelas","parcela_id = $parcela_id",$db);
		$direccion_id_postal = CCDLookUp("direccion_id_postal","parcelas","parcela_id = $parcela_id",$db);
		$SQL="DELETE FROM parcelas WHERE parcela_id = $parcela_id";
		$db->query($SQL);
		$SQL="DELETE FROM personas_parcelas WHERE parcela_id = $parcela_id";
		$db->query($SQL);
		$SQL="DELETE FROM mejoras WHERE parcela_id = $parcela_id";
		$db->query($SQL);
		$SQL="DELETE FROM parcelas_documentos WHERE parcela_id = $parcela_id";
		$db->query($SQL);
		$SQL="DELETE FROM parcelas_documentos WHERE parcela_id = $parcela_id";
		$db->query($SQL);
		$SQL="DELETE FROM parcelas_tipos_restricc WHERE parcela_id = $parcela_id";
		$db->query($SQL);
		$SQL="DELETE FROM parcelas_usos_suelo WHERE parcela_id = $parcela_id";
		$db->query($SQL);
		$SQL="DELETE FROM parcelas_dominiales WHERE parcela_id = $parcela_id";
		$db->query($SQL);

		if($direccion_id_real){
			$SQL="DELETE FROM direcciones WHERE direccion_id = $direccion_id_real";
			$db->query($SQL);
		}
		if($direccion_id_postal){
			$SQL="DELETE FROM direcciones WHERE direccion_id = $direccion_id_postal";
			$db->query($SQL);
		}
	}

// -------------------------
//End Custom Code

//Close parcela_Button_baja_OnClick @331-B41A0F3B
    return $parcela_Button_baja_OnClick;
}
//End Close parcela_Button_baja_OnClick

//parcela_Button_baja_BeforeShow @331-1F66F366
function parcela_Button_baja_BeforeShow(& $sender)
{
    $parcela_Button_baja_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcela; //Compatibility
//End parcela_Button_baja_BeforeShow

//Custom Code @334-2A29BDB7
// -------------------------
    // Write your own code here.
	// Ariel PROD
 
	$db = new clsDBtdf_nuevo();
	if (CCDLookUp("perfil_id", "_usuarios", "usuario_id = ".CCGetUserID(), $db ) != 1) {
		$parcela->Button_baja->Visible= false;
	}
// -------------------------
//End Custom Code

//Close parcela_Button_baja_BeforeShow @331-ECC16F7D
    return $parcela_Button_baja_BeforeShow;
}
//End Close parcela_Button_baja_BeforeShow

//parcela_AfterInsert @2-719CD039
function parcela_AfterInsert(& $sender)
{
    $parcela_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcela; //Compatibility
//End parcela_AfterInsert

//Custom Code @260-2A29BDB7
// -------------------------
	$parcela_id = mysql_insert_id();
  	$db = new clsDBtdf_nuevo();
	$parcela_partida = $parcela->parcela_partida->GetValue();
    $audit_string = $parcela->audit_string->GetValue();

  	$SQL = "DELETE FROM parcelas_usos_suelo WHERE parcela_id = $parcela_id";
  	$db->query($SQL);
  
  	if(CCGetParam(usos_suelo)){
  		$s = CCGetParam(usos_suelo);
  		while (list ($clave, $val) = each ($s)) {
   	   		$SQL = "INSERT INTO parcelas_usos_suelo
  		   			  SET parcela_id = $parcela_id,
  					      tipo_uso_suelo_id = $val";
  		   $db->query($SQL);
  		} 
  	}

  	$SQL = "UPDATE parcelas SET parcela_partida = $parcela_partida, parcela_f_proceso = NOW(), parcela_f_alta = NOW(), audit_string = '$audit_string', usuario_id= " . CCGetUserID() . " WHERE parcela_id = $parcela_id";
  	$db->query($SQL);
  	$db->close();
	global $Redirect;
	$Redirect="recordParcela.php?parcela_id=$parcela_id";
// -------------------------
//End Custom Code

//Close parcela_AfterInsert @2-15D83500
    return $parcela_AfterInsert;
}
//End Close parcela_AfterInsert

//parcela_AfterUpdate @2-78DA1028
function parcela_AfterUpdate(& $sender)
{
    $parcela_AfterUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcela; //Compatibility
//End parcela_AfterUpdate

//Custom Code @261-2A29BDB7
// -------------------------
  	$parcela_id = $Component->parcela_id->GetValue();
  	$db = new clsDBtdf_nuevo();
    $audit_string = $Component->audit_string->GetValue();

  	$SQL = "DELETE FROM parcelas_usos_suelo WHERE parcela_id = $parcela_id";
  	$db->query($SQL);

  	if(CCGetParam(usos_suelo)){
  		$s = CCGetParam(usos_suelo);
  		while (list ($clave, $val) = each ($s)) {
   	   		$SQL = "INSERT INTO parcelas_usos_suelo
  		   			  SET parcela_id = $parcela_id,
  					      tipo_uso_suelo_id = $val";
  		   $db->query($SQL);
  		} 
  	}

	$codigo = $Component->tipo_ubica_parcela_nw_id->GetValue();
	if($codigo == ''){
		$codigo = "00";
	}

	$tipo_ubica_parcela_nw_id = CCDLookUp("tipo_ubica_parcela_nw_id","tipos_ubica_parcela_nw","tipo_ubica_parcela_nw_cod = '".str_pad($codigo, 2, "0", STR_PAD_LEFT)."'",$db);
  	$SQL = "UPDATE parcelas SET tipo_ubica_parcela_nw_id = $tipo_ubica_parcela_nw_id, parcela_f_proceso = NOW(), audit_string = '$audit_string', usuario_id= " . CCGetUserID() . " WHERE parcela_id = $parcela_id";
  	$db->query($SQL);
  	$db->close();
// -------------------------
//End Custom Code

//Close parcela_AfterUpdate @2-DAF1F48F
    return $parcela_AfterUpdate;
}
//End Close parcela_AfterUpdate

//parcela_BeforeShow @2-F81A6DBC
function parcela_BeforeShow(& $sender)
{
    $parcela_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcela; //Compatibility
//End parcela_BeforeShow

//Custom Code @263-2A29BDB7
// -------------------------
 	$audit_string = implode('|',array(CCGetUserID(),$_SERVER[REMOTE_ADDR],substr(strrchr ($_SERVER['PHP_SELF'], "/"), 1)));
  	$Component->audit_string->SetValue($audit_string);
  	//fecha de proceso
  	$Component->parcela_f_proceso->SetValue(date('Y-m-d H:i:s'));
  
  	//llenar el check list de servicios
  	$db = new clsDBtdf_nuevo();
  	$db2 = new clsDBtdf_nuevo();
  	$Component->usuario->SetValue(" por ".CCDLookUp("usuario_nombre","_usuarios","usuario_id =".$Component->usuario_id->GetValue(),$db));
  	$Component->depto->SetValue(CCDLookUp("tipo_depto_parc_desc","tipos_deptos_parcela","tipo_depto_parc_id = ".$Component->tipo_depto_parc_id->GetValue(),$db));
	$Component->tipo_ubica_parcela_nw_id->SetValue(CCDLookUp("tipo_ubica_parcela_nw_cod","parcelas LEFT JOIN tipos_ubica_parcela_nw ON parcelas.tipo_ubica_parcela_nw_id = tipos_ubica_parcela_nw.tipo_ubica_parcela_nw_id","parcela_id = ".CCGetParam('parcela_id'),$db));

  	if(CCGetParam(parcela_id)){
  		//recupera el numero plano
  		//$Component->plano->SetValue(CCDLookUp("CONCAT('T.F.',CONCAT_WS('-',tipos_deptos_parcela.tipo_depto_parc_plano_nro,CONCAT(tipos_planos.tipo_plano_abrev,plano_nro),RIGHT(plano_anio,2)))","planos INNER JOIN parcelas_planos ON planos.plano_id = parcelas_planos.plano_id INNER JOIN parcelas ON parcelas_planos.parcela_id = parcelas.parcela_id LEFT JOIN tipos_deptos_parcela ON planos.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id LEFT JOIN tipos_planos ON planos.tipo_plano_id = tipos_planos.tipo_plano_id","parcelas.parcela_id = ".CCGetParam(parcela_id),$db));
		$Component->plano->SetValue(obtenerPlano(false,CCGetParam('parcela_id'),false, $db));
  		$Component->ImageLink1->Visible = true;
		$Component->ImageLink2->Visible = true;
		$Component->ImageLink3->Visible = true;
		$Component->ImageLink4->Visible = true;
  		//completa el compo nomenclatura si no tiene
  		$nomenclatura="";
		if($Component->tipo_depto_parcela_nw_id->GetValue() != '' && $Component->tipo_ubica_parcela_nw_id->GetValue() != '' && (($Component->tipo_secc_parcela_id->GetValue() != '' && $Component->parcela_manzana->GetValue() != '' && $Component->parcela_parcela_nw->GetValue() != '' && $Component->parcela_subparcela->GetValue() != '') || ($Component->parcela_coord_x->GetValue() != '' && $Component->parcela_coord_y->GetValue() != ''))){
			$depto=CCDLookUp("tipo_depto_parcela_nw_cod","parcelas LEFT JOIN tipos_depto_parcela_nw ON parcelas.tipo_depto_parcela_nw_id = tipos_depto_parcela_nw.tipo_depto_parcela_nw_id","parcela_id = ".CCGetParam('parcela_id'),$db);
			$ubicacion=preg_match('/[^0-9]/',$Component->tipo_ubica_parcela_nw_id->GetValue());
			$seccion=CCDLookUp("tipo_secc_parcela_cod","parcelas LEFT JOIN tipos_seccion_parcela_nw ON parcelas.tipo_secc_parcela_id = tipos_seccion_parcela_nw.tipo_secc_parcela_id","parcela_id = ".CCGetParam('parcela_id'),$db);
			if($ubicacion >= 0 && $ubicacion <= 50){
				$nomenclatura=$depto.$Component->tipo_ubica_parcela_nw_id->GetValue().$seccion.$Component->parcela_manzana->GetValue().$Component->parcela_parcela_nw->GetValue().$Component->parcela_subparcela->GetValue();
			}else{
				$nomenclatura=$depto.$Component->tipo_ubica_parcela_nw_id->GetValue().$Component->parcela_coord_x->GetValue().$Component->parcela_coord_y->GetValue();
			}
		}else{
	  		if($Component->depto->GetValue() != ""){
	  			$nomenclatura = $nomenclatura . $Component->depto->GetValue();
	  		}else{
	  			$nomenclatura = $nomenclatura . "-";
	  		}
	  		if($Component->parcela_seccion->GetValue() != ""){
	  			$nomenclatura = $nomenclatura . " " . $Component->parcela_seccion->GetValue();
	  		}else{
	  			$nomenclatura = $nomenclatura . " -";
	  		}
	  		if($Component->parcela_macizo->GetValue() != ""){
	  			$nomenclatura = $nomenclatura . " " . $Component->parcela_macizo->GetValue();
	  		}else{
	  			$nomenclatura = $nomenclatura . " -";
	  		}
	  		if($Component->parcela_parcela->GetValue() != ""){
	  			$nomenclatura = $nomenclatura . " " . $Component->parcela_parcela->GetValue();
	  		}else{
	  			$nomenclatura = $nomenclatura . " -";
	  		}
	  		if($Component->parcela_uf->GetValue() != ""){
	  			$nomenclatura = $nomenclatura . " " . $Component->parcela_uf->GetValue();
	  		}else{
	  			$nomenclatura = $nomenclatura . " -";
	  		}
		}
  	    $Component->parcela_nomenclatura->SetValue($nomenclatura);
  		$Component->nomenclatura->SetValue($nomenclatura);
  
  
  		$parcela->parcela_padron->Visible=true;
		//carga uso suelo
  		$SQL = "SELECT * 
  				FROM parcelas_usos_suelo 
  				WHERE parcela_id = " . CCGetParam(parcela_id);
  		$db->query($SQL);
  		while($db->next_record()){
  			$a[] = $db->f('tipo_uso_suelo_id');
  		}
  		
  		//print_r($a);
  		$Component->usos_suelo->Value = $a;

		//carga restricciones
  		$SQL = "SELECT * 
  				FROM parcelas_tipos_restricc 
  				WHERE parcela_id = " . CCGetParam(parcela_id);
  		$db->query($SQL);
		$salto="";
		$restic="";
  		while($db->next_record()){
			$restic.=$salto.CCDLookUp("tipo_restricc_parcela_desc","tipos_restricc_parcela","tipo_restricc_parcela_id=".$db->f('tipo_restricc_parcela_id'),$db2);
			$salto="<br>";
  		}
  		
  		//print_r($a);
		$Component->restricciones->Value = $restic;
		  	
  	 	//armar la tabla de origen
  		$SQL = "SELECT parcelas.*
  				FROM uniones_desgloses 
  				INNER JOIN parcelas ON uniones_desgloses.parcela_id = parcelas.parcela_id
  				WHERE uniones_desgloses.parcela_destino_id = " . CCGetParam(parcela_id) . " ORDER BY parcelas.parcela_partida";
  
  		$ori = CCDLookUp('tipos_parcelas_altas.tipo_parcela_alta_desc',
  						 'parcelas  INNER JOIN tipos_parcelas_altas ON tipos_parcelas_altas.tipo_parcela_alta_id = parcelas.tipo_parcela_alta_id',
  						 'parcela_id = ' . CCGetParam(parcela_id),$db);
  		if ($ori) $ori = " : " . $ori;
  		$db->query($SQL);
  		$htm = "<table class='Record' cellspacing='0' cellpadding='0'> 
  				<tr class='Caption'>
  	            	<td class='th' colspan='16'>
  						<div align='center'><font size=1><b>Origen de esta Parcela</b></font></div>
  					</td>
  				</tr>
  				<tr class='Caption'>
  					<td class='th'>
  						<div align='center'><font size=1><b>Partida</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Dpto</b></font></div>
  					</td>
  	            	<td class='th'>
  						<div align='center'><font size=1><b>Padron</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Seccion</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Chacra</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Quinta</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Macizo</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Fraccion</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Parcela</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Uf/Uc</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Predio</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Remanente</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Mzna</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Lote</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Instrumento</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Ir a...</b></font></div>
  					</td>
  				</tr>";
  	
  		while($db->next_record()){
  			$lnk = "recordParcela.php?parcela_id=" . $db->f('parcela_id') . "&" . CCGetQueryString("QueryString", array('parcela_id'));
  			$htm .= "<tr class='Row'>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . $db->f('parcela_partida') . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . CCDLookUp("tipo_depto_parc_abrev","tipos_deptos_parcela","tipo_depto_parc_id = ".$db->f('tipo_depto_parc_id'),$db2) . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . CCDLookUp("tipo_padron_parc_abrev","tipos_padrones_parcela","tipo_padron_parc_id = ".$db->f('tipo_padron_parc_id'),$db2) . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . $db->f('parcela_seccion') . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . $db->f('parcela_chacra') . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . $db->f('parcela_quinta') . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . $db->f('parcela_macizo') . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . $db->f('parcela_fraccion') . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . $db->f('parcela_parcela') . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . $db->f('parcela_uf') . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . $db->f('parcela_predio') . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . $db->f('parcela_rte') . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . $db->f('parcela_mzna') . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . $db->f('parcela_lote') . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . CCDLookUp("CONCAT(tipo_instrumento_descrip,' ',persona_parcela_num_int)","personas_parcelas LEFT JOIN tipos_instrumentos ON personas_parcelas.tipo_instrumento_id = tipos_instrumentos.tipo_instrumento_id","parcela_id = ".$db->f('parcela_id')." LIMIT 1",$db2) . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'>" . "<a href='$lnk' title='Ir a esta Parcela Origen'><img style='BORDER-RIGHT: 0px; BORDER-TOP: 0px; BORDER-LEFT: 0px; BORDER-BOTTOM: 0px' src='../iconos/16x16/format-indent-less.gif'></a>" . $db->f('') . "</div></td>";
  			$htm .= "</tr>";
  		}
  		$htm .= "</table>";
  	
  		$Component->origen->SetValue($htm);
  
  		//armar la tabla de destino
  		$SQL = "SELECT parcelas.*
  				FROM uniones_desgloses 
  				INNER JOIN parcelas ON uniones_desgloses.parcela_destino_id = parcelas.parcela_id
  				WHERE uniones_desgloses.parcela_id = " . CCGetParam(parcela_id) . " ORDER BY parcelas.parcela_partida";
  		$db->query($SQL);
  		$htm = "<table class='Record' cellspacing='0' cellpadding='0'>
  				<tr class='Caption'>
  	            	<td class='th' colspan='16'>
  						<div align='center'><font size=1><b>Divisiones de esta Parcela</b></font></div>
  					</td>
  				</tr>
  				<tr class='Caption'>
  					<td class='th'>
  						<div align='center'><font size=1><b>Partida</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Dpto</b></font></div>
  					</td>
  	            	<td class='th'>
  						<div align='center'><font size=1><b>Padron</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Seccion</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Chacra</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Quinta</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Macizo</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Fraccion</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Parcela</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Uf/Uc</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Predio</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Remanente</b></font></div>
  					</td>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Mzna</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Lote</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Instrumento</b></font></div>
  					</td>
  					<td class='th'>
  						<div align='center'><font size=1><b>Ir a...</b></font></div>
  					</td>
  				</tr>";
  	
  		while($db->next_record()){
  			$lnk = "recordParcela.php?parcela_id=" . $db->f('parcela_id') . "&" . CCGetQueryString("QueryString", array('parcela_id'));
  			$htm .= "<tr class='Row'>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . $db->f('parcela_partida') . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . CCDLookUp("tipo_depto_parc_abrev","tipos_deptos_parcela","tipo_depto_parc_id = ".$db->f('tipo_depto_parc_id'),$db2) . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . CCDLookUp("tipo_padron_parc_abrev","tipos_padrones_parcela","tipo_padron_parc_id = ".$db->f('tipo_padron_parc_id'),$db2) . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . $db->f('parcela_seccion') . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . $db->f('parcela_chacra') . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . $db->f('parcela_quinta') . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . $db->f('parcela_macizo') . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . $db->f('parcela_fraccion') . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . $db->f('parcela_parcela') . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . $db->f('parcela_uf') . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . $db->f('parcela_predio') . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . $db->f('parcela_rte') . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . $db->f('parcela_mzna') . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . $db->f('parcela_lote') . "</font></div></td>";
  			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . CCDLookUp("CONCAT(tipo_instrumento_descrip,' ',persona_parcela_num_int)","personas_parcelas LEFT JOIN tipos_instrumentos ON personas_parcelas.tipo_instrumento_id = tipos_instrumentos.tipo_instrumento_id","parcela_id = ".$db->f('parcela_id')." LIMIT 1",$db2) . "</font></div></td>";  			
			$htm .= "<td style='background-color: #FFFFFF'><div align='center'><font size=1>" . "<a href='$lnk' title='Ir a esta Parcela Destino'><img style='BORDER-RIGHT: 0px; BORDER-TOP: 0px; BORDER-LEFT: 0px; BORDER-BOTTOM: 0px' src='../iconos/16x16/format-indent-more.gif'></a>" . $db->f('') . "</div></td>";
  			$htm .= "</tr>";
  		}
  		$htm .= "</table>";
  	
  		$Component->destino->SetValue($htm);
  	}else{
		$parcela->ImageLink1->Visible = false;
		$parcela->ImageLink2->Visible = false;
		$parcela->ImageLink3->Visible = false;
		$parcela->ImageLink4->Visible = false;
	}



	//----------------------------planchetas-----------------------------------

	$htm = generarPlanchetasSlides(
		CCGetParam('parcela_id'),
		array(
      'wrapper' => 'dialog-modal',
      'wrapper_title' => 'Planchetas de la parcela',
      'additional_classes' => 'big'
     ),
		$db
	);
	$Component->plancheta->SetValue( $htm );


  //-----------------------inscripcion dominial----------------------------------
	if(CCGetParam(parcela_id)){
		$SQL="SELECT CONCAT(tipos_instrumentos.tipo_instrumento_descrip,' ',parcelas_dominiales.parcela_dominial_intrumento_nro) AS instrumento, COUNT(*) AS cant FROM parcelas_dominiales LEFT JOIN tipos_instrumentos ON parcelas_dominiales.tipo_instrumento_id = tipos_instrumentos.tipo_instrumento_id WHERE parcelas_dominiales.parcela_id = ".CCGetParam(parcela_id);
		$db->query($SQL);
		if($db->next_record()){
			if($db->f('cant') > 1){
				$mas=" (otros)";
			}else{
				$mas="";
			}
			$parcela->inscripcionDominial->SetValue($db->f('instrumento').$mas);
		}
	}



   /* Consulta el plano y lo asigna a su label */
   $Component->plano->SetValue( obtenerPlano( false, CCGetParam('parcela_id'), false, $db ) );


   	$db->close();
  	$db2->close();

// -------------------------
//End Custom Code

//Close parcela_BeforeShow @2-739A2254
    return $parcela_BeforeShow;
}
//End Close parcela_BeforeShow

//parcela_OnValidate @2-759C4F79
function parcela_OnValidate(& $sender)
{
    $parcela_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcela; //Compatibility
//End parcela_OnValidate

//Custom Code @264-2A29BDB7
// -------------------------
  	//validar padrones y nomenclaturas unicos.
  	$db = new clsDBtdf_nuevo();
  	$parcela_partida = $Component->parcela_partida->GetValue();
  	$parcela_depto = $Component->tipo_depto_parc_id->GetValue();
  	$parcela_id = CCGetParam(parcela_id);
  	
  	if($parcela_id){
  		$chk_p = CCDLookUp('COUNT(*)','parcelas',"parcela_partida = $parcela_partida AND parcela_id <> $parcela_id AND tipo_depto_parc_id = $parcela_depto AND parcela_partida <> 0",$db);
  	} else {
  		$chk_p = CCDLookUp('COUNT(*)','parcelas',"parcela_partida = $parcela_partida AND tipo_depto_parc_id = $parcela_depto AND parcela_partida <> 0",$db);
  	}
  
  	if($chk_p > 0){
  		$Component->Errors->AddError('Ya existe otra parcela con este Nro. de Partida en el departamento seleccionado. Verifique!');
  	}
// -------------------------
//End Custom Code

//Close parcela_OnValidate @2-4C6146DD
    return $parcela_OnValidate;
}
//End Close parcela_OnValidate

//parcela_BeforeUpdate @2-5385323F
function parcela_BeforeUpdate(& $sender)
{
    $parcela_BeforeUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcela; //Compatibility
//End parcela_BeforeUpdate

//Custom Code @275-2A29BDB7
// -------------------------
/*
    $parcela_id = CCGetParam(parcela_id);
  	$db = new clsDBtdf_nuevo();
  
  	$SQL = "DELETE FROM parcelas_usos_suelo WHERE parcela_id = " . $parcela_id;
  	$db->query($SQL);

  	if(CCGetParam(usos_suelo)){
  		$s = CCGetParam(usos_suelo);
  		while (list ($clave, $val) = each ($s)) {
   	   		$SQL = "INSERT INTO parcelas_usos_suelo
  		   			  SET parcela_id = $parcela_id,
  					      tipo_uso_suelo_id = $val";
  
  		   $db->query($SQL);
  		} 
  	}

  	$SQL = "DELETE FROM parcelas_tipos_restricc WHERE parcela_id = " . $parcela_id;
  	$db->query($SQL);

  	if(CCGetParam(tipo_restricc_parcela_id)){
		$s = CCGetParam(tipo_restricc_parcela_id);
		while (list ($clave, $val) = each ($s)) {
	   		$SQL = "INSERT INTO parcelas_tipos_restricc
		   			  SET parcela_id = $parcela_id,
					      tipo_restricc_parcela_id = $val<br>";
		   $db->query($SQL);
		} 
  	}

  	$db->close();
*/
// -------------------------
//End Custom Code

//Close parcela_BeforeUpdate @2-9E13A904
    return $parcela_BeforeUpdate;
}
//End Close parcela_BeforeUpdate

//Page_BeforeInitialize @1-234E5B43
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $recordParcela; //Compatibility
//End Page_BeforeInitialize

//Custom Code @281-2A29BDB7
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

//Page_AfterInitialize @1-3BF862C0
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $recordParcela; //Compatibility
//End Page_AfterInitialize

//Custom Code @315-2A29BDB7
// -------------------------

// -------------------------
//End Custom Code

//Close Page_AfterInitialize @1-379D319D
    return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize
?>