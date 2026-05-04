<?php
//BindEvents Method @1-558ED2E4
function BindEvents()
{
    global $piezas_piezas_tipos_trami;
    global $NewRecord1;
    $piezas_piezas_tipos_trami->CCSEvents["BeforeShowRow"] = "piezas_piezas_tipos_trami_BeforeShowRow";
    $NewRecord1->ctomos->CCSEvents["OnValidate"] = "NewRecord1_ctomos_OnValidate";
    $NewRecord1->Button_DoSearch->CCSEvents["OnClick"] = "NewRecord1_Button_DoSearch_OnClick";
}
//End BindEvents Method

//piezas_piezas_tipos_trami_BeforeShowRow @2-D0B61AF7
function piezas_piezas_tipos_trami_BeforeShowRow(& $sender)
{
    $piezas_piezas_tipos_trami_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $piezas_piezas_tipos_trami; //Compatibility
//End piezas_piezas_tipos_trami_BeforeShowRow

//Custom Code @23-2A29BDB7
// -------------------------
    // Write your own code here.
	$db = new clsDBmesa();
	$wh = "pieza_nro = " . $Component->ds->f('pieza_nro');
	$wh .= " AND pieza_letra = '" . $Component->ds->f('pieza_letra') . "'";
	$wh .= " AND pieza_anio = '" . $Component->ds->f('pieza_anio') . "'";
	
	$tomos = CCDLookUp('COUNT(*)','piezas',$wh,$db);

	$Component->tomos->SetValue($tomos);

// -------------------------
//End Custom Code

//Close piezas_piezas_tipos_trami_BeforeShowRow @2-9DE4BE72
    return $piezas_piezas_tipos_trami_BeforeShowRow;
}
//End Close piezas_piezas_tipos_trami_BeforeShowRow

//NewRecord1_ctomos_OnValidate @48-F4EB4096
function NewRecord1_ctomos_OnValidate(& $sender)
{
    $NewRecord1_ctomos_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $NewRecord1; //Compatibility
//End NewRecord1_ctomos_OnValidate

//Validate Minimum Value @61-398B894C
    global $CCSLocales;
    if (CCStrLen($Container->ctomos->GetText()) && $Container->ctomos->GetValue() < 1) {
        $Container->ctomos->Errors->addError("Como minimo tiene que crear 1 tomo");
    }
//End Validate Minimum Value

//Close NewRecord1_ctomos_OnValidate @48-E6CB69BB
    return $NewRecord1_ctomos_OnValidate;
}
//End Close NewRecord1_ctomos_OnValidate

//NewRecord1_Button_DoSearch_OnClick @50-BA75D1BA
function NewRecord1_Button_DoSearch_OnClick(& $sender)
{
    $NewRecord1_Button_DoSearch_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $NewRecord1; //Compatibility
//End NewRecord1_Button_DoSearch_OnClick

//Custom Code @56-2A29BDB7
// -------------------------
    // Write your own code here.
	global $Redirect;
	$db = new clsDBmesa();
	$db2 = new clsDBmesa();
	$ctomos = $Container->ctomos->GetValue();
	$unidad_id = CCGetSession('unidad_id');//unidad actual
	$usuario_id = CCGetUserID();
	$login = CCGetUserLogin();

	$SQL = "SELECT * FROM piezas WHERE pieza_id = " . CCGetParam('pieza_id');
	$db->query($SQL);
	if($db->next_record()){
		$wh = "pieza_nro = " . $db->f('pieza_nro');
		$wh .= " AND pieza_letra = '" . $db->f('pieza_letra') . "'";
		$wh .= " AND pieza_anio = '" . $db->f('pieza_anio') . "'";
		$tmos = CCDLookUp('MAX(pieza_tm_nro)','piezas', $wh,$db2);
		for($i = $tmos ; $i < ($tmos + $ctomos) ; $i++){

			$SQL_i = "INSERT INTO piezas 
					  SET pieza_tipo_id = '" . $db->f('pieza_tipo_id') . "',
							pieza_nro = '" . $db->f('pieza_nro') . "',
							pieza_letra = '" . $db->f('pieza_letra') . "',
							pieza_anio= '" . $db->f('pieza_anio') . "',
							pieza_cp_nro = '0',
							pieza_tm_nro = '" . ($i + 1) . "',
							pieza_iniciador = '" . $db->f('pieza_iniciador') . "',
							pieza_descripcion = '" . $db->f('pieza_descripcion') . "',
							pieza_observaciones = '" . $db->f('pieza_observaciones') . "',
							pieza_f_alta = '" . $db->f('pieza_f_alta') . "',
							pieza_ref = '" . $db->f('pieza_ref') . "',
							pieza_txt = '" . $db->f('pieza_txt') . "',
							pieza_destinatario = '" . $db->f('pieza_destinatario') . "',
							pieza_of_destinatario = '" . $db->f('pieza_of_destinatario') . "',
							pieza_autor = '" . $db->f('pieza_autor') . "',
							unidad_id = '" . $db->f('unidad_id') . "',
							tramite_id = '" . $db->f('tramite_id') . "',
							entorno_id = '" . $db->f('entorno_id') . "',
							estado_id = '" . $db->f('estado_id') . "',
							pieza_archivada = '" . $db->f('pieza_archivada') . "',
							pieza_archivo = '" . $db->f('pieza_archivo') .  "'";
		
			//echo $SQL_i;exit();
			$db2->query($SQL_i);

			$pieza_id = mysql_insert_id();
		
			$INS_PASE = "INSERT INTO pases SET
						pieza_id = $pieza_id,
						pase_nro = 1,
						ori_unidad_id = $unidad_id,
						des_unidad_id = $unidad_id,
						pase_comentario = 'Creación Tomo',
						pase_n_fojas = 1,
						pase_f_pase = NOW(),
						pase_f_confirma = NOW(),
						pase_confirmado = 1,
						pase_activo = 1,
						ori_usuario_id = $usuario_id,
						des_usuario_id = $usuario_id,
						pase_receptor = '$login'";

			$db2->query($INS_PASE);	
		}
	}

	$Redirect = "msa_newTomo.php?refresh=1&pieza_id=" . CCGetParam('pieza_id');


// -------------------------
//End Custom Code

//Close NewRecord1_Button_DoSearch_OnClick @50-5B2559D8
    return $NewRecord1_Button_DoSearch_OnClick;
}
//End Close NewRecord1_Button_DoSearch_OnClick


?>
