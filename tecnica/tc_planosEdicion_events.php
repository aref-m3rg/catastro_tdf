<?php
//BindEvents Method @1-3E01FF27
function BindEvents()
{
    global $planos;
    global $parcelas_destino_prov;
    global $parcelas_origen_prov;
    global $CCSEvents;
    $planos->plano_archivo->CCSEvents["AfterProcessFile"] = "planos_plano_archivo_AfterProcessFile";
    $planos->CustomError->CCSEvents["BeforeShow"] = "planos_CustomError_BeforeShow";
    $planos->Button_Editar->CCSEvents["OnClick"] = "planos_Button_Editar_OnClick";
    $planos->ListBox1->CCSEvents["BeforeShow"] = "planos_ListBox1_BeforeShow";
    $planos->CCSEvents["AfterInsert"] = "planos_AfterInsert";
    $planos->CCSEvents["AfterUpdate"] = "planos_AfterUpdate";
    $planos->CCSEvents["BeforeShow"] = "planos_BeforeShow";
    $planos->CCSEvents["OnValidate"] = "planos_OnValidate";
    $parcelas_destino_prov->parcelas1_TotalRecords->CCSEvents["BeforeShow"] = "parcelas_destino_prov_parcelas1_TotalRecords_BeforeShow";
    $parcelas_destino_prov->plano->CCSEvents["BeforeShow"] = "parcelas_destino_prov_plano_BeforeShow";
    $parcelas_destino_prov->CCSEvents["BeforeShowRow"] = "parcelas_destino_prov_BeforeShowRow";
    $parcelas_destino_prov->CCSEvents["BeforeShow"] = "parcelas_destino_prov_BeforeShow";
    $parcelas_origen_prov->origen_TotalRecords->CCSEvents["BeforeShow"] = "parcelas_origen_prov_origen_TotalRecords_BeforeShow";
    $parcelas_origen_prov->Navigator->CCSEvents["BeforeShow"] = "parcelas_origen_prov_Navigator_BeforeShow";
    $parcelas_origen_prov->plano->CCSEvents["BeforeShow"] = "parcelas_origen_prov_plano_BeforeShow";
    $parcelas_origen_prov->ds->CCSEvents["AfterExecuteDelete"] = "parcelas_origen_prov_ds_AfterExecuteDelete";
    $parcelas_origen_prov->CCSEvents["BeforeShow"] = "parcelas_origen_prov_BeforeShow";
    $parcelas_origen_prov->CCSEvents["BeforeShowRow"] = "parcelas_origen_prov_BeforeShowRow";
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
	$planoData = CCQueryToArray( 'SELECT * FROM planos WHERE plano_id = ' . mysql_real_escape_string( $planoId ) . ';', $db );
	$userId = CCGetSession('UID');

	// muestra en la pantalla salidas para depuración
  	$debugMode = false;

	if ($debugMode) debug($planoData, false, false, 'Datos del plano');

	$isPlanoSVC = ( empty($planoData[0]['plano_svc']) ) ? false : true;
	$isSinOrig = ( $planoData[0]['plano_sin_origen'] == 1 ) ? true : false;
	$isServidumbre = ( $planoData[0]['tipo_plano_id'] == 1 ) ? true : false;
	$notRegistered = ( $planoData[0]['tipo_estado_plano_id'] != 4 ) ? true : false;
	$isTramiteMig = ( $planoData[0]['plano_tramite_mig'] == 1 ) ? true : false;
	if ($debugMode) debug($isTramiteMig, false, false, 'Es plano en trámite migrado con parcelas en trámite?');

	//var_dump($isSinOrig);exit;
	/* Proceso de guardar Edición del Plano
	---------------------------------------------------------------
	1. Hace el volcado en PDF y lo guarda
	2. Procesa los cambios en las parcelas
		2.1. Comprobar existencia de las parcelas
		2.2. Crear las que no existen y asignar los titulares
		2.3. Vincular y desvincular con el plano en uniones y desgloses
	3. Borra los datos en las parcelas provisorias
	4. Saca el plano de edición 
	5. Redirecciona a planosRecord.php
	*/


	// si no hay ID de plano no se hace nada
	if ( !empty( $planoId ) && !empty( $planoData ) ) {

		/* 1. Volcado y generación de snapshot en PDF
		--------------------------------------------------------------- */
		/* -- Inserta el snapshot */
		$snapSQL = 'INSERT INTO planos_snapshots SET plano_id = ' . mysql_real_escape_string($planoId) . ', creado = NOW(), usuario_id = ' . $userId . ", plano_data = '" . mysql_real_escape_string( json_encode($planoData) ) . "';";
		if ($debugMode) debug( $snapSQL, false, false, 'Query insert snapshot:' );
		if (!$debugMode) $db->query($snapSQL);

		$snapshotId = mysql_insert_id();
		if ($debugMode) debug( $snapshotId, false, false, 'ID insert snapshot:' );

		/* -- Genera y guarda PDF */
		require_once( RelativePath . '/scripts/tcpdf/tcpdf.php' );

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_URL, BASE_URL . '/tecnica/tc_planosVista.php?plano_id=' . $planoId);
		$htmlDump = curl_exec($ch);
		curl_close($ch);

		// limpia el HTML (requiere la extension Tidy de PHP)
		$tidy_config = array( 'clean' => true, 'output-xhtml' => true, 'show-body-only' => true, 'wrap' => 0 ); 
		$tidy = tidy_parse_string($htmlDump, $tidy_config, 'UTF8'); 
		$tidy->cleanRepair(); 

		if ( !empty($htmlDump) ) {
			// crea el PDF
			$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, false, 'ISO-8859-1', false);

			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Subsecretaría de Catastro Provincial - Dirección General de Catastro e Información Territorial');
			$pdfTitle = 'Resumen de estado del plano ID: ' . $planoId;
			$pdf->SetTitle($pdfTitle);
			$pdfSubject = 'Generado el ' . date('d/m/Y \a \l\a\s H:i:s') . ' por el usuario ID: ' . $userId;
			$pdf->SetSubject($pdfSubject);

			$pdf->SetHeaderData('', 0, $pdfTitle, $pdfSubject);

			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			$styles = '<style>
				table {
				}

				th {
					color: #ffffff;
					font-weight: bold;
					background-color: #333;
				}
				td { background-color: #eee; }
			</style>';
			$pdf->AddPage();
			$fileName = $planoId . '_' . date('Ymd_h-i-s') . '.pdf';
			$pdf->writeHTML($styles . $tidy, true, false, true, false, '');

			// guarda el plano en el disco
			$pdf->Output( WWW_ROOT . PLANOS_SNAPSHOTS_PATH . DS . $fileName, 'F');

			/* -- Actualiza la información del snapshot con el nombre del archivo y las parcelas de origen y destino */
			if ( !empty($snapshotId) ) {
				$poActuales = getParcOrigen($planoId, $db);
				if ($debugMode) debug( $poActuales, false, false, 'PO Actuales del plano:' );

				$pdActuales = getParcDestino($planoId, $db);
				if ($debugMode) debug( $pdActuales, false, false, 'PD Actuales del plano:' );

				if ( empty($poActuales) ) {
					$poActuales = '';
				} else {
					$poActuales = json_encode($poActuales);
				}

				if ( empty($pdActuales) ) {
					$pdActuales = '';
				} else {
					$pdActuales = json_encode($pdActuales);
				}

				$snapUpdSQL = 'UPDATE planos_snapshots SET archivo = "' . mysql_real_escape_string($fileName) . '", parcelas_origen_data = "' . mysql_real_escape_string($poActuales) . '", parcelas_destino_data = "' . mysql_real_escape_string($pdActuales) . '" WHERE planos_snapshots.id = ' . $snapshotId . ';';
				if ($debugMode) debug( $snapUpdSQL, false, false, 'Query update snapshot:' );
				if (!$debugMode) $db->query($snapUpdSQL);
			}

		}


		/* 2. Procesa los cambios en las parcelas
		--------------------------------------------------------------- */

		/* -- Validaciones generales */
		// Validar que hayan parcelas de origen
		$countParcOrig = planoProvOrigen( $planoId, $db );
		if ($debugMode) debug( $countParcOrig, false, false, 'Cantidad P.O.P.' );


		if ( $countParcOrig['cant'] < 1 && ( $isSinOrig != true ) ) {
			$errors[] = 'No hay parcelas de Origen seleccionadas para registrar el plano.';
			if ($debugMode) debug('error');
		}

		/* -- Trae las parcelas de destino a crear y seleccionadas */
		$countParcSel = planoProvSelec( $planoId, $db );
		if ($debugMode) debug( $countParcSel, false, false, 'Cantidad P.D.P.Sel.' );

		$countParcCreadas = planoProvCreadas( $planoId, $db );
		if ($debugMode) debug( $countParcCreadas, false, false, 'Cantidad P.D.P.Crear' );

		// Si el plano no es del tipo "servidumbre" valida que tiene parcelas de destino y lo contrario si no es
		if ( !$isServidumbre && ( empty($countParcSel['cant']) && empty($countParcCreadas['cant']) ) ) {
			$errors[] = 'El plano NO es del tipo -Servidumbre- y NO tiene Parcelas de Destino asignadas. De no ser un plano de Servidumbre debe asignar Parcelas de Destino al plano.';
		} else if ( $isServidumbre && ( $countParcSel['cant'] > 0 || $countParcCreadas['cant'] > 0 ) ) {
			$errors[] = 'El plano ES del tipo -Servidumbre- y tiene Parcelas de Destino asignadas. Por favor desvincúlelas y proceda nuevamente a guardar los cambios.';
		}

		
    	/* -- Si no se han registrado errores en las primeras condiciones ejecuta el proceso */
		
		if ( empty( $errors ) ) {

			/* -- Trae las P.O. y P.D. a crear, vincular y desvincular */
			$po = getParcOrigenDiff( $planoId, $db, array('debug' => false) );
			if ($debugMode) debug( $po, false, false, 'Diferencias P.O.' );

			$pd = getParcDestinoDiff( $planoId, $db, array('debug' => false) );
			if ($debugMode) debug( $pd, false, false, 'Diferencias P.D.' );

			/* -- Crear P.D. */
			if ( !empty( $pd['create'] ) ) {
				foreach( $pd['create'] as $pdc ) {
					$output = createParcela( $pdc, $db, array( 'isPlanoSVC' => $isPlanoSVC, 'debug' => $debugMode) );
					if ( $output == 'duplicated' ) {
						$errors[] = 'La parcela a insertar ya existe: ' . json_encode($pdc);	
					} else if ( $output == 'error' ) {
						$errors[] = 'Hubo un error al insertar la parcela: ' . json_encode($pdc);	
					} else {
						// guardo en un array las parcelas que se insertaron para luego vincularlas
						$pdNuevas[] = $output;
						if ($debugMode) debug( $output, false, false, 'P.D. creada con ID: ' );

						// trae e inserta los titulares vinculados
						$titularesParcela = CCQueryToArray( 'SELECT * FROM planos_parc_prov_personas WHERE planos_prov_id = ' . mysql_real_escape_string( $pdc['planos_prov_id'] ) . ';', $db);
						if ($debugMode) debug( $titularesParcela, false, false, 'Titulares a insertar en la P.D. creada: ' );

						if ( !empty( $titularesParcela ) ) {
							foreach( $titularesParcela as $titularParcela ) {
							  $SQL  = 'INSERT INTO personas_parcelas SET ';
							  $SQL .= 'parcela_id = ' . $output;
							  $SQL .= ', persona_id = ' . $titularParcela['persona_id'];
							  $SQL .= ( !empty( $titularParcela['tipo_instrumento_id'] ) ) ? ', tipo_instrumento_id = ' . mysql_real_escape_string( $titularParcela['tipo_instrumento_id'] ) : '';
							  $SQL .= ( !empty( $titularParcela['planos_parc_prov_personas_num_int'] ) ) ? ', persona_parcela_num_int = "' . mysql_real_escape_string( $titularParcela['planos_parc_prov_personas_num_int'] ) . '"' : '';
							  $SQL .= ( !empty( $titularParcela['persona_parcela_f_int'] ) ) ? ', persona_parcela_f_int = "' . mysql_real_escape_string( $titularParcela['persona_parcela_f_int'] ) . '"' : '';
							  $SQL .= ( !empty( $titularParcela['persona_parcela_dominio'] ) ) ? ', persona_parcela_dominio = ' . mysql_real_escape_string( $titularParcela['persona_parcela_dominio'] ) : '';
							  $SQL .= ( !empty( $titularParcela['tipo_persona_parcela_id'] ) ) ? ', tipo_persona_parcela_id = ' . mysql_real_escape_string( $titularParcela['tipo_persona_parcela_id'] ) : '';
							  $SQL .= ', usuario_id = ' . mysql_real_escape_string( CCGetSession("UID") );
							  $SQL .= ', persona_parcela_f_pro = NOW()';
							  $SQL .= ', persona_parcela_ppal = 1;';

							  if ($debugMode) debug( $SQL, false, false, 'Insertando titular: ' );
							  if (!$debugMode) $db->query( $SQL );
							}
						}

					}

				}			
			}
			

			/* -- Luego de crear las parcelas necesarias las agrega al array de PDP a vincular */
			if ( !empty($pdNuevas) ) {
				foreach( $pdNuevas as $pdn ) {
					$pd['add'][] = $pdn;
				}
			}
			if ($debugMode) debug( $pd, false, false, 'Diferencias P.D. luego de crear' );


			/* -- Comienza proceso UNION/DESGLOSE sobre las parcelas -- */

	        // determina si es unión o división
	        if ( $po['total'] > $pd['total'] ) {
	          $tipoOperacion = 1; # union
	        } else if( $po['total'] < $pd['total'] )  {
	          $tipoOperacion = 2; # división
	        } else {
	          $tipoOperacion = 1; # mismo número de destino y origen
	        }
			if ($debugMode) debug( $tipoOperacion, false, false, 'Tipo operación:' );

			// remueve PO
			if ( !empty( $po['remove'] ) ) {
				foreach( $po['remove'] as $poItem ) {
					$delPO = 'DELETE FROM uniones_desgloses WHERE parcela_id = ' . mysql_real_escape_string( $poItem ) . ' AND plano_id = ' . mysql_real_escape_string($planoId);
					if ($debugMode) debug( $delPO, false, false, 'Query remoción PO:' );

					if (!$debugMode) $db->query($delPO);
				}
			}

			// remueve PD
			if ( !empty($pd['remove']) ) {
				foreach( $pd['remove'] as $pdItem ) {
					$delPD = 'DELETE FROM uniones_desgloses WHERE parcela_destino_id = ' . mysql_real_escape_string( $pdItem ) . ' AND plano_id = ' . mysql_real_escape_string($planoId);
					if ($debugMode) debug( $delPD, false, false, 'Query remoción PD:' );

					if (!$debugMode) $db->query($delPD);
				}
			}

			//echo $isSinOrig." </br>"; exit;
			if ( !$isSinOrig ) {
				// Si NO es plano Sin Origen Catastral...
				//echo 2." </br>";
				// vincular PO existentes con las PD nuevas (keep -> add)
				if ( !empty($po['keep']) ) {
					//echo 3." </br>";
					foreach( $po['keep'] as $poItem ) {
					  if ( !empty($pd['add']) ) {
						  foreach( $pd['add'] as $pdItem ) {
							  // inserta la relación
							  $poKeepAddSQL = 'INSERT INTO uniones_desgloses SET parcela_id  = ' . $poItem . ', parcela_destino_id = ' . $pdItem . ', tipo_union_desglose_id = ' . $tipoOperacion . ', plano_id = ' . $planoId . ', usuario_id = ' . CCGetSession('UID') . ', union_desglose_fecha = NOW(), uniones_desgloses_observacion = "Insertando relación PO:keep -> PD:add";';							  
							  if ($debugMode) debug($poKeepAddSQL, false, false, 'Insertando relación PO:keep -> PD:add');
							  if (!$debugMode) $db->query( $poKeepAddSQL );
						  }
					  }

						// G. Quiroga 25/11/19
					  if ( !empty($pd['keep']) ) {
						  //echo 6;
						  foreach( $pd['keep'] as $pdItem ) {
							//echo 7;
							  // inserta la relación
							  $poKeepKeepSQL = 'INSERT INTO uniones_desgloses SET parcela_id  = ' . $poItem . ', parcela_destino_id = ' . $pdItem . ', tipo_union_desglose_id = ' . $tipoOperacion . ', plano_id = ' . $planoId . ', usuario_id = ' . CCGetSession('UID') . ', union_desglose_fecha = NOW(), uniones_desgloses_observacion = "Insertando relación PO:keep -> PD:add";';
							  //echo $poKeepKeepSQL; echo "</br>";
							  if ($debugMode) debug($poKeepKeepSQL, false, false, 'Insertando relación PO:keep -> PD:keep');
							  if (!$debugMode) $db->query( $poKeepKeepSQL );
							  //echo $poKeepKeepSQL; exit;
						  }
					  }

					}
				}

				// vincular PO nuevas con las PD existentes y nuevas (add -> keep + add)
				if ( !empty($po['add']) ) {
					foreach( $po['add'] as $poItem ) {
					  if ( !empty($pd['add']) ) {
						  foreach( $pd['add'] as $pdItem ) {
							  // inserta la relación
							  $poAddAddSQL = 'INSERT INTO uniones_desgloses SET parcela_id  = ' . $poItem . ', parcela_destino_id = ' . $pdItem . ', tipo_union_desglose_id = ' . $tipoOperacion . ', plano_id = ' . $planoId . ', usuario_id = ' . CCGetSession('UID') . ', union_desglose_fecha = NOW(), uniones_desgloses_observacion = "Insertando relación PO:add -> PD:add";';
							  if ($debugMode) debug($poAddAddSQL, false, false, 'Insertando relación PO:add -> PD:add');
							  if (!$debugMode) $db->query( $poAddAddSQL );
						  }
					  }
					  if ( !empty($pd['keep']) ) {
						  foreach( $pd['keep'] as $pdItem ) {
							  // inserta la relación
							  $poAddKeep = 'INSERT INTO uniones_desgloses SET parcela_id  = ' . $poItem . ', parcela_destino_id = ' . $pdItem . ', tipo_union_desglose_id = ' . $tipoOperacion . ', plano_id = ' . $planoId . ', usuario_id = ' . CCGetSession('UID') . ', union_desglose_fecha = NOW(), uniones_desgloses_observacion = "Insertando relación PO:add -> PD:keep";';
							  if ($debugMode) debug($poAddKeep, false, false, 'Insertando relación PO:add -> PD:keep:');
							  if (!$debugMode) $db->query( $poAddKeep );
						  }
					  }
					}
				}
			} else {
				// Si es plano Sin Origen Catastral...				
				// vincular PD nuevas
				if ( !empty($pd['add']) ) {
				    foreach( $pd['add'] as $pdItem ) {
					    // inserta la relación
					    $pdAddSQL = 'INSERT INTO uniones_desgloses SET parcela_destino_id = ' . $pdItem . ', tipo_union_desglose_id = ' . $tipoOperacion . ', plano_id = ' . $planoId . ', usuario_id = ' . CCGetSession('UID') . ', union_desglose_fecha = NOW(), uniones_desgloses_observacion = "Insertando relación PD:add en un Sin Orig. Catastral";';
					    if ($debugMode) debug($pdAddSQL, false, false, 'Insertando relación PD:add en un Sin Orig. Catastral:');
					    if (!$debugMode) $db->query( $pdAddSQL );
				    }
				}

			}

			/* 3. Borra datos en las parcelas provisorias y titulares prov.
			--------------------------------------------------------------- */
			$delQuery = 'DELETE FROM planos_parc_prov WHERE plano_id = ' . mysql_real_escape_string($planoId);
			if ($debugMode) debug($delQuery, false, false, 'Borra datos de parcelas provisorias:');
			if (!$debugMode) $db->query( $delQuery );
			
			if ( !empty($pd['create']) ) {
				foreach( $pd['create'] as $pdc ) {
					$delTitQuery = 'DELETE FROM planos_parc_prov_personas WHERE planos_prov_id = ' . $pdc['planos_prov_id'];
					if ($debugMode) debug($delTitQuery, false, false, 'Borra datos de titulares de parcelas provisorias:');
					if (!$debugMode) $db->query( $delTitQuery );
				}
			}

			/* 4. Saca el plano de edición
			--------------------------------------------------------------- */
			$updQuery = 'UPDATE planos SET plano_en_edicion = 0 WHERE plano_id = ' . mysql_real_escape_string($planoId);
			if ($debugMode) debug($updQuery, false, false, 'Query de actualización estado edición plano:');
			if (!$debugMode) $db->query( $updQuery );


			/* 5. Redirecciona
			--------------------------------------------------------------- */
			global $Redirect;
			$Redirect = "tc_planosRecord.php?plano_id=" . $planoId;

		} 
	}


	if ($debugMode) debug( $errors, false, false, 'Errores del proceso' );
	if ($debugMode) die();

