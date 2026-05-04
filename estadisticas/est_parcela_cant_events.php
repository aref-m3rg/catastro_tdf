<?php

//BindEvents Method @1-3EEF1B78
function BindEvents()
{
    global $parcelasSearch;
    global $parcelas;
    global $CCSEvents;
    $parcelasSearch->s_persona_denominacion->CCSEvents["BeforeShow"] = "parcelasSearch_s_persona_denominacion_BeforeShow";
    $parcelasSearch->s_plano_nro->CCSEvents["BeforeShow"] = "parcelasSearch_s_plano_nro_BeforeShow";
    $parcelasSearch->s_plano_anio->CCSEvents["BeforeShow"] = "parcelasSearch_s_plano_anio_BeforeShow";
    $parcelasSearch->CCSEvents["OnValidate"] = "parcelasSearch_OnValidate";
    $parcelas->toXls->CCSEvents["BeforeShow"] = "parcelas_toXls_BeforeShow";
    $parcelas->ds->CCSEvents["AfterExecuteSelect"] = "parcelas_ds_AfterExecuteSelect";
    $parcelas->ds->CCSEvents["BeforeExecuteSelect"] = "parcelas_ds_BeforeExecuteSelect";
    $parcelas->CCSEvents["BeforeShow"] = "parcelas_BeforeShow";
}
//End BindEvents Method

//parcelasSearch_s_persona_denominacion_BeforeShow @323-4198CF46
function parcelasSearch_s_persona_denominacion_BeforeShow(& $sender)
{
    $parcelasSearch_s_persona_denominacion_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelasSearch; //Compatibility
//End parcelasSearch_s_persona_denominacion_BeforeShow

//PTAutocomplete1 BeforeShow @339-D0AD39E2
    $Component->Attributes->SetValue('id', 'parcelasSearchs_persona_denominacion');
//End PTAutocomplete1 BeforeShow

//Close parcelasSearch_s_persona_denominacion_BeforeShow @323-D9BA5659
    return $parcelasSearch_s_persona_denominacion_BeforeShow;
}
//End Close parcelasSearch_s_persona_denominacion_BeforeShow

//parcelasSearch_s_plano_nro_BeforeShow @368-97295081
function parcelasSearch_s_plano_nro_BeforeShow(& $sender)
{
    $parcelasSearch_s_plano_nro_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelasSearch; //Compatibility
//End parcelasSearch_s_plano_nro_BeforeShow

//PTAutocomplete2 BeforeShow @372-83783941
    $Component->Attributes->SetValue('id', 'parcelasSearchs_plano_nro');
//End PTAutocomplete2 BeforeShow

//Close parcelasSearch_s_plano_nro_BeforeShow @368-49B087F3
    return $parcelasSearch_s_plano_nro_BeforeShow;
}
//End Close parcelasSearch_s_plano_nro_BeforeShow

//parcelasSearch_s_plano_anio_BeforeShow @369-AEA9F981
function parcelasSearch_s_plano_anio_BeforeShow(& $sender)
{
    $parcelasSearch_s_plano_anio_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelasSearch; //Compatibility
//End parcelasSearch_s_plano_anio_BeforeShow

//PTAutocomplete3 BeforeShow @374-43876534
    $Component->Attributes->SetValue('id', 'parcelasSearchs_plano_anio');
//End PTAutocomplete3 BeforeShow

//Close parcelasSearch_s_plano_anio_BeforeShow @369-5A44C3A5
    return $parcelasSearch_s_plano_anio_BeforeShow;
}
//End Close parcelasSearch_s_plano_anio_BeforeShow

