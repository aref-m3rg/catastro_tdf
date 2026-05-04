<?php
//BindEvents Method @1-48B50FFA
function BindEvents()
{
    global $mejoras_tipos_mejoras_tip;
    global $mejoras;
    global $parcelas;
    global $mejoras1;
    global $CCSEvents;
    $mejoras_tipos_mejoras_tip->mejoras_tipos_mejoras_tip_TotalRecords->CCSEvents["BeforeShow"] = "mejoras_tipos_mejoras_tip_mejoras_tipos_mejoras_tip_TotalRecords_BeforeShow";
    $mejoras_tipos_mejoras_tip->CCSEvents["BeforeShow"] = "mejoras_tipos_mejoras_tip_BeforeShow";
    $mejoras_tipos_mejoras_tip->CCSEvents["BeforeShowRow"] = "mejoras_tipos_mejoras_tip_BeforeShowRow";
    $mejoras->Button_Delete->CCSEvents["OnClick"] = "mejoras_Button_Delete_OnClick";
    $mejoras->Button_Delete->CCSEvents["BeforeShow"] = "mejoras_Button_Delete_BeforeShow";
    $mejoras->baja->CCSEvents["BeforeShow"] = "mejoras_baja_BeforeShow";
    $mejoras->Button_alta->CCSEvents["OnClick"] = "mejoras_Button_alta_OnClick";
    $mejoras->Button_alta->CCSEvents["BeforeShow"] = "mejoras_Button_alta_BeforeShow";
    $mejoras->Button_eliminar->CCSEvents["OnClick"] = "mejoras_Button_eliminar_OnClick";
    $mejoras->CCSEvents["BeforeInsert"] = "mejoras_BeforeInsert";
    $mejoras->CCSEvents["BeforeUpdate"] = "mejoras_BeforeUpdate";
    $mejoras->CCSEvents["BeforeShow"] = "mejoras_BeforeShow";
    $mejoras->CCSEvents["AfterInsert"] = "mejoras_AfterInsert";
    $mejoras->CCSEvents["AfterUpdate"] = "mejoras_AfterUpdate";
    $parcelas->CCSEvents["BeforeShow"] = "parcelas_BeforeShow";
    $mejoras1->Button_Delete->CCSEvents["OnClick"] = "mejoras1_Button_Delete_OnClick";
    $mejoras1->Button_Delete->CCSEvents["BeforeShow"] = "mejoras1_Button_Delete_BeforeShow";
    $mejoras1->baja->CCSEvents["BeforeShow"] = "mejoras1_baja_BeforeShow";
    $mejoras1->Button_alta->CCSEvents["OnClick"] = "mejoras1_Button_alta_OnClick";
    $mejoras1->Button_alta->CCSEvents["BeforeShow"] = "mejoras1_Button_alta_BeforeShow";
    $mejoras1->Button_eliminar->CCSEvents["OnClick"] = "mejoras1_Button_eliminar_OnClick";
    $mejoras1->CCSEvents["BeforeInsert"] = "mejoras1_BeforeInsert";
    $mejoras1->CCSEvents["BeforeUpdate"] = "mejoras1_BeforeUpdate";
    $mejoras1->CCSEvents["BeforeShow"] = "mejoras1_BeforeShow";
    $mejoras1->CCSEvents["AfterInsert"] = "mejoras1_AfterInsert";
    $mejoras1->CCSEvents["AfterUpdate"] = "mejoras1_AfterUpdate";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
}
//End BindEvents Method

//mejoras_tipos_mejoras_tip_mejoras_tipos_mejoras_tip_TotalRecords_BeforeShow @36-84634A64
function mejoras_tipos_mejoras_tip_mejoras_tipos_mejoras_tip_TotalRecords_BeforeShow(& $sender)
{
    $mejoras_tipos_mejoras_tip_mejoras_tipos_mejoras_tip_TotalRecords_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras_tipos_mejoras_tip; //Compatibility
//End mejoras_tipos_mejoras_tip_mejoras_tipos_mejoras_tip_TotalRecords_BeforeShow

//Retrieve number of records @37-ABE656B4
    $Component->SetValue($Container->DataSource->RecordsCount);
//End Retrieve number of records

//Close mejoras_tipos_mejoras_tip_mejoras_tipos_mejoras_tip_TotalRecords_BeforeShow @36-5F56CCDC
    return $mejoras_tipos_mejoras_tip_mejoras_tipos_mejoras_tip_TotalRecords_BeforeShow;
}
//End Close mejoras_tipos_mejoras_tip_mejoras_tipos_mejoras_tip_TotalRecords_BeforeShow

