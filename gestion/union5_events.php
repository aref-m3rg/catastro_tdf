<?php

//BindEvents Method @1-7A953179
function BindEvents()
{
    global $parcelas_unidades_medidas1;
    global $padrones_parcelas_parcela;
    global $parcelas_tmp;
    global $mejoras_personas_tipos_do;
    global $tmp_mejoras;
    global $NewRecord1;
    global $personas_tipos_documentos;
    global $parcelas_tmp_u_d;
    global $NewRecord2;
    global $tmp2;
    global $cantidad;
    global $CCSEvents;
    $parcelas_unidades_medidas1->CCSEvents["BeforeShowRow"] = "parcelas_unidades_medidas1_BeforeShowRow";
    $parcelas_unidades_medidas1->CCSEvents["BeforeShow"] = "parcelas_unidades_medidas1_BeforeShow";
    $padrones_parcelas_parcela->Button2->CCSEvents["OnClick"] = "padrones_parcelas_parcela_Button2_OnClick";
    $parcelas_tmp->CCSEvents["BeforeSelect"] = "parcelas_tmp_BeforeSelect";
    $parcelas_tmp->CCSEvents["BeforeShow"] = "parcelas_tmp_BeforeShow";
    $mejoras_personas_tipos_do->CCSEvents["BeforeShow"] = "mejoras_personas_tipos_do_BeforeShow";
    $tmp_mejoras->Button_Submit->CCSEvents["OnClick"] = "tmp_mejoras_Button_Submit_OnClick";
    $tmp_mejoras->CCSEvents["BeforeShowRow"] = "tmp_mejoras_BeforeShowRow";
    $tmp_mejoras->CCSEvents["BeforeShow"] = "tmp_mejoras_BeforeShow";
    $NewRecord1->Button_Insert->CCSEvents["OnClick"] = "NewRecord1_Button_Insert_OnClick";
    $NewRecord1->CCSEvents["BeforeShow"] = "NewRecord1_BeforeShow";
    $personas_tipos_documentos->CCSEvents["BeforeShow"] = "personas_tipos_documentos_BeforeShow";
    $parcelas_tmp_u_d->certificado_parcela->CCSEvents["BeforeShow"] = "parcelas_tmp_u_d_certificado_parcela_BeforeShow";
    $parcelas_tmp_u_d->CCSEvents["BeforeShow"] = "parcelas_tmp_u_d_BeforeShow";
    $NewRecord2->Button_DoSearch->CCSEvents["OnClick"] = "NewRecord2_Button_DoSearch_OnClick";
    $NewRecord2->CCSEvents["BeforeShow"] = "NewRecord2_BeforeShow";
    $tmp2->Button1->CCSEvents["OnClick"] = "tmp2_Button1_OnClick";
    $tmp2->CCSEvents["BeforeShow"] = "tmp2_BeforeShow";
    $cantidad->Button_DoSearch->CCSEvents["OnClick"] = "cantidad_Button_DoSearch_OnClick";
    $cantidad->Link1->CCSEvents["BeforeShow"] = "cantidad_Link1_BeforeShow";
    $cantidad->TextBox1->CCSEvents["BeforeShow"] = "cantidad_TextBox1_BeforeShow";
    $cantidad->CCSEvents["BeforeShow"] = "cantidad_BeforeShow";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
}
//End BindEvents Method

//parcelas_unidades_medidas1_BeforeShowRow @37-6DDD5ACE
function parcelas_unidades_medidas1_BeforeShowRow(& $sender)
{
    $parcelas_unidades_medidas1_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_unidades_medidas1; //Compatibility
//End parcelas_unidades_medidas1_BeforeShowRow

//Set Row Style @79-982C9472
    $styles = array("Row", "AltRow");
    if (count($styles)) {
        $Style = $styles[($Component->RowNumber - 1) % count($styles)];
        if (strlen($Style) && !strpos($Style, "="))
            $Style = (strpos($Style, ":") ? 'style="' : 'class="'). $Style . '"';
        $Component->Attributes->SetValue("rowStyle", $Style);
    }
//End Set Row Style

//Custom Code @119-2A29BDB7
// -------------------------
    // Write your own code here.
$parcelas_unidades_medidas1->editar->Visible=TRUE;
$db = new clsDBtdf_nuevo();
$esta= CCDLookUp('tmp_parcela_id', 'tmp','tmp_parcela_id ='. $parcelas_unidades_medidas1->ds->f('parcela_id') . " AND usuario_id = " . CCGetSession("UID"), $db);
if($esta) $parcelas_unidades_medidas1->editar->Visible=FALSE;
if(CCGetParam(parcela_id_mas) == $parcelas_unidades_medidas1->ds->f('parcela_id')) $parcelas_unidades_medidas1->editar->Visible=FALSE;
$db->close();

// -------------------------
//End Custom Code

//Close parcelas_unidades_medidas1_BeforeShowRow @37-2A1A3D30
    return $parcelas_unidades_medidas1_BeforeShowRow;
}
//End Close parcelas_unidades_medidas1_BeforeShowRow

//parcelas_unidades_medidas1_BeforeShow @37-8616974F
function parcelas_unidades_medidas1_BeforeShow(& $sender)
{
    $parcelas_unidades_medidas1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_unidades_medidas1; //Compatibility
//End parcelas_unidades_medidas1_BeforeShow

//Custom Code @129-2A29BDB7
// -------------------------
    // Write your own code here.
global $padrones_parcelas_parcela;
$parcelas_unidades_medidas1->Visible = FALSE;
if ($padrones_parcelas_parcela->h1->GetValue() == 1) $parcelas_unidades_medidas1->Visible = FALSE;
ELSE $parcelas_unidades_medidas1->Visible = TRUE;
//$parcelas_unidades_medidas1 = FALSE;
 // -------------------------
//End Custom Code

//Close parcelas_unidades_medidas1_BeforeShow @37-C0A23661
    return $parcelas_unidades_medidas1_BeforeShow;
}
//End Close parcelas_unidades_medidas1_BeforeShow

