<?php
//Page_BeforeInitialize @1-F750EA92
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tc_removeParcela; //Compatibility
//End Page_BeforeInitialize

//Custom Code @2-2A29BDB7
// -------------------------


	// Incluye el archivo de funciones generales
	include_once(RelativePath . "/scripts/myFunctions.php");


	// Incluye la gestión de permisos
	include_once(RelativePath . "/scripts/permisos1.php");



	/* Quita la parcela indicada y redirecciona
	----------------------------------------------- */
	$planos_prov_id = CCGetParam('planos_prov_id');
	$plano_id = CCGetParam('plano_id');
	$returnPage = CCGetParam('returnPage');


	if ( !empty( $planos_prov_id ) && !empty( $plano_id ) ) {

		$db = new clsDBtdf_nuevo();

		// 1ero. Borra las personas relacionadas con la parcela
		$db->query('DELETE FROM planos_parc_prov_personas WHERE planos_prov_id = ' . mysql_real_escape_string( $planos_prov_id ) );

		// 2do. Borra la parcela de destino relacionada
		$db->query('DELETE FROM planos_parc_prov WHERE planos_prov_id = ' . mysql_real_escape_string( $planos_prov_id ) );

		$db->close();


	    // Si existe el paràmetro returnPage cambia la página de destino luego de borrar
		if ( !empty($returnPage) ) {
			header('Location: ' . $returnPage . '.php?plano_id='. $plano_id );
		} else {
			header('Location: tc_planosRecord.php?plano_id='. $plano_id );
		}

	}


// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
