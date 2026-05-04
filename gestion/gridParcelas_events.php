<?php
//BindEvents Method @1-F0486459
function BindEvents()
{
    global $parcelas_unidades_medidas1;
    global $parcelas1;
    global $padrones_parcelas_parcela;
    global $Panel2;
    global $CCSEvents;
    $parcelas_unidades_medidas1->plano_nro->CCSEvents["BeforeShow"] = "parcelas_unidades_medidas1_plano_nro_BeforeShow";
    $parcelas_unidades_medidas1->CCSEvents["BeforeShowRow"] = "parcelas_unidades_medidas1_BeforeShowRow";
    $parcelas_unidades_medidas1->CCSEvents["BeforeShow"] = "parcelas_unidades_medidas1_BeforeShow";
    $parcelas_unidades_medidas1->ds->CCSEvents["BeforeExecuteSelect"] = "parcelas_unidades_medidas1_ds_BeforeExecuteSelect";
    $parcelas1->ds->CCSEvents["BeforeExecuteSelect"] = "parcelas1_ds_BeforeExecuteSelect";
    $parcelas1->CCSEvents["BeforeShow"] = "parcelas1_BeforeShow";
    $padrones_parcelas_parcela->alta_pura->CCSEvents["BeforeShow"] = "padrones_parcelas_parcela_alta_pura_BeforeShow";
    $Panel2->CCSEvents["BeforeShow"] = "Panel2_BeforeShow";
}
//End BindEvents Method

//parcelas_unidades_medidas1_plano_nro_BeforeShow @481-F98AB0C0
function parcelas_unidades_medidas1_plano_nro_BeforeShow(& $sender)
{
    $parcelas_unidades_medidas1_plano_nro_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_unidades_medidas1; //Compatibility
//End parcelas_unidades_medidas1_plano_nro_BeforeShow

//Custom Code @510-2A29BDB7
// -------------------------

  $db = new clsDBtdf_nuevo();

	// obtenemos el ID de la parcela
	$parcela_id = $Container->ds->f('parcela_id');


	/* Calcula el Nro. de plano para mostrar en la fila
	-------------------------------------------------------------- */

	if ( !empty( $parcela_id ) ) {
		// busco los datos del plano
		$nro_plano = obtenerPlano( false, $parcela_id, false, $db );

		if ( !empty( $nro_plano ) ) {
			// si lo obtengo seteo el valor en el label
			$Component->SetValue( $nro_plano );
		} else {
      $Component->SetValue( '' );
    }
	}


// -------------------------
//End Custom Code

//Close parcelas_unidades_medidas1_plano_nro_BeforeShow @481-05788A87
    return $parcelas_unidades_medidas1_plano_nro_BeforeShow;
}
//End Close parcelas_unidades_medidas1_plano_nro_BeforeShow

