<?php
//BindEvents Method @1-0AF6CE72
function BindEvents()
{
    global $noticias_noticias_categor;
    global $hilo;
    global $CCSEvents;
    $noticias_noticias_categor->CCSEvents["BeforeShowRow"] = "noticias_noticias_categor_BeforeShowRow";
    $hilo->CCSEvents["BeforeShow"] = "hilo_BeforeShow";
    $hilo->CCSEvents["AfterInsert"] = "hilo_AfterInsert";
}
//End BindEvents Method

//noticias_noticias_categor_BeforeShowRow @2-0CC011A7
function noticias_noticias_categor_BeforeShowRow(& $sender)
{
    $noticias_noticias_categor_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $noticias_noticias_categor; //Compatibility
//End noticias_noticias_categor_BeforeShowRow

//Custom Code @14-2A29BDB7
// -------------------------
    // Write your own code here.
	if($Component->ds->f('usuario_id') == CCGetUserID()){
		$Component->edit->Visible = true;
	} else {
		$Component->edit->Visible = false;
	}
// -------------------------
//End Custom Code

//Close noticias_noticias_categor_BeforeShowRow @2-07507DD7
    return $noticias_noticias_categor_BeforeShowRow;
}
//End Close noticias_noticias_categor_BeforeShowRow

//hilo_BeforeShow @36-03D4BD97
function hilo_BeforeShow(& $sender)
{
    $hilo_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $hilo; //Compatibility
//End hilo_BeforeShow

//Custom Code @54-2A29BDB7
// -------------------------
    // Write your own code here.
	//si esta cerrado no mostrar
	global $iframe;
	$noticia_id = CCGetParam(noticia_id);
	if($noticia_id){
		//$db = new clsDBguaymallen();
		$db = new clsDBtdf_nuevo();
		//cerrado?
		$not_h_end = CCDLookUp('not_h_end',
								  'noticias_hilos INNER JOIN noticias_h_estados USING(not_h_est_id)',
								  'noticia_id = ' . $noticia_id . ' ORDER BY noti_hilo_fecha DESC LIMIT 1',
								  $db);
		if($not_h_end){
			$Component->Visible = false;
			$hf = 350;
		} else {
			$hf = 200;
		}

		$db->close();
	}

	$frame = "iframeNoticiasHilos.php?noticia_id=" . CCGetParam(noticia_id);
	$htm= "<iframe src='$frame' 
			frameborder='1' 
			width='99%' 
			height='$hf'
			scrolling='yes'>Su navegador no soporta frames o está actualmente configurado para no mostrarlos.Consulte con el Dpto. de Sistemas.</iframe>";
	$iframe->SetValue($htm);
// -------------------------
//End Custom Code

//Close hilo_BeforeShow @36-EBF037FE
    return $hilo_BeforeShow;
}
//End Close hilo_BeforeShow

//hilo_AfterInsert @36-A186B8B4
function hilo_AfterInsert(& $sender)
{
    $hilo_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $hilo; //Compatibility
//End hilo_AfterInsert

//Custom Code @65-2A29BDB7
// -------------------------

	$db = new clsDBtdf_nuevo();

	/* Enviar notificación por email
	------------------------------------------------------------------------------------- */
	$userName = CCDLookUp('usuario_nombre', '_usuarios', 'usuario_id = ' . CCGetUserID(), $db );
	$noticia = CCQueryToArray('SELECT noticias.* FROM noticias WHERE noticias.noticia_id = ' . mysql_real_escape_string(CCGetParam('noticia_id')), $db);
	$message = $Component->noti_hilo_texto->GetValue();

	if ( !empty($noticia) && !empty($message) ) {
		$subject = '(#' . $noticia[0]['noticia_id'] . ') ' . $noticia[0]['noticias_asunto'];

		$body[] = 'Se ha agregado un nuevo comentario que debería ser revisado. Por favor ingresar, chequear y dar una respuesta o derivar la atención del mismo.';
		$body[] = '';
		$body[] = 'Requerimiento: ' . $subject;
		$body[] = 'Autor: ' . $userName;
		$body[] = 'Fecha: El ' . date('d/m/Y') . ' a las ' . date('H:i:s');
		$body[] = 'Comentario: (puede contener errores de formato)';
		$body[] = '';
		$body[] = strip_tags($message);

		sendNotification('Nuevo comentario en: ' . $subject . ' por ' . $userName, $body, array('debug' => false));
	}

// -------------------------
//End Custom Code

//Close hilo_AfterInsert @36-234315E3
    return $hilo_AfterInsert;
}
//End Close hilo_AfterInsert

//Page_BeforeInitialize @1-A973D7AF
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $pn_recordNoticiaHilo; //Compatibility
//End Page_BeforeInitialize

//Custom Code @66-2A29BDB7
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