//parcelasSearch_OnValidate @7-7E58F250
function parcelasSearch_OnValidate(& $sender)
{
    $parcelasSearch_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelasSearch; //Compatibility
//End parcelasSearch_OnValidate

//Custom Code @318-2A29BDB7
// -------------------------
    if($parcelasSearch->s_tipo_est_parc_id->GetValue() == "" && $parcelasSearch->s_tipo_parcela_id->GetValue() == "" && $parcelasSearch->s_tipo_parcela_uso_id->GetValue() == "" && $parcelasSearch->s_tipo_instrumento_id->GetValue() == "" && $parcelasSearch->s_persona_parcela_num_int->GetValue() == "" && $parcelasSearch->sup_min->GetValue() == "" && $parcelasSearch->sup_max->GetValue() == "" && $parcelasSearch->s_tipo_depto_parc_id->GetValue() == "" && $parcelasSearch->s_tipo_padron_parc_id->GetValue() == "" && $parcelasSearch->s_parcela_seccion->GetValue() == "" && $parcelasSearch->s_parcela_macizo->GetValue() == "" && $parcelasSearch->s_parcela_parcela->GetValue() == "" && $parcelasSearch->s_parcela_chacra->GetValue() == "" && $parcelasSearch->s_parcela_quinta->GetValue() == "" && $parcelasSearch->s_parcela_fraccion->GetValue() == "" && $parcelasSearch->s_parcela_uf->GetValue() == "" && $parcelasSearch->s_parcela_predio->GetValue() == "" && $parcelasSearch->s_parcela_rte->GetValue() == "" && $parcelasSearch->s_tipo_restricc_parcela_id->GetValue() == ""  && $parcelasSearch->s_persona_denominacion->GetValue() == ""  && $parcelasSearch->s_tipo_plano_id->GetValue() == ""  && $parcelasSearch->s_plano_nro->GetValue() == ""  && $parcelasSearch->s_plano_anio->GetValue() == ""  && $parcelasSearch->s_tipos_estados_planos->GetValue() == ""){
		$parcelasSearch->Errors->addError("Complete campos para realizar la consulta, no se permite busqueda general total");
	}
// -------------------------
//End Custom Code

//Close parcelasSearch_OnValidate @7-3B696427
    return $parcelasSearch_OnValidate;
}
//End Close parcelasSearch_OnValidate

//parcelas_toXls_BeforeShow @264-06E4CE62
function parcelas_toXls_BeforeShow(& $sender)
{
    $parcelas_toXls_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas; //Compatibility
//End parcelas_toXls_BeforeShow

//Close parcelas_toXls_BeforeShow @264-FA0007EB
    return $parcelas_toXls_BeforeShow;
}
//End Close parcelas_toXls_BeforeShow

