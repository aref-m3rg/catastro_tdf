<?php

//BindEvents Method @1-397EAC53
function BindEvents()
{
    global $CCSEvents;
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
}
//End BindEvents Method

//DEL  // -------------------------
//DEL      // Write your own code here.
//DEL  $parcelas_unidades_medidas1->editar->Visible=TRUE;
//DEL  $db = new clsDBtdf_nuevo();
//DEL  $esta= CCDLookUp('tmp_parcela_id', 'tmp','tmp_parcela_id ='. $parcelas_unidades_medidas1->ds->f('parcela_id') . " AND usuario_id = " . CCGetSession("UID"), $db);
//DEL  if($esta) $parcelas_unidades_medidas1->editar->Visible=FALSE;
//DEL  if(CCGetParam(parcela_id_mas) == $parcelas_unidades_medidas1->ds->f('parcela_id')) $parcelas_unidades_medidas1->editar->Visible=FALSE;
//DEL  $db->close();
//DEL  
//DEL  // -------------------------

//DEL  // -------------------------
//DEL      // Write your own code here.
//DEL  global $padrones_parcelas_parcela;
//DEL  $parcelas_unidades_medidas1->Visible = FALSE;
//DEL  if ($padrones_parcelas_parcela->h1->GetValue() == 1) $parcelas_unidades_medidas1->Visible = FALSE;
//DEL  ELSE $parcelas_unidades_medidas1->Visible = TRUE;
//DEL  //$parcelas_unidades_medidas1 = FALSE;
//DEL   // -------------------------

//DEL  // -------------------------
//DEL      // Write your own code here.
//DEL  	// borrar tmp2
//DEL  $db = new clsDBtdf_nuevo();
//DEL  			
//DEL  			$SQL = "DELETE FROM tmp
//DEL  					WHERE   usuario_id = " . CCGetSession("UID")  ;
//DEL  			//$db->Query($SQL);
//DEL  
//DEL  			
//DEL  			$SQL = "DELETE FROM tmp2
//DEL  					WHERE   usuario_id = " . CCGetSession("UID")  ;
//DEL  			$db->Query($SQL);
//DEL  
//DEL  
//DEL  			$SQL = "DELETE FROM tmp_mejoras
//DEL  					WHERE   usuario_id = " . CCGetSession("UID")  ;
//DEL  			$db->Query($SQL);
//DEL  
//DEL  
//DEL  			$SQL = "DELETE FROM tmp_u_d
//DEL  					WHERE   usuario_id = " . CCGetSession("UID")  ;
//DEL  			$db->Query($SQL);
//DEL  
//DEL  
//DEL  
//DEL  $db->close();
//DEL  // -------------------------

//DEL  // -------------------------
//DEL      // Write your own code here.
//DEL  	if (CCGetParam(parcela_id_mas)){
//DEL  		$db = new clsDBtdf_nuevo();
//DEL  		$esta= CCDLookUp('tmp_parcela_id', 'tmp','tmp_parcela_id ='. CCGetParam(parcela_id_mas) . " AND usuario_id = " . CCGetSession("UID"), $db);
//DEL  		if (!$esta){
//DEL  			$SQL = "INSERT INTO tmp SET tmp_parcela_id = " . CCGetParam(parcela_id_mas)  . " , usuario_id = " . CCGetSession("UID")  ;
//DEL  			//echo $SQL;
//DEL  			//exit;
//DEL  			$db->Query($SQL);
//DEL  			//$Redirect = CCGetParam("ret_link", $Redirect);
//DEL  			//$_GET["parcela_id_a"] = "";
//DEL  			}
//DEL  	}
//DEL  	if (CCGetParam(parcela_id_menos)){
//DEL  		$db = new clsDBtdf_nuevo();
//DEL  		$esta= CCDLookUp('tmp_parcela_id', 'tmp','tmp_parcela_id ='. CCGetParam(parcela_id_menos) , $db);
//DEL  		if ($esta){
//DEL  			$SQL = "DELETE FROM tmp
//DEL  					WHERE  tmp_parcela_id = " . CCGetParam(parcela_id_menos) . 
//DEL  					  " AND usuario_id = " . CCGetSession("UID")  ;
//DEL  //			echo $SQL;
//DEL  			//exit;			
//DEL  			$db->Query($SQL);
//DEL  			//$Redirect = CCGetParam("ret_link", $Redirect);
//DEL  			//$_GET["parcela_id_a"] = "";
//DEL  			}
//DEL  	}
//DEL  
//DEL  // -------------------------

