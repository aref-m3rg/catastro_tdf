<?php
//BindEvents Method @1-9301A3F7
function BindEvents()
{
    global $planos;
    global $parcelas_destino;
    global $parcelas_origen;
    global $CCSEvents;
    $planos->CCSEvents["BeforeShow"] = "planos_BeforeShow";
    $parcelas_destino->CCSEvents["BeforeShowRow"] = "parcelas_destino_BeforeShowRow";
    $parcelas_destino->CCSEvents["BeforeShow"] = "parcelas_destino_BeforeShow";
    $parcelas_origen->CCSEvents["BeforeShowRow"] = "parcelas_origen_BeforeShowRow";
    $parcelas_origen->CCSEvents["BeforeShow"] = "parcelas_origen_BeforeShow";
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
}
//End BindEvents Method


//planos_BeforeShow @5-F6E56A0C
function planos_BeforeShow(& $sender)
{
    $planos_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planos; //Compatibility
//End planos_BeforeShow

//Custom Code @52-2A29BDB7
// -------------------------


	$db = new clsDBtdf_nuevo();

	/* Trae el dato del estado actual del plano p/ el label
	--------------------------------------------------------- */
	$estadoPlano = $Component->DataSource->f('tipo_estado_plano_id');
	if ( !empty( $estadoPlano ) ) {
		$estadoPlanoNombre = CCDLookUp('tipo_estado_plano_desc', 'tipos_estados_planos', 'tipo_estado_plano_id = ' . $estadoPlano, $db );
		if ( !empty( $estadoPlanoNombre ) ) {
			$Component->plano_estado_desc->SetValue( $estadoPlanoNombre );
		}
	}

	$planoSvc = $estadoPlano = $Component->DataSource->f('plano_svc');
	$planoSvcLabel = ($planoSvc == 1) ? 'Sí': 'No';
	$Component->plano_svc->SetValue( $planoSvcLabel );

	$planoSinOrig = $estadoPlano = $Component->DataSource->f('plano_sin_origen');
	$planoSinOrigLabel = ($planoSinOrig == 1) ? 'Sí': 'No';
	$Component->plano_sin_origen->SetValue( $planoSinOrigLabel );


	$db->close();


// -------------------------
//End Custom Code

//Close planos_BeforeShow @5-2AC242DA
    return $planos_BeforeShow;
}
//End Close planos_BeforeShow

//parcelas_destino_BeforeShowRow @437-2A12CC57
function parcelas_destino_BeforeShowRow(& $sender)
{
    $parcelas_destino_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_destino; //Compatibility
//End parcelas_destino_BeforeShowRow

//Set Row Style @466-982C9472
    $styles = array("Row", "AltRow");
    if (count($styles)) {
        $Style = $styles[($Component->RowNumber - 1) % count($styles)];
        if (strlen($Style) && !strpos($Style, "="))
            $Style = (strpos($Style, ":") ? 'style="' : 'class="'). $Style . '"';
        $Component->Attributes->SetValue("rowStyle", $Style);
    }
//End Set Row Style

//Custom Code @467-2A29BDB7
// -------------------------

	global $planos;

	$db = new clsDBtdf_nuevo();
	$planoEstado = $planos->ds->f('tipo_estado_plano_id'); //debug( $planoEstado );
	$planoId = CCGetParam('plano_id');


	// obtenemos el ID de la parcela dependiendo de si se seleccionó o creó
	$parcela_id = $Component->ds->f('parcela_id');


	if ( !empty( $parcela_id ) ) {

		// si existe el ID de la parcela es que la parcela fue seleccionada

		/* Calcula el Nro. de plano para mostrar en la fila
		-------------------------------------------------------------- */
		$parcelaPlano = CCDLookUp('plano_id', 'uniones_desgloses', 'parcela_destino_id = ' . $parcela_id, $db );

		// busco los datos del plano
		if ( $parcelaPlano == $planoId ) {
			$Component->plano->SetValue( '(plano actual)' );
		} else {
			$nro_plano = obtenerPlano( false, $parcela_id, false, $db );
			if ( !empty( $nro_plano ) ) {
				// si lo obtengo seteo el valor en el label
				$Component->plano->SetValue( $nro_plano );
			}
		}

	}


	$db->close();


// -------------------------
//End Custom Code

//Close parcelas_destino_BeforeShowRow @437-86F6F126
    return $parcelas_destino_BeforeShowRow;
}
//End Close parcelas_destino_BeforeShowRow

