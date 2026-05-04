<?php
//BindEvents Method @1-6116BE30
function BindEvents()
{
    global $planos_detalle;
    global $parcelas_destino_sel;
    global $parcelas_destino_creadas;
    global $EditableGrid1;
    global $results_message;
    global $CCSEvents;
    $planos_detalle->plano_sin_origen->CCSEvents["BeforeShow"] = "planos_detalle_plano_sin_origen_BeforeShow";
    $planos_detalle->plano_svc->CCSEvents["BeforeShow"] = "planos_detalle_plano_svc_BeforeShow";
    $parcelas_destino_sel->CCSEvents["BeforeShow"] = "parcelas_destino_sel_BeforeShow";
    $parcelas_destino_creadas->CCSEvents["BeforeShow"] = "parcelas_destino_creadas_BeforeShow";
    $EditableGrid1->parcelas_destinos_sel->CCSEvents["BeforeShow"] = "EditableGrid1_parcelas_destinos_sel_BeforeShow";
    $EditableGrid1->parcelas_destino_creadas->CCSEvents["BeforeShow"] = "EditableGrid1_parcelas_destino_creadas_BeforeShow";
    $EditableGrid1->Button_Registrar->CCSEvents["OnClick"] = "EditableGrid1_Button_Registrar_OnClick";
    $EditableGrid1->CCSEvents["BeforeShow"] = "EditableGrid1_BeforeShow";
    $EditableGrid1->CCSEvents["OnValidate"] = "EditableGrid1_OnValidate";
    $results_message->CCSEvents["BeforeShow"] = "results_message_BeforeShow";
}
//End BindEvents Method

//planos_detalle_plano_sin_origen_BeforeShow @391-A0FC2F15
function planos_detalle_plano_sin_origen_BeforeShow(& $sender)
{
    $planos_detalle_plano_sin_origen_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planos_detalle; //Compatibility
//End planos_detalle_plano_sin_origen_BeforeShow

//Custom Code @393-2A29BDB7
// -------------------------

    /* Muestra el texto en el label en base al valor que tiene
  --------------------------------------------------------------------- */
  if ( $Component->GetValue() == 1 ) {
    $Component->SetValue('Si');
  } else if ( $Component->GetValue() == 2 ) {
    $Component->SetValue('No');
  } else {
    $Component->SetValue('');
  }


// -------------------------
//End Custom Code

//Close planos_detalle_plano_sin_origen_BeforeShow @391-A245B5DB
    return $planos_detalle_plano_sin_origen_BeforeShow;
}
//End Close planos_detalle_plano_sin_origen_BeforeShow

//planos_detalle_plano_svc_BeforeShow @392-C8BAF760
function planos_detalle_plano_svc_BeforeShow(& $sender)
{
    $planos_detalle_plano_svc_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planos_detalle; //Compatibility
//End planos_detalle_plano_svc_BeforeShow

//Custom Code @394-2A29BDB7
// -------------------------

    /* Muestra el texto en el label en base al valor que tiene
  --------------------------------------------------------------------- */
  if ( $Component->GetValue() == 1 ) {
    $Component->SetValue('Si');
  } else if ( $Component->GetValue() == 0 ) {
    $Component->SetValue('No');
  } else {
    $Component->SetValue('');
  }

// -------------------------
//End Custom Code

//Close planos_detalle_plano_svc_BeforeShow @392-8A256D7A
    return $planos_detalle_plano_svc_BeforeShow;
}
//End Close planos_detalle_plano_svc_BeforeShow

//parcelas_destino_sel_BeforeShow @215-6ACAFAB1
function parcelas_destino_sel_BeforeShow(& $sender)
{
    $parcelas_destino_sel_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_destino_sel; //Compatibility
//End parcelas_destino_sel_BeforeShow

//Custom Code @258-2A29BDB7
// -------------------------


    /* Si no tiene registros no muestra el listado
  ------------------------------------------------------------------------- */
  if ( $Component->DataSource->RecordsCount == 0 ) {
    $Component->Visible = false;
  }


// -------------------------
//End Custom Code

//Close parcelas_destino_sel_BeforeShow @215-7E1C2588
    return $parcelas_destino_sel_BeforeShow;
}
//End Close parcelas_destino_sel_BeforeShow

//parcelas_destino_creadas_BeforeShow @259-40211F5C
function parcelas_destino_creadas_BeforeShow(& $sender)
{
    $parcelas_destino_creadas_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_destino_creadas; //Compatibility
//End parcelas_destino_creadas_BeforeShow

//Custom Code @272-2A29BDB7
// -------------------------


    /* Si no tiene registros no muestra el listado
  ------------------------------------------------------------------------- */
  if ( $Component->DataSource->RecordsCount == 0 ) {
    $Component->Visible = false;
  }
  


// -------------------------
//End Custom Code

//Close parcelas_destino_creadas_BeforeShow @259-F10709B9
    return $parcelas_destino_creadas_BeforeShow;
}
//End Close parcelas_destino_creadas_BeforeShow

//EditableGrid1_parcelas_destinos_sel_BeforeShow @359-11D562B5
function EditableGrid1_parcelas_destinos_sel_BeforeShow(& $sender)
{
    $EditableGrid1_parcelas_destinos_sel_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $EditableGrid1; //Compatibility
//End EditableGrid1_parcelas_destinos_sel_BeforeShow

//Custom Code @380-2A29BDB7
// -------------------------

  /* Oculta el selectbox si no hay opciones para mostrar...
  ------------------------------------------------------------ */

  if ( empty( $Component->Values ) ) {
    $Component->Visible = false;
  }


// -------------------------
//End Custom Code

//Close EditableGrid1_parcelas_destinos_sel_BeforeShow @359-A2A0E908
    return $EditableGrid1_parcelas_destinos_sel_BeforeShow;
}
//End Close EditableGrid1_parcelas_destinos_sel_BeforeShow