// -------------------------
//End Custom Code

//Close planos_Button_Editar_OnClick @537-4FC62B88
    return $planos_Button_Editar_OnClick;
}
//End Close planos_Button_Editar_OnClick

//planos_ListBox1_BeforeShow @622-7246C7E6
function planos_ListBox1_BeforeShow(& $sender)
{
    $planos_ListBox1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planos; //Compatibility
//End planos_ListBox1_BeforeShow

//Custom Code @623-2A29BDB7
// -------------------------
	// G. Quiroga edición estado planos
	// Si es administrador le permito editar el estado del plano
	$usuario_id = CCGetSession('UID');
	$db = new clsDBtdf_nuevo();
	$perfil_id = CCDLookUp('perfil_id', '_usuarios', 'usuario_id = ' . $usuario_id, $db);
	if($perfil_id == 1){
		$planos->ListBox1->Visible = true; 
	}else{
		$planos->ListBox1->Visible = false;
	}
// -------------------------
//End Custom Code

//Close planos_ListBox1_BeforeShow @622-D4B401D0
    return $planos_ListBox1_BeforeShow;
}
//End Close planos_ListBox1_BeforeShow

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

	// Historia estado planos
	$db = new clsDBtdf_nuevo();
	$max_id = CCDLookUp('MAX(historico_estado_plano_id)', 'historico_estados_planos', '', $db);

	$SQL = "UPDATE historico_estados_planos SET	usuario_id = " . CCGetUserID() . " WHERE usuario_id IS NULL AND historico_estado_plano_id = " . $max_id;
	//echo $SQL; exit;
	$db->query($SQL);
	$db->close();	

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


	$db = new clsDBtdf_nuevo();

	////// G. Quiroga //////
	$paramPlanoId = CCGetParam('plano_id', false);	
	// Si existe mas de 1 origen y mas de 1 destino, informo
	$countOrigen = CCDLookUp('COUNT(*)', '(SELECT * FROM uniones_desgloses WHERE parcela_id IS NOT NULL AND plano_id = ' . $paramPlanoId . ' GROUP BY parcela_id) AS total_origen', '', $db);
	$countDestino = CCDLookUp('COUNT(*)', '(SELECT * FROM uniones_desgloses WHERE parcela_destino_id IS NOT NULL AND plano_id = ' . $paramPlanoId . ' GROUP BY parcela_destino_id) AS total_destino', '', $db);
	if($countOrigen > 1 && $countDestino > 1 ){
		//echo $countOrigen."</br>";
		//echo $countDestino."</br>";
		$planos->Label1->SetValue('</br>Este plano posee más de un origen y más de un destino simultáneamente</br> por lo que en caso de querer editar las parcelas vinculadas se recomienda </br>darlas de baja en primer instancia y luego crear nuevamente las relaciones.');
	}
	////////////////////////


	/* Decide qué paneles y controles mostrar dentro del record.
	   Los botones y grids se manejan en el BeforeShow de la pag.
	-------------------------------------------------------------- */



	/* Trae el dato del estado actual del plano p/ el label
	--------------------------------------------------------- */
	$estadoPlano = $Component->DataSource->f('tipo_estado_plano_id');

	if ( !empty( $estadoPlano ) ) {

		$estadoPlanoNombre = CCDLookUp('tipo_estado_plano_desc', 'tipos_estados_planos', 'tipo_estado_plano_id = ' . $estadoPlano, $db );

		if ( !empty( $estadoPlanoNombre ) ) {
			$Component->plano_estado_desc->SetValue( $estadoPlanoNombre );
		}

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

//DEL  // -------------------------
//DEL      
//DEL  	$db = new clsDBtdf_nuevo();
//DEL  
//DEL  	$userId = CCGetSession('UID');
//DEL  	$planoId = CCGetParam('plano_id');
//DEL  
//DEL  
//DEL  	/* Guarda un histórico y genera un snapshot del plano
//DEL  	--------------------------------------------------------- */
//DEL  
//DEL  	/* Guarda el registro en la tabla de históricos */
//DEL  	$SQL = 'INSERT INTO planos_ediciones SELECT NULL AS id, planos.*, ' . $userId . ' AS edicion_usuario_id, NOW() AS edicion_fecha, "" AS edicion_snapshot, "parcial" as edicion_tipo FROM planos WHERE planos.plano_id = ' . mysql_real_escape_string($planoId);
//DEL  	$db->query($SQL);
//DEL  
//DEL  	$insertId = mysql_insert_id();
//DEL  
//DEL  
//DEL  	/* Genera el snapshot en PDF y lo guarda en la tabla */
//DEL  	
//DEL  
//DEL  
//DEL  
//DEL  	$db->close();
//DEL  
//DEL  // -------------------------

//DEL  // -------------------------
//DEL  
//DEL      /* Borra las parcela de origen seleccionadas.
//DEL  	   Este evento se ejecuta después del custom delete (que no hace nada)
//DEL      ------------------------------------------------------------------------- */
//DEL  
//DEL  	$planoId = CCGetParam('plano_id');
//DEL  
//DEL  	if( $planoId ) {
//DEL  
//DEL  		$theId = $Component->planos_prov_id->GetValue();
//DEL  
//DEL  		$db = new clsDBtdf_nuevo();
//DEL  		$SQL = 'DELETE FROM planos_parc_prov WHERE planos_prov_id = ' . $theId . ' AND plano_id = ' . $planoId;
//DEL  		$db->query($SQL);
//DEL  		$db->close();
//DEL  
//DEL  	}
//DEL  
//DEL  
//DEL  // -------------------------

//DEL  // -------------------------
//DEL  
//DEL  
//DEL  	/* Asigna el link con sus parámetros y el popup al enlace de
//DEL  	   seleccionar nuevas parcelas (Origen prov.)
//DEL  	-------------------------------------------------------------- */
//DEL  
//DEL  	$newlnk = "#";
//DEL  	$planoId = CCGetParam('plano_id');
//DEL  
//DEL  	if( !empty( $planoId ) ) {
//DEL  
//DEL  		// hago global el record para poder sacar el ID del depto.
//DEL  		global $planos;
//DEL  		$deptoId = $planos->ds->f('tipo_depto_parc_id');
//DEL  		
//DEL  		// crea el link/evento Javascript
//DEL  		$lnk = "tc_addOrigen.php?dpto_id=" . $deptoId ."&plano_id=" . $planoId;
//DEL  		$w = '700';
//DEL  		$h = '600';
//DEL  		$newlnk="$lnk\" onclick=\"javascript:window.open(this.href,'','width=$w,height=$h,top='+(screen.height-$h)/2+',left='+(screen.width-$w)/2+',scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=yes');return false;";
//DEL  
//DEL  		$Component->SeleccionarParcela->SetLink($newlnk);
//DEL  
//DEL  	}
//DEL  
//DEL  
//DEL  
//DEL  // -------------------------

//DEL  // -------------------------
//DEL  
//DEL  
//DEL  	$db = new clsDBtdf_nuevo();
//DEL  
//DEL  	// obtenemos el ID de la parcela
//DEL  	$parcela_id = $Component->parcela_id->GetValue('parcelas_parcela_id');
//DEL  
//DEL  
//DEL  	/* Obtiene la plancheta
//DEL  	-------------------------------------------------------------- */
//DEL  	if ( !empty( $parcela_id ) ) {
//DEL  		$plancheta = obtenerPlancheta( $parcela_id, $db, '/planchetas/archivos/', 35 );
//DEL  		$Component->htm->SetValue( $plancheta );
//DEL  	}
//DEL  	
//DEL  
//DEL  	/* Calcula el Nro. de plano para mostrar en la fila
//DEL  	-------------------------------------------------------------- */
//DEL  
//DEL  	if ( !empty( $parcela_id ) ) {
//DEL  		// busco los datos del plano
//DEL  		$nro_plano = obtenerPlano( false, $parcela_id, false, $db );
//DEL  
//DEL  		if ( !empty( $nro_plano ) ) {
//DEL  			// si lo obtengo seteo el valor en el label
//DEL  			$Component->plano->SetValue( $nro_plano );
//DEL  		}
//DEL  	}
//DEL  
//DEL  
//DEL  	$db->close();
//DEL  
//DEL  
//DEL  // -------------------------

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

//Custom Code @619-2A29BDB7
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
		$plancheta = obtenerPlancheta( $parcela_id, $db, '/planchetas/archivos/', 35 );
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
		$Component->ImageLink2->Visible = false;
		$Component->link_edit_exist->Visible = true;
		$Component->LinkRemove->Visible = true;


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
		$Component->ImageLink2->Visible = true;
		$Component->link_edit_exist->Visible = false;
		$Component->LinkRemove->Visible = true;

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

	// si es plano SVC NO muestra nunca la opción de seleccionar parcelas, sòlo permite crear
	// Nota: NO QUEDA CLARO SI ESTA VERIFICACIÒN HAY QUE HACERLA PARA EL CASO DE LA EDICIÒN, se deshabilita por el momento
	/*if ( $isPlanoSVC ) {
		$Component->SeleccionarParcela->Visible = false;
	}*/

	$db->close();


// -------------------------
//End Custom Code

//Close parcelas_destino_prov_BeforeShow @86-A904F9F8
    return $parcelas_destino_prov_BeforeShow;
}
//End Close parcelas_destino_prov_BeforeShow

