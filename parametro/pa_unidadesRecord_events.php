<?php

//BindEvents Method @1-7A5E4A3C
function BindEvents()
{
    global $unidades;
    global $unidades_parametros;
    global $CCSEvents;
    $unidades->CCSEvents["AfterInsert"] = "unidades_AfterInsert";
    $unidades_parametros->CCSEvents["BeforeShow"] = "unidades_parametros_BeforeShow";
    $unidades_parametros->CCSEvents["AfterSubmit"] = "unidades_parametros_AfterSubmit";
    $unidades_parametros->CCSEvents["OnValidateRow"] = "unidades_parametros_OnValidateRow";
    $unidades_parametros->ds->CCSEvents["BeforeBuildInsert"] = "unidades_parametros_ds_BeforeBuildInsert";
    $unidades_parametros->CCSEvents["OnValidate"] = "unidades_parametros_OnValidate";
}
//End BindEvents Method

//unidades_AfterInsert @6-F6EF35EB
function unidades_AfterInsert(& $sender)
{
    $unidades_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $unidades; //Compatibility
//End unidades_AfterInsert

//Custom Code @41-2A29BDB7
// -------------------------

    // Luego de insertar una unidad redirecciona a la edición del
	// mismo registro para agregar o editar parámetros
	global $Redirect;
	$unidad_id = mysql_insert_id();
	$Redirect = "pa_unidadesRecord.php?unidad_id=$unidad_id";

// -------------------------
//End Custom Code

//Close unidades_AfterInsert @6-181E73E4
    return $unidades_AfterInsert;
}
//End Close unidades_AfterInsert

//unidades_parametros_BeforeShow @21-D321B102
function unidades_parametros_BeforeShow(& $sender)
{
    $unidades_parametros_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $unidades_parametros; //Compatibility
//End unidades_parametros_BeforeShow

//Custom Code @35-2A29BDB7
// -------------------------

    // Muestra el grid editable de parámetros solo si viene el
	// ID de la unidad
	if( !CCGetParam(unidad_id) ){
		$Component->Visible = False;
	}

// -------------------------
//End Custom Code

//Close unidades_parametros_BeforeShow @21-9E2BC495
    return $unidades_parametros_BeforeShow;
}
//End Close unidades_parametros_BeforeShow

//unidades_parametros_AfterSubmit @21-2A78058D
function unidades_parametros_AfterSubmit(& $sender)
{
    $unidades_parametros_AfterSubmit = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $unidades_parametros; //Compatibility
//End unidades_parametros_AfterSubmit

//Custom Code @38-2A29BDB7
// -------------------------

    // Crea la conexión
	$db = new clsDBmesa();

	// recuepera el ID de la unidad
	$unidad_id = CCGetParam(unidad_id); //debug('unidad_id: ' . $unidad_id . '<br>');


	/* Maneja el estado de los parámetros
	----------------------------------------- */
	
	// pone todos los parámetros inactivos
	$SQL_UPD = "UPDATE unidades_param SET unidad_p_activo = 0 WHERE unidad_id = $unidad_id";
	$db->query($SQL_UPD);


	// busca el parámetro (previo) más reciente con respecto a la fecha de hoy
	$unidad_p_id = CCDLookUp('unidad_p_id','unidades_param',"unidad_id = $unidad_id AND unidad_p_f_vig <= NOW() ORDER BY unidad_p_f_vig DESC LIMIT 1",$db);


	if( $unidad_p_id ) {

		// si existe lo activa ...
		$SQL_UPD = "UPDATE unidades_param 
					SET unidad_p_activo = 1 
					WHERE unidad_p_id = $unidad_p_id";
		$db->query($SQL_UPD);	

	} else {
		
		// si no busca el próximo vigente y lo activa ...
		$unidad_p_id = CCDLookUp('unidad_p_id','unidades_param',"unidad_id = $unidad_id AND unidad_p_f_vig >= NOW() ORDER BY unidad_p_f_vig ASC LIMIT 1", $db);
		$SQL_UPD = "UPDATE unidades_param 
					SET unidad_p_activo = 1 
					WHERE unidad_p_id = $unidad_p_id";
		$db->query($SQL_UPD);

	}



	// si está actualizando vincula con la tabla de unidades y
	// actualiza el nombre (no me pregunten para que cuernos hace esto)
	if ( $unidad_p_id ) {

		$SQL = "UPDATE unidades_param
				INNER JOIN unidades USING(unidad_id)
				SET unidad_p_nombre = unidad_nombre
				WHERE unidad_p_id = $unidad_p_id";
		$db->query($SQL);

	}


	$db->close();


// -------------------------
//End Custom Code

//Close unidades_parametros_AfterSubmit @21-0E16D976
    return $unidades_parametros_AfterSubmit;
}
//End Close unidades_parametros_AfterSubmit

