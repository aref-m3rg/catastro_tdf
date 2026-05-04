<?php
//BindEvents Method @1-BDE6C07A
function BindEvents()
{
    global $piezas;
    $piezas->ds->CCSEvents["AfterExecuteInsert"] = "piezas_ds_AfterExecuteInsert";
}
//End BindEvents Method

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
				pieza_destinatario = '" . $Component->pieza_iniciador->GetValue() . "',
				pieza_of_destinatario = '" . $Component->pieza_of_destinatario->GetValue() . "',
				pieza_autor = '" . $Component->pieza_autor->GetValue() . "',               
				pieza_iniciador = '" . $Component->pieza_iniciador->GetValue() . "',      
				pieza_descripcion = '" . $Component->pieza_descripcion->GetValue() . "',      
				pieza_observaciones = '" . $Component->pieza_observaciones->GetValue() . "',
				pieza_f_alta = NOW(),  
				unidad_id = $unidad_id,
				tramite_id = " . $Component->tramite_id->GetValue() . ",
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
	$Redirect = "sys_newPieza.php?pieza_id=" . $pieza_id;


// -------------------------
//End Custom Code

//Close piezas_ds_AfterExecuteInsert @2-1BACBED6
    return $piezas_ds_AfterExecuteInsert;
}
//End Close piezas_ds_AfterExecuteInsert


?>
