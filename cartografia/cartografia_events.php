<?php
//BindEvents Method @1-123D7683
function BindEvents()
{
    global $select;
    global $plano;
    global $CCSEvents;
    $select->CCSEvents["BeforeShow"] = "select_BeforeShow";
    $plano->CCSEvents["BeforeShow"] = "plano_BeforeShow";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
}
//End BindEvents Method

//select_BeforeShow @27-CF41DAF1
function select_BeforeShow(& $sender)
{
    $select_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $select; //Compatibility
//End select_BeforeShow

//Custom Code @32-2A29BDB7
// -------------------------
    $Component->Button1->Visible = false;
// -------------------------
//End Custom Code

//Close select_BeforeShow @27-19CA5715
    return $select_BeforeShow;
}
//End Close select_BeforeShow

//plano_BeforeShow @33-A719A413
function plano_BeforeShow(& $sender)
{
    $plano_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $plano; //Compatibility
//End plano_BeforeShow

//Custom Code @34-2A29BDB7
// -------------------------
	/*
    if(CCGetParam(nomenc21) != ''){

		$db = new clsDBdb2a();
		$dbp = new clsDBdb2a();
		$paso=CCDLookUp("COUNT(*)","DB2A.PLANOS","NRO_PLANO='".CCGetParam(nro_plano)."'",$dbp);
		if($paso > 0){
			$SQL="SELECT * FROM DB2A.PLANOS WHERE NRO_PLANO='".CCGetParam(nro_plano)."'";
			$db->query($SQL);
			if($db->next_record()){
				if(md5($db->f('IMAGEN')) == $db->f('CHECKSUM')){
					if(!$fp = fopen("imagen_".CCGetUserID().".tif", 'w+')) {}
					if(fwrite($fp,$db->f('IMAGEN')) === FALSE) {}
					fclose($fp);
					include "../phmagick/phMagick.php";
	    			$p = new phMagick("imagen_".CCGetUserID().".tif","imagen_".CCGetUserID().".gif");
					$p->resize(900);
	    			$p->convert();
					unlink("imagen_".CCGetUserID().".tif");
					$fecha_visa = CCFormatDate(CCParseDate($db->f('FECHA_VISACION'),array("yyyy", "-", "mm", "-", "dd")),array("dd","/","mm","/","yyyy"));
					$visador = CCDLookUp("NOMBRE","DB2A.VISADORES_PLANOS","CODIGO='".$db->f('VISADOR')."'",$dbp);
					$profesional = CCDLookUp("PFRASOPR","DB2A.AGRIMENSORES","PFNROMAT=".$db->f('MATRICULA_PROFESIONAL'),$dbp);
					$antecedente = CCDLookUp("NRO_PLANO_ANTECEDENTE","DB2A.PLANOS_ANTECEDENTES","NRO_PLANO='".$db->f('NRO_PLANO')."'",$dbp);
					$serie = CCDLookUp("SERIE_ANTECEDENTE","DB2A.PLANOS_ANTECEDENTES","NRO_PLANO='".$db->f('NRO_PLANO')."'",$dbp);
					$plano->SetValue("<div title='Plano' dojotype='dijit.layout.AccordionPane'>
            							<div id='boton2' dojotype='dijit.form.DropDownButton'>
									        <span><b>N° ".CCGetParam(nro_plano)."</b></span> 
									        <div id='dialog2' dojotype='dijit.TooltipDialog'>
											  <table bgcolor='#bbd1ff' border='1'>
												<tr class='Caption'>
	            									<td class='th' colspan='5'>
														<div align='center'><strong>NOMENCLATURA</strong></div>
													</td>
												</tr>
												<tr >
	            									<td class='th' colspan='5'>
														<div align='center'><strong>".CCGetParam(nomenc21)."</strong></div>
													</td>
												</tr>
												<tr>
												  <td class='th' colspan='5'>
			  										<img id='image' src='imagen_".CCGetUserID().".gif' width='900' height='450' style='width:900px; height:450px;' border='1'/>
												  </td> 
												</tr>
												<tr class='Caption'>
									            	<td class='th'>
														<div align='center'><strong>Nº PLANO</strong></div>
													</td>
													<td class='th'>
														<div align='center'><strong>TIPO PLANO</strong></div>
													</td>
													<td class='th'>
														<div align='center'><strong>Nº CAJA</strong></div>
													</td>
													<td class='th'>
														<div align='center'><strong>UBICACION CAJA</strong></div>
													</td>
													<td class='th'>
														<div align='center'><strong>Nº EXPEDIENTE</strong></div>
													</td>
												</tr>
												<tr class='Row'>
													<td><div align='center'>" . $db->f('NRO_PLANO') . "&nbsp;</div></td>
													<td><div align='center'>" . $db->f('TIPO_PLANO') . "&nbsp;</div></td>
													<td><div align='center'>" . $db->f('NRO_CAJA_ARCHIVO') . "&nbsp;</div></td>
													<td><div align='center'>" . $db->f('UBICACION_CAJA') . "&nbsp;</div></td>
													<td><div align='center'>" . $db->f('NRO_EXPEDIENTE') . "&nbsp;</div></td>
												</tr>
												<tr class='Caption'>
								            		<td class='th' colspan='5'>
														<div align='center'><strong>VISADOR</strong></div>
													</td>
												</tr>
												<tr class='Caption'>
								            		<td class='th' colspan='2'>
														<div align='center'><strong>FECHA VISADO</strong></div>
													</td>
													<td class='th' colspan='3'>
														<div align='center'><strong>NOMBRE</strong></div>
													</td>
												</tr>
												<tr class='Row'>
												<td colspan='2'><div align='center'>" . $fecha_visa . "&nbsp;</div></td>
												<td colspan='3'><div align='center'>" . $visador . "&nbsp;</div></td>
												</tr>
												<tr class='Caption'>
								            		<td class='th' colspan='5'>
														<div align='center'><strong>AGRIMENSOR</strong></div>
													</td>
												</tr>
												<tr class='Caption'>
								            		<td class='th' colspan='2'>
														<div align='center'><strong>MATRICULA</strong></div>
													</td>
													<td class='th' colspan='3'>
														<div align='center'><strong>NOMBRE</strong></div>
													</td>
												</tr>
												<tr class='Row'>
												<td colspan='2'><div align='center'>" . $db->f('MATRICULA_PROFESIONAL') . "&nbsp;</div></td>
												<td colspan='3'><div align='center'>" . $profesional . "&nbsp;</div></td>
												</tr>
												<tr class='Caption'>
								            		<td class='th' colspan='5'>
														<div align='center'><strong>ANTECEDENTE</strong></div>
													</td>
												</tr>
												<tr class='Caption'>
								            		<td class='th' colspan='2'>
														<div align='center'><strong>NUMERO</strong></div>
													</td>
													<td class='th' colspan='3'>
														<div align='center'><strong>SERIE</strong></div>
													</td>
												</tr>
												<tr class='Row'>
												<td colspan='2'><div align='center'>" . $antecedente . "&nbsp;</div></td>
												<td colspan='3'><div align='center'>" . $serie . "&nbsp;</div></td>
												</tr>
											  </table>
											</div>
										</div>
          							</div>");
				}
			}
		}
	}else{
		$plano->SetValue('');
	}*/
// -------------------------
//End Custom Code

//Close plano_BeforeShow @33-FCC772F0
    return $plano_BeforeShow;
}
//End Close plano_BeforeShow

//Page_AfterInitialize @1-47C2FABE
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $cartografia; //Compatibility
//End Page_AfterInitialize

//Custom Code @52-2A29BDB7
// -------------------------

  	global $params, $select;

  	$db = new clsDBtdf_nuevo();



    // si está el parámetro del id de la parcela o el nro. de partida muestra el navegador
  	if(CCGetParam('parcela_id') || CCGetParam('parcela_partida')){
  		$Component->footerParcela->Visible = true;
  	}


    // trae los parámetros del servidor de cartografía
  	$SQL = "SELECT gis_par_server,gis_par_jsapi,gis_par_css,gis_par_dojo,gis_par_proxy,gis_par_geometry FROM gis_parametros WHERE gis_par_id = 1";
  	$db->query($SQL);
  
  	if( $db->next_record() ){
  		$Component->server->SetValue($db->f(gis_par_server));
  		$Component->jsapi->SetValue($db->f(gis_par_jsapi));
  		$Component->css->SetValue($db->f(gis_par_css));
  		$Component->dojo->SetValue($db->f(gis_par_dojo));
		  $Component->proxy->SetValue($db->f(gis_par_proxy));
		  $Component->geometry->SetValue($db->f(gis_par_geometry));
  	}


    // si viene el parámetro servicio lo busca y trae sus datos
  	if( CCGetParam('servicio') ){
  		$srv = 	CCGetParam('servicio');
    } else {
  		$srv = CCDLookUp( 'gis_srv_name','gis_servicios','gis_srv_id = 1', $db);
  		$Component->servicio->SetValue( $srv );
  	}
  	$Component->servicio->SetValue( $srv );

  	
  	$SQL = "SELECT GROUP_CONCAT(gis_srv_query_layer ORDER BY padron_id) gis_srv_query_layer 
  			FROM gis_servicios 
  			WHERE gis_srv_name = '" . $srv . "'";
  	$db->query($SQL);
  	
  	if( $db->next_record() ){
  		$Component->query_layer->SetValue('[' . $db->f(gis_srv_query_layer) . ']');
  		$Component->query_layer_2->SetValue($db->f(gis_srv_query_layer));
  	} 

  	
  	$db->close();

// -------------------------
//End Custom Code

//Close Page_AfterInitialize @1-379D319D
    return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize

//Page_BeforeInitialize @1-E2472BFF
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $cartografia; //Compatibility
//End Page_BeforeInitialize

//Custom Code @59-2A29BDB7
// -------------------------
    include_once(RelativePath . "/scripts/permisos1.php");
// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize

?>
