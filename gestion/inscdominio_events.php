<?php

//BindEvents Method @1-D5A15FE7
function BindEvents()
{
    global $parcelas;
    global $tmp_dominio;
    global $CCSEvents;
    $parcelas->Button1->CCSEvents["OnClick"] = "parcelas_Button1_OnClick";
    $parcelas->Button_DoSearch->CCSEvents["OnClick"] = "parcelas_Button_DoSearch_OnClick";
    $parcelas->CCSEvents["BeforeShow"] = "parcelas_BeforeShow";
    $parcelas->CCSEvents["OnValidate"] = "parcelas_OnValidate";
    $tmp_dominio->deshacer->CCSEvents["OnClick"] = "tmp_dominio_deshacer_OnClick";
    $tmp_dominio->parcela_partida->CCSEvents["BeforeShow"] = "tmp_dominio_parcela_partida_BeforeShow";
    $tmp_dominio->CCSEvents["BeforeShow"] = "tmp_dominio_BeforeShow";
    $tmp_dominio->CCSEvents["AfterSubmit"] = "tmp_dominio_AfterSubmit";
    $tmp_dominio->CCSEvents["OnValidateRow"] = "tmp_dominio_OnValidateRow";
    $tmp_dominio->CCSEvents["BeforeSubmit"] = "tmp_dominio_BeforeSubmit";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
}
//End BindEvents Method

//parcelas_Button1_OnClick @10-6F9D2F7D
function parcelas_Button1_OnClick(& $sender)
{
    $parcelas_Button1_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas; //Compatibility
//End parcelas_Button1_OnClick

//Custom Code @12-2A29BDB7
// -------------------------
	global $Redirect;
	$Redirect = "recordParcela.php?parcela_id=".CCGetParam('parcela_id');
// -------------------------
//End Custom Code

//Close parcelas_Button1_OnClick @10-9EF0360F
    return $parcelas_Button1_OnClick;
}
//End Close parcelas_Button1_OnClick

//parcelas_Button_DoSearch_OnClick @7-426708C0
function parcelas_Button_DoSearch_OnClick(& $sender)
{
    $parcelas_Button_DoSearch_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas; //Compatibility
//End parcelas_Button_DoSearch_OnClick

//Custom Code @42-2A29BDB7
// -------------------------
	global $Redirect;
	$db = new clsDBtdf_nuevo();
	//inserta los campos en tabla temporal
	for($i=0;$parcelas->cant->GetValue()>$i;$i++){
		$SQL="INSERT INTO tmp_dominio SET 
				parcela_id = ".CCGetParam('parcela_id').",
				tipo_depto_parc_id = ".CCDLookUp("tipo_depto_parc_id","parcelas","parcela_id=".CCGetParam('parcela_id'),$db).", 
				tipo_padron_parc_id = ".CCDLookUp("tipo_padron_parc_id","parcelas","parcela_id=".CCGetParam('parcela_id'),$db).", 
				parcela_seccion = '".CCDLookUp("parcela_seccion","parcelas","parcela_id=".CCGetParam('parcela_id'),$db)."', 
				usuario_id = ".CCGetUserID().", 
				fecha = NOW(),
				cant = ".$parcelas->cant->GetValue();
		$db->query($SQL);
	}
	$db->close();
	$Redirect="inscdominio.php?parcela_id=".CCGetParam('parcela_id');
// -------------------------
//End Custom Code

//Close parcelas_Button_DoSearch_OnClick @7-DDC27BAD
    return $parcelas_Button_DoSearch_OnClick;
}
//End Close parcelas_Button_DoSearch_OnClick

//parcelas_BeforeShow @6-3DB6FDDD
function parcelas_BeforeShow(& $sender)
{
    $parcelas_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas; //Compatibility
//End parcelas_BeforeShow

//Custom Code @11-2A29BDB7
// -------------------------
    $db = new clsDBtdf_nuevo();
	$cant=CCDLookUp("COUNT(*)","tmp_dominio","parcela_id=".CCGetParam('parcela_id'),$db);
	if($cant > 0){
		$parcelas->Visible=false;
	}
	$db->close();
// -------------------------
//End Custom Code

//Close parcelas_BeforeShow @6-FBF6787B
    return $parcelas_BeforeShow;
}
//End Close parcelas_BeforeShow