//parcelas_destino_BeforeShow @437-2D374F7B
function parcelas_destino_BeforeShow(& $sender)
{
    $parcelas_destino_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_destino; //Compatibility
//End parcelas_destino_BeforeShow

//Custom Code @468-2A29BDB7
// -------------------------



// -------------------------
//End Custom Code

//Close parcelas_destino_BeforeShow @437-524AAF8E
    return $parcelas_destino_BeforeShow;
}
//End Close parcelas_destino_BeforeShow

//parcelas_origen_BeforeShowRow @541-EB95A597
function parcelas_origen_BeforeShowRow(& $sender)
{
    $parcelas_origen_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_origen; //Compatibility
//End parcelas_origen_BeforeShowRow

//Set Row Style @558-982C9472
    $styles = array("Row", "AltRow");
    if (count($styles)) {
        $Style = $styles[($Component->RowNumber - 1) % count($styles)];
        if (strlen($Style) && !strpos($Style, "="))
            $Style = (strpos($Style, ":") ? 'style="' : 'class="'). $Style . '"';
        $Component->Attributes->SetValue("rowStyle", $Style);
    }
//End Set Row Style

//Custom Code @559-2A29BDB7
// -------------------------

	global $planos;

	$db = new clsDBtdf_nuevo();
	$planoEstado = $planos->ds->f('tipo_estado_plano_id'); //debug( $planoEstado );
	$planoId = CCGetParam('plano_id');


	// obtenemos el ID de la parcela dependiendo de si se seleccionó o creó
	$parcela_id = $Component->ds->f('parcela_id');


	if ( !empty( $parcela_id ) ) {

		// si existe el ID de la parcela es que la parcela fue seleccionada

		/* Calcula el Nro. de plano para mostrar en la fila
		-------------------------------------------------------------- */
		$parcelaPlano = CCDLookUp('plano_id', 'uniones_desgloses', 'parcela_destino_id = ' . $parcela_id, $db );

		// busco los datos del plano
		if ( $parcelaPlano == $planoId ) {
			$Component->plano->SetValue( '(plano actual)' );
		} else {
			$nro_plano = obtenerPlano( false, $parcela_id, false, $db );
			if ( !empty( $nro_plano ) ) {
				// si lo obtengo seteo el valor en el label
				$Component->plano->SetValue( $nro_plano );
			}
		}

	}


	$db->close();


// -------------------------
//End Custom Code

//Close parcelas_origen_BeforeShowRow @541-8769B310
    return $parcelas_origen_BeforeShowRow;
}
//End Close parcelas_origen_BeforeShowRow

//parcelas_origen_BeforeShow @541-2233897E
function parcelas_origen_BeforeShow(& $sender)
{
    $parcelas_origen_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_origen; //Compatibility
//End parcelas_origen_BeforeShow

//Custom Code @560-2A29BDB7
// -------------------------



// -------------------------
//End Custom Code

//Close parcelas_origen_BeforeShow @541-97433365
    return $parcelas_origen_BeforeShow;
}
//End Close parcelas_origen_BeforeShow

//Page_BeforeShow @1-986A5FF2
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tc_planosVista; //Compatibility
//End Page_BeforeShow

//Custom Code @210-2A29BDB7
// -------------------------


	$db = new clsDBtdf_nuevo();


	/* Determina visibilidad de componentes al cargar la página
	-------------------------------------------------------------- */

	$paramPlanoId = CCGetParam('plano_id', false);

	// si no existe el ID (modo insert)
	if( empty( $paramPlanoId ) ) {

		// no mostrar listado de parcelas origen ni destino prov
		$Component->parcelas_origen_prov->Visible = false;
		$Component->parcelas_destino_prov->Visible = false;

		// no mostrar listado de parcelas origen ni destino definitivas
		$Component->parcelas_origen->Visible = false;
		$Component->parcelas_destino->Visible = false;

		// mostrar botones: crear y volver
		$Component->planos->Button_Archivar->Visible = false;
		$Component->planos->Button_Anular->Visible = false;
		$Component->planos->Button_Suspender->Visible = false;
		$Component->planos->Button_Registrar->Visible = false;
		$Component->planos->Button_Vigencia->Visible = false;


	// si existe el ID (modo edit)
	} else {

		/* De acuerdo al estado mostrar los distintos grids y botones */

		// obtiene el estado actual del plano, si es SVC y si está en edición
		$estadoPlano = CCDLookUp('tipo_estado_plano_id', 'planos', 'plano_id = ' . $paramPlanoId, $db); #debug( $estadoPlano );

		$planoSVC = CCDLookUp('plano_svc', 'planos', 'plano_id = ' . $paramPlanoId, $db);
		$isPlanoSVC = ( !empty($planoSVC) ) ? true : false;

		$planoEdicion = CCDLookUp('plano_en_edicion', 'planos', 'plano_id = ' . $paramPlanoId, $db);
		$isPlanoEdicion = ( !empty($planoEdicion) ) ? true : false;


		switch( $estadoPlano ) :
			
			// Si está "En Trámite" (id = 5)
			case 5:

				// PO provisorias
				$Component->parcelas_origen_prov->Visible = true;
				$Component->parcelas_origen_prov->DeleteAllowed  = true;

				// PO definitivas
				$Component->parcelas_origen->Visible = false;

				// PD provisorias
				$Component->parcelas_destino_prov->Visible = true;

				// PD definitivas
				$Component->parcelas_destino->Visible = false;

				// Planos
				$Component->planos->Button_Archivar->Visible = ($isPlanoEdicion) ? false: true;
				$Component->planos->Button_Anular->Visible = false;
				$Component->planos->Button_Suspender->Visible = false;
				$Component->planos->Button_Registrar->Visible = ($isPlanoEdicion) ? false: true;
				$Component->planos->Button_Vigencia->Visible = false;
				$Component->planos->Button_Editar->Visible = false;

				$Component->planos->UpdateAllowed = ($isPlanoEdicion) ? false: true;
				$Component->planos->DeleteAllowed = false;

				break;


			// Si está "Archivado" (id = 6)
			case 6:

				// PO provisorias
				$Component->parcelas_origen_prov->Visible = false;
				$Component->parcelas_origen_prov->DeleteAllowed  = false;
				$Component->parcelas_origen_prov->SeleccionarParcela->Visible = false;

				// PO definitivas
				$Component->parcelas_origen->Visible = true;

				// PD provisorias
				$Component->parcelas_destino_prov->Visible = false;
				$Component->parcelas_destino_prov->SeleccionarParcela->Visible = false;
				$Component->parcelas_destino_prov->ImageLink1->Visible = false;
				$Component->parcelas_destino_prov->ImageLink2->Visible = false;
				$Component->parcelas_destino_prov->LinkRemove->Visible = false;

				// PD definitivas
				$Component->parcelas_destino->Visible = true;

				// Planos
				$Component->planos->Button_Archivar->Visible = false;
				$Component->planos->Button_Anular->Visible = false;
				$Component->planos->Button_Suspender->Visible = false;
				$Component->planos->Button_Registrar->Visible = false;
				$Component->planos->Button_Vigencia->Visible = false;
				$Component->planos->Button_Editar->Visible = false;

				$Component->planos->UpdateAllowed = false;
				$Component->planos->DeleteAllowed = false;

				break;


			// Si está "Registrado" (id = 4)
			case 4:

				// PO provisorias
				$Component->parcelas_origen_prov->Visible = false;
				$Component->parcelas_origen_prov->DeleteAllowed  = false;
				$Component->parcelas_origen_prov->SeleccionarParcela->Visible = false;

				// PO definitivas
				$Component->parcelas_origen->Visible = true;

				// PD provisorias
				$Component->parcelas_destino_prov->Visible = false;
				$Component->parcelas_destino_prov->SeleccionarParcela->Visible = false;
				$Component->parcelas_destino_prov->ImageLink1->Visible = false;
				$Component->parcelas_destino_prov->ImageLink2->Visible = false;
				$Component->parcelas_destino_prov->LinkRemove->Visible = false;

				// PD definitivas
				$Component->parcelas_destino->Visible = true;

				// Planos
				$Component->planos->Button_Archivar->Visible = false;
				$Component->planos->Button_Anular->Visible = ($isPlanoEdicion) ? false: true;
				$Component->planos->Button_Suspender->Visible = ($isPlanoEdicion) ? false: true;
				$Component->planos->Button_Registrar->Visible = false;
				if ( !$isPlanoSVC ) $Component->planos->Button_Vigencia->Visible = false;
				$Component->planos->Button_Editar->Visible = true;

				$Component->planos->UpdateAllowed = false;
				$Component->planos->DeleteAllowed = false;
				break;


			// Si está "Anulado" (id = 1)
			case 1:
				// PO provisorias
				$Component->parcelas_origen_prov->Visible = false;
				$Component->parcelas_origen_prov->DeleteAllowed  = false;
				$Component->parcelas_origen_prov->SeleccionarParcela->Visible = false;

				// PO definitivas
				$Component->parcelas_origen->Visible = true;

				// PD provisorias
				$Component->parcelas_destino_prov->Visible = false;
				$Component->parcelas_destino_prov->SeleccionarParcela->Visible = false;
				$Component->parcelas_destino_prov->ImageLink1->Visible = false;
				$Component->parcelas_destino_prov->ImageLink2->Visible = false;
				$Component->parcelas_destino_prov->LinkRemove->Visible = false;

				// PD definitivas
				$Component->parcelas_destino->Visible = true;

				// Planos
				$Component->planos->Button_Archivar->Visible = false;
				$Component->planos->Button_Anular->Visible = false;
				$Component->planos->Button_Suspender->Visible = false;
				$Component->planos->Button_Registrar->Visible = false;
				$Component->planos->Button_Vigencia->Visible = false;
				$Component->planos->Button_Editar->Visible = false;

				$Component->planos->UpdateAllowed = false;
				$Component->planos->DeleteAllowed = false;
				break;


			// Si está "Suspendido" (id = 8)
			case 8:
				// PO provisorias
				$Component->parcelas_origen_prov->Visible = false;
				$Component->parcelas_origen_prov->DeleteAllowed  = false;
				$Component->parcelas_origen_prov->SeleccionarParcela->Visible = false;

				// PO definitivas
				$Component->parcelas_origen->Visible = true;

				// PD provisorias
				$Component->parcelas_destino_prov->Visible = false;
				$Component->parcelas_destino_prov->SeleccionarParcela->Visible = false;
				$Component->parcelas_destino_prov->ImageLink1->Visible = false;
				$Component->parcelas_destino_prov->ImageLink2->Visible = false;
				$Component->parcelas_destino_prov->LinkRemove->Visible = false;

				// PD definitivas
				$Component->parcelas_destino->Visible = true;

				// Planos
				$Component->planos->Button_Archivar->Visible = false;
				$Component->planos->Button_Anular->Visible = false;
				$Component->planos->Button_Suspender->Visible = false;
				$Component->planos->Button_Registrar->Visible = false;
				$Component->planos->Button_Vigencia->Visible = false;
				$Component->planos->Button_Editar->Visible = false;

				$Component->planos->UpdateAllowed = false;
				$Component->planos->DeleteAllowed = false;
				break;

			default:
				break;

		endswitch;


	}


// -------------------------
//End Custom Code

//Close Page_BeforeShow @1-4BC230CD
    return $Page_BeforeShow;
}
//End Close Page_BeforeShow

//Page_BeforeInitialize @1-48FE979B
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tc_planosVista; //Compatibility
//End Page_BeforeInitialize

//Custom Code @304-2A29BDB7
// -------------------------

	// Incluye el archivo de funciones generales
	include_once(RelativePath . "/scripts/myFunctions.php");

    // Incluye la gestión de permisos
	//include_once(RelativePath . "/scripts/permisos1.php");

// -------------------------
//End Custom Code

//PTAutoFill1 Initialization @140-519D9FC2
    if ('planosplano_anioPTAutoFill1' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new JsonFormatter());
//End PTAutoFill1 Initialization

//PTAutoFill1 DataSource @140-B7FCB7B8
        $Service->DataSource = new clsDBcatastro();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM planos {SQL_Where} {SQL_OrderBy}";
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End PTAutoFill1 DataSource

//PTAutoFill1 DataFields @140-5E2C9B65
        $Service->AddDataSourceField('cant',ccsInteger,"");
//End PTAutoFill1 DataFields

//PTAutoFill1 Execution @140-028A6C4C
        echo $Service->Execute();
//End PTAutoFill1 Execution

//PTAutoFill1 Loading @140-27890EF8
        exit;
    }
//End PTAutoFill1 Loading

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>