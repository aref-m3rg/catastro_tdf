<?php
//BindEvents Method @1-54B74D59
function BindEvents()
{
    global $personas;
    global $CCSEvents;
    $personas->add_persona->CCSEvents["BeforeShow"] = "personas_add_persona_BeforeShow";
    $personas->CCSEvents["BeforeUpdate"] = "personas_BeforeUpdate";
    $personas->CCSEvents["OnValidate"] = "personas_OnValidate";
    $personas->CCSEvents["BeforeShow"] = "personas_BeforeShow";
    $personas->CCSEvents["AfterUpdate"] = "personas_AfterUpdate";
}
//End BindEvents Method

//personas_add_persona_BeforeShow @53-488C2869
function personas_add_persona_BeforeShow(& $sender)
{
    $personas_add_persona_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personas; //Compatibility
//End personas_add_persona_BeforeShow

//Custom Code @56-2A29BDB7
// -------------------------


  /* Modifica el enlace agregando la URL codificada y la key de regreso */
  global $FileName;
  $returnPage = rawurlencode( $FileName ); // debug( $returnPage );
  $returnParams = rawurlencode( CCGetQueryString('QueryString', array() ) ); // debug( $returnParams );
  $returnKey = 'persona_relacionada_id';
  $Component->SetLink( 'buscaPersonasGral.php?return_page=' . $returnPage . '&return_params=' . $returnParams . '&return_key=' . $returnKey );


// -------------------------
//End Custom Code

//Close personas_add_persona_BeforeShow @53-9EAD6AC6
    return $personas_add_persona_BeforeShow;
}
//End Close personas_add_persona_BeforeShow

//personas_BeforeUpdate @2-939AC6C3
function personas_BeforeUpdate(& $sender)
{
    $personas_BeforeUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personas; //Compatibility
//End personas_BeforeUpdate

//Custom Code @23-2A29BDB7
// -------------------------
	$personas->persona_denominacion->SetValue($personas->persona_apellido->GetValue().' '.$personas->persona_nombre->GetValue());
    $personas->persona_f_proce->SetValue(date('Y-m-d H:i:s'));
// -------------------------
//End Custom Code

//Close personas_BeforeUpdate @2-C317E93D
    return $personas_BeforeUpdate;
}
//End Close personas_BeforeUpdate

//personas_OnValidate @2-808A0718
function personas_OnValidate(& $sender)
{
    $personas_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personas; //Compatibility
//End personas_OnValidate

//Custom Code @50-2A29BDB7
// -------------------------

  /* Validación selectiva de acuerdo a la figura legal
  ---------------------------------------------------------- */

	if ( $personas->persona_cuit->GetValue() == '' && $personas->persona_nro_doc->GetValue() == '' ) {
		$personas->persona_nro_doc->SetValue("0");
		$personas->tipo_documento_id->SetValue(7);
	  //$personas->Errors->addError("Debe cargar un numero de documento o CUIT.");
	}


  if ( $personas->tipo_persona_id->GetValue() == 2 ) {

    /* Persona jurídica */

    $persRazSoc = $personas->persona_apellido->GetValue();
    if ( empty( $persRazSoc ) ) {
      $personas->Errors->addError("Debe completar la Razón Social");
    }


  } else {

    /* Persona física */

    $persNombre = $personas->persona_nombre->GetValue();
    $persApellido = $personas->persona_apellido->GetValue();
    if ( empty( $persNombre ) || empty( $persApellido ) ) {
      $personas->Errors->addError("Debe completar Nombre y Apellido");
    }

    
  }



// -------------------------
//End Custom Code

//Close personas_OnValidate @2-11CF5189
    return $personas_OnValidate;
}
//End Close personas_OnValidate