//parcelas_OnValidate @6-18681923
function parcelas_OnValidate(& $sender)
{
    $parcelas_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas; //Compatibility
//End parcelas_OnValidate

//Custom Code @48-2A29BDB7
// -------------------------
    if($parcelas->cant->GetValue() == 0){
		$parcelas->Errors->addError("Cantidad debe ser mayor o igual a uno");
	}
// -------------------------
//End Custom Code

//Close parcelas_OnValidate @6-C40D1CF2
    return $parcelas_OnValidate;
}
//End Close parcelas_OnValidate

//tmp_dominio_deshacer_OnClick @52-8DCF19A6
function tmp_dominio_deshacer_OnClick(& $sender)
{
    $tmp_dominio_deshacer_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tmp_dominio; //Compatibility
//End tmp_dominio_deshacer_OnClick

//Custom Code @54-2A29BDB7
// -------------------------
	global $Redirect;
    $db = new clsDBtdf_nuevo();
	$SQL="DELETE FROM tmp_dominio WHERE parcela_id = ".CCGetParam('parcela_id');
	$db->query($SQL);
	$db->close();
	$Redirect="inscdominio.php?parcela_id=".CCGetParam('parcela_id');
// -------------------------
//End Custom Code

//Close tmp_dominio_deshacer_OnClick @52-65DE20D6
    return $tmp_dominio_deshacer_OnClick;
}
//End Close tmp_dominio_deshacer_OnClick

//tmp_dominio_parcela_partida_BeforeShow @49-379CD38B
function tmp_dominio_parcela_partida_BeforeShow(& $sender)
{
    $tmp_dominio_parcela_partida_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tmp_dominio; //Compatibility
//End tmp_dominio_parcela_partida_BeforeShow

//Custom Code @98-2A29BDB7
// -------------------------
    $db = new clsDBtdf_nuevo();
	$cant=CCDLookUp("COUNT(*)","tmp_dominio","parcela_id=".CCGetParam('parcela_id'),$db);
	if($cant == 0){
		$tmp_dominio->Visible = false;
	}
	$db->close();    
// -------------------------
//End Custom Code

//Close tmp_dominio_parcela_partida_BeforeShow @49-9E1390EB
    return $tmp_dominio_parcela_partida_BeforeShow;
}
//End Close tmp_dominio_parcela_partida_BeforeShow

//tmp_dominio_BeforeShow @13-7321C5FB
function tmp_dominio_BeforeShow(& $sender)
{
    $tmp_dominio_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tmp_dominio; //Compatibility
//End tmp_dominio_BeforeShow

//Custom Code @46-2A29BDB7
// -------------------------
    $db = new clsDBtdf_nuevo();
	$cant=CCDLookUp("COUNT(*)","tmp_dominio","parcela_id=".CCGetParam('parcela_id'),$db);
	if($cant > 0){
		$Component->Visible=true;
		$SQL="SELECT MIN(parcela_partida) AS parcela_partida,parcela_seccion,cant FROM tmp_dominio WHERE parcela_id = ".CCGetParam('parcela_id')." GROUP BY parcela_partida";
		$db->query($SQL);
		if($db->next_record()){
			$Component->seccion->SetValue($db->f('parcela_seccion'));
			$Component->partida->SetValue($db->f('parcela_partida'));
			$Component->cant->SetValue($db->f('cant'));
		}
	}else{
		$Component->Visible=false;
	}
	if($cant == 1){
		$tmp_dominio->Label1->SetValue("<!--");
		$tmp_dominio->Label2->SetValue("-->");
	}
	$db->close();
// -------------------------
//End Custom Code

//Close tmp_dominio_BeforeShow @13-2D2A86E6
    return $tmp_dominio_BeforeShow;
}
//End Close tmp_dominio_BeforeShow