//mejoras_tipos_mejoras_tip_BeforeShow @6-FF7FC24A
function mejoras_tipos_mejoras_tip_BeforeShow(& $sender)
{
    $mejoras_tipos_mejoras_tip_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras_tipos_mejoras_tip; //Compatibility
//End mejoras_tipos_mejoras_tip_BeforeShow

//Custom Code @166-2A29BDB7
// -------------------------
    $db = new clsDBtdf_nuevo();
	$cub=round(CCDLookUp("SUM(mejora_sup_cub)","mejoras","parcela_id = ".CCGetParam('parcela_id')." AND tipo_estado_id = 1",$db)*100)/100;
	$cub_2=round(CCDLookUp("SUM(mejora_sup_cub_2)","mejoras","parcela_id = ".CCGetParam('parcela_id')." AND tipo_estado_id = 1",$db)*100)/100;
	$semi=round(CCDLookUp("SUM(mejora_sup_semi_cub)","mejoras","parcela_id = ".CCGetParam('parcela_id')." AND tipo_estado_id = 1",$db)*100)/100;
	$val=round(CCDLookUp("SUM(mejora_valuacion)","mejoras","parcela_id = ".CCGetParam('parcela_id')." AND tipo_estado_id = 1",$db)*100)/100;

	if($cub == ''){
		$cub = 0.0;
	}
	if($cub_2 == ''){
		$cub_2 = 0.0;
	}
	if($semi == ''){
		$semi = 0.0;
	}
	$mejoras_tipos_mejoras_tip->sum_sup_cub->SetValue($cub);
	$mejoras_tipos_mejoras_tip->sum_sup_cub_2->SetValue($cub_2);
	$mejoras_tipos_mejoras_tip->sum_sup_semi_cub->SetValue($semi);
	$mejoras_tipos_mejoras_tip->sup_total->SetValue((round(($cub+$semi+$cub_2)*100)/100)." m<sup>2</sup>");
	$mejoras_tipos_mejoras_tip->val_total->SetValue($val);
	$db->close();

	if(CCGetParam('f') != ''){
		$mejoras_tipos_mejoras_tip->Visible=false;
	}
// -------------------------
//End Custom Code

//Close mejoras_tipos_mejoras_tip_BeforeShow @6-A1C254E6
    return $mejoras_tipos_mejoras_tip_BeforeShow;
}
//End Close mejoras_tipos_mejoras_tip_BeforeShow

//mejoras_tipos_mejoras_tip_BeforeShowRow @6-893B9E2F
function mejoras_tipos_mejoras_tip_BeforeShowRow(& $sender)
{
    $mejoras_tipos_mejoras_tip_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras_tipos_mejoras_tip; //Compatibility
//End mejoras_tipos_mejoras_tip_BeforeShowRow

//Custom Code @186-2A29BDB7
// -------------------------
    if(CCGetParam(mejora_id) == $mejoras_tipos_mejoras_tip->ds->f(mejora_id)){
		$mejoras_tipos_mejoras_tip->Attributes->SetValue("rowStyle", 'class="AltRow"');
		$mejoras_tipos_mejoras_tip->este->Visible=true;
	} else {
		$mejoras_tipos_mejoras_tip->Attributes->SetValue("rowStyle", 'class="Row"');
		$mejoras_tipos_mejoras_tip->este->Visible=false;
	}
	if($mejoras_tipos_mejoras_tip->ds->f(mejora_form) == 'E1'){
		$mejoras_tipos_mejoras_tip->pdfE2->Visible = false;
		$mejoras_tipos_mejoras_tip->pdfE1->Visible = true;
	}elseif($mejoras_tipos_mejoras_tip->ds->f(mejora_form) == 'E2'){
		$mejoras_tipos_mejoras_tip->pdfE1->Visible = false;
		$mejoras_tipos_mejoras_tip->pdfE2->Visible = true;
	}else{
		$mejoras_tipos_mejoras_tip->este->Visible=false;
	}
// -------------------------
//End Custom Code

//Close mejoras_tipos_mejoras_tip_BeforeShowRow @6-D4195829
    return $mejoras_tipos_mejoras_tip_BeforeShowRow;
}
//End Close mejoras_tipos_mejoras_tip_BeforeShowRow

//mejoras_Button_Delete_OnClick @67-085D6513
function mejoras_Button_Delete_OnClick(& $sender)
{
    $mejoras_Button_Delete_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras; //Compatibility
//End mejoras_Button_Delete_OnClick

//Custom Code @131-2A29BDB7
// -------------------------

// -------------------------
//End Custom Code

//Close mejoras_Button_Delete_OnClick @67-7324830E
    return $mejoras_Button_Delete_OnClick;
}
//End Close mejoras_Button_Delete_OnClick

//mejoras_Button_Delete_BeforeShow @67-A1F026C5
function mejoras_Button_Delete_BeforeShow(& $sender)
{
    $mejoras_Button_Delete_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras; //Compatibility
//End mejoras_Button_Delete_BeforeShow

//Custom Code @135-2A29BDB7
// -------------------------
	if($mejoras->tipo_estado_id->GetValue() == 1){
    	$mejoras->Button_Delete->Visible = true;
	}else{
		$mejoras->Button_Delete->Visible = false;
	}
// -------------------------
//End Custom Code

//Close mejoras_Button_Delete_BeforeShow @67-9836822D
    return $mejoras_Button_Delete_BeforeShow;
}
//End Close mejoras_Button_Delete_BeforeShow

//mejoras_baja_BeforeShow @133-E48AE59C
function mejoras_baja_BeforeShow(& $sender)
{
    $mejoras_baja_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras; //Compatibility
//End mejoras_baja_BeforeShow

//Custom Code @134-2A29BDB7
// -------------------------
	if($mejoras->tipo_estado_id->GetValue() == 2){
		$mejoras->baja->SetValue("<font color='RED' size='3'><b>Mejora dada de Baja</b></font>");
	}elseif($mejoras->mejora_f_baja->GetValue() != ''){
		$mejoras->baja->SetValue("<font color='ORANGE' size='2'><b>Esta Mejora estubo de baja</b></font>");
	}else{
		$mejoras->baja->SetValue("");
	}
// -------------------------
//End Custom Code

//Close mejoras_baja_BeforeShow @133-1CBF543F
    return $mejoras_baja_BeforeShow;
}
//End Close mejoras_baja_BeforeShow