//DEL  // -------------------------
//DEL      // Write your own code here.
//DEL  
//DEL  
//DEL  /*
//DEL  	if (CCgetParam(cantparce)) $parcelas_tmp->Visible = TRUE;
//DEL  ELSE $parcelas_tmp->Visible = FALSE;
//DEL  */
//DEL  
//DEL  $db = new clsDBtdf_nuevo();
//DEL  //si asigno todas mejoras
//DEL  $listo = CCDLookUp("count(tmp_mejora_id)", "tmp_mejoras","tmp2_id IS NULL AND usuario_id =" . CCGetSession("UID") , $db);
//DEL  // si hay mejoras
//DEL  $tiene = CCDLookUp("count(tmp_mejora_id)", "tmp_mejoras","usuario_id =" . CCGetSession("UID") , $db);
//DEL  $Component->Visible = TRUE;
//DEL  
//DEL  if (($listo == 0) AND ($tiene > 0)){
//DEL  $Component->Visible = FALSE;
//DEL  }
//DEL  $db->Query($SQL);
//DEL  // -------------------------

//DEL  // -------------------------
//DEL      // Write your own code here.
//DEL  
//DEL  $db = new clsDBtdf_nuevo();
//DEL  $SQL = "DELETE FROM tmp2 WHERE  usuario_id = " . CCGetSession("UID")  ;
//DEL  //echo $SQL;
//DEL  //exit;			
//DEL  $db->Query($SQL);
//DEL  
//DEL  
//DEL  //SELECT MAX(parcela_partida) FROM parcelas
//DEL  $partida = CCDLookUp('MAX(parcela_partida)', 'parcelas','', $db);
//DEL  while ($a < $cantidad->cantparce->GetValue()) {
//DEL  	$partida ++ ;
//DEL  	$SQL = "INSERT INTO tmp2 SET  parcela_partida = " . $partida . " , usuario_id = " . CCGetSession("UID") . " , secuencia = " . ($a + 1)  ;
//DEL  	//echo $SQL . "<BR>";
//DEL  	//exit;
//DEL  	$db->Query($SQL);
//DEL  	$a ++;
//DEL  }
//DEL  //EXIT;
//DEL  
//DEL  $db->close();
//DEL  
//DEL  
//DEL  // -------------------------

//DEL  // -------------------------
//DEL      // Write your own code here.
//DEL  $db = new clsDBtdf_nuevo();
//DEL  //si asigno todas mejoras
//DEL  $listo = CCDLookUp("count(tmp_mejora_id)", "tmp_mejoras","tmp2_id IS NULL AND usuario_id =" . CCGetSession("UID") , $db);
//DEL  // si hay mejoras
//DEL  $tiene = CCDLookUp("count(tmp_mejora_id)", "tmp_mejoras","usuario_id =" . CCGetSession("UID") , $db);
//DEL  $Component->Visible = TRUE;
//DEL  if (($listo == 0) AND ($tiene > 0)){
//DEL  $Component->Visible = FALSE;
//DEL  }
//DEL  
//DEL  
//DEL  
//DEL  // si todavia no asocia las personas
//DEL  $per= CCDLookUp("COUNT(tmp2_id)", "tmp2", "usuario_id = " . CCGetSession("UID") . " AND persona_id IS NULL " , $db);
//DEL  $per1= CCDLookUp("COUNT(tmp2_id)", "tmp2", "usuario_id = " . CCGetSession("UID")  , $db);
//DEL  //echo "<BR> per->". $per;
//DEL  if (($per1 > 0) AND ($per == 0)) $Component->Visible = FALSE;
//DEL  
//DEL  
//DEL  
//DEL  $db->Query($SQL);
//DEL  // -------------------------

//DEL  // -------------------------
//DEL      // Write your own code here.
//DEL  	$Component->Visible=FALSE;
//DEL  
//DEL  $db = new clsDBtdf_nuevo();
//DEL  
//DEL  //cantidad de mejoras total
//DEL  $estac= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") . " AND secuencia <> 999 " , $db);
//DEL  // cantidad de mejoras asignadas
//DEL  //$esta= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") . " AND mejora_id IS NOT NULL " , $db);
//DEL  $esta= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") . " AND tmp2_id IS NOT NULL " , $db);
//DEL  // ya asocio las personas con la parcela, o sea que creo un tmp_mejopra con las mejoras o con secuencia 999
//DEL  $estap= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") , $db);
//DEL  //aaaaa
//DEL  //echo $esta . " -- " . $estac . " -- " . $estap;
//DEL  //exit;
//DEL  IF (($estac == $esta) AND ($estap > 0 )) $Component->Visible=TRUE;
//DEL  
//DEL  
//DEL  $hay = CCDLookUp("count(tmp2_id)", "tmp2"," usuario_id =" . CCGetSession("UID") , $db);
//DEL  if ($hay == 0) $Component->Visible = FALSE;
//DEL  // si todavia no asocia las personas
//DEL  $per= CCDLookUp("COUNT(tmp2_id)", "tmp2", "usuario_id = " . CCGetSession("UID") . " AND persona_id IS NULL " , $db);
//DEL  //echo "<BR> per->". $per;
//DEL  if ($per <> 0) $Component->Visible = FALSE;
//DEL  
//DEL  
//DEL  $estaud= CCDLookUp("COUNT(tmp_u_d.tmp_u_d_id)", "tmp_u_d", "usuario_id = " . CCGetSession("UID") , $db);
//DEL  if ($estaud) $Component->Visible=FALSE;
//DEL  
//DEL  //echo "<BR> 2-->" . $hay . "<BR>"; 	
//DEL  
//DEL  $db->close();
//DEL  
//DEL  
//DEL  $Component->Visible = FALSE;
//DEL  
//DEL  
//DEL  // -------------------------