//padrones_parcelas_parcela_Button2_OnClick @316-7E93E7AE
function padrones_parcelas_parcela_Button2_OnClick(& $sender)
{
    $padrones_parcelas_parcela_Button2_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $padrones_parcelas_parcela; //Compatibility
//End padrones_parcelas_parcela_Button2_OnClick

//Custom Code @317-2A29BDB7
// -------------------------
    // Write your own code here.
	// borrar tmp2


unset($_SESSION['plano_id']);
unset($_SESSION['plano_idd']);

$db = new clsDBtdf_nuevo();
			
			$SQL = "DELETE FROM tmp
					WHERE   usuario_id = " . CCGetSession("UID")  ;
			//$db->Query($SQL);

			
			$SQL = "DELETE FROM tmp2
					WHERE   usuario_id = " . CCGetSession("UID")  ;
			$db->Query($SQL);


			$SQL = "DELETE FROM tmp_mejoras
					WHERE   usuario_id = " . CCGetSession("UID")  ;
			$db->Query($SQL);


			$SQL = "DELETE FROM tmp_u_d
					WHERE   usuario_id = " . CCGetSession("UID")  ;
			$db->Query($SQL);



$db->close();
// -------------------------
//End Custom Code

//Close padrones_parcelas_parcela_Button2_OnClick @316-9BEF31DB
    return $padrones_parcelas_parcela_Button2_OnClick;
}
//End Close padrones_parcelas_parcela_Button2_OnClick

//parcelas_tmp_BeforeSelect @112-036E6649
function parcelas_tmp_BeforeSelect(& $sender)
{
    $parcelas_tmp_BeforeSelect = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_tmp; //Compatibility
//End parcelas_tmp_BeforeSelect

//Custom Code @115-2A29BDB7
// -------------------------
    // Write your own code here.
	if (CCGetParam(parcela_id_mas)){
		$db = new clsDBtdf_nuevo();
		$esta= CCDLookUp('tmp_parcela_id', 'tmp','tmp_parcela_id ='. CCGetParam(parcela_id_mas) . " AND usuario_id = " . CCGetSession("UID"), $db);
		if (!$esta){
			$SQL = "INSERT INTO tmp SET tmp_parcela_id = " . CCGetParam(parcela_id_mas)  . " , usuario_id = " . CCGetSession("UID")  ;
			//echo $SQL;
			//exit;
			$db->Query($SQL);
			//$Redirect = CCGetParam("ret_link", $Redirect);
			//$_GET["parcela_id_a"] = "";
			}
	}
	if (CCGetParam(parcela_id_menos)){
		$db = new clsDBtdf_nuevo();
		$esta= CCDLookUp('tmp_parcela_id', 'tmp','tmp_parcela_id ='. CCGetParam(parcela_id_menos) , $db);
		if ($esta){
			$SQL = "DELETE FROM tmp
					WHERE  tmp_parcela_id = " . CCGetParam(parcela_id_menos) . 
					  " AND usuario_id = " . CCGetSession("UID")  ;
//			echo $SQL;
			//exit;			
			$db->Query($SQL);
			//$Redirect = CCGetParam("ret_link", $Redirect);
			//$_GET["parcela_id_a"] = "";
			}
	}

// -------------------------
//End Custom Code

//Close parcelas_tmp_BeforeSelect @112-AE369792
    return $parcelas_tmp_BeforeSelect;
}
//End Close parcelas_tmp_BeforeSelect

//parcelas_tmp_BeforeShow @112-DF068139
function parcelas_tmp_BeforeShow(& $sender)
{
    $parcelas_tmp_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_tmp; //Compatibility
//End parcelas_tmp_BeforeShow

//Custom Code @313-2A29BDB7
// -------------------------
    // Write your own code here.


/*
	if (CCgetParam(cantparce)) $parcelas_tmp->Visible = TRUE;
ELSE $parcelas_tmp->Visible = FALSE;
*/

$db = new clsDBtdf_nuevo();
//si asigno todas mejoras
$listo = CCDLookUp("count(tmp_mejora_id)", "tmp_mejoras","tmp2_id IS NULL AND usuario_id =" . CCGetSession("UID") , $db);
// si hay mejoras
$tiene = CCDLookUp("count(tmp_mejora_id)", "tmp_mejoras","usuario_id =" . CCGetSession("UID") , $db);
$Component->Visible = TRUE;

if (($listo == 0) AND ($tiene > 0)){
$Component->Visible = FALSE;
}
$db->Query($SQL);
// -------------------------
//End Custom Code

//Close parcelas_tmp_BeforeShow @112-DE2F83E3
    return $parcelas_tmp_BeforeShow;
}
//End Close parcelas_tmp_BeforeShow

//mejoras_personas_tipos_do_BeforeShow @318-7078408C
function mejoras_personas_tipos_do_BeforeShow(& $sender)
{
    $mejoras_personas_tipos_do_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras_personas_tipos_do; //Compatibility
//End mejoras_personas_tipos_do_BeforeShow

//Custom Code @386-2A29BDB7
// -------------------------
    // Write your own code here.
	$Component->Visible=FALSE;

$db = new clsDBtdf_nuevo();

//cantidad de mejoras total
$estac= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") . " AND secuencia <> 999 " , $db);
// cantidad de mejoras asignadas
//$esta= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") . " AND mejora_id IS NOT NULL " , $db);
$esta= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") . " AND tmp2_id IS NOT NULL " , $db);
// ya asocio las personas con la parcela, o sea que creo un tmp_mejopra con las mejoras o con secuencia 999
$estap= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") , $db);
//aaaaa
//echo $esta . " -- " . $estac . " -- " . $estap;
//exit;
IF (($estac == $esta) AND ($estap > 0 )) $Component->Visible=TRUE;


$hay = CCDLookUp("count(tmp2_id)", "tmp2"," usuario_id =" . CCGetSession("UID") , $db);
if ($hay == 0) $Component->Visible = FALSE;
// si todavia no asocia las personas
$per= CCDLookUp("COUNT(tmp2_id)", "tmp2", "usuario_id = " . CCGetSession("UID") . " AND persona_id IS NULL " , $db);
//echo "<BR> per->". $per;
if ($per <> 0) $Component->Visible = FALSE;


$estaud= CCDLookUp("COUNT(tmp_u_d.tmp_u_d_id)", "tmp_u_d", "usuario_id = " . CCGetSession("UID") , $db);
if ($estaud) $Component->Visible=FALSE;

//echo "<BR> 2-->" . $hay . "<BR>"; 	

$db->close();


$Component->Visible = FALSE;


// -------------------------
//End Custom Code

//Close mejoras_personas_tipos_do_BeforeShow @318-F91134BF
    return $mejoras_personas_tipos_do_BeforeShow;
}
//End Close mejoras_personas_tipos_do_BeforeShow