//EditableGrid1_parcelas_destino_creadas_BeforeShow @365-ECA6C272
function EditableGrid1_parcelas_destino_creadas_BeforeShow(& $sender)
{
    $EditableGrid1_parcelas_destino_creadas_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $EditableGrid1; //Compatibility
//End EditableGrid1_parcelas_destino_creadas_BeforeShow

//Custom Code @381-2A29BDB7
// -------------------------


  /* Oculta el selectbox si no hay opciones para mostrar...
  ------------------------------------------------------------ */

  if ( empty( $Component->Values ) ) {
    $Component->Visible = false;
  }


// -------------------------
//End Custom Code

//Close EditableGrid1_parcelas_destino_creadas_BeforeShow @365-F900040E
    return $EditableGrid1_parcelas_destino_creadas_BeforeShow;
}
//End Close EditableGrid1_parcelas_destino_creadas_BeforeShow

//EditableGrid1_Button_Registrar_OnClick @382-DCCC441D
function EditableGrid1_Button_Registrar_OnClick(& $sender)
{
    $EditableGrid1_Button_Registrar_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $EditableGrid1; //Compatibility
//End EditableGrid1_Button_Registrar_OnClick

//Custom Code @383-2A29BDB7
// -------------------------

  $db = new clsDBtdf_nuevo();

  // muestra en la pantalla salidas para depuración
  $debugMode = false;

  // obtengo parámetros necesarios
  $planoId = CCGetParam('plano_id');
  $planoData = CCQueryToArray( 'SELECT * FROM planos WHERE plano_id = ' . mysql_real_escape_string( $planoId ) . ';', $db );
  if ($debugMode) debug('Datos del plano');
  if ($debugMode) debug($planoData);

  $isPlanoSVC = ( empty($planoData[0]['plano_svc']) ) ? false : true;
  $isSinOrig = ( $planoData[0]['plano_sin_origen'] == 1 ) ? true : false;
  $isServidumbre = ( $planoData[0]['tipo_plano_id'] == 1 ) ? true : false;
  $notRegistered = ( $planoData[0]['tipo_estado_plano_id'] != 4 ) ? true : false;
  $isTramiteMig = ( $planoData[0]['plano_tramite_mig'] == 1 ) ? true : false;
  if ($debugMode) debug('Es plano en trámite migrado con parcelas en trámite:');
  if ($debugMode) debug($isTramiteMig);


  /* Proceso de registro del plano
  ------------------------------------------------------------------------- */

  // si no hay ID de plano no se hace nada
  if ( !empty( $planoId ) && !empty( $planoData ) && $notRegistered ) {

    /* -- Validaciones generales */

    // Validar que hayan parcelas de origen
    $countParcOrig = planoProvOrigen( $planoId, $db );
    if ($debugMode) debug( 'countParcOrig:' );
    if ($debugMode) debug( $countParcOrig );


    if ( $countParcOrig['cant'] < 1 && ( $isSinOrig != true ) ) {
      $errors[] = 'No hay parcelas de Origen seleccionadas para registrar el plano.';
      if ($debugMode) debug('error');
    }


    // Validar que hayan parcelas de destino y que sean de 1 solo tipo (creadas o seleccionadas)
    $countParcSel = planoProvSelec( $planoId, $db );
    if ($debugMode) debug( 'countParcSel:' );
    if ($debugMode) debug( $countParcSel );

    $countParcCreadas = planoProvCreadas( $planoId, $db );
    if ($debugMode) debug( 'countParcCreadas:' );
    if ($debugMode) debug( $countParcCreadas );

	//Modif 02/12
    //if ( $countParcSel['cant'] > 0 && $countParcCreadas['cant'] > 0 ) {      
	//  $errors[] = 'El plano no se puede registrar porque posee parcelas a Crear y Seleccionadas simultáneamente.';
    //}

	// Si el plano no es del tipo "servidumbre" valida que tiene parcelas de destino y lo contrario si no es
	if ( !$isServidumbre && ( empty($countParcSel['cant']) && empty($countParcCreadas['cant']) ) ) {
		$errors[] = 'El plano NO es del tipo servidumbre y no tiene Parcelas de Destino asignadas. De no ser un plano de Servidumbre debe asignar Parcelas de Destino al plano.';
	} else if ( $isServidumbre && ( $countParcSel['cant'] > 0 || $countParcCreadas['cant'] > 0 ) ) {
		$errors[] = 'El plano es del tipo Servidumbre y tiene Parcelas de Destino asignadas. Por favor desvincúlelas y proceda nuevamente al registro.';
	}


    // Validar si las parcelas todas pertenecen al mismo depto
    // TODO: es necesario validar esto?



    /* -- Si no se han registrado errores en las primeras condiciones ejecuta el proceso */

    if ( empty( $errors ) ) {

      // trae las partidas de origen
      $parcelasOrigenQuery = 'SELECT parcelas.*
        FROM planos_parc_prov
        INNER JOIN parcelas ON parcelas.parcela_id = planos_parc_prov.parcela_id
        WHERE plano_id = ' . mysql_real_escape_string( $planoId ) . ' AND planos_parc_prov_tipo = "origen" AND planos_parc_prov.tipo_estado_id = 1;';
      $parcelasOrigen = CCQueryToArray( $parcelasOrigenQuery, $db );
      if ($debugMode) debug('Traer PO:');
      if ($debugMode) debug($parcelasOrigenQuery);
      if ($debugMode) debug($parcelasOrigen);


      /* -- Procesa de acuerdo a si son seleccionadas o a crear */
      if ( !empty( $countParcSel['cant'] ) ) {

        /* -- Parcelas seleccionadas */
        if ($debugMode) debug('Tipo de PD: seleccionadas');

        // trae las parcelas de destino
        $parcelasDestinoQuery = '
          SELECT parcelas.*
          FROM planos_parc_prov
          INNER JOIN parcelas ON parcelas.parcela_id = planos_parc_prov.parcela_id
          WHERE planos_parc_prov.plano_id = ' . mysql_real_escape_string( $planoId ) . ' AND planos_parc_prov.planos_parc_prov_tipo = "destino" AND ( planos_parc_prov.parcela_id IS NOT NULL AND planos_parc_prov.parcela_id <> "" );';
        $parcelasDestino = CCQueryToArray( $parcelasDestinoQuery, $db);
        if ($debugMode) debug('PD (seleccionadas de existentes) encontradas:');
        if ($debugMode) debug($parcelasDestinoQuery);
        if ($debugMode) debug($parcelasDestino);

        // determina si es unión o división
        if ( count($parcelasOrigen) > count($parcelasDestino) ) {
          $tipoOperacion = 1; # union
        } else if( count($parcelasOrigen) < count($parcelasDestino) )  {
          $tipoOperacion = 2; # división
        } else {
          $tipoOperacion = 1; # mismo número de destino y origen
        }

        // va recorriendo las parcelas e insertando su relación
        foreach( $parcelasDestino as $parcelaDest ) {

          // si no es un plano que tiene que tener PO ...
          if ( !$isSinOrig ) {

            if ($debugMode) debug('Es plano con orígen catastral:');

            foreach( $parcelasOrigen as $parcelaOrig ) {
              // inserta la relación
              $SQL = 'INSERT INTO uniones_desgloses SET
                parcela_id  = ' . $parcelaOrig['parcela_id'] . ',
                parcela_destino_id = ' . $parcelaDest['parcela_id'] . ',
                tipo_union_desglose_id = ' . $tipoOperacion . ',
                plano_id = ' . $planoId . ',
                usuario_id = ' . CCGetSession('UID') . ', union_desglose_fecha = NOW();';
              if ($debugMode) debug($SQL);

              if (!$debugMode) $db->query( $SQL );
            }
          } else {
            // en este caso se inserta la relacíón directa con el plano sin parcela origen
            if ($debugMode) debug('Es plano sin orígen catastral / tierras fiscales sin mensurar');

            // inserta la relación
            $SQL = 'INSERT INTO uniones_desgloses SET
              parcela_destino_id = ' . $parcelaDest['parcela_id'] . ',
              tipo_union_desglose_id = ' . $tipoOperacion . ',
              plano_id = ' . $planoId . ',
              usuario_id = ' . CCGetSession('UID') . ', union_desglose_fecha = NOW();';
            if ($debugMode) debug($SQL);
            if (!$debugMode) $db->query( $SQL );
          }

          // actualiza el Nro. de partida si no lo tiene asignado
          if ( empty( $parcelaDest['parcela_partida'] ) ) {
            if ($debugMode) debug('la parcela no tiene asignado Partida, se asignará:');


            // Determina siguiente número de partida
			// NOTE: se agrega el 20131205 la verificación de SVC para las parc. seleccionadas
			if ( !$isPlanoSVC ) {
		        $ultimaPartida = getUltimaPartida( $db );
		        $ultimaPartida++;
				$sqlActEstado = '';
			} else {
		        $ultimaPartida = 0;
				$sqlActEstado = ', tipo_est_parc_id = 3';
			}

            $SQL = 'UPDATE parcelas SET parcela_partida = ' . $ultimaPartida . $sqlActEstado . ' WHERE parcela_id = ' . $parcelaDest['parcela_id'];

            if ($debugMode) debug($SQL);
            if (!$debugMode) $db->query( $SQL );
          }

          // si es plano en trámite con problemas de migración cambia el estado de la parcela en trámite a activa
          //if ( $isTramiteMig && $parcelaDest['tipo_est_parc_id'] == 3 ) {
              $SQL = '
                UPDATE parcelas SET
                tipo_est_parc_id  = 1
                WHERE parcela_id = ' . $parcelaDest['parcela_id'];
              if ($debugMode) debug('Pasa la parcela en trámite a activa:');
              if ($debugMode) debug($SQL);

              if (!$debugMode) $db->query( $SQL );
          //}

        }


        // Asignación de mejoras seleccionadas
        $datosMejoras = $Container->FormParameters;
        foreach( $datosMejoras['parcelas_destinos_sel'] as $key => $data ) {
          if ( !empty( $data ) ) {
            // recupera datos necesarios
            $mejoraParcelaId = CCDLookUp( 'parcela_id', 'planos_parc_prov', 'planos_prov_id = ' . mysql_real_escape_string( $data ), $db);
            $mejora = CCQueryToArray( 'SELECT * FROM mejoras WHERE mejora_id = ' . mysql_real_escape_string( $datosMejoras['mejora_id'][$key] ), $db );

            if ($debugMode) debug('Mejoras encontradas:');
            if ($debugMode) debug($mejora);

            // inserta la mejora en la parcela correspondiente
            $SQL  = 'INSERT INTO mejoras SET ';
            $SQL .= 'parcela_id = ' . mysql_real_escape_string( $mejoraParcelaId );
            $SQL .= ( !empty( $mejora[0]['tipo_mejora_id'] ) ) ? ', tipo_mejora_id = ' . mysql_real_escape_string( $mejora[0]['tipo_mejora_id'] ) : '';
            $SQL .= ( !empty( $mejora[0]['tipo_mejora_estado_id'] ) ) ? ', tipo_mejora_estado_id = ' . mysql_real_escape_string( $mejora[0]['tipo_mejora_estado_id'] ): '';
            $SQL .= ( !empty( $mejora[0]['tipo_mejora_destino_id'] ) ) ? ', tipo_mejora_destino_id = ' . mysql_real_escape_string( $mejora[0]['tipo_mejora_destino_id'] ): '';
            $SQL .= ( !empty( $mejora[0]['tipo_mejora_conserva_id'] ) ) ? ', tipo_mejora_conserva_id = ' . mysql_real_escape_string( $mejora[0]['tipo_mejora_conserva_id'] ): '';
            $SQL .= ( !empty( $mejora[0]['tipo_mejora_conserva_2_id'] ) ) ? ', tipo_mejora_conserva_2_id = ' . mysql_real_escape_string( $mejora[0]['tipo_mejora_conserva_2_id'] ) : '';
            $SQL .= ( !empty( $mejora[0]['tipo_mejora_conserva_3_id'] ) ) ? ', tipo_mejora_conserva_3_id = ' . mysql_real_escape_string( $mejora[0]['tipo_mejora_conserva_3_id'] ) : '';
            $SQL .= ( !empty( $mejora[0]['mejora_nro_nota'] ) ) ? ', mejora_nro_nota = ' . mysql_real_escape_string( $mejora[0]['mejora_nro_nota'] ) : '';
            $SQL .= ( !empty( $mejora[0]['mejora_nro_exp'] ) ) ? ', mejora_nro_exp = ' . mysql_real_escape_string( $mejora[0]['mejora_nro_exp'] ) : '';
            $SQL .= ( !empty( $mejora[0]['mejora_letra_exp'] ) ) ? ', mejora_letra_exp = "' . mysql_real_escape_string( $mejora[0]['mejora_letra_exp'] ) . '"' : '';
            $SQL .= ( !empty( $mejora[0]['mejora_fecha_exp'] ) ) ? ', mejora_fecha_exp = "' . mysql_real_escape_string( $mejora[0]['mejora_nro_exp'] ) . '"' : '';
            $SQL .= ( !empty( $mejora[0]['mejora_sup_cub'] ) ) ? ', mejora_sup_cub = ' . mysql_real_escape_string( $mejora[0]['mejora_sup_cub'] ) : '';
            $SQL .= ( !empty( $mejora[0]['mejora_sup_semi_cub'] ) ) ? ', mejora_sup_semi_cub = ' . mysql_real_escape_string( $mejora[0]['mejora_sup_semi_cub'] ) : '';
            $SQL .= ( !empty( $mejora[0]['mejora_sup_cub_2'] ) ) ? ', mejora_sup_cub_2 = ' . mysql_real_escape_string( $mejora[0]['mejora_sup_cub_2'] ) : '';
            $SQL .= ( !empty( $mejora[0]['mejora_anio_construccion'] ) ) ? ', mejora_anio_construccion = ' . mysql_real_escape_string( $mejora[0]['mejora_anio_construccion'] ) : '';
            $SQL .= ( !empty( $mejora[0]['mejora_anio_construccion_2'] ) ) ? ', mejora_anio_construccion_2 = ' . mysql_real_escape_string( $mejora[0]['mejora_anio_construccion_2'] ) : '';
            $SQL .= ( !empty( $mejora[0]['mejora_anio_construccion_3'] ) ) ? ', mejora_anio_construccion_3 = ' . mysql_real_escape_string( $mejora[0]['mejora_anio_construccion_3'] ) : '';
            $SQL .= ( !empty( $mejora[0]['mejora_porc_dominio'] ) ) ? ', mejora_porc_dominio = ' . mysql_real_escape_string( $mejora[0]['mejora_porc_dominio'] ) : '';
            $SQL .= ( !empty( $mejora[0]['mejora_f_alta'] ) ) ? ', mejora_f_alta = "' . mysql_real_escape_string( $mejora[0]['mejora_f_alta'] ) . '"' : '';
            $SQL .= ', mejora_f_pro = NOW()';
            $SQL .= ( !empty( $mejora[0]['mejora_categoria_dpc'] ) ) ? ', mejora_categoria_dpc = ' . mysql_real_escape_string( $mejora[0]['mejora_categoria_dpc'] ) : '';
            $SQL .= ( !empty( $mejora[0]['mejora_edif_id'] ) ) ? ', mejora_edif_id = ' . mysql_real_escape_string( $mejora[0]['mejora_edif_id'] ) : '';
            $SQL .= ( !empty( $mejora[0]['mejora_valor'] ) ) ? ', mejora_valor = ' . mysql_real_escape_string( $mejora[0]['mejora_valor'] ) : '';
            $SQL .= ( !empty( $mejora[0]['mejora_f_baja'] ) ) ? ', mejora_f_baja = "' . mysql_real_escape_string( $mejora[0]['mejora_f_baja'] ) . '"' : '';
            $SQL .= ( !empty( $mejora[0]['mejora_mot_baja'] ) ) ? ', mejora_mot_baja = "' . mysql_real_escape_string( $mejora[0]['mejora_mot_baja'] ) . '"' : '';
            $SQL .= ( !empty( $mejora[0]['mejora_observacion'] ) ) ? ', mejora_observacion = "' . mysql_real_escape_string( $mejora[0]['mejora_f_baja'] ) . '"' : '';
            $SQL .= ( !empty( $mejora[0]['usuario_id'] ) ) ? ', usuario_id = ' . mysql_real_escape_string( CCGetSession("UID") ) : '';
            $SQL .= ( !empty( $mejora[0]['audit_string'] ) ) ? ', audit_string = "' . mysql_real_escape_string( $mejora[0]['audit_string'] ) . '"' : '';
            $SQL .= ( !empty( $mejora[0]['tipo_estado_id'] ) ) ? ', tipo_estado_id = ' . mysql_real_escape_string( $mejora[0]['tipo_estado_id'] ) : '';
            $SQL .= ( !empty( $mejora[0]['mejora_form'] ) ) ? ', mejora_form = "' . mysql_real_escape_string( $mejora[0]['mejora_form'] ) . '"' : '';
            $SQL .= ( !empty( $mejora[0]['mejora_valuacion'] ) ) ? ', mejora_valuacion = ' . mysql_real_escape_string( $mejora[0]['mejora_valuacion'] ) : '';
            $SQL .= ( !empty( $mejora[0]['mejora_coef_ajuste'] ) ) ? ', mejora_coef_ajuste = ' . mysql_real_escape_string( $mejora[0]['mejora_coef_ajuste'] ) : '';
            $SQL .= ( !empty( $mejora[0]['tipo_mejora_cat_id'] ) ) ? ', tipo_mejora_cat_id = ' . mysql_real_escape_string( $mejora[0]['tipo_mejora_cat_id'] ) : '';
            $SQL .= ( !empty( $mejora[0]['tipo_mejora_cat_2_id'] ) ) ? ', tipo_mejora_cat_2_id = ' . mysql_real_escape_string( $mejora[0]['tipo_mejora_cat_2_id'] ) : '';
            $SQL .= ( !empty( $mejora[0]['tipo_mejora_cat_3_id'] ) ) ? ', tipo_mejora_cat_3_id = ' . mysql_real_escape_string( $mejora[0]['tipo_mejora_cat_3_id'] ) : '';
            $SQL .= ( !empty( $mejora[0]['mejora_id_old'] ) ) ? ', mejora_id_old = ' . mysql_real_escape_string( $mejora[0]['mejora_id_old'] ) : '';
            $SQL .= ( !empty( $mejora[0]['mejora_cant_bp'] ) ) ? ', mejora_cant_bp = ' . mysql_real_escape_string( $mejora[0]['mejora_cant_bp'] ) : '';
            $SQL .= ( !empty( $mejora[0]['mejora_cant_bs'] ) ) ? ', mejora_cant_bs = ' . mysql_real_escape_string( $mejora[0]['mejora_cant_bs'] ) : '';
            $SQL .= ( !empty( $mejora[0]['tipo_mejora_decla_id'] ) ) ? ', tipo_mejora_decla_id = ' . mysql_real_escape_string( $mejora[0]['tipo_mejora_decla_id'] ) . ';' : '';

            if ($debugMode) debug( $SQL );
            if (!$debugMode) $db->query( $SQL );
          }
        }
	  //Modif 02/12
      //} else if ( !empty( $countParcCreadas ) ) {	  
	  }// else 
	  if ( !empty( $countParcCreadas ) ) {	  
	  //Modif 02/12
        /* -- Parcelas a crear */
        if ($debugMode) debug('Tipo de PD: creadas');

        // trae las parcelas de destino
        $parcelasDestinoQuery = '
          SELECT *
          FROM planos_parc_prov
          WHERE planos_parc_prov.plano_id = ' . mysql_real_escape_string( $planoId ) . ' AND planos_parc_prov_tipo = "destino" AND ( planos_parc_prov.parcela_id IS NULL OR planos_parc_prov.parcela_id = "" );';
        $parcelasDestino = CCQueryToArray( $parcelasDestinoQuery, $db);

        if ($debugMode) debug('PD encontradas:');
        if ($debugMode) debug($parcelasDestino);

        // determina si es unión o división
        if ( count($parcelasOrigen) > count($parcelasDestino) ) {
          $tipoOperacion = 1; # union
        } else if( count($parcelasOrigen) < count($parcelasDestino) )  {
          $tipoOperacion = 2; # división
        } else {
          $tipoOperacion = 1; # mismo número de destino y origen
        }

        // va recorriendo las parcelas e insertando su relación y otros datos
        foreach( $parcelasDestino as $parcelaDest ) {

		  // Determina partida y estado de acuerdo a si es SVC o no
		  if ( !$isPlanoSVC ) {
	          $ultimaPartida = getUltimaPartida( $db );
	          $ultimaPartida++;
			  $estadoParcela = 1;
		  } else {
	          $ultimaPartida = 0;
			  $estadoParcela = 3;
		  }


          // crea la parcela de destino
          $supUF = ( !empty( $parcelaDest['planos_prov_sup_uf'] ) ) ? $parcelaDest['planos_prov_sup_uf'] : 0;
          $porcUF = ( !empty( $parcelaDest['planos_prov_porc_uf'] ) ) ? $parcelaDest['planos_prov_porc_uf'] : 0;

          $SQL = '
            INSERT INTO parcelas SET
            parcela_partida = ' . mysql_real_escape_string( $ultimaPartida )  . ',
            tipo_depto_parc_id = ' . mysql_real_escape_string( $parcelaDest['tipo_depto_parc_id'] )  . ',
            parcela_seccion = "' . mysql_real_escape_string( $parcelaDest['planos_prov_seccion'] )  . '",
            parcela_macizo = "' . mysql_real_escape_string( $parcelaDest['planos_prov_macizo'] )  . '",
            parcela_parcela = "' . mysql_real_escape_string( $parcelaDest['planos_prov_parcela'] )  . '",
            parcela_chacra = "' . mysql_real_escape_string( $parcelaDest['planos_prov_chacra'] )  . '",
            parcela_quinta = "' . mysql_real_escape_string( $parcelaDest['planos_prov_quinta'] )  . '",
            parcela_fraccion = "' . mysql_real_escape_string( $parcelaDest['planos_prov_fraccion'] )  . '",
            parcela_uf = "' . mysql_real_escape_string( $parcelaDest['planos_prov_uf'] )  . '",
            parcela_predio = "' . mysql_real_escape_string( $parcelaDest['planos_prov_predio'] )  . '",
            parcela_rte = "' . mysql_real_escape_string( $parcelaDest['planos_prov_rte'] )  . '",
            parcela_super_mensura = ' . mysql_real_escape_string( $parcelaDest['planos_prov_super_mensura'] )  . ',
            unidades_medidas_id = ' . mysql_real_escape_string( $parcelaDest['unidades_medidas_id'] )  . ',
            parcela_sup_uf = ' . mysql_real_escape_string( $supUF )  . ',
            parcela_porc_uf = ' . mysql_real_escape_string( $porcUF ) . ',
            usuario_id = ' . mysql_real_escape_string( CCGetSession("UID") ) . ',
            tipo_est_parc_id = ' . mysql_real_escape_string( $estadoParcela ) . ',
            parcela_f_alta = NOW(),
            parcela_f_proceso = NOW();';

          if ($debugMode) debug($SQL);
          if (!$debugMode) $db->query( $SQL );

          // guarda el ID insertado en relación a la parecela provisoria
          // TODO: con esto se podría hacer el loop que inserta las mejoras sólo una vez y no para cada parcela de destino
          $newParcelaId = mysql_insert_id();
          $provisoriasParcelas[$parcelaDest['planos_prov_id']] = array( 'parcela_id' => $newParcelaId, 'parcela_partida' => $ultimaPartida );

          // inserta la relación con origen / destino
          if ( ! $isSinOrig ) {
            foreach( $parcelasOrigen as $parcelaOrig ) {
              // inserta la relación
              $SQL = 'INSERT INTO uniones_desgloses SET
                parcela_id  = ' . $parcelaOrig['parcela_id'] . ',
                parcela_destino_id = ' . $newParcelaId . ',
                tipo_union_desglose_id = ' . $tipoOperacion . ',
                plano_id = ' . $planoId . ',
                usuario_id = ' . CCGetSession('UID') . ', union_desglose_fecha = NOW();';

              if ($debugMode) debug( $SQL );
              if (!$debugMode) $db->query( $SQL );

            }
          } else {
            // en este caso se inserta la relacíón directa con el plano sin parcela origen
            if ($debugMode) debug('Es plano sin orígen catastral / tierras fiscales sin mensurar');

            // inserta la relación
            $SQL = 'INSERT INTO uniones_desgloses SET
              parcela_destino_id = ' . $newParcelaId . ',
              tipo_union_desglose_id = ' . $tipoOperacion . ',
              plano_id = ' . $planoId . ',
              usuario_id = ' . CCGetSession('UID') . ', union_desglose_fecha = NOW();';

            if ($debugMode) debug( $SQL );
            if (!$debugMode) $db->query( $SQL );
          }


          // trae e inserta los titulares
          $titularesParcela = CCQueryToArray( 'SELECT * FROM planos_parc_prov_personas WHERE planos_prov_id = ' . mysql_real_escape_string( $parcelaDest['planos_prov_id'] ) . ';', $db);

          if ( !empty( $titularesParcela ) ) {

            foreach( $titularesParcela as $titularParcela ) {

              $SQL  = 'INSERT INTO personas_parcelas SET ';
              $SQL .= 'parcela_id = ' . $newParcelaId;
              $SQL .= ', persona_id = ' . $titularParcela['persona_id'];
              $SQL .= ( !empty( $titularParcela['tipo_instrumento_id'] ) ) ? ', tipo_instrumento_id = ' . mysql_real_escape_string( $titularParcela['tipo_instrumento_id'] ) : '';
              $SQL .= ( !empty( $titularParcela['planos_parc_prov_personas_num_int'] ) ) ? ', persona_parcela_num_int = "' . mysql_real_escape_string( $titularParcela['planos_parc_prov_personas_num_int'] ) . '"' : '';
              $SQL .= ( !empty( $titularParcela['persona_parcela_f_int'] ) ) ? ', persona_parcela_f_int = "' . mysql_real_escape_string( $titularParcela['persona_parcela_f_int'] ) . '"' : '';
              $SQL .= ( !empty( $titularParcela['persona_parcela_dominio'] ) ) ? ', persona_parcela_dominio = ' . mysql_real_escape_string( $titularParcela['persona_parcela_dominio'] ) : '';
              $SQL .= ( !empty( $titularParcela['tipo_persona_parcela_id'] ) ) ? ', tipo_persona_parcela_id = ' . mysql_real_escape_string( $titularParcela['tipo_persona_parcela_id'] ) : '';
              $SQL .= ', usuario_id = ' . mysql_real_escape_string( CCGetSession("UID") );
			  $SQL .= ', tipo_estado_id = 1';
              $SQL .= ', persona_parcela_f_pro = NOW()';
              $SQL .= ', persona_parcela_ppal = 1;';

              if ($debugMode) debug( $SQL );
              if (!$debugMode) $db->query( $SQL );
            }
          }


          // Asignación de mejoras seleccionadas

          $datosMejoras = $Container->FormParameters;
          if ($debugMode) debug($datosMejoras);

          if ( !empty( $datosMejoras ) ) {
            foreach( $datosMejoras['parcelas_destino_creadas'] as $key => $data ) {

              // si se ha asignado la mejora a la parcela
              if ( !empty($data) && $data == $parcelaDest['planos_prov_id'] ) {

                // recupera datos necesarios
                $mejora = CCQueryToArray( 'SELECT * FROM mejoras WHERE mejora_id = ' . mysql_real_escape_string( $datosMejoras['mejora_id'][$key] )  . ';', $db );

                // inserta la mejora en la parcela correspondiente
                $SQL  = 'INSERT INTO mejoras SET ';
                $SQL .= 'parcela_id = ' . mysql_real_escape_string( $newParcelaId );
                $SQL .= ( !empty( $mejora[0]['tipo_mejora_id'] ) ) ? ', tipo_mejora_id = ' . mysql_real_escape_string( $mejora[0]['tipo_mejora_id'] ) : '';
                $SQL .= ( !empty( $mejora[0]['tipo_mejora_estado_id'] ) ) ? ', tipo_mejora_estado_id = ' . mysql_real_escape_string( $mejora[0]['tipo_mejora_estado_id'] ): '';
                $SQL .= ( !empty( $mejora[0]['tipo_mejora_destino_id'] ) ) ? ', tipo_mejora_destino_id = ' . mysql_real_escape_string( $mejora[0]['tipo_mejora_destino_id'] ): '';
                $SQL .= ( !empty( $mejora[0]['tipo_mejora_conserva_id'] ) ) ? ', tipo_mejora_conserva_id = ' . mysql_real_escape_string( $mejora[0]['tipo_mejora_conserva_id'] ): '';
                $SQL .= ( !empty( $mejora[0]['tipo_mejora_conserva_2_id'] ) ) ? ', tipo_mejora_conserva_2_id = ' . mysql_real_escape_string( $mejora[0]['tipo_mejora_conserva_2_id'] ) : '';
                $SQL .= ( !empty( $mejora[0]['tipo_mejora_conserva_3_id'] ) ) ? ', tipo_mejora_conserva_3_id = ' . mysql_real_escape_string( $mejora[0]['tipo_mejora_conserva_3_id'] ) : '';
                $SQL .= ( !empty( $mejora[0]['mejora_nro_nota'] ) ) ? ', mejora_nro_nota = ' . mysql_real_escape_string( $mejora[0]['mejora_nro_nota'] ) : '';
                $SQL .= ( !empty( $mejora[0]['mejora_nro_exp'] ) ) ? ', mejora_nro_exp = ' . mysql_real_escape_string( $mejora[0]['mejora_nro_exp'] ) : '';
                $SQL .= ( !empty( $mejora[0]['mejora_letra_exp'] ) ) ? ', mejora_letra_exp = "' . mysql_real_escape_string( $mejora[0]['mejora_letra_exp'] ) . '"' : '';
                $SQL .= ( !empty( $mejora[0]['mejora_fecha_exp'] ) ) ? ', mejora_fecha_exp = "' . mysql_real_escape_string( $mejora[0]['mejora_nro_exp'] ) . '"' : '';
                $SQL .= ( !empty( $mejora[0]['mejora_sup_cub'] ) ) ? ', mejora_sup_cub = ' . mysql_real_escape_string( $mejora[0]['mejora_sup_cub'] ) : '';
                $SQL .= ( !empty( $mejora[0]['mejora_sup_semi_cub'] ) ) ? ', mejora_sup_semi_cub = ' . mysql_real_escape_string( $mejora[0]['mejora_sup_semi_cub'] ) : '';
                $SQL .= ( !empty( $mejora[0]['mejora_sup_cub_2'] ) ) ? ', mejora_sup_cub_2 = ' . mysql_real_escape_string( $mejora[0]['mejora_sup_cub_2'] ) : '';
                $SQL .= ( !empty( $mejora[0]['mejora_anio_construccion'] ) ) ? ', mejora_anio_construccion = ' . mysql_real_escape_string( $mejora[0]['mejora_anio_construccion'] ) : '';
                $SQL .= ( !empty( $mejora[0]['mejora_anio_construccion_2'] ) ) ? ', mejora_anio_construccion_2 = ' . mysql_real_escape_string( $mejora[0]['mejora_anio_construccion_2'] ) : '';
                $SQL .= ( !empty( $mejora[0]['mejora_anio_construccion_3'] ) ) ? ', mejora_anio_construccion_3 = ' . mysql_real_escape_string( $mejora[0]['mejora_anio_construccion_3'] ) : '';
                $SQL .= ( !empty( $mejora[0]['mejora_porc_dominio'] ) ) ? ', mejora_porc_dominio = ' . mysql_real_escape_string( $mejora[0]['mejora_porc_dominio'] ) : '';
                $SQL .= ( !empty( $mejora[0]['mejora_f_alta'] ) ) ? ', mejora_f_alta = "' . mysql_real_escape_string( $mejora[0]['mejora_f_alta'] ) . '"' : '';
                $SQL .= ', mejora_f_pro = NOW()';
                $SQL .= ( !empty( $mejora[0]['mejora_categoria_dpc'] ) ) ? ', mejora_categoria_dpc = ' . mysql_real_escape_string( $mejora[0]['mejora_categoria_dpc'] ) : '';
                $SQL .= ( !empty( $mejora[0]['mejora_edif_id'] ) ) ? ', mejora_edif_id = ' . mysql_real_escape_string( $mejora[0]['mejora_edif_id'] ) : '';
                $SQL .= ( !empty( $mejora[0]['mejora_valor'] ) ) ? ', mejora_valor = ' . mysql_real_escape_string( $mejora[0]['mejora_valor'] ) : '';
                $SQL .= ( !empty( $mejora[0]['mejora_f_baja'] ) ) ? ', mejora_f_baja = "' . mysql_real_escape_string( $mejora[0]['mejora_f_baja'] ) . '"' : '';
                $SQL .= ( !empty( $mejora[0]['mejora_mot_baja'] ) ) ? ', mejora_mot_baja = "' . mysql_real_escape_string( $mejora[0]['mejora_mot_baja'] ) . '"' : '';
                $SQL .= ( !empty( $mejora[0]['mejora_observacion'] ) ) ? ', mejora_observacion = "' . mysql_real_escape_string( $mejora[0]['mejora_f_baja'] ) . '"' : '';
                $SQL .= ( !empty( $mejora[0]['usuario_id'] ) ) ? ', usuario_id = ' . mysql_real_escape_string( CCGetSession("UID") ) : '';
                $SQL .= ( !empty( $mejora[0]['audit_string'] ) ) ? ', audit_string = "' . mysql_real_escape_string( $mejora[0]['audit_string'] ) . '"' : '';
                $SQL .= ( !empty( $mejora[0]['tipo_estado_id'] ) ) ? ', tipo_estado_id = ' . mysql_real_escape_string( $mejora[0]['tipo_estado_id'] ) : '';
                $SQL .= ( !empty( $mejora[0]['mejora_form'] ) ) ? ', mejora_form = "' . mysql_real_escape_string( $mejora[0]['mejora_form'] ) . '"' : '';
                $SQL .= ( !empty( $mejora[0]['mejora_valuacion'] ) ) ? ', mejora_valuacion = ' . mysql_real_escape_string( $mejora[0]['mejora_valuacion'] ) : '';
                $SQL .= ( !empty( $mejora[0]['mejora_coef_ajuste'] ) ) ? ', mejora_coef_ajuste = ' . mysql_real_escape_string( $mejora[0]['mejora_coef_ajuste'] ) : '';
                $SQL .= ( !empty( $mejora[0]['tipo_mejora_cat_id'] ) ) ? ', tipo_mejora_cat_id = ' . mysql_real_escape_string( $mejora[0]['tipo_mejora_cat_id'] ) : '';
                $SQL .= ( !empty( $mejora[0]['tipo_mejora_cat_2_id'] ) ) ? ', tipo_mejora_cat_2_id = ' . mysql_real_escape_string( $mejora[0]['tipo_mejora_cat_2_id'] ) : '';
                $SQL .= ( !empty( $mejora[0]['tipo_mejora_cat_3_id'] ) ) ? ', tipo_mejora_cat_3_id = ' . mysql_real_escape_string( $mejora[0]['tipo_mejora_cat_3_id'] ) : '';
                $SQL .= ( !empty( $mejora[0]['mejora_id_old'] ) ) ? ', mejora_id_old = ' . mysql_real_escape_string( $mejora[0]['mejora_id_old'] ) : '';
                $SQL .= ( !empty( $mejora[0]['mejora_cant_bp'] ) ) ? ', mejora_cant_bp = ' . mysql_real_escape_string( $mejora[0]['mejora_cant_bp'] ) : '';
                $SQL .= ( !empty( $mejora[0]['mejora_cant_bs'] ) ) ? ', mejora_cant_bs = ' . mysql_real_escape_string( $mejora[0]['mejora_cant_bs'] ) : '';
                $SQL .= ( !empty( $mejora[0]['tipo_mejora_decla_id'] ) ) ? ', tipo_mejora_decla_id = ' . mysql_real_escape_string( $mejora[0]['tipo_mejora_decla_id'] ) . ';' : '';

                if ($debugMode) debug( $SQL );
                if (!$debugMode) $db->query( $SQL );

              }

            }

          }

        } // end foreach: va recorriendo las parcelas e insertando su relación y otros datos

      } // end if: si hay parcelas a crear


      // Pone las parcela de Orig. como histórica (si no es un plano Sin Origen o SVC o tipo Servidumbre)
      if ( !$isPlanoSVC && !$isSinOrig && !$isServidumbre ) {
        foreach( $parcelasOrigen as $parcelaOrig ) {
          $SQL = 'UPDATE parcelas SET tipo_est_parc_id = 2, parcela_f_proceso = NOW() WHERE parcela_id = ' . $parcelaOrig['parcela_id'] . ';';

          if ($debugMode) debug( 'Pone las parcela de Orig. como histórica (si no es un plano Sin Origen o SVC)' );
          if ($debugMode) debug( $SQL );
          if (!$debugMode) $db->query( $SQL );
        }
      }


      // Cambiar el estado del plano
      $SQL = 'UPDATE planos SET tipo_estado_plano_id = 4 WHERE plano_id = ' . mysql_real_escape_string( $planoId ) . ';';

      if ($debugMode) debug( 'Cambiar el estado del plano' );
      if ($debugMode) debug( $SQL );
      if (!$debugMode) $db->query( $SQL );

    }


  } else {

    $errors[] = 'No se pudo procesar el registro del plano.';

  }



  /* Procesa el array de errores y si tiene algo lo guarda en la sesión para mostrarlo */

  if ( !empty( $errors ) ) {
    $output = '
      <div class="results" style="padding: 10px; margin: 15px 0; border: 1px solid #FBEED5; background-color: #FCF8E3; width: 938px;">
        <h1>Resultados</h1>
        <h2>Errores detectados</h2>
        <ul class="results-errors" style="list-style-position: inside; margin: 0; padding: 5px; border: 1px solid #EED3D7; background-color: #F2DEDE; color: #B94A48;">';

    foreach( $errors as $error ) {
      $output .= '<li>' . $error . '</li>';
    }

    $output .= '
        </ul>
      </div>';


    $_SESSION['registerMessage'] = $output;

  } else {

    // redireccionar al edit de plano
    global $Redirect;
    if (!$debugMode) $Redirect = RelativePath . '/tecnica/tc_planosRecord.php?plano_id=' . $planoId;

  }

  if ($debugMode) die();

// -------------------------
//End Custom Code

//Close EditableGrid1_Button_Registrar_OnClick @382-63E75D4D
    return $EditableGrid1_Button_Registrar_OnClick;
}
//End Close EditableGrid1_Button_Registrar_OnClick


