<?php

//BindEvents Method @1-A90E6269
function BindEvents()
{
    global $afectaciones;
    global $CCSEvents;
    $afectaciones->plano->CCSEvents["BeforeShow"] = "afectaciones_plano_BeforeShow";
    $afectaciones->open_plano_busq->CCSEvents["BeforeShow"] = "afectaciones_open_plano_busq_BeforeShow";
    $afectaciones->plano_id->CCSEvents["BeforeShow"] = "afectaciones_plano_id_BeforeShow";
    $afectaciones->CCSEvents["OnValidate"] = "afectaciones_OnValidate";
    $afectaciones->CCSEvents["BeforeShow"] = "afectaciones_BeforeShow";
}
//End BindEvents Method

//afectaciones_plano_BeforeShow @18-C4203547
function afectaciones_plano_BeforeShow(& $sender)
{
    $afectaciones_plano_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $afectaciones; //Compatibility
//End afectaciones_plano_BeforeShow

//Custom Code @25-2A29BDB7
// -------------------------


	/* Toma el ID del plano del campo, de la sesión o de la URL
	----------------------------------------------------------- */
/*
	// recupera el valor que tenga el campo
	$planoVal = $afectaciones->plano_id->GetValue();

	if ( CCGetSession("plano_id") ) {
		// si hay algo en la sesión...
		$plano_id = CCGetSession("plano_id");
		unset( $_SESSION['plano_id'] );
	} else if ( !empty( $planoVal ) ) {
		// si tiene valor en el campo...
		$plano_id = $planoVal;
	} else if (CCGetParam("plano_id")) {
		// si viene en la URL
		$plano_id = CCGetParam("plano_id");
	}


	$db = new clsDBtdf_nuevo();

	// obtiene la identificación del plano
	if ( !empty( $plano_id)  ) {

		$plano = obtenerPlano( $plano_id, $db );
		$Component->SetValue( $plano );

	}


	$db->close();
*/

// -------------------------
//End Custom Code

//Close afectaciones_plano_BeforeShow @18-1BC57C26
    return $afectaciones_plano_BeforeShow;
}
//End Close afectaciones_plano_BeforeShow

//afectaciones_open_plano_busq_BeforeShow @23-66427F0C
function afectaciones_open_plano_busq_BeforeShow(& $sender)
{
    $afectaciones_open_plano_busq_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $afectaciones; //Compatibility
//End afectaciones_open_plano_busq_BeforeShow

//Open as popup @24-A713246E
    

// open_plano_busq
// open_plano_busq
	
global $afectaciones;

$lnk=$afectaciones->open_plano_busq->GetLink();
$newlnk="$lnk\" onclick=\"javascript:window.open(this.href,'','width=800,height=550,top='+(screen.height-550)/2+',left='+(screen.width-800)/2+',scrollbars=yes,location=yes,directories=yes,status=yes,menubar=yes,toolbar=yes,resizable=yes').focus();return false;";
$afectaciones->open_plano_busq->SetLink($newlnk);

	
//End Open as popup

//Close afectaciones_open_plano_busq_BeforeShow @23-CEF43753
    return $afectaciones_open_plano_busq_BeforeShow;
}
//End Close afectaciones_open_plano_busq_BeforeShow

//afectaciones_plano_id_BeforeShow @26-C4C075E9
function afectaciones_plano_id_BeforeShow(& $sender)
{
    $afectaciones_plano_id_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $afectaciones; //Compatibility
//End afectaciones_plano_id_BeforeShow

//Custom Code @27-2A29BDB7
// -------------------------

	/* Toma el ID del plano de la sesión o de la URL y lo
	   guarda en el campo oculto
	------------------------------------------------------ */
/*
	if ( CCGetSession("plano_id") ) {
		$plano_id = CCGetSession("plano_id");
	}

	if (CCGetParam("plano_id")) {
		$plano_id = CCGetParam("plano_id");
	}

	// si se trajo algún dato lo carga en el valor del campo oculto
	if ( !empty( $plano_id ) ) {
		$Component->SetValue( $plano_id );
	}
*/

// -------------------------
//End Custom Code

//Close afectaciones_plano_id_BeforeShow @26-D19B7D3A
    return $afectaciones_plano_id_BeforeShow;
}
//End Close afectaciones_plano_id_BeforeShow