//tmp_dominio_AfterSubmit @13-7D7DBD0A
function tmp_dominio_AfterSubmit(& $sender)
{
    $tmp_dominio_AfterSubmit = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tmp_dominio; //Compatibility
//End tmp_dominio_AfterSubmit

//Custom Code @47-2A29BDB7
// -------------------------
	$db = new clsDBtdf_nuevo();
	$db2 = new clsDBtdf_nuevo();
	$parcela_id_des = CCGetParam('parcela_id');
	$parcela_partida_des = CCDLookUp("parcela_partida","parcelas","parcela_id=$parcela_id_des",$db2);
	$usuario_id = CCGetUserID();

	for($RowNumber = 1; $RowNumber <= $Component->TotalRows; $RowNumber++){
		$tipo_instrumento_id = $Component->FormParameters["tipo_instrumento_id_grid"][$RowNumber];
		$parcela_instrumento = $Component->FormParameters["parcela_instrumento_grid"][$RowNumber];
		$parcela_partida_org = $Component->FormParameters["parcela_partida"][$RowNumber]; 
		$tipo_depto_parc_id = $Component->FormParameters["tipo_depto_parc_id"][$RowNumber];  
		$tipo_padron_parc_id = $Component->FormParameters["tipo_padron_parc_id"][$RowNumber]; 
		$parcela_seccion = $Component->FormParameters["parcela_seccion"][$RowNumber]; 
		$parcela_macizo = $Component->FormParameters["parcela_macizo"][$RowNumber]; 
		$parcela_parcela = $Component->FormParameters["parcela_parcela"][$RowNumber]; 
		$parcela_chacra = $Component->FormParameters["parcela_chacra"][$RowNumber];
		$parcela_quinta = $Component->FormParameters["parcela_quinta"][$RowNumber];
		$parcela_fraccion = $Component->FormParameters["parcela_fraccion"][$RowNumber];
		$parcela_uf = $Component->FormParameters["parcela_uf"][$RowNumber];
		$parcela_mzna = $Component->FormParameters["parcela_mzna"][$RowNumber];
		$parcela_lote = $Component->FormParameters["parcela_lote"][$RowNumber];	

			$SQL="SELECT * FROM parcelas WHERE parcela_partida = '$parcela_partida_org' AND tipo_depto_parc_id = '$tipo_depto_parc_id' AND tipo_padron_parc_id = '$tipo_padron_parc_id' AND parcela_seccion = '$parcela_seccion' AND parcela_macizo = '$parcela_macizo' AND parcela_parcela = '$parcela_parcela' AND parcela_chacra = '$parcela_chacra' AND parcela_quinta = '$parcela_quinta' AND parcela_fraccion = '$parcela_fraccion' AND parcela_uf = '$parcela_uf' AND parcela_mzna = '$parcela_mzna' AND parcela_lote = '$parcela_lote';";
			$db->query($SQL);
			
			if($db->next_record()){//si encuentra esta parcela
				//busca si existe en union y desglose
				$ud1 = CCDLookUp("count(*)","uniones_desgloses","origen_parcela_id = '" .$db->f('parcela_id'). "' AND destino_parcela_id = '$parcela_id_des'",$db2);
				
				if($db->f('parcela_id') != $parcela_id_des && $ud1 == 0){//no esta en union_desglose y con parcelas distintas
					$INS="INSERT INTO uniones_desgloses SET  
						parcela_id = '".$db->f('parcela_id')."', 
						parcela_destino_id = '$parcela_id_des',
						tipo_union_desglose_id = '1',
						union_desglose_fecha = NOW(),
						usuario_id = '$usuario_id',
						partida_origen = '$parcela_partida_org',
						partida_destino = '$parcela_partida_des', 
						audit_string = '$usuario_id|".$_SERVER['REMOTE_ADDR']."|inscdominio.php',
						uniones_desgloses_observacion = 'creacion por inscripcion dominial de la parcela';";
					$db2->query($INS);
				}elseif($db->f('parcela_id') == $parcela_id_des && $ud1 == 0){
					$INS="INSERT INTO parcelas SET 
							parcela_partida = '$parcela_partida_org',
							parcela_f_proceso = NOW(),
							parcela_f_alta = NOW(),
							tipo_parcela_alta_id = '1',
							usuario_id = '$usuario_id',
							audit_string = '$usuario_id|".$_SERVER['REMOTE_ADDR']."|inscdominio.php',
							tipo_est_parc_id = '2',
							tipo_depto_parc_id = '$tipo_depto_parc_id',
							tipo_padron_parc_id = '$tipo_padron_parc_id',
							parcela_seccion = '$parcela_seccion',
							parcela_macizo = '$parcela_macizo',
							parcela_parcela = LOWER('$parcela_parcela'),
							parcela_chacra = '$parcela_chacra',
							parcela_quinta = '$parcela_quinta',
							parcela_fraccion = '$parcela_fraccion',
							parcela_uf = '$parcela_uf',
							parcela_mzna = '$parcela_mzna',
							parcela_lote = '$parcela_lote',
							parcela_observa = 'creado por inscripcion dominial';";
					$db2->query($INS);
					$parcela_id_org=mysql_insert_id();
					$persona_id=CCDLookUp("persona_id","personas","persona_old = 'NaN' AND persona_apellido = 'NaN' AND persona_nombre = 'NaN' LIMIT 1",$db2);
					if($persona_id == '' || $persona_id == 0 || $persona_id == ' '){
						$INS="INSERT INTO personas SET 
								tipo_persona_id = '0',
								tipo_documento_id = '0',
								persona_nro_doc = '0',
								persona_cuit = '0',
								persona_old = 'NaN',
								persona_denominacion = 'Creada por inscripcion Dominial',
								persona_apellido = 'NaN',
								persona_nombre = 'NaN',
								tipo_estado_id = '1',
								persona_f_proce = NOW(),
								persona_f_alta = NOW(),
								audit_string = '$usuario_id|".$_SERVER['REMOTE_ADDR']."|inscdominio.php';";
						$db2->query($INS);
						$persona_id=mysql_insert_id();
					}
					$INS="INSERT INTO personas_parcelas SET
						persona_id = '$persona_id',
						parcela_id = '$parcela_id_org',
						tipo_instrumento_id = '$tipo_instrumento_id',
						persona_parcela_num_int = '$parcela_instrumento',
						persona_parcela_f_int = '',
						tipo_persona_parcela_id = '0',
						persona_parcela_origen = '',
						persona_parcela_f_pro = NOW(),
						usuario_id = '$usuario_id',
						tipo_estado_id = '1',
						persona_parcela_ppal = '0',
						persona_parcela_observacion = 'Creada por inscripcion Dominial',
						audit_string = '$usuario_id|".$_SERVER['REMOTE_ADDR']."|inscdominio.php';";
					$db2->query($INS);
					$INS="INSERT INTO uniones_desgloses SET
							parcela_id = '$parcela_id_org',
							parcela_destino_id = '$parcela_id_des',
							tipo_union_desglose_id = '1',
							union_desglose_fecha = NOW(),
							usuario_id = '$usuario_id',
							partida_origen = '$parcela_partida_org',
							partida_destino = '$parcela_partida_des',
							audit_string = '$usuario_id|".$_SERVER['REMOTE_ADDR']."|inscdominio.php',
							uniones_desgloses_observacion = 'creacion desde antecedentes dentro de la parcela';";
					$db2->query($INS);	
				}
			}else{//si no encuentra esta parcela
				$INS="INSERT INTO parcelas SET 
						parcela_partida = '$parcela_partida_org',
						parcela_f_proceso = NOW(),
						parcela_f_alta = NOW(),
						tipo_parcela_alta_id = '1',
						usuario_id = '$usuario_id',
						audit_string = '$usuario_id|".$_SERVER['REMOTE_ADDR']."|inscdominio.php',
						tipo_est_parc_id = '2',
						tipo_depto_parc_id = '$tipo_depto_parc_id',
						tipo_padron_parc_id = '$tipo_padron_parc_id',
						parcela_seccion = '$parcela_seccion',
						parcela_macizo = '$parcela_macizo',
						parcela_parcela = LOWER('$parcela_parcela'),
						parcela_chacra = '$parcela_chacra',
						parcela_quinta = '$parcela_quinta',
						parcela_fraccion = '$parcela_fraccion',
						parcela_uf = '$parcela_uf',
						parcela_mzna = '$parcela_mzna',
						parcela_lote = '$parcela_lote',
						parcela_observa = 'creado por inscripcion dominial';";
				$db2->query($INS);
				$parcela_id_org=mysql_insert_id();
				$persona_id=CCDLookUp("persona_id","personas","persona_old = 'NaN' AND persona_apellido = 'NaN' AND persona_nombre = 'NaN' LIMIT 1",$db2);
				if($persona_id == '' || $persona_id == 0){
					$INS="INSERT INTO personas SET 
							tipo_persona_id = '0',
							tipo_documento_id = '0',
							persona_nro_doc = '0',
							persona_cuit = '0',
							persona_old = 'NaN',
							persona_denominacion = 'Creada por inscripcion Dominial',
							persona_apellido = 'NaN',
							persona_nombre = 'NaN',
							tipo_estado_id = '1',
							persona_f_proce = NOW(),
							persona_f_alta = NOW(),
							audit_string = '$usuario_id|".$_SERVER['REMOTE_ADDR']."|inscdominio.php';";
					$db2->query($INS);
					$persona_id=mysql_insert_id();
				}
				$INS="INSERT INTO personas_parcelas SET
					persona_id = '$persona_id',
					parcela_id = '$parcela_id_org',
					tipo_instrumento_id = '$tipo_instrumento_id',
					persona_parcela_num_int = '$parcela_instrumento',
					persona_parcela_f_int = '',
					tipo_persona_parcela_id = '0',
					persona_parcela_origen = '',
					persona_parcela_f_pro = NOW(),
					usuario_id = '$usuario_id',
					tipo_estado_id = '1',
					persona_parcela_ppal = '0',
					persona_parcela_observacion = 'Creada por inscripcion Dominial',
					audit_string = '$usuario_id|".$_SERVER['REMOTE_ADDR']."|inscdominio.php';";
				$db2->query($INS);
				$INS="INSERT INTO uniones_desgloses SET 
						parcela_id = '$parcela_id_org',
						parcela_destino_id = '$parcela_id_des',
						tipo_union_desglose_id = '1',
						union_desglose_fecha = NOW(),
						usuario_id = '$usuario_id',
						partida_origen = '$parcela_partida_org',
						partida_destino = '$parcela_partida_des',
						audit_string = '$usuario_id|".$_SERVER['REMOTE_ADDR']."|inscdominio.php',
						uniones_desgloses_observacion = 'creacion desde antecedentes dentro de la parcela';";
				$db2->query($INS);					
			}
	}
		
	$SQL="DELETE FROM tmp_dominio WHERE parcela_id = $parcela_id_des";
	$db->query($SQL);
	$db->close();
	$db2->close();
	global $Redirect;
	$Redirect="recordParcela.php?parcela_id=".CCGetParam('parcela_id');
// -------------------------
//End Custom Code

//Close tmp_dominio_AfterSubmit @13-C7A9F8B2
    return $tmp_dominio_AfterSubmit;
}
//End Close tmp_dominio_AfterSubmit

