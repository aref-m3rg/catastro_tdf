<?php

//BindEvents Method @1-90E90F4E
function BindEvents()
{
    global $personasSearch;
    global $personas;
    global $personasEdit;
    global $CCSEvents;
    $personasSearch->s_persona_nro_doc->CCSEvents["BeforeShow"] = "personasSearch_s_persona_nro_doc_BeforeShow";
    $personasSearch->Button1->CCSEvents["OnClick"] = "personasSearch_Button1_OnClick";
    $personas->CCSEvents["BeforeShowRow"] = "personas_BeforeShowRow";
    $personasEdit->Button_Delete->CCSEvents["OnClick"] = "personasEdit_Button_Delete_OnClick";
    $personasEdit->CCSEvents["BeforeShow"] = "personasEdit_BeforeShow";
    $personasEdit->CCSEvents["OnValidate"] = "personasEdit_OnValidate";
    $personasEdit->CCSEvents["AfterUpdate"] = "personasEdit_AfterUpdate";
    $personasEdit->CCSEvents["AfterInsert"] = "personasEdit_AfterInsert";
    $personasEdit->CCSEvents["BeforeUpdate"] = "personasEdit_BeforeUpdate";
    $personasEdit->CCSEvents["BeforeInsert"] = "personasEdit_BeforeInsert";
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
}
//End BindEvents Method

//personasSearch_s_persona_nro_doc_BeforeShow @13-423444F0
function personasSearch_s_persona_nro_doc_BeforeShow(& $sender)
{
    $personasSearch_s_persona_nro_doc_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personasSearch; //Compatibility
//End personasSearch_s_persona_nro_doc_BeforeShow

//PTAutocomplete1 BeforeShow @14-FA92BE47
    $Component->Attributes->SetValue('id', 'personasSearchs_persona_nro_doc');
//End PTAutocomplete1 BeforeShow

//Close personasSearch_s_persona_nro_doc_BeforeShow @13-B8973565
    return $personasSearch_s_persona_nro_doc_BeforeShow;
}
//End Close personasSearch_s_persona_nro_doc_BeforeShow

//personasSearch_Button1_OnClick @122-641E9762
function personasSearch_Button1_OnClick(& $sender)
{
    $personasSearch_Button1_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personasSearch; //Compatibility
//End personasSearch_Button1_OnClick

//Custom Code @133-2A29BDB7
// -------------------------

    /* Redirecciona con parámetros para poder cargar
	   una nueva persona y relacionarla
	--------------------------------------------------- */

	$planos_prov_id = CCGetParam('planos_prov_id');

	header('Location: tc_addTitular.php?source=new&planos_prov_id='. $planos_prov_id );

	exit(); // si no hacemos el exit no alcanza a redireccionar :S



// -------------------------
//End Custom Code

//Close personasSearch_Button1_OnClick @122-C31FDACA
    return $personasSearch_Button1_OnClick;
}
//End Close personasSearch_Button1_OnClick

//personas_BeforeShowRow @24-B025649C
function personas_BeforeShowRow(& $sender)
{
    $personas_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personas; //Compatibility
//End personas_BeforeShowRow

//Set Row Style @50-982C9472
    $styles = array("Row", "AltRow");
    if (count($styles)) {
        $Style = $styles[($Component->RowNumber - 1) % count($styles)];
        if (strlen($Style) && !strpos($Style, "="))
            $Style = (strpos($Style, ":") ? 'style="' : 'class="'). $Style . '"';
        $Component->Attributes->SetValue("rowStyle", $Style);
    }
//End Set Row Style

//Close personas_BeforeShowRow @24-514EF97B
    return $personas_BeforeShowRow;
}
//End Close personas_BeforeShowRow