//tmp_mejoras_Button_Submit_OnClick @229-E21740C9
function tmp_mejoras_Button_Submit_OnClick(& $sender)
{
    $tmp_mejoras_Button_Submit_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tmp_mejoras; //Compatibility
//End tmp_mejoras_Button_Submit_OnClick

//Custom Code @315-2A29BDB7
// -------------------------
    // Write your own code here.
// verificar si las partidas sugueridas no estan ocupadas ya, si estan ocupada cambiarlas en tmp2 (nada mas)
// poner las parcelas como daddas de baja a la parcela, a la relacion con las personas y las mejoras ( o solo la parcelas)
// crear parcelas parcelas_personas y mejoras
// ver si las parcelas no tienen mejora comoo hacer
/*
SELECT tmp.*, tmp2.*
FROM tmp
LEFT JOIN tmp2 ON 1 = 1
WHERE tmp.usuario_id = 3;


*/

// -------------------------
//End Custom Code

//Close tmp_mejoras_Button_Submit_OnClick @229-A47FFA62
    return $tmp_mejoras_Button_Submit_OnClick;
}
//End Close tmp_mejoras_Button_Submit_OnClick

//tmp_mejoras_BeforeShowRow @219-512BAE89
function tmp_mejoras_BeforeShowRow(& $sender)
{
    $tmp_mejoras_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tmp_mejoras; //Compatibility
//End tmp_mejoras_BeforeShowRow

//Custom Code @312-2A29BDB7
// -------------------------
    // Write your own code here.


$db = new clsDBtdf_nuevo();
$mej = $tmp_mejoras->ds->f('mejora_id');
$mejora_sup_cub= CCDLookUp('mejora_sup_cub', 'mejoras','mejora_id='. $mej , $db);
$parcela_partida= CCDLookUp('parcela_partida', 'mejoras INNER JOIN parcelas ON parcelas.parcela_id = mejoras.parcela_id','mejoras.mejora_id='. $mej , $db);
//$Component->lmejora->SetValue("aaaa");

//echo $mejora_sup_cub . " - "  . $parcela_partida;
//exit;


$mej = "Partida:". $parcela_partida . "-->Sup.Cub=" .  $mejora_sup_cub ;

//concat(mejora_sup_cub, " mts de la parcela ", parcela_partida)
$Component->lmejora->SetValue($mej);
/*

$parcelas_unidades_medidas1->editar->Visible=TRUE;
$db = new clsDBtdf_nuevo();
$esta= CCDLookUp('tmp_parcela_id', 'tmp','tmp_parcela_id ='. $parcelas_unidades_medidas1->ds->f('parcela_id') . " AND usuario_id = " . CCGetSession("UID"), $db);
if($esta) $parcelas_unidades_medidas1->editar->Visible=FALSE;
if(CCGetParam(parcela_id_mas) == $parcelas_unidades_medidas1->ds->f('parcela_id')) $parcelas_unidades_medidas1->editar->Visible=FALSE;
$db->close();
*/



// -------------------------
//End Custom Code

//Close tmp_mejoras_BeforeShowRow @219-4E48BCC0
    return $tmp_mejoras_BeforeShowRow;
}
//End Close tmp_mejoras_BeforeShowRow

//tmp_mejoras_BeforeShow @219-ABDFD98F
function tmp_mejoras_BeforeShow(& $sender)
{
    $tmp_mejoras_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tmp_mejoras; //Compatibility
//End tmp_mejoras_BeforeShow

//Custom Code @385-2A29BDB7
// -------------------------
    // Write your own code here.

$Component->Visible=FALSE;

$db = new clsDBtdf_nuevo();



//hay partidas sin personas
$parcelassintitular= CCDLookUp("COUNT(tmp2.tmp2_id)", "tmp2", "usuario_id = " . CCGetSession("UID") . " AND persona_id IS NULL " , $db);



//cantidad de mejoras total
$estac= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") . " AND secuencia <> 999 " , $db);


// cantidad de mejoras asignadas
//$esta= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") . " AND mejora_id IS NOT NULL " , $db);
$esta= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") . " AND tmp2_id IS NOT NULL " , $db);


// ya asocio las personas con la parcela, o sea que creo un tmp_mejopra con las mejoras o con secuencia 999
$estap= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") , $db);


//aaaaa
//echo $esta . " -- " . $estac . " -- " . $estap . "--" . $parcelassintitular ;
//exit;

IF (($estac > 0 ) AND ($estac <> $esta) AND ($parcelassintitular == 0 ))  $Component->Visible=TRUE;




// si ya esta creado la union que no muestre
$estaud= CCDLookUp("COUNT(tmp_u_d.tmp_u_d_id)", "tmp_u_d", "usuario_id = " . CCGetSession("UID") , $db);
if ($estaud) $Component->Visible=FALSE;






$db->close();

// -------------------------
//End Custom Code

//Close tmp_mejoras_BeforeShow @219-2C52419A
    return $tmp_mejoras_BeforeShow;
}
//End Close tmp_mejoras_BeforeShow

