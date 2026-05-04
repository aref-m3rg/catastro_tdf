<?php

//BindEvents Method @1-0DF1591D
function BindEvents()
{
    global $permissions_html;
    global $perfiles;
    global $CCSEvents;
    $permissions_html->CCSEvents["BeforeShow"] = "permissions_html_BeforeShow";
    $perfiles->CCSEvents["AfterInsert"] = "perfiles_AfterInsert";
    $perfiles->CCSEvents["AfterDelete"] = "perfiles_AfterDelete";
}
//End BindEvents Method

//permissions_html_BeforeShow @6-8591C354
function permissions_html_BeforeShow(& $sender)
{
    $permissions_html_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $permissions_html; //Compatibility
//End permissions_html_BeforeShow

//Custom Code @7-2A29BDB7
// -------------------------


	/* Función que crea el arbol en base a un array agrupado */
	function createTree(&$list, $parent){
		$tree = array();
		foreach ($parent as $k=>$l){
			if(isset($list[$l['menu_id']])){
				$l['children'] = createTree($list, $list[$l['menu_id']]);
			}
			$tree[] = $l;
		} 
		return $tree;
	}



	function createTreeRow( $data, $level, $permisos ) {

		$level++;

		// determina el tipo de permiso que tiene
		if ( !empty( $permisos[$data['menu_id']] ) ) {
			if ( $permisos[$data['menu_id']] == 1 ) {
				$permisoActual = 1; // lectura
				$selectLectura = ' selected="selected" ';
			} else {
				$permisoActual = 2; // lectura + escritura
				$selectEscritura = ' selected="selected" ';
			}
		} else {
			$permisoActual = 0; // sin permisos asignados
		}


		// determina estado actual de visibilidad
		$visClass = ( $data['menu_visible_id'] == 1 ? '' : 'perm-row-novis ' );

		$output .= '  <tr class="perm-row ' . $visClass . 'perm-level-' . $level . '">';
		$output .= '    <td class="perm-row-description"><span title="ID: ' . $data['menu_id'] . '">' . $data['menu_descripcion'] . '</span></td>';

		// si tiene página asignada muestra el select para setear permisos
		$output .= '    <td>';
		if ( !empty( $data['menu_link'] ) ) {
			$output .= '      <select name="perm-' . $data['menu_id'] . '">';
			$output .= '        <option value="">...</option>';
			$output .= '        <option value="1"' . $selectLectura . '>Lectura</option>';
			$output .= '        <option value="2"' . $selectEscritura . '>Lectura / Escritura</option>';
			$output .= '      </select>';
		} else {
			$output .= '      &nbsp;';
		}
		$output .= '    </td>';

		$output .= '    <td>' . $data['menu_link'] . '&nbsp;</td>';
		$output .= '    <td>' . $data['menu_visible_descrip'] . '&nbsp;</td>';
		$output .= '    <td style="text-align:right;">' . $data['menu_orden'] . '&nbsp;</td>';
		$output .= '  </tr>';

		if ( !empty( $data['children'] ) ) {
			foreach( $data['children'] as $child ) {
				$output .= createTreeRow( $child, $level, $permisos );
			}
		}

		return $output;
	}




	$db = new clsDBtdf_nuevo();


	// trae los datos del perfil a editar
	$perfilId = CCGetParam('perfil_id');
	$perfilData = CCQueryToArray('SELECT * FROM _perfiles WHERE perfil_id = ' . mysql_real_escape_string( $perfilId ), $db );


	// si se encontró el perfil
	if ( !empty( $perfilData ) ) {


		/* Si se envió el formulario PROCESA los datos de permisos */
		if( !empty( $_POST['post-form'] ) ) {

			// trae los permisos actuales
			$permisosActualesData = CCQueryToArray(
				'SELECT menu_id, nivel_id
				FROM _perfiles_items
				WHERE perfil_id = ' . mysql_real_escape_string( $perfilData[0]['perfil_id'] )
			, $db );

			$permisosActuales = array();
			if ( !empty( $permisosActualesData ) ) {
				foreach( $permisosActualesData as $permiso ) {
					$permisosActuales[$permiso['menu_id']] = $permiso['nivel_id'];
				}
			}

			// loop por los parámetros POST de permisos
			foreach( $_POST as $postKey => $postValue ) {

				// detecta si pertenece a un permiso
				$paramData = explode('-', $postKey);

				if ( $paramData[0] == 'perm' ) {

					// chequea si el permiso existe actualmente
					if ( empty( $permisosActuales[$paramData[1]] ) && !empty( $postValue ) ) {
						// como no existe lo tengo que insertar
						$SQL  = 'INSERT INTO _perfiles_items SET';
						$SQL .= ' perfil_id = ' . mysql_real_escape_string( $perfilData[0]['perfil_id'] );
						$SQL .= ', menu_id = ' . mysql_real_escape_string( $paramData[1] ) . ' ';
						$SQL .= ', nivel_id = ' . mysql_real_escape_string( $postValue ) ;

						$db->query($SQL); //debug( $SQL );

					} else {
						// si existe, chequea si ha cambiado para no hacer miles de querys al pedo
						if ( $permisosActuales[$paramData[1]] != $postValue ) {

							// si no se ha dejado vacío borra, si no actualiza
							if ( empty( $postValue ) ) {
								$SQL  = 'DELETE FROM _perfiles_items';
								$SQL .= ' WHERE perfil_id = ' . mysql_real_escape_string( $perfilData[0]['perfil_id'] );
								$SQL .= ' AND menu_id = ' . mysql_real_escape_string( $paramData[1] ) . ' ';

								$db->query($SQL); // debug( $SQL );

							} else {
								$SQL  = 'UPDATE _perfiles_items SET';
								$SQL .= ' nivel_id = ' . mysql_real_escape_string( $postValue ) ;
								$SQL .= ' WHERE perfil_id = ' . mysql_real_escape_string( $perfilData[0]['perfil_id'] );
								$SQL .= ' AND menu_id = ' . mysql_real_escape_string( $paramData[1] ) . ' ';

								$db->query($SQL); // debug( $SQL );
							}

						}

					}

				}
			
			}

		} // end: si se envió el formulario PROCESA los datos de permisos



		// trae las páginas en el menú
		$paginas = CCQueryToArray(
			'SELECT menu.*, menus_visibles.menu_visible_descrip, IF( menu_parent_id IS NOT NULL, menu_parent_id, 0 ) AS parent_id
			FROM menu
			INNER JOIN menus_visibles ON menus_visibles.menu_visible_id = menu.`menu_visible_id`
			ORDER BY parent_id ASC, menu_visible_id ASC, menu_orden ASC
		', $db );


		// trae los permisos nuevamente por si se modificaron al procesar el formulario
		$permisosPaginasData = CCQueryToArray(
			'SELECT menu_id, nivel_id
			FROM _perfiles_items
			WHERE perfil_id = ' . mysql_real_escape_string( $perfilData[0]['perfil_id'] )
		, $db );


		$permisosPaginas = array();
		if ( !empty( $permisosPaginasData ) ) {
			foreach( $permisosPaginasData as $permiso ) {
				$permisosPaginas[$permiso['menu_id']] = $permiso['nivel_id'];
			}
		}


		/* Crear arbol del menú en un array */

		// primer agrupamiento
		$groupedArray = array();
		foreach ( $paginas as $pagina ) {
			$groupedArray[$pagina['parent_id']][] = $pagina;
		}
		// crear arbol
		$menu = createTree( $groupedArray, $groupedArray[0] ); // debug( $menu );



		/* Crea la tabla principal de permisos */
		$permissions_html  = 	'';

		$permissions_html .=	'<form action="' . RelativePath . '/permisos/adm_recordPerfil.php?perfil_id=' . $perfilData[0]['perfil_id'] . '&ccsForm=permisos_perfil" name="tipos_instrumentos" method="post" id="permisos_perfil">';
		$permissions_html .=	'<table cellspacing="0" cellpadding="0" border="0" style="width:960px;">';

		$permissions_html .=	'<tr>';
		$permissions_html .=	'  <td>';

		$permissions_html .=	'    <table cellspacing="0" cellpadding="0" border="0" class="Header">';
		$permissions_html .=	'      <tr>';
		$permissions_html .=	'        <td class="HeaderLeft"><img border="0" src="../Styles/Simple_tdf/Images/Spacer.gif"></td> ';
		$permissions_html .=	'        <th>Listado de permisos por página</th>';
		$permissions_html .=	'        <td class="HeaderRight"><img border="0" src="../Styles/Simple_tdf/Images/Spacer.gif"></td> ';
		$permissions_html .=	'      </tr>';
		$permissions_html .=	'    </table>';
	
		$permissions_html .=	'  </td>';
		$permissions_html .=	'</tr>';

		$permissions_html .=	'<tr>';
		$permissions_html .=	'  <td>';
		$permissions_html .=	'    <table cellpadding="4" cellspacing="1" style="width:100%;">';

		$permissions_html .=	'      <tr class="Caption">';
		$permissions_html .=	'        <th>Titulo</th>';
		$permissions_html .=	'        <th>Permiso</th>';
		$permissions_html .=	'        <th>URL</th>';
		$permissions_html .=	'        <th>Visibilidad</th>';
		$permissions_html .=	'        <th>Orden</th>';
		$permissions_html .=	'      </tr>';

		foreach( $menu as $menuItem ) {
			$permissions_html .= createTreeRow( $menuItem, 0, $permisosPaginas );
		}

		$permissions_html .=	'    </table>';
		$permissions_html .=	'  </td>';
		$permissions_html .=	'</tr>';

		$permissions_html .=	'<tr class="Footer">';
		$permissions_html .=	'  <td style="TEXT-ALIGN: right">';
		$permissions_html .=	'    <input type="hidden" value="1" name="post-form" id="form-post"/>';
		$permissions_html .=	'    <input type="submit" value="Guardar permisos" name="Button_Submit" class="Button" id="tipos_instrumentosButton_Submit">';
		$permissions_html .=	'  </td>';
		$permissions_html .=	'</tr>';

		$permissions_html .=	'</table>';
		$permissions_html .=	'</form>';

		$Component->SetValue( $permissions_html );

	} // end: si se encontró el perfil


	$db->close();

// -------------------------
//End Custom Code

//Close permissions_html_BeforeShow @6-E382524B
    return $permissions_html_BeforeShow;
}
//End Close permissions_html_BeforeShow

//perfiles_AfterInsert @8-330C2C22
function perfiles_AfterInsert(& $sender)
{
    $perfiles_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $perfiles; //Compatibility
//End perfiles_AfterInsert

//Custom Code @19-2A29BDB7
// -------------------------

	// Redirecciona a la misma página con el ID del insert
	global $Redirect;

	$lastID = mysql_insert_id();
	$Redirect = 'adm_recordPerfil.php?perfil_id=' . $lastID;


// -------------------------
//End Custom Code

//Close perfiles_AfterInsert @8-5A3AD88F
    return $perfiles_AfterInsert;
}
//End Close perfiles_AfterInsert

//perfiles_AfterDelete @8-6EC023C6
function perfiles_AfterDelete(& $sender)
{
    $perfiles_AfterDelete = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $perfiles; //Compatibility
//End perfiles_AfterDelete

//Custom Code @20-2A29BDB7
// -------------------------

    /* Después de borrar el perfil borra las relaciones con páginas */
	$perfilId = CCGetParam('perfil_id');

	if ( !empty( $perfilId ) ) {
		$db = new clsDBtdf_nuevo();
		$db->query( 'DELETE FROM _perfiles_items WHERE perfil_id = ' . mysql_real_escape_string( $perfilId ) );
		$db->close();
	}

	// redirecciona al listado de perfiles
	global $Redirect;
	$Redirect = '../usuarios/adm_perfil.php';


// -------------------------
//End Custom Code

//Close perfiles_AfterDelete @8-0937BF71
    return $perfiles_AfterDelete;
}
//End Close perfiles_AfterDelete

//Page_BeforeInitialize @1-1DF815BE
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $adm_recordPerfil; //Compatibility
//End Page_BeforeInitialize

//Custom Code @5-2A29BDB7
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