//personas_BeforeShow @2-A554E3E6
function personas_BeforeShow(& $sender)
{
    $personas_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personas; //Compatibility
//End personas_BeforeShow

//Custom Code @57-2A29BDB7
// -------------------------

  $db = new clsDBtdf_nuevo();

  /* Determina qué mostrar en el label de persona seleccionada y los links */

  // Si viene el ID de persona en la URL tiene total prioridad

  $personaId = CCGetParam('persona_relacionada_id' );

  if ( !empty( $personaId ) ) {

    // busca la persona y la muestra en el label y carga el campo oculto con su id
    $SQL = 'SELECT * from personas WHERE persona_id = ' . mysql_real_escape_string( $personaId );
    $responsable = CCQueryToArray( $SQL, $db ); //debug( $responsable );

    if ( !empty( $responsable ) )  {
      // carga los valores
      $Component->persona_relacionada_id->SetValue( $responsable[0]['persona_id'] );
      $Component->persona_relacionada->SetValue( $responsable[0]['persona_denominacion'] . ' (Doc. Nro: ' . $responsable[0]['persona_nro_doc'] . ')' );
      // muestra/oculta los enlaces
      $Component->add_persona->Visible = false;
      $Component->remove_persona->Visible = true;
    } else {
      // carga lo valores
      $Component->persona_relacionada->SetValue( '(no hay resonsables asignados)' );
      $Component->persona_relacionada_id->SetValue( '' );
      // muestra/oculta los enlaces
      $Component->add_persona->Visible = true;
      $Component->remove_persona->Visible = false;
    }

  } else if ( $Component->ds->f('persona_relacionada_id') ) {

      // Si la persona ya estaba relacionada en la DDBB

      // busca la persona y la muestra en el label y carga el campo oculto con su id
      $SQL = 'SELECT * from personas WHERE persona_id = ' . mysql_real_escape_string( $Component->ds->f('persona_relacionada_id') );
      $responsable = CCQueryToArray( $SQL, $db ); //debug( $responsable );

      $Component->persona_relacionada_id->SetValue( $responsable[0]['persona_id'] );
      $Component->persona_relacionada->SetValue( $responsable[0]['persona_denominacion'] . ' (Doc. Nro: ' . $responsable[0]['persona_nro_doc'] . ')' );
      // muestra/oculta los enlaces
      $Component->add_persona->Visible = false;
      $Component->remove_persona->Visible = true;

  } else {

      $Component->persona_relacionada->SetValue( '(no hay resonsables asignados)' );
      $Component->persona_relacionada_id->SetValue( '' );
      // muestra/oculta los enlaces
      $Component->add_persona->Visible = true;
      $Component->remove_persona->Visible = false;

  }



  // Si se indica remover la persona (si no viene seleccionada)

  $remover = CCGetParam('remove');

  if ( !empty( $remover ) && empty( $personaId ) ) {

    $Component->persona_relacionada->SetValue( '(Resonsable desvinculado. Actualizar para confirmar.)' );
    $Component->persona_relacionada_id->SetValue( '' );
    // muestra/oculta los enlaces
    $Component->add_persona->Visible = true;
    $Component->remove_persona->Visible = false;

  }



// -------------------------
//End Custom Code

//Close personas_BeforeShow @2-2E343500
    return $personas_BeforeShow;
}
//End Close personas_BeforeShow

//personas_AfterUpdate @2-B36B36F6
function personas_AfterUpdate(& $sender)
{
    $personas_AfterUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personas; //Compatibility
//End personas_AfterUpdate

//Custom Code @59-2A29BDB7
// -------------------------
	$persona_id = CCGetParam('persona_id');
	$audit_string = implode('|',array(CCGetUserID(),$_SERVER[REMOTE_ADDR],substr(strrchr ($_SERVER['PHP_SELF'], "/"), 1)));
	$db = new clsDBtdf_nuevo();
	$SQL = "UPDATE personas SET 
					persona_f_proce = NOW(),
					audit_string = '$audit_string'
			WHERE persona_id = $persona_id";
	$db->query($SQL);
	$db->close();
// -------------------------
//End Custom Code

//Close personas_AfterUpdate @2-B6AACF75
    return $personas_AfterUpdate;
}
//End Close personas_AfterUpdate

//Page_BeforeInitialize @1-202DC09D
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $EditPersona; //Compatibility
//End Page_BeforeInitialize

//Custom Code @49-2A29BDB7
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