//tmp_dominio_OnValidateRow @13-E6B72BDD
function tmp_dominio_OnValidateRow(& $sender)
{
    $tmp_dominio_OnValidateRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tmp_dominio; //Compatibility
//End tmp_dominio_OnValidateRow

//Custom Code @75-2A29BDB7
// -------------------------

// -------------------------
//End Custom Code

//Close tmp_dominio_OnValidateRow @13-0CDC3075
    return $tmp_dominio_OnValidateRow;
}
//End Close tmp_dominio_OnValidateRow

//tmp_dominio_BeforeSubmit @13-3541A412
function tmp_dominio_BeforeSubmit(& $sender)
{
    $tmp_dominio_BeforeSubmit = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tmp_dominio; //Compatibility
//End tmp_dominio_BeforeSubmit

//Custom Code @95-2A29BDB7
// -------------------------
    global $Redirect;
	$cant=$tmp_dominio->cant->GetValue();
	if($cant == 1){
		$db = new clsDBtdf_nuevo();
		$usuario_id = CCGetUserID();
		for($RowNumber = 1; $RowNumber <= $Component->TotalRows; $RowNumber++){
			$tipo_instrumento_id = $Component->FormParameters["tipo_instrumento_id_grid"][$RowNumber];
			$parcela_instrumento = $Component->FormParameters["parcela_instrumento_grid"][$RowNumber];
			$tipo_depto_parc_id = $Component->FormParameters["tipo_depto_parc_id"][$RowNumber];  
			$tipo_padron_parc_id = $Component->FormParameters["tipo_padron_parc_id"][$RowNumber]; 
			$parcela_seccion = $Component->FormParameters["parcela_seccion"][$RowNumber]; 
			$parcela_macizo = $Component->FormParameters["parcela_macizo"][$RowNumber]; 
			$parcela_parcela = $Component->FormParameters["parcela_parcela"][$RowNumber]; 
			$parcela_chacra = $Component->FormParameters["parcela_chacra"][$RowNumber];
			$parcela_quinta = $Component->FormParameters["parcela_quinta"][$RowNumber];
			$parcela_fraccion = $Component->FormParameters["parcela_fraccion"][$RowNumber];
			$parcela_uf = $Component->FormParameters["parcela_uf"][$RowNumber];
			$parcela_mzna = $Component->FormParameters["parcela_mzna"][$RowNumber];
			$parcela_lote = $Component->FormParameters["parcela_lote"][$RowNumber];	
			$SQL="SELECT * FROM parcelas WHERE parcelas.parcela_id = ".CCGetParam('parcela_id');
			$db->query($SQL);
			if($db->next_record()){
				if($tipo_depto_parc_id == $db->f('tipo_depto_parc_id') && $tipo_padron_parc_id == $db->f('tipo_padron_parc_id') && $parcela_seccion == $db->f('parcela_seccion') && $parcela_macizo == $db->f('parcela_macizo') && $parcela_parcela == $db->f('parcela_parcela') && $parcela_chacra == $db->f('parcela_chacra') && $parcela_quinta == $db->f('parcela_quinta') && $parcela_fraccion == $db->f('parcela_fraccion') && $parcela_uf == $db->f('parcela_uf')){
					$parcela_id=CCGetParam('parcela_id');
			 		$INS="INSERT INTO parcelas_dominiales SET
							parcela_id = $parcela_id,
							parcela_dominial_f_pro = NOW(),
							usuario_id = '$usuario_id',
							parcela_dominial_intrumento_nro = '$parcela_instrumento',
							tipo_instrumento_id = $tipo_instrumento_id, 
							audit_string = '$usuario_id|".$_SERVER['REMOTE_ADDR']."|inscdominio.php', 
							parcela_dominial_partida = '$parcela_partida',
							tipo_depto_parc_id = '$tipo_depto_parc_id',
							tipo_padron_parc_id = '$tipo_padron_parc_id',
							parcela_dominial_seccion = '$parcela_seccion',
							parcela_dominial_macizo = '$parcela_macizo',
							parcela_dominial_parcela = LOWER('$parcela_parcela'),
							parcela_dominial_chacra = '$parcela_chacra',
							parcela_dominial_quinta = '$parcela_quinta',
							parcela_dominial_fraccion = '$parcela_fraccion',
							parcela_dominial_uf = '$parcela_uf',
							parcela_dominial_mzna = '$parcela_mzna',
							parcela_dominial_lote = '$parcela_lote'";
					$db->query($INS);
				}
			}
		}
		$db->close();
	}
	$Redirect="recordParcela.php?parcela_id=".CCGetParam('parcela_id');
// -------------------------
//End Custom Code

//Close tmp_dominio_BeforeSubmit @13-A1323246
    return $tmp_dominio_BeforeSubmit;
}
//End Close tmp_dominio_BeforeSubmit

//Page_BeforeInitialize @1-867FB751
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $inscdominio; //Compatibility
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

//Page_AfterInitialize @1-23FA6610
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $inscdominio; //Compatibility
//End Page_AfterInitialize

//Custom Code @94-2A29BDB7
// -------------------------

// -------------------------
//End Custom Code

//Close Page_AfterInitialize @1-379D319D
    return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize
?>
