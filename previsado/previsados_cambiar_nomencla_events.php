<?php

//BindEvents Method @1-3FF821DF
function BindEvents()
{
    global $previsados_parcelas_desti;
    global $CCSEvents;
    $previsados_parcelas_desti->CCSEvents["BeforeShow"] = "previsados_parcelas_desti_BeforeShow";
    $previsados_parcelas_desti->CCSEvents["BeforeUpdate"] = "previsados_parcelas_desti_BeforeUpdate";
}
//End BindEvents Method

//previsados_parcelas_desti_BeforeShow @6-A5276A9C
function previsados_parcelas_desti_BeforeShow(& $sender)
{
    $previsados_parcelas_desti_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_parcelas_desti; //Compatibility
//End previsados_parcelas_desti_BeforeShow

//Custom Code @37-2A29BDB7
// -------------------------
    $previsados_parcelas_desti->tipo_depto_parc_id_2->SetValue($previsados_parcelas_desti->tipo_depto_parc_id->GetValue());
	$previsados_parcelas_desti->parcela_seccion_2->SetValue($previsados_parcelas_desti->parcela_seccion->GetValue());
	$previsados_parcelas_desti->parcela_chacra_2->SetValue($previsados_parcelas_desti->parcela_chacra->GetValue());
	$previsados_parcelas_desti->parcela_quinta_2->SetValue($previsados_parcelas_desti->parcela_quinta->GetValue());
	$previsados_parcelas_desti->parcela_macizo_2->SetValue($previsados_parcelas_desti->parcela_macizo->GetValue());
	$previsados_parcelas_desti->parcela_fraccion_2->SetValue($previsados_parcelas_desti->parcela_fraccion->GetValue());
	$previsados_parcelas_desti->parcela_parcela_2->SetValue($previsados_parcelas_desti->parcela_parcela->GetValue());
	$previsados_parcelas_desti->parcela_uf_2->SetValue($previsados_parcelas_desti->parcela_uf->GetValue());
	$previsados_parcelas_desti->parcela_super_mensura_2->SetValue($previsados_parcelas_desti->parcela_super_mensura->GetValue());
	$previsados_parcelas_desti->unidades_medidas_id_2->SetValue($previsados_parcelas_desti->unidades_medidas_id->GetValue());
	$previsados_parcelas_desti->parcela_super_uf_2->SetValue($previsados_parcelas_desti->parcela_super_uf->GetValue());
	$previsados_parcelas_desti->unidades_medidas_uf_id_2->SetValue($previsados_parcelas_desti->unidades_medidas_uf_id->GetValue());
// -------------------------
//End Custom Code

//Close previsados_parcelas_desti_BeforeShow @6-4EF307AA
    return $previsados_parcelas_desti_BeforeShow;
}
//End Close previsados_parcelas_desti_BeforeShow

