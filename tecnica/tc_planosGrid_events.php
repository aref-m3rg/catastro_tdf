<?php
//BindEvents Method @1-B895111D
function BindEvents()
{
    global $departamentos_planos_plan1;
    global $planos_listado;
    global $CCSEvents;
    $departamentos_planos_plan1->s_prof_id->CCSEvents["BeforeShow"] = "departamentos_planos_plan1_s_prof_id_BeforeShow";
    $planos_listado->planos_listado_TotalRecords->CCSEvents["BeforeShow"] = "planos_listado_planos_listado_TotalRecords_BeforeShow";
    $planos_listado->ds->CCSEvents["AfterExecuteSelect"] = "planos_listado_ds_AfterExecuteSelect";
    $planos_listado->ds->CCSEvents["BeforeExecuteSelect"] = "planos_listado_ds_BeforeExecuteSelect";
    $planos_listado->CCSEvents["BeforeShowRow"] = "planos_listado_BeforeShowRow";
}
//End BindEvents Method

//DEL  // -------------------------
//DEL  
//DEL      // Arma las condiciones para el query
//DEL  
//DEL  	$pasa = false;
//DEL  	$wh = " 1 ";
//DEL  
//DEL  	if( $Component->ds->f('dpto_id') ){
//DEL  		$wh .= " AND dpto_id = '" . $Component->ds->f('dpto_id') . "'";
//DEL  	}
//DEL  
//DEL  	if($Component->ds->f('parcela_seccion')){
//DEL  		$wh .= " AND plancheta_scc = '" . $Component->ds->f('parcela_seccion') . "'";
//DEL  		$pasa = true;
//DEL  	}
//DEL  
//DEL  	if($Component->ds->f('parcela_macizo')){
//DEL  		$wh .= " AND plancheta_mzo = '" . $Component->ds->f('parcela_macizo') . "'";
//DEL  		$pasa = true;
//DEL  	}
//DEL  
//DEL  	if($Component->ds->f('parcela_parcela')){			
//DEL  			$wh .= " AND ( (TRIM(LEADING '0' FROM plancheta_par) = '" . $Component->ds->f('parcela_parcela') . "') OR (IFNULL(TRIM(LEADING '0' FROM plancheta_par),'')= ''))";
//DEL  			$pasa = true;
//DEL  	}
//DEL  
//DEL  	if($Component->ds->f('parcela_chacra')){
//DEL  		$wh .= " AND plancheta_cha = '" . $Component->ds->f('parcela_chacra') . "'";
//DEL  		$pasa = true;
//DEL  	}
//DEL  
//DEL  	if($Component->ds->f('parcela_quinta')){
//DEL  		$wh .= " AND plancheta_qta = '" . $Component->ds->f('parcela_quinta') . "'";
//DEL  		$pasa = true;
//DEL  	}
//DEL  
//DEL  	if( $pasa ){
//DEL  	
//DEL  		$db = new clsDBtdf_nuevo();
//DEL  	
//DEL  		$img = CCDLookUp('plancheta_file','planchetas',$wh . ' LIMIT 1',$db);
//DEL  		$plancheta_id = CCDLookUp('plancheta_id','planchetas',$wh . ' LIMIT 1',$db);
//DEL  		if($img){
//DEL  			$htm = '<a class="" target="plancheta" href="' . RelativePath . '/reportes/rpt_plancheta.php?plancheta_id=' . $plancheta_id . '"><img border="0" class=""  src="' . RelativePath . '/phpThumb/phpThumb.php?src=/planchetas/archivos/' . $img . '&h=40"></a>';
//DEL  		
//DEL  		} else {
//DEL  			$htm = '-';
//DEL  		} 
//DEL  	} else {
//DEL  		$htm = '-';
//DEL      }
//DEL  	
//DEL  	$Component->htm->SetValue($htm);
//DEL  
//DEL  // -------------------------

//DEL  // -------------------------
//DEL  
//DEL      // Después de ejecutar la búsqueda actualiza la cantidad de registros
//DEL  //	$db = new clsDBtdf_nuevo();
//DEL  //	$SQL = str_replace('{SQL_OrderBy}','', str_replace('{SQL_Where}', " WHERE " . $Component->ds->Where, $Component->ds->SQL));
//DEL  	// print_r( $SQL );
//DEL  //	$records = mysql_num_rows( $db->query($SQL) );
//DEL  //	$Component->ds->RecordsCount = $records;
//DEL  //	$db->close();
//DEL  
//DEL  	//echo $SQL;
//DEL  // -------------------------

