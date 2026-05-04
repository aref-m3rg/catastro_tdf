<?php
define("RelativePath", "..");
include(RelativePath . "/Common.php");

$db = new clsDBtdf_nuevo();
$db2 = new clsDBtdf_nuevo();

$datos = array();

if(CCGetParam('cant_a')||CCGetParam('cant_b')||CCGetParam('cant_c')){
		//--------------------------------------------RESERVADO PARA LA DIRECCION------------------------------------------------------
		//parametros:
		//	a,b,c,tipo_mejora_conserva_id,tipo_mejora_cat_id,tipo_mejora_cat_2_id,tipo_mejora_conserva_3_id,mejora_anio_construccion,
		//  mejora_sup_cub,mejora_sup_semi_cub,mejora_sup_cub_2,mejora_cant_bp,mejora_cant_bs
		
		//cantidad de A
		$cantE1A = (int) $_GET['cant_a'];
		if(!$cantE1A){ $cantE1A = 0; }
		//valor de A
		$valE1A = (float) CCDLookUp("mejoras_valores.mejora_valor_valor","mejoras_valores INNER JOIN mejoras_formularios ON mejoras_valores.mejora_formulario_id = mejoras_formularios.mejora_formulario_id INNER JOIN tipos_mejoras_cat ON mejoras_valores.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id","mejoras_formularios.mejora_formulario_abrev = 'E1' AND mejoras_valores.mejora_valor_f_ini <= NOW() AND tipos_mejoras_cat.tipo_mejora_cat_descript = 'A'",$db2);
		//cant_valor de A
		$cantValorE1A = $cantE1A * $valE1A;
		
		//cantidad de B
		$cantE1B = (int) $_GET['cant_b'];
		if(!$cantE1B){ $cantE1B = 0; }
		//valor de B
		$valE1B = (float) CCDLookUp("mejoras_valores.mejora_valor_valor","mejoras_valores INNER JOIN mejoras_formularios ON mejoras_valores.mejora_formulario_id = mejoras_formularios.mejora_formulario_id INNER JOIN tipos_mejoras_cat ON mejoras_valores.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id","mejoras_formularios.mejora_formulario_abrev = 'E1' AND mejoras_valores.mejora_valor_f_ini <= NOW() AND tipos_mejoras_cat.tipo_mejora_cat_descript = 'B'",$db2);
		//cant_valor de B
		$cantValorE1B = $cantE1B * $valE1B;

		//cantidad de C
		$cantE1C = (int) $_GET['cant_c'];
		if(!$cantE1C){ $cantE1C = 0; }
		//valor de C
		$valE1C = (float) CCDLookUp("mejoras_valores.mejora_valor_valor","mejoras_valores INNER JOIN mejoras_formularios ON mejoras_valores.mejora_formulario_id = mejoras_formularios.mejora_formulario_id INNER JOIN tipos_mejoras_cat ON mejoras_valores.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id","mejoras_formularios.mejora_formulario_abrev = 'E1' AND mejoras_valores.mejora_valor_f_ini <= NOW() AND tipos_mejoras_cat.tipo_mejora_cat_descript = 'C'",$db2);
		//cant_valor de C
		$cantValorE1C = $cantE1C * $valE1C;
		
		$sum_cant = $cantE1A + $cantE1B + $cantE1C;
		if($sum_cant == 0){
			echo "Error de division por cero, corrija los datos ingresados";exit;
			return 0;
		}		
		$sum_valor = $cantValorE1A + $cantValorE1B + $cantValorE1C;
		
		$valor_unitario_m2 = floor(($sum_valor/$sum_cant)*100)/100;

		$datos[] = array('cant_A',$cantE1A);
		$datos[] = array('val_A',$valE1A);
		$datos[] = array('mult_A',$cantValorE1A);
		$datos[] = array('cant_B',$cantE1B);
		$datos[] = array('val_B',$valE1B);
		$datos[] = array('mult_B',$cantValorE1B);
		$datos[] = array('cant_C',$cantE1C);
		$datos[] = array('val_C',$valE1C);
		$datos[] = array('mult_C',$cantValorE1C);		
		$datos[] = array('sum_cant',$sum_cant);
		$datos[] = array('sum_val',$sum_valor);
		$datos[] = array('val_uni',$valor_unitario_m2);
		
		//-------------------------------------------------------------------------------------------------------------------------------------------
		//Segun las cantidades a que tipo corresponde
		
		if(($cantE1A > $cantE1B) && ($cantE1A  > $cantE1C)){
			$tipo='A';
		}elseif(($cantE1B > $cantE1A) && ($cantE1B > $cantE1C)){
			$tipo='B';
		}elseif(($cantE1C > $cantE1A) && ($cantE1C > $cantE1B)){
			$tipo='C';
		}elseif(($cantE1A == $cantE1B) && ($cantE1A > $cantE1C)){
			$tipo='A';
		}elseif(($cantE1A == $cantE1C) && ($cantE1A > $cantE1B)){
			$tipo='A';
		}elseif(($cantE1B == $cantE1C) && ($cantE1B > $cantE1A)){
			$tipo='B';
		}elseif(($cantE1A == $cantE1B) && ($cantE1B == $cantE1C)){
			$tipo='A';
		}

		$tipo_cat = CCDLookUp("tipo_mejora_cat_id","tipos_mejoras_cat","tipo_mejora_cat_descript = '$tipo'",$db2);
		$coefg = CCDLookUp("mejora_coeficiente_valor","mejoras_coeficientes","tipo_mejora_conserva_id = '".$_GET['tipo_mejora_conserva_id']."' AND mejora_coeficiente_anio = '".$_GET['mejora_anio_construccion']."' AND tipo_mejora_cat_id = '$tipo_cat'",$db2);
		if(!$coefg){ $coefg = 0.0; }		

		$datos[] = array('coef_gen',$coefg);

		//--------------------------------------VALUACION DEL EDIFICIO DESTINADO A VIVIENDA O DESTINOS SIMILARES------------------------------------------------------
		
		//--------------------------------------1º EDIFICIO--------------------------------------------------------------------------------------------------------------
		$coef = (float) CCDLookUp("mejora_coeficiente_valor","mejoras_coeficientes","tipo_mejora_conserva_id = '".$_GET['tipo_mejora_conserva_id']."' AND mejora_coeficiente_anio = '".$_GET['mejora_anio_construccion']."' AND tipo_mejora_cat_id = '".$_GET['tipo_mejora_cat_id']."'",$db2);
		if(!$coef){ $coef = 0.0; }
		$total1 = floor((float)($coef * $valor_unitario_m2 * $_GET['mejora_sup_cub'])*100)/100;
		
		//--------------------------------------2º PORCH O GALERIA--------------------------------------------------------------------------------------------------------------
		$coef = (float) CCDLookUp("mejora_coeficiente_valor","mejoras_coeficientes","tipo_mejora_conserva_id = '".$_GET['tipo_mejora_conserva_id']."' AND mejora_coeficiente_anio = '".$_GET['mejora_anio_construccion']."' AND tipo_mejora_cat_id = '".$_GET['tipo_mejora_cat_2_id']."'",$db2);
		
		$categ = CCDLookUp("tipo_mejora_cat_descript","tipos_mejoras_cat","tipo_mejora_cat_id = ".$_GET['tipo_mejora_cat_2_id'],$db2);
		$sum_sub_total2 = $valor_unitario_m2;
		
		if($categ == "C"){
			$sum_sub_total2 = floor(($valor_unitario_m2 * 0.30)*100)/100;
		}else{
			$sum_sub_total2 = floor(($valor_unitario_m2 * 0.50)*100)/100;
		}

		$total2 = floor((float)($coef * $sum_sub_total2 * $_GET['mejora_sup_semi_cub'])*100)/100;
		
		//---TOTAL VALOR EDIFICIO
		
		$total_val_edif = $total1 + $total2;
		$datos[] = array('valor_uni_edif',$valor_unitario_m2);
		$datos[] = array('valor_uni_porc',$sum_sub_total2);
		$datos[] = array('subtotal_vivienda',$total1);
		$datos[] = array('subtotal_porch',$total2);
		$datos[] = array('subtotal_edificio',$total_val_edif);		
		
		//--------------------------------------VALUACION DEL EDIFICIO DESTINADO A NEGOCIOS O SALAS------------------------------------------------------
		
		$coef = (float) CCDLookUp("mejora_coeficiente_valor","mejoras_coeficientes","tipo_mejora_conserva_id = '".$_GET['tipo_mejora_conserva_id']."' AND mejora_coeficiente_anio = '".$_GET['mejora_anio_construccion']."' AND tipo_mejora_cat_id = '".$_GET['tipo_mejora_cat_2_id']."'",$db2);
		$sum_sub_total3 = $valor_unitario_m2;
		if($_GET['mejora_sup_cub_2'] > 100.0){
			$sum_sub_total3 = floor(($valor_unitario_m2 * 0.70)*100)/100;
		}
		
		$total_val_negoc = floor((float)($coef * $sum_sub_total3 * $_GET['mejora_sup_cub_2'])*100)/100;
		
		$datos[] = array('valor_uni_neg',$sum_sub_total3);
		$datos[] = array('subtotal_negocio',$total_val_negoc);
		
		//--------------------------------------VALUACION DE OBRAS ACCESORIAS------------------------------------------------------
		
		$valor = (float) CCDLookUp("mejoras_valores.mejora_valor_valor","mejoras_valores INNER JOIN mejoras_formularios ON mejoras_valores.mejora_formulario_id = mejoras_formularios.mejora_formulario_id INNER JOIN tipos_mejoras_cat ON mejoras_valores.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id","mejoras_formularios.mejora_formulario_abrev = 'E1' AND mejoras_valores.mejora_valor_f_ini <= NOW() AND tipos_mejoras_cat.tipo_mejora_cat_descript = '$tipo' AND mejoras_valores.mejora_construccion_id = 2",$db2);
		$total_bp = floor((float)($coefg * $valor *  $_GET['mejora_cant_bp'])*100)/100;
		
		$valor = (float) CCDLookUp("mejoras_valores.mejora_valor_valor","mejoras_valores INNER JOIN mejoras_formularios ON mejoras_valores.mejora_formulario_id = mejoras_formularios.mejora_formulario_id INNER JOIN tipos_mejoras_cat ON mejoras_valores.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id","mejoras_formularios.mejora_formulario_abrev = 'E1' AND mejoras_valores.mejora_valor_f_ini <= NOW() AND tipos_mejoras_cat.tipo_mejora_cat_descript = '$tipo' AND mejoras_valores.mejora_construccion_id = 3",$db2);
		$total_bs = floor((float)($coefg * $valor *  $_GET['mejora_cant_bs'])*100)/100;
		
		$total_val_obras = $total_bp + $total_bs;
		$datos[] = array('valor_uni_bp',$total_bp);//eliminar
		$datos[] = array('subtotal_bp',$total_bp);
		$datos[] = array('valor_uni_bs',$total_bs);//eliminar
		$datos[] = array('subtotal_bs',$total_bs);
		$datos[] = array('subtotal_bt',$total_val_obras);
		
		//--------------------------------------SUBTOTAL------------------------------------------------------

		$total_total = $total_val_edif + $total_val_negoc + $total_val_obras;

		//--------------------------------------TOTAL------------------------------------------------------

		$ajuste = (float) CCDLookUp("tipo_coef_ajuste_valor","tipos_coef_ajustes","tipo_coef_ajuste_f_ini <= NOW()",$db2);
		$total = floor(($total_total * $ajuste)*100)/100;
		
		$datos[] = array('subtotal',$total_total);
		$datos[] = array('ajuste',$ajuste);
		$datos[] = array('total',$total);
		
		echo json_encode($datos);				
}
$db->close();
$db2->close();
?>