<?php
//BindEvents Method @1-03E70A9F
function BindEvents()
{
    global $departamentos_planos_plan;
    global $parcelas;
    global $doc_tipos_personas_person;
    global $CCSEvents;
    $departamentos_planos_plan->plano->CCSEvents["BeforeShow"] = "departamentos_planos_plan_plano_BeforeShow";
    $parcelas->Button_Cancel->CCSEvents["OnClick"] = "parcelas_Button_Cancel_OnClick";
    $parcelas->CCSEvents["OnValidate"] = "parcelas_OnValidate";
    $doc_tipos_personas_person->doc_tipos_personas_person_TotalRecords->CCSEvents["BeforeShow"] = "doc_tipos_personas_person_doc_tipos_personas_person_TotalRecords_BeforeShow";
    $doc_tipos_personas_person->CCSEvents["BeforeShow"] = "doc_tipos_personas_person_BeforeShow";
    $doc_tipos_personas_person->CCSEvents["BeforeShowRow"] = "doc_tipos_personas_person_BeforeShowRow";
}
//End BindEvents Method

//departamentos_planos_plan_plano_BeforeShow @94-4E0971B6
function departamentos_planos_plan_plano_BeforeShow(& $sender)
{
    $departamentos_planos_plan_plano_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $departamentos_planos_plan; //Compatibility
//End departamentos_planos_plan_plano_BeforeShow

//Custom Code @177-2A29BDB7
// -------------------------

	$db = new clsDBtdf_nuevo();

	/* Calcula el Nro. de plano para mostrar en el detalle
	-------------------------------------------------------------- */
	$planoId = CCGetParam('plano_id');

	if ( !empty( $planoId ) ) {
		// busco los datos del plano
		$nro_plano = obtenerPlano( $planoId, false, false, $db );

		if ( !empty( $nro_plano ) ) {
			// si lo obtengo seteo el valor en el label
			$Component->SetValue( $nro_plano );
		}
	}


	$db->close();


// -------------------------
//End Custom Code

//Close departamentos_planos_plan_plano_BeforeShow @94-9C96B931
    return $departamentos_planos_plan_plano_BeforeShow;
}
//End Close departamentos_planos_plan_plano_BeforeShow

//parcelas_Button_Cancel_OnClick @7-78910902
function parcelas_Button_Cancel_OnClick(& $sender)
{
    $parcelas_Button_Cancel_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas; //Compatibility
//End parcelas_Button_Cancel_OnClick

//Custom Code @238-2A29BDB7
// -------------------------

	$returnPage = CCGetParam('returnPage');

    // Si existe el paràmetro returnPage cambia la página de destino del botón
	if ( !empty($returnPage) ) {
		global $Redirect;
		$Redirect = $returnPage . ".php?plano_id=" . CCGetParam('plano_id') . "&planos_prov_id=" . CCGetParam('id') . "&ver=" . CCGetParam('ver');
	}


// -------------------------
//End Custom Code

//Close parcelas_Button_Cancel_OnClick @7-8AA7B232
    return $parcelas_Button_Cancel_OnClick;
}
//End Close parcelas_Button_Cancel_OnClick

//DEL  // -------------------------
//DEL  
//DEL  	global $Redirect;
//DEL  
//DEL  	/* Después de insertar redirecciona acá mismo
//DEL  	   con el ID para seguir editando
//DEL  	------------------------------------------------------ */
//DEL  
//DEL  	// obtiene el ID del insert
//DEL  	$id = mysql_insert_id();
//DEL  
//DEL  	// redirecciona a esta misma página con el ID para editar
//DEL  	$Redirect = "tc_addParcela.php?plano_id=" . CCGetParam(plano_id) . "&planos_prov_id=" . $id . "&ver=" . CCGetParam(ver);
//DEL  
//DEL  
//DEL  
//DEL  // -------------------------

//DEL  // -------------------------
//DEL  
//DEL  
//DEL  	$db = new clsDBtdf_nuevo();
//DEL  
//DEL  
//DEL  	/* Trae el departamento asignado al plano y lo completa en el campo
//DEL  	----------------------------------------------------------------------- */
//DEL  	$planoId = CCGetParam( 'plano_id' );
//DEL  
//DEL  	if ( !empty( $planoId ) ){
//DEL  		
//DEL  		// busco el departamento asignado al plano
//DEL  		$dpto_id = CCDLookUp( 'tipo_depto_parc_id', 'planos', 'plano_id = ' . $planoId, $db);
//DEL  
//DEL  		$Component->dpto_id->SetValue( $dpto_id );
//DEL  
//DEL  	}
//DEL  
//DEL  	$db->close();
//DEL  
//DEL  // -------------------------