//mejoras_Button_alta_OnClick @181-F96B0738
function mejoras_Button_alta_OnClick(& $sender)
{
    $mejoras_Button_alta_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras; //Compatibility
//End mejoras_Button_alta_OnClick

//Custom Code @183-2A29BDB7
// -------------------------
    $db = new clsDBtdf_nuevo();
	$mejoras->tipo_estado_id->SetValue(1);
	$db->query("UPDATE mejoras SET tipo_estado_id = 1, mejora_f_pro = '".date('Y-m-d H:i:s')."' WHERE mejora_id = ".CCGetParam('mejora_id'));
	$db->close();
// -------------------------
//End Custom Code

//Close mejoras_Button_alta_OnClick @181-D312FC42
    return $mejoras_Button_alta_OnClick;
}
//End Close mejoras_Button_alta_OnClick

//mejoras_Button_alta_BeforeShow @181-EEB8806B
function mejoras_Button_alta_BeforeShow(& $sender)
{
    $mejoras_Button_alta_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras; //Compatibility
//End mejoras_Button_alta_BeforeShow

//Custom Code @184-2A29BDB7
// -------------------------
    if($mejoras->tipo_estado_id->GetValue() == 2){
    	$mejoras->Button_alta->Visible = true;
	}else{
		$mejoras->Button_alta->Visible = false;
	}
// -------------------------
//End Custom Code

//Close mejoras_Button_alta_BeforeShow @181-86AB0689
    return $mejoras_Button_alta_BeforeShow;
}
//End Close mejoras_Button_alta_BeforeShow

//mejoras_Button_eliminar_OnClick @627-09F6855B
function mejoras_Button_eliminar_OnClick(& $sender)
{
    $mejoras_Button_eliminar_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras; //Compatibility
//End mejoras_Button_eliminar_OnClick

//Custom Code @628-2A29BDB7
// -------------------------
	$db = new clsDBtdf_nuevo();
	$SQL="DELETE FROM mejoras WHERE mejora_id = ".CCGetParam(mejora_id);
	$db->query($SQL);
	$db->close();
// -------------------------
//End Custom Code

//Close mejoras_Button_eliminar_OnClick @627-229195F9
    return $mejoras_Button_eliminar_OnClick;
}
//End Close mejoras_Button_eliminar_OnClick

//mejoras_BeforeInsert @64-D19CEDAF
function mejoras_BeforeInsert(& $sender)
{
    $mejoras_BeforeInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras; //Compatibility
//End mejoras_BeforeInsert

//Custom Code @124-2A29BDB7
// -------------------------
	$mejoras->mejora_f_pro->SetValue(date('Y-m-d H:i:s'));
	$mejoras->tipo_estado_id->SetValue(1);
// -------------------------
//End Custom Code

//Close mejoras_BeforeInsert @64-399E74D2
    return $mejoras_BeforeInsert;
}
//End Close mejoras_BeforeInsert

//mejoras_BeforeUpdate @64-92D35DAE
function mejoras_BeforeUpdate(& $sender)
{
    $mejoras_BeforeUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras; //Compatibility
//End mejoras_BeforeUpdate

//Custom Code @127-2A29BDB7
// -------------------------
	$mejoras->mejora_f_pro->SetValue(date('Y-m-d H:i:s'));
	$mejoras->tipo_estado_id->SetValue(1);
// -------------------------
//End Custom Code

//Close mejoras_BeforeUpdate @64-F6B7B55D
    return $mejoras_BeforeUpdate;
}
//End Close mejoras_BeforeUpdate