//parcelas_ds_AfterExecuteSelect @27-30A38EAE
function parcelas_ds_AfterExecuteSelect(& $sender)
{
    $parcelas_ds_AfterExecuteSelect = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas; //Compatibility
//End parcelas_ds_AfterExecuteSelect

//Custom Code @266-2A29BDB7
// -------------------------

		if($Component->DataSource->Where){
			$q = $Component->DataSource->SQL . " WHERE " . $Component->DataSource->Where;
		}else{
			$q = $Component->DataSource->SQL;
		}

		$q = $q . " ORDER BY " . $Component->DataSource->Order;

		$col = array (
		  'tipo_est_parc_descr'=>'Estado',
		  'tipo_depto_parc_abrev'=>'Departamento',
		  'tipo_padron_parc_abrev'=>'Padron',
		  'parcela_partida'=>'Nº Partida',
		  'parcela_seccion'=>'Seccion',
		  'parcela_chacra'=>'Chacra',
		  'parcela_quinta'=>'Quinta',
		  'parcela_macizo'=>'Macizo',
		  'parcela_fraccion'=>'Fraccion',
		  'parcela_parcela'=>'Parcela',
		  'parcela_uf'=>'U.F./U.C.',
		  'parcela_predio'=>'Predio',
		  'parcela_rte'=>'Rte.',
		  'tipo_parcela_uso_descrip'=>'Uso',
		  'parcela_super_mensura'=>'Superficie',
		  'unidades_medidas_abrev'=>'Uni. Medida',
		  'parcela_val_tierra'=>'Valor Tierra',
		  'parcela_val_mejora'=>'Valor Mejora',
		  'parcela_val_ampliac'=>'Valor Ampliacion',
		  'parcela_val_total'=>'Valor Total',
		  'tipo_uso_suelo_id'=>'Uso Rural',
		  'parcela_receptividad'=>'Receptividad',
		  'parcela_obs_rural'=>'Observaciones Rural',
		  'parcela_dist_pto'=>'Distancia a Puerto',
		  'parcela_porc_uf'=>'% UF/UC',
		  'parcela_sup_uf'=>'Superficie UF/UC',
		  'tipo_restricc_parcela_id'=>'Tipo de Restriciones',
		  'parcela_restr'=>'Restricciones',
		  'parcela_observa'=>'Observaciones Parcela',
		  'parcela_notas_nom'=>'Notas en Sol. Nomenclatura',
		  'tipo_instrumento_abrev'=>'Tipo de Instrumento',
		  'persona_parcela_num_int'=>'Instrumento',
		  'plano'=>'Nro de Plano',
		  'tipo_plano_abrev'=>'Tipo de Plano',
		  'tipo_estado_plano_abrev'=>'Estado del Plano',
		  'plano_exp'=>'Expediente',
		  'plano_f_alta'=>'F. Alta Plano',
		  'plano_observa'=>'Observaciones Plano',
		  'plano_disposicion'=>'Disposicion Plano',
		  'persona_denominacion'=>'Titular',
		  'tipo_documento_abrev'=>'Tipo Doc',
		  'persona_nro_doc'=>'Nro Documento',
		  'persona_conyuge'=>'Figura Legal',
		  'persona_conyuge'=>'Conyuge',
		  'persona_parcela_dominio'=>'Dominio');

		CCSetSession('qryXls',$q);
		CCSetSession('colXls',$col);
		CCSetSession('nameXls',"Consulta de Parcelas");

		$db = new clsDBtdf_nuevo();
		$db2 = new clsDBtdf_nuevo();
		$where='';
		if($parcelas->DataSource->Where != ''){
			$where='WHERE '.$parcelas->DataSource->Where;
		}
		$select="SELECT parcelas.parcela_super_mensura, parcelas.parcela_sup_uf, parcelas.parcela_val_ampliac, parcelas.parcela_val_mejora, parcelas.parcela_val_tierra, parcelas.parcela_val_total, parcelas.unidades_medidas_id, unidades_medidas.unidades_medidas_metros";
		$from="FROM parcelas 
				LEFT JOIN tipos_parcelas_usos ON parcelas.tipo_parcela_uso_id = tipos_parcelas_usos.tipo_parcela_uso_id
				LEFT JOIN tipos_estados_parcela ON parcelas.tipo_est_parc_id = tipos_estados_parcela.tipo_est_parc_id
				LEFT JOIN tipos_deptos_parcela ON parcelas.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id
				LEFT JOIN tipos_padrones_parcela ON parcelas.tipo_padron_parc_id = tipos_padrones_parcela.tipo_padron_parc_id
				LEFT JOIN tipos_parcelas ON parcelas.tipo_parcela_id = tipos_parcelas.tipo_parcela_id
				LEFT JOIN parcelas_tipos_restricc ON parcelas_tipos_restricc.parcela_id = parcelas.parcela_id
				LEFT JOIN personas_parcelas ON personas_parcelas.parcela_id = parcelas.parcela_id
				LEFT JOIN personas ON personas_parcelas.persona_id = personas.persona_id
				LEFT JOIN unidades_medidas ON parcelas.unidades_medidas_id = unidades_medidas.unidades_medidas_id
				LEFT JOIN uniones_desgloses ON parcelas.parcela_id = uniones_desgloses.parcela_destino_id
				LEFT JOIN planos ON uniones_desgloses.plano_id = planos.plano_id";

		$SQL="$select 
				$from 	
				$where";

		$suma_sup=0.0;//cambiar segun tipo de unidad
		$suma_sup_uf=0.0;
		$suma_val_amp=0.0;
		$suma_val_mej=0.0;
		$suma_val_tie=0.0;
		$suma_val_tot=0.0;

		$db->query($SQL);
		$contador=0;
		while($db->next_record()){
			$suma_sup+=($db->f('parcela_super_mensura')*$db->f('unidades_medidas_metros'));
			$suma_sup_uf+=$db->f('parcela_sup_uf');
			$suma_val_amp+=$db->f('parcela_val_ampliac');
			$suma_val_mej+=$db->f('parcela_val_mejora');
			$suma_val_tie+=$db->f('parcela_val_tierra');
			$suma_val_tot+=$db->f('parcela_val_total');
			$contador++;
		}

		$parcelas->super_mensura->SetValue($suma_sup);
		$parcelas->super_uf->SetValue($suma_sup_uf);
		$parcelas->sum_val_amp->SetValue($suma_val_amp);
		$parcelas->sum_val_tot->SetValue($suma_val_tot);
		$parcelas->sum_val_tierra->SetValue($suma_val_tie);
		$parcelas->sum_val_mejora->SetValue($suma_val_mej);
		$parcelas->contador->SetValue($contador);

		CCSetSession('suma_sup',$suma_sup);
		CCSetSession('suma_sup_uf',$suma_sup_uf);
		CCSetSession('suma_val_amp',$suma_val_amp);
		CCSetSession('suma_val_tot',$suma_val_tot);
		CCSetSession('suma_val_tie',$suma_val_tie);
		CCSetSession('suma_val_mej',$suma_val_mej);

		$db->close();
		$db2->close();
// -------------------------
//End Custom Code

//Close parcelas_ds_AfterExecuteSelect @27-7FC1A8C2
    return $parcelas_ds_AfterExecuteSelect;
}
//End Close parcelas_ds_AfterExecuteSelect

