<?php

//BindEvents Method @1-74A31414
function BindEvents()
{
    global $afectaciones;
    global $CCSEvents;
    $afectaciones->afectaciones_TotalRecords->CCSEvents["BeforeShow"] = "afectaciones_afectaciones_TotalRecords_BeforeShow";
    $afectaciones->CCSEvents["BeforeShowRow"] = "afectaciones_BeforeShowRow";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
}
//End BindEvents Method

//afectaciones_afectaciones_TotalRecords_BeforeShow @11-382A6791
function afectaciones_afectaciones_TotalRecords_BeforeShow(& $sender)
{
    $afectaciones_afectaciones_TotalRecords_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $afectaciones; //Compatibility
//End afectaciones_afectaciones_TotalRecords_BeforeShow

//Retrieve number of records @12-ABE656B4
    $Component->SetValue($Container->DataSource->RecordsCount);
//End Retrieve number of records

//Close afectaciones_afectaciones_TotalRecords_BeforeShow @11-4B88FFC0
    return $afectaciones_afectaciones_TotalRecords_BeforeShow;
}
//End Close afectaciones_afectaciones_TotalRecords_BeforeShow

//afectaciones_BeforeShowRow @10-34C25282
function afectaciones_BeforeShowRow(& $sender)
{
    $afectaciones_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $afectaciones; //Compatibility
//End afectaciones_BeforeShowRow

//Custom Code @38-2A29BDB7
// -------------------------

    /* Calcula el Nro. de plano para mostrar en la fila
	-------------------------------------------------------------- */
	$db = new clsDBtdf_nuevo();
	$plano_id = $afectaciones->DataSource->f('plano_id'); //debug( $plano_id );

	if ( !empty( $plano_id ) ) {
		// busco los datos del plano
		$nro_plano = obtenerPlano( $plano_id, $db );

		if ( !empty( $nro_plano ) ) {
			// si lo obtengo seteo el valor en el label
			$afectaciones->plano_nro->SetValue( $nro_plano );
		}
	} else {
		$afectaciones->plano_nro->SetValue( '' );
	}


// -------------------------
//End Custom Code

//Close afectaciones_BeforeShowRow @10-6942F271
    return $afectaciones_BeforeShowRow;
}
//End Close afectaciones_BeforeShowRow

//Page_BeforeInitialize @1-E0A92D99
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelaAfectaciones; //Compatibility
//End Page_BeforeInitialize

//Custom Code @9-2A29BDB7
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

//Page_AfterInitialize @1-FE907296
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelaAfectaciones; //Compatibility
//End Page_AfterInitialize

//Custom Code @47-2A29BDB7
// -------------------------
	$db = new clsDBtdf_nuevo();
  	$SQL = "SELECT gis_par_jsapi,gis_par_css,gis_par_image FROM gis_parametros WHERE gis_par_id = 1";
  	$db->query($SQL);
  
  	if($db->next_record()){
  		$Component->jsapi->SetValue($db->f('gis_par_jsapi'));
  		$Component->css->SetValue($db->f('gis_par_css'));
		$Component->image->SetValue($db->f('gis_par_image'));
  	}
	$db->close();
// -------------------------
//End Custom Code

//Close Page_AfterInitialize @1-379D319D
    return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize


?>