//mejoras_BeforeShow @64-72583193
function mejoras_BeforeShow(& $sender)
{
    $mejoras_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras; //Compatibility
//End mejoras_BeforeShow

//Custom Code @160-2A29BDB7
// -------------------------
  	$audit_string = implode('|',array(CCGetUserID(),$_SERVER[REMOTE_ADDR],substr(strrchr ($_SERVER['PHP_SELF'], "/"), 1)));
  	$mejoras->audit_string->SetValue($audit_string);
  
  	$mejoras->Visible = False;
  	$mejoras->mejora_f_pro->SetValue(date('Y-m-d H:i:s')); 
	//muestra record
	if(CCGetParam(mejora_id) > 0){
			$mejoras->Button_eliminar->Visible=true;
	}else{
			$mejoras->Button_eliminar->Visible=false;
	}
  	if(CCGetParam(mejora_id) > 0 && CCGetParam(add) == 0 && CCGetParam(f) == 'E2'){
  		$mejoras->Visible = True;
  	}
  	if(CCGetParam(parcela_id) > 0 && CCGetParam(add) == 1 && CCGetParam(f) == 'E2'){
  		$mejoras->Visible = True;
  	}
	$db = new clsDBtdf_nuevo();

	
	$sup_parc=CCDLookUp("parcela_super_mensura","parcelas","parcela_id = ".CCGetParam('parcela_id'),$db);
	if(CCGetParam('mejora_id')){
		$mejoras->mejora_nro_nota->SetValue(CCDLookUp("mejora_nro_nota","mejoras","mejora_id = ".CCGetParam('mejora_id'),$db));
		//recupera las cantidades de las clasificaciones
		$cantE2B=CCDLookUp("mejora_tipo_cat_cant","mejoras_tipos_cat","mejora_id = '".CCGetParam('mejora_id')."' AND tipo_mejora_cat_id = '2'",$db);
		if(!$cantE2B){
			$cantE2B = 0;
		}
		$mejoras->cantE2B->SetValue($cantE2B);

		$cantE2C=CCDLookUp("mejora_tipo_cat_cant","mejoras_tipos_cat","mejora_id = '".CCGetParam('mejora_id')."' AND tipo_mejora_cat_id = '3'",$db);
		if(!$cantE2C){
			$cantE2C = 0;
		}
		$mejoras->cantE2C->SetValue($cantE2C);	
	}


	//recupera el valor actual del coeficiente de ajuste
	$mejoras->coefE2A->SetValue(CCDLookUp("tipo_coef_ajuste_valor","tipos_coef_ajustes","ISNULL(tipo_coef_ajuste_f_fin)",$db));

	//recupera los valores para la valuacion
	$mejoras->valE2B->SetValue(CCDLookUp("mejoras_valores.mejora_valor_valor","mejoras_valores INNER JOIN mejoras_formularios ON mejoras_valores.mejora_formulario_id = mejoras_formularios.mejora_formulario_id INNER JOIN tipos_mejoras_cat ON mejoras_valores.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id","mejoras_formularios.mejora_formulario_abrev = '".CCGetParam('f')."' AND mejoras_valores.mejora_valor_f_ini <= NOW() AND tipos_mejoras_cat.tipo_mejora_cat_descript = 'B' AND mejoras_valores.mejora_construccion_id = 1",$db));
	$mejoras->valE2C->SetValue(CCDLookUp("mejoras_valores.mejora_valor_valor","mejoras_valores INNER JOIN mejoras_formularios ON mejoras_valores.mejora_formulario_id = mejoras_formularios.mejora_formulario_id INNER JOIN tipos_mejoras_cat ON mejoras_valores.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id","mejoras_formularios.mejora_formulario_abrev = '".CCGetParam('f')."' AND mejoras_valores.mejora_valor_f_ini <= NOW() AND tipos_mejoras_cat.tipo_mejora_cat_descript = 'C' AND mejoras_valores.mejora_construccion_id = 1",$db));

	$tipo_medida=CCDLookUp("unidades_medidas_descrip","parcelas LEFT JOIN unidades_medidas ON unidades_medidas.unidades_medidas_id = parcelas.unidades_medidas_id","parcela_id = ".CCGetParam('parcela_id'),$db);
	switch($tipo_medida){
	    case 'Hectareas':
	        $mejoras->sup_terreno->SetValue($sup_parc*10000.00);break;
	    case 'Area':
	        $mejoras->sup_terreno->SetValue($sup_parc*100.00);break;
	    default:
	        $mejoras->sup_terreno->SetValue($sup_parc);
	}
	$tipo_estado_id=CCDLookUp("tipo_estado_id","mejoras","mejora_id = ".CCGetParam('mejora_id'),$db);
	if($tipo_estado_id == 2){
		$mejoras->Button_Update->Visible=false;
		$mejoras->motivo_baja->SetValue("<font color='RED'><b>Motivo: ".CCDLookUp("mejora_mot_baja","mejoras","mejora_id = ".CCGetParam('mejora_id'),$db)."</b></font>");
	}

	$db->close();
// -------------------------
//End Custom Code

//Close mejoras_BeforeShow @64-0083545D
    return $mejoras_BeforeShow;
}
//End Close mejoras_BeforeShow

//mejoras_AfterInsert @64-CF54FE94
function mejoras_AfterInsert(& $sender)
{
    $mejoras_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras; //Compatibility
//End mejoras_AfterInsert

//Custom Code @513-2A29BDB7
// -------------------------
    $mejora_id = mysql_insert_id();
	$db = new clsDBtdf_nuevo();
	$mejora_tipo_cat_cant = $mejoras->cantE2B->GetValue();
	

	$tipo_mejora_cat_id = 2;
	$SQL = "INSERT INTO mejoras_tipos_cat SET tipo_mejora_cat_id = $tipo_mejora_cat_id, mejora_id = $mejora_id, mejora_tipo_cat_cant = $mejora_tipo_cat_cant";
	$db->query($SQL);
	$mejora_tipo_cat_cant = $mejoras->cantE2C->GetValue();
	$tipo_mejora_cat_id = 3;
	$SQL = "INSERT INTO mejoras_tipos_cat SET tipo_mejora_cat_id = $tipo_mejora_cat_id, mejora_id = $mejora_id, mejora_tipo_cat_cant = $mejora_tipo_cat_cant";
	$db->query($SQL);

	$mejora_nro_nota=$mejoras->mejora_nro_nota->GetValue();
	$SQL="UPDATE mejoras SET mejora_nro_nota = '".mysql_real_escape_string($mejora_nro_nota)."' WHERE mejora_id = $mejora_id";
	$db->query($SQL);
	$db->close();
// -------------------------
//End Custom Code

//Close mejoras_AfterInsert @64-6C7794D2
    return $mejoras_AfterInsert;
}
//End Close mejoras_AfterInsert