//DEL  // -------------------------
//DEL      // Write your own code here.
//DEL  // verificar si las partidas sugueridas no estan ocupadas ya, si estan ocupada cambiarlas en tmp2 (nada mas)
//DEL  // poner las parcelas como daddas de baja a la parcela, a la relacion con las personas y las mejoras ( o solo la parcelas)
//DEL  // crear parcelas parcelas_personas y mejoras
//DEL  // ver si las parcelas no tienen mejora comoo hacer
//DEL  /*
//DEL  SELECT tmp.*, tmp2.*
//DEL  FROM tmp
//DEL  LEFT JOIN tmp2 ON 1 = 1
//DEL  WHERE tmp.usuario_id = 3;
//DEL  
//DEL  
//DEL  */
//DEL  
//DEL  // -------------------------

//DEL  // -------------------------
//DEL      // Write your own code here.
//DEL  
//DEL  
//DEL  $db = new clsDBtdf_nuevo();
//DEL  $mej = $tmp_mejoras->ds->f('mejora_id');
//DEL  $mejora_sup_cub= CCDLookUp('mejora_sup_cub', 'mejoras','mejora_id='. $mej , $db);
//DEL  $parcela_partida= CCDLookUp('parcela_partida', 'mejoras INNER JOIN parcelas ON parcelas.parcela_id = mejoras.parcela_id','mejoras.mejora_id='. $mej , $db);
//DEL  //$Component->lmejora->SetValue("aaaa");
//DEL  
//DEL  //echo $mejora_sup_cub . " - "  . $parcela_partida;
//DEL  //exit;
//DEL  
//DEL  
//DEL  $mej = "Partida:". $parcela_partida . "-->Sup.Cub=" .  $mejora_sup_cub ;
//DEL  
//DEL  //concat(mejora_sup_cub, " mts de la parcela ", parcela_partida)
//DEL  $Component->lmejora->SetValue($mej);
//DEL  /*
//DEL  
//DEL  $parcelas_unidades_medidas1->editar->Visible=TRUE;
//DEL  $db = new clsDBtdf_nuevo();
//DEL  $esta= CCDLookUp('tmp_parcela_id', 'tmp','tmp_parcela_id ='. $parcelas_unidades_medidas1->ds->f('parcela_id') . " AND usuario_id = " . CCGetSession("UID"), $db);
//DEL  if($esta) $parcelas_unidades_medidas1->editar->Visible=FALSE;
//DEL  if(CCGetParam(parcela_id_mas) == $parcelas_unidades_medidas1->ds->f('parcela_id')) $parcelas_unidades_medidas1->editar->Visible=FALSE;
//DEL  $db->close();
//DEL  */
//DEL  
//DEL  
//DEL  
//DEL  // -------------------------

//DEL  // -------------------------
//DEL      // Write your own code here.
//DEL  
//DEL  $Component->Visible=FALSE;
//DEL  
//DEL  $db = new clsDBtdf_nuevo();
//DEL  
//DEL  //cantidad de mejoras total
//DEL  $estac= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") . " AND secuencia <> 999 " , $db);
//DEL  // cantidad de mejoras asignadas
//DEL  //$esta= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") . " AND mejora_id IS NOT NULL " , $db);
//DEL  $esta= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") . " AND tmp2_id IS NOT NULL " , $db);
//DEL  // ya asocio las personas con la parcela, o sea que creo un tmp_mejopra con las mejoras o con secuencia 999
//DEL  $estap= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") , $db);
//DEL  //aaaaa
//DEL  //echo $esta . " -- " . $estac . " -- " . $estap;
//DEL  //exit;
//DEL  IF (($estac > 0 ) AND ($estac <> $esta))  $Component->Visible=TRUE;
//DEL  
//DEL  
//DEL  
//DEL  
//DEL  // si ya esta creado la union que no muestre
//DEL  $estaud= CCDLookUp("COUNT(tmp_u_d.tmp_u_d_id)", "tmp_u_d", "usuario_id = " . CCGetSession("UID") , $db);
//DEL  if ($estaud) $Component->Visible=FALSE;
//DEL  
//DEL  
//DEL  
//DEL  
//DEL  
//DEL  
//DEL  $db->close();
//DEL  
//DEL  // -------------------------

