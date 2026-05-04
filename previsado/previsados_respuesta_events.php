<?php
//BindEvents Method @1-1CB8C9BB
function BindEvents()
{
    global $previsados_detalles_carga;
    global $respuesta;
    global $CCSEvents;
    $previsados_detalles_carga->CCSEvents["BeforeShow"] = "previsados_detalles_carga_BeforeShow";
    $previsados_detalles_carga->CCSEvents["BeforeShowRow"] = "previsados_detalles_carga_BeforeShowRow";
    $respuesta->Button_Insert->CCSEvents["OnClick"] = "respuesta_Button_Insert_OnClick";
    $respuesta->CCSEvents["BeforeShow"] = "respuesta_BeforeShow";
    $respuesta->CCSEvents["OnValidate"] = "respuesta_OnValidate";
    $respuesta->CCSEvents["AfterUpdate"] = "respuesta_AfterUpdate";
    $respuesta->CCSEvents["BeforeInsert"] = "respuesta_BeforeInsert";
}
//End BindEvents Method

//previsados_detalles_carga_BeforeShow @4-36C921C9
function previsados_detalles_carga_BeforeShow(& $sender)
{
    $previsados_detalles_carga_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_detalles_carga; //Compatibility
//End previsados_detalles_carga_BeforeShow

//Custom Code @34-2A29BDB7
// -------------------------
    $previsado_carga_id = CCGetParam('previsado_carga_id');
	if($previsado_carga_id){
		$db = new clsDBtdf_nuevo();
		$db2 = new clsDBtdf_nuevo();
		$SQL="SELECT * FROM previsados_cargas WHERE previsado_carga_id = $previsado_carga_id";
		$db->query($SQL);
		if($db->next_record()){
			$matricula_tdf = CCDLookUp("prof_matricula_tdf","profesionales","user_id=".$db->f('user_id'),$db2);
			$previsados_detalles_carga->matricula->SetValue($matricula_tdf);
			$fecha_carga = CCParseDate($db->f('previsado_carga_proc'),array("yyyy","-","mm","-","dd"," ","HH",":","nn",":","ss"));
			$previsados_detalles_carga->fecha_carga->SetValue($fecha_carga);
			$nombre_prof = CCDLookUp("prof_nombre","profesionales","user_id=".$db->f('user_id'),$db2);
			$previsados_detalles_carga->profesional_nombre->SetValue($nombre_prof);
			$tipo_plano = CCDLookUp("previsado_tipo_plano_descrip","previsados_tipos_planos","previsado_tipo_plano_id=".$db->f('previsado_tipo_plano_id'),$db2);
			$previsados_detalles_carga->tipo_plano->SetValue($tipo_plano);
			$cad_org = $db->f('previsado_nombre_archivo_org');
			$cad_dest = $db->f('previsado_carga_ubica_cat');
			$previsados_detalles_carga->cad->SetValue("<font color='BLUE'><b><a href='../../plancheta/previsado/$cad_dest' id='cad_org' download='$cad_org'>$cad_org</a></b></font>");
			$previsado_tipo_estado_carga_id = $db->f('previsado_tipo_estado_carga_id');
			//____________________TITULARES_______________________
			$cant_titulares = CCDLookUp("COUNT(*)","previsados_titulares","previsado_carga_id = $previsado_carga_id",$db2);
			if($cant_titulares){
				$SQL="SELECT * FROM previsados_titulares WHERE previsado_carga_id = $previsado_carga_id ORDER BY previsado_titular_id DESC";
				$db->query($SQL);
				$html = "";
				while($db->next_record()){
					$html .= $db->f('previsado_titular_nombre')."<br>";
				}
				$html = substr_replace($html,"",-4);
				$previsados_detalles_carga->previsado_titular->SetValue($html);
			}else{
				$html = "<font color='RED'><b>NO TIENE</b></font>";
				$previsados_detalles_carga->previsado_titular->SetValue($html);
			}
			//________________________ORIGEN______________________
			$cant_origenes = CCDLookUp("COUNT(*)","previsados_parcelas_origenes","previsado_carga_id = ".CCGetParam('previsado_carga_id'),$db2);
			if($cant_origenes){
				$SQL="SELECT previsados_parcelas_origenes.*, tipos_deptos_parcela.tipo_depto_parc_desc AS tipo_depto_parc_desc
						FROM previsados_parcelas_origenes 
						LEFT JOIN tipos_deptos_parcela ON previsados_parcelas_origenes.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id
						WHERE previsado_carga_id = ".CCGetParam('previsado_carga_id')." 
						ORDER BY previsado_parcela_origen_id DESC";
				$db->query($SQL);
				$html = "<table cellspacing='0' cellpadding='0' width='100%' class='Grid'>
						<tr>
						<td style='color: #fff; background: #3D84CC;'><div align='center'>Depto</div></td>
						<td style='color: #fff; background: #3D84CC;'><div align='center'>Secc</div></td>
						<td style='color: #fff; background: #3D84CC;'><div align='center'>Cha</div></td>
						<td style='color: #fff; background: #3D84CC;'><div align='center'>Qta</div></td>
						<td style='color: #fff; background: #3D84CC;'><div align='center'>Mzo</div></td>
						<td style='color: #fff; background: #3D84CC;'><div align='center'>Fra</div></td>
						<td style='color: #fff; background: #3D84CC;'><div align='center'>Par</div></td>
						<td style='color: #fff; background: #3D84CC;'><div align='center'>Uf/Uc</div></td>
						</tr>";
				while($db->next_record()){
					$html .= "<tr>";
					$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('tipo_depto_parc_desc')."</div></td>";
					$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_seccion')."</div></td>";
					$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_chacra')."</div></td>";
					$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_quinta')."</div></td>";
					$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_macizo')."</div></td>";
					$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_fraccion')."</div></td>";
					$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_parcela')."</div></td>";
					$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_uf')."</td>";
					$html .= "</tr>";
				}
				$html .= "</table>";
				$previsados_detalles_carga->nomenclatura_origen->SetValue($html);
			}else{
				$html = "<font color='RED'><b>NO TIENE</b></font>";
				$previsados_detalles_carga->nomenclatura_origen->SetValue($html);
			}
			//________________________DESTINO______________________
			$cant_destinos = CCDLookUp("COUNT(*)","previsados_parcelas_destinos","previsado_carga_id = ".CCGetParam('previsado_carga_id'),$db2);
			if($cant_destinos){
				$SQL="SELECT previsados_parcelas_destinos.*, tipos_deptos_parcela.tipo_depto_parc_desc AS tipo_depto_parc_desc
						FROM previsados_parcelas_destinos 
						LEFT JOIN tipos_deptos_parcela ON previsados_parcelas_destinos.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id
						WHERE previsado_carga_id = ".CCGetParam('previsado_carga_id')." AND ISNULL(previsados_parcelas_destinos.previsado_parcela_destino_reemplazo_id) 
						ORDER BY previsado_parcela_destino_id DESC";
				$db->query($SQL);
				$html = "<table cellspacing='0' cellpadding='0' width='100%' class='Grid'>
						<tr>
						<td style='color: #fff; background: #3D84CC;'><div align='center'>Depto</div></td>
						<td style='color: #fff; background: #3D84CC;'><div align='center'>Secc</div></td>
						<td style='color: #fff; background: #3D84CC;'><div align='center'>Cha</div></td>
						<td style='color: #fff; background: #3D84CC;'><div align='center'>Qta</div></td>
						<td style='color: #fff; background: #3D84CC;'><div align='center'>Mzo</div></td>
						<td style='color: #fff; background: #3D84CC;'><div align='center'>Fra</div></td>
						<td style='color: #fff; background: #3D84CC;'><div align='center'>Par</div></td>
						<td style='color: #fff; background: #3D84CC;'><div align='center'>Uf/Uc</div></td>
						<td style='color: #fff; background: #3D84CC;'><div align='center'></div></td>
						</tr>";
				while($db->next_record()){
					$html .= "<tr>";
					$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('tipo_depto_parc_desc')."</div></td>";
					$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_seccion')."</div></td>";
					$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_chacra')."</div></td>";
					$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_quinta')."</div></td>";
					$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_macizo')."</div></td>";
					$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_fraccion')."</div></td>";
					$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_parcela')."</div></td>";
					$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_uf')."</td>";
					if($previsado_tipo_estado_carga_id == 1 || $previsado_tipo_estado_carga_id == 3){
						$html .= "<td style='color: #000; background: #fff;'><div align='center'><a href='previsados_cambiar_nomencla.php?previsado_carga_id=$previsado_carga_id&previsado_parcela_destino_id=".$db->f('previsado_parcela_destino_id')."' title='cambiar datos de nomenclaatura'><img src='../iconos/16x16/view-refresh.gif'></a></td>";
					}else{
						$html .= "<td style='color: #000; background: #fff;'><div align='center'></td>";
					}
					$html .= "</tr>";
				}
				$html .= "</table>";
				$previsados_detalles_carga->nomenclatura_destino->SetValue($html);
			}else{
				$html = "<font color='RED'><b>NO TIENE</b></font>";
				$previsados_detalles_carga->nomenclatura_destino->SetValue($html);
			}
			//________________________AFECTACIONES______________________
			$cant_afectaciones = CCDLookUp("COUNT(*)","previsados_parcelas_afectaciones","previsado_carga_id = ".CCGetParam('previsado_carga_id'),$db2);
			if($cant_afectaciones){
				$SQL="SELECT previsados_parcelas_afectaciones.*, tipos_deptos_parcela.tipo_depto_parc_desc AS tipo_depto_parc_desc
						FROM previsados_parcelas_afectaciones 
						LEFT JOIN tipos_deptos_parcela ON previsados_parcelas_afectaciones.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id
						WHERE previsado_carga_id = ".CCGetParam('previsado_carga_id')." 
						ORDER BY previsado_parcela_afectacion_id DESC";
				$db->query($SQL);
				$html = "<table cellspacing='0' cellpadding='0' width='100%' class='Grid'>
						<tr>
						<td style='color: #fff; background: #3D84CC;'><div align='center'>Depto</div></td>
						<td style='color: #fff; background: #3D84CC;'><div align='center'>Secc</div></td>
						<td style='color: #fff; background: #3D84CC;'><div align='center'>Cha</div></td>
						<td style='color: #fff; background: #3D84CC;'><div align='center'>Qta</div></td>
						<td style='color: #fff; background: #3D84CC;'><div align='center'>Mzo</div></td>
						<td style='color: #fff; background: #3D84CC;'><div align='center'>Fra</div></td>
						<td style='color: #fff; background: #3D84CC;'><div align='center'>Par</div></td>
						<td style='color: #fff; background: #3D84CC;'><div align='center'>Uf/Uc</div></td>
						<td style='color: #fff; background: #3D84CC;'><div align='center'>Pol</div></td>
						</tr>";
				while($db->next_record()){
					$html .= "<tr>";
					$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('tipo_depto_parc_desc')."</div></td>";
					$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_seccion')."</div></td>";
					$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_chacra')."</div></td>";
					$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_quinta')."</div></td>";
					$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_macizo')."</div></td>";
					$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_fraccion')."</div></td>";
					$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_parcela')."</div></td>";
					$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_uf')."</td>";
					$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_poligono')."</td>";
					$html .= "</tr>";
				}
				$html .= "</table>";
				$previsados_detalles_carga->nomenclatura_afectacion->SetValue($html);
			}else{
				$html = "<font color='RED'><b>NO TIENE</b></font>";
				$previsados_detalles_carga->nomenclatura_afectacion->SetValue($html);
			}
		}
		$db->close();
		$db2->close();
	}else{
		$previsados_detalles_carga->Visible = FALSE;
	}
// -------------------------
//End Custom Code

//Close previsados_detalles_carga_BeforeShow @4-3A890BBE
    return $previsados_detalles_carga_BeforeShow;
}
//End Close previsados_detalles_carga_BeforeShow

//previsados_detalles_carga_BeforeShowRow @4-622D3DD9
function previsados_detalles_carga_BeforeShowRow(& $sender)
{
    $previsados_detalles_carga_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_detalles_carga; //Compatibility
//End previsados_detalles_carga_BeforeShowRow

//Custom Code @73-2A29BDB7
// -------------------------
	$db = new clsDBtdf_nuevo();
	$previsado_detalle_carga_id = $previsados_detalles_carga->DataSource->f('previsado_detalle_carga_id');
	$SQL="SELECT * FROM previsados_archivos_detalles WHERE previsado_detalle_carga_id=$previsado_detalle_carga_id";
	$db->query($SQL);
	$html="<table cellspacing='0' cellpadding='0' width='100%'>";
	while($db->next_record()){
		$html.="<tr><td style='color: #000; background: #fff; border: hidden'><b><a href='../../plancheta/previsado/".$db->f('previsado_detalle_carga_ubica')."' download='".$db->f('previsado_detalle_nombre_arch_org')."'>".$db->f('previsado_detalle_nombre_arch_org')."</a></b></td></tr>";
	}
	$html.="</table>";
	$previsados_detalles_carga->previsado_detalle_carga_ubica->SetValue($html);
	$db->close();
// -------------------------
//End Custom Code

//Close previsados_detalles_carga_BeforeShowRow @4-6A9BFE39
    return $previsados_detalles_carga_BeforeShowRow;
}
//End Close previsados_detalles_carga_BeforeShowRow

//respuesta_Button_Insert_OnClick @15-C889C90D
function respuesta_Button_Insert_OnClick(& $sender)
{
    $respuesta_Button_Insert_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $respuesta; //Compatibility
//End respuesta_Button_Insert_OnClick

//Custom Code @43-2A29BDB7
// -------------------------
    $previsado_carga_id = CCGetParam('previsado_carga_id');
  	$db = new clsDBtdf_nuevo();
	$user_id = CCDLookUp("user_id","previsados_cargas","previsado_carga_id = $previsado_carga_id",$db);

	//borra lista de chequeo
  	$previsado_respuesta_id = CCDLookUp("previsado_respuesta_id","previsados_respuestas","previsado_carga_id=$previsado_carga_id",$db);
  	$SQL = "DELETE FROM previsados_respuestas_verificaciones WHERE previsado_respuesta_id = $previsado_respuesta_id";
  	$db->query($SQL);
  	//inserta lista de chequeo
  	if(CCGetParam(previsado_tipo_verif_id)){
  		$s = CCGetParam(previsado_tipo_verif_id);
  		while (list ($clave, $val) = each ($s)) {
   	   		$SQL = "INSERT INTO previsados_respuestas_verificaciones
  		   			  SET previsado_respuesta_id = $previsado_respuesta_id,
  					      previsado_tipo_verif_id = $val";
  		   $db->query($SQL);
  		}
  	}
	//cambia de estado si esta elegido
	$previsado_tipo_estado_carga_id = $respuesta->previsado_tipo_estado_carga_id->GetValue();
	if($previsado_tipo_estado_carga_id == 2){//2: APTO DEFINITIVO
		if($respuesta->observaciones->GetValue()){
			//agrega la observacion
			$SQL="INSERT INTO previsados_contestaciones SET 
								previsado_contestacion_f = NOW(),
								previsado_contestacion_texto = '".$respuesta->observaciones->GetValue()."', 
								usuario_id = '".CCGetUserID()."', 
								previsado_respuesta_id = $previsado_respuesta_id";
			$db->query($SQL);
		}
		//actualiza respuesta
		$SQL="UPDATE previsados_respuestas SET 
					previsado_respuesta_cerrado = 1, 
					previsado_respuesta_proc_resp = NOW() 
					WHERE previsado_respuesta_id = $previsado_respuesta_id";
		$db->query($SQL);
	}elseif($previsado_tipo_estado_carga_id == 3 || $previsado_tipo_estado_carga_id == 5){//3:OBSERVADO;5:A CARATULAR
		//agrega la observacion
		if($previsado_tipo_estado_carga_id == 3){//para observacion es obligatorio
			$SQL="INSERT INTO previsados_contestaciones SET 
								previsado_contestacion_f = NOW(),
								previsado_contestacion_texto = '".$respuesta->observaciones->GetValue()."', 
								usuario_id = '".CCGetUserID()."', 
								previsado_respuesta_id = $previsado_respuesta_id";
			$db->query($SQL);
			$contestaciones = $respuesta->observaciones->GetValue();
		}else{
			if($respuesta->observaciones->GetValue() != ""){//para caratular solo se registra si hay comentarios
				$SQL="INSERT INTO previsados_contestaciones SET 
								previsado_contestacion_f = NOW(),
								previsado_contestacion_texto = '".$respuesta->observaciones->GetValue()."', 
								usuario_id = '".CCGetUserID()."', 
								previsado_respuesta_id = $previsado_respuesta_id";
				$db->query($SQL);
			}
		}
		
		$previsado_contestacion_id = mysql_insert_id();
		//archivo adjunto respuesta
		$nombre_archivo_tmp = $respuesta->archivo_carga->Value;

		if($nombre_archivo_tmp != ''){//si se cargó un archivo
			$nombre_archivo_separado = explode(".", $nombre_archivo_tmp);
			for($i=1;$i<count($nombre_archivo_separado);$i++){//arma solo el nombre real
				$nombre_archivo .= $nombre_archivo_separado[$i].".";
			}
			$nombre_archivo = substr($nombre_archivo,0,-1);//quita el ultimo punto
			//nombre destino: id Detalle _ id usuario - fecha Ymd_H_i_s
			$usuario_id = CCGetUserID();
			$fecha_carga = date("Ymd_H_i_s");
			$nombre_destino = $previsado_contestacion_id."_".$usuario_id."_".$fecha_carga.".pdf";
			$origen = $respuesta->archivo_carga->TemporaryFolder.$nombre_archivo_tmp;
			$destino = $respuesta->archivo_carga->FileFolder.$nombre_destino;
			
			if (copy($origen,$destino)) {
				$SQL= "UPDATE previsados_contestaciones SET previsado_contesta_arch_nom = '$nombre_archivo', previsado_contesta_arch_ubica = '$nombre_destino' WHERE previsado_contestacion_id=$previsado_contestacion_id";
				$db->query($SQL);
				unlink($origen);//borrar archivo de origen
			}
		}
	}

	if($previsado_tipo_estado_carga_id == 2 || $previsado_tipo_estado_carga_id == 5){
		$tipo_depto_parc_id = $respuesta->tipo_depto_parc_id->GetValue();
		$previsado_respuesta_nro_plano = $respuesta->previsado_respuesta_nro_plano->GetValue();
		$previsado_respuesta_nro_anio = $respuesta->previsado_respuesta_nro_anio->GetValue();
		$previsado_respuesta_exp_nro = $respuesta->previsado_respuesta_exp_nro->GetValue();
		$previsado_respuesta_exp_letra = $respuesta->previsado_respuesta_exp_letra->GetValue();
		$previsado_respuesta_exp_anio = $respuesta->previsado_respuesta_exp_anio->GetValue();
		$otro_exp = "tipo_depto_parc_id = '$tipo_depto_parc_id', 
					previsado_respuesta_nro_plano = '$previsado_respuesta_nro_plano', 
					previsado_respuesta_nro_anio = '$previsado_respuesta_nro_anio', 
					previsado_respuesta_exp_nro = '$previsado_respuesta_exp_nro', 
					previsado_respuesta_exp_letra = '$previsado_respuesta_exp_letra', 
					previsado_respuesta_exp_anio = '$previsado_respuesta_exp_anio' ";
		$SQL="UPDATE previsados_respuestas SET 
				 $otro_exp 
				WHERE previsado_respuesta_id = $previsado_respuesta_id";
		$db->query($SQL);
	}
	$plazo_tiempo=$respuesta->plazo_tiempo->GetValue();
	$fecha_futura = "";
	if($plazo_tiempo){
		$fecha_futura = calculaFecha($plazo_tiempo,"2016-09-20");;
	}
	$SQL="UPDATE previsados_respuestas SET 
			previsado_plazo_tiempo = '$plazo_tiempo',
			previsado_tiempo_fin = '$fecha_futura'
			WHERE previsado_respuesta_id = $previsado_respuesta_id";
	$db->query($SQL);
	//actualiza notas
	if($respuesta->caratula->GetValue() == 1){//esta marcado a caratular
		$previsado_respuesta_caratula = $respuesta->caratula->GetValue();
		$previsado_respuesta_f_caratula = CCFormatDate(CCParseDate($respuesta->fecha_caratula->GetValue(),array("dd","/","mm","/","yyyy")),array("yyyy", "-", "mm", "-", "dd"));
		$otro = "previsado_respuesta_caratula = $previsado_respuesta_caratula, previsado_respuesta_f_caratula = '$previsado_respuesta_f_caratula' ";
	}else{
		$otro = "previsado_respuesta_caratula = NULL, previsado_respuesta_f_caratula = NULL";
	}
	//------------------------agrega datos de los campos de pantalla-------------------------------
	$SQL="UPDATE previsados_respuestas SET 
			previsado_respuesta_nota = '".$respuesta->previsado_respuesta_nota->GetValue()."', 
			 $otro 
			WHERE previsado_respuesta_id = $previsado_respuesta_id";
	$db->query($SQL);
	//actualiza estado
	$SQL="UPDATE previsados_cargas SET previsado_tipo_estado_carga_id = '$previsado_tipo_estado_carga_id' WHERE previsado_carga_id = $previsado_carga_id";
	$db->query($SQL);
	//---------------------------------registra movimiento--------------------------------------------------
	$respuesta = CCDLookUp("previsado_tipo_estado_carga_descrip","previsados_tipos_estados_cargas","previsado_tipo_estado_carga_id = $previsado_tipo_estado_carga_id",$db);
	$SQL="INSERT INTO previsados_movimientos SET 
				previsado_carga_id = $previsado_carga_id,
				previsado_movimiento_fecha = NOW(),
				usuario_id = ".CCGetUserID().", 
				tipo_usuario = 2,
				previsado_movimiento_observacion = 'Respuesta de $respuesta por el operador.'";
	$db->query($SQL);

	//---------------------------------------pre-mail---------------------------------------------------------------
	$user_name = CCDLookUp("usuario_nombre","_usuarios","usuario_id = ".CCGetUserID(),$db);
	$prof_mail = CCDLookUp("prof_mail","profesionales","user_id = $user_id",$db);


	if($previsado_tipo_estado_carga_id != 3){// no ha contestacion sino en OBSERVADO
		$contestaciones = '';
	}
	$plano = "";
	$expediente = "";
	if($previsado_tipo_estado_carga_id == 2){// si es para aprobar se envia los datos de plano y expedinte por correo
		$contestaciones = 'Datos para el Plano';
		$tipo_depto_parc_id = CCDLookUp("tipo_depto_parc_id","previsados_respuestas","previsado_carga_id=$previsado_carga_id",$db);
		$previsado_respuesta_nro_plano = CCDLookUp("previsado_respuesta_nro_plano","previsados_respuestas","previsado_carga_id=$previsado_carga_id",$db);
		$previsado_respuesta_nro_anio = CCDLookUp("previsado_respuesta_nro_anio","previsados_respuestas","previsado_carga_id=$previsado_carga_id",$db);
		$previsado_respuesta_exp_nro = CCDLookUp("previsado_respuesta_exp_nro","previsados_respuestas","previsado_carga_id=$previsado_carga_id",$db);
		$previsado_respuesta_exp_letra = CCDLookUp("previsado_respuesta_exp_letra","previsados_respuestas","previsado_carga_id=$previsado_carga_id",$db);
		$previsado_respuesta_exp_anio = CCDLookUp("previsado_respuesta_exp_anio","previsados_respuestas","previsado_carga_id=$previsado_carga_id",$db);
		$plano = "T.F. $tipo_depto_parc_id-$previsado_respuesta_nro_plano-$previsado_respuesta_nro_anio";
		$expediente = "$previsado_respuesta_exp_nro-$previsado_respuesta_exp_letra-$previsado_respuesta_exp_anio";
	}
	$db->close();
	//######################################CORREO#######################################
	/* Enviar notificación por email
	------------------------------------------------------------------------------------- */
	$subject = "[PREVISADO PLANO NRO $previsado_carga_id - $respuesta]";
	$body[] = '-------------------------------------------------------------------';
	$body[] = 'Autor: ' . $user_name;
	$body[] = 'Fecha: ' . date('d/m/Y') . ' a las ' . date('H:i:s');
	$body[] = 'Mensaje: (este E-MAIL puede contener errores de formato)';
	$body[] = '-------------------------------------------------------------------';
	$body[] = 'Su plano y documentacion ingresado se encuentra '.$respuesta;
	$body[] = 'Ingrese a la aplicacion de previsado de plano para tener más detalle.';
	$body[] = 'Nro de Previsado: '.$previsado_carga_id;
	$body[] = '';
	$body[] = ''.$contestaciones;
	$body[] = ''.$plano;
	$body[] = ''.$expediente;
	
	if($prof_mail != ''){
		sendNotification_general_TDF($prof_mail,$subject,$body,array('debug' => false));
	}
	//###################################################################################
	global $Redirect;
	$Redirect = "previsados_respuesta.php?previsado_carga_id=$previsado_carga_id";
// -------------------------
//End Custom Code

//Close respuesta_Button_Insert_OnClick @15-EEAF4B21
    return $respuesta_Button_Insert_OnClick;
}
//End Close respuesta_Button_Insert_OnClick

//respuesta_BeforeShow @12-EB20382D
function respuesta_BeforeShow(& $sender)
{
    $respuesta_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $respuesta; //Compatibility
//End respuesta_BeforeShow

//Custom Code @50-2A29BDB7
// -------------------------
	$db = new clsDBtdf_nuevo();
	$usuario_id = CCGetUserID();
	$respuesta->nombre->SetValue(CCDLookUp("usuario_nombre","_usuarios","usuario_id = $usuario_id",$db));

	$previsado_carga_id = CCGetParam('previsado_carga_id');
	$previsado_respuesta_id = CCDLookUp("previsado_respuesta_id","previsados_respuestas","previsado_carga_id=$previsado_carga_id",$db);
	$previsado_respuesta_cerrado = CCDLookUp("previsado_respuesta_cerrado","previsados_respuestas","previsado_respuesta_id=$previsado_respuesta_id",$db);
	$previsado_tipo_estado_carga_id = CCDLookUp("previsado_tipo_estado_carga_id","previsados_cargas","previsado_carga_id=$previsado_carga_id",$db);
	$respuesta->previsado_tipo_estado_carga_id->SetValue($previsado_tipo_estado_carga_id);
	$existe = CCDLookUp("COUNT(*)","previsados_cargas","previsado_carga_id = $previsado_carga_id",$db);

	$respuesta->Button1->Visible = FALSE;
	$respuesta->tipo_depto_parc_id->Visible = FALSE;
	$respuesta->previsado_respuesta_nro_plano->Visible = FALSE;
	$respuesta->previsado_respuesta_nro_anio->Visible = FALSE;
	$respuesta->previsado_respuesta_exp_nro->Visible = FALSE;
	$respuesta->previsado_respuesta_exp_letra->Visible = FALSE;
	$respuesta->previsado_respuesta_exp_anio->Visible = FALSE;
	if($respuesta->previsado_tipo_estado_carga_id->GetValue() == 2 || $respuesta->previsado_tipo_estado_carga_id->GetValue() == 5){
		$respuesta->Panel1->Visible = TRUE;
		$respuesta->tipo_depto_parc_id->Visible = TRUE;
		$respuesta->previsado_respuesta_nro_plano->Visible = TRUE;
		$respuesta->previsado_respuesta_nro_anio->Visible = TRUE;
		$respuesta->previsado_respuesta_exp_nro->Visible = TRUE;
		$respuesta->previsado_respuesta_exp_letra->Visible = TRUE;
		$respuesta->previsado_respuesta_exp_anio->Visible = TRUE;
	}
	if($previsado_respuesta_cerrado || !$previsado_carga_id || !$existe){
		$respuesta->Button_Insert->Visible = FALSE;
	}else{
		$respuesta->Button_Insert->Visible = TRUE;
	}

	if(!$existe){
		$respuesta->aviso->SetValue("<font size='2' color='RED'><b>FUE ELIMINADO POR EL USUARIO(PROFESIONAL) O NO EXITE LA CARGA</b></font>");
	}else{
		$respuesta->aviso->SetValue("");
	}
	// trae las unidades que estén vinculadas y las agrega en un array
	$SQL = "SELECT * 
			FROM previsados_respuestas_verificaciones 
			WHERE previsado_respuesta_id = $previsado_respuesta_id";
	$db->query($SQL);
	
	while($db->next_record()){
		$a[] = $db->f('previsado_tipo_verif_id');
	}

	$nota = CCDLookUp("previsado_respuesta_nota","previsados_respuestas","previsado_respuesta_id=$previsado_respuesta_id",$db);
	$respuesta->previsado_respuesta_nota->SetValue($nota);
	$cantidad = CCDLookUp("COUNT(*)","previsados_tipos_verificaciones","tipo_estado_id = 1 ORDER BY previsado_tipo_verif_orden",$db);
	$respuesta->cantidad->SetValue($cantidad);
	
	//---------------------caratula-------------------------------------------
	$previsado_respuesta_caratula = CCDLookUp("previsado_respuesta_caratula","previsados_respuestas","previsado_carga_id=$previsado_carga_id",$db);
	$previsado_respuesta_f_caratula = CCDLookUp("previsado_respuesta_f_caratula","previsados_respuestas","previsado_carga_id=$previsado_carga_id",$db);
	
	//---------------------plano-------------------------------------------
	$tipo_depto_parc_id = CCDLookUp("tipo_depto_parc_id","previsados_respuestas","previsado_carga_id=$previsado_carga_id",$db);
	$previsado_respuesta_nro_plano = CCDLookUp("previsado_respuesta_nro_plano","previsados_respuestas","previsado_carga_id=$previsado_carga_id",$db);
	$previsado_respuesta_nro_anio = CCDLookUp("previsado_respuesta_nro_anio","previsados_respuestas","previsado_carga_id=$previsado_carga_id",$db);
	//---------------------expediente-------------------------------------------
	$previsado_respuesta_exp_nro = CCDLookUp("previsado_respuesta_exp_nro","previsados_respuestas","previsado_carga_id=$previsado_carga_id",$db);
	$previsado_respuesta_exp_letra = CCDLookUp("previsado_respuesta_exp_letra","previsados_respuestas","previsado_carga_id=$previsado_carga_id",$db);
	$previsado_respuesta_exp_anio = CCDLookUp("previsado_respuesta_exp_anio","previsados_respuestas","previsado_carga_id=$previsado_carga_id",$db);
	$respuesta->tipo_depto_parc_id->SetValue($tipo_depto_parc_id);
	$respuesta->previsado_respuesta_nro_plano->SetValue($previsado_respuesta_nro_plano);
	$respuesta->previsado_respuesta_nro_anio->SetValue($previsado_respuesta_nro_anio);
	$respuesta->previsado_respuesta_exp_nro->SetValue($previsado_respuesta_exp_nro);
	$respuesta->previsado_respuesta_exp_letra->SetValue($previsado_respuesta_exp_letra);
	$respuesta->previsado_respuesta_exp_anio->SetValue($previsado_respuesta_exp_anio);

	$plazo_tiempo = CCDLookUp("previsado_plazo_tiempo","previsados_respuestas","previsado_carga_id=$previsado_carga_id",$db);
	$respuesta->plazo_tiempo->SetValue($plazo_tiempo);
	
	$db->close();
	// asigna el valor a la fila para que aparezca marcado
  	$Component->previsado_tipo_verif_id->Value = $a;
	//---------------------------contestacion_respuesta-----------------------------------
	$frame = "previsado_ifame_contestaciones.php?previsado_respuesta_id=$previsado_respuesta_id";
	$htm= "<iframe src='$frame' 
			frameborder='0' 
			width='100%'
			height='100'
			scrolling='auto'>Su navegador no soporta frames o está actualmente configurado para no mostrarlos. Consulte con el Dpto. de Sistemas.</iframe>";
	$respuesta->contestacion->SetValue($htm);

	if($previsado_respuesta_caratula == 1){
		$respuesta->caratula->SetValue($previsado_respuesta_caratula);
		$previsado_respuesta_f_caratula = CCFormatDate(CCParseDate($previsado_respuesta_f_caratula,array("yyyy", "-", "mm", "-", "dd")),array("dd","/","mm","/","yyyy"));
		$respuesta->fecha_caratula->SetValue($previsado_respuesta_f_caratula);
	}

// -------------------------
//End Custom Code

//Close respuesta_BeforeShow @12-8B3A5645
    return $respuesta_BeforeShow;
}
//End Close respuesta_BeforeShow

//respuesta_OnValidate @12-A855C24D
function respuesta_OnValidate(& $sender)
{
    $respuesta_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $respuesta; //Compatibility
//End respuesta_OnValidate

//Custom Code @51-2A29BDB7
// -------------------------
    if($respuesta->previsado_tipo_estado_carga_id->GetValue() == 3 && !$respuesta->observaciones->GetValue()){
		$respuesta->Errors->addError("Si esta OBSERVADO, debe agregar una observacion");
	}

// -------------------------
//End Custom Code

//Close respuesta_OnValidate @12-B4C132CC
    return $respuesta_OnValidate;
}
//End Close respuesta_OnValidate

//respuesta_AfterUpdate @12-BBF781BF
function respuesta_AfterUpdate(& $sender)
{
    $respuesta_AfterUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $respuesta; //Compatibility
//End respuesta_AfterUpdate

//Custom Code @78-2A29BDB7
// -------------------------

// -------------------------
//End Custom Code

//Close respuesta_AfterUpdate @12-B0B97409
    return $respuesta_AfterUpdate;
}
//End Close respuesta_AfterUpdate

//respuesta_BeforeInsert @12-E3380701
function respuesta_BeforeInsert(& $sender)
{
    $respuesta_BeforeInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $respuesta; //Compatibility
//End respuesta_BeforeInsert

//Custom Code @79-2A29BDB7
// -------------------------

// -------------------------
//End Custom Code

//Close respuesta_BeforeInsert @12-558B061E
    return $respuesta_BeforeInsert;
}
//End Close respuesta_BeforeInsert

//Page_BeforeInitialize @1-4D77FAC4
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_respuesta; //Compatibility
//End Page_BeforeInitialize

//Custom Code @48-2A29BDB7
// -------------------------
	// Incluye el archivo de funciones generales
	include_once(RelativePath . "/scripts/myFunctions.php");

    // Incluye la gestión de permisos
	include_once(RelativePath . "/scripts/permisos1.php");

    $previsado_carga_id = CCGetParam('previsado_carga_id');
	$db = new clsDBtdf_nuevo();
	$previsado_respuesta_id = CCDLookUp("previsado_respuesta_id","previsados_respuestas","previsado_carga_id = $previsado_carga_id",$db);
	if(!$previsado_respuesta_id){
		$usuario_id = CCGetUserID();
		$SQL="INSERT INTO previsados_respuestas SET previsado_respuesta_proc = NOW(), previsado_carga_id = $previsado_carga_id, usuario_id = '$usuario_id'";
		$db->query($SQL);
		$previsado_respuesta_id = mysql_insert_id();
	}
	CCSetSession('previsado_respuesta_id', $previsado_respuesta_id);
	$db->close();
// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize
?>