//mejoras_AfterUpdate @64-C6123E85
function mejoras_AfterUpdate(& $sender)
{
    $mejoras_AfterUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras; //Compatibility
//End mejoras_AfterUpdate

//Custom Code @514-2A29BDB7
// -------------------------
	$db = new clsDBtdf_nuevo();
	$db2 = new clsDBtdf_nuevo();
	$mejora_id = CCGetParam('mejora_id');
	$mejora_tipo_cat_cant = $mejoras->cantE2B->GetValue();
	

	$tipo_mejora_cat_id = 2;
	$SQL = "SELECT * FROM mejoras_tipos_cat WHERE tipo_mejora_cat_id = $tipo_mejora_cat_id AND mejora_id = $mejora_id";
	$db->query($SQL);

	if($db->next_record()){
		$SQL = "UPDATE mejoras_tipos_cat SET mejora_tipo_cat_cant = $mejora_tipo_cat_cant WHERE tipo_mejora_cat_id = $tipo_mejora_cat_id AND mejora_id = $mejora_id";
		$db2->query($SQL);
	}else{
		$SQL = "INSERT INTO mejoras_tipos_cat SET mejora_tipo_cat_cant = $mejora_tipo_cat_cant, tipo_mejora_cat_id = $tipo_mejora_cat_id, mejora_id = $mejora_id";
		$db2->query($SQL);
	}

	$mejora_tipo_cat_cant = $mejoras->cantE2C->GetValue();
	$tipo_mejora_cat_id = 3;

	$SQL = "SELECT * FROM mejoras_tipos_cat WHERE tipo_mejora_cat_id = $tipo_mejora_cat_id AND mejora_id = $mejora_id";
	$db->query($SQL);

	if($db->next_record()){
		$SQL = "UPDATE mejoras_tipos_cat SET mejora_tipo_cat_cant = $mejora_tipo_cat_cant WHERE tipo_mejora_cat_id = $tipo_mejora_cat_id AND mejora_id = $mejora_id";
		$db2->query($SQL);
	}else{
		$SQL = "INSERT INTO mejoras_tipos_cat SET mejora_tipo_cat_cant = $mejora_tipo_cat_cant, tipo_mejora_cat_id = $tipo_mejora_cat_id, mejora_id = $mejora_id";
		$db2->query($SQL);
	}
	$mejora_nro_nota = $mejoras->mejora_nro_nota->GetValue();
	$SQL="UPDATE mejoras SET mejora_nro_nota = '".mysql_real_escape_string($mejora_nro_nota)."' WHERE mejora_id = $mejora_id";
	$db->query($SQL);
	$db->close();
	$db2->close();
// -------------------------
//End Custom Code

//Close mejoras_AfterUpdate @64-A35E555D
    return $mejoras_AfterUpdate;
}
//End Close mejoras_AfterUpdate

//parcelas_BeforeShow @197-3DB6FDDD
function parcelas_BeforeShow(& $sender)
{
    $parcelas_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas; //Compatibility
//End parcelas_BeforeShow

//Custom Code @645-2A29BDB7
// -------------------------
	$db = new clsDBtdf_nuevo();
	$parcelas->paso->SetValue(CCDLookUp("IF(parcela_uf <> '','SI','NO') AS paso","parcelas","parcela_id=".CCGetParam('parcela_id'),$db));
	$db->close();
// -------------------------
//End Custom Code

//Close parcelas_BeforeShow @197-FBF6787B
    return $parcelas_BeforeShow;
}
//End Close parcelas_BeforeShow

//mejoras1_Button_Delete_OnClick @359-7B122CE6
function mejoras1_Button_Delete_OnClick(& $sender)
{
    $mejoras1_Button_Delete_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras1; //Compatibility
//End mejoras1_Button_Delete_OnClick

//Custom Code @361-2A29BDB7
// -------------------------

// -------------------------
//End Custom Code

//Close mejoras1_Button_Delete_OnClick @359-E2B9E1F5
    return $mejoras1_Button_Delete_OnClick;
}
//End Close mejoras1_Button_Delete_OnClick

//mejoras1_Button_Delete_BeforeShow @359-D2950FAC
function mejoras1_Button_Delete_BeforeShow(& $sender)
{
    $mejoras1_Button_Delete_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras1; //Compatibility
//End mejoras1_Button_Delete_BeforeShow

//Custom Code @362-2A29BDB7
// -------------------------
	if($mejoras1->tipo_estado_id->GetValue() == 1){
    	$mejoras1->Button_Delete->Visible = true;
	}else{
		$mejoras1->Button_Delete->Visible = false;
	}
// -------------------------
//End Custom Code

//Close mejoras1_Button_Delete_BeforeShow @359-F8D2F851
    return $mejoras1_Button_Delete_BeforeShow;
}
//End Close mejoras1_Button_Delete_BeforeShow

//mejoras1_baja_BeforeShow @377-4447727B
function mejoras1_baja_BeforeShow(& $sender)
{
    $mejoras1_baja_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras1; //Compatibility
//End mejoras1_baja_BeforeShow

//Custom Code @378-2A29BDB7
// -------------------------
	if($mejoras1->tipo_estado_id->GetValue() == 2){
		$mejoras1->baja->SetValue("<font color='RED' size='3'><b>Mejora dada de Baja</b></font>");
	}elseif($mejoras1->mejora_f_baja->GetValue() != ''){
		$mejoras1->baja->SetValue("<font color='ORANGE' size='2'><b>Esta Mejora estubo de baja</b></font>");
	}else{
		$mejoras1->baja->SetValue("");
	}
// -------------------------
//End Custom Code

//Close mejoras1_baja_BeforeShow @377-0E2F6CB2
    return $mejoras1_baja_BeforeShow;
}
//End Close mejoras1_baja_BeforeShow

//mejoras1_Button_alta_OnClick @386-EC9D8ADE
function mejoras1_Button_alta_OnClick(& $sender)
{
    $mejoras1_Button_alta_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras1; //Compatibility
//End mejoras1_Button_alta_OnClick

//Custom Code @388-2A29BDB7
// -------------------------
    $db = new clsDBtdf_nuevo();
	$mejoras1->tipo_estado_id->SetValue(1);
	$db->query("UPDATE mejoras SET tipo_estado_id = 1, mejora_f_pro = '".date('Y-m-d H:i:s')."' WHERE mejora_id = ".CCGetParam('mejora_id'));
	$db->close();
// -------------------------
//End Custom Code

//Close mejoras1_Button_alta_OnClick @386-64A1DDDE
    return $mejoras1_Button_alta_OnClick;
}
//End Close mejoras1_Button_alta_OnClick