//afectaciones_OnValidate @10-0D5C46DB
function afectaciones_OnValidate(& $sender)
{
    $afectaciones_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $afectaciones; //Compatibility
//End afectaciones_OnValidate

//Custom Code @31-2A29BDB7
// -------------------------

    $db = new clsDBtdf_nuevo();

	/* Valida que se inserte el plano_id en el caso
	   de que el tipo seleccionado lo requiera
	--------------------------------------------------------------------  */
	$tipoAfectacion = $afectaciones->tipo_afectacion_id->GetValue();

	if ( $tipoAfectacion ) {
		// trae si el plano está requerido para este titpo
		$tipoAfectacionReq = CCDLookUp('tipo_afectacion_req_plano', 'tipos_afectaciones', 'tipo_afectacion_id = ' . $tipoAfectacion , $db);
		
		// si el tipo requiere plano...
		if ( $tipoAfectacionReq == 1 ) {

			// trae el id del plano
			$planoId = $afectaciones->plano_id->GetValue();
			// si está vacío agrega mensaje de error
			if ( empty( $planoId ) ) {
				$afectaciones->Errors->addError("Este tipo de afectación requiere un plano relacionado.");

			}

		}

	}


	$db->close();


// -------------------------
//End Custom Code

//Close afectaciones_OnValidate @10-E8E8B74F
    return $afectaciones_OnValidate;
}
//End Close afectaciones_OnValidate

//afectaciones_BeforeShow @10-BB14ABBF
function afectaciones_BeforeShow(& $sender)
{
    $afectaciones_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $afectaciones; //Compatibility
//End afectaciones_BeforeShow

//Custom Code @32-2A29BDB7
// -------------------------


	/* Toma el ID del plano del campo, de la sesión o de la URL
	----------------------------------------------------------- */

	$quitarPlano = CCGetParam('quitarPlano', false);

	// Si se ha pedido desrelacionar el plano...
	if( !empty( $quitarPlano ) ) {

		// lo elimina de la sesión
		unset( $_SESSION['plano_id'] );

		// lo elimina del campo oculto
		$afectaciones->plano_id->SetValue( false );

		// quita el parámetro de la URL y redirecciona
/*		global $fileName;
		$queryString = CCGetQueryString( 'All', array('quitarPlano') );
		header("Location: " . $fileName . "?" . $queryString );
*/

	// funcionamiento normal
	} else {

		// recupera el valor del plano que tenga el campo
		$planoVal = $afectaciones->plano_id->GetValue(); //debug( $planoVal );


		if ( CCGetSession("plano_id") ) {
			// si viene en la sesión lo saca de ahí
			$plano_id = CCGetSession("plano_id");
			// carga el valor en el campo oculto
			$afectaciones->plano_id->SetValue( $plano_id );
			// y elimina el valor para que no moleste luego si está seteado de otra forma
			unset( $_SESSION['plano_id'] );
		} else if ( !empty( $planoVal ) ) {
			// si tiene valor en el campo...
			$plano_id = $planoVal;
		}



		// obtiene la identificación del plano
		if ( !empty( $plano_id ) ) {

			$db = new clsDBtdf_nuevo();

			// carga el idetificacion en el label
			$plano = obtenerPlano( $plano_id, $db );
			$afectaciones->plano->SetValue( $plano );

			$db->close();

		}

	}



// -------------------------
//End Custom Code

//Close afectaciones_BeforeShow @10-D713D3C6
    return $afectaciones_BeforeShow;
}
//End Close afectaciones_BeforeShow

//Page_BeforeInitialize @1-9694E90F
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelaAfectacionesRecord; //Compatibility
//End Page_BeforeInitialize

//Custom Code @9-2A29BDB7
// -------------------------

	// Incluye el archivo de funciones generales
	include_once(RelativePath . "/scripts/myFunctions.php");


	// Incluye la gestión de permisos
	include_once(RelativePath . "/scripts/permisos1.php");



	/* Quita el plano seleccionado de la sesión si viene el parámetro
	------------------------------------------------------------------------- */
/*
	$quitarPlano = CCGetParam('quitarPlano', false);

	if( !empty( $quitarPlano ) ) {

		// lo elimina de la sesión
		unset( $_SESSION['plano_id'] );

		// quita el parámetro de la URL y redirecciona
		global $fileName;
		$queryString = CCGetQueryString( 'All', array('quitarPlano') );
		header("Location: " . $fileName . "?" . $queryString );

	}

*/


// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