//NewRecord1_Button_Insert_OnClick @384-848B3021
function NewRecord1_Button_Insert_OnClick(& $sender)
{
    $NewRecord1_Button_Insert_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $NewRecord1; //Compatibility
//End NewRecord1_Button_Insert_OnClick

//Custom Code @425-2A29BDB7
// -------------------------
    // Write your own code here.


$db = new clsDBtdf_nuevo();
$dba = new clsDBtdf_nuevo();
$dbb = new clsDBtdf_nuevo();
$dbc = new clsDBtdf_nuevo();
	
			
$SQL = " SELECT tmp2.tmp2_id, tmp2.parcela_partida, tmp2.persona_id, tmp2.persona_parcela_num_int, tmp2.tipo_instrumento_id, tipo_persona_parcela_id 
FROM tmp2 WHERE tmp2.usuario_id = " . CCGetSession("UID") ;



// busco de que departalento es --> controlar que todas las parcelas elegidas sean del mismo dpto
$dpto = CCDLookUp('parcelas.tipo_depto_parc_id', 'tmp LEFT JOIN parcelas ON parcelas.parcela_id = tmp.tmp_parcela_id','tmp.usuario_id = ' . CCGetSession("UID"), $dba);
$padron = CCDLookUp('parcelas.tipo_padron_parc_id', 'tmp LEFT JOIN parcelas ON parcelas.parcela_id = tmp.tmp_parcela_id','tmp.usuario_id = ' . CCGetSession("UID"), $dba);



//SELECT MAX(parcela_partida) FROM parcelas
//$partida = CCDLookUp('MAX(parcela_partida)', 'parcelas','tipo_padron_parc_id = ' . $padron . ' AND tipo_depto_parc_id = ' . $dpto , $dba);

$partida = CCDLookUp('MAX(parcela_partida)', 'parcelas','tipo_padron_parc_id = ' . $padron . ' AND tipo_depto_parc_id = ' . $dpto , $dba);
$db->query($SQL);
$a = 1;
while($Result = $db->next_record()){
	// creo la parcela
	//$partida = CCDLookUp('MAX(parcela_partida)', 'parcelas','', $dba);	
	


	$partida = $partida + 1;
	$SQL = "INSERT INTO parcelas SET  parcela_partida = " . $partida . 
									" , tipo_est_parc_id = 3 "  .				// en tramite
									" , tipo_depto_parc_id = 1 "  .				// 1 ushuaia
									" , tipo_padron_parc_id = 1 "  .			//1 Urbano
									" , tipo_parcela_id = 1 "  .				// 1 nacional
									" , usuario_id = " . CCGetSession("UID") . 
									" , parcela_f_proceso = NOW()" ;	
	

	$dba->query($SQL);
	$parcela_id = mysql_insert_id();

	$persona_id = $db->f('persona_id');
	$persona_parcela_num_int = $db->f('persona_parcela_num_int');
	$tipo_instrumento_id = $db->f('tipo_instrumento_id');
	$tipo_persona_parcela_id  = $db->f('tipo_persona_parcela_id');
	$tmp2_id  = $db->f('tmp2_id');
	// creo relacion persona parcela
	$SQL = "INSERT INTO personas_parcelas SET  parcela_id = " . $parcela_id . 
											", persona_id = " . $persona_id . 
											", tipo_instrumento_id = " . $tipo_instrumento_id . 
											", persona_parcela_num_int = " . $persona_parcela_num_int . 
											", tipo_persona_parcela_id = " . $tipo_persona_parcela_id . 
											
											" , usuario_id = " . CCGetSession("UID") . 
											" , persona_parcela_f_pro = NOW()" .
											" , persona_parcela_ppal = 1" ;	 // principañ



	$dba->query($SQL);

	/*creo un temporario de union desgloce*/
	$SQL1 = " SELECT tmp.tmp_id, tmp.tmp_parcela_id
			FROM tmp
			WHERE tmp.usuario_id = " . CCGetSession("UID")  ;
	
	$dbb->query($SQL1);
	while($Result = $dbb->next_record()){


		$SQL1a = " INSERT INTO tmp_u_d SET
					tmp_id                = ". $dbb->f('tmp_id')  . ",
					tmp_u_d_parcela_id1            = ". $dbb->f('tmp_parcela_id') . ",
					tmp2_id     = ". $db->f('tmp2_id') . ",
					tmp_u_d_parcela_id2            = ". $parcela_id . ",
					usuario_id                = ". CCGetSession("UID") ;
		$dba->query($SQL1a);		


	}

	// migro las mejoras seleccionadas
	$SQL1 = " SELECT tmp_mejoras.mejora_id, tmp_mejoras.tmp2_id  , mejoras.*
			FROM tmp_mejoras	
			INNER JOIN mejoras ON mejoras.mejora_id = tmp_mejoras.mejora_id
			WHERE tmp_mejoras.usuario_id = " . CCGetSession("UID") . 
				" AND tmp_mejoras.tmp2_id = " . $tmp2_id ;
	
	$dbb->query($SQL1);
	while($Result = $dbb->next_record()){

		$tipo_mejora_id		 	=  0;
		$tipo_mejora_estado_id	 =  0;
		$tipo_mejora_destino_id  = 0;
		$mejora_nro_exp		 = 0;
		$mejora_letra_exp	 = '';
		$mejora_fecha_exp	 = '';
		$mejora_sup_cub		 = 0;
		$mejora_sup_semi_cub	 = 0;
		$mejora_anio_construccion = 0;
		$mejora_porc_dominio	 = 0;
		$mejora_f_alta		 	= '' ;
		$mejora_valor		 = 0;
		$mejora_f_baja		 =  '';
		$mejora_mot_baja	 = '';
		$mejora_observacion	 = '';
		$tipo_estado_id		 =  0;


		if ($dbb->f('tipo_mejora_id')) $tipo_mejora_id		 =  $dbb->f('tipo_mejora_id');
		if ($dbb->f('tipo_mejora_estado_id')) $tipo_mejora_estado_id	 =  $dbb->f('tipo_mejora_estado_id');
		if ($dbb->f('tipo_mejora_destino_id')) $tipo_mejora_destino_id  = $dbb->f('tipo_mejora_destino_id');
		if ($dbb->f('mejora_nro_exp')) $mejora_nro_exp		 = $dbb->f('mejora_nro_exp');
		if ($dbb->f('mejora_letra_exp'))$mejora_letra_exp	 = $dbb->f('mejora_letra_exp');
		if ($dbb->f('mejora_fecha_exp')) $mejora_fecha_exp	 = $dbb->f('mejora_fecha_exp');
		if($dbb->f('mejora_sup_cub')) $mejora_sup_cub		 = $dbb->f('mejora_sup_cub');
		if($dbb->f('mejora_sup_semi_cub')) $mejora_sup_semi_cub	 = $dbb->f('mejora_sup_semi_cub');
		if($dbb->f('mejora_anio_construccion'))$mejora_anio_construccion = $dbb->f('mejora_anio_construccion');
		if($dbb->f('mejora_porc_dominio'))$mejora_porc_dominio	 = $dbb->f('mejora_porc_dominio');
		if($dbb->f('mejora_f_alta'))$mejora_f_alta		 = $dbb->f('mejora_f_alta') ;
		if($dbb->f('mejora_valor'))$mejora_valor		 = $dbb->f('mejora_valor');
		if($dbb->f('mejora_f_baja'))$mejora_f_baja		 =  $dbb->f('mejora_f_baja');
		if($dbb->f('mejora_mot_baja'))$mejora_mot_baja	 = $dbb->f('mejora_mot_baja');
		if($dbb->f('mejora_observacion'))$mejora_observacion	 = $dbb->f('mejora_observacion');
		if($dbb->f('tipo_estado_id'))$tipo_estado_id		 =  $dbb->f('tipo_estado_id') ;


		$SQL1a = " INSERT INTO mejoras SET
		parcela_id                = ". $parcela_id  . ",
		tipo_mejora_id            = ". $tipo_mejora_id . ",
		tipo_mejora_estado_id     = ". $tipo_mejora_estado_id . ",
		tipo_mejora_destino_id    = ". $tipo_mejora_destino_id . ", 
		mejora_nro_exp            = ". $mejora_nro_exp . ",
		mejora_letra_exp          = '". $mejora_letra_exp . "',
		mejora_fecha_exp          = '". $mejora_fecha_exp . "',
		mejora_sup_cub            = ". $mejora_sup_cub . ",
		mejora_sup_semi_cub       = ". $mejora_sup_semi_cub . ",
		mejora_anio_construccion  = ". $mejora_anio_construccion . ",
		mejora_porc_dominio       = ". $mejora_porc_dominio . ",
		mejora_f_alta             = '".$mejora_f_alta . "',
		mejora_f_pro              = NOW(),
		mejora_valor              = ". $mejora_valor . ",
		mejora_f_baja             = '". $mejora_f_baja . "',
		mejora_mot_baja           = '". $mejora_mot_baja . "',
		mejora_observacion        = '". $mejora_observacion . "',
		usuario_id                = ". CCGetSession("UID") . ",
		tipo_estado_id            = ". $tipo_estado_id ;

		$dba->query($SQL1a);
	}

	$a++;
}
			
			
			
// creo la tabla union_desglose			
$SQL = " SELECT tmp_u_d.tmp_u_d_parcela_id1, tmp_u_d.tmp_u_d_parcela_id2 FROM tmp_u_d WHERE tmp_u_d.usuario_id = " . CCGetSession("UID") ;
$db->query($SQL);
$a = 1;

$plano_idd = 0;
IF (CCGetSession("plano_idd")) $plano_idd = CCGetSession("plano_idd");
while($Result = $db->next_record()){
	$SQL = "INSERT INTO uniones_desgloses SET  parcela_id  = " . $db->f('tmp_u_d_parcela_id1') . 
									" , parcela_destino_id = " . $db->f('tmp_u_d_parcela_id2') . 
									" , plano_id = " . $plano_idd . 
									" , usuario_id = " . CCGetSession("UID") . 
									" , union_desglose_fecha = NOW()" ;	
	
	$dba->query($SQL);




}

		
		
/*doy de baja la parcelas viejas*/	
$SQL = " SELECT  parcelas.parcela_partida, parcelas.parcela_id
FROM tmp_u_d
LEFT JOIN tmp ON tmp.tmp_id = tmp_u_d.tmp_id
LEFT JOIN parcelas ON parcelas.parcela_id = tmp.tmp_parcela_id
WHERE tmp_u_d.usuario_id = " . CCGetSession("UID") ." GROUP BY tmp_u_d.tmp_id ";
$db->query($SQL);
/*
echo "<BR> 1 ->" . $SQL;
*/
while($Result = $db->next_record()){
	

	$SQL = "UPDATE parcelas SET parcelas.tipo_est_parc_id  = 2 , parcela_f_proceso = NOW() WHERE parcelas.parcela_id = ". $db->f('parcela_id');
	$dba->query($SQL);

/*
echo "<BR> 2 ->" . $SQL;
exit;
*/

}	
	
	
			
			
			
			
	// borro todo		
/*

			$SQL = "DELETE FROM tmp
					WHERE   usuario_id = " . CCGetSession("UID")  ;
			$db->Query($SQL);


			$SQL = "DELETE FROM tmp2
					WHERE   usuario_id = " . CCGetSession("UID")  ;
			$db->Query($SQL);


			$SQL = "DELETE FROM tmp_mejoras
					WHERE   usuario_id = " . CCGetSession("UID")  ;
			$db->Query($SQL);


			$SQL = "DELETE FROM tmp_u_d
					WHERE   usuario_id = " . CCGetSession("UID")  ;
			$db->Query($SQL);


*/
$db->close();
$dba->close();

// -------------------------
//End Custom Code

//Close NewRecord1_Button_Insert_OnClick @384-A9FC55FD
    return $NewRecord1_Button_Insert_OnClick;
}
//End Close NewRecord1_Button_Insert_OnClick