//unidades_parametros_OnValidateRow @21-72CEAEB2
function unidades_parametros_OnValidateRow(& $sender)
{
    $unidades_parametros_OnValidateRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $unidades_parametros; //Compatibility
//End unidades_parametros_OnValidateRow

//Custom Code @40-2A29BDB7
// -------------------------

	/* Si se va a insertar el registro completa con el ID de la unid.
	 --------------------------------------------------------------- */
/*
	$fecha_vigencia = $unidades_parametros->unidad_p_f_vig->GetValue();		// debug($fecha_vigencia);
	$responsable = $unidades_parametros->unidad_p_responsable->GetValue();	// debug($responsable);
	$unidad_p_id = $unidades_parametros->unidad_p_id->GetValue();			// debug( 'id: ' . $unidad_p_id );
	$unidad_id = CCGetParam('unidad_id', false);


	// Si se está insertando...
	if ( empty( $unidad_p_id ) ) {

		debug('insertando');
		$unidades_parametros->unidad_id->SetValue( $unidad_id );
		$Component->ds->uni

		// Si los parámetros necesarios están....
		if (
			!empty( $fecha_vigencia )
			&& !empty( $responsable )
			&& !empty( $unidad_id )
		) {

			// asigno el ID de la unidad al parámetro
			$unidades_parametros->unidad_id->SetValue( $unidad_id );

		} elseif (
			!empty( $fecha_vigencia )
			&& !empty( $responsable )
			&& empty( $unidad_id )
		) {

			// si no se pudo obtener el ID de la unidad no permite el insert
			$unidades_parametros->unidad_p_responsable->Errors->addError("No se pudo insertar la parametrización.");

		}


	} else {

		debug('modificando');

	}
*/

	/* Si se va a insertar el registro completa con el ID de la unid.
	 --------------------------------------------------------------- */

	$fecha_vigencia = $unidades_parametros->unidad_p_f_vig->GetValue();		debug($fecha_vigencia);
	$responsable = $unidades_parametros->unidad_p_responsable->GetValue();	debug($responsable);
	//$unidad_p_id = $unidades_parametros->unidad_p_id->GetValue();			//debug( 'id: ' . $unidad_p_id );
	//$ctrl_unidad_id = $unidades_parametros->unidad_id->GetValue();			//debug( 'CTRL unidad id: ' . $ctrl_unidad_id );
	//$unidad_id = CCGetParam('unidad_id', false);							//debug ('PARAM unidad id: ' . $unidad_id );


	// Si se está insertando...
	if ( empty( $fecha_vigencia ) || empty( $responsable ) ) {

		$unidades_parametros->InsertAllowed = false; 
		debug('no insert');

	} else {

		$unidades_parametros->InsertAllowed = true;

	}



// -------------------------
//End Custom Code

//Close unidades_parametros_OnValidateRow @21-EF23FBDE
    return $unidades_parametros_OnValidateRow;
}
//End Close unidades_parametros_OnValidateRow

//unidades_parametros_ds_BeforeBuildInsert @21-E94970E4
function unidades_parametros_ds_BeforeBuildInsert(& $sender)
{
    $unidades_parametros_ds_BeforeBuildInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $unidades_parametros; //Compatibility
//End unidades_parametros_ds_BeforeBuildInsert

//Custom Code @45-2A29BDB7
// -------------------------


	/* Si se va a insertar el registro completa con el ID de la unid.
	 --------------------------------------------------------------- */

	$fecha_vigencia = $unidades_parametros->unidad_p_f_vig->GetValue();		//debug($fecha_vigencia);
	$responsable = $unidades_parametros->unidad_p_responsable->GetValue();	//debug($responsable);
	$unidad_p_id = $unidades_parametros->unidad_p_id->GetValue();			//debug( 'id: ' . $unidad_p_id );
	$ctrl_unidad_id = $unidades_parametros->unidad_id->GetValue();			//debug( 'CTRL unidad id: ' . $ctrl_unidad_id );
	$unidad_id = CCGetParam('unidad_id', false);							//debug ('PARAM unidad id: ' . $unidad_id );


	// Si se está insertando...
	if ( empty( $fecha_vigencia ) || empty( $responsable ) ) {

		$unidades_parametros->InsertAllowed = false; 

	} else {

		$unidades_parametros->InsertAllowed = true;

	}


//debug( 'CTRL unidad id: ' . $unidades_parametros->unidad_id->GetValue() );
//debug( $unidades_parametros->ds );
//debug( $unidades_parametros->ds['RowNumber'] );


// -------------------------
//End Custom Code

//Close unidades_parametros_ds_BeforeBuildInsert @21-F3A91CB4
    return $unidades_parametros_ds_BeforeBuildInsert;
}
//End Close unidades_parametros_ds_BeforeBuildInsert

//unidades_parametros_OnValidate @21-903F4EA7
function unidades_parametros_OnValidate(& $sender)
{
    $unidades_parametros_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $unidades_parametros; //Compatibility
//End unidades_parametros_OnValidate

//Custom Code @46-2A29BDB7
// -------------------------


// -------------------------
//End Custom Code

//Close unidades_parametros_OnValidate @21-A1D0A01C
    return $unidades_parametros_OnValidate;
}
//End Close unidades_parametros_OnValidate

//DEL  // -------------------------
//DEL  
//DEL  debug( $unidades_parametros->DataSource[$Container->RowNumber] );
//DEL  debug( $unidades_parametros->RowNumber );
//DEL  die();
//DEL  
//DEL  // -------------------------

//Page_BeforeInitialize @1-479A4A57
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $pa_unidadesRecord; //Compatibility
//End Page_BeforeInitialize

//Custom Code @20-2A29BDB7
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
