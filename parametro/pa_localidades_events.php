<?php
//BindEvents Method @1-08DA938B
function BindEvents()
{
    global $localidades;
    $localidades->localidad_nombre->CCSEvents["OnValidate"] = "localidades_localidad_nombre_OnValidate";
}
//End BindEvents Method

//localidades_localidad_nombre_OnValidate @10-9A16873B
function localidades_localidad_nombre_OnValidate(& $sender)
{
    $localidades_localidad_nombre_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $localidades; //Compatibility
//End localidades_localidad_nombre_OnValidate

//Custom Code @17-2A29BDB7
// -------------------------

    /* Valida que no exista una localidad con el mismo
	   nombre para el mismo departamento
	------------------------------------------------------------- */

	// consulta la ddbb
	$db = new clsDBtdf_nuevo();

	// determina cómo tiene que validar (si es INSERT o UPDATE)
	$recordID = $localidades->localidad_id->GetValue();

	if ( !empty( $recordID ) ) {
		// editando: excluye el registro actual de la consulta
		$SQL = 'SELECT * FROM localidades WHERE localidad_nombre LIKE "' . $localidades->localidad_nombre->GetValue() . '" AND departamento_id = ' . $localidades->departamento_id->GetValue() . ' AND localidad_id != ' . $recordID;
		//echo 'buscando con exclusión';
	} else {
		// insertando: busca en todos los registros
		$SQL = 'SELECT * FROM localidades WHERE localidad_nombre LIKE "' . $localidades->localidad_nombre->GetValue() . '" AND departamento_id = ' . $localidades->departamento_id->GetValue();
		//echo 'buscando sin exclusión';
	}
	
	$db->query($SQL);
    $localidadData = $db->next_record();

	// valida
	if ( !empty( $localidadData ) ) {
		$localidades->localidad_nombre->Errors->addError('Ya existe una localidad con ese nombre para el departamento.');
	}

	// cierra conexión
	$db->close();


// -------------------------
//End Custom Code

//Close localidades_localidad_nombre_OnValidate @10-49B02C0B
    return $localidades_localidad_nombre_OnValidate;
}
//End Close localidades_localidad_nombre_OnValidate


?>