//departamentos_planos_plan1_s_prof_id_BeforeShow @61-279E22A7
function departamentos_planos_plan1_s_prof_id_BeforeShow(& $sender)
{
    $departamentos_planos_plan1_s_prof_id_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $departamentos_planos_plan1; //Compatibility
//End departamentos_planos_plan1_s_prof_id_BeforeShow

//Close departamentos_planos_plan1_s_prof_id_BeforeShow @61-8EDE1863
    return $departamentos_planos_plan1_s_prof_id_BeforeShow;
}
//End Close departamentos_planos_plan1_s_prof_id_BeforeShow

//planos_listado_planos_listado_TotalRecords_BeforeShow @426-0AFF673E
function planos_listado_planos_listado_TotalRecords_BeforeShow(& $sender)
{
    $planos_listado_planos_listado_TotalRecords_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planos_listado; //Compatibility
//End planos_listado_planos_listado_TotalRecords_BeforeShow

//Retrieve number of records @427-ABE656B4
    $Component->SetValue($Container->DataSource->RecordsCount);
//End Retrieve number of records

//Close planos_listado_planos_listado_TotalRecords_BeforeShow @426-B720CB4A
    return $planos_listado_planos_listado_TotalRecords_BeforeShow;
}
//End Close planos_listado_planos_listado_TotalRecords_BeforeShow

//planos_listado_ds_AfterExecuteSelect @352-695BF983
function planos_listado_ds_AfterExecuteSelect(& $sender)
{
    $planos_listado_ds_AfterExecuteSelect = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planos_listado; //Compatibility
//End planos_listado_ds_AfterExecuteSelect

//Custom Code @445-2A29BDB7
// -------------------------


    /* Realiza de nuevo el query sin el límite por página para poder
	 * contar los registros totales (una cagada pero no hay otra
	 * forma en CCS! ) 
	------------------------------------------------------------------ */

	$db = new clsDBtdf_nuevo();
	$SQL = str_replace('{SQL_OrderBy}','', str_replace('{SQL_Where}', " WHERE " . $Component->ds->Where, $Component->ds->SQL));
	$numRecords = mysql_num_rows( $db->query($SQL) );
	$Component->ds->RecordsCount = $numRecords;
	$db->close();


// -------------------------
//End Custom Code

//Close planos_listado_ds_AfterExecuteSelect @352-67C06BF0
    return $planos_listado_ds_AfterExecuteSelect;
}
//End Close planos_listado_ds_AfterExecuteSelect