//parcelas_ds_BeforeExecuteSelect @27-E126DE58
function parcelas_ds_BeforeExecuteSelect(& $sender)
{
    $parcelas_ds_BeforeExecuteSelect = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas; //Compatibility
//End parcelas_ds_BeforeExecuteSelect

//Custom Code @316-2A29BDB7
// -------------------------
	//echo $Component->ds->Where;exit;

		$SELECT = "SELECT IF( plano_nro, CONCAT('T.F. ', CONCAT_WS('-', planos.tipo_depto_parc_id, CONCAT(tipo_plano_abrev, plano_nro ), RIGHT( plano_anio, 2 ) ) ), IFNULL( tmp_plano, 'Sin Mensura') ) AS plano,
					tipo_depto_parc_desc, tipo_depto_parc_abrev, tipo_padron_parc_desc, tipo_padron_parc_abrev, 
					tipos_deptos_parcela.tipo_depto_parc_id AS tipos_deptos_parcela_tipo_depto_parc_id, parcelas.parcela_id AS parcelas_parcela_id,
					tipo_restricc_parcela_desc, unidades_medidas_abrev, unidades_medidas_htm, 
					tipo_parcela_uso_abrev, tipo_plano_abrev, tipo_estado_plano_abrev, CONCAT_WS('-',plano_e_nro,plano_e_letra,plano_e_anio) AS plano_exp, plano_f_alta,
					plano_f_inicio, plano_f_entrada, plano_f_salida, plano_f_archivo, plano_f_visado, plano_observa, plano_disposicion, planos.plano_id AS plano_id,
					tipo_uso_suelo_id, parcelas_tipos_restricc.tipo_restricc_parcela_id, tipo_parcela_uso_descrip, tipo_parcela_uso_abrev, tipo_est_parc_descr, 
					tipo_est_parc_abrev, tipo_parcela_descrip, tipo_parcela_abrev, tipo_instrumento_abrev, 
					parcelas.*, (parcelas.parcela_seccion) AS parcela_seccion, tipo_est_parc_abrev, persona_denominacion, persona_conyuge, persona_nro_doc, tipo_documento_abrev, tipo_persona_parcela_descrip, personas_parcelas.*, gis_srv_name ";
		$FROM = "   parcelas
					LEFT JOIN personas_parcelas ON parcelas.parcela_id = personas_parcelas.parcela_id
					LEFT JOIN personas ON personas_parcelas.persona_id = personas.persona_id
					LEFT JOIN unidades_medidas ON parcelas.unidades_medidas_id = unidades_medidas.unidades_medidas_id
					LEFT JOIN parcelas_usos_suelo ON parcelas.parcela_id = parcelas_usos_suelo.parcela_id
					LEFT JOIN parcelas_tipos_restricc ON parcelas.parcela_id = parcelas_tipos_restricc.parcela_id					
					LEFT JOIN uniones_desgloses ON parcelas.parcela_id = uniones_desgloses.parcela_destino_id
					LEFT JOIN planos ON planos.plano_id = uniones_desgloses.plano_id
					LEFT JOIN tipos_instrumentos ON personas_parcelas.tipo_instrumento_id = tipos_instrumentos.tipo_instrumento_id
					LEFT JOIN tipos_personas_parcelas ON tipos_personas_parcelas.tipo_persona_parcela_id = personas_parcelas.tipo_persona_parcela_id
					LEFT JOIN tipos_documentos ON personas.tipo_documento_id = tipos_documentos.tipo_documento_id
					LEFT JOIN tipos_deptos_parcela ON parcelas.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id
					LEFT JOIN tipos_padrones_parcela ON parcelas.tipo_padron_parc_id = tipos_padrones_parcela.tipo_padron_parc_id
					LEFT JOIN tipos_parcelas ON parcelas.tipo_parcela_id = tipos_parcelas.tipo_parcela_id
					LEFT JOIN tipos_parcelas_usos ON parcelas.tipo_parcela_uso_id = tipos_parcelas_usos.tipo_parcela_uso_id
					LEFT JOIN tipos_estados_parcela ON parcelas.tipo_est_parc_id = tipos_estados_parcela.tipo_est_parc_id
					LEFT JOIN tipos_restricc_parcela ON parcelas_tipos_restricc.tipo_restricc_parcela_id = tipos_restricc_parcela.tipo_restricc_parcela_id
					LEFT JOIN tipos_planos ON planos.tipo_plano_id = tipos_planos.tipo_plano_id
					LEFT JOIN tipos_estados_planos ON planos.tipo_estado_plano_id = tipos_estados_planos.tipo_estado_plano_id
					LEFT JOIN gis_servicios ON parcelas.tipo_padron_parc_id = gis_servicios.padron_id 
					AND IF(parcela_seccion = 'T',3,parcelas.tipo_depto_parc_id) = gis_servicios.dpto_id";
	
		$Component->ds->SQL = $SELECT .  " FROM " .$FROM;
		$Component->ds->CountSQL = "SELECT COUNT(*) FROM" . $FROM; 

		if(CCGetParam(parcela_uso_rural)){
			//$uso = implode(",",CCGetParam(parcela_uso_rural));
			//echo $uso;
			$i = 0;
			$u = CCGetParam(parcela_uso_rural);
			$wh = " (";
			//echo "<pre>";print_r($u);
			foreach($u as $uso){
				if($i!=0){$wh.= " OR ";};
				$wh .= " (FIND_IN_SET('" . $uso . "' , parcela_uso_rural) > 0) ";
				$i++;
			}

			$wh .= " )";
		
			if($Component->ds->Where){
				$Component->ds->Where .= " AND " . $wh;
			}else{
				$Component->ds->Where = $wh;
			}
		}
		
		if(CCGetParam('base') == 1){
			$Component->ds->Where .= " GROUP BY personas_parcelas.parcela_id ";
		}elseif(CCGetParam('base') == 2){
			$Component->ds->Where .= " GROUP BY personas_parcelas.persona_id ";
		}elseif(CCGetParam('base') == 3){
			//$Component->ds->Where .= " ";
			$Component->ds->Where .= " GROUP BY personas_parcelas.parcela_id, personas_parcelas.persona_id ";
		}

   	if (CCGetParam('s_tipo_est_parc_id') == '' && CCGetParam('s_tipo_parcela_id') == '' && CCGetParam('s_tipo_parcela_uso_id') == '' && CCGetParam('s_tipo_instrumento_id') == '' && CCGetParam('s_persona_parcela_num_int') == '' && CCGetParam('sup_min') == '' && CCGetParam('sup_max') == '' && CCGetParam('s_tipo_depto_parc_id') == '' && CCGetParam('s_tipo_padron_parc_id') == '' && CCGetParam('s_parcela_seccion') == '' && CCGetParam('s_parcela_macizo') == '' && CCGetParam('s_parcela_parcela') == '' && CCGetParam('s_parcela_chacra') == '' && CCGetParam('s_parcela_quinta') == '' && CCGetParam('s_parcela_fraccion') == '' && CCGetParam('s_parcela_uf') == '' && CCGetParam('s_parcela_predio') == '' && CCGetParam('s_parcela_rte') == '' && CCGetParam('s_tipo_restricc_parcela_id') == '' && CCGetParam('s_persona_denominacion') == '' && CCGetParam('s_plano_nro') == '' && CCGetParam('s_tipo_plano_id') == '' && CCGetParam('s_plano_anio') == '' && CCGetParam('s_tipos_estados_planos') == ''){
		$Component->ds->Where = "1 < 0";
	}
// -------------------------
//End Custom Code

//Close parcelas_ds_BeforeExecuteSelect @27-A7EEBE64
    return $parcelas_ds_BeforeExecuteSelect;
}
//End Close parcelas_ds_BeforeExecuteSelect