//personasEdit_Button_Delete_OnClick @130-ECDE129C
function personasEdit_Button_Delete_OnClick(& $sender)
{
    $personasEdit_Button_Delete_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personasEdit; //Compatibility
//End personasEdit_Button_Delete_OnClick

//Custom Code @132-2A29BDB7
// -------------------------


	/* Elimina la relación entre persona y parcela
	-------------------------------------------------- */

	$planos_parc_prov_personas_id = $Container->planos_parc_prov_personas_id->GetValue();

	if ( !empty( $planos_parc_prov_personas_id ) ) :

		$db = new clsDBtdf_nuevo();

		$db->query('DELETE FROM planos_parc_prov_personas WHERE planos_parc_prov_personas_id = ' . mysql_real_escape_string( $planos_parc_prov_personas_id ) );
		
		$db->close();

	endif;


// -------------------------
//End Custom Code

//Close personasEdit_Button_Delete_OnClick @130-DF9A5BEC
    return $personasEdit_Button_Delete_OnClick;
}
//End Close personasEdit_Button_Delete_OnClick

//personasEdit_BeforeShow @68-C949C696
function personasEdit_BeforeShow(& $sender)
{
    $personasEdit_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personasEdit; //Compatibility
//End personasEdit_BeforeShow

//Custom Code @100-2A29BDB7
// -------------------------


	/* Si se está editando trae los datos del dominio del
	   titular sobre la parcela 
	-------------------------------------------------------- */
	$planos_prov_id = CCGetParam('planos_prov_id');
	$persona_id = CCGetParam('persona_id');

	if ( !empty( $planos_prov_id ) && !empty( $persona_id )  ) :

		$db = new clsDBtdf_nuevo();

		$SQL = 'SELECT * FROM planos_parc_prov_personas WHERE planos_prov_id = ' . mysql_real_escape_string( $planos_prov_id ) . ' AND persona_id  = ' . mysql_real_escape_string( $persona_id ) . ' LIMIT 1';
		$db->query( $SQL );

		if ( $db->next_record() ) :

			// carga los valores en cada campo
			$Component->planos_parc_prov_personas_id->SetValue( $db->f( 'planos_parc_prov_personas_id') );
			$Component->tipo_persona_parcela_id->SetValue( $db->f( 'tipo_persona_parcela_id') );
			$Component->tipo_instrumento_id->SetValue( $db->f( 'tipo_instrumento_id') );
			$Component->persona_parcela_num_int->SetValue( $db->f( 'planos_parc_prov_personas_num_int') );
			$Component->persona_parcela_f_int->SetValue( CCParseDate( $db->f( 'planos_parc_prov_personas_f_int'), array("yyyy", "-", "mm", "-", "dd", " ", "HH", ":", "nn") ) );
			$Component->persona_parcela_dominio->SetValue( $db->f( 'planos_parc_prov_personas_dominio') );

		endif;

		$db->close();

	endif;



// -------------------------
//End Custom Code

//Close personasEdit_BeforeShow @68-45ACBBB8
    return $personasEdit_BeforeShow;
}
//End Close personasEdit_BeforeShow

//personasEdit_OnValidate @68-7F012BF2
function personasEdit_OnValidate(& $sender)
{
    $personasEdit_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personasEdit; //Compatibility
//End personasEdit_OnValidate

//Custom Code @102-2A29BDB7
// -------------------------

	/* Valida que se hayan completado los datos corresp. al dominio
	------------------------------------------------------------------- */
	$tipo_persona_parcela_id = $Component->tipo_persona_parcela_id->GetValue();
	$tipo_instrumento_id = $Component->tipo_instrumento_id->GetValue();
	$persona_parcela_num_int = $Component->persona_parcela_num_int->GetValue();
	$persona_parcela_dominio = $Component->persona_parcela_dominio->GetValue();
	$persona_parcela_f_int = $Component->persona_parcela_f_int->GetValue();

	if ( empty( $tipo_persona_parcela_id ) ) : $Component->Errors->addError("Indique la Figura del titular."); endif;
	if ( empty( $tipo_instrumento_id ) ) : $Component->Errors->addError("Indique el Tipo de Instrumento."); endif;
	

	/* Valida que no exista la persona al insertar o editar
	------------------------------------------------------------------- */
	$persona_id = $Component->persona_id->GetValue();
	$tipo_documento_id = $Component->tipo_documento_id->GetValue();
	$persona_nro_doc = $Component->persona_nro_doc->GetValue();

	$db = new clsDBtdf_nuevo();

	$personaData = checkPersona( $tipo_documento_id, $persona_nro_doc, $db, $persona_id, true );

	if ( !empty( $personaData ) ) {
		$Component->Errors->addError("Ya existe la persona que cargó con este tipo y nro. de documento, se encuentra como: " . $personaData['persona_denominacion']);
	}

	$db->close();






// -------------------------
//End Custom Code

//Close personasEdit_OnValidate @68-7A57DF31
    return $personasEdit_OnValidate;
}
//End Close personasEdit_OnValidate

