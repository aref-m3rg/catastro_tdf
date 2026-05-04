<?php
//BindEvents Method @1-B57C83D1
function BindEvents()
{
  global $piezas;
  global $CCSEvents;
  $piezas->tipo_tramites_id->CCSEvents["BeforeShow"] = "piezas_tipo_tramites_id_BeforeShow";
  $piezas->ds->CCSEvents["AfterExecuteInsert"] = "piezas_ds_AfterExecuteInsert";
}
//End BindEvents Method

//piezas_tipo_tramites_id_BeforeShow @47-6BF115AD
function piezas_tipo_tramites_id_BeforeShow(& $sender)
{
  $piezas_tipo_tramites_id_BeforeShow = true;
  $Component = & $sender;
  $Container = & CCGetParentContainer($sender);
  global $piezas; //Compatibility
//End piezas_tipo_tramites_id_BeforeShow

//Close piezas_tipo_tramites_id_BeforeShow @47-8DA721F4
  return $piezas_tipo_tramites_id_BeforeShow;
}
//End Close piezas_tipo_tramites_id_BeforeShow

//piezas_ds_AfterExecuteInsert @2-679446CB
function piezas_ds_AfterExecuteInsert(& $sender)
{
  $piezas_ds_AfterExecuteInsert = true;
  $Component = & $sender;
  $Container = & CCGetParentContainer($sender);
  global $piezas; //Compatibility
//End piezas_ds_AfterExecuteInsert

//Custom Code @40-2A29BDB7
// -------------------------
    // Write your own code here.
	//crear la pieza con su numero, crear el primer pase activo.
	global $Redirect;

	$db = new clsDBmesa();
	$db2 = new clsDBmesa();

	$pieza_tipo_id = 2;//Nota
	$unidad_id = CCGetSession('unidad_id');//unidad actual
	$usuario_id = CCGetUserID();
	$login = CCGetUserLogin();
	
	$SQL = "SELECT GET_LOCK('numero_nota',3) AS lck";
	$db->query($SQL);
	$db->next_record();

	// si logra bloquear.... 
	if ( $db->f('lck') != 0) {
		//echo CCGetSession(prov_id);

    // trae el ID de trámite de acuerdo al ID de tipo de trámite
    $tramitesData = CCQueryToArray( 'SELECT tipos_tramites.tipo_tramites_id, tramites.tramite_id FROM tipos_tramites INNER JOIN tramites ON tipos_tramites.tramite_id = tramites.tramite_id WHERE tipos_tramites.tipo_tramites_id = ' . mysql_real_escape_string( $Component->tipo_tramites_id->GetValue() ), $db2 );


		$numero = CCDLookUp('IFNULL(MAX(pieza_nro),0)','piezas',"pieza_tipo_id = $pieza_tipo_id AND entorno_id = 1 AND pieza_anio = " . date('Y'),$db2);
		$numero++;
	
		
		$INS_PIEZA = " INSERT INTO piezas SET 
				pieza_tipo_id = $pieza_tipo_id,
				pieza_nro = $numero,
				pieza_anio = DATE_FORMAT(NOW(),'%Y'),
				pieza_cp_nro = 0,
				pieza_tm_nro = 1,
				pieza_ref = '" . $Component->pieza_ref->GetValue() . "',           				
				pieza_txt = '" . $Component->pieza_txt->GetValue() . "',           
				pieza_destinatario = '" . $Component->pieza_destinatario->GetValue() . "',
				pieza_of_destinatario = '" . $Component->pieza_of_destinatario->GetValue() . "',
				pieza_autor = '" . $Component->pieza_autor->GetValue() . "',               
				pieza_iniciador = '" . $Component->pieza_iniciador->GetValue() . "',      
				pieza_descripcion = '" . $Component->pieza_descripcion->GetValue() . "',      
				pieza_observaciones = '" . $Component->pieza_observaciones->GetValue() . "',
				pieza_f_alta = NOW(),  
				unidad_id = $unidad_id,
				tramite_id = " . $tramitesData[0]['tramite_id'] . ",
				tipo_tramites_id = " . $tramitesData[0]['tipo_tramites_id'] . ",
				entorno_id = 1,           
				estado_id = 1";

		$db2->query($INS_PIEZA);
		
		$pieza_id = mysql_insert_id();

		//desbloquear
		$SQL = "SELECT RELEASE_LOCK('numero_nota')";
	    $db->query($SQL);
	    $db->next_record();

		//ahora el primer pase

		$INS_PASE = "INSERT INTO pases SET
					pieza_id = $pieza_id,
					pase_nro = 1,
					ori_unidad_id = $unidad_id,
					des_unidad_id = $unidad_id,
					pase_comentario = 'Creación Pieza',
					pase_n_fojas = 1,
					pase_f_pase = NOW(),
					pase_f_confirma = NOW(),
					pase_confirmado = 1,
					pase_activo = 1,
					ori_usuario_id = $usuario_id,
					des_usuario_id = $usuario_id,
					pase_receptor = '$login'";
		
		$db2->query($INS_PASE);

		//auditar este evento
		include_once(RelativePath . "/scripts/myFunctions.php");
		auditar("piezas",$pieza_id,3);

	}

	$db->close();
	$db2->close();

	//vamos a mostrar la pieza
	$Redirect = "msa_viewPieza.php?pieza_id=" . $pieza_id;





	



// -------------------------
//End Custom Code

//Close piezas_ds_AfterExecuteInsert @2-1BACBED6
  return $piezas_ds_AfterExecuteInsert;
}
//End Close piezas_ds_AfterExecuteInsert

//Page_BeforeInitialize @1-A90520CD
function Page_BeforeInitialize(& $sender)
{
  $Page_BeforeInitialize = true;
  $Component = & $sender;
  $Container = & CCGetParentContainer($sender);
  global $msa_altaNota; //Compatibility
//End Page_BeforeInitialize

//Custom Code @52-2A29BDB7
// -------------------------

	// Incluye el archivo de funciones generales
	include_once(RelativePath . "/scripts/myFunctions.php");

// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
  return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