//DEL  // -------------------------
//DEL  
//DEL  	global $planos;
//DEL  
//DEL  	$db = new clsDBtdf_nuevo();
//DEL  	$planoEstado = $planos->ds->f('tipo_estado_plano_id'); //debug( $planoEstado );
//DEL  	$planoId = CCGetParam('plano_id');
//DEL  
//DEL  
//DEL  	// obtenemos el ID de la parcela dependiendo de si se seleccionó o creó
//DEL  	$parcela_id = $Component->ds->f('parcela_id');
//DEL  
//DEL  
//DEL  	if ( !empty( $parcela_id ) ) {
//DEL  
//DEL  		// si existe el ID de la parcela es que la parcela fue seleccionada
//DEL  
//DEL  		/* Obtiene la plancheta
//DEL  		-------------------------------------------------------------- */
//DEL  		$plancheta = obtenerPlancheta( $parcela_id, $db, '/planchetas/archivos/', 35 );
//DEL  		$Component->htm->SetValue( $plancheta );
//DEL  
//DEL  
//DEL  		/* Calcula el Nro. de plano para mostrar en la fila
//DEL  		-------------------------------------------------------------- */
//DEL  		$parcelaPlano = CCDLookUp('plano_id', 'uniones_desgloses', 'parcela_destino_id = ' . $parcela_id, $db );
//DEL  
//DEL  		// busco los datos del plano
//DEL  		if ( $parcelaPlano == $planoId ) {
//DEL  			$Component->plano->SetValue( '(plano actual)' );
//DEL  		} else {
//DEL  			$nro_plano = obtenerPlano( false, $parcela_id, false, $db );
//DEL  			if ( !empty( $nro_plano ) ) {
//DEL  				// si lo obtengo seteo el valor en el label
//DEL  				$Component->plano->SetValue( $nro_plano );
//DEL  			}
//DEL  		}
//DEL  
//DEL  		/* Oculta  el botón de editar, muestra el de quitar
//DEL  		-------------------------------------------------------------- */
//DEL  		// dependiendo del estado determina si se aplican las reglas de mostrar acciones
//DEL  		if ( in_array( $planoEstado, array( 5 ) ) ) {
//DEL  			$Component->ImageLink2->Visible = false;
//DEL  			$Component->LinkRemove->Visible = true;
//DEL  		} else {
//DEL  			$Component->ImageLink2->Visible = false;
//DEL  			$Component->LinkRemove->Visible = false;
//DEL  		}
//DEL  
//DEL  
//DEL  	} else {
//DEL  
//DEL  		// si no existe el ID es una parcela creada manualmente (y prov.)
//DEL  
//DEL  		// setea la fuente
//DEL  		$Component->fuente->SetValue('Por crearse');
//DEL  
//DEL  		// pongo en los labels los valores que en este caso vienen de la tabla provisoria
//DEL  		$Component->parcela_seccion->SetValue( $Component->ds->f('planos_prov_seccion') );
//DEL  		$Component->parcela_chacra->SetValue( $Component->ds->f('planos_prov_chacra') );
//DEL  		$Component->parcela_quinta->SetValue( $Component->ds->f('planos_prov_quinta') );
//DEL  		$Component->parcela_macizo->SetValue( $Component->ds->f('planos_prov_macizo') );
//DEL  		$Component->parcela_fraccion->SetValue( $Component->ds->f('planos_prov_fraccion') );
//DEL  		$Component->parcela_parcela->SetValue( $Component->ds->f('planos_prov_parcela') );
//DEL  		$Component->parcela_uf->SetValue( $Component->ds->f('planos_prov_uf') );
//DEL  		$Component->parcela_predio->SetValue( $Component->ds->f('planos_prov_predio') );
//DEL  		$Component->parcela_rte->SetValue( $Component->ds->f('planos_prov_rte') );
//DEL  
//DEL  		// no muestra nada para plano ni plancheta
//DEL  		$Component->plano->SetValue('');
//DEL  		$Component->htm->SetValue('');
//DEL  
//DEL  
//DEL  		/* -- Oculta  el botón de quitar, muestra el de editar */
//DEL  		// dependiendo del estado determina si se aplican las reglas de mostrar acciones
//DEL  		if ( in_array( $planoEstado, array( 5 ) ) ) {
//DEL  			$Component->ImageLink2->Visible = true;
//DEL  			$Component->LinkRemove->Visible = false;
//DEL  		} else {
//DEL  			$Component->ImageLink2->Visible = false;
//DEL  			$Component->LinkRemove->Visible = false;
//DEL  		}
//DEL  
//DEL  
//DEL  	}
//DEL  
//DEL  
//DEL  	$db->close();
//DEL  
//DEL  
//DEL  // -------------------------