//NewRecord1_BeforeShow @382-38EC31E8
function NewRecord1_BeforeShow(& $sender)
{
    $NewRecord1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $NewRecord1; //Compatibility
//End NewRecord1_BeforeShow

//Custom Code @387-2A29BDB7
// -------------------------
    // Write your own code here.
	$Component->Visible=FALSE;

$db = new clsDBtdf_nuevo();

//cantidad de mejoras total
$estac= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") . " AND secuencia <> 999 " , $db);
// cantidad de mejoras asignadas
//$esta= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") . " AND mejora_id IS NOT NULL " , $db);
$esta= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") . " AND tmp2_id IS NOT NULL " , $db);
// ya asocio las personas con la parcela, o sea que creo un tmp_mejopra con las mejoras o con secuencia 999
$estap= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") , $db);
//echo $esta . " -- " . $estac . " -- " . $estap;
//exit;
IF (($estac == $esta) AND ($estap > 0 )) $Component->Visible=TRUE;

$hay = CCDLookUp("count(tmp2_id)", "tmp2"," usuario_id =" . CCGetSession("UID") , $db);
if ($hay == 0) $Component->Visible = FALSE;

// si todavia no asocia las personas
$per= CCDLookUp("COUNT(tmp2_id)", "tmp2", "usuario_id = " . CCGetSession("UID") . " AND persona_id IS NULL " , $db);
//echo "<BR> per->". $per;
if ($per <> 0) $Component->Visible = FALSE;

$estaud= CCDLookUp("COUNT(tmp_u_d.tmp_u_d_id)", "tmp_u_d", "usuario_id = " . CCGetSession("UID") , $db);
if ($estaud) $Component->Visible=FALSE;


$db->close();// -------------------------
//End Custom Code

//Close NewRecord1_BeforeShow @382-0FB12030
    return $NewRecord1_BeforeShow;
}
//End Close NewRecord1_BeforeShow