//parcelas_BeforeShow @27-3DB6FDDD
function parcelas_BeforeShow(& $sender)
{
    $parcelas_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas; //Compatibility
//End parcelas_BeforeShow

//Custom Code @319-2A29BDB7
// -------------------------
   	if (CCGetParam('s_tipo_est_parc_id') == '' && CCGetParam('s_tipo_parcela_id') == '' && CCGetParam('s_tipo_parcela_uso_id') == '' && CCGetParam('s_tipo_instrumento_id') == '' && CCGetParam('s_persona_parcela_num_int') == '' && CCGetParam('sup_min') == '' && CCGetParam('sup_max') == '' && CCGetParam('s_tipo_depto_parc_id') == '' && CCGetParam('s_tipo_padron_parc_id') == '' && CCGetParam('s_parcela_seccion') == '' && CCGetParam('s_parcela_macizo') == '' && CCGetParam('s_parcela_parcela') == '' && CCGetParam('s_parcela_chacra') == '' && CCGetParam('s_parcela_quinta') == '' && CCGetParam('s_parcela_fraccion') == '' && CCGetParam('s_parcela_uf') == '' && CCGetParam('s_parcela_predio') == '' && CCGetParam('s_parcela_rte') == '' && CCGetParam('s_tipo_restricc_parcela_id') == '' && CCGetParam('s_persona_denominacion') == '' && CCGetParam('s_plano_nro') == '' && CCGetParam('s_tipo_plano_id') == '' && CCGetParam('s_plano_anio') == '' && CCGetParam('s_tipos_estados_planos') == ''){
		$Component->Visible=false;
	}else{
		$Component->Visible=true;
	}
// -------------------------
//End Custom Code

//Close parcelas_BeforeShow @27-FBF6787B
    return $parcelas_BeforeShow;
}
//End Close parcelas_BeforeShow