//personasEdit_AfterUpdate @68-ABD73425
function personasEdit_AfterUpdate(& $sender)
{
    $personasEdit_AfterUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personasEdit; //Compatibility
//End personasEdit_AfterUpdate

//Custom Code @123-2A29BDB7
// -------------------------

	/* Guarda los datos de la relación entre personas y parcelas provisorias
	-------------------------------------------------------------------------- */

	$planos_parc_prov_personas_id = $Container->planos_parc_prov_personas_id->GetValue();

	$db = new clsDBtdf_nuevo();


	// si no hay ID de la relación inserta, si no actualiza
	if ( empty( $planos_parc_prov_personas_id ) ) :

		$sqlInsert  = 'INSERT INTO planos_parc_prov_personas';
		$sqlInsert .= ' SET tipo_persona_parcela_id = ' . mysql_real_escape_string( $Container->tipo_persona_parcela_id->GetValue() );
		$sqlInsert .= ', planos_prov_id = ' . mysql_real_escape_string( $Container->planos_prov_id->GetValue() );
		$sqlInsert .= ', persona_id = ' . mysql_real_escape_string( $Container->persona_id->GetValue() );
		$sqlInsert .= ', tipo_instrumento_id = ' . mysql_real_escape_string( $Container->tipo_instrumento_id->GetValue() );
		$sqlInsert .= ', planos_parc_prov_personas_num_int = "' . mysql_real_escape_string( $Container->persona_parcela_num_int->GetValue() ) . '"';
		$sqlInsert .= ', planos_parc_prov_personas_f_int = "' . mysql_real_escape_string( CCFormatDate( $Container->persona_parcela_f_int->GetValue(), array("yyyy", "-", "mm", "-", "dd", " ", "HH", ":", "nn") ) ) . '"';
		$sqlInsert .= ', planos_parc_prov_personas_dominio = ' . mysql_real_escape_string( $Container->persona_parcela_dominio->GetValue() );

    //debug($sqlInsert);
		$db->query( $sqlInsert );

	else:
		$sqlUpdate  = 'UPDATE planos_parc_prov_personas';
		$sqlUpdate .= ' SET tipo_persona_parcela_id = ' . mysql_real_escape_string( $Container->tipo_persona_parcela_id->GetValue() );
		$sqlUpdate .= ', tipo_instrumento_id = ' . mysql_real_escape_string( $Container->tipo_instrumento_id->GetValue() );
		$sqlUpdate .= ', planos_parc_prov_personas_num_int = "' . mysql_real_escape_string( $Container->persona_parcela_num_int->GetValue() ) . '"';
		$sqlUpdate .= ', planos_parc_prov_personas_f_int = "' . mysql_real_escape_string( CCFormatDate( $Container->persona_parcela_f_int->GetValue(), array("yyyy", "-", "mm", "-", "dd", " ", "HH", ":", "nn") ) ) . '"';
		$sqlUpdate .= ', planos_parc_prov_personas_dominio = ' . mysql_real_escape_string( $Container->persona_parcela_dominio->GetValue() );
		$sqlUpdate .= ' WHERE planos_parc_prov_personas_id = ' . mysql_real_escape_string( $planos_parc_prov_personas_id  );

		//debug($sqlUpdata);
    $db->query( $sqlUpdate );

	endif;

	$db->close();
	

// -------------------------
//End Custom Code

//Close personasEdit_AfterUpdate @68-737B6C45
    return $personasEdit_AfterUpdate;
}
//End Close personasEdit_AfterUpdate

