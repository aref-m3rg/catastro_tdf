<?php
	define("RelativePath", "..");
	include(RelativePath . "/Common.php");
	$delete = $_GET["del"];
	$usuario = CCGetUserID();
	$db = new clsDBtdf_nuevo();
	$db2 = new clsDBtdf_nuevo();
	
	//echo 1;exit;
	// Truncar tabla
	if($delete == 1){
		$SQL = "DELETE FROM parcelas_masivas WHERE usuario_id = '$usuario';";
		$db->query( $SQL );
	}else{		
		// Insertar en tabla planos_parc_prov el listado en parcelas_masivas
		$SQL2 = "SELECT * FROM parcelas_masivas WHERE usuario_id = '$usuario';";
		$db->query( $SQL2 );
		while($db->next_record()){
			$SQL3 = "INSERT INTO planos_parc_prov (plano_id, planos_parc_prov_tipo, tipo_estado_id, tipo_depto_parc_id, planos_prov_seccion, planos_prov_macizo, planos_prov_parcela, planos_prov_chacra, planos_prov_quinta, planos_prov_fraccion, planos_prov_uf, planos_prov_predio, planos_prov_rte, planos_prov_super_mensura, unidades_medidas_id, planos_prov_sup_uf, planos_prov_porc_uf, parcela_clasificacion_id, tipo_padron_parc_id ) 
			VALUES ('".$db->f('plano_id')."', 2, 1, '".$db->f('tipo_depto_parc_id')."', '".$db->f('parcela_seccion')."', '".$db->f('parcela_macizo')."', '".$db->f('parcela_parcela')."', '".$db->f('parcela_chacra')."', '".$db->f('parcela_quinta')."', '".$db->f('parcela_fraccion')."', '', '', '', '".$db->f('parcela_super_mensura')."', '".$db->f('unidades_medidas_id')."', '', '', '', '".$db->f('tipo_padron_parc_id')."')";
			$db2->query( $SQL3 );
		}
		$SQL4 = "DELETE FROM parcelas_masivas WHERE usuario_id = '$usuario';";
		$db2->query( $SQL4 );		
	}
	
	$db->close();
	$db2->close();
?>