//mejoras1_Button_alta_BeforeShow @386-02DC51B1
function mejoras1_Button_alta_BeforeShow(& $sender)
{
    $mejoras1_Button_alta_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras1; //Compatibility
//End mejoras1_Button_alta_BeforeShow

//Custom Code @389-2A29BDB7
// -------------------------
    if($mejoras1->tipo_estado_id->GetValue() == 2){
    	$mejoras1->Button_alta->Visible = true;
	}else{
		$mejoras1->Button_alta->Visible = false;
	}
// -------------------------
//End Custom Code

//Close mejoras1_Button_alta_BeforeShow @386-AC55B07F
    return $mejoras1_Button_alta_BeforeShow;
}
//End Close mejoras1_Button_alta_BeforeShow

//mejoras1_Button_eliminar_OnClick @624-40F60F93
function mejoras1_Button_eliminar_OnClick(& $sender)
{
    $mejoras1_Button_eliminar_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras1; //Compatibility
//End mejoras1_Button_eliminar_OnClick

//Custom Code @626-2A29BDB7
// -------------------------
	$db = new clsDBtdf_nuevo();
	$SQL="DELETE FROM mejoras WHERE mejora_id = ".CCGetParam(mejora_id);
	$db->query($SQL);
	$db->close();
// -------------------------
//End Custom Code

//Close mejoras1_Button_eliminar_OnClick @624-76653C66
    return $mejoras1_Button_eliminar_OnClick;
}
//End Close mejoras1_Button_eliminar_OnClick

//mejoras1_BeforeInsert @356-97C82138
function mejoras1_BeforeInsert(& $sender)
{
    $mejoras1_BeforeInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras1; //Compatibility
//End mejoras1_BeforeInsert

//Custom Code @414-2A29BDB7
// -------------------------
	$mejoras1->mejora_f_pro->SetValue(date('Y-m-d H:i:s'));
	$mejoras1->tipo_estado_id->SetValue(1);
	if($mejoras1->mejora_sup_cub_2->GetValue() > 0 && $mejoras1->mejora_sup_semi_cub->GetValue() == 0 && $mejoras1->mejora_sup_cub->GetValue() == 0){
		$mejoras1->tipo_mejora_destino_id->SetValue(2);
	}
// -------------------------
//End Custom Code

//Close mejoras1_BeforeInsert @356-7399FEB5
    return $mejoras1_BeforeInsert;
}
//End Close mejoras1_BeforeInsert

//mejoras1_BeforeUpdate @356-FA4B777A
function mejoras1_BeforeUpdate(& $sender)
{
    $mejoras1_BeforeUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras1; //Compatibility
//End mejoras1_BeforeUpdate

//Custom Code @415-2A29BDB7
// -------------------------
	$mejoras1->mejora_f_pro->SetValue(date('Y-m-d H:i:s'));
	$mejoras1->tipo_estado_id->SetValue(1);
// -------------------------
//End Custom Code

//Close mejoras1_BeforeUpdate @356-BCB03F3A
    return $mejoras1_BeforeUpdate;
}
//End Close mejoras1_BeforeUpdate