//planos_listado_ds_BeforeExecuteSelect @352-9F0E0618
function planos_listado_ds_BeforeExecuteSelect(& $sender)
{
    $planos_listado_ds_BeforeExecuteSelect = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planos_listado; //Compatibility
//End planos_listado_ds_BeforeExecuteSelect

//Custom Code @446-2A29BDB7
// -------------------------


    /* Modifica el query de acuerdo a los parametros de búsqueda 
	------------------------------------------------------------------ */

	// toma los parámetros que puedan llegar por GET o POST
	$s_dpto_id = CCGetParam('s_dpto_id', false);
	$s_plano_nro = CCGetParam('s_plano_nro', false);
	$s_plano_anio = CCGetParam('s_plano_anio', false);
	$s_prof_id = CCGetParam('s_prof_id', false);
	$s_persona_denominacion = CCGetParam('s_persona_denominacion', false);
	$s_persona_nro_doc = CCGetParam('s_persona_nro_doc', false);
	$s_tipo_estado_plano_id = CCGetParam('s_tipo_estado_plano_id', false);
	$s_tipo_plano_id = CCGetParam('s_tipo_plano_id', false);
	$s_plano_e_nro = CCGetParam('s_plano_e_nro', false);
	$s_plano_e_letra = CCGetParam('s_plano_e_letra', false);
	$s_plano_e_anio = CCGetParam('s_plano_e_anio', false);
	$s_parcela_seccion = CCGetParam('s_parcela_seccion', false);
	$s_parcela_chacra = CCGetParam('s_parcela_chacra', false);
	$s_parcela_quinta = CCGetParam('s_parcela_quinta', false);
	$s_parcela_macizo = CCGetParam('s_parcela_macizo', false);
	$s_parcela_fraccion = CCGetParam('s_parcela_fraccion', false);
	$s_parcela_parcela = CCGetParam('s_parcela_parcela', false);
	$s_parcela_uf = CCGetParam('s_parcela_uf', false);

	$where = '( 1 = 1 ) ';

	// si los parametros tienen contenido agrega la condición al query
	if ( !empty( $s_dpto_id ) ) : $where .= ' AND planos.tipo_depto_parc_id = ' . $s_dpto_id; endif;
	
	if ( !empty( $s_plano_nro ) ) : $where .= ' AND planos.plano_nro = ' . $s_plano_nro; endif;
	if ( !empty( $s_plano_anio ) ) : $where .= ' AND planos.plano_anio = ' . $s_plano_anio; endif;

	if ( !empty( $s_prof_id ) ) :
		$where .= ' AND ( planos.profesional_id = ' . $s_prof_id . ' OR planos.profesional_id_2 = ' . $s_prof_id . ')';
	endif;

	if ( !empty( $s_persona_denominacion ) ) : $where .= ' AND ( persona_denominacion_destino LIKE "%' . mysql_real_escape_string( $s_persona_denominacion ) . '%" OR persona_denominacion_origen LIKE "%' . mysql_real_escape_string($s_persona_denominacion) . '%" )'; endif;
	if ( !empty( $s_persona_nro_doc ) ) : $where .= ' AND ( persona_nro_doc_destino = ' . $s_persona_nro_doc . ' OR persona_nro_doc_origen = ' . $s_persona_nro_doc . ' )'; endif;

	if ( !empty( $s_tipo_estado_plano_id ) ) : $where .= ' AND planos.tipo_estado_plano_id = ' . $s_tipo_estado_plano_id; endif;
	if ( !empty( $s_tipo_plano_id ) ) : $where .= ' AND planos.tipo_plano_id = ' . $s_tipo_plano_id; endif;
	if ( !empty( $s_plano_e_nro ) ) : $where .= ' AND planos.plano_e_nro = ' . $s_plano_e_nro; endif;
	if ( !empty( $s_plano_e_letra ) ) : $where .= ' AND planos.plano_e_letra = "' . $s_plano_e_letra . '"'; endif;
	if ( !empty( $s_plano_e_anio ) ) : $where .= ' AND planos.plano_e_anio = ' . $s_plano_e_anio; endif;

	if ( !empty( $s_parcela_seccion ) ) :
		$where .= ' AND ( parcelas_destino.parcela_seccion = "' . $s_parcela_seccion . '" OR parcelas_origen.parcela_seccion = "' . $s_parcela_seccion . '" )';
	endif;

	if ( !empty( $s_parcela_chacra ) ) :
		$where .= ' AND ( parcelas_destino.parcela_chacra = "' . $s_parcela_chacra . '" OR parcelas_origen.parcela_chacra = "' . $s_parcela_chacra . '" )';
	endif;

	if ( !empty( $s_parcela_quinta ) ) :
		$where .= ' AND ( parcelas_destino.parcela_quinta = "' . $s_parcela_quinta . '" OR parcelas_origen.parcela_quinta = "' . $s_parcela_quinta . '" )';
	endif;

	if ( !empty( $s_parcela_macizo ) ) :
		$where .= ' AND ( parcelas_destino.parcela_macizo = "' . $s_parcela_macizo . '" OR parcelas_origen.parcela_macizo = "' . $s_parcela_macizo . '" )';
	endif;

	if ( !empty( $s_parcela_fraccion ) ) :
		$where .= ' AND ( parcelas_destino.parcela_fraccion = "' . $s_parcela_fraccion . '" OR parcelas_origen.parcela_fraccion = "' . $s_parcela_fraccion . '" )';
	endif;

	if ( !empty( $s_parcela_parcela ) ) :
		$where .= ' AND ( parcelas_destino.parcela_parcela = "' . $s_parcela_parcela . '" OR parcelas_origen.parcela_parcela = "' . $s_parcela_parcela . '" )';
	endif;

	if ( !empty( $s_parcela_uf ) ) :
		$where .= ' AND ( parcelas_destino.parcela_uf = "' . $s_parcela_uf . '" OR parcelas_origen.parcela_uf = "' . $s_parcela_uf . '" )';
	endif;


    // Reemplaza el Datasource para hacer la búsqueda
	// IMPORTANTE: el 'count' debe reemplazarse manualmente en el evento AfterExecuteSelect
	// ya que al agrupar CCS no saca bien las cuentas
	if(trim($where) == "( 1 = 1 )"){
		$where = " ( 1 = 2 ) ";
	}
	$planos_listado->DataSource->Where = $where." GROUP BY planos.plano_id ";
	$planos_listado->DataSource->SQL = str_replace('{SQL_OrderBy}', '{SQL_Where} {SQL_OrderBy}', $planos_listado->DataSource->SQL);
	//debug( $planos_listado->DataSource->SQL );
	//debug( $where );


// -------------------------
//End Custom Code

//Close planos_listado_ds_BeforeExecuteSelect @352-6F21EE27
    return $planos_listado_ds_BeforeExecuteSelect;
}
//End Close planos_listado_ds_BeforeExecuteSelect