//personas_tipos_documentos_BeforeShow @388-758CE700
function personas_tipos_documentos_BeforeShow(& $sender)
{
    $personas_tipos_documentos_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personas_tipos_documentos; //Compatibility
//End personas_tipos_documentos_BeforeShow

//Custom Code @424-2A29BDB7
// -------------------------
    // Write your own code here.
	$Component->Visible=FALSE;

$db = new clsDBtdf_nuevo();

//cantidad de mejoras total
$estac= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") . " AND secuencia <> 999 " , $db);
// cantidad de mejoras asignadas
$esta= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") . " AND tmp2_id IS NOT NULL " , $db);
// ya asocio las personas con la parcela, o sea que creo un tmp_mejopra con las mejoras o con secuencia 999
$estap= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") , $db);
//echo "--->" . $esta . " -- " . $estac . " -- " . $estap;
//exit;
IF (($estac == $esta) AND ($estap > 0 )) $Component->Visible=TRUE;

$hay = CCDLookUp("count(tmp2_id)", "tmp2"," usuario_id =" . CCGetSession("UID") , $db);
if ($hay == 0) $Component->Visible = FALSE;
//echo "<BR> 1-->" . $hay . "<BR>"; 	

// si todavia no asocia las personas
$per= CCDLookUp("COUNT(tmp2_id)", "tmp2", "usuario_id = " . CCGetSession("UID") . " AND persona_id IS NULL " , $db);
//echo "<BR> per->". $per;
if ($per <> 0) $Component->Visible = FALSE;


$estaud= CCDLookUp("COUNT(tmp_u_d.tmp_u_d_id)", "tmp_u_d", "usuario_id = " . CCGetSession("UID") , $db);
if ($estaud) $Component->Visible=FALSE;



$db->close();

// -------------------------
//End Custom Code

//Close personas_tipos_documentos_BeforeShow @388-13B2F06B
    return $personas_tipos_documentos_BeforeShow;
}
//End Close personas_tipos_documentos_BeforeShow

//parcelas_tmp_u_d_certificado_parcela_BeforeShow @170-5D894EC9
function parcelas_tmp_u_d_certificado_parcela_BeforeShow(& $sender)
{
    $parcelas_tmp_u_d_certificado_parcela_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_tmp_u_d; //Compatibility
//End parcelas_tmp_u_d_certificado_parcela_BeforeShow

//Close parcelas_tmp_u_d_certificado_parcela_BeforeShow @170-4578BE4B
    return $parcelas_tmp_u_d_certificado_parcela_BeforeShow;
}
//End Close parcelas_tmp_u_d_certificado_parcela_BeforeShow

//parcelas_tmp_u_d_BeforeShow @433-6C09B70A
function parcelas_tmp_u_d_BeforeShow(& $sender)
{
    $parcelas_tmp_u_d_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_tmp_u_d; //Compatibility
//End parcelas_tmp_u_d_BeforeShow

//Custom Code @483-2A29BDB7
// -------------------------
    // Write your own code here.


$Component->Visible=FALSE;
$db = new clsDBtdf_nuevo();
$estaud= CCDLookUp("COUNT(tmp_u_d.tmp_u_d_id)", "tmp_u_d", "usuario_id = " . CCGetSession("UID") , $db);
if ($estaud) $Component->Visible=TRUE;
$db->close();

// -------------------------
//End Custom Code

//Close parcelas_tmp_u_d_BeforeShow @433-B1E34E2E
    return $parcelas_tmp_u_d_BeforeShow;
}
//End Close parcelas_tmp_u_d_BeforeShow

//NewRecord2_Button_DoSearch_OnClick @491-D0D24266
function NewRecord2_Button_DoSearch_OnClick(& $sender)
{
    $NewRecord2_Button_DoSearch_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $NewRecord2; //Compatibility
//End NewRecord2_Button_DoSearch_OnClick

//Custom Code @492-2A29BDB7
// -------------------------
    // Write your own code here.


unset($_SESSION['plano_id']);
unset($_SESSION['plano_idd']);

$db = new clsDBtdf_nuevo();


			$SQL = "DELETE FROM tmp
					WHERE   usuario_id = " . CCGetSession("UID")  ;
			//$db->Query($SQL);


			$SQL = "DELETE FROM tmp2
					WHERE   usuario_id = " . CCGetSession("UID")  ;
			$db->Query($SQL);


			$SQL = "DELETE FROM tmp_mejoras
					WHERE   usuario_id = " . CCGetSession("UID")  ;
			$db->Query($SQL);


			$SQL = "DELETE FROM tmp_u_d
					WHERE   usuario_id = " . CCGetSession("UID")  ;
			$db->Query($SQL);



$db->close();

// -------------------------
//End Custom Code

//Close NewRecord2_Button_DoSearch_OnClick @491-E8B1741B
    return $NewRecord2_Button_DoSearch_OnClick;
}
//End Close NewRecord2_Button_DoSearch_OnClick