//parcelas_OnValidate @2-18681923
function parcelas_OnValidate(& $sender)
{
    $parcelas_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas; //Compatibility
//End parcelas_OnValidate

//Custom Code @66-2A29BDB7
// -------------------------


// -------------------------
//End Custom Code

//Close parcelas_OnValidate @2-C40D1CF2
    return $parcelas_OnValidate;
}
//End Close parcelas_OnValidate

//DEL  // -------------------------
//DEL  
//DEL  
//DEL      /* Después de eliminar la parcela provisoria elimina
//DEL  	   las personas relacionadas en la tabla temporal
//DEL  	--------------------------------------------------- */
//DEL  
//DEL  	$planos_prov_id = CCGetParam('planos_prov_id');
//DEL  
//DEL  	if ( !empty( $planos_prov_id ) ) {
//DEL  		$db = new clsDBtdf_nuevo();
//DEL  		$query = 'DELETE FROM planos_parc_prov_personas WHERE planos_prov_id = ' . mysql_real_escape_string( $planos_prov_id );
//DEL  		$db->query( $query );
//DEL  		$db->close();
//DEL  	}
//DEL  
//DEL  
//DEL  // -------------------------

//doc_tipos_personas_person_doc_tipos_personas_person_TotalRecords_BeforeShow @111-71101C92
function doc_tipos_personas_person_doc_tipos_personas_person_TotalRecords_BeforeShow(& $sender)
{
    $doc_tipos_personas_person_doc_tipos_personas_person_TotalRecords_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $doc_tipos_personas_person; //Compatibility
//End doc_tipos_personas_person_doc_tipos_personas_person_TotalRecords_BeforeShow

//Retrieve number of records @112-ABE656B4
    $Component->SetValue($Container->DataSource->RecordsCount);
//End Retrieve number of records

//Close doc_tipos_personas_person_doc_tipos_personas_person_TotalRecords_BeforeShow @111-14E38D83
    return $doc_tipos_personas_person_doc_tipos_personas_person_TotalRecords_BeforeShow;
}
//End Close doc_tipos_personas_person_doc_tipos_personas_person_TotalRecords_BeforeShow

//doc_tipos_personas_person_BeforeShow @110-08F5946B
function doc_tipos_personas_person_BeforeShow(& $sender)
{
    $doc_tipos_personas_person_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $doc_tipos_personas_person; //Compatibility
//End doc_tipos_personas_person_BeforeShow

//Custom Code @117-2A29BDB7
// -------------------------

	// Momentaneamente oculta este listado
	$Component->Visible = false;


    /* Determina la visibilidad del listado de titulares
	   de acuerdo a si está el parámetro de parc.
	------------------------------------------------------ */
	$planos_prov_id = CCGetParam( 'planos_prov_id' );

	if ( empty( $planos_prov_id ) ) {
		$Component->Visible = false;
	}


    /* Genera el enlace del popup de agregar personas
    ------------------------------------------------------ */
	$lnk = "tc_addTitular.php?planos_prov_id=" . $planos_prov_id;
	$newlnk="$lnk\" onclick=\"javascript:window.open(this.href,'','width=800,height=500,top='+(screen.height-600)/2+',left='+(screen.width-870)/2+',scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=yes');return false;";
	$Component->ImageLink1->SetLink($newlnk);



// -------------------------
//End Custom Code

//Close doc_tipos_personas_person_BeforeShow @110-81E54329
    return $doc_tipos_personas_person_BeforeShow;
}
//End Close doc_tipos_personas_person_BeforeShow

//doc_tipos_personas_person_BeforeShowRow @110-C9A8E379
function doc_tipos_personas_person_BeforeShowRow(& $sender)
{
    $doc_tipos_personas_person_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $doc_tipos_personas_person; //Compatibility
//End doc_tipos_personas_person_BeforeShowRow

//Custom Code @132-2A29BDB7
// -------------------------

    /* Genera el enlace del popup de editar personas
    ------------------------------------------------------ */
	$persona_id = $Component->ds->f('persona_id');
	$planos_prov_id = CCGetParam( 'planos_prov_id' );

	if ( !empty( $persona_id ) && !empty( $planos_prov_id ) ) :

		$lnk = "tc_addTitular.php?persona_id=" . $persona_id . "&planos_prov_id=" . $planos_prov_id . "&source=editing";
		$newlnk="$lnk\" onclick=\"javascript:window.open(this.href,'','width=800,height=500,top='+(screen.height-400)/2+',left='+(screen.width-380)/2+',scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=yes');return false;";
		$Component->ImageLink2->SetLink($newlnk);

	endif;



// -------------------------
//End Custom Code

//Close doc_tipos_personas_person_BeforeShowRow @110-EE63B889
    return $doc_tipos_personas_person_BeforeShowRow;
}
//End Close doc_tipos_personas_person_BeforeShowRow

//Page_BeforeInitialize @1-71CA68F5
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tc_addParcelaExistente; //Compatibility
//End Page_BeforeInitialize

//Custom Code @178-2A29BDB7
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