//planos_listado_BeforeShowRow @352-C2320500
function planos_listado_BeforeShowRow(& $sender)
{
    $planos_listado_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planos_listado; //Compatibility
//End planos_listado_BeforeShowRow

//Custom Code @447-2A29BDB7
// -------------------------

	$db = new clsDBtdf_nuevo();

	// obtenemos el ID de la parcela
	$parcela_id = $Component->ds->f('parcela_id');


	/* Obtiene la plancheta
	-------------------------------------------------------------- */
	if ( !empty( $parcela_id ) ) {
		$plancheta = '';
		$plancheta = obtenerPlancheta( $parcela_id, $db, '/planchetas/archivos/', 35 );
		$Component->html_plancheta->SetValue( $plancheta );
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

	/* De acuerdo a si es P.O. o P.D. setea los valores de los campos a mostrar
	------------------------------------------------------------------------------ */
	//if () {
	//} else {
	//}

	/* De acuerdo al tipo de parcela (sistema, provisoria sel, provisoria crear)
	------------------------------------------------------------------------------ */
	$planos_prov_id_creadas = $Component->ds->f('planos_prov_id_creadas');
	$planos_prov_id_sel = $Component->ds->f('planos_prov_id_sel');

 	if ( !empty( $parcela_id ) ) {
		// si es parcela de destino definitiva
		$Component->tipo_parcela->SetValue('Sistema');
	} else if ( !empty($planos_prov_id_creadas) ) {
		// si es parcela provisoria a crear
		$Component->tipo_parcela->SetValue('Provisoria');
		$Component->parcela_seccion->SetValue($Component->ds->f('planos_prov_seccion'));
		$Component->parcela_chacra->SetValue($Component->ds->f('planos_prov_chacra'));
		$Component->parcela_quinta->SetValue($Component->ds->f('planos_prov_quinta'));
		$Component->parcela_macizo->SetValue($Component->ds->f('planos_prov_macizo'));
		$Component->parcela_fraccion->SetValue($Component->ds->f('planos_prov_fraccion'));
		$Component->parcela_parcela->SetValue($Component->ds->f('planos_prov_parcela'));
		$Component->parcela_uf->SetValue($Component->ds->f('planos_prov_uf'));
	} else if ( !empty($planos_prov_id_sel) ) {
		// si es parcela provisoria seleccionada
		$Component->tipo_parcela->SetValue('Provisoria');
		$Component->parcela_seccion->SetValue($Component->ds->f('parcela_seccion_sel'));
		$Component->parcela_chacra->SetValue($Component->ds->f('parcela_chacra_sel'));
		$Component->parcela_quinta->SetValue($Component->ds->f('parcela_quinta_sel'));
		$Component->parcela_macizo->SetValue($Component->ds->f('parcela_macizo_sel'));
		$Component->parcela_fraccion->SetValue($Component->ds->f('parcela_fraccion_sel'));
		$Component->parcela_parcela->SetValue($Component->ds->f('parcela_parcela_sel'));
		$Component->parcela_uf->SetValue($Component->ds->f('parcela_uf_sel'));
	}


// -------------------------
//End Custom Code

//Close planos_listado_BeforeShowRow @352-8EC14F2F
    return $planos_listado_BeforeShowRow;
}
//End Close planos_listado_BeforeShowRow

//Page_BeforeInitialize @1-812429AF
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tc_planosGrid; //Compatibility
//End Page_BeforeInitialize

//Custom Code @459-2A29BDB7
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