//DEL  // -------------------------
//DEL      // Write your own code here.
//DEL  
//DEL  
//DEL  $db = new clsDBtdf_nuevo();
//DEL  $dba = new clsDBtdf_nuevo();
//DEL  $dbb = new clsDBtdf_nuevo();
//DEL  $dbc = new clsDBtdf_nuevo();
//DEL  	
//DEL  			
//DEL  $SQL = " SELECT tmp2.tmp2_id, tmp2.parcela_partida, tmp2.persona_id, tmp2.persona_parcela_num_int, tmp2.tipo_instrumento_id, tipo_persona_parcela_id 
//DEL  FROM tmp2 WHERE tmp2.usuario_id = " . CCGetSession("UID") ;
//DEL  
//DEL  
//DEL  
//DEL  $db->query($SQL);
//DEL  $a = 1;
//DEL  while($Result = $db->next_record()){
//DEL  	// creo la parcela
//DEL  	$partida = CCDLookUp('MAX(parcela_partida)', 'parcelas','', $dba);	
//DEL  	$partida = $partida + 1;
//DEL  	$SQL = "INSERT INTO parcelas SET  parcela_partida = " . $partida . 
//DEL  									" , tipo_est_parc_id = 3 "  .				// en tramite
//DEL  									" , tipo_depto_parc_id = 1 "  .				// 1 ushuaia
//DEL  									" , tipo_padron_parc_id = 1 "  .			//1 Urbano
//DEL  									" , tipo_parcela_id = 1 "  .				// 1 nacional
//DEL  									" , usuario_id = " . CCGetSession("UID") . 
//DEL  									" , parcela_f_proceso = NOW()" ;	
//DEL  	
//DEL  
//DEL  	$dba->query($SQL);
//DEL  	$parcela_id = mysql_insert_id();
//DEL  
//DEL  	$persona_id = $db->f('persona_id');
//DEL  	$persona_parcela_num_int = $db->f('persona_parcela_num_int');
//DEL  	$tipo_instrumento_id = $db->f('tipo_instrumento_id');
//DEL  	$tipo_persona_parcela_id  = $db->f('tipo_persona_parcela_id');
//DEL  	$tmp2_id  = $db->f('tmp2_id');
//DEL  	// creo relacion persona parcela
//DEL  	$SQL = "INSERT INTO personas_parcelas SET  parcela_id = " . $parcela_id . 
//DEL  											", persona_id = " . $persona_id . 
//DEL  											", tipo_instrumento_id = " . $tipo_instrumento_id . 
//DEL  											", persona_parcela_num_int = " . $persona_parcela_num_int . 
//DEL  											", tipo_persona_parcela_id = " . $tipo_persona_parcela_id . 
//DEL  											
//DEL  											" , usuario_id = " . CCGetSession("UID") . 
//DEL  											" , persona_parcela_f_pro = NOW()" .
//DEL  											" , persona_parcela_ppal = 1" ;	 // principañ
//DEL  
//DEL  
//DEL  
//DEL  	$dba->query($SQL);
//DEL  
//DEL  	/*creo un temporario de union desgloce*/
//DEL  	$SQL1 = " SELECT tmp.tmp_id, tmp.tmp_parcela_id
//DEL  			FROM tmp
//DEL  			WHERE tmp.usuario_id = " . CCGetSession("UID")  ;
//DEL  	
//DEL  	$dbb->query($SQL1);
//DEL  	while($Result = $dbb->next_record()){
//DEL  
//DEL  
//DEL  		$SQL1a = " INSERT INTO tmp_u_d SET
//DEL  					tmp_id                = ". $dbb->f('tmp_id')  . ",
//DEL  					tmp_u_d_parcela_id1            = ". $dbb->f('tmp_parcela_id') . ",
//DEL  					tmp2_id     = ". $db->f('tmp2_id') . ",
//DEL  					tmp_u_d_parcela_id2            = ". $parcela_id . ",
//DEL  					usuario_id                = ". CCGetSession("UID") ;
//DEL  		$dba->query($SQL1a);		
//DEL  
//DEL  
//DEL  	}
//DEL  
//DEL  	// migro las mejoras seleccionadas
//DEL  	$SQL1 = " SELECT tmp_mejoras.mejora_id, tmp_mejoras.tmp2_id  , mejoras.*
//DEL  			FROM tmp_mejoras	
//DEL  			INNER JOIN mejoras ON mejoras.mejora_id = tmp_mejoras.mejora_id
//DEL  			WHERE tmp_mejoras.usuario_id = " . CCGetSession("UID") . 
//DEL  				" AND tmp_mejoras.tmp2_id = " . $tmp2_id ;
//DEL  	
//DEL  	$dbb->query($SQL1);
//DEL  	while($Result = $dbb->next_record()){
//DEL  
//DEL  		$tipo_mejora_id		 	=  0;
//DEL  		$tipo_mejora_estado_id	 =  0;
//DEL  		$tipo_mejora_destino_id  = 0;
//DEL  		$mejora_nro_exp		 = 0;
//DEL  		$mejora_letra_exp	 = '';
//DEL  		$mejora_fecha_exp	 = '';
//DEL  		$mejora_sup_cub		 = 0;
//DEL  		$mejora_sup_semi_cub	 = 0;
//DEL  		$mejora_anio_construccion = 0;
//DEL  		$mejora_porc_dominio	 = 0;
//DEL  		$mejora_f_alta		 	= '' ;
//DEL  		$mejora_valor		 = 0;
//DEL  		$mejora_f_baja		 =  '';
//DEL  		$mejora_mot_baja	 = '';
//DEL  		$mejora_observacion	 = '';
//DEL  		$tipo_estado_id		 =  0;
//DEL  
//DEL  
//DEL  		if ($dbb->f('tipo_mejora_id')) $tipo_mejora_id		 =  $dbb->f('tipo_mejora_id');
//DEL  		if ($dbb->f('tipo_mejora_estado_id')) $tipo_mejora_estado_id	 =  $dbb->f('tipo_mejora_estado_id');
//DEL  		if ($dbb->f('tipo_mejora_destino_id')) $tipo_mejora_destino_id  = $dbb->f('tipo_mejora_destino_id');
//DEL  		if ($dbb->f('mejora_nro_exp')) $mejora_nro_exp		 = $dbb->f('mejora_nro_exp');
//DEL  		if ($dbb->f('mejora_letra_exp'))$mejora_letra_exp	 = $dbb->f('mejora_letra_exp');
//DEL  		if ($dbb->f('mejora_fecha_exp')) $mejora_fecha_exp	 = $dbb->f('mejora_fecha_exp');
//DEL  		if($dbb->f('mejora_sup_cub')) $mejora_sup_cub		 = $dbb->f('mejora_sup_cub');
//DEL  		if($dbb->f('mejora_sup_semi_cub')) $mejora_sup_semi_cub	 = $dbb->f('mejora_sup_semi_cub');
//DEL  		if($dbb->f('mejora_anio_construccion'))$mejora_anio_construccion = $dbb->f('mejora_anio_construccion');
//DEL  		if($dbb->f('mejora_porc_dominio'))$mejora_porc_dominio	 = $dbb->f('mejora_porc_dominio');
//DEL  		if($dbb->f('mejora_f_alta'))$mejora_f_alta		 = $dbb->f('mejora_f_alta') ;
//DEL  		if($dbb->f('mejora_valor'))$mejora_valor		 = $dbb->f('mejora_valor');
//DEL  		if($dbb->f('mejora_f_baja'))$mejora_f_baja		 =  $dbb->f('mejora_f_baja');
//DEL  		if($dbb->f('mejora_mot_baja'))$mejora_mot_baja	 = $dbb->f('mejora_mot_baja');
//DEL  		if($dbb->f('mejora_observacion'))$mejora_observacion	 = $dbb->f('mejora_observacion');
//DEL  		if($dbb->f('tipo_estado_id'))$tipo_estado_id		 =  $dbb->f('tipo_estado_id') ;
//DEL  
//DEL  
//DEL  		$SQL1a = " INSERT INTO mejoras SET
//DEL  		parcela_id                = ". $parcela_id  . ",
//DEL  		tipo_mejora_id            = ". $tipo_mejora_id . ",
//DEL  		tipo_mejora_estado_id     = ". $tipo_mejora_estado_id . ",
//DEL  		tipo_mejora_destino_id    = ". $tipo_mejora_destino_id . ", 
//DEL  		mejora_nro_exp            = ". $mejora_nro_exp . ",
//DEL  		mejora_letra_exp          = '". $mejora_letra_exp . "',
//DEL  		mejora_fecha_exp          = '". $mejora_fecha_exp . "',
//DEL  		mejora_sup_cub            = ". $mejora_sup_cub . ",
//DEL  		mejora_sup_semi_cub       = ". $mejora_sup_semi_cub . ",
//DEL  		mejora_anio_construccion  = ". $mejora_anio_construccion . ",
//DEL  		mejora_porc_dominio       = ". $mejora_porc_dominio . ",
//DEL  		mejora_f_alta             = '".$mejora_f_alta . "',
//DEL  		mejora_f_pro              = NOW(),
//DEL  		mejora_valor              = ". $mejora_valor . ",
//DEL  		mejora_f_baja             = '". $mejora_f_baja . "',
//DEL  		mejora_mot_baja           = '". $mejora_mot_baja . "',
//DEL  		mejora_observacion        = '". $mejora_observacion . "',
//DEL  		usuario_id                = ". CCGetSession("UID") . ",
//DEL  		tipo_estado_id            = ". $tipo_estado_id ;
//DEL  
//DEL  		$dba->query($SQL1a);
//DEL  	}
//DEL  
//DEL  	$a++;
//DEL  }
//DEL  			
//DEL  			
//DEL  			
//DEL  // creo la tabla union_desglose			
//DEL  $SQL = " SELECT tmp_u_d.tmp_u_d_parcela_id1, tmp_u_d.tmp_u_d_parcela_id2 FROM tmp_u_d WHERE tmp_u_d.usuario_id = " . CCGetSession("UID") ;
//DEL  $db->query($SQL);
//DEL  $a = 1;
//DEL  while($Result = $db->next_record()){
//DEL  	$SQL = "INSERT INTO uniones_desgloses SET  parcela_id  = " . $db->f('tmp_u_d_parcela_id1') . 
//DEL  									" , parcela_destino_id = " . $db->f('tmp_u_d_parcela_id2') . 
//DEL  									" , usuario_id = " . CCGetSession("UID") . 
//DEL  									" , union_desglose_fecha = NOW()" ;	
//DEL  	
//DEL  	$dba->query($SQL);
//DEL  
//DEL  }
//DEL  
//DEL  			
//DEL  			
//DEL  			
//DEL  			
//DEL  	// borro todo		
//DEL  /*
//DEL  
//DEL  			$SQL = "DELETE FROM tmp
//DEL  					WHERE   usuario_id = " . CCGetSession("UID")  ;
//DEL  			$db->Query($SQL);
//DEL  
//DEL  
//DEL  			$SQL = "DELETE FROM tmp2
//DEL  					WHERE   usuario_id = " . CCGetSession("UID")  ;
//DEL  			$db->Query($SQL);
//DEL  
//DEL  
//DEL  			$SQL = "DELETE FROM tmp_mejoras
//DEL  					WHERE   usuario_id = " . CCGetSession("UID")  ;
//DEL  			$db->Query($SQL);
//DEL  
//DEL  
//DEL  			$SQL = "DELETE FROM tmp_u_d
//DEL  					WHERE   usuario_id = " . CCGetSession("UID")  ;
//DEL  			$db->Query($SQL);
//DEL  
//DEL  
//DEL  */
//DEL  $db->close();
//DEL  $dba->close();
//DEL  
//DEL  // -------------------------