//mejoras1_BeforeShow @356-BA883009
function mejoras1_BeforeShow(& $sender)
{
    $mejoras1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras1; //Compatibility
//End mejoras1_BeforeShow

//Custom Code @416-2A29BDB7
// -------------------------
  	$audit_string = implode('|',array(CCGetUserID(),$_SERVER[REMOTE_ADDR],substr(strrchr ($_SERVER['PHP_SELF'], "/"), 1)));
  	$mejoras1->audit_string->SetValue($audit_string);
  
  	$mejoras1->Visible = False;
  	$mejoras1->mejora_f_pro->SetValue(date('Y-m-d H:i:s')); 
	if(CCGetParam(mejora_id) > 0){
			$mejoras1->Button_eliminar->Visible=true;
	}else{
			$mejoras1->Button_eliminar->Visible=false;
	}
  	if(CCGetParam(mejora_id) > 0 && CCGetParam(add) == 0 && CCGetParam(f) == 'E1'){
  		$mejoras1->Visible = True;
  	}
  	if(CCGetParam(parcela_id) > 0 && CCGetParam(add) == 1 && CCGetParam(f) == 'E1'){
  		$mejoras1->Visible = True;
  	}
	$db = new clsDBtdf_nuevo();
	$sup_parc=CCDLookUp("parcela_super_mensura","parcelas","parcela_id = ".CCGetParam('parcela_id'),$db);

	if(CCGetParam('mejora_id')){
		$mejoras1->mejora_nro_nota->SetValue(CCDLookUp("mejora_nro_nota","mejoras","mejora_id = ".CCGetParam('mejora_id'),$db));

		//recupera las cantidades de las clasificaciones
		$cantE1A=CCDLookUp("mejora_tipo_cat_cant","mejoras_tipos_cat","mejora_id = '".CCGetParam('mejora_id')."' AND tipo_mejora_cat_id = '1'",$db);
		if(!$cantE1A){
			$cantE1A = 0;
		}
		$mejoras1->cantE1A->SetValue($cantE1A);

		$cantE1B=CCDLookUp("mejora_tipo_cat_cant","mejoras_tipos_cat","mejora_id = '".CCGetParam('mejora_id')."' AND tipo_mejora_cat_id = '2'",$db);
		if(!$cantE1B){
			$cantE1B = 0;
		}
		$mejoras1->cantE1B->SetValue($cantE1B);

		$cantE1C=CCDLookUp("mejora_tipo_cat_cant","mejoras_tipos_cat","mejora_id = '".CCGetParam('mejora_id')."' AND tipo_mejora_cat_id = '3'",$db);
		if(!$cantE1C){
			$cantE1C = 0;
		}
		$mejoras1->cantE1C->SetValue($cantE1C);	
	}

	//recupera el valor actual del coeficiente de ajuste
	$mejoras1->coefE1A->SetValue(CCDLookUp("tipo_coef_ajuste_valor","tipos_coef_ajustes","ISNULL(tipo_coef_ajuste_f_fin)",$db));
	
	//recupera los valores de valuacion
	$mejoras1->valE1A->SetValue(CCDLookUp("mejoras_valores.mejora_valor_valor","mejoras_valores INNER JOIN mejoras_formularios ON mejoras_valores.mejora_formulario_id = mejoras_formularios.mejora_formulario_id INNER JOIN tipos_mejoras_cat ON mejoras_valores.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id","mejoras_formularios.mejora_formulario_abrev = '".CCGetParam('f')."' AND mejoras_valores.mejora_valor_f_ini <= NOW() AND tipos_mejoras_cat.tipo_mejora_cat_descript = 'A' AND mejoras_valores.mejora_construccion_id = 1",$db));
	$mejoras1->valE1B->SetValue(CCDLookUp("mejoras_valores.mejora_valor_valor","mejoras_valores INNER JOIN mejoras_formularios ON mejoras_valores.mejora_formulario_id = mejoras_formularios.mejora_formulario_id INNER JOIN tipos_mejoras_cat ON mejoras_valores.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id","mejoras_formularios.mejora_formulario_abrev = '".CCGetParam('f')."' AND mejoras_valores.mejora_valor_f_ini <= NOW() AND tipos_mejoras_cat.tipo_mejora_cat_descript = 'B' AND mejoras_valores.mejora_construccion_id = 1",$db));
	$mejoras1->valE1C->SetValue(CCDLookUp("mejoras_valores.mejora_valor_valor","mejoras_valores INNER JOIN mejoras_formularios ON mejoras_valores.mejora_formulario_id = mejoras_formularios.mejora_formulario_id INNER JOIN tipos_mejoras_cat ON mejoras_valores.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id","mejoras_formularios.mejora_formulario_abrev = '".CCGetParam('f')."' AND mejoras_valores.mejora_valor_f_ini <= NOW() AND tipos_mejoras_cat.tipo_mejora_cat_descript = 'C' AND mejoras_valores.mejora_construccion_id = 1",$db));

	//revisar candidatos a mayor categoria
	//CAMBIAR ESTO POR VALORES ALMACENADOS
	//$mejoras1->valE1D->SetValue(CCDLookUp("mejoras_valores.mejora_valor_valor","mejoras_valores INNER JOIN mejoras_formularios ON mejoras_valores.mejora_formulario_id = mejoras_formularios.mejora_formulario_id INNER JOIN tipos_mejoras_cat ON mejoras_valores.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id","mejoras_formularios.mejora_formulario_abrev = '".CCGetParam('f')."' AND mejoras_valores.mejora_valor_f_ini <= NOW() AND tipos_mejoras_cat.tipo_mejora_cat_descript = 'B' AND mejoras_valores.mejora_construccion_id = 2",$db));
	//$mejoras1->valE1E->SetValue(CCDLookUp("mejoras_valores.mejora_valor_valor","mejoras_valores INNER JOIN mejoras_formularios ON mejoras_valores.mejora_formulario_id = mejoras_formularios.mejora_formulario_id INNER JOIN tipos_mejoras_cat ON mejoras_valores.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id","mejoras_formularios.mejora_formulario_abrev = '".CCGetParam('f')."' AND mejoras_valores.mejora_valor_f_ini <= NOW() AND tipos_mejoras_cat.tipo_mejora_cat_descript = 'C' AND mejoras_valores.mejora_construccion_id = 3",$db));

	$tipo_medida=CCDLookUp("unidades_medidas_descrip","parcelas LEFT JOIN unidades_medidas ON unidades_medidas.unidades_medidas_id = parcelas.unidades_medidas_id","parcela_id = ".CCGetParam('parcela_id'),$db);
	switch($tipo_medida){
	    case 'Hectareas':
	        $mejoras1->sup_terreno->SetValue($sup_parc*10000.00);break;
	    case 'Area':
	        $mejoras1->sup_terreno->SetValue($sup_parc*100.00);break;
	    default:
	        $mejoras1->sup_terreno->SetValue($sup_parc);
	}
	$tipo_estado_id=CCDLookUp("tipo_estado_id","mejoras","mejora_id = ".CCGetParam('mejora_id'),$db);
	if($tipo_estado_id == 2){
		$mejoras1->Button_Update->Visible=false;
		$mejoras1->motivo_baja->SetValue("<font color='RED'><b>Motivo: ".CCDLookUp("mejora_mot_baja","mejoras","mejora_id = ".CCGetParam('mejora_id'),$db)."</b></font>");
	}

	$db->close();
// -------------------------
//End Custom Code

//Close mejoras1_BeforeShow @356-228EEAF5
    return $mejoras1_BeforeShow;
}
//End Close mejoras1_BeforeShow

