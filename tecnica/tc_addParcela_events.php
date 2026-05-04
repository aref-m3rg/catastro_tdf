<?php
//BindEvents Method @1-FA39C3DC
function BindEvents()
{
    global $departamentos_planos_plan;
    global $parcelas;
    global $doc_tipos_personas_person;
    global $CCSEvents;
    $departamentos_planos_plan->plano->CCSEvents["BeforeShow"] = "departamentos_planos_plan_plano_BeforeShow";
    $parcelas->Button_Delete->CCSEvents["OnClick"] = "parcelas_Button_Delete_OnClick";
    $parcelas->Button_Cancel->CCSEvents["BeforeShow"] = "parcelas_Button_Cancel_BeforeShow";
    $parcelas->Button_Cancel->CCSEvents["OnClick"] = "parcelas_Button_Cancel_OnClick";
    $parcelas->CCSEvents["AfterInsert"] = "parcelas_AfterInsert";
    $parcelas->CCSEvents["BeforeShow"] = "parcelas_BeforeShow";
    $parcelas->CCSEvents["OnValidate"] = "parcelas_OnValidate";
    $parcelas->CCSEvents["AfterDelete"] = "parcelas_AfterDelete";
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

//parcelas_Button_Delete_OnClick @5-F031F9E1
function parcelas_Button_Delete_OnClick(& $sender)
{
    $parcelas_Button_Delete_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas; //Compatibility
//End parcelas_Button_Delete_OnClick

//Custom Code @218-2A29BDB7
// -------------------------

	$returnPage = CCGetParam('returnPage');

    // Si existe el paràmetro returnPage cambia la página de destino del botón
	if ( !empty($returnPage) ) {
		global $Redirect;
		$Redirect = $returnPage . ".php?plano_id=" . CCGetParam('plano_id') . "&planos_prov_id=" . CCGetParam('id') . "&ver=" . CCGetParam('ver');
	}

// -------------------------
//End Custom Code

//Close parcelas_Button_Delete_OnClick @5-5059AB42
    return $parcelas_Button_Delete_OnClick;
}
//End Close parcelas_Button_Delete_OnClick

//parcelas_Button_Cancel_BeforeShow @7-6993098A
function parcelas_Button_Cancel_BeforeShow(& $sender)
{
    $parcelas_Button_Cancel_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas; //Compatibility
//End parcelas_Button_Cancel_BeforeShow

//Custom Code @216-2A29BDB7
// -------------------------


// -------------------------
//End Custom Code

//Close parcelas_Button_Cancel_BeforeShow @7-07AB4B08
    return $parcelas_Button_Cancel_BeforeShow;
}
//End Close parcelas_Button_Cancel_BeforeShow

//parcelas_Button_Cancel_OnClick @7-78910902
function parcelas_Button_Cancel_OnClick(& $sender)
{
    $parcelas_Button_Cancel_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas; //Compatibility
//End parcelas_Button_Cancel_OnClick

//Custom Code @217-2A29BDB7
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

//parcelas_AfterInsert @2-29C724EB
function parcelas_AfterInsert(& $sender)
{
    $parcelas_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas; //Compatibility
//End parcelas_AfterInsert

//Custom Code @62-2A29BDB7
// -------------------------

	global $Redirect;
	$returnPage = CCGetParam('returnPage');

	/* Después de insertar redirecciona acá mismo
	   con el ID para seguir editando
	------------------------------------------------------ */

	// obtiene el ID del insert
	$id = mysql_insert_id();

	// redirecciona a esta misma página con el ID para editar
	$Redirect = "tc_addParcela.php?plano_id=" . CCGetParam(plano_id) . "&planos_prov_id=" . $id . "&ver=" . CCGetParam(ver) . "&returnPage=" . $returnPage;



// -------------------------
//End Custom Code

//Close parcelas_AfterInsert @2-BE816403
    return $parcelas_AfterInsert;
}
//End Close parcelas_AfterInsert

//parcelas_BeforeShow @2-3DB6FDDD
function parcelas_BeforeShow(& $sender)
{
    $parcelas_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas; //Compatibility
//End parcelas_BeforeShow

//Custom Code @64-2A29BDB7
// -------------------------


	$db = new clsDBtdf_nuevo();


	/* Trae el departamento asignado al plano y lo completa en el campo
	----------------------------------------------------------------------- */
	$planoId = CCGetParam( 'plano_id' );

	if ( !empty( $planoId ) ){
		
		// busco el departamento asignado al plano
		$dpto_id = CCDLookUp( 'tipo_depto_parc_id', 'planos', 'plano_id = ' . $planoId, $db);

		$Component->dpto_id->SetValue( $dpto_id );

	}

	$db->close();

// -------------------------
//End Custom Code

//Close parcelas_BeforeShow @2-FBF6787B
    return $parcelas_BeforeShow;
}
//End Close parcelas_BeforeShow

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


	$db = new clsDBtdf_nuevo();


	/* Validar que no se repita la nomenclatura segun departamento 
	----------------------------------------------------------------- */

	$dpto_id = $Component->dpto_id->GetValue();
	$planos_prov_id = CCGetParam('planos_prov_id');

	/* --Crea el identificador de nomenclatura para buscarlo */
	$nomenclatura = array(
		$Component->parcela_seccion->GetValue(),
		$Component->parcela_chacra->GetValue(),
		$Component->parcela_quinta->GetValue(),
		$Component->parcela_macizo->GetValue(),
		$Component->parcela_fraccion->GetValue(),
		$Component->parcela_parcela->GetValue(),
		$Component->parcela_uf->GetValue(),
		$Component->parcela_predio->GetValue(),
		$Component->parcela_rte->GetValue()
	);

	$nom = implode( '-', $nomenclatura );


	/* -- Busco en las parcelas y en las parcelas provisorias si existe una con la misma nomenclatura */
	if ( !empty( $dpto_id ) ){
		
		/* -- Chequea si existe la parcela ya creada */
		$SQL = '
			SELECT COUNT(*) AS cant
			FROM parcelas
			WHERE
			  parcelas.tipo_depto_parc_id = ' . $dpto_id . '
			  AND CONCAT_WS("-",IFNULL(parcela_seccion,""),IFNULL(parcela_chacra,""),IFNULL(parcela_quinta,""), IFNULL(parcela_macizo,""),IFNULL(parcela_fraccion,""),IFNULL(parcela_parcela,""), IFNULL(parcela_uf,""),IFNULL(parcela_predio,""),IFNULL(parcela_rte,"")) = "' . $nom . '"';

		$db->query( $SQL );
		$db->next_record();
		$queryData = CCArrayFromConnection($db);

		// si hay alguna agrega un error
		if ( !empty( $queryData['cant'] ) ) {
			$errors[] = 'Ya existe una parcela con esta nomenclatura para el departamento.';
		}



		/* -- Chequea si no existe ya como parcela a crear */
		/*
		$SQL = '
			SELECT COUNT(*) AS cant
			FROM planos_parc_prov
			WHERE tipo_depto_parc_id = ' . $dpto_id . ' AND CONCAT_WS("-",IFNULL(planos_prov_seccion,""),IFNULL(planos_prov_chacra,""),IFNULL(planos_prov_quinta,""), IFNULL(planos_prov_macizo,""),IFNULL(planos_prov_fraccion,""),IFNULL(planos_prov_parcela,""), IFNULL(planos_prov_uf,""),IFNULL(planos_prov_predio,""),IFNULL(planos_prov_rte,"")) = "' . $nom . '"';
		*/
		$SQL = '
			SELECT COUNT(*) AS cant, planos_parc_prov.plano_id AS plano_id, planos_parc_prov.tipo_depto_parc_id AS depto, plano_nro AS nro, plano_anio AS anio
			FROM planos_parc_prov INNER JOIN planos ON planos_parc_prov.plano_id = planos.plano_id
			WHERE planos_parc_prov.tipo_depto_parc_id = ' . $dpto_id . ' AND CONCAT_WS("-",IFNULL(planos_prov_seccion,""),IFNULL(planos_prov_chacra,""),IFNULL(planos_prov_quinta,""), IFNULL(planos_prov_macizo,""),IFNULL(planos_prov_fraccion,""),IFNULL(planos_prov_parcela,""), IFNULL(planos_prov_uf,""),IFNULL(planos_prov_predio,""),IFNULL(planos_prov_rte,"")) = "' . $nom . '"';

		// excluye el registro actual si se está editando
		if ( !empty( $planos_prov_id ) ) {
			$SQL .= ' AND planos_parc_prov.planos_prov_id <> ' . $planos_prov_id; 
		}

		$db->query( $SQL );
		$db->next_record();
		$queryData = CCArrayFromConnection($db);

		// si hay alguna agrega un error
		if ( !empty( $queryData['cant'] ) ) {
			$errors[] = "Ya existe una parcela a crear con esta nomenclatura para el departamento. Plano <a href='tc_planosRecord.php?plano_id=".$queryData['plano_id']."'>" . $queryData['depto'] . '-'.$queryData['nro'].'-'.$queryData['anio']."</a>";
		}


		/* -- Errores en el formulario */
		if ( !empty( $errors ) ) {

			$error = implode('<br>', $errors);
			$Component->Errors->AddError( $error );

		}
	
	}



// -------------------------
//End Custom Code

//Close parcelas_OnValidate @2-C40D1CF2
    return $parcelas_OnValidate;
}
//End Close parcelas_OnValidate

//parcelas_AfterDelete @2-740B2B0F
function parcelas_AfterDelete(& $sender)
{
    $parcelas_AfterDelete = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas; //Compatibility
//End parcelas_AfterDelete

//Custom Code @194-2A29BDB7
// -------------------------


    /* Después de eliminar la parcela provisoria elimina
	   las personas relacionadas en la tabla temporal
	--------------------------------------------------- */

	$planos_prov_id = CCGetParam('planos_prov_id');

	if ( !empty( $planos_prov_id ) ) {
		$db = new clsDBtdf_nuevo();
		$query = 'DELETE FROM planos_parc_prov_personas WHERE planos_prov_id = ' . mysql_real_escape_string( $planos_prov_id );
		$db->query( $query );
		$db->close();
	}


// -------------------------
//End Custom Code

//Close parcelas_AfterDelete @2-ED8C03FD
    return $parcelas_AfterDelete;
}
//End Close parcelas_AfterDelete

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

//Page_BeforeInitialize @1-AFF67E61
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tc_addParcela; //Compatibility
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