//DEL  // -------------------------
//DEL      // Write your own code here.
//DEL  	$Component->Visible=FALSE;
//DEL  
//DEL  $db = new clsDBtdf_nuevo();
//DEL  
//DEL  //cantidad de mejoras total
//DEL  $estac= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") . " AND secuencia <> 999 " , $db);
//DEL  // cantidad de mejoras asignadas
//DEL  //$esta= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") . " AND mejora_id IS NOT NULL " , $db);
//DEL  $esta= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") . " AND tmp2_id IS NOT NULL " , $db);
//DEL  // ya asocio las personas con la parcela, o sea que creo un tmp_mejopra con las mejoras o con secuencia 999
//DEL  $estap= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") , $db);
//DEL  //echo $esta . " -- " . $estac . " -- " . $estap;
//DEL  //exit;
//DEL  IF (($estac == $esta) AND ($estap > 0 )) $Component->Visible=TRUE;
//DEL  
//DEL  $hay = CCDLookUp("count(tmp2_id)", "tmp2"," usuario_id =" . CCGetSession("UID") , $db);
//DEL  if ($hay == 0) $Component->Visible = FALSE;
//DEL  
//DEL  // si todavia no asocia las personas
//DEL  $per= CCDLookUp("COUNT(tmp2_id)", "tmp2", "usuario_id = " . CCGetSession("UID") . " AND persona_id IS NULL " , $db);
//DEL  //echo "<BR> per->". $per;
//DEL  if ($per <> 0) $Component->Visible = FALSE;
//DEL  
//DEL  $estaud= CCDLookUp("COUNT(tmp_u_d.tmp_u_d_id)", "tmp_u_d", "usuario_id = " . CCGetSession("UID") , $db);
//DEL  if ($estaud) $Component->Visible=FALSE;
//DEL  
//DEL  
//DEL  $db->close();// -------------------------