//personasEdit_AfterInsert @68-DA4724C3
function personasEdit_AfterInsert(& $sender)
{
    $personasEdit_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personasEdit; //Compatibility
//End personasEdit_AfterInsert

//Custom Code @135-2A29BDB7
// -------------------------

	/* Guarda los datos de la rel. entre personas y parcelas provisorias
	   (despues de insertar la persona)
	------------------------------------------------------------------------- */
	$personaId = mysql_insert_id();

	if ( !empty( $personaId ) ) :

		$db = new clsDBtdf_nuevo();

		$sqlInsert  = 'INSERT INTO planos_parc_prov_personas';
		$sqlInsert .= ' SET tipo_persona_parcela_id = ' . mysql_real_escape_string( $Container->tipo_persona_parcela_id->GetValue() );
		$sqlInsert .= ', planos_prov_id = ' . mysql_real_escape_string( $Container->planos_prov_id->GetValue() );
		$sqlInsert .= ', persona_id = ' . mysql_real_escape_string( $personaId );
		$sqlInsert .= ', tipo_instrumento_id = ' . mysql_real_escape_string( $Container->tipo_instrumento_id->GetValue() );
		$sqlInsert .= ', planos_parc_prov_personas_num_int = "' . mysql_real_escape_string( $Container->persona_parcela_num_int->GetValue() ) . '"';
		$sqlInsert .= ', planos_parc_prov_personas_f_int = "' . mysql_real_escape_string( CCFormatDate( $Container->persona_parcela_f_int->GetValue(), array("yyyy", "-", "mm", "-", "dd", " ", "HH", ":", "nn") ) ) . '"';
		$sqlInsert .= ', planos_parc_prov_personas_dominio = ' . mysql_real_escape_string( $Container->persona_parcela_dominio->GetValue() );

		$db->query( $sqlInsert );

		$db->close();

	endif;


	/* Redirecciona a la misma página con el ID de la person insertada
	------------------------------------------------------------------------- */
	global $Redirect;
	$planosProvId = $Container->planos_prov_id->GetValue();

	$Redirect = 'tc_addTitular.php?persona_id=' . $personaId . '&planos_prov_id=' . $planosProvId . '&source=selected)';


// -------------------------
//End Custom Code

//Close personasEdit_AfterInsert @68-BC52ADCA
    return $personasEdit_AfterInsert;
}
//End Close personasEdit_AfterInsert

//personasEdit_BeforeUpdate @68-7A6537D0
function personasEdit_BeforeUpdate(& $sender)
{
    $personasEdit_BeforeUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personasEdit; //Compatibility
//End personasEdit_BeforeUpdate

//Custom Code @136-2A29BDB7
// -------------------------


	/* Actualiza el campo "denominación de la persona antes de guardar
	------------------------------------------------------------------------- */
	$Component->persona_denominacion->SetValue( trim( $Component->persona_apellido->GetValue()).' '.($Component->persona_nombre->GetValue()) );
    $Component->persona_f_proce->SetValue( date('Y-m-d H:i:s') );


// -------------------------
//End Custom Code

//Close personasEdit_BeforeUpdate @68-E50B0832
    return $personasEdit_BeforeUpdate;
}
//End Close personasEdit_BeforeUpdate

//personasEdit_BeforeInsert @68-23CC5417
function personasEdit_BeforeInsert(& $sender)
{
    $personasEdit_BeforeInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personasEdit; //Compatibility
//End personasEdit_BeforeInsert

//Custom Code @138-2A29BDB7
// -------------------------


	/* Actualiza el campo "denominación" de la persona antes de insertar
	------------------------------------------------------------------------- */
	$Component->persona_denominacion->SetValue( trim( $Component->persona_apellido->GetValue()).' '.($Component->persona_nombre->GetValue()) );

    $currentDate = date( 'Y-m-d H:i:s' );
	$Component->persona_f_proce->SetValue( $currentDate );
	$Component->persona_f_alta->SetValue( $currentDate );


// -------------------------
//End Custom Code

//Close personasEdit_BeforeInsert @68-2A22C9BD
    return $personasEdit_BeforeInsert;
}
//End Close personasEdit_BeforeInsert