//mejoras1_AfterInsert @356-DA724F26
function mejoras1_AfterInsert(& $sender)
{
    $mejoras1_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras1; //Compatibility
//End mejoras1_AfterInsert

//Custom Code @594-2A29BDB7
// -------------------------
    $mejora_id = mysql_insert_id();
	$db = new clsDBtdf_nuevo();
	$mejora_tipo_cat_cant = $mejoras1->cantE1A->GetValue();
	$tipo_mejora_cat_id = 1;
	$SQL = "INSERT INTO mejoras_tipos_cat SET tipo_mejora_cat_id = $tipo_mejora_cat_id, mejora_id = $mejora_id, mejora_tipo_cat_cant = $mejora_tipo_cat_cant";
	$db->query($SQL);
	$mejora_tipo_cat_cant = $mejoras1->cantE1B->GetValue();
	$tipo_mejora_cat_id = 2;
	$SQL = "INSERT INTO mejoras_tipos_cat SET tipo_mejora_cat_id = $tipo_mejora_cat_id, mejora_id = $mejora_id, mejora_tipo_cat_cant = $mejora_tipo_cat_cant";
	$db->query($SQL);
	$mejora_tipo_cat_cant = $mejoras1->cantE1C->GetValue();
	$tipo_mejora_cat_id = 3;
	$SQL = "INSERT INTO mejoras_tipos_cat SET tipo_mejora_cat_id = $tipo_mejora_cat_id, mejora_id = $mejora_id, mejora_tipo_cat_cant = $mejora_tipo_cat_cant";
	$db->query($SQL);
	$mejora_nro_nota=$mejoras1->mejora_nro_nota->GetValue();
	$SQL="UPDATE mejoras SET mejora_nro_nota = '".mysql_real_escape_string($mejora_nro_nota)."' WHERE mejora_id = $mejora_id";
	$db->query($SQL);
	$db->close();
// -------------------------
//End Custom Code

//Close mejoras1_AfterInsert @356-B458B2B6
    return $mejoras1_AfterInsert;
}
//End Close mejoras1_AfterInsert

//mejoras1_AfterUpdate @356-AD363000
function mejoras1_AfterUpdate(& $sender)
{
    $mejoras1_AfterUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $mejoras1; //Compatibility
//End mejoras1_AfterUpdate

//Custom Code @600-2A29BDB7
// -------------------------
	$db = new clsDBtdf_nuevo();
	$db2 = new clsDBtdf_nuevo();
	$mejora_id = CCGetParam('mejora_id');
	$mejora_tipo_cat_cant = $mejoras1->cantE1A->GetValue();
	$tipo_mejora_cat_id = 2;
	$SQL = "SELECT * FROM mejoras_tipos_cat WHERE tipo_mejora_cat_id = $tipo_mejora_cat_id AND mejora_id = $mejora_id";
	$db->query($SQL);

	if($db->next_record()){
		$SQL = "UPDATE mejoras_tipos_cat SET mejora_tipo_cat_cant = $mejora_tipo_cat_cant WHERE tipo_mejora_cat_id = $tipo_mejora_cat_id AND mejora_id = $mejora_id";
		$db2->query($SQL);
	}else{
		$SQL = "INSERT INTO mejoras_tipos_cat SET mejora_tipo_cat_cant = $mejora_tipo_cat_cant, tipo_mejora_cat_id = $tipo_mejora_cat_id, mejora_id = $mejora_id";
		$db2->query($SQL);
	}

	$mejora_tipo_cat_cant = $mejoras1->cantE1B->GetValue();
	$tipo_mejora_cat_id = 2;
	$SQL = "SELECT * FROM mejoras_tipos_cat WHERE tipo_mejora_cat_id = $tipo_mejora_cat_id AND mejora_id = $mejora_id";
	$db->query($SQL);

	if($db->next_record()){
		$SQL = "UPDATE mejoras_tipos_cat SET mejora_tipo_cat_cant = $mejora_tipo_cat_cant WHERE tipo_mejora_cat_id = $tipo_mejora_cat_id AND mejora_id = $mejora_id";
		$db2->query($SQL);
	}else{
		$SQL = "INSERT INTO mejoras_tipos_cat SET mejora_tipo_cat_cant = $mejora_tipo_cat_cant, tipo_mejora_cat_id = $tipo_mejora_cat_id, mejora_id = $mejora_id";
		$db2->query($SQL);
	}

	$mejora_tipo_cat_cant = $mejoras1->cantE1C->GetValue();
	$tipo_mejora_cat_id = 3;

	$SQL = "SELECT * FROM mejoras_tipos_cat WHERE tipo_mejora_cat_id = $tipo_mejora_cat_id AND mejora_id = $mejora_id";
	$db->query($SQL);

	$mejora_nro_nota = $mejoras1->mejora_nro_nota->GetValue();
	$SQL="UPDATE mejoras SET mejora_nro_nota = '".mysql_real_escape_string($mejora_nro_nota)."' WHERE mejora_id = $mejora_id";
	$db->query($SQL);

	if($db->next_record()){
		$SQL = "UPDATE mejoras_tipos_cat SET mejora_tipo_cat_cant = $mejora_tipo_cat_cant WHERE tipo_mejora_cat_id = $tipo_mejora_cat_id AND mejora_id = $mejora_id";
		$db2->query($SQL);
	}else{
		$SQL = "INSERT INTO mejoras_tipos_cat SET mejora_tipo_cat_cant = $mejora_tipo_cat_cant, tipo_mejora_cat_id = $tipo_mejora_cat_id, mejora_id = $mejora_id";
		$db2->query($SQL);
	}

	$db->close();
	$db2->close();
// -------------------------
//End Custom Code

//Close mejoras1_AfterUpdate @356-7B717339
    return $mejoras1_AfterUpdate;
}
//End Close mejoras1_AfterUpdate

//Page_AfterInitialize @1-D8C78D9E
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $gridMejoras; //Compatibility
//End Page_AfterInitialize

//Custom Code @116-2A29BDB7
// -------------------------

  // Write your own code here.
	if(CCGetParam(add) || CCGetParam(mejora_id)){
		$Component->footerParcela->Visible = false;
	}

// -------------------------
//End Custom Code

//Close Page_AfterInitialize @1-379D319D
    return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize

//Page_BeforeInitialize @1-7D425CDF
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $gridMejoras; //Compatibility
//End Page_BeforeInitialize

//Custom Code @196-2A29BDB7
// -------------------------

    include_once(RelativePath . "/scripts/permisos1.php");

// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