//EditableGrid1_BeforeShow @308-1066041D
function EditableGrid1_BeforeShow(& $sender)
{
    $EditableGrid1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $EditableGrid1; //Compatibility
//End EditableGrid1_BeforeShow

//Custom Code @358-2A29BDB7
// -------------------------


// -------------------------
//End Custom Code

//Close EditableGrid1_BeforeShow @308-094A7726
    return $EditableGrid1_BeforeShow;
}
//End Close EditableGrid1_BeforeShow

//EditableGrid1_OnValidate @308-FB654D78
function EditableGrid1_OnValidate(& $sender)
{
    $EditableGrid1_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $EditableGrid1; //Compatibility
//End EditableGrid1_OnValidate

//Custom Code @385-2A29BDB7
// -------------------------

// -------------------------
//End Custom Code

//Close EditableGrid1_OnValidate @308-36B113AF
    return $EditableGrid1_OnValidate;
}
//End Close EditableGrid1_OnValidate

//results_message_BeforeShow @386-9FED0E55
function results_message_BeforeShow(& $sender)
{
    $results_message_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $results_message; //Compatibility
//End results_message_BeforeShow

//Custom Code @388-2A29BDB7
// -------------------------


  /* Si hay mensaje guardado en la Sesión los muestra
  ------------------------------------------------------------ */

  if ( !empty( $_SESSION['registerMessage'] ) ) {
    $Component->SetValue( $_SESSION['registerMessage'] );
    unset( $_SESSION['registerMessage'] );
  }


// -------------------------
//End Custom Code

//Close results_message_BeforeShow @386-67DEFDE9
    return $results_message_BeforeShow;
}
//End Close results_message_BeforeShow

//Page_BeforeInitialize @1-ACF28555
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tc_planosRegistro; //Compatibility
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