//Page_BeforeInitialize @1-ED125A0B
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tc_addTitular; //Compatibility
//End Page_BeforeInitialize

//Custom Code @5-2A29BDB7
// -------------------------

	// Incluye el archivo de funciones generales
	include_once(RelativePath . "/scripts/myFunctions.php");


	// Incluye la gestión de permisos
	include_once(RelativePath . "/scripts/permisos1.php");

// -------------------------
//End Custom Code

//PTAutocomplete1 Initialization @14-76EE271D
    global $Charset;
    if ('personasSearchs_persona_nro_docPTAutocomplete1' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new ListFormatter());
//End PTAutocomplete1 Initialization

//PTAutocomplete1 DataSource @14-6229DCA5
        $Service->DataSource = new clsDBtdf_nuevo();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM personas {SQL_Where} {SQL_OrderBy}";
        $Service->DataSource->Parameters["posts_persona_nro_doc"] = CCGetFromPost("s_persona_nro_doc", NULL);
        $Service->DataSource->wp = new clsSQLParameters();
        $Service->DataSource->wp->AddParameter("1", "posts_persona_nro_doc", ccsText, "", "", $Service->DataSource->Parameters["posts_persona_nro_doc"], -1, false);
        $Service->DataSource->wp->Criterion[1] = $Service->DataSource->wp->Operation(opBeginsWith, "persona_nro_doc", $Service->DataSource->wp->GetDBValue("1"), $Service->DataSource->ToSQL($Service->DataSource->wp->GetDBValue("1"), ccsText),false);
        $Service->DataSource->Where = 
             $Service->DataSource->wp->Criterion[1];
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End PTAutocomplete1 DataSource

//PTAutocomplete1 Charset @14-4F7C968C
        $Service->AddHttpHeader("Content-type", "text/html; charset=" . $Charset);
//End PTAutocomplete1 Charset

//PTAutocomplete1 DataFields @14-E987230F
        $Service->AddDataSourceField('persona_nro_doc');
//End PTAutocomplete1 DataFields

//PTAutocomplete1 Execution @14-D749E478
        $Service->DisplayHeaders();
        echo $Service->Execute();
//End PTAutocomplete1 Execution

//PTAutocomplete1 Tail @14-27890EF8
        exit;
    }
//End PTAutocomplete1 Tail

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize

//Page_BeforeShow @1-19CCC4EE
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tc_addTitular; //Compatibility
//End Page_BeforeShow

//Custom Code @66-2A29BDB7
// -------------------------


	/* Si no se ha pasado el ID de la persona muestra el buscador
	   para seleccionar una existente
	---------------------------------------------------------------*/
	$personaId = CCGetParam('persona_id');
	$source = CCGetParam('source');

	if ( empty( $personaId ) && $source != 'new' ) :

		// muestra el buscador de personas
		$Container->personasSearch->Visible = true;
		$Container->personas->Visible = true;

		// oculta otras cosas
		$Container->personasEdit->Visible = false;

	else:

		// oculta el buscador de personas
		$Container->personasSearch->Visible = false;
		$Container->personas->Visible = false;

		switch( $source ) :

			// si se ha llegado desde seleccionar un parsona existente o para agregar nuevo...
			case 'selected':
				$Container->personasEdit->Visible = true;
				break;

			case 'editing':
				$Container->personasEdit->Visible = true;
				break;

			case 'new':
				$Container->personasEdit->Visible = true;
				break;

		endswitch;


	endif;



// -------------------------
//End Custom Code

//Close Page_BeforeShow @1-4BC230CD
    return $Page_BeforeShow;
}
//End Close Page_BeforeShow
?>