//NewRecord2_BeforeShow @489-CF1D755C
function NewRecord2_BeforeShow(& $sender)
{
    $NewRecord2_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $NewRecord2; //Compatibility
//End NewRecord2_BeforeShow

//Custom Code @493-2A29BDB7
// -------------------------
    // Write your own code here.

$Component->Visible=FALSE;
$db = new clsDBtdf_nuevo();
$estaud= CCDLookUp("COUNT(tmp_u_d.tmp_u_d_id)", "tmp_u_d", "usuario_id = " . CCGetSession("UID") , $db);
if ($estaud) $Component->Visible=TRUE;
$db->close();
// -------------------------
//End Custom Code

//Close NewRecord2_BeforeShow @489-73D005EB
    return $NewRecord2_BeforeShow;
}
//End Close NewRecord2_BeforeShow

//tmp2_Button1_OnClick @205-11018EFF
function tmp2_Button1_OnClick(& $sender)
{
    $tmp2_Button1_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tmp2; //Compatibility
//End tmp2_Button1_OnClick

//Custom Code @268-2A29BDB7
// -------------------------
    // Write your own code here.


$db = new clsDBtdf_nuevo();
$db2 = new clsDBtdf_nuevo();
$SQL = "DELETE FROM tmp_mejoras WHERE  usuario_id = " . CCGetSession("UID")  ;
$db->Query($SQL);

$SQL = " SELECT mejoras.mejora_id as mejoraid FROM tmp INNER JOIN parcelas ON parcelas.parcela_id = tmp.tmp_parcela_id  INNER JOIN mejoras ON mejoras.parcela_id = parcelas.parcela_id WHERE tmp.usuario_id = " . CCGetSession("UID") ;
$db->query($SQL);
$a = 1;
while($Result = $db->next_record()){
	
	$SQL = "INSERT INTO tmp_mejoras SET  mejora_id = " . $db->f('mejoraid') . " , usuario_id = " . CCGetSession("UID") . " , secuencia = " . ($a + 1)  ;	
	//echo $SQL;
	//exit;
	$db2->query($SQL);
	$a++;
}
if ($a == 1){

	$SQL = "INSERT INTO tmp_mejoras SET  usuario_id = " . CCGetSession("UID") . " , secuencia = 999" ;	
	$db2->query($SQL);

}


$db->close();
$db2->close();


// -------------------------
//End Custom Code

//Close tmp2_Button1_OnClick @205-6EB3054C
    return $tmp2_Button1_OnClick;
}
//End Close tmp2_Button1_OnClick

//tmp2_BeforeShow @172-100C96C0
function tmp2_BeforeShow(& $sender)
{
    $tmp2_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tmp2; //Compatibility
//End tmp2_BeforeShow

//Custom Code @200-2A29BDB7
// -------------------------
    // Write your own code here.

$db = new clsDBtdf_nuevo();






//si asigno todas mejoras
$listo = CCDLookUp("count(tmp_mejora_id)", "tmp_mejoras","tmp2_id IS NULL AND usuario_id =" . CCGetSession("UID") , $db);
// si hay mejoras
$tiene = CCDLookUp("count(tmp_mejora_id)", "tmp_mejoras","usuario_id =" . CCGetSession("UID") , $db);
$Component->Visible = TRUE;
if (($listo == 0) AND ($tiene > 0)){
$Component->Visible = FALSE;
}



// hay por lo menos un tm2
$hay = CCDLookUp("count(tmp2_id)", "tmp2"," usuario_id =" . CCGetSession("UID") , $db);
if ($hay == 0) $Component->Visible = FALSE;
//echo "<BR> &&&&-->" . $hay . "<BR>"; 	
// si todavia no asocia las personas
$per= CCDLookUp("COUNT(tmp2_id)", "tmp2", "usuario_id = " . CCGetSession("UID") . " AND persona_id IS NULL " , $db);
//echo "<BR> per->". $per;
if ($per == 0) $Component->Visible = FALSE;




$db->Query($SQL);

/*
	$Component->Visible=FALSE;

$db = new clsDBtdf_nuevo();

//cantidad de mejoras total
$estac= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") . " AND secuencia <> 999 " , $db);
// cantidad de mejoras asignadas
$esta= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") . " AND tmp2_id IS NOT NULL " , $db);
// ya asocio las personas con la parcela, o sea que creo un tmp_mejopra con las mejoras o con secuencia 999
$estap= CCDLookUp("COUNT(tmp_mejoras.tmp_mejora_id)", "tmp_mejoras", "usuario_id = " . CCGetSession("UID") , $db);
//echo $esta . " -- " . $estac . " -- " . $estap;
//exit;
IF (($estac == $esta) AND ($estap > 0 )) $Component->Visible=TRUE;
$db->close();

*/





// -------------------------
//End Custom Code

//Close tmp2_BeforeShow @172-2CEE0738
    return $tmp2_BeforeShow;
}
//End Close tmp2_BeforeShow