//DEL  // -------------------------
//DEL  
//DEL  
//DEL  
//DEL  // -------------------------

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

//parcelas_origen_prov_plano_BeforeShow @349-69BC6542
function parcelas_origen_prov_plano_BeforeShow(& $sender)
{
    $parcelas_origen_prov_plano_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_origen_prov; //Compatibility
//End parcelas_origen_prov_plano_BeforeShow

//Custom Code @620-2A29BDB7
// -------------------------
    // Plano en fila		
	$db = new clsDBtdf_nuevo();
	$planoId = $_GET["plano_id"];
	$tmp_plano = CCDLookUp("tmp_plano","planos","plano_id = $planoId",$db);
	//echo $planoId;exit;
	if ( !empty( $planoId ) ) {
		$nro_plano = obtenerPlano( $planoId, false, false, $db );
	}

	$parcelas_origen_prov->plano->SetValue( $nro_plano );
	$db->close();
// -------------------------
//End Custom Code

//Close parcelas_origen_prov_plano_BeforeShow @349-7C03B4AE
    return $parcelas_origen_prov_plano_BeforeShow;
}
//End Close parcelas_origen_prov_plano_BeforeShow

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
		$plancheta = obtenerPlancheta( $parcela_id, $db, '/planchetas/archivos/', 35 );
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