//Page_BeforeInitialize @1-9CF223DA
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $est_parcela_cant; //Compatibility
//End Page_BeforeInitialize

//Custom Code @5-2A29BDB7
// -------------------------

	// Incluye el archivo de funciones generales
	include_once(RelativePath . "/scripts/myFunctions.php");


	// Incluye la gestión de permisos
	include_once(RelativePath . "/scripts/permisos1.php");

// -------------------------
//End Custom Code

//PTAutocomplete1 Initialization @339-D336E4DF
    global $Charset;
    if ('parcelasSearchs_persona_denominacionPTAutocomplete1' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new ListFormatter());
//End PTAutocomplete1 Initialization

//PTAutocomplete1 DataSource @339-56918E0F
        $Service->DataSource = new clsDBtdf_nuevo();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM personas {SQL_Where} {SQL_OrderBy}";
        $Service->DataSource->Parameters["posts_persona_denominacion"] = CCGetFromPost("s_persona_denominacion", NULL);
        $Service->DataSource->wp = new clsSQLParameters();
        $Service->DataSource->wp->AddParameter("1", "posts_persona_denominacion", ccsText, "", "", $Service->DataSource->Parameters["posts_persona_denominacion"], -1, false);
        $Service->DataSource->wp->Criterion[1] = $Service->DataSource->wp->Operation(opBeginsWith, "persona_denominacion", $Service->DataSource->wp->GetDBValue("1"), $Service->DataSource->ToSQL($Service->DataSource->wp->GetDBValue("1"), ccsText),false);
        $Service->DataSource->Where = 
             $Service->DataSource->wp->Criterion[1];
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End PTAutocomplete1 DataSource

//PTAutocomplete1 Charset @339-4F7C968C
        $Service->AddHttpHeader("Content-type", "text/html; charset=" . $Charset);