//DEL  // -------------------------
//DEL      // Write your own code here.
//DEL  	$Component->Visible=FALSE;
//DEL  
//DEL  $db = new clsDBtdf_nuevo();
//DEL  
//DEL  //cantidad de mejoras total
//DEL  $estac= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") . " AND secuencia <> 999 " , $db);
//DEL  // cantidad de mejoras asignadas
//DEL  $esta= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") . " AND tmp2_id IS NOT NULL " , $db);
//DEL  // ya asocio las personas con la parcela, o sea que creo un tmp_mejopra con las mejoras o con secuencia 999
//DEL  $estap= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") , $db);
//DEL  //echo "--->" . $esta . " -- " . $estac . " -- " . $estap;
//DEL  //exit;
//DEL  IF (($estac == $esta) AND ($estap > 0 )) $Component->Visible=TRUE;
//DEL  
//DEL  $hay = CCDLookUp("count(tmp2_id)", "tmp2"," usuario_id =" . CCGetSession("UID") , $db);
//DEL  if ($hay == 0) $Component->Visible = FALSE;
//DEL  //echo "<BR> 1-->" . $hay . "<BR>"; 	
//DEL  
//DEL  // si todavia no asocia las personas
//DEL  $per= CCDLookUp("COUNT(tmp2_id)", "tmp2", "usuario_id = " . CCGetSession("UID") . " AND persona_id IS NULL " , $db);
//DEL  //echo "<BR> per->". $per;
//DEL  if ($per <> 0) $Component->Visible = FALSE;
//DEL  
//DEL  
//DEL  $estaud= CCDLookUp("COUNT(tmp_u_d.tmp_u_d_id)", "tmp_u_d", "usuario_id = " . CCGetSession("UID") , $db);
//DEL  if ($estaud) $Component->Visible=FALSE;
//DEL  
//DEL  
//DEL  
//DEL  $db->close();
//DEL  
//DEL  // -------------------------

