<?php
//BindEvents Method @1-3D92F831
function BindEvents()
{
  global $piezas;
  global $CCSEvents;
  $piezas->tipo_tramites_id->CCSEvents["BeforeShow"] = "piezas_tipo_tramites_id_BeforeShow";
  $piezas->ds->CCSEvents["AfterExecuteInsert"] = "piezas_ds_AfterExecuteInsert";
  $piezas->CCSEvents["BeforeShow"] = "piezas_BeforeShow";
  $piezas->CCSEvents["OnValidate"] = "piezas_OnValidate";
  $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
}
//End BindEvents Method

//piezas_tipo_tramites_id_BeforeShow @61-6BF115AD
function piezas_tipo_tramites_id_BeforeShow(& $sender)
{
  $piezas_tipo_tramites_id_BeforeShow = true;
  $Component = & $sender;
  $Container = & CCGetParentContainer($sender);
  global $piezas; //Compatibility
//End piezas_tipo_tramites_id_BeforeShow

//Close piezas_tipo_tramites_id_BeforeShow @61-8DA721F4
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

//Custom Code @29-2A29BDB7
// -------------------------
    // Write your own code here.
	//crear la pieza con su numero, crear el primer pase activo.
	global $Redirect;

	$db = new clsDBmesa();
	$db2 = new clsDBmesa();

	$pieza_tipo_id = $Component->pieza_tipo_id->GetValue();
	$unidad_id = $Component->unidad_id->GetValue();
	$des_unidad_id = CCGetSession(unidad_id);
	$usuario_id = CCGetUserID();
	$login = CCGetUserLogin();
	$fojas = $Component->fojas->GetValue();
	$pieza_nro = $Component->pieza_nro->GetValue();
	
	$pieza_letra = $Component->pieza_letra->GetValue();//expediente
	$pieza_anio = $Component->pieza_anio->GetValue();//expediente
	
	$letra = substr(ucfirst($Component->pieza_iniciador->GetValue()),0,1);

	if(!$Component->pieza_nro->GetValue()){
		$SQL = "SELECT GET_LOCK('numero_nota',3) AS lck";
		$db->query($SQL);
		$db->next_record();
		$numero = CCDLookUp('IFNULL(MAX(pieza_nro),0)','piezas',"pieza_tipo_id = $pieza_tipo_id AND entorno_id = 1 AND pieza_anio = " . date('Y'),$db2);
		$numero++;
		$pieza_nro = $numero++;
	}

  // trae el ID de trámite de acuerdo al ID de tipo de trámite
  $tramitesData = CCQueryToArray( 'SELECT tipos_tramites.tipo_tramites_id, tramites.tramite_id FROM tipos_tramites INNER JOIN tramites ON tipos_tramites.tramite_id = tramites.tramite_id WHERE tipos_tramites.tipo_tramites_id = ' . mysql_real_escape_string( $Component->tipo_tramites_id->GetValue() ), $db2 );


	$INS_PIEZA = " INSERT INTO piezas SET 
			pieza_tipo_id = $pieza_tipo_id,
			pieza_nro = $pieza_nro,
			pieza_letra = '$pieza_letra',   
			pieza_anio = $pieza_anio,
			pieza_cp_nro = 0,
			pieza_tm_nro = 1,      
			pieza_iniciador = '" . $Component->pieza_iniciador->GetValue() . "',      
			pieza_descripcion = '" . $Component->pieza_descripcion->GetValue() . "',      
			pieza_observaciones = '" . $Component->pieza_observaciones->GetValue() . "',
			pieza_f_alta = NOW(),  
			unidad_id = $unidad_id,
		  tramite_id = " . $tramitesData[0]['tramite_id'] . ",
			tipo_tramites_id = " . $tramitesData[0]['tipo_tramites_id'] . ",
			entorno_id = 2,           
			estado_id = 1";

	$db2->query($INS_PIEZA);
	//echo $INS_PIEZA;exit();
	
	$pieza_id = mysql_insert_id();

	//desbloquear
	if(!$Component->pieza_nro->GetValue()){
		$SQL = "SELECT RELEASE_LOCK('numero_nota')";
	    $db->query($SQL);
	    $db->next_record();
	}

	//ahora el primer pase

	$INS_PASE = "INSERT INTO pases SET
				pieza_id = $pieza_id,
				pase_nro = 1,
				ori_unidad_id = $unidad_id,
				des_unidad_id = $des_unidad_id,
				pase_comentario = 'Creación Pieza',
				pase_n_fojas = $fojas,
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

//piezas_BeforeShow @2-EA4EEDD7
function piezas_BeforeShow(& $sender)
{
  $piezas_BeforeShow = true;
  $Component = & $sender;
  $Container = & CCGetParentContainer($sender);
  global $piezas; //Compatibility
//End piezas_BeforeShow

//Custom Code @30-2A29BDB7
// -------------------------
    // Write your own code here.
	//$Component->pieza_iniciador->SetValue(CCGetSession('unidad_nombre'));
// -------------------------
//End Custom Code

//Close piezas_BeforeShow @2-62556E9E
  return $piezas_BeforeShow;
}
//End Close piezas_BeforeShow

//piezas_OnValidate @2-9ABDD730
function piezas_OnValidate(& $sender)
{
  $piezas_OnValidate = true;
  $Component = & $sender;
  $Container = & CCGetParentContainer($sender);
  global $piezas; //Compatibility
//End piezas_OnValidate

//Validate Minimum Length @58-39281E9B
  global $CCSLocales;
  if (CCStrLen($Container->pieza_anio->GetText()) < 4) {
    $Container->pieza_anio->Errors->addError("El año debe ser de 4 digitos");
  }
//End Validate Minimum Length

//Custom Code @60-2A29BDB7
// -------------------------
    // Write your own code here.
	//si es un expediente , el numero es obligatorio
	$pieza_nro = $piezas->pieza_nro->GetValue();
	$pieza_anio = $piezas->pieza_anio->GetValue();
	$pieza_letra = strtoupper($piezas->pieza_letra->GetValue());

	$db = new clsDBmesa();
	$cant = CCDLookUp("COUNT(*) AS cant","piezas","piezas.pieza_anio = '$pieza_anio' AND piezas.pieza_letra = '$pieza_letra'  AND piezas.pieza_nro = '$pieza_nro'",$db);

	if($cant > 0){
		$Component->Errors->AddError('Ya existe una pieza con el mismo numero!');
	}

	$db->close();
	if($Component->pieza_tipo_id->GetValue() == 1){
		if(!$Component->pieza_nro->GetValue()){
			$Component->Errors->AddError('Debe ingresar el numero del expediente!');
		}
	}
// -------------------------
//End Custom Code

//Close piezas_OnValidate @2-5DAE0A17
  return $piezas_OnValidate;
}
//End Close piezas_OnValidate

//Page_AfterInitialize @1-E407E6AB
function Page_AfterInitialize(& $sender)
{
  $Page_AfterInitialize = true;
  $Component = & $sender;
  $Container = & CCGetParentContainer($sender);
  global $msa_altaPiezaExt; //Compatibility
//End Page_AfterInitialize

//Custom Code @59-2A29BDB7
// -------------------------
    // Write your own code here.
	global $Redirect;

	//solo puede entrar si a este area se le permiten los pases externos....

	$db = new clsDBunidades();
	$pase_externo = CCDLookUp('unidad_pase_externo','unidades','unidad_id = ' . CCGetSession('unidad_id'),$db);

	
	if(!$pase_externo){
		$Redirect = RelativePath . "/tdf_restricted.php";
	}
	
	$db->close();



// -------------------------
//End Custom Code

//Close Page_AfterInitialize @1-379D319D
  return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize

//Page_BeforeInitialize @1-2BF2D869
function Page_BeforeInitialize(& $sender)
{
  $Page_BeforeInitialize = true;
  $Component = & $sender;
  $Container = & CCGetParentContainer($sender);
  global $msa_altaPiezaExt; //Compatibility
//End Page_BeforeInitialize

//Custom Code @65-2A29BDB7
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