<?php
//BindEvents Method @1-D26EAD82
function BindEvents()
{
    global $parcelas_unidades_medida1;
    global $parcelas_unidades_medida;
    global $CCSEvents;
    $parcelas_unidades_medida1->ds->CCSEvents["AfterExecuteDelete"] = "parcelas_unidades_medida1_ds_AfterExecuteDelete";
    $parcelas_unidades_medida1->CCSEvents["BeforeShowRow"] = "parcelas_unidades_medida1_BeforeShowRow";
    $parcelas_unidades_medida1->ds->CCSEvents["BeforeBuildSelect"] = "parcelas_unidades_medida1_ds_BeforeBuildSelect";
    $parcelas_unidades_medida->s_parcela_macizo->CCSEvents["BeforeShow"] = "parcelas_unidades_medida_s_parcela_macizo_BeforeShow";
    $parcelas_unidades_medida->CCSEvents["BeforeShow"] = "parcelas_unidades_medida_BeforeShow";
}
//End BindEvents Method

//parcelas_unidades_medida1_ds_AfterExecuteDelete @2-195A8121
function parcelas_unidades_medida1_ds_AfterExecuteDelete(& $sender)
{
    $parcelas_unidades_medida1_ds_AfterExecuteDelete = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_unidades_medida1; //Compatibility
//End parcelas_unidades_medida1_ds_AfterExecuteDelete

//Custom Code @76-2A29BDB7
// -------------------------


	/* Inserta las parcelas provisorias en la tabla correspondiente
	---------------------------------------------------------------- */

	$parcela_id = $Component->parcela_id->GetValue();
	$plano_id = CCGetParam( 'plano_id' );

	if ( !empty( $parcela_id ) && !empty( $plano_id ) ) {

		$db = new clsDBtdf_nuevo();

		// chequear que la parcela ya no esté relacionada
		$existe = CCDLookUp( 'planos_prov_id', 'planos_parc_prov', 'plano_id = ' . mysql_real_escape_string( $plano_id ) . ' AND parcela_id = ' . mysql_real_escape_string( $parcela_id ), $db );

		if ( empty( $existe ) ) {
			$SQL = "INSERT INTO planos_parc_prov
				SET parcela_id = " . mysql_real_escape_string( $parcela_id ) . ",
				plano_id = " . mysql_real_escape_string( $plano_id ) . ",
				planos_parc_prov_tipo = 'destino',
				tipo_estado_id = 1";
			// die($SQL);exit();
			$db->query( $SQL );
		}

	}


// -------------------------
//End Custom Code

//Close parcelas_unidades_medida1_ds_AfterExecuteDelete @2-D136F9E0
    return $parcelas_unidades_medida1_ds_AfterExecuteDelete;
}
//End Close parcelas_unidades_medida1_ds_AfterExecuteDelete

//parcelas_unidades_medida1_BeforeShowRow @2-D27CCFDD
function parcelas_unidades_medida1_BeforeShowRow(& $sender)
{
    $parcelas_unidades_medida1_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_unidades_medida1; //Compatibility
//End parcelas_unidades_medida1_BeforeShowRow

//Custom Code @103-2A29BDB7
// -------------------------

	$db = new clsDBtdf_nuevo();

	// obtenemos el ID de la parcela
	$parcela_id = $Component->ds->f('parcelas_parcela_id');


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

//Close parcelas_unidades_medida1_BeforeShowRow @2-0FFBFE81
    return $parcelas_unidades_medida1_BeforeShowRow;
}
//End Close parcelas_unidades_medida1_BeforeShowRow

//parcelas_unidades_medida1_ds_BeforeBuildSelect @2-C0DA000D
function parcelas_unidades_medida1_ds_BeforeBuildSelect(& $sender)
{
    $parcelas_unidades_medida1_ds_BeforeBuildSelect = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_unidades_medida1; //Compatibility
//End parcelas_unidades_medida1_ds_BeforeBuildSelect

//Custom Code @154-2A29BDB7
// -------------------------

	$db = new clsDBtdf_nuevo();

    /* Si el plano está marcado como los planos en trámite con parcelas en tràmite
	   que se migraron permite agregar parcelas en trámite
	------------------------------------------------------------------------------------ */
	$plano_id = CCGetParam('plano_id');

	if ( !empty( $plano_id ) ) {
		// obtenemos el estado del plano
		$plano_tramite_mig = CCDLookUp('plano_tramite_mig', 'planos', 'plano_id = ' . mysql_real_escape_string($plano_id), $db);
		// si el plano está marcado se agrega la condición de que las parcelas puedan ser en tràmite		
		if ( !empty($plano_tramite_mig ) ){
			$Component->DataSource->Where = str_replace('AND parcelas.tipo_est_parc_id = 1', 'AND ( parcelas.tipo_est_parc_id = 1 OR parcelas.tipo_est_parc_id = 3 )', $Component->DataSource->Where );
		}
	}

	$db->close();

// -------------------------
//End Custom Code

//Close parcelas_unidades_medida1_ds_BeforeBuildSelect @2-0BEFB790
    return $parcelas_unidades_medida1_ds_BeforeBuildSelect;
}
//End Close parcelas_unidades_medida1_ds_BeforeBuildSelect

//parcelas_unidades_medida_s_parcela_macizo_BeforeShow @24-D83FC493
function parcelas_unidades_medida_s_parcela_macizo_BeforeShow(& $sender)
{
    $parcelas_unidades_medida_s_parcela_macizo_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_unidades_medida; //Compatibility
//End parcelas_unidades_medida_s_parcela_macizo_BeforeShow

//Close parcelas_unidades_medida_s_parcela_macizo_BeforeShow @24-FAC7EABB
    return $parcelas_unidades_medida_s_parcela_macizo_BeforeShow;
}
//End Close parcelas_unidades_medida_s_parcela_macizo_BeforeShow

//parcelas_unidades_medida_BeforeShow @21-9417C3E5
function parcelas_unidades_medida_BeforeShow(& $sender)
{
    $parcelas_unidades_medida_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_unidades_medida; //Compatibility
//End parcelas_unidades_medida_BeforeShow

//Custom Code @67-2A29BDB7
// -------------------------


    // Write your own code here. (esto demuestra lo útil que es no comentar las cosas)
	$Component->Button_DoSearch->Visible = false;


	/* Guarda en la Sesión el ID del departamento para las consultas AJAX
	   de los listbox dependientes */
	$deptoId = CCGetParam('dpto_id');
	CCSetSession( 'addOrigen_dpto_id', $deptoId );


// -------------------------
//End Custom Code

//Close parcelas_unidades_medida_BeforeShow @21-10412C82
    return $parcelas_unidades_medida_BeforeShow;
}
//End Close parcelas_unidades_medida_BeforeShow

//Page_BeforeInitialize @1-C818C7E4
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tc_addDestino; //Compatibility
//End Page_BeforeInitialize

//Custom Code @153-2A29BDB7
// -------------------------

	// Incluye el archivo de funciones generales
	include_once(RelativePath . "/scripts/myFunctions.php");


	// Incluye la gestión de permisos
	include_once(RelativePath . "/scripts/permisos1.php");


	// Incluye el archivo de configuraciones generales
	include_once( RelativePath . '/configuracion_general.php' );


// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