//parcelas_unidades_medidas1_BeforeShowRow @37-6DDD5ACE
function parcelas_unidades_medidas1_BeforeShowRow(& $sender)
{
    $parcelas_unidades_medidas1_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_unidades_medidas1; //Compatibility
//End parcelas_unidades_medidas1_BeforeShowRow

//Set Row Style @67-982C9472
    $styles = array("Row", "AltRow");
    if (count($styles)) {
        $Style = $styles[($Component->RowNumber - 1) % count($styles)];
        if (strlen($Style) && !strpos($Style, "="))
            $Style = (strpos($Style, ":") ? 'style="' : 'class="'). $Style . '"';
        $Component->Attributes->SetValue("rowStyle", $Style);
    }
//End Set Row Style

//Custom Code @173-2A29BDB7
// -------------------------

    $db = new clsDBtdf_nuevo();

	// ----------PLANCHETA---------------
	$htm = generarPlanchetasSlides(
		$Component->ds->f('parcela_id'),
		array('width' => 140, 'height' => 95, 'multiple' => true, 'encode' => false),
		$db
	);
	$Component->plancheta_html->SetValue( $htm );

	$db->close();

/*	$pasa = False;
	$wh = " 1 ";
    if( $Component->ds->f('parcelas_tipo_depto_parc_id') ){
		$wh .= " AND tipo_depto_parc_id = '" . $Component->ds->f('parcelas_tipo_depto_parc_id') . "'";
	}
	if($Component->ds->f('parcelas_tipo_padron_parc_id')){
		$wh .= " AND tipo_padron_parc_id = '" . $Component->ds->f('parcelas_tipo_padron_parc_id') . "'";
	}
	if($Component->ds->f('parcela_seccion')){
		$wh .= " AND plancheta_scc = '" . $Component->ds->f('parcela_seccion') . "'";
		$pasa = True;
	}
	if($Component->ds->f('parcela_macizo')){
		$wh .= " AND plancheta_mzo = '" . $Component->ds->f('parcela_macizo') . "'";
		$pasa = True;
	}
	if($Component->ds->f('parcela_parcela')){
		$wh .= " AND ( (TRIM(LEADING '0' FROM plancheta_par) = '" . $Component->ds->f('parcela_parcela') . "') OR (IFNULL(TRIM(LEADING '0' FROM plancheta_par),'')= ''))";
		$pasa = True;
	}
	if($Component->ds->f('parcela_chacra')){
		$wh .= " AND plancheta_cha = '" . $Component->ds->f('parcela_chacra') . "'";
		$pasa = True;
	}
	if($Component->ds->f('parcela_quinta')){
		$wh .= " AND plancheta_qta = '" . $Component->ds->f('parcela_quinta') . "'";
		$pasa = True;
	}
	if($pasa){
		$db = new clsDBtdf_nuevo();
/*
		$img = CCDLookUp('plancheta_file','planchetas',$wh . ' LIMIT 1',$db);
		$plancheta_id = CCDLookUp('plancheta_id','planchetas',$wh . ' ORDER BY plancheta_par DESC,plancheta_hoja LIMIT 1',$db);

		if(file_exists('../planchetas/archivos/' . $img) && $img){
			$htm = '<a class="" target="plancheta" title="Plancheta a PDF" href="' . RelativePath . '/reportes/rpt_plancheta.php?plancheta_id=' . $plancheta_id . '"><img border="0" class=""  src="' . RelativePath . '/phpThumb/phpThumb.php?src=/planchetas/archivos/' . $img . '&h=125"></a>';
		} else {
			$htm = '-';
		} 

		$cant=CCDLookUp('COUNT(*) AS cant','planchetas',$wh . ' ORDER BY plancheta_hoja',$db);
		$SQL="SELECT plancheta_id, plancheta_file, plancheta_hoja FROM planchetas WHERE $wh GROUP BY plancheta_file ORDER BY plancheta_hoja";
		$db->query($SQL);
		$htm = "";
		$i=1;
		$domain = $_SERVER['HTTP_HOST'];  

		$arreglo = explode("/",$_SERVER['REQUEST_URI']); //$arreglo = split("/",$_SERVER['REQUEST_URI']);

		$url = "http://" . $domain . "/" .$arreglo[1];
		$path="$url/planchetas/archivos/";
		$path2="$url/reportes/rpt_plancheta.php?plancheta_id=";
		while($db->next_record()){
			$htm .= "{thumb:'$path".$db->f('plancheta_file')."',large:'$path".$db->f('plancheta_file')."',title:'".$db->f('plancheta_hoja')."',link:'$path2".$db->f('plancheta_id')."'}";
			if($i != $cant){
				$htm .= ",";
				$i++;
			}
		}
		
	} else {
		$htm = '-';
    }
	//$Component->html->SetValue($htm);
*/

//-----PLANO---------
//	$db = new clsDBtdf_nuevo();
//	$Component->plano->SetValue(CCDLookUp("IF(planos.plano_nro,CONCAT('T.F. ',CONCAT_WS('-',tipos_deptos_parcela.tipo_depto_parc_plano_nro,CONCAT(tipos_planos.tipo_plano_abrev,planos.plano_nro),RIGHT(planos.plano_anio,2))),IFNULL(planos.tmp_plano,'Sin Mensura')) AS plano","parcelas_planos LEFT JOIN planos ON parcelas_planos.plano_id = planos.plano_id LEFT JOIN tipos_planos ON planos.tipo_plano_id = tipos_planos.tipo_plano_id LEFT JOIN tipos_deptos_parcela ON planos.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id","parcelas_planos.parcela_id = ". $Component->ds->f('parcela_id'),$db));
//	$db->close();
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

//Custom Code @254-2A29BDB7
// -------------------------
	if(CCGetParam('pasop') == 'parcela'){
    	$Component->Visible=true;
	}else{
		$Component->Visible=false;
	}
// -------------------------
//End Custom Code

//Close parcelas_unidades_medidas1_BeforeShow @37-C0A23661
    return $parcelas_unidades_medidas1_BeforeShow;
}
//End Close parcelas_unidades_medidas1_BeforeShow

//parcelas_unidades_medidas1_ds_BeforeExecuteSelect @37-FD51FFE6
function parcelas_unidades_medidas1_ds_BeforeExecuteSelect(& $sender)
{
    $parcelas_unidades_medidas1_ds_BeforeExecuteSelect = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_unidades_medidas1; //Compatibility
//End parcelas_unidades_medidas1_ds_BeforeExecuteSelect

//Custom Code @256-2A29BDB7
// -------------------------
	if(CCGetParam('pasop') != 'parcela'){
    	$Component->DataSource->Where = " parcelas.parcela_partida = '-1' ";
	}
	if(strrpos(CCGetParam('parcela_parcela'),'_') || strrpos(CCGetParam('parcela_parcela'),'%')){
		$origen="parcelas.parcela_parcela = '".CCGetParam('parcela_parcela')."'";
		$destino="parcelas.parcela_parcela LIKE '".CCGetParam('parcela_parcela')."'";
		$Component->DataSource->Where = str_replace($origen,$destino,$Component->DataSource->Where);
	}
// -------------------------
//End Custom Code

//Close parcelas_unidades_medidas1_ds_BeforeExecuteSelect @37-D964F12D
    return $parcelas_unidades_medidas1_ds_BeforeExecuteSelect;
}
//End Close parcelas_unidades_medidas1_ds_BeforeExecuteSelect

//parcelas1_ds_BeforeExecuteSelect @324-E319373E
function parcelas1_ds_BeforeExecuteSelect(& $sender)
{
    $parcelas1_ds_BeforeExecuteSelect = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas1; //Compatibility
//End parcelas1_ds_BeforeExecuteSelect

//Custom Code @346-2A29BDB7
// -------------------------
    if(CCGetParam('pasol') != 'plano'){
    	$Component->DataSource->Where = " parcelas.parcela_partida = '-1' ";
	}
// -------------------------
//End Custom Code

//Close parcelas1_ds_BeforeExecuteSelect @324-9B20F38F
    return $parcelas1_ds_BeforeExecuteSelect;
}
//End Close parcelas1_ds_BeforeExecuteSelect

//parcelas1_BeforeShow @324-C270B8E5
function parcelas1_BeforeShow(& $sender)
{
    $parcelas1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas1; //Compatibility
//End parcelas1_BeforeShow

//Custom Code @347-2A29BDB7
// -------------------------
    if(CCGetParam('pasol') == 'plano'){
    	$Component->Visible=true;
	}else{
		$Component->Visible=false;
	}
// -------------------------
//End Custom Code

//Close parcelas1_BeforeShow @324-F0781A24
    return $parcelas1_BeforeShow;
}
//End Close parcelas1_BeforeShow

//DEL  // -------------------------
//DEL      //global $Redirect;
//DEL  	//$Redirect = "recordParcela.php";
//DEL  // -------------------------

//padrones_parcelas_parcela_alta_pura_BeforeShow @541-76C3B1F6
function padrones_parcelas_parcela_alta_pura_BeforeShow(& $sender)
{
    $padrones_parcelas_parcela_alta_pura_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $padrones_parcelas_parcela; //Compatibility
//End padrones_parcelas_parcela_alta_pura_BeforeShow

//Custom Code @543-2A29BDB7
// -------------------------
	if(CCGetUserID() == 41 || CCGetUserID() == 5){
    	$padrones_parcelas_parcela->alta_pura->Visible=true;
	}else{
		$padrones_parcelas_parcela->alta_pura->Visible=false;
	}
// -------------------------
//End Custom Code

//Close padrones_parcelas_parcela_alta_pura_BeforeShow @541-20646CAC
    return $padrones_parcelas_parcela_alta_pura_BeforeShow;
}
//End Close padrones_parcelas_parcela_alta_pura_BeforeShow

//Panel2_BeforeShow @198-96696C3D
function Panel2_BeforeShow(& $sender)
{
    $Panel2_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Panel2; //Compatibility
//End Panel2_BeforeShow

//Panel1Panel2YahooTabbedTab1 BeforeShow @199-3E50549E
    $Component->BlockPrefix = "<div id=\"Panel1Panel2\">";
    $Component->BlockSuffix = "</div>";
//End Panel1Panel2YahooTabbedTab1 BeforeShow

//Close Panel2_BeforeShow @198-AE7F9FB3
    return $Panel2_BeforeShow;
}
//End Close Panel2_BeforeShow

//Page_BeforeInitialize @1-E26C86D7
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $gridParcelas; //Compatibility
//End Page_BeforeInitialize

//Custom Code @409-2A29BDB7
// -------------------------
	include_once(RelativePath . "/scripts/myFunctions.php");
  include_once(RelativePath . "/scripts/permisos1.php");
// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize
?>
