<?php
// //Events @1-F81417CB

//headerParcela_parcela_BeforeShow @2-7E970BD9
function headerParcela_parcela_BeforeShow(& $sender)
{
    $headerParcela_parcela_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $headerParcela; //Compatibility
//End headerParcela_parcela_BeforeShow

//Custom Code @74-2A29BDB7
// -------------------------
	$nomenclatura="";
	if($Component->tipo_depto_parc_desc->GetValue() != ""){
		$nomenclatura = $nomenclatura . $Component->tipo_depto_parc_desc->GetValue();
	}else{
		$nomenclatura = $nomenclatura . "-";
	}
	if($Component->parcela_seccion->GetValue() != ""){
		$nomenclatura = $nomenclatura . " " . $Component->parcela_seccion->GetValue();
	}else{
		$nomenclatura = $nomenclatura . " -";
	}
	if($Component->parcela_macizo->GetValue() != ""){
		$nomenclatura = $nomenclatura . " " . $Component->parcela_macizo->GetValue();
	}else{
		$nomenclatura = $nomenclatura . " -";
	}
	if($Component->parcela_parcela->GetValue() != ""){
		$nomenclatura = $nomenclatura . " " . $Component->parcela_parcela->GetValue();
	}else{
		$nomenclatura = $nomenclatura . " -";
	}
	if($Component->parcela_uf->GetValue() != ""){
		$nomenclatura = $nomenclatura . " " . $Component->parcela_uf->GetValue();
	}else{
		$nomenclatura = $nomenclatura . " -";
	}
    $Component->parcela_nomenclatura->SetValue($nomenclatura);

	$db = new clsDBtdf_nuevo();
	$instrumento = CCDLookUp("CONCAT(tipo_instrumento_descrip,' ',persona_parcela_num_int)","personas_parcelas LEFT JOIN tipos_instrumentos ON tipos_instrumentos.tipo_instrumento_id = personas_parcelas.tipo_instrumento_id","personas_parcelas.tipo_estado_id = 1 AND parcela_id = ".CCGetParam('parcela_id')." ORDER BY personas_parcelas.persona_parcela_f_pro DESC LIMIT 1",$db);
	if($instrumento != ''){
		$Component->instrumento->SetValue($instrumento);
	}else{
		$Component->instrumento->SetValue(CCDLookUp("CONCAT(tipo_instrumento_descrip,' ',parcela_instrumento)","parcelas LEFT JOIN tipos_instrumentos ON tipos_instrumentos.tipo_instrumento_id = parcelas.tipo_instrumento_id","parcelas.tipo_est_parc_id = 1 AND parcela_id = ".CCGetParam('parcela_id'),$db));
	}
	$Component->plano->SetValue(obtenerPlano(false,CCGetParam('parcela_id'),false, $db));
	$db->close();

	$db = new clsDBtdf_nuevo();
	$db2 = new clsDBtdf_nuevo();

	//----------------------------planchetas-----------------------------------

	$htm = generarPlanchetasSlides(
		CCGetParam('parcela_id'),
		array(
      'wrapper' => 'dialog-modal',
      'wrapper_title' => 'Planchetas de la parcela',
      'additional_classes' => 'big'
    ),
		$db
	);
	$Component->plancheta->SetValue( $htm );

	$SQL="SELECT tipo_restricc_parcela_desc FROM parcelas_tipos_restricc INNER JOIN tipos_restricc_parcela ON parcelas_tipos_restricc.tipo_restricc_parcela_id = tipos_restricc_parcela.tipo_restricc_parcela_id WHERE parcelas_tipos_restricc.parcela_id = ".CCGetParam('parcela_id');
	$db->query($SQL);
	$coma="";
	while($db->next_record()){
		$restric.=$coma.$db->f('tipo_restricc_parcela_desc');
		$coma=", ";
	}
	$Component->tipo_restricc_parcela_desc->SetValue($restric);

	$db->close();
	$db2->close();


// -------------------------
//End Custom Code

//Close headerParcela_parcela_BeforeShow @2-AA27A010
    return $headerParcela_parcela_BeforeShow;
}
//End Close headerParcela_parcela_BeforeShow

//headerParcela_AfterInitialize @1-490641B4
function headerParcela_AfterInitialize(& $sender)
{
    $headerParcela_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $headerParcela; //Compatibility
//End headerParcela_AfterInitialize

//Custom Code @55-2A29BDB7
// -------------------------
    // Write your own code here.
	$db = new clsDBtdf_nuevo();
	if(CCGetParam(parcela_id)){
		$no_edit = CCDLookUp('tipo_parcela_no_edit','tipos_parcelas_estados INNER JOIN parcelas USING(tipo_parcela_estado_id)','parcela_id = ' . CCGetParam(parcela_id),$db);
		if($no_edit){
			$Component->parcela->UpdateAllowed = False;
			$Component->parcela->Errors->addError("Los datos de esta parcela no pueden ser modificados.");
		}
	}
// -------------------------
//End Custom Code

//Close headerParcela_AfterInitialize @1-C07CDBBD
    return $headerParcela_AfterInitialize;
}
//End Close headerParcela_AfterInitialize

//headerParcela_BeforeInitialize @1-D978109E
function headerParcela_BeforeInitialize(& $sender)
{
    $headerParcela_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $headerParcela; //Compatibility
//End headerParcela_BeforeInitialize

//Custom Code @110-2A29BDB7
// -------------------------

	// Incluye el archivo de funciones generales
	include_once(RelativePath . "/scripts/myFunctions.php");

	// Incluye la gestión de permisos
	include_once(RelativePath . "/scripts/permisos1.php");
// -------------------------
//End Custom Code

//Close headerParcela_BeforeInitialize @1-187F610B
    return $headerParcela_BeforeInitialize;
}
//End Close headerParcela_BeforeInitialize


?>