//Page_BeforeShow @1-4ECB4857
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tc_planosEdicion; //Compatibility
//End Page_BeforeShow

//Custom Code @210-2A29BDB7
// -------------------------


	$db = new clsDBtdf_nuevo();

	/* Determina visibilidad de componentes al cargar la página
	-------------------------------------------------------------- */
	$paramPlanoId = CCGetParam('plano_id', false);	
	$planoEdicion = CCDLookUp('plano_en_edicion', 'planos', 'plano_id = ' . $paramPlanoId, $db);
	$isPlanoEdicion = ( !empty($planoEdicion) ) ? true : false;



	// si no existe el ID  o el plano NO está en edición redirecciona
	if( empty( $paramPlanoId ) || empty( $isPlanoEdicion ) ) {

		// redireccionar al edit de plano
		header('Location: ' . RelativePath . '/tecnica/tc_planosGrid.php');
		die();

	// si existe el ID (modo edit)
	} else {

		/* De acuerdo al estado mostrar los distintos grids y botones */


	}


// -------------------------
//End Custom Code

//Close Page_BeforeShow @1-4BC230CD
    return $Page_BeforeShow;
}
//End Close Page_BeforeShow

//Page_BeforeInitialize @1-6F4B02AF
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tc_planosEdicion; //Compatibility
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