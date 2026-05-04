<?php
//BindEvents Method @1-4EC1C6C6
function BindEvents()
{
    global $noticias;
    global $CCSEvents;
    $noticias->CCSEvents["AfterUpdate"] = "noticias_AfterUpdate";
    $noticias->CCSEvents["AfterInsert"] = "noticias_AfterInsert";
}
//End BindEvents Method

//noticias_AfterUpdate @2-C32F5E67
function noticias_AfterUpdate(& $sender)
{
    $noticias_AfterUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $noticias; //Compatibility
//End noticias_AfterUpdate

//Custom Code @35-2A29BDB7
// -------------------------
    // Write your own code here.
	//auditar este evento
	//include_once(RelativePath . "/myFunctions.php");
	//auditar("noticias",CCGetParam(noticias_id),5);
// -------------------------
//End Custom Code

//Close noticias_AfterUpdate @2-C3C64955
    return $noticias_AfterUpdate;
}
//End Close noticias_AfterUpdate

//noticias_AfterInsert @2-B46B2141
function noticias_AfterInsert(& $sender)
{
    $noticias_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $noticias; //Compatibility
//End noticias_AfterInsert

//Custom Code @40-2A29BDB7
// -------------------------

	//Insertar un hilo
	$noticia_id = mysql_insert_id();
	if($noticia_id){
		//$db = new clsDBguaymallen();
		$db = new clsDBtdf_nuevo();
		//estado del hilo
		$not_h_est_id = CCDLookUp('not_h_est_id',
								  'noticias INNER JOIN noticias_categoria USING(noti_cat_id)',
								  'noticia_id = ' . $noticia_id,
								  $db);
		$SQL = "INSERT INTO noticias_hilos
				SET noticia_id = $noticia_id,
			 	noti_hilo_fecha = NOW(),
				noti_hilo_texto = 'Inicio del comentario',
				not_h_est_id = $not_h_est_id,
				usuario_id = " . CCGetUserID();
		$db->query($SQL);
		$db->close();
		
	}


	/* Enviar notificación por email
	------------------------------------------------------------------------------------- */
	$userName = CCDLookUp('usuario_nombre', '_usuarios', 'usuario_id = ' . CCGetUserID(), $db );
	$subject = $Component->noticias_asunto->GetValue();
	$message = $Component->noticias_texto->GetValue();

	$body[] = 'Se ha agregado un nuevo requerimiento en el sistema que debería ser revisado. Por favor ingresar, chequear y dar una respuesta o derivar la atención del mismo.';
	$body[] = '';
	$body[] = 'Asunto: ' . $subject;
	$body[] = 'Autor: ' . $userName;
	$body[] = 'Fecha: El ' . date('d/m/Y') . ' a las ' . date('H:i:s');
	$body[] = 'Mensaje: (puede contener errores de formato)';
	$body[] = '';
	$body[] = strip_tags($message);

	sendNotification('Nuevo requerimiento: ' . $subject . ' por ' . $userName, $body, array('debug' => false));


// -------------------------
//End Custom Code

//Close noticias_AfterInsert @2-0CEF88DA
    return $noticias_AfterInsert;
}
//End Close noticias_AfterInsert

//Page_BeforeInitialize @1-533791BF
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $pn_recordNoticias; //Compatibility
//End Page_BeforeInitialize

//Custom Code @45-2A29BDB7
// -------------------------

	// Incluye el archivo de funciones generales
	include_once(RelativePath . "/scripts/myFunctions.php");


// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
