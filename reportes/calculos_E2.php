<?php
define("RelativePath", "..");
include(RelativePath . "/Common.php");

$db = new clsDBtdf_nuevo();
$db2 = new clsDBtdf_nuevo();

$datos = array();

if(CCGetParam('cant_b')||CCGetParam('cant_c')){

		$cantE2B = (int) $_GET['cant_b'];;
		if(!$cantE2B){ $cantE2B = 0; }
		$valE2B = (float) CCDLookUp("mejoras_valores.mejora_valor_valor","mejoras_valores INNER JOIN mejoras_formularios ON mejoras_valores.mejora_formulario_id = mejoras_formularios.mejora_formulario_id INNER JOIN tipos_mejoras_cat ON mejoras_valores.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id","mejoras_formularios.mejora_formulario_abrev = 'E2' AND mejoras_valores.mejora_valor_f_ini <= NOW() AND tipos_mejoras_cat.tipo_mejora_cat_descript = 'B'",$db2);
		
		$cantValorE2B = $cantE2B * $valE2B;
		
		$cantE2C = (int) $_GET['cant_c'];;
		if(!$cantE2C){ $cantE2C = 0; }		
		$valE2C = (float) CCDLookUp("mejoras_valores.mejora_valor_valor","mejoras_valores INNER JOIN mejoras_formularios ON mejoras_valores.mejora_formulario_id = mejoras_formularios.mejora_formulario_id INNER JOIN tipos_mejoras_cat ON mejoras_valores.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id","mejoras_formularios.mejora_formulario_abrev = 'E2' AND mejoras_valores.mejora_valor_f_ini <= NOW() AND tipos_mejoras_cat.tipo_mejora_cat_descript = 'C'",$db2);
		
		$cantValorE2C = $cantE2C * $valE2C;		
		
		$sum_cant = $cantE2B + $cantE2C;
		
		if($sum_cant == 0){
			echo "Error de division por cero, corrija los datos ingresados";exit;
		}
		
		$sum_val = $cantValorE2B + $cantValorE2C;
		
		$valor_unitario_m2 = floor(($sum_val/$sum_cant)*100)/100;

		$datos[] = array('cant_B',$cantE2B);
		$datos[] = array('val_B',$valE2B);
		$datos[] = array('mult_B',$cantValorE2B);
		$datos[] = array('cant_C',$cantE2C);
		$datos[] = array('val_C',$valE2C);
		$datos[] = array('mult_C',$cantValorE2C);		
		$datos[] = array('sum_cant',$sum_cant);
		$datos[] = array('sum_val',$sum_val);
		$datos[] = array('val_uni',$valor_unitario_m2);
		
		if($cantE2B > $cantE2C){
			$tipo='B';
		}elseif($cantE2B < $cantE2C){
			$tipo='C';
		}elseif($cantE2B == $cantE2C){
			if($valE2B >= $valE2C){
				$tipo='B';
			}elseif($valE2B < $valE2C){
				$tipo='C';
			}
		}
		
		$tipo_cat = CCDLookUp("tipo_mejora_cat_id","tipos_mejoras_cat","tipo_mejora_cat_descript = '$tipo'",$db2);
		$coef = (float) CCDLookUp("mejora_coeficiente_valor","mejoras_coeficientes","tipo_mejora_conserva_id = '".$_GET['tipo_mejora_conserva_id']."' AND mejora_coeficiente_anio = '".$_GET['mejora_anio_construccion']."' AND tipo_mejora_cat_id = '$tipo_cat'",$db2);
		if(!$coef){	$coef = 0.0; }
		
		$total = floor(($coef * $valor_unitario_m2 * $_GET['mejora_sup_cub'])*100)/100;
		
		$datos[] = array('coef',$coef);
		
		$ajuste = (float) CCDLookUp("tipo_coef_ajuste_valor","tipos_coef_ajustes","tipo_coef_ajuste_f_ini <= NOW()",$db2);
		$final = floor(($total*$ajuste)*100)/100;	
		
		$datos[] = array('subtotal',$total);
		$datos[] = array('ajuste',$ajuste);
		$datos[] = array('total',$final);
		
		echo json_encode($datos);		
}else{
	echo "no paso";
}
$db->close();
$db2->close();
?>