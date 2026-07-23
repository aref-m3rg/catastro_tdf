<?php
//BindEvents Method @1-BA18D9F4
function BindEvents()
{
    global $planos;
    global $parcelas_origen_prov;
    global $parcelas_destino_prov;
    global $parcelas_destino;
    global $parcelas_origen;
    global $CCSEvents;
    $planos->plano_archivo->CCSEvents["AfterProcessFile"] = "planos_plano_archivo_AfterProcessFile";
    $planos->Button_Archivar->CCSEvents["OnClick"] = "planos_Button_Archivar_OnClick";
    $planos->Button_Anular->CCSEvents["OnClick"] = "planos_Button_Anular_OnClick";
    $planos->Button_Suspender->CCSEvents["OnClick"] = "planos_Button_Suspender_OnClick";
    $planos->CustomError->CCSEvents["BeforeShow"] = "planos_CustomError_BeforeShow";
    $planos->Button_Vigencia->CCSEvents["OnClick"] = "planos_Button_Vigencia_OnClick";
    $planos->Button_Editar->CCSEvents["OnClick"] = "planos_Button_Editar_OnClick";
    $planos->baja_pura->CCSEvents["OnClick"] = "planos_baja_pura_OnClick";
    $planos->CCSEvents["AfterInsert"] = "planos_AfterInsert";
    $planos->CCSEvents["AfterUpdate"] = "planos_AfterUpdate";
    $planos->CCSEvents["BeforeShow"] = "planos_BeforeShow";
    $planos->CCSEvents["OnValidate"] = "planos_OnValidate";
    $parcelas_origen_prov->origen_TotalRecords->CCSEvents["BeforeShow"] = "parcelas_origen_prov_origen_TotalRecords_BeforeShow";
    $parcelas_origen_prov->Navigator->CCSEvents["BeforeShow"] = "parcelas_origen_prov_Navigator_BeforeShow";
    $parcelas_origen_prov->ds->CCSEvents["AfterExecuteDelete"] = "parcelas_origen_prov_ds_AfterExecuteDelete";
    $parcelas_origen_prov->CCSEvents["BeforeShow"] = "parcelas_origen_prov_BeforeShow";
    $parcelas_origen_prov->CCSEvents["BeforeShowRow"] = "parcelas_origen_prov_BeforeShowRow";
    $parcelas_destino_prov->parcelas1_TotalRecords->CCSEvents["BeforeShow"] = "parcelas_destino_prov_parcelas1_TotalRecords_BeforeShow";
    $parcelas_destino_prov->plano->CCSEvents["BeforeShow"] = "parcelas_destino_prov_plano_BeforeShow";
    $parcelas_destino_prov->CCSEvents["BeforeShowRow"] = "parcelas_destino_prov_BeforeShowRow";
    $parcelas_destino_prov->CCSEvents["BeforeShow"] = "parcelas_destino_prov_BeforeShow";
    $parcelas_destino->parcelas1_TotalRecords->CCSEvents["BeforeShow"] = "parcelas_destino_parcelas1_TotalRecords_BeforeShow";
    $parcelas_destino->CCSEvents["BeforeShowRow"] = "parcelas_destino_BeforeShowRow";
    $parcelas_destino->CCSEvents["BeforeShow"] = "parcelas_destino_BeforeShow";
    $parcelas_origen->parcelas1_TotalRecords->CCSEvents["BeforeShow"] = "parcelas_origen_parcelas1_TotalRecords_BeforeShow";
    $parcelas_origen->CCSEvents["BeforeShowRow"] = "parcelas_origen_BeforeShowRow";
    $parcelas_origen->CCSEvents["BeforeShow"] = "parcelas_origen_BeforeShow";
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
}
//End BindEvents Method


//planos_plano_archivo_AfterProcessFile @120-31235663
function planos_plano_archivo_AfterProcessFile(& $sender)
{
    $planos_plano_archivo_AfterProcessFile = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planos; //Compatibility
//End planos_plano_archivo_AfterProcessFile

//Custom Code @121-2A29BDB7
// -------------------------


	/* Renombra el archivo subido y actualiza el nombre en la tabla
	--------------------------------------------------------------- */

	$old = $Component->GetValue();
	$oldInfo = pathinfo( $old ); // print_r( $oldInfo );

	$new = date('Ymd_') . uniqid() . '.' . $oldInfo['extension'];
	rename( RelativePath . "/tecnica/planos/".$old, RelativePath . "/tecnica/planos/".$new);
	$db = new clsDBtdf_nuevo();
	$db->query("UPDATE planos SET plano_archivo = '" . $new . "' WHERE plano_archivo = '" . $old . "'");
	$db->close();


// -------------------------
//End Custom Code

//Close planos_plano_archivo_AfterProcessFile @120-8A498799
    return $planos_plano_archivo_AfterProcessFile;
}
//End Close planos_plano_archivo_AfterProcessFile

//planos_Button_Archivar_OnClick @308-747B7790
function planos_Button_Archivar_OnClick(& $sender)
{
    $planos_Button_Archivar_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planos; //Compatibility
//End planos_Button_Archivar_OnClick

//Custom Code @330-2A29BDB7
// -------------------------

	$db = new clsDBtdf_nuevo();
	$planoId = CCGetParam('plano_id');


	/* Procedimiento de Archivar un plano:
	---------------------------------------------------------------------------
	    Se liberan las nomenclaturas para poder usarlas nuevamente	
	*/

  /* -- Se verifica si se ha introducido la disposición */
  $disposicion = $Container->plano_disposicion->GetValue();

  if( !empty( $disposicion ) ) {//si exite una disposicion

    /* -- Trae las parcelas de destino activas y las pone inactivas */

  	$parcelasActivas = planoGetProvActive( $planoId, 'both', $db );
	
  	if ( !empty( $parcelasActivas ) ) {
  		foreach( $parcelasActivas as $parcela ) {
  			$SQL = 'UPDATE `planos_parc_prov` SET `planos_parc_prov`.`tipo_estado_id` = 2 WHERE `planos_parc_prov`.`planos_prov_id` = ' . mysql_real_escape_string( $parcela['planos_prov_id'] );
  			$db->query( $SQL );
  		} 

  	}

  	/* -- Pone el plano en estado 'Archivado' y guarda la disposición */
  	if ( !empty( $planoId ) ) {
  		$SQL = 'UPDATE `planos` SET `planos`.`tipo_estado_plano_id` = 6, `planos`.`plano_disposicion` = "' . mysql_real_escape_string( $disposicion ) . '" WHERE `planos`.`plano_id` = ' . mysql_real_escape_string( $planoId );
		//debug($SQL);
  		$db->query( $SQL );
  	}
  } else {
    /* -- Si no se indicó disposición guarda en la sesión el mensaje de error */
    $msg  = '<span style="color:red;">Para archivar un plano debe cargar una disposición.</span>';
    $msg .= '<script type="text/javascript">jQuery(document).ready( function() { alert("No se pudo archivar el plano. Se debe indicar una disposición.") });</script>';
    CCSetSession('CustomErrorMsg', $msg);

  }

	$db->close();


// -------------------------
//End Custom Code

//Close planos_Button_Archivar_OnClick @308-7ABFD451
    return $planos_Button_Archivar_OnClick;
}
//End Close planos_Button_Archivar_OnClick

//planos_Button_Anular_OnClick @309-C35CE6DC
function planos_Button_Anular_OnClick(& $sender)
{
    $planos_Button_Anular_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planos; //Compatibility
//End planos_Button_Anular_OnClick

//Custom Code @507-2A29BDB7
// -------------------------


	$db = new clsDBtdf_nuevo();
	$planoId = CCGetParam('plano_id');


	/* Proceso de Anulación del plano
	--------------------------------------------------------------- */

	if ( !empty( $planoId ) ) {

		// TODO: 1ero. se debería chequear acá los permisos del usuario?

    /* -- Se verifica si se ha introducido la disposición */
    $disposicion = $Container->plano_disposicion->GetValue();

    if( !empty( $disposicion ) ) {

  		/* -- Baja de las partidas y nomenclaturas -- */

  		$parcelasDestino = CCQueryToArray(
  			'SELECT parcelas.* FROM parcelas
  			INNER JOIN uniones_desgloses ON uniones_desgloses.parcela_destino_id = parcelas.parcela_id
  			WHERE uniones_desgloses.plano_id = ' . mysql_real_escape_string( $planoId ) , $db);

  		foreach( $parcelasDestino as $parcela ) {
  			$SQL = 'UPDATE parcelas SET parcela_f_proceso = NOW(), tipo_est_parc_id = 2, usuario_id = ' . mysql_real_escape_string( CCGetSession('UID') ) . ' WHERE parcela_id = ' . mysql_real_escape_string( $parcela['parcela_id'] );

  			//debug( $SQL );
  			$db->query( $SQL );
  		}



  		/* -- Pasar las parcelas de origen a "Activas" */

		// Trae las provisorias, teniendo que traer las activas
		// Modificado por sql de abajo, 9/12/19
  		/*$parcelasOrigen = CCQueryToArray(
  			'SELECT parcelas.*
  			FROM planos_parc_prov
  			INNER JOIN parcelas ON parcelas.parcela_id = planos_parc_prov.parcela_id
  			WHERE plano_id = ' . mysql_real_escape_string( $planoId ) . ' AND planos_parc_prov_tipo = "origen" AND planos_parc_prov.tipo_estado_id = 1;', $db );
		*/

		$parcelasOrigen = CCQueryToArray(
  			'SELECT parcelas.*, tipo_est_parc_descr 
FROM (parcelas LEFT JOIN tipos_estados_parcela ON
parcelas.tipo_est_parc_id = tipos_estados_parcela.tipo_est_parc_id) INNER JOIN uniones_desgloses ON
uniones_desgloses.parcela_id = parcelas.parcela_id
WHERE uniones_desgloses.plano_id = ' . mysql_real_escape_string( $planoId ) . '
GROUP BY parcelas.parcela_id ', $db );


  		foreach( $parcelasOrigen as $parcelaO ) {
  			$SQL = 'UPDATE parcelas SET parcela_f_proceso = NOW(), tipo_est_parc_id = 1, usuario_id = ' . mysql_real_escape_string( CCGetSession('UID') ) . ' WHERE parcela_id = ' . mysql_real_escape_string( $parcelaO['parcela_id'] );
			
  			//debug( $SQL );
  			$db->query( $SQL );
  		}



  		/* -- Pasar el plano al estado "Anulado" */

  		$SQL = 'UPDATE `planos` SET `planos`.`tipo_estado_plano_id` = 1, `planos`.`plano_disposicion` = "' . mysql_real_escape_string( $disposicion ) . '" WHERE `planos`.`plano_id` = ' . mysql_real_escape_string( $planoId );

  		//debug( $SQL );
  	  $db->query( $SQL );

    } else {

      /* -- Si no se indicó disposición guarda en la sesión el mensaje de error */
      $msg  = '<span style="color:red;">Para anular un plano debe cargar una disposición.</span>';
      $msg .= '<script type="text/javascript">jQuery(document).ready( function() { alert("No se pudo anular el plano. Se debe indicar una disposición.") });</script>';
      CCSetSession('CustomErrorMsg', $msg);

    }

	}

	$db->close();


// -------------------------
//End Custom Code

//Close planos_Button_Anular_OnClick @309-5EBBC2EF
    return $planos_Button_Anular_OnClick;
}
//End Close planos_Button_Anular_OnClick

//planos_Button_Suspender_OnClick @310-1F1F2DB0
function planos_Button_Suspender_OnClick(& $sender)
{
    $planos_Button_Suspender_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planos; //Compatibility
//End planos_Button_Suspender_OnClick

//Custom Code @508-2A29BDB7
// -------------------------

	$db = new clsDBtdf_nuevo();
	$planoId = CCGetParam('plano_id');


	/* Proceso de Supensión del plano
	--------------------------------------------------------------- */

	if ( !empty( $planoId ) ) {

		// TODO: 1ero. se debería chequear acá los permisos del usuario?

    /* -- Se verifica si se ha introducido la disposición */
    $disposicion = $Container->plano_disposicion->GetValue();

    if( !empty( $disposicion ) ) {

		  /* -- Pase de las parcelas de destino a "En trámite" -- */

  		$parcelasDestino = CCQueryToArray(
  			'SELECT parcelas.* FROM parcelas
  			INNER JOIN uniones_desgloses ON uniones_desgloses.parcela_destino_id = parcelas.parcela_id
  			WHERE uniones_desgloses.plano_id = ' . mysql_real_escape_string( $planoId ) , $db);

  		foreach( $parcelasDestino as $parcela ) {
  			$SQL = 'UPDATE parcelas SET parcela_f_proceso = NOW(), tipo_est_parc_id = 3, usuario_id = ' . mysql_real_escape_string( CCGetSession('UID') ) . ' WHERE parcela_id = ' . mysql_real_escape_string( $parcela['parcela_id'] );

  			//debug( $SQL );
  			$db->query( $SQL );
  		}


  		/* -- Pasar el plano al estado "Suspendido" */

  		$SQL = 'UPDATE `planos` SET `planos`.`tipo_estado_plano_id` = 8, `planos`.`plano_disposicion` = "' . mysql_real_escape_string( $disposicion ) . '" WHERE `planos`.`plano_id` = ' . mysql_real_escape_string( $planoId );
  		//debug( $SQL );
  		$db->query( $SQL );

    } else {

      /* -- Si no se indicó disposición guarda en la sesión el mensaje de error */
      $msg  = '<span style="color:red;">Para suspender un plano debe cargar una disposición.</span>';
      $msg .= '<script type="text/javascript">jQuery(document).ready( function() { alert("No se pudo supender el plano. Se debe indicar una disposición.") });</script>';
      CCSetSession('CustomErrorMsg', $msg);

    }


	}



	$db->close();



// -------------------------
//End Custom Code

//Close planos_Button_Suspender_OnClick @310-205083B3
    return $planos_Button_Suspender_OnClick;
}
//End Close planos_Button_Suspender_OnClick

//planos_CustomError_BeforeShow @522-9C73FEEC
function planos_CustomError_BeforeShow(& $sender)
{
    $planos_CustomError_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planos; //Compatibility
//End planos_CustomError_BeforeShow

//Custom Code @523-2A29BDB7
// -------------------------

  /* Verifica en la sesión si hay algún mensaje para mostrar */
  $msg = CCGetSession( 'CustomErrorMsg', false );

  if ( !empty( $msg ) ) {
    // si hay mensaje lo muestra en el label y luego borra el mensaje de la sesión
    $Component->SetValue( $msg );
    unset( $_SESSION['CustomErrorMsg'] );
  }


// -------------------------
//End Custom Code

//Close planos_CustomError_BeforeShow @522-CBB7845E
    return $planos_CustomError_BeforeShow;
}
//End Close planos_CustomError_BeforeShow

//planos_Button_Vigencia_OnClick @534-810D98E4
function planos_Button_Vigencia_OnClick(& $sender)
{
    $planos_Button_Vigencia_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planos; //Compatibility
//End planos_Button_Vigencia_OnClick

//Custom Code @535-2A29BDB7
// -------------------------
    
	$db = new clsDBtdf_nuevo();
	$planoId = CCGetParam('plano_id');
	$planoData = CCQueryToArray( 'SELECT * FROM planos WHERE plano_id = ' . mysql_real_escape_string( $planoId ) . ';', $db );
	$isPlanoSVC = ( empty($planoData[0]['plano_svc']) ) ? false : true; //debug($isPlanoSVC);


	/* Proceso de Dar Vigencia a un plano
	--------------------------------------------------------------- */
	if ( !empty( $planoId ) && $isPlanoSVC ) {
		// pasar las parcelas de origen a Histórica
	    $parcelasOrigenQuery = 'SELECT parcelas.*
	      FROM planos_parc_prov
	      INNER JOIN parcelas ON parcelas.parcela_id = planos_parc_prov.parcela_id
	      WHERE plano_id = ' . mysql_real_escape_string( $planoId ) . ' AND planos_parc_prov_tipo = "origen" AND planos_parc_prov.tipo_estado_id = 1;';
	    $parcelasOrigen = CCQueryToArray( $parcelasOrigenQuery, $db ); //debug($parcelasOrigen);

		if ( !empty($parcelasOrigen) ) {
		  foreach( $parcelasOrigen as $po ) {
		    $query = 'UPDATE parcelas SET tipo_est_parc_id = 2 WHERE parcela_id = ' . $po['parcela_id']; //debug($query);
			$db->query($query);
		  }
		}

		// traer las parcelas de destino, asignarles partida y ponerlas activas
		$parcelasDestinoQuery = 'SELECT uniones_desgloses.union_desglose_id, uniones_desgloses.parcela_id, uniones_desgloses.parcela_destino_id, parcelas.parcela_partida, parcelas.tipo_est_parc_id FROM uniones_desgloses INNER JOIN parcelas ON parcelas.parcela_id = uniones_desgloses.parcela_destino_id WHERE plano_id = ' . mysql_real_escape_string($planoId);
		$parcelasDestino = CCQueryToArray( $parcelasDestinoQuery, $db ); //debug($parcelasDestino);

		if ( !empty($parcelasDestino) ) {
		  foreach( $parcelasDestino as $pd ) {
		  	if ( empty($pd['parcela_partida'] ) ) {
				$ultimaPartida = getUltimaPartida( $db );
            	$ultimaPartida++;
				$sqlPartida = 'parcela_partida = ' . $ultimaPartida . ', ';
			} else {
				$sqlPartida = '';
			}

		    $query = 'UPDATE parcelas SET ' . $sqlPartida . 'tipo_est_parc_id = 1 WHERE parcela_id = ' . $pd['parcela_destino_id'];
		    //debug($query);
			$db->query($query);
		  }
		}


		// cambiar el atributo SVC del plano
		$query = 'UPDATE planos SET plano_svc = 0 WHERE plano_id = ' . mysql_real_escape_string($planoId); //debug( $query );
		$db->query($query);
	}


	$db->close();


// -------------------------
//End Custom Code

//Close planos_Button_Vigencia_OnClick @534-C22B5AFC
    return $planos_Button_Vigencia_OnClick;
}
//End Close planos_Button_Vigencia_OnClick

//planos_Button_Editar_OnClick @537-EB78EF75
function planos_Button_Editar_OnClick(& $sender)
{
    $planos_Button_Editar_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planos; //Compatibility
//End planos_Button_Editar_OnClick

//Custom Code @538-2A29BDB7
// -------------------------

	$db = new clsDBtdf_nuevo();
	$planoId = CCGetParam('plano_id');


	/* Proceso de Editar Plano
	--------------------------------------------------------------- */
	$planoDataQuery = 'SELECT * FROM planos WHERE plano_id = ' . mysql_real_escape_string($planoId);
	$planoData = CCQueryToArray( $planoDataQuery, $db ); //debug($planoData);


	// Si el plano no está en edición procede a ponerlo en ese estado y copiar a las provisorias las parcelas vinculadas
	if ( $planoData[0]['plano_en_edicion'] != 1 ) {

		// Pone el plano en edición
		$query = 'UPDATE planos SET plano_en_edicion = 1 WHERE plano_id = ' . mysql_real_escape_string($planoId); //debug($query);
		$db->query( $query );

		// Hace el snapshot del plano en formato PDF

		// Borra de la tabla de provisorias todo lo relacionado con el plano
		$query = 'DELETE FROM planos_parc_prov WHERE plano_id = ' . mysql_real_escape_string($planoId); //debug($query);
		$db->query( $query );


		// Copia las parcelas actuales a la tabla de parecelas provisorias para la edición
		// PO 
		$parcelasOrigenQuery = 'SELECT * FROM uniones_desgloses WHERE plano_id = ' . mysql_real_escape_string($planoId) . ' AND (parcela_id IS NOT NULL OR parcela_id != "" OR parcela_id != 0) GROUP BY parcela_id';
		$parcelasOrigen = CCQueryToArray( $parcelasOrigenQuery, $db ); //debug($parcelasOrigen);

		// Agrega las PO a la tabla de provisorias
		foreach( $parcelasOrigen as $po ) {
			$query = 'INSERT INTO planos_parc_prov SET plano_id = ' . mysql_real_escape_string($planoId) . ', planos_parc_prov_tipo = "origen", parcela_id = ' . mysql_real_escape_string($po['parcela_id']); //debug($query);
			$db->query( $query );
		}

		// PD 
		$parcelasDestinoQuery = 'SELECT * FROM uniones_desgloses WHERE plano_id = ' . mysql_real_escape_string($planoId) . ' AND (parcela_destino_id IS NOT NULL OR parcela_destino_id != "" OR parcela_destino_id != 0) GROUP BY parcela_destino_id';
		$parcelasDestino = CCQueryToArray( $parcelasDestinoQuery, $db ); //debug($parcelasDestino);

		// Agrega las PD a la tabla de provisorias
		foreach( $parcelasDestino as $pd ) {
			$query = 'INSERT INTO planos_parc_prov SET plano_id = ' . mysql_real_escape_string($planoId) . ', planos_parc_prov_tipo = "destino", parcela_id = ' . mysql_real_escape_string( $pd['parcela_destino_id'] ); //debug($query);
			$db->query( $query );
		}

	}


	// Cierra la conexión a la ddbb y redirecciona por la página seteada en el botón
	$db->close();


// -------------------------
//End Custom Code

//Close planos_Button_Editar_OnClick @537-4FC62B88
    return $planos_Button_Editar_OnClick;
}
//End Close planos_Button_Editar_OnClick

//planos_baja_pura_OnClick @606-F3BE76F2
function planos_baja_pura_OnClick(& $sender)
{
    $planos_baja_pura_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planos; //Compatibility
//End planos_baja_pura_OnClick

//Custom Code @608-2A29BDB7
// -------------------------
   	if( CCGetParam(plano_id)){
   		$plano_id = CCGetParam(plano_id);
		$db = new clsDBtdf_nuevo();
		$db->query("INSERT INTO planos_bajas SELECT * FROM planos WHERE plano_id = ".$plano_id);
		$db->query("DELETE FROM planos WHERE plano_id = ".$plano_id);
		$db->close();		
		header("Location: ./tc_planosGrid.php");
		die();
   	}
// -------------------------
//End Custom Code

//Close planos_baja_pura_OnClick @606-C7AA8B62
    return $planos_baja_pura_OnClick;
}
//End Close planos_baja_pura_OnClick

//DEL  // -------------------------
//DEL      $planos->Label2->SetValue('');
//DEL  // -------------------------

//planos_AfterInsert @5-22B01F1B
function planos_AfterInsert(& $sender)
{
    $planos_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planos; //Compatibility
//End planos_AfterInsert

//Custom Code @47-2A29BDB7
// -------------------------

	/* Despues de insertar redirige a la edición del mismo plano
	--------------------------------------------------------------- */

	// toma el ID del plano insertado
	$id = mysql_insert_id();

    // trae la ruta del redirect para luego modificarla para que se vuelva a la misma
	// página luego de guardar
	global $Redirect;
	$Redirect = "tc_planosRecord.php?plano_id=" . $id;



	/* Auditar plano insertado
	--------------------------------------------------------------- */

	auditar("planos", $id, 3);


// -------------------------
//End Custom Code

//Close planos_AfterInsert @5-1F81C347
    return $planos_AfterInsert;
}
//End Close planos_AfterInsert

//planos_AfterUpdate @5-D1CEA9B7
function planos_AfterUpdate(& $sender)
{
    $planos_AfterUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planos; //Compatibility
//End planos_AfterUpdate

//Custom Code @48-2A29BDB7
// -------------------------


	/* Auditar plano modificado
	--------------------------------------------------------------- */

	auditar("planos", CCGetParam(plano_id), 5);


// -------------------------
//End Custom Code

//Close planos_AfterUpdate @5-D0A802C8
    return $planos_AfterUpdate;
}
//End Close planos_AfterUpdate

//planos_BeforeShow @5-F6E56A0C
function planos_BeforeShow(& $sender)
{
    $planos_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planos; //Compatibility
//End planos_BeforeShow

//Custom Code @52-2A29BDB7
// -------------------------

	$nivel_id = CCGetSession("nivel_id");
	$GID = CCGetSession("GID");
	$menu_id = CCGetSession("menu_id");
	$perfil_id = CCGetSession("perfil_id");
	$pagina = CCGetSession("pagina");

	//Ariel -- 15/02/2016
	$Component->planos->Button_desarchivar->Visible = FALSE;
	/*
	if($nivel_id == 2){
		$Component->Button_Insert->Visible = TRUE;
	}else{
		$Component->Button_Insert->Visible = TRUE;
	}
	*/


	$db = new clsDBtdf_nuevo();

	/* Decide qué paneles y controles mostrar dentro del record.
	   Los botones y grids se manejan en el BeforeShow de la pag.
	-------------------------------------------------------------- */

	// si ya existe el ID del plano...
	if( CCGetParam(plano_id) ) {

		// parece haber quedado de antes ya que no existe el Panel1: $Component->Panel1->Visible = false;
		// muestra el botón de "Registrar Plano"
		$Component->registrar->Visible = true;
	
	// si no existe el ID (se está insertando registro)
	} else {

		// oculta el panel de la documentación
		$Component->Panel2->Visible = false;
		// oculta el botón de "Registrar Plano"
		$Component->registrar->Visible = false;

	}

	/* Trae el dato del estado actual del plano p/ el label
	--------------------------------------------------------- */

	$estadoPlano = $Component->DataSource->f('tipo_estado_plano_id');

	if ( !empty( $estadoPlano ) ) {

		$estadoPlanoNombre = CCDLookUp('tipo_estado_plano_desc', 'tipos_estados_planos', 'tipo_estado_plano_id = ' . $estadoPlano, $db );

		if ( !empty( $estadoPlanoNombre ) ) {
			$Component->plano_estado_desc->SetValue( $estadoPlanoNombre );
		}
		/*
		//si el estado del plano es archivado, muestra boton de desarchivar
		if($estadoPlano == 6){
			$planos->Button_desarchivar->Visible = TRUE;
		}else{//sino, no lo muestra
			$planos->Button_desarchivar->Visible = FALSE;
		}
		*/
	}else{
		//$Component->Button_Registrar->Visible = true;
	}

	/* Genera HTML para mostrar el archivo atachado y los escaneados
	---------------------------------------------------------------- */
    $slides = generarPlanoSlides( CCGetParam(plano_id), array('width' => 210, 'height' => 158, 'additional_classes' => 'medium', 'encode' => false), $db);

	if ( !empty($slides) ) {
		$htm = $slides;
	} else {
		$htm = '';
	}

	$Component->htm->SetValue( $htm );

	$db->close();
// -------------------------
//End Custom Code

//Close planos_BeforeShow @5-2AC242DA
    return $planos_BeforeShow;
}
//End Close planos_BeforeShow

//planos_OnValidate @5-861650EB
function planos_OnValidate(& $sender)
{
    $planos_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planos; //Compatibility
//End planos_OnValidate

//Custom Code @277-2A29BDB7
// -------------------------


	$db = new clsDBtdf_nuevo();


	/* Validar que la numeración del plano sea única
	--------------------------------------------------------- */

	// si se han indicado los datos necesarios
	if (
		$Component->tipo_depto_parc_id->GetValue() &&
		$Component->plano_nro->GetValue() &&
		$Component->plano_anio->GetValue()
	) {

		// guarda valores necesarios en variables
		$tipo_depto_parc_id = $Component->tipo_depto_parc_id->GetValue();
		$plano_nro = $Component->plano_nro->GetValue();
		$plano_anio = $Component->plano_anio->GetValue();
		$plano_id = CCGetParam(plano_id);

		if( $plano_id ) {

			// si existe el ID del plano cuenta cuántos planos hay con los parámetros especificados
			// que no sea el plano actual (al actualizar el registro)
			$chk = CCDLookUp(
				'COUNT(*)',
				'planos',
				"tipo_depto_parc_id=$tipo_depto_parc_id AND plano_nro=$plano_nro AND plano_anio=$plano_anio AND plano_id <> $plano_id",
				$db
			);

		} else {

			// cuenta cuántos planos hay con los parámetros indicados (al insertar el registro)
			$chk = CCDLookUp(
				'COUNT(*)',
				'planos',
				"tipo_depto_parc_id=$tipo_depto_parc_id AND plano_nro=$plano_nro AND plano_anio=$plano_anio",
			$db);

		}

		if( $chk > 0 ){
			$Component->Errors->AddError('Ya existe un plano con este Nro. para este departamento. Por favor verificar!');
		}

	}

	$db->close();


// -------------------------
//End Custom Code

//Close planos_OnValidate @5-15392653
    return $planos_OnValidate;
}
//End Close planos_OnValidate

//parcelas_origen_prov_origen_TotalRecords_BeforeShow @332-7B7F3846
function parcelas_origen_prov_origen_TotalRecords_BeforeShow(& $sender)
{
    $parcelas_origen_prov_origen_TotalRecords_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_origen_prov; //Compatibility
//End parcelas_origen_prov_origen_TotalRecords_BeforeShow

//Retrieve number of records @333-ABE656B4
    $Component->SetValue($Container->DataSource->RecordsCount);
//End Retrieve number of records

//Close parcelas_origen_prov_origen_TotalRecords_BeforeShow @332-1FD89AE6
    return $parcelas_origen_prov_origen_TotalRecords_BeforeShow;
}
//End Close parcelas_origen_prov_origen_TotalRecords_BeforeShow

//parcelas_origen_prov_Navigator_BeforeShow @345-109E1D18
function parcelas_origen_prov_Navigator_BeforeShow(& $sender)
{
    $parcelas_origen_prov_Navigator_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_origen_prov; //Compatibility
//End parcelas_origen_prov_Navigator_BeforeShow

//Hide-Show Component @346-0DB41530
    $Parameter1 = $Container->DataSource->PageCount();
    $Parameter2 = 2;
    if (((is_array($Parameter1) || strlen($Parameter1)) && (is_array($Parameter2) || strlen($Parameter2))) && 0 >  CCCompareValues($Parameter1, $Parameter2, ccsInteger))
        $Component->Visible = false;
//End Hide-Show Component

//Close parcelas_origen_prov_Navigator_BeforeShow @345-62DF829A
    return $parcelas_origen_prov_Navigator_BeforeShow;
}
//End Close parcelas_origen_prov_Navigator_BeforeShow

//parcelas_origen_prov_ds_AfterExecuteDelete @331-1589A07E
function parcelas_origen_prov_ds_AfterExecuteDelete(& $sender)
{
    $parcelas_origen_prov_ds_AfterExecuteDelete = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_origen_prov; //Compatibility
//End parcelas_origen_prov_ds_AfterExecuteDelete

//Custom Code @388-2A29BDB7
// -------------------------

    /* Borra las parcela de origen seleccionadas.
	   Este evento se ejecuta después del custom delete (que no hace nada)
    ------------------------------------------------------------------------- */

	$planoId = CCGetParam(plano_id);

	if( $planoId ) {

		$theId = $Component->planos_prov_id->GetValue();

		$db = new clsDBcatastro();
		$SQL = 'DELETE FROM planos_parc_prov WHERE planos_prov_id = ' . $theId . ' AND plano_id = ' . $planoId;
		$db->query($SQL);
		$db->close();

	}


// -------------------------
//End Custom Code

//Close parcelas_origen_prov_ds_AfterExecuteDelete @331-4FBB6DA6
    return $parcelas_origen_prov_ds_AfterExecuteDelete;
}
//End Close parcelas_origen_prov_ds_AfterExecuteDelete

//parcelas_origen_prov_BeforeShow @331-AA5B33FF
function parcelas_origen_prov_BeforeShow(& $sender)
{
    $parcelas_origen_prov_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_origen_prov; //Compatibility
//End parcelas_origen_prov_BeforeShow

//Custom Code @390-2A29BDB7
// -------------------------


	/* Asigna el link con sus parámetros y el popup al enlace de
	   seleccionar nuevas parcelas (Origen prov.)
	-------------------------------------------------------------- */

	$newlnk = "#";
	$planoId = CCGetParam('plano_id');

	if( !empty( $planoId ) ) {

		// hago global el record para poder sacar el ID del depto.
		global $planos;
		$deptoId = $planos->ds->f('tipo_depto_parc_id');
		
		// crea el link/evento Javascript
		$lnk = "tc_addOrigen.php?dpto_id=" . $deptoId ."&plano_id=" . $planoId;
		$w = '700';
		$h = '600';
		$newlnk="$lnk\" onclick=\"javascript:window.open(this.href,'','width=$w,height=$h,top='+(screen.height-$h)/2+',left='+(screen.width-$w)/2+',scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=yes');return false;";

		$Component->SeleccionarParcela->SetLink($newlnk);
		$Component->SeleccionarParcela->Visible = true; 
	}



// -------------------------
//End Custom Code

//Close parcelas_origen_prov_BeforeShow @331-B8CA49AE
    return $parcelas_origen_prov_BeforeShow;
}
//End Close parcelas_origen_prov_BeforeShow

//parcelas_origen_prov_BeforeShowRow @331-1BC52A6C
function parcelas_origen_prov_BeforeShowRow(& $sender)
{
    $parcelas_origen_prov_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_origen_prov; //Compatibility
//End parcelas_origen_prov_BeforeShowRow

//Custom Code @393-2A29BDB7
// -------------------------


	$db = new clsDBtdf_nuevo();

	// obtenemos el ID de la parcela
	$parcela_id = $Component->parcela_id->GetValue('parcelas_parcela_id');


	/* Obtiene la plancheta
	-------------------------------------------------------------- */
	if ( !empty( $parcela_id ) ) {
		$plancheta = obtenerPlancheta( $parcela_id, $db, PLANCHETAS_PATH, 35 );
		$Component->htm->SetValue( $plancheta );
	}
	

	/* Calcula el Nro. de plano para mostrar en la fila
	-------------------------------------------------------------- */

	if ( !empty( $parcela_id ) ) {
		// busco los datos del plano
		$nro_plano = obtenerPlano( false, $parcela_id, false, $db );

		if ( !empty( $nro_plano ) ) {
			// si lo obtengo seteo el valor en el label
			$Component->plano->SetValue( $nro_plano );
		}
	}


	$db->close();


// -------------------------
//End Custom Code

//Close parcelas_origen_prov_BeforeShowRow @331-5B276066
    return $parcelas_origen_prov_BeforeShowRow;
}
//End Close parcelas_origen_prov_BeforeShowRow

//parcelas_destino_prov_parcelas1_TotalRecords_BeforeShow @87-C065F749
function parcelas_destino_prov_parcelas1_TotalRecords_BeforeShow(& $sender)
{
    $parcelas_destino_prov_parcelas1_TotalRecords_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_destino_prov; //Compatibility
//End parcelas_destino_prov_parcelas1_TotalRecords_BeforeShow

//Retrieve number of records @88-ABE656B4
    $Component->SetValue($Container->DataSource->RecordsCount);
//End Retrieve number of records

//Close parcelas_destino_prov_parcelas1_TotalRecords_BeforeShow @87-64135A9C
    return $parcelas_destino_prov_parcelas1_TotalRecords_BeforeShow;
}
//End Close parcelas_destino_prov_parcelas1_TotalRecords_BeforeShow

//parcelas_destino_prov_plano_BeforeShow @416-9DE339CE
function parcelas_destino_prov_plano_BeforeShow(& $sender)
{
    $parcelas_destino_prov_plano_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_destino_prov; //Compatibility
//End parcelas_destino_prov_plano_BeforeShow

//Custom Code @572-2A29BDB7
// -------------------------
    // Plano en fila		
	$db = new clsDBtdf_nuevo();
	$planoId = $_GET["plano_id"];
	$tmp_plano = CCDLookUp("tmp_plano","planos","plano_id = $planoId",$db);
	//echo $planoId;exit;
	if ( !empty( $planoId ) ) {
		$nro_plano = obtenerPlano( $planoId, false, false, $db );
	}

	$parcelas_destino_prov->plano->SetValue( $nro_plano );
	$db->close();
// -------------------------
//End Custom Code

//Close parcelas_destino_prov_plano_BeforeShow @416-3D650722
    return $parcelas_destino_prov_plano_BeforeShow;
}
//End Close parcelas_destino_prov_plano_BeforeShow

//parcelas_destino_prov_BeforeShowRow @86-3412D9C2
function parcelas_destino_prov_BeforeShowRow(& $sender)
{
    $parcelas_destino_prov_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_destino_prov; //Compatibility
//End parcelas_destino_prov_BeforeShowRow

//Set Row Style @105-982C9472
    $styles = array("Row", "AltRow");
    if (count($styles)) {
        $Style = $styles[($Component->RowNumber - 1) % count($styles)];
        if (strlen($Style) && !strpos($Style, "="))
            $Style = (strpos($Style, ":") ? 'style="' : 'class="'). $Style . '"';
        $Component->Attributes->SetValue("rowStyle", $Style);
    }
//End Set Row Style

//Custom Code @144-2A29BDB7
// -------------------------

	global $planos;

	$db = new clsDBtdf_nuevo();
	$planoEstado = $planos->ds->f('tipo_estado_plano_id'); //debug( $planoEstado );


	// obtenemos el ID de la parcela dependiendo de si se seleccionó o creó
	$parcela_id = $Component->ds->f('parcela_id');


	if ( !empty( $parcela_id ) ) {

		// si existe el ID de la parcela es que la parcela fue seleccionada

		// setea la fuente
		$Component->fuente->SetValue('Seleccionada');


		/* Obtiene la plancheta
		-------------------------------------------------------------- */
		$plancheta = obtenerPlancheta( $parcela_id, $db, PLANCHETAS_PATH, 35 );
		$Component->htm->SetValue( $plancheta );


		/* Calcula el Nro. de plano para mostrar en la fila
		-------------------------------------------------------------- */
		// busco los datos del plano
		$nro_plano = obtenerPlano( false, $parcela_id, false, $db );

		if ( !empty( $nro_plano ) ) {
			// si lo obtengo seteo el valor en el label
			$Component->plano->SetValue( $nro_plano );
		}

		/* Oculta  el botón de editar creadas, muestra el de quitar y editar seleccionadas
		------------------------------------------------------------------------------------ */
		// dependiendo del estado determina si se aplican las reglas de mostrar acciones
		if ( in_array( $planoEstado, array( 5 ) ) ) {
			$Component->ImageLink2->Visible = false;
			$Component->link_edit_exist->Visible = true;
			$Component->LinkRemove->Visible = true;
		} else {
			$Component->ImageLink2->Visible = false;
			$Component->link_edit_exist->Visible = false;
			$Component->LinkRemove->Visible = false;
		}


	} else {

		// si no existe el ID es una parcela creada manualmente (y prov.)

		// setea la fuente
		$Component->fuente->SetValue('Por crearse');

		// pongo en los labels los valores que en este caso vienen de la tabla provisoria
		$Component->parcela_seccion->SetValue( $Component->ds->f('planos_prov_seccion') );
		$Component->parcela_chacra->SetValue( $Component->ds->f('planos_prov_chacra') );
		$Component->parcela_quinta->SetValue( $Component->ds->f('planos_prov_quinta') );
		$Component->parcela_macizo->SetValue( $Component->ds->f('planos_prov_macizo') );
		$Component->parcela_fraccion->SetValue( $Component->ds->f('planos_prov_fraccion') );
		$Component->parcela_parcela->SetValue( $Component->ds->f('planos_prov_parcela') );
		$Component->parcela_uf->SetValue( $Component->ds->f('planos_prov_uf') );
		$Component->parcela_predio->SetValue( $Component->ds->f('planos_prov_predio') );
		$Component->parcela_rte->SetValue( $Component->ds->f('planos_prov_rte') );

		// no muestra nada para plano ni plancheta
		$Component->plano->SetValue('');
		$Component->htm->SetValue('');


		/* -- Oculta  el botón de quitar, muestra el de editar */
		// dependiendo del estado determina si se aplican las reglas de mostrar acciones
		if ( in_array( $planoEstado, array( 5 ) ) ) {
			$Component->ImageLink2->Visible = true;
			$Component->link_edit_exist->Visible = false;
			$Component->LinkRemove->Visible = true;
		} else {
			$Component->ImageLink2->Visible = false;
			$Component->link_edit_exist->Visible = false;
			$Component->LinkRemove->Visible = true;
		}


	}

	// Coloco superficie de la parcela, si no tiene coloco la superficie del plano
	if($parcelas_destino_prov->superficie->GetValue()){
		$parcelas_destino_prov->unidades_medidas_abrev->Visible = false;
		$parcelas_destino_prov->unidades_medidas_parcelas->Visible = true;
	}else{
		$superficie_plano = $parcelas_destino_prov->planos_prov_super_mensura->GetValue();
		$parcelas_destino_prov->superficie->SetValue($superficie_plano);
		$parcelas_destino_prov->unidades_medidas_abrev->Visible = true;
		$parcelas_destino_prov->unidades_medidas_parcelas->Visible = false;		
	}

	$db->close();


// -------------------------
//End Custom Code

//Close parcelas_destino_prov_BeforeShowRow @86-AB0F737A
    return $parcelas_destino_prov_BeforeShowRow;
}
//End Close parcelas_destino_prov_BeforeShowRow

//parcelas_destino_prov_BeforeShow @86-16C6BD93
function parcelas_destino_prov_BeforeShow(& $sender)
{
    $parcelas_destino_prov_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_destino_prov; //Compatibility
//End parcelas_destino_prov_BeforeShow

//Custom Code @241-2A29BDB7
// -------------------------

	global $planos;

	$db = new clsDBtdf_nuevo();

	$planoId = CCGetParam('plano_id');
	$planoEstado = $planos->ds->f('tipo_estado_plano_id'); //debug( $planoEstado );
  	$planoSVC = CCDLookUp('plano_svc', 'planos', 'plano_id = ' . $planoId, $db);
	$isPlanoSVC = ( !empty($planoSVC) ) ? true : false;


	/* Asigna el link con sus parámetros y el popup al enlace de
	   seleccionar nuevas parcelas (Destino prov.)
	-------------------------------------------------------------- */

	$newlnk = "#";

	if( !empty( $planoId ) ) {

		// hago global el record para poder sacar el ID del depto.
		global $planos;
		$deptoId = $planos->ds->f('tipo_depto_parc_id');
		
		// crea el link/evento Javascript
		$lnk = "tc_addDestino.php?dpto_id=" . $deptoId ."&plano_id=" . $planoId;
		$w = '700';
		$h = '600';
		$newlnk="$lnk\" onclick=\"javascript:window.open(this.href,'','width=$w,height=$h,top='+(screen.height-$h)/2+',left='+(screen.width-$w)/2+',scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=yes');return false;";

		$Component->SeleccionarParcela->SetLink($newlnk);

	}



	/* Determina si mostrar las opciones de seleccionar parcelas o agregar
	------------------------------------------------------------------------------ */
	$parSeleccionadas = planoProvSelec( $planoId, $db ); //debug( $parSeleccionadas );
	$parCreadas = planoProvCreadas( $planoId, $db ); //debug( $parCreadas );

	// dependiendo del estado determina si se aplican las reglas de mostrar acciones
	/* Ariel
	if ( in_array( $planoEstado, array( 5 ) ) ) {
		
		if ( $parSeleccionadas['cant'] > 0 && $parCreadas['cant'] <= 0 ) {
			// solo se pueden seleccionar
			$Component->SeleccionarParcela->Visible = true;
			$Component->ImageLink1->Visible = false;
		} else if ( $parCreadas['cant'] > 0 && $parSeleccionadas['cant'] <= 0 ) {
			// solo se pueden crear
			$Component->SeleccionarParcela->Visible = false;
			$Component->ImageLink1->Visible = true;
		} else if ( $parCreadas['cant'] > 0 && $parSeleccionadas['cant'] > 0 )  {
			// existen de los dos tipos, no se puede hacer nada hasta dejar de 1 solo tipo
			$Component->SeleccionarParcela->Visible = false;
			$Component->ImageLink1->Visible = false;
		} else {
			// nada agregado aún, se pueden seleccionar o crear
			$Component->SeleccionarParcela->Visible = true;
			$Component->ImageLink1->Visible = true;
		}
		

		// si es plano SVC NO muestra nunca la opción de seleccionar parcelas, sòlo permite crear
		if ( $isPlanoSVC ) {
			$Component->SeleccionarParcela->Visible = false;			
		}

	} else {
		$Component->SeleccionarParcela->Visible = false;
		$Component->ImageLink1->Visible = false;
	}*/

	$db->close();


// -------------------------
//End Custom Code

//Close parcelas_destino_prov_BeforeShow @86-A904F9F8
    return $parcelas_destino_prov_BeforeShow;
}
//End Close parcelas_destino_prov_BeforeShow

//parcelas_destino_parcelas1_TotalRecords_BeforeShow @438-918C80E7
function parcelas_destino_parcelas1_TotalRecords_BeforeShow(& $sender)
{
    $parcelas_destino_parcelas1_TotalRecords_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_destino; //Compatibility
//End parcelas_destino_parcelas1_TotalRecords_BeforeShow

//Retrieve number of records @439-ABE656B4
    $Component->SetValue($Container->DataSource->RecordsCount);
//End Retrieve number of records

//Close parcelas_destino_parcelas1_TotalRecords_BeforeShow @438-2FA34929
    return $parcelas_destino_parcelas1_TotalRecords_BeforeShow;
}
//End Close parcelas_destino_parcelas1_TotalRecords_BeforeShow

//parcelas_destino_BeforeShowRow @437-2A12CC57
function parcelas_destino_BeforeShowRow(& $sender)
{
    $parcelas_destino_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_destino; //Compatibility
//End parcelas_destino_BeforeShowRow

//Set Row Style @466-982C9472
    $styles = array("Row", "AltRow");
    if (count($styles)) {
        $Style = $styles[($Component->RowNumber - 1) % count($styles)];
        if (strlen($Style) && !strpos($Style, "="))
            $Style = (strpos($Style, ":") ? 'style="' : 'class="'). $Style . '"';
        $Component->Attributes->SetValue("rowStyle", $Style);
    }
//End Set Row Style

//Custom Code @467-2A29BDB7
// -------------------------

	global $planos;

	$db = new clsDBtdf_nuevo();
	$planoEstado = $planos->ds->f('tipo_estado_plano_id'); //debug( $planoEstado );
	$planoId = CCGetParam('plano_id');


	// obtenemos el ID de la parcela dependiendo de si se seleccionó o creó
	$parcela_id = $Component->ds->f('parcela_id');


	if ( !empty( $parcela_id ) ) {

		// si existe el ID de la parcela es que la parcela fue seleccionada

		/* Obtiene la plancheta
		-------------------------------------------------------------- */
		$plancheta = obtenerPlancheta( $parcela_id, $db, PLANCHETAS_PATH, 35 );
		$Component->htm->SetValue( $plancheta );


		/* Calcula el Nro. de plano para mostrar en la fila
		-------------------------------------------------------------- */
		$parcelaPlano = CCDLookUp('plano_id', 'uniones_desgloses', 'parcela_destino_id = ' . $parcela_id, $db );

		// busco los datos del plano
		if ( $parcelaPlano == $planoId ) {
			$Component->plano->SetValue( '(plano actual)' );
		} else {
			$nro_plano = obtenerPlano( false, $parcela_id, false, $db );
			if ( !empty( $nro_plano ) ) {
				// si lo obtengo seteo el valor en el label
				$Component->plano->SetValue( $nro_plano );
			}
		}

		/* Oculta  el botón de editar, muestra el de quitar
		-------------------------------------------------------------- */
		// dependiendo del estado determina si se aplican las reglas de mostrar acciones
		if ( in_array( $planoEstado, array( 5 ) ) ) {
			$Component->ImageLink2->Visible = false;
			$Component->LinkRemove->Visible = true;
		} else {
			$Component->ImageLink2->Visible = false;
			$Component->LinkRemove->Visible = false;
		}


	} else {

		// si no existe el ID es una parcela creada manualmente (y prov.)

		// setea la fuente
		$Component->fuente->SetValue('Por crearse');

		// pongo en los labels los valores que en este caso vienen de la tabla provisoria
		$Component->parcela_seccion->SetValue( $Component->ds->f('planos_prov_seccion') );
		$Component->parcela_chacra->SetValue( $Component->ds->f('planos_prov_chacra') );
		$Component->parcela_quinta->SetValue( $Component->ds->f('planos_prov_quinta') );
		$Component->parcela_macizo->SetValue( $Component->ds->f('planos_prov_macizo') );
		$Component->parcela_fraccion->SetValue( $Component->ds->f('planos_prov_fraccion') );
		$Component->parcela_parcela->SetValue( $Component->ds->f('planos_prov_parcela') );
		$Component->parcela_uf->SetValue( $Component->ds->f('planos_prov_uf') );
		$Component->parcela_predio->SetValue( $Component->ds->f('planos_prov_predio') );
		$Component->parcela_rte->SetValue( $Component->ds->f('planos_prov_rte') );

		// no muestra nada para plano ni plancheta
		$Component->plano->SetValue('');
		$Component->htm->SetValue('');


		/* -- Oculta  el botón de quitar, muestra el de editar */
		// dependiendo del estado determina si se aplican las reglas de mostrar acciones
		if ( in_array( $planoEstado, array( 5 ) ) ) {
			$Component->ImageLink2->Visible = true;
			$Component->LinkRemove->Visible = false;
		} else {
			$Component->ImageLink2->Visible = false;
			$Component->LinkRemove->Visible = false;
		}


	}


	$db->close();


// -------------------------
//End Custom Code

//Close parcelas_destino_BeforeShowRow @437-86F6F126
    return $parcelas_destino_BeforeShowRow;
}
//End Close parcelas_destino_BeforeShowRow

//parcelas_destino_BeforeShow @437-2D374F7B
function parcelas_destino_BeforeShow(& $sender)
{
    $parcelas_destino_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_destino; //Compatibility
//End parcelas_destino_BeforeShow

//Custom Code @468-2A29BDB7
// -------------------------



// -------------------------
//End Custom Code

//Close parcelas_destino_BeforeShow @437-524AAF8E
    return $parcelas_destino_BeforeShow;
}
//End Close parcelas_destino_BeforeShow

//parcelas_origen_parcelas1_TotalRecords_BeforeShow @542-7CF6EBA9
function parcelas_origen_parcelas1_TotalRecords_BeforeShow(& $sender)
{
    $parcelas_origen_parcelas1_TotalRecords_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_origen; //Compatibility
//End parcelas_origen_parcelas1_TotalRecords_BeforeShow

//Retrieve number of records @543-ABE656B4
    $Component->SetValue($Container->DataSource->RecordsCount);
//End Retrieve number of records

//Close parcelas_origen_parcelas1_TotalRecords_BeforeShow @542-991710B9
    return $parcelas_origen_parcelas1_TotalRecords_BeforeShow;
}
//End Close parcelas_origen_parcelas1_TotalRecords_BeforeShow

//parcelas_origen_BeforeShowRow @541-EB95A597
function parcelas_origen_BeforeShowRow(& $sender)
{
    $parcelas_origen_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_origen; //Compatibility
//End parcelas_origen_BeforeShowRow

//Set Row Style @558-982C9472
    $styles = array("Row", "AltRow");
    if (count($styles)) {
        $Style = $styles[($Component->RowNumber - 1) % count($styles)];
        if (strlen($Style) && !strpos($Style, "="))
            $Style = (strpos($Style, ":") ? 'style="' : 'class="'). $Style . '"';
        $Component->Attributes->SetValue("rowStyle", $Style);
    }
//End Set Row Style

//Custom Code @559-2A29BDB7
// -------------------------

	global $planos;

	$db = new clsDBtdf_nuevo();
	$planoEstado = $planos->ds->f('tipo_estado_plano_id'); //debug( $planoEstado );
	$planoId = CCGetParam('plano_id');


	// obtenemos el ID de la parcela dependiendo de si se seleccionó o creó
	$parcela_id = $Component->ds->f('parcela_id');


	if ( !empty( $parcela_id ) ) {

		// si existe el ID de la parcela es que la parcela fue seleccionada

		/* Obtiene la plancheta
		-------------------------------------------------------------- */
		$plancheta = obtenerPlancheta( $parcela_id, $db, PLANCHETAS_PATH, 35 );
		$Component->htm->SetValue( $plancheta );


		/* Calcula el Nro. de plano para mostrar en la fila
		-------------------------------------------------------------- */
		$parcelaPlano = CCDLookUp('plano_id', 'uniones_desgloses', 'parcela_destino_id = ' . $parcela_id, $db );

		// busco los datos del plano
		if ( $parcelaPlano == $planoId ) {
			$Component->plano->SetValue( '(plano actual)' );
		} else {
			$nro_plano = obtenerPlano( false, $parcela_id, false, $db );
			if ( !empty( $nro_plano ) ) {
				// si lo obtengo seteo el valor en el label
				$Component->plano->SetValue( $nro_plano );
			}
		}

		/* Oculta  el botón de editar, muestra el de quitar
		-------------------------------------------------------------- */
		// dependiendo del estado determina si se aplican las reglas de mostrar acciones
		if ( in_array( $planoEstado, array( 5 ) ) ) {
			$Component->ImageLink2->Visible = false;
			$Component->LinkRemove->Visible = true;
		} else {
			$Component->ImageLink2->Visible = false;
			$Component->LinkRemove->Visible = false;
		}


	} else {

		// si no existe el ID es una parcela creada manualmente (y prov.)

		// setea la fuente
		$Component->fuente->SetValue('Por crearse');

		// pongo en los labels los valores que en este caso vienen de la tabla provisoria
		$Component->parcela_seccion->SetValue( $Component->ds->f('planos_prov_seccion') );
		$Component->parcela_chacra->SetValue( $Component->ds->f('planos_prov_chacra') );
		$Component->parcela_quinta->SetValue( $Component->ds->f('planos_prov_quinta') );
		$Component->parcela_macizo->SetValue( $Component->ds->f('planos_prov_macizo') );
		$Component->parcela_fraccion->SetValue( $Component->ds->f('planos_prov_fraccion') );
		$Component->parcela_parcela->SetValue( $Component->ds->f('planos_prov_parcela') );
		$Component->parcela_uf->SetValue( $Component->ds->f('planos_prov_uf') );
		$Component->parcela_predio->SetValue( $Component->ds->f('planos_prov_predio') );
		$Component->parcela_rte->SetValue( $Component->ds->f('planos_prov_rte') );

		// no muestra nada para plano ni plancheta
		$Component->plano->SetValue('');
		$Component->htm->SetValue('');


		/* -- Oculta  el botón de quitar, muestra el de editar */
		// dependiendo del estado determina si se aplican las reglas de mostrar acciones
		if ( in_array( $planoEstado, array( 5 ) ) ) {
			$Component->ImageLink2->Visible = true;
			$Component->LinkRemove->Visible = false;
		} else {
			$Component->ImageLink2->Visible = false;
			$Component->LinkRemove->Visible = false;
		}


	}


	$db->close();


// -------------------------
//End Custom Code

//Close parcelas_origen_BeforeShowRow @541-8769B310
    return $parcelas_origen_BeforeShowRow;
}
//End Close parcelas_origen_BeforeShowRow

//parcelas_origen_BeforeShow @541-2233897E
function parcelas_origen_BeforeShow(& $sender)
{
    $parcelas_origen_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_origen; //Compatibility
//End parcelas_origen_BeforeShow

//Custom Code @560-2A29BDB7
// -------------------------



// -------------------------
//End Custom Code

//Close parcelas_origen_BeforeShow @541-97433365
    return $parcelas_origen_BeforeShow;
}
//End Close parcelas_origen_BeforeShow

//Page_BeforeShow @1-1911D1D5
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tc_planosRecord; //Compatibility
//End Page_BeforeShow

//Custom Code @210-2A29BDB7
// -------------------------

	$db = new clsDBtdf_nuevo();
	$perfil_id = CCGetSession("perfil_id");
	$paramPlanoId = CCGetParam('plano_id', false);

	/* Determina visibilidad de componentes al cargar la página
	-------------------------------------------------------------- */

	

	$Component->planos->Button_desarchivar->Visible = FALSE;
	$Component->planos->baja_pura->Visible = false;

	// si no existe el ID (modo insert)
	if( empty( $paramPlanoId ) ) {

		// no mostrar listado de parcelas origen ni destino prov
		$Component->parcelas_origen_prov->Visible = false;
		$Component->parcelas_destino_prov->Visible = false;

		// no mostrar listado de parcelas origen ni destino definitivas
		$Component->parcelas_origen->Visible = false;
		$Component->parcelas_destino->Visible = false;

		// mostrar botones: crear y volver
		$Component->planos->Button_Archivar->Visible = false;
		$Component->planos->Button_Anular->Visible = false;
		$Component->planos->Button_Suspender->Visible = false;
		$Component->planos->Button_Registrar->Visible = false;
		$Component->planos->Button_Vigencia->Visible = false;
		$Component->planos->Button_Editar->Visible = false;


	// si existe el ID (modo edit)
	} else {

		/* De acuerdo al estado mostrar los distintos grids y botones */

		// obtiene el estado actual del plano, si es SVC y si está en edición
		$estadoPlano = CCDLookUp('tipo_estado_plano_id', 'planos', 'plano_id = ' . $paramPlanoId, $db); #debug( $estadoPlano );

		$planoSVC = CCDLookUp('plano_svc', 'planos', 'plano_id = ' . $paramPlanoId, $db);
		$isPlanoSVC = ( !empty($planoSVC) ) ? true : false;

		$planoEdicion = CCDLookUp('plano_en_edicion', 'planos', 'plano_id = ' . $paramPlanoId, $db);
		$isPlanoEdicion = ( !empty($planoEdicion) ) ? true : false;

		switch( $estadoPlano ) :
			
			// Si está "En Trámite" (id = 5)
			case 5:

				// PO provisorias
				$Component->parcelas_origen_prov->Visible = true;
				$Component->parcelas_origen_prov->DeleteAllowed  = true;

				// PO definitivas
				$Component->parcelas_origen->Visible = false;

				// PD provisorias
				$Component->parcelas_destino_prov->Visible = true;

				// PD definitivas
				$Component->parcelas_destino->Visible = false;

				// Planos
				$Component->planos->Button_Archivar->Visible = ($isPlanoEdicion) ? false: true;
				$Component->planos->Button_Anular->Visible = false;
				$Component->planos->Button_Suspender->Visible = false;
				$Component->planos->Button_Registrar->Visible = ($isPlanoEdicion) ? false: true;
				$Component->planos->Button_Vigencia->Visible = false;
				if($perfil_id == 1){
					$Component->planos->Button_Editar->Visible = false;
					$Component->planos->baja_pura->Visible = true;
				}else{
					$Component->planos->Button_Editar->Visible = false;
				}
				$Component->planos->UpdateAllowed = ($isPlanoEdicion) ? false: true;
				$Component->planos->DeleteAllowed = false;

				//---Ariel 15/02/2016---
				$Component->planos->Button_Insert->Visible = false;
				$Component->planos->Button_desarchivar->Visible = false;
				//---Ariel 15/02/2016---

				break;


			// Si está "Archivado" (id = 6)
			case 6:

				// PO provisorias
				$Component->parcelas_origen_prov->Visible = false;
				$Component->parcelas_origen_prov->DeleteAllowed  = false;
				$Component->parcelas_origen_prov->SeleccionarParcela->Visible = false;

				// PO definitivas
				$Component->parcelas_origen->Visible = true;

				// PD provisorias
				$Component->parcelas_destino_prov->Visible = false;
				$Component->parcelas_destino_prov->SeleccionarParcela->Visible = false;
				$Component->parcelas_destino_prov->ImageLink1->Visible = false;
				$Component->parcelas_destino_prov->ImageLink2->Visible = false;
				$Component->parcelas_destino_prov->LinkRemove->Visible = false;

				// PD definitivas
				$Component->parcelas_destino->Visible = true;

				// Planos
				$Component->planos->Button_Archivar->Visible = false;
				$Component->planos->Button_Anular->Visible = false;
				$Component->planos->Button_Suspender->Visible = false;
				$Component->planos->Button_Registrar->Visible = false;
				$Component->planos->Button_Vigencia->Visible = false;
				if($perfil_id == 1){
					$Component->planos->Button_Editar->Visible = true;
					$Component->planos->baja_pura->Visible = true;
				}else{
					$Component->planos->Button_Editar->Visible = false;
				}

				$Component->planos->UpdateAllowed = false;
				$Component->planos->DeleteAllowed = false;

				//---Ariel 15/02/2016---
				$Component->planos->Button_Insert->Visible = false;
				$Component->planos->Button_desarchivar->Visible = true;
				//---Ariel 15/02/2016---

				break;


			// Si está "Registrado" (id = 4)
			case 4:

				// PO provisorias
				$Component->parcelas_origen_prov->Visible = false;
				$Component->parcelas_origen_prov->DeleteAllowed  = false;
				$Component->parcelas_origen_prov->SeleccionarParcela->Visible = false;

				// PO definitivas
				$Component->parcelas_origen->Visible = true;

				// PD provisorias
				$Component->parcelas_destino_prov->Visible = false;
				$Component->parcelas_destino_prov->SeleccionarParcela->Visible = false;
				$Component->parcelas_destino_prov->ImageLink1->Visible = false;
				$Component->parcelas_destino_prov->ImageLink2->Visible = false;
				$Component->parcelas_destino_prov->LinkRemove->Visible = false;

				// PD definitivas
				$Component->parcelas_destino->Visible = true;

				// Planos
				$Component->planos->Button_Archivar->Visible = false;
				$Component->planos->Button_Anular->Visible = ($isPlanoEdicion) ? false: true;
				$Component->planos->Button_Suspender->Visible = ($isPlanoEdicion) ? false: true;
				$Component->planos->Button_Registrar->Visible = false;
				if ( !$isPlanoSVC ) $Component->planos->Button_Vigencia->Visible = false;
				$Component->planos->Button_Editar->Visible = true;
				if($perfil_id == 1){
					$Component->planos->baja_pura->Visible = true;
				}

				$Component->planos->UpdateAllowed = false;
				$Component->planos->DeleteAllowed = false;

				//---Ariel 15/02/2016---
				$Component->planos->Button_Insert->Visible = false;
				$Component->planos->Button_desarchivar->Visible = false;
				//---Ariel 15/02/2016---
				break;


			// Si está "Anulado" (id = 1)
			case 1:
				// PO provisorias
				$Component->parcelas_origen_prov->Visible = false;
				$Component->parcelas_origen_prov->DeleteAllowed  = false;
				$Component->parcelas_origen_prov->SeleccionarParcela->Visible = false;

				// PO definitivas
				$Component->parcelas_origen->Visible = true;

				// PD provisorias
				$Component->parcelas_destino_prov->Visible = false;
				$Component->parcelas_destino_prov->SeleccionarParcela->Visible = false;
				$Component->parcelas_destino_prov->ImageLink1->Visible = false;
				$Component->parcelas_destino_prov->ImageLink2->Visible = false;
				$Component->parcelas_destino_prov->LinkRemove->Visible = false;

				// PD definitivas
				$Component->parcelas_destino->Visible = true;

				// Planos
				$Component->planos->Button_Archivar->Visible = false;
				$Component->planos->Button_Anular->Visible = false;
				$Component->planos->Button_Suspender->Visible = false;
				$Component->planos->Button_Registrar->Visible = false;
				$Component->planos->Button_Vigencia->Visible = false;
				if($perfil_id == 1){
					$Component->planos->Button_Editar->Visible = true;
					$Component->planos->baja_pura->Visible = true;
				}else{
					$Component->planos->Button_Editar->Visible = false;
				}

				$Component->planos->UpdateAllowed = false;
				$Component->planos->DeleteAllowed = false;

				//---Ariel 15/02/2016---
				$Component->planos->Button_Insert->Visible = false;
				$Component->planos->Button_desarchivar->Visible = false;
				//---Ariel 15/02/2016---
				break;


			// Si está "Suspendido" (id = 8)
			case 8:
				// PO provisorias
				$Component->parcelas_origen_prov->Visible = false;
				$Component->parcelas_origen_prov->DeleteAllowed  = false;
				$Component->parcelas_origen_prov->SeleccionarParcela->Visible = false;

				// PO definitivas
				$Component->parcelas_origen->Visible = true;

				// PD provisorias
				$Component->parcelas_destino_prov->Visible = false;
				$Component->parcelas_destino_prov->SeleccionarParcela->Visible = false;
				$Component->parcelas_destino_prov->ImageLink1->Visible = false;
				$Component->parcelas_destino_prov->ImageLink2->Visible = false;
				$Component->parcelas_destino_prov->LinkRemove->Visible = false;

				// PD definitivas
				$Component->parcelas_destino->Visible = true;

				// Planos
				$Component->planos->Button_Archivar->Visible = false;
				$Component->planos->Button_Anular->Visible = false;
				$Component->planos->Button_Suspender->Visible = false;
				$Component->planos->Button_Registrar->Visible = false;
				$Component->planos->Button_Vigencia->Visible = false;
				if($perfil_id == 1){
					$Component->planos->Button_Editar->Visible = true;
					$Component->planos->baja_pura->Visible = true;
				}else{
					$Component->planos->Button_Editar->Visible = false;
				}

				$Component->planos->UpdateAllowed = false;
				$Component->planos->DeleteAllowed = false;

				//---Ariel 15/02/2016---
				$Component->planos->Button_Insert->Visible = false;
				$Component->planos->Button_desarchivar->Visible = false;
				//---Ariel 15/02/2016---
				break;

			default:
				// PO provisorias
				$Component->parcelas_origen_prov->Visible = false;
				$Component->parcelas_origen_prov->DeleteAllowed  = false;
				$Component->parcelas_origen_prov->SeleccionarParcela->Visible = false;

				// PO definitivas
				$Component->parcelas_origen->Visible = true;

				// PD provisorias
				$Component->parcelas_destino_prov->Visible = false;
				$Component->parcelas_destino_prov->SeleccionarParcela->Visible = false;
				$Component->parcelas_destino_prov->ImageLink1->Visible = false;
				$Component->parcelas_destino_prov->ImageLink2->Visible = false;
				$Component->parcelas_destino_prov->LinkRemove->Visible = false;

				// PD definitivas
				$Component->parcelas_destino->Visible = true;

				// Planos
				$Component->planos->Button_Archivar->Visible = false;
				$Component->planos->Button_Anular->Visible = false;
				$Component->planos->Button_Suspender->Visible = false;
				$Component->planos->Button_Registrar->Visible = false;
				$Component->planos->Button_Vigencia->Visible = false;
				if($perfil_id == 1){
					$Component->planos->Button_Editar->Visible = true;
					$Component->planos->baja_pura->Visible = true;
				}else{
					$Component->planos->Button_Editar->Visible = false;
				}

				$Component->planos->UpdateAllowed = false;
				$Component->planos->DeleteAllowed = false;
				break;

		endswitch;


	}


// -------------------------
//End Custom Code

//Close Page_BeforeShow @1-4BC230CD
    return $Page_BeforeShow;
}
//End Close Page_BeforeShow

//Page_BeforeInitialize @1-2DAF9CE1
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tc_planosRecord; //Compatibility
//End Page_BeforeInitialize

//Custom Code @304-2A29BDB7
// -------------------------

	// Incluye el archivo de funciones generales
	include_once(RelativePath . "/scripts/myFunctions.php");

    // Incluye la gestión de permisos
	include_once(RelativePath . "/scripts/permisos1.php");

// -------------------------
//End Custom Code

//PTAutoFill1 Initialization @140-519D9FC2
    if ('planosplano_anioPTAutoFill1' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new JsonFormatter());
//End PTAutoFill1 Initialization

//PTAutoFill1 DataSource @140-B7FCB7B8
        $Service->DataSource = new clsDBcatastro();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM planos {SQL_Where} {SQL_OrderBy}";
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End PTAutoFill1 DataSource

//PTAutoFill1 DataFields @140-5E2C9B65
        $Service->AddDataSourceField('cant',ccsInteger,"");
//End PTAutoFill1 DataFields

//PTAutoFill1 Execution @140-028A6C4C
        echo $Service->Execute();
//End PTAutoFill1 Execution

//PTAutoFill1 Loading @140-27890EF8
        exit;
    }
//End PTAutoFill1 Loading

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>