//previsados_parcelas_desti_BeforeUpdate @6-5C1CAFD8
function previsados_parcelas_desti_BeforeUpdate(& $sender)
{
    $previsados_parcelas_desti_BeforeUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_parcelas_desti; //Compatibility
//End previsados_parcelas_desti_BeforeUpdate

//Custom Code @38-2A29BDB7
// -------------------------
	$cambio = FALSE;

    if($previsados_parcelas_desti->tipo_depto_parc_id_2->GetValue() != $previsados_parcelas_desti->tipo_depto_parc_id->GetValue()) $cambio = TRUE;
	if($previsados_parcelas_desti->parcela_seccion_2->GetValue() != $previsados_parcelas_desti->parcela_seccion->GetValue()) $cambio = TRUE;
	if($previsados_parcelas_desti->parcela_chacra_2->GetValue() != $previsados_parcelas_desti->parcela_chacra->GetValue()) $cambio = TRUE;
	if($previsados_parcelas_desti->parcela_quinta_2->GetValue() != $previsados_parcelas_desti->parcela_quinta->GetValue()) $cambio = TRUE;
	if($previsados_parcelas_desti->parcela_macizo_2->GetValue() != $previsados_parcelas_desti->parcela_macizo->GetValue()) $cambio = TRUE;
	if($previsados_parcelas_desti->parcela_fraccion_2->GetValue() != $previsados_parcelas_desti->parcela_fraccion->GetValue()) $cambio = TRUE;
	if($previsados_parcelas_desti->parcela_parcela_2->GetValue() != $previsados_parcelas_desti->parcela_parcela->GetValue()) $cambio = TRUE;
	if($previsados_parcelas_desti->parcela_uf_2->GetValue() != $previsados_parcelas_desti->parcela_uf->GetValue()) $cambio = TRUE;
	if($previsados_parcelas_desti->parcela_super_mensura_2->GetValue() != $previsados_parcelas_desti->parcela_super_mensura->GetValue()) $cambio = TRUE;
	if($previsados_parcelas_desti->unidades_medidas_id_2->GetValue() != $previsados_parcelas_desti->unidades_medidas_id->GetValue()) $cambio = TRUE;
	if($previsados_parcelas_desti->parcela_super_uf_2->GetValue() != $previsados_parcelas_desti->parcela_super_uf->GetValue()) $cambio = TRUE;
	if($previsados_parcelas_desti->unidades_medidas_uf_id_2->GetValue() != $previsados_parcelas_desti->unidades_medidas_uf_id->GetValue()) $cambio = TRUE;

	if($cambio){
		$db = new clsDBtdf_nuevo();
		$previsado_parcela_destino_id = CCGetParam('previsado_parcela_destino_id');
		$INSERT = "INSERT INTO previsados_parcelas_destinos
							(parcela_id, 
								tipo_depto_parc_id, 
								parcela_seccion, 
								parcela_chacra, 
								parcela_quinta, 
								parcela_macizo, 
								parcela_fraccion, 
								parcela_parcela, 
								parcela_super_mensura, 
								unidades_medidas_id, 
								parcela_uf, 
								parcela_super_uf, 
								unidades_medidas_uf_id, 
								previsado_carga_id, 
								previsado_parcela_destino_reemplazo_id)
							(SELECT bper.parcela_id,
									bper.tipo_depto_parc_id,
									bper.parcela_seccion,
									bper.parcela_chacra,
									bper.parcela_quinta,
									bper.parcela_macizo,
									bper.parcela_fraccion,
									bper.parcela_parcela,
									bper.parcela_super_mensura,
									bper.unidades_medidas_id,
									bper.parcela_uf,
									bper.parcela_super_uf,
									bper.unidades_medidas_uf_id,
									bper.previsado_carga_id,
									bper.previsado_parcela_destino_id 
							FROM  previsados_parcelas_destinos as bper 
							WHERE bper.previsado_parcela_destino_id = $previsado_parcela_destino_id)";
		$db->query($INSERT);

		$tipo_depto_parc_id = $previsados_parcelas_desti->tipo_depto_parc_id->GetValue();
		$parcela_seccion = $previsados_parcelas_desti->parcela_seccion->GetValue();
		$parcela_chacra = $previsados_parcelas_desti->parcela_chacra->GetValue();
		$parcela_quinta = $previsados_parcelas_desti->parcela_quinta->GetValue();
		$parcela_macizo = $previsados_parcelas_desti->parcela_macizo->GetValue();
		$parcela_fraccion = $previsados_parcelas_desti->parcela_fraccion->GetValue();
		$parcela_parcela = $previsados_parcelas_desti->parcela_parcela->GetValue();
		$parcela_uf = $previsados_parcelas_desti->parcela_uf->GetValue();
		$SQL="SELECT parcela_id FROM parcelas WHERE 
					tipo_depto_parc_id='$tipo_depto_parc_id' AND 
					parcela_seccion='$parcela_seccion' AND 
					parcela_chacra='$parcela_chacra' AND 
					parcela_quinta='$parcela_quinta' AND 
					parcela_macizo='$parcela_macizo' AND 
					parcela_fraccion='$parcela_fraccion' AND 
					parcela_parcela='$parcela_parcela' AND 
					parcela_uf='$parcela_uf'
					ORDER BY parcela_partida DESC LIMIT 1";
		
		$db->query($SQL);
		if($db->next_record()){
			$previsados_parcelas_desti->parcela_id->SetValue($db->f('parcela_id'));
		}
		$db->close();
	}
// -------------------------
//End Custom Code

//Close previsados_parcelas_desti_BeforeUpdate @6-5F288C19
    return $previsados_parcelas_desti_BeforeUpdate;
}
//End Close previsados_parcelas_desti_BeforeUpdate

//Page_BeforeInitialize @1-F7F08D87
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_cambiar_nomencla; //Compatibility
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