//End PTAutocomplete1 Charset

//PTAutocomplete1 DataFields @339-F1FB86B5
        $Service->AddDataSourceField('persona_denominacion');
//End PTAutocomplete1 DataFields

//PTAutocomplete1 Execution @339-D749E478
        $Service->DisplayHeaders();
        echo $Service->Execute();
//End PTAutocomplete1 Execution

//PTAutocomplete1 Tail @339-27890EF8
        exit;
    }
//End PTAutocomplete1 Tail

//PTAutocomplete2 Initialization @372-AE7A3953
    global $Charset;
    if ('parcelasSearchs_plano_nroPTAutocomplete2' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new ListFormatter());
//End PTAutocomplete2 Initialization

//PTAutocomplete2 DataSource @372-21598B54
        $Service->DataSource = new clsDBtdf_nuevo();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM planos {SQL_Where} {SQL_OrderBy}";
        $Service->DataSource->Parameters["posts_plano_nro"] = CCGetFromPost("s_plano_nro", NULL);
        $Service->DataSource->wp = new clsSQLParameters();
        $Service->DataSource->wp->AddParameter("1", "posts_plano_nro", ccsText, "", "", $Service->DataSource->Parameters["posts_plano_nro"], -1, false);
        $Service->DataSource->wp->Criterion[1] = $Service->DataSource->wp->Operation(opBeginsWith, "plano_nro", $Service->DataSource->wp->GetDBValue("1"), $Service->DataSource->ToSQL($Service->DataSource->wp->GetDBValue("1"), ccsText),false);
        $Service->DataSource->Where = 
             $Service->DataSource->wp->Criterion[1];
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End PTAutocomplete2 DataSource

//PTAutocomplete2 Charset @372-4F7C968C
        $Service->AddHttpHeader("Content-type", "text/html; charset=" . $Charset);
//End PTAutocomplete2 Charset

//PTAutocomplete2 DataFields @372-24784661
        $Service->AddDataSourceField('plano_nro');
//End PTAutocomplete2 DataFields

//PTAutocomplete2 Execution @372-D749E478
        $Service->DisplayHeaders();
        echo $Service->Execute();
//End PTAutocomplete2 Execution

//PTAutocomplete2 Tail @372-27890EF8
        exit;
    }
//End PTAutocomplete2 Tail

//PTAutocomplete3 Initialization @374-AC2F9A33
    global $Charset;
    if ('parcelasSearchs_plano_anioPTAutocomplete3' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new ListFormatter());
//End PTAutocomplete3 Initialization

//PTAutocomplete3 DataSource @374-443476DE
        $Service->DataSource = new clsDBtdf_nuevo();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM planos {SQL_Where} {SQL_OrderBy}";
        $Service->DataSource->Parameters["posts_plano_anio"] = CCGetFromPost("s_plano_anio", NULL);
        $Service->DataSource->wp = new clsSQLParameters();
        $Service->DataSource->wp->AddParameter("1", "posts_plano_anio", ccsText, "", "", $Service->DataSource->Parameters["posts_plano_anio"], -1, false);
        $Service->DataSource->wp->Criterion[1] = $Service->DataSource->wp->Operation(opBeginsWith, "plano_anio", $Service->DataSource->wp->GetDBValue("1"), $Service->DataSource->ToSQL($Service->DataSource->wp->GetDBValue("1"), ccsText),false);
        $Service->DataSource->Where = 
             $Service->DataSource->wp->Criterion[1];
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End PTAutocomplete3 DataSource

//PTAutocomplete3 Charset @374-4F7C968C
        $Service->AddHttpHeader("Content-type", "text/html; charset=" . $Charset);
//End PTAutocomplete3 Charset

//PTAutocomplete3 DataFields @374-784E4583
        $Service->AddDataSourceField('plano_anio');
//End PTAutocomplete3 DataFields

//PTAutocomplete3 Execution @374-D749E478
        $Service->DisplayHeaders();
        echo $Service->Execute();
//End PTAutocomplete3 Execution

//PTAutocomplete3 Tail @374-27890EF8
        exit;
    }
//End PTAutocomplete3 Tail

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize
?>