//cantidad_Button_DoSearch_OnClick @134-BB0F8C58
function cantidad_Button_DoSearch_OnClick(& $sender)
{
    $cantidad_Button_DoSearch_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $cantidad; //Compatibility
//End cantidad_Button_DoSearch_OnClick

//Custom Code @171-2A29BDB7
// -------------------------
    // Write your own code here.

//unset($_SESSION['plano_id']);


// si viene un plano por la busqueda de plano
if (CCGetSession("plano_id")){
$plano_id = CCGetSession("plano_id");
}


// si viene un plano por url
if (CCGetParam("plano_id")){
$plano_id = CCGetParam("plano_id");
}


// seteo la variable del plano para luego usarla en el insert
CCSetSession("plano_idd",$plano_id);






$db = new clsDBtdf_nuevo();
$SQL = "DELETE FROM tmp2 WHERE  usuario_id = " . CCGetSession("UID")  ;
//echo $SQL;
//exit;			
$db->Query($SQL);

// busco de que departalento es --> controlar que todas las parcelas elegidas sean del mismo dpto
$dpto = CCDLookUp('parcelas.tipo_depto_parc_id', 'tmp LEFT JOIN parcelas ON parcelas.parcela_id = tmp.tmp_parcela_id','tmp.usuario_id = ' . CCGetSession("UID"), $db);
$padron = CCDLookUp('parcelas.tipo_padron_parc_id', 'tmp LEFT JOIN parcelas ON parcelas.parcela_id = tmp.tmp_parcela_id','tmp.usuario_id = ' . CCGetSession("UID"), $db);



//SELECT MAX(parcela_partida) FROM parcelas
$partida = CCDLookUp('MAX(parcela_partida)', 'parcelas','tipo_padron_parc_id = ' . $padron . ' AND tipo_depto_parc_id = ' . $dpto , $db);
while ($a < $cantidad->cantparce->GetValue()) {
	$partida ++ ;
	$SQL = "INSERT INTO tmp2 SET  parcela_partida = " . $partida . " , usuario_id = " . CCGetSession("UID") . " , secuencia = " . ($a + 1)  ;
	//echo $SQL . "<BR>";
	//exit;
	$db->Query($SQL);
	$a ++;
}
//EXIT;

$db->close();


// -------------------------
//End Custom Code

//Close cantidad_Button_DoSearch_OnClick @134-37747CB4
    return $cantidad_Button_DoSearch_OnClick;
}
//End Close cantidad_Button_DoSearch_OnClick

//cantidad_Link1_BeforeShow @494-BC09F7B6
function cantidad_Link1_BeforeShow(& $sender)
{
    $cantidad_Link1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $cantidad; //Compatibility
//End cantidad_Link1_BeforeShow

//Custom Code @498-2A29BDB7
// -------------------------
    // Write your own code here.
// -------------------------
//End Custom Code

//Close cantidad_Link1_BeforeShow @494-34C9137B
    return $cantidad_Link1_BeforeShow;
}
//End Close cantidad_Link1_BeforeShow

//cantidad_TextBox1_BeforeShow @495-1647076C
function cantidad_TextBox1_BeforeShow(& $sender)
{
    $cantidad_TextBox1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $cantidad; //Compatibility
//End cantidad_TextBox1_BeforeShow

//Custom Code @497-2A29BDB7
// -------------------------



if (CCGetSession("plano_id")){
$plano_id = CCGetSession("plano_id");
}

if (CCGetParam("plano_id")){
$plano_id = CCGetParam("plano_id");
}


$db = new clsDBtdf_nuevo();

$plano = CCDLookUp("CONCAT(planos.plano_nro, '-',planos.plano_anio )","planos","plano_id = " . $plano_id ,$db);



$db->close();
echo "PLano_id: ". $plano_id . " plano:" . $plano;
$Component->SetValue($plano);
//exit;




    // Write your own code here.
// -------------------------
//End Custom Code

//Close cantidad_TextBox1_BeforeShow @495-2D4924EE
    return $cantidad_TextBox1_BeforeShow;
}
//End Close cantidad_TextBox1_BeforeShow

//cantidad_BeforeShow @131-46A08694
function cantidad_BeforeShow(& $sender)
{
    $cantidad_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $cantidad; //Compatibility
//End cantidad_BeforeShow

//Custom Code @314-2A29BDB7
// -------------------------
    // Write your own code here.
$db = new clsDBtdf_nuevo();
//si asigno todas mejoras
$listo = CCDLookUp("count(tmp_mejora_id)", "tmp_mejoras","tmp2_id IS NULL AND usuario_id =" . CCGetSession("UID") , $db);
// si hay mejoras
$tiene = CCDLookUp("count(tmp_mejora_id)", "tmp_mejoras","usuario_id =" . CCGetSession("UID") , $db);
$Component->Visible = TRUE;
if (($listo == 0) AND ($tiene > 0)){
$Component->Visible = FALSE;
}



// si todavia no asocia las personas
$per= CCDLookUp("COUNT(tmp2_id)", "tmp2", "usuario_id = " . CCGetSession("UID") . " AND persona_id IS NULL " , $db);
$per1= CCDLookUp("COUNT(tmp2_id)", "tmp2", "usuario_id = " . CCGetSession("UID")  , $db);
//echo "<BR> per->". $per;
if (($per1 > 0) AND ($per == 0)) $Component->Visible = FALSE;



$db->Query($SQL);


if (CCGetParam("plano_id")) $cantidad->Link1->Visible = FALSE;
// -------------------------
//End Custom Code

//Close cantidad_BeforeShow @131-127EF4D7
    return $cantidad_BeforeShow;
}
//End Close cantidad_BeforeShow

//Page_BeforeInitialize @1-D8C74D54
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $union5; //Compatibility
//End Page_BeforeInitialize

//Custom Code @5-2A29BDB7
// -------------------------
    // Write your own code here.
	include_once(RelativePath . "/scripts/permisos1.php");



// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize

//Page_AfterInitialize @1-1951EAC2
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $union5; //Compatibility
//End Page_AfterInitialize

//Custom Code @481-2A29BDB7
// -------------------------


  	$db = new clsDBtdf_nuevo();
  	$SQL = "SELECT gis_par_jsapi,gis_par_css FROM gis_parametros WHERE gis_par_id = 1";
  	$db->query($SQL);
  
  	if($db->next_record()){
  		$Component->jsapi->SetValue($db->f(gis_par_jsapi));
  		$Component->css->SetValue($db->f(gis_par_css));
  	}
	$db->close();


    // Write your own code here.
// -------------------------
//End Custom Code

//Close Page_AfterInitialize @1-379D319D
    return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize
?>