//DEL  // -------------------------
//DEL      // Write your own code here.
//DEL  
//DEL  
//DEL  $Component->Visible=FALSE;
//DEL  $db = new clsDBtdf_nuevo();
//DEL  $estaud= CCDLookUp("COUNT(tmp_u_d.tmp_u_d_id)", "tmp_u_d", "usuario_id = " . CCGetSession("UID") , $db);
//DEL  if ($estaud) $Component->Visible=TRUE;
//DEL  $db->close();
//DEL  
//DEL  // -------------------------

//DEL  // -------------------------
//DEL      // Write your own code here.
//DEL  
//DEL  
//DEL  $db = new clsDBtdf_nuevo();
//DEL  $db2 = new clsDBtdf_nuevo();
//DEL  $SQL = "DELETE FROM tmp_mejoras WHERE  usuario_id = " . CCGetSession("UID")  ;
//DEL  $db->Query($SQL);
//DEL  
//DEL  $SQL = " SELECT mejoras.mejora_id as mejoraid FROM tmp INNER JOIN parcelas ON parcelas.parcela_id = tmp.tmp_parcela_id  INNER JOIN mejoras ON mejoras.parcela_id = parcelas.parcela_id WHERE tmp.usuario_id = " . CCGetSession("UID") ;
//DEL  $db->query($SQL);
//DEL  $a = 1;
//DEL  while($Result = $db->next_record()){
//DEL  	
//DEL  	$SQL = "INSERT INTO tmp_mejoras SET  mejora_id = " . $db->f('mejoraid') . " , usuario_id = " . CCGetSession("UID") . " , secuencia = " . ($a + 1)  ;	
//DEL  	//echo $SQL;
//DEL  	//exit;
//DEL  	$db2->query($SQL);
//DEL  	$a++;
//DEL  }
//DEL  if ($a == 1){
//DEL  
//DEL  	$SQL = "INSERT INTO tmp_mejoras SET  usuario_id = " . CCGetSession("UID") . " , secuencia = 999" ;	
//DEL  	$db2->query($SQL);
//DEL  
//DEL  }
//DEL  
//DEL  
//DEL  $db->close();
//DEL  $db2->close();
//DEL  
//DEL  
//DEL  // -------------------------

//DEL  // -------------------------
//DEL      // Write your own code here.
//DEL  
//DEL  $db = new clsDBtdf_nuevo();
//DEL  
//DEL  
//DEL  
//DEL  
//DEL  
//DEL  
//DEL  //si asigno todas mejoras
//DEL  $listo = CCDLookUp("count(tmp_mejora_id)", "tmp_mejoras","tmp2_id IS NULL AND usuario_id =" . CCGetSession("UID") , $db);
//DEL  // si hay mejoras
//DEL  $tiene = CCDLookUp("count(tmp_mejora_id)", "tmp_mejoras","usuario_id =" . CCGetSession("UID") , $db);
//DEL  $Component->Visible = TRUE;
//DEL  if (($listo == 0) AND ($tiene > 0)){
//DEL  $Component->Visible = FALSE;
//DEL  }
//DEL  
//DEL  
//DEL  
//DEL  // hay por lo menos un tm2
//DEL  $hay = CCDLookUp("count(tmp2_id)", "tmp2"," usuario_id =" . CCGetSession("UID") , $db);
//DEL  if ($hay == 0) $Component->Visible = FALSE;
//DEL  //echo "<BR> &&&&-->" . $hay . "<BR>"; 	
//DEL  // si todavia no asocia las personas
//DEL  $per= CCDLookUp("COUNT(tmp2_id)", "tmp2", "usuario_id = " . CCGetSession("UID") . " AND persona_id IS NULL " , $db);
//DEL  //echo "<BR> per->". $per;
//DEL  if ($per == 0) $Component->Visible = FALSE;
//DEL  
//DEL  
//DEL  
//DEL  
//DEL  $db->Query($SQL);
//DEL  
//DEL  /*
//DEL  	$Component->Visible=FALSE;
//DEL  
//DEL  $db = new clsDBtdf_nuevo();
//DEL  
//DEL  //cantidad de mejoras total
//DEL  $estac= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") . " AND secuencia <> 999 " , $db);
//DEL  // cantidad de mejoras asignadas
//DEL  $esta= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") . " AND tmp2_id IS NOT NULL " , $db);
//DEL  // ya asocio las personas con la parcela, o sea que creo un tmp_mejopra con las mejoras o con secuencia 999
//DEL  $estap= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") , $db);
//DEL  //echo $esta . " -- " . $estac . " -- " . $estap;
//DEL  //exit;
//DEL  IF (($estac == $esta) AND ($estap > 0 )) $Component->Visible=TRUE;
//DEL  $db->close();
//DEL  
//DEL  */
//DEL  
//DEL  
//DEL  
//DEL  
//DEL  
//DEL  // -------------------------

//DEL  // -------------------------
//DEL      // Write your own code here.
//DEL  
//DEL  
//DEL  $db = new clsDBtdf_nuevo();
//DEL  
//DEL  
//DEL  			$SQL = "DELETE FROM tmp
//DEL  					WHERE   usuario_id = " . CCGetSession("UID")  ;
//DEL  			//$db->Query($SQL);
//DEL  
//DEL  
//DEL  			$SQL = "DELETE FROM tmp2
//DEL  					WHERE   usuario_id = " . CCGetSession("UID")  ;
//DEL  			$db->Query($SQL);
//DEL  
//DEL  
//DEL  			$SQL = "DELETE FROM tmp_mejoras
//DEL  					WHERE   usuario_id = " . CCGetSession("UID")  ;
//DEL  			$db->Query($SQL);
//DEL  
//DEL  
//DEL  			$SQL = "DELETE FROM tmp_u_d
//DEL  					WHERE   usuario_id = " . CCGetSession("UID")  ;
//DEL  			$db->Query($SQL);
//DEL  
//DEL  
//DEL  
//DEL  $db->close();
//DEL  
//DEL  // -------------------------

//DEL  // -------------------------
//DEL      // Write your own code here.
//DEL  
//DEL  $Component->Visible=FALSE;
//DEL  $db = new clsDBtdf_nuevo();
//DEL  $estaud= CCDLookUp("COUNT(tmp_u_d.tmp_u_d_id)", "tmp_u_d", "usuario_id = " . CCGetSession("UID") , $db);
//DEL  if ($estaud) $Component->Visible=TRUE;
//DEL  $db->close();
//DEL  // -------------------------

//Page_BeforeInitialize @1-8B5D16D0
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $union6; //Compatibility
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

//Page_AfterInitialize @1-4ACBB146
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $union6; //Compatibility
//End Page_AfterInitialize

//Custom Code @481-2A29BDB7
// -------------------------

    // Write your own code here.
// -------------------------
//End Custom Code

//Close Page_AfterInitialize @1-379D319D
    return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize
?>
