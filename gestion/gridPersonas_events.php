<?php
//BindEvents Method @1-71756BFB
function BindEvents()
{
    global $personas_personas_parcela;
    global $personas;
    global $domicilios;
    global $direcciones;
    global $personas1;
    global $CCSEvents;
    $personas_personas_parcela->Label1->CCSEvents["BeforeShow"] = "personas_personas_parcela_Label1_BeforeShow";
    $personas_personas_parcela->CCSEvents["BeforeShowRow"] = "personas_personas_parcela_BeforeShowRow";
    $personas_personas_parcela->CCSEvents["AfterSubmit"] = "personas_personas_parcela_AfterSubmit";
    $personas_personas_parcela->CCSEvents["BeforeShow"] = "personas_personas_parcela_BeforeShow";
    $personas_personas_parcela->CCSEvents["OnValidate"] = "personas_personas_parcela_OnValidate";
    $personas->eliminar->CCSEvents["OnClick"] = "personas_eliminar_OnClick";
    $personas->CCSEvents["BeforeShow"] = "personas_BeforeShow";
    $domicilios->Label1->CCSEvents["BeforeShow"] = "domicilios_Label1_BeforeShow";
    $domicilios->CCSEvents["BeforeShow"] = "domicilios_BeforeShow";
    $domicilios->CCSEvents["BeforeShowRow"] = "domicilios_BeforeShowRow";
    $direcciones->nombre_calle->CCSEvents["BeforeShow"] = "direcciones_nombre_calle_BeforeShow";
    $direcciones->nombre_barrio->CCSEvents["BeforeShow"] = "direcciones_nombre_barrio_BeforeShow";
    $direcciones->CCSEvents["BeforeShow"] = "direcciones_BeforeShow";
    $direcciones->CCSEvents["AfterInsert"] = "direcciones_AfterInsert";
    $direcciones->CCSEvents["BeforeInsert"] = "direcciones_BeforeInsert";
    $direcciones->CCSEvents["BeforeUpdate"] = "direcciones_BeforeUpdate";
    $direcciones->CCSEvents["OnValidate"] = "direcciones_OnValidate";
    $personas1->Button_Insert->CCSEvents["OnClick"] = "personas1_Button_Insert_OnClick";
    $personas1->quitar->CCSEvents["OnClick"] = "personas1_quitar_OnClick";
    $personas1->add_persona->CCSEvents["BeforeShow"] = "personas1_add_persona_BeforeShow";
    $personas1->CCSEvents["BeforeShow"] = "personas1_BeforeShow";
    $personas1->CCSEvents["OnValidate"] = "personas1_OnValidate";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
}
//End BindEvents Method

//personas_personas_parcela_Label1_BeforeShow @400-8D4C5D50
function personas_personas_parcela_Label1_BeforeShow(& $sender)
{
    $personas_personas_parcela_Label1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personas_personas_parcela; //Compatibility
//End personas_personas_parcela_Label1_BeforeShow

//Retrieve number of records @401-ABE656B4
    $Component->SetValue("<font size=2><b>".$Container->DataSource->RecordsCount."</b></font>");
//End Retrieve number of records

//Close personas_personas_parcela_Label1_BeforeShow @400-B90A58AB
    return $personas_personas_parcela_Label1_BeforeShow;
}
//End Close personas_personas_parcela_Label1_BeforeShow

//personas_personas_parcela_BeforeShowRow @115-97C91D8A
function personas_personas_parcela_BeforeShowRow(& $sender)
{
    $personas_personas_parcela_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personas_personas_parcela; //Compatibility
//End personas_personas_parcela_BeforeShowRow

//Custom Code @236-2A29BDB7
// -------------------------
    // Write your own code here.
	//si no es un titular activo, no mostrar no es candidato a ser principal

	//resaltar el seleccionado
	if(CCGetParam(persona_id) == $Component->ds->f(persona_id)){
		$Component->Attributes->SetValue("rowStyle", 'class="AltRow"');
		$Component->este->Visible=true;
	}else{
		$Component->Attributes->SetValue("rowStyle", 'class="Row"');
		$Component->este->Visible=false;
	}
	
// -------------------------
//End Custom Code

//Close personas_personas_parcela_BeforeShowRow @115-7E770EF2
    return $personas_personas_parcela_BeforeShowRow;
}
//End Close personas_personas_parcela_BeforeShowRow

//personas_personas_parcela_AfterSubmit @115-D1566679
function personas_personas_parcela_AfterSubmit(& $sender)
{
    $personas_personas_parcela_AfterSubmit = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personas_personas_parcela; //Compatibility
//End personas_personas_parcela_AfterSubmit

//Custom Code @428-2A29BDB7
// -------------------------
	$db = new clsDBtdf_nuevo();
	$SQL="UPDATE personas_parcelas SET persona_parcela_f_pro = '".date('Y-m-d H:i:s')."' WHERE parcela_id = ".CCGetParam(parcela_id);
	$db->query($SQL);
	$db->close();
// -------------------------
//End Custom Code

//Close personas_personas_parcela_AfterSubmit @115-B609BE79
    return $personas_personas_parcela_AfterSubmit;
}
//End Close personas_personas_parcela_AfterSubmit

//personas_personas_parcela_BeforeShow @115-3D0DAF62
function personas_personas_parcela_BeforeShow(& $sender)
{
    $personas_personas_parcela_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personas_personas_parcela; //Compatibility
//End personas_personas_parcela_BeforeShow

//Custom Code @619-2A29BDB7
// -------------------------
	$db = new clsDBtdf_nuevo();
	$total_porc_dom=CCDLookUp("SUM(personas_parcelas.persona_parcela_dominio)","personas_parcelas","parcela_id = ".CCGetParam(parcela_id)." AND tipo_estado_id = 1",$db);
	if($total_porc_dom > '100.00'){
    	$personas_personas_parcela->Errors->addError("Error en la suma de porcentaje total de los titulares activos, es de ".$total_porc_dom."%, verificar porcentajes de dominio de los titulares");
		$personas_personas_parcela->total_dom->SetValue("<font color='RED'><b>$total_porc_dom</b></font>");
	}elseif($total_porc_dom < '100.00'){
		$personas_personas_parcela->total_dom->SetValue("<font color='BLACK'><b>$total_porc_dom</b></font>");
	}elseif($total_porc_dom == '100.00'){
		$personas_personas_parcela->total_dom->SetValue("<font color='GREEN'><b>$total_porc_dom</b></font>");
	}
	$db->close();
// -------------------------
//End Custom Code

//Close personas_personas_parcela_BeforeShow @115-3CE9C4A2
    return $personas_personas_parcela_BeforeShow;
}
//End Close personas_personas_parcela_BeforeShow

//personas_personas_parcela_OnValidate @115-9CF0CA77
function personas_personas_parcela_OnValidate(& $sender)
{
    $personas_personas_parcela_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personas_personas_parcela; //Compatibility
//End personas_personas_parcela_OnValidate

//Custom Code @239-2A29BDB7
// -------------------------
	$db = new clsDBtdf_nuevo();
	$ppal = 0;
	$control = 0;
	$paso = 0;
	for($RowNumber = 1; $RowNumber <= $Component->TotalRows; $RowNumber++){
		if($Component->FormParameters["ppal"][$RowNumber]){
			$ppal++;
		}else{
			$control++;
		}
		if($Component->FormParameters["personas_parcelas_tipo_estado_id"][$RowNumber] == 2 && $Component->FormParameters["ppal"][$RowNumber] == 1){
			$paso++;
		}
	}
	if($control == $Component->TotalRows){$Component->Errors->AddError("Debe elegir un solo Titular Principal.");}
	if($ppal > 1){$Component->Errors->AddError("Ha definido más de un titular principal. Verifique!");}
	if($paso){$Component->Errors->AddError("No puede definir un titular con estado inactivo como principal!");}
	$db->close();
// -------------------------
//End Custom Code

//Close personas_personas_parcela_OnValidate @115-0312A02B
    return $personas_personas_parcela_OnValidate;
}
//End Close personas_personas_parcela_OnValidate

//personas_eliminar_OnClick @695-C684031E
function personas_eliminar_OnClick(& $sender)
{
    $personas_eliminar_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personas; //Compatibility
//End personas_eliminar_OnClick

//Custom Code @697-2A29BDB7
// -------------------------
	$db = new clsDBtdf_nuevo();
	$SQL="DELETE FROM personas_parcelas WHERE persona_parcela_id = ".CCGetParam('persona_parcela_id');
	$db->query($SQL);
	$db->close();
// -------------------------
//End Custom Code

//Close personas_eliminar_OnClick @695-98A0794A
    return $personas_eliminar_OnClick;
}
//End Close personas_eliminar_OnClick

//personas_BeforeShow @189-A554E3E6
function personas_BeforeShow(& $sender)
{
    $personas_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personas; //Compatibility
//End personas_BeforeShow

//Custom Code @215-2A29BDB7
// -------------------------

  $db = new clsDBtdf_nuevo();

  /* Si la persona está relacionada con otra (pers. Jurídica) trae los datos */
  if ( $Component->ds->f('persona_relacionada_id') ) {

    // Si la persona ya estaba relacionada en la DDBB

    // busca la persona y la muestra en el label y carga el campo oculto con su id
    $SQL = 'SELECT * from personas WHERE persona_id = ' . mysql_real_escape_string( $Component->ds->f('persona_relacionada_id') );
    $responsable = CCQueryToArray( $SQL, $db ); //debug( $responsable );

    $Component->persona_relacionada->SetValue( $responsable[0]['persona_denominacion'] . ' (Doc. Nro: ' . $responsable[0]['persona_nro_doc'] . ')' );

  }
	
	$personas->tipo_estado_id->SetValue(CCDLookUp("tipo_estado_id","personas_parcelas","persona_parcela_id = ".CCGetParam('persona_parcela_id'),$db));

	//llenar fecha modificacion

	//fecha proceso
	$Component->persona_parcela_f_pro->SetValue(date('Y-m-d H:i:s'));
	//auditoria

	$audit_string = implode('|',array(CCGetUserID(),$_SERVER[REMOTE_ADDR],substr(strrchr ($_SERVER['PHP_SELF'], "/"), 1)));
	$Component->audit_string->SetValue($audit_string);
	
	$Component->Visible = False;
	if(CCGetParam(persona_id) && CCGetParam(personas) && CCGetParam(persona_parcela_id) > 0){
		$Component->Visible = True;
		$Component->persona->SetValue("Editar datos de " . trim($personas->persona_apellido->GetValue()) . ", ".trim($personas->persona_nombre->GetValue()));
	}


  $db->close();

// -------------------------
//End Custom Code

//Close personas_BeforeShow @189-2E343500
    return $personas_BeforeShow;
}
//End Close personas_BeforeShow

//domicilios_Label1_BeforeShow @373-9C3DB2A8
function domicilios_Label1_BeforeShow(& $sender)
{
    $domicilios_Label1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $domicilios; //Compatibility
//End domicilios_Label1_BeforeShow

//Retrieve number of records @374-ABE656B4
    $Component->SetValue($Container->DataSource->RecordsCount);
//End Retrieve number of records

//Close domicilios_Label1_BeforeShow @373-D5445DCC
    return $domicilios_Label1_BeforeShow;
}
//End Close domicilios_Label1_BeforeShow

//domicilios_BeforeShow @243-B239D716
function domicilios_BeforeShow(& $sender)
{
    $domicilios_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $domicilios; //Compatibility
//End domicilios_BeforeShow

//Custom Code @249-2A29BDB7
// -------------------------
    // Write your own code here.
	$Component->Visible = False;
	if(CCGetParam(persona_id) && CCGetParam(direcciones) && !CCGetParam(direccion_id)){
		$Component->Visible = True;
		$db = new clsDBtdf_nuevo();
		$persona = CCDLookUp('persona_denominacion','personas','persona_id=' . CCGetParam(persona_id),$db);
		$Component->persona->SetValue($persona);
		$db->close();
	}
// -------------------------
//End Custom Code

//Close domicilios_BeforeShow @243-2BEE3CCF
    return $domicilios_BeforeShow;
}
//End Close domicilios_BeforeShow

//domicilios_BeforeShowRow @243-18302B69
function domicilios_BeforeShowRow(& $sender)
{
    $domicilios_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $domicilios; //Compatibility
//End domicilios_BeforeShowRow

//Custom Code @611-2A29BDB7
// -------------------------
	if(CCGetParam(direccion_id) == $Component->ds->f(direccion_id)){
		$Component->Attributes->SetValue("rowStyle", 'class="AltRow"');
		$Component->este->Visible=true;
	} else {
		$Component->Attributes->SetValue("rowStyle", 'class="Row"');
		$Component->este->Visible=false;
	}
// -------------------------
//End Custom Code

//Close domicilios_BeforeShowRow @243-7C79A880
    return $domicilios_BeforeShowRow;
}
//End Close domicilios_BeforeShowRow

//direcciones_nombre_calle_BeforeShow @596-7F643158
function direcciones_nombre_calle_BeforeShow(& $sender)
{
    $direcciones_nombre_calle_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $direcciones; //Compatibility
//End direcciones_nombre_calle_BeforeShow

//PTAutocomplete1 BeforeShow @600-19CDFADA
    $Component->Attributes->SetValue('id', 'direccionesnombre_calle');
//End PTAutocomplete1 BeforeShow

//Close direcciones_nombre_calle_BeforeShow @596-307E6E17
    return $direcciones_nombre_calle_BeforeShow;
}
//End Close direcciones_nombre_calle_BeforeShow

//direcciones_nombre_barrio_BeforeShow @597-5FA87EE9
function direcciones_nombre_barrio_BeforeShow(& $sender)
{
    $direcciones_nombre_barrio_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $direcciones; //Compatibility
//End direcciones_nombre_barrio_BeforeShow

//PTAutocomplete2 BeforeShow @602-F56AA0A8
    $Component->Attributes->SetValue('id', 'direccionesnombre_barrio');
//End PTAutocomplete2 BeforeShow

//Close direcciones_nombre_barrio_BeforeShow @597-5AE0A13E
    return $direcciones_nombre_barrio_BeforeShow;
}
//End Close direcciones_nombre_barrio_BeforeShow

//direcciones_BeforeShow @326-314EEF63
function direcciones_BeforeShow(& $sender)
{
    $direcciones_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $direcciones; //Compatibility
//End direcciones_BeforeShow

//Custom Code @365-2A29BDB7
// -------------------------
    // Write your own code here.
	$Component->Visible = False;
	$Component->persona_id->SetValue(CCGetParam(persona_id));

	if(CCGetParam(direccion_id) && CCGetParam(persona_id)){//esta editando
		$Component->Visible = True;
		$Component->accion->SetValue('Editar');
	}

	if(CCGetParam(persona_id) && CCGetParam(add)){//esta agregando una direccion
		$Component->Visible = True;
		$Component->accion->SetValue('Agregar');
	}
	
    $db = new clsDBtdf_nuevo();
	$Component->de->SetValue('de '.CCDLookUp("persona_denominacion","personas","persona_id = ".CCGetParam(persona_id),$db));
	$Component->nombre_calle->SetValue(CCDLookUp("calle_nombre","calles","calle_id = ".$Component->calle_id->GetValue()." AND tipo_estado_id = 1",$db));
	$Component->nombre_barrio->SetValue(CCDLookUp("barrio_nombre","barrios","barrio_id = ".$Component->barrio_id->GetValue()." AND tipo_estado_id = 1",$db));
	if($Component->calle_id->GetValue() == 0 && $Component->barrio_id->GetValue() == 0){
		$Component->calle_aux->SetValue("<font color='RED'><b>".CCDLookUp("calle_nombre","direcciones","direccion_id = ".CCGetParam('direccion_id'),$db)."</b></font>");
	}else{
		$Component->calle_aux->SetValue('');	
	}
	$db->close();
// -------------------------
//End Custom Code

//Close direcciones_BeforeShow @326-C5F47CA8
    return $direcciones_BeforeShow;
}
//End Close direcciones_BeforeShow

//direcciones_AfterInsert @326-F5AC6163
function direcciones_AfterInsert(& $sender)
{
    $direcciones_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $direcciones; //Compatibility
//End direcciones_AfterInsert

//Custom Code @366-2A29BDB7
// -------------------------
    // Write your own code here.
	//primero borrar la direccion anterior???
	//y luego relacionar la direccion en la parcela
	
	$direccion_id = mysql_insert_id();
	$parcela_id = CCGetParam(parcela_id);

	switch(CCGetParam(tipo)){
		case 'R':
			$campo = "direccion_id_real";
			$tipo = 1;
			break;
		case 'P':
			$campo = "direccion_id_postal";
			$tipo = 3;
			break;
	}
	if($direccion_id && $parcela_id){
		$db = new clsDBtdf_nuevo();

		$SQL = "UPDATE parcelas SET $campo = $direccion_id WHERE parcela_id = $parcela_id";
		$db->query($SQL);

		$SQL = "UPDATE direcciones SET tipo_direccion_id = $tipo WHERE direccion_id = $direccion_id";
		$db->query($SQL);

		$db->close();
	}
// -------------------------
//End Custom Code

//Close direcciones_AfterInsert @326-A165E569
    return $direcciones_AfterInsert;
}
//End Close direcciones_AfterInsert

//direcciones_BeforeInsert @326-A069CEC7
function direcciones_BeforeInsert(& $sender)
{
    $direcciones_BeforeInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $direcciones; //Compatibility
//End direcciones_BeforeInsert

//Custom Code @598-2A29BDB7
// -------------------------
	$direcciones->nombre_calle->SetValue(strtoupper($direcciones->nombre_calle->GetValue()));
	$direcciones->nombre_barrio->SetValue(strtoupper($direcciones->nombre_barrio->GetValue()));
    $db = new clsDBtdf_nuevo();
	$db2 = new clsDBtdf_nuevo();
	if($direcciones->nombre_calle->GetValue() != ''){
		$calle_id=CCDLookUp("calle_id","calles","calle_nombre = '".$direcciones->nombre_calle->GetValue()."'",$db);
		if($calle_id){
			$direcciones->calle_id->SetValue($calle_id);
		}else{
			$SQL="INSERT INTO calles SET calle_nombre ='".$direcciones->nombre_calle->GetValue()."', tipo_estado_id=1";
			$db2->query($SQL);
			$direcciones->calle_id->SetValue(mysql_insert_id());
		}
	}else{
		$direcciones->calle_id->SetValue('');
	}
	if($direcciones->nombre_barrio->GetValue() != ''){
		$barrio_id=CCDLookUp("barrio_id","barrios","barrio_nombre = '".$direcciones->nombre_barrio->GetValue()."'",$db);
		if($barrio_id){
			$direcciones->barrio_id->SetValue($barrio_id);
		}else{
			$SQL="INSERT INTO barrios SET barrio_nombre ='".$direcciones->nombre_barrio->GetValue()."', tipo_estado_id=1";
			$db2->query($SQL);
			$direcciones->barrio_id->SetValue(mysql_insert_id());
		}
	}else{
		$direcciones->barrio_id->SetValue('');
	}
	$db->close();
	$db2->close();
// -------------------------
//End Custom Code

//Close direcciones_BeforeInsert @326-65E00CA7
    return $direcciones_BeforeInsert;
}
//End Close direcciones_BeforeInsert

//direcciones_BeforeUpdate @326-81FCA183
function direcciones_BeforeUpdate(& $sender)
{
    $direcciones_BeforeUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $direcciones; //Compatibility
//End direcciones_BeforeUpdate

//Custom Code @605-2A29BDB7
// -------------------------
	$Component->nombre_calle->SetValue(strtoupper($Component->nombre_calle->GetValue()));
	$Component->nombre_barrio->SetValue(strtoupper($Component->nombre_barrio->GetValue()));
    $db = new clsDBtdf_nuevo();
	$db2 = new clsDBtdf_nuevo();
	if($direcciones->nombre_calle->GetValue() != ''){
		$calle_id=CCDLookUp("calle_id","calles","calle_nombre = '".$direcciones->nombre_calle->GetValue()."'",$db);
		if($calle_id){
			$direcciones->calle_id->SetValue($calle_id);
		}else{
			$SQL="INSERT INTO calles SET calle_nombre ='".mysql_real_escape_string($direcciones->nombre_calle->GetValue())."', tipo_estado_id=1";
			$db2->query($SQL);
			$direcciones->calle_id->SetValue(mysql_insert_id());
		}
	}else{
		$direcciones->calle_id->SetValue('');
	}
	if($direcciones->nombre_barrio->GetValue() != ''){
		$barrio_id=CCDLookUp("barrio_id","barrios","barrio_nombre = '".$direcciones->nombre_barrio->GetValue()."'",$db);
		if($barrio_id){
			$direcciones->barrio_id->SetValue($barrio_id);
		}else{
			$SQL="INSERT INTO barrios SET barrio_nombre ='".mysql_real_escape_string($direcciones->nombre_barrio->GetValue())."', tipo_estado_id=1";
			$db2->query($SQL);
			$direcciones->barrio_id->SetValue(mysql_insert_id());
		}
	}else{
		$direcciones->barrio_id->SetValue('');
	}
	$db->close();
	$db2->close();
// -------------------------
//End Custom Code

//Close direcciones_BeforeUpdate @326-AAC9CD28
    return $direcciones_BeforeUpdate;
}
//End Close direcciones_BeforeUpdate

//direcciones_OnValidate @326-ECC8D278
function direcciones_OnValidate(& $sender)
{
    $direcciones_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $direcciones; //Compatibility
//End direcciones_OnValidate

//Custom Code @612-2A29BDB7
// -------------------------
    if($direcciones->nombre_barrio->GetValue() == '' && $direcciones->nombre_calle->GetValue() == ''){
		$direcciones->Errors->addError("Debe ingresar al menos una ubicacion del domicilio");
	}
// -------------------------
//End Custom Code

//Close direcciones_OnValidate @326-FA0F1821
    return $direcciones_OnValidate;
}
//End Close direcciones_OnValidate

//personas1_Button_Insert_OnClick @438-D51E5ECC
function personas1_Button_Insert_OnClick(& $sender)
{
    $personas1_Button_Insert_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personas1; //Compatibility
//End personas1_Button_Insert_OnClick

//Custom Code @483-2A29BDB7
// -------------------------

  /* Hace el insert customizado al presionar el botón */


	$usuario_id = CCGetUserID();

	$personas1->persona_denominacion->SetValue($personas1->persona_apellido->GetValue()." ".$personas1->persona_nombre->GetValue());

	$tipo_persona_id = $personas1->tipo_persona_id->GetValue();
	if($tipo_persona_id > 0){
		$tipo_persona_id = "tipo_persona_id = '$tipo_persona_id', ";
	}else{
		$tipo_persona_id = '';
	}
	$tipo_documento_id = $personas1->tipo_documento_id->GetValue();
	if($tipo_documento_id > 0){
		$tipo_documento_id = "tipo_documento_id = '$tipo_documento_id', ";
	}else{
		$tipo_documento_id = '';
	}	
	$persona_nro_doc = $personas1->persona_nro_doc->GetValue();
	if($persona_nro_doc > 0){
		$persona_nro_doc = "persona_nro_doc = '$persona_nro_doc', ";
	}else{
		$persona_nro_doc = '';
	}		
	$persona_cuit = $personas1->persona_cuit->GetValue();
	if($persona_cuit != ""){
		$persona_cuit = "persona_cuit = '$persona_cuit', ";
	}else{
		$persona_cuit = '';
	}
	$persona_denominacion = strtoupper($personas1->persona_denominacion->GetValue());
	if($persona_denominacion != ""){
		$persona_denominacion = "persona_denominacion = '".mysql_real_escape_string($persona_denominacion)."', ";
	}else{
		$persona_denominacion = '';
	}
	$persona_apellido = strtoupper($personas1->persona_apellido->GetValue());
	if($persona_apellido != ""){
		$persona_apellido = "persona_apellido = '".mysql_real_escape_string($persona_apellido)."', ";
	}else{
		$persona_apellido = '';
	}	
	$persona_nombre = strtoupper($personas1->persona_nombre->GetValue());
	if($persona_nombre != ""){
		$persona_nombre = "persona_nombre = '".mysql_real_escape_string($persona_nombre)."', ";
	}else{
		$persona_nombre = '';
	}	
	$persona_conyuge = $personas1->persona_conyuge->GetValue();
	if($persona_conyuge != ""){
		$persona_conyuge = "persona_conyuge = '".mysql_real_escape_string($persona_conyuge)."', ";
	}else{
		$persona_conyuge = '';
	}		
	$persona_fecha_nac = CCFormatDate($personas1->persona_fecha_nac->GetValue(),array("yyyy", "-", "mm", "-", "dd"));
	if($persona_fecha_nac != ""){
		$persona_fecha_nac = "persona_fecha_nac = '$persona_fecha_nac', ";
	}else{
		$persona_fecha_nac = '';
	}	
	$pais_id = $personas1->pais_id->GetValue();
	if($pais_id > 0){
		$pais_id = "pais_id = '$pais_id', ";
	}else{
		$pais_id = '';
	}	
	$persona_tel_movil = $personas1->persona_tel_movil->GetValue();
	if($persona_tel_movil != ""){
		$persona_tel_movil = "persona_tel_movil = '$persona_tel_movil', ";
	}else{
		$persona_tel_movil = '';
	}		
	$persona_email = $personas1->persona_email->GetValue();
	if($persona_email != ""){
		$persona_email = "persona_email = '$persona_email', ";
	}else{
		$persona_email = '';
	}		
    $tipo_perso_jur_id = $personas1->tipo_perso_jur_id->GetValue();
	if($tipo_perso_jur_id > 0){
		$tipo_perso_jur_id = "tipo_perso_jur_id = '$tipo_perso_jur_id', ";
	}else{
		$tipo_perso_jur_id = '';
	}		
    $persona_relacionada_id = $personas1->persona_relacionada_id->GetValue();
	if($persona_relacionada_id > 0){
		$persona_relacionada_id = "persona_relacionada_id = '$persona_relacionada_id', ";
	}else{
		$persona_relacionada_id = '';
	}		
	$audit_string = $personas1->audit_string->GetValue();
	if($audit_string != ""){
		$audit_string = "audit_string = '$audit_string', ";
	}else{
		$audit_string = '';
	}		

	$db = new clsDBtdf_nuevo();

    if($personas1->person_id->GetValue() == ''){
		$SQL = "INSERT INTO personas SET
					$tipo_persona_id
					$tipo_documento_id
					$persona_nro_doc
					$persona_cuit
					$persona_denominacion
					$persona_apellido
					$persona_nombre
					$persona_conyuge
					$persona_fecha_nac
					$pais_id
					$persona_tel_movil
					$persona_email
					$tipo_perso_jur_id
					$persona_relacionada_id
					$audit_string				
					tipo_estado_id = 1,					
					persona_f_proce = NOW(),
					persona_f_alta = NOW()";
		$db->query($SQL);
		$personas1->person_id->SetValue(mysql_insert_id());
	}elseif($personas1->person_id->GetValue() != ''){
		$SQL = "UPDATE personas SET
					$tipo_persona_id
					$persona_cuit
					$persona_conyuge
					$persona_fecha_nac
					$pais_id
					$persona_tel_movil
					$persona_email
					$audit_string
					persona_f_proce = NOW()
				WHERE persona_id = ".$personas1->person_id->GetValue();
		$db->query($SQL);
	}

	$parcela_id = CCGetParam('parcela_id');
	$persona_id = $personas1->person_id->GetValue();
	$fecha_instrumento = $personas1->persona_parcela_f_int->GetValue();
	
	$tipo_instrumento_id = $personas1->tipo_instrumento_id->GetValue();
	if($tipo_instrumento_id > 0){
		$tipo_instrumento_id = "tipo_instrumento_id = '$tipo_instrumento_id', ";
	}else{
		$tipo_instrumento_id = '';
	}		
	$persona_parcela_num_int = $personas1->persona_parcela_num_int->GetValue();
	if($persona_parcela_num_int != ""){
		$persona_parcela_num_int = "persona_parcela_num_int = '$persona_parcela_num_int', ";
	}else{
		$persona_parcela_num_int = '';
	}			
	$persona_parcela_f_int = $fecha_instrumento[1] . "-" . $fecha_instrumento[2] . "-" . $fecha_instrumento[3];
	if($persona_parcela_f_int != "" && $persona_parcela_f_int != "--"){
		$persona_parcela_f_int = "persona_parcela_f_int = '$persona_parcela_f_int', ";
	}else{
		$persona_parcela_f_int = '';
	}		
	$persona_parcela_dominio = $personas1->persona_parcela_dominio->GetValue();
	if($persona_parcela_dominio != ""){
		$persona_parcela_dominio = "persona_parcela_dominio = '$persona_parcela_dominio', ";
	}else{
		$persona_parcela_dominio = '';
	}	
	$tipo_persona_parcela_id = $personas1->tipo_persona_parcela_id->GetValue();
	if($tipo_persona_parcela_id > 0){
		$tipo_persona_parcela_id = "tipo_persona_parcela_id = '$tipo_persona_parcela_id', ";
	}else{
		$tipo_persona_parcela_id = '';
	}		
	$persona_parcela_origen = $personas1->persona_parcela_origen->GetValue();
	if($persona_parcela_origen != ""){
		$persona_parcela_origen = "persona_parcela_origen = '$persona_parcela_origen', ";
	}else{
		$persona_parcela_origen = '';
	}		
	$usuario_id = CCGetUserID();
	if($usuario_id > 0){
		$usuario_id = "usuario_id = '$usuario_id', ";
	}else{
		$usuario_id = '';
	}		
	$tipo_estado_id = $personas1->tipo_estado_id->GetValue();
	if($tipo_estado_id > 0){
		$tipo_estado_id = "tipo_estado_id = '$tipo_estado_id', ";
	}else{
		$tipo_estado_id = '';
	}		
	
	$paso = CCDLookUp("COUNT(*)","personas_parcelas","parcela_id = ".$parcela_id." AND persona_parcela_ppal = 1",$db);
	if($paso == 0){
		$principal = 1;
	}else{
		$principal = 0;
	}
	if($persona_id && $parcela_id){
		$SQL = "INSERT INTO personas_parcelas
				SET persona_id = '$persona_id',
					parcela_id = '$parcela_id',
					$tipo_instrumento_id 
					$persona_parcela_num_int 
					$persona_parcela_f_int 
					$persona_parcela_dominio 
					$tipo_persona_parcela_id 
					$persona_parcela_origen 
					$usuario_id   
					$tipo_estado_id 
					$audit_string 
					persona_parcela_ppal = '$principal', 
					persona_parcela_f_pro = NOW()"; 
		$db->query($SQL);
	}
	$db->close();

	global $Redirect;
	$Redirect = "gridPersonas.php?parcela_id=".CCGetParam('parcela_id');
// -------------------------
//End Custom Code

//Close personas1_Button_Insert_OnClick @438-90F3E848
    return $personas1_Button_Insert_OnClick;
}
//End Close personas1_Button_Insert_OnClick

//personas1_quitar_OnClick @540-3E2D86EB
function personas1_quitar_OnClick(& $sender)
{
    $personas1_quitar_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personas1; //Compatibility
//End personas1_quitar_OnClick

//Custom Code @541-2A29BDB7
// -------------------------
    global $Redirect;
	$Redirect="gridPersonas.php?add=".CCGetParam('add')."&personas=".CCGetParam('personas')."&parcela_id=".CCGetParam('parcela_id');
// -------------------------
//End Custom Code

//Close personas1_quitar_OnClick @540-3E93D64D
    return $personas1_quitar_OnClick;
}
//End Close personas1_quitar_OnClick

//personas1_add_persona_BeforeShow @53-987FC633
function personas1_add_persona_BeforeShow(& $sender)
{
    $personas1_add_persona_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personas1; //Compatibility
//End personas1_add_persona_BeforeShow

//Custom Code @56-2A29BDB7
// -------------------------

  /* Modifica el enlace agregando la URL codificada y la key de regreso */
  global $FileName;
  $returnPage = rawurlencode( $FileName ); // debug( $returnPage );
  $returnParams = rawurlencode( CCGetQueryString('QueryString', array() ) ); // debug( $returnParams );
  $returnKey = 'persona_relacionada_id';
  $Component->SetLink( 'buscaPersonasGral.php?return_page=' . $returnPage . '&return_params=' . $returnParams . '&return_key=' . $returnKey );

// -------------------------
//End Custom Code

//Close personas1_add_persona_BeforeShow @53-7BB12850
    return $personas1_add_persona_BeforeShow;
}
//End Close personas1_add_persona_BeforeShow

//personas1_BeforeShow @437-7396B9AC
function personas1_BeforeShow(& $sender)
{
    $personas1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personas1; //Compatibility
//End personas1_BeforeShow

//Custom Code @470-2A29BDB7
// -------------------------

  $db = new clsDBtdf_nuevo();

  /* Determina qué mostrar en el label de persona seleccionada y los links */

  // Si viene el ID de persona en la URL tiene total prioridad

  $personaId = CCGetParam('persona_relacionada_id' );

  if ( !empty( $personaId ) ) {

    // busca la persona y la muestra en el label y carga el campo oculto con su id
    $SQL = 'SELECT * from personas WHERE persona_id = ' . mysql_real_escape_string( $personaId );
    $responsable = CCQueryToArray( $SQL, $db ); //debug( $responsable );

    if ( !empty( $responsable ) )  {
      // carga los valores
      $Component->persona_relacionada_id->SetValue( $responsable[0]['persona_id'] );
      $Component->persona_relacionada->SetValue( $responsable[0]['persona_denominacion'] . ' (Doc. Nro: ' . $responsable[0]['persona_nro_doc'] . ')' );
      // muestra/oculta los enlaces
      $Component->add_persona->Visible = false;
      $Component->remove_persona->Visible = true;
    } else {
      // carga lo valores
      $Component->persona_relacionada->SetValue( '(no hay resonsables asignados)' );
      $Component->persona_relacionada_id->SetValue( '' );
      // muestra/oculta los enlaces
      $Component->add_persona->Visible = true;
      $Component->remove_persona->Visible = false;
    }

  } else {

      $Component->persona_relacionada->SetValue( '(no hay resonsables asignados)' );
      $Component->persona_relacionada_id->SetValue( '' );
      // muestra/oculta los enlaces
      $Component->add_persona->Visible = true;
      $Component->remove_persona->Visible = false;

  }



  // Si se indica remover la persona (si no viene seleccionada)

  $remover = CCGetParam('remove');

  if ( !empty( $remover ) && empty( $personaId ) ) {

    $Component->persona_relacionada->SetValue( '(Resonsable desvinculado. Actualizar para confirmar.)' );
    $Component->persona_relacionada_id->SetValue( '' );
    // muestra/oculta los enlaces
    $Component->add_persona->Visible = true;
    $Component->remove_persona->Visible = false;

  }

	//llenar fecha modificacion
	if(CCGetParam('person_id')){
		$Component->quitar->Visible=true;
		$Component->Label2->SetValue("<font color='RED'><b><- Si carga una nueva persona, primero quite la que buscó</b></font>");
		$Component->Label1->SetValue("<font color='GREEN'><b>Puede reemplazarlo por otra en la busqueda -></b></font>");
	}else{
		$Component->quitar->Visible=false;
		$Component->Label2->SetValue("<font color='GREEN'><b>, sino cargue un titular nuevo</b></font>");
		$Component->Label1->SetValue("<font color='GREEN'><b>Busque un titular o persona a cargar:</b></font>");
	}
	//fecha proceso
	$Component->persona_f_proce->SetValue(date('Y-m-d H:i:s'));
	//auditoria

	$audit_string = implode('|',array(CCGetUserID(),$_SERVER[REMOTE_ADDR],substr(strrchr ($_SERVER['PHP_SELF'], "/"), 1)));
	$Component->audit_string->SetValue($audit_string);
	
	$Component->Visible = False;
	if(CCGetParam(persona_id) == '' && CCGetParam(personas) && CCGetParam(persona_parcela_id) == ''){
		$Component->Visible = True;
		$SQL = "SELECT tipo_persona_id, tipo_documento_id, persona_nro_doc, persona_cuit, persona_denominacion, persona_apellido, persona_nombre,
						persona_conyuge, persona_fecha_nac, pais_id, persona_tel_movil, persona_email 
						FROM personas
						WHERE persona_id = ".CCGetParam(person_id);
		$db->query($SQL);
		if($db->next_record()){
			$personas1->tipo_persona_id->SetValue($db->f('tipo_persona_id'));
			$personas1->tipo_documento_id->SetValue($db->f('tipo_documento_id'));
			$personas1->persona_nro_doc->SetValue($db->f('persona_nro_doc'));
			$personas1->persona_cuit->SetValue($db->f('persona_cuit'));
			$personas1->persona_denominacion->SetValue($db->f('persona_denominacion'));
			$personas1->persona_apellido->SetValue($db->f('persona_apellido'));
			$personas1->persona_nombre->SetValue($db->f('persona_nombre'));
			$personas1->persona_conyuge->SetValue($db->f('persona_conyuge'));
			$personas1->persona_fecha_nac->SetValue(CCParseDate($db->f('persona_fecha_nac'),array("yyyy", "-", "mm", "-", "dd")));
			$personas1->pais_id->SetValue($db->f('pais_id'));
			$personas1->persona_tel_movil->SetValue($db->f('persona_tel_movil'));
			$personas1->persona_email->SetValue($db->f('persona_email'));
		}
		$db->close();
	}

// -------------------------
//End Custom Code

//Close personas1_BeforeShow @437-377A70DD
    return $personas1_BeforeShow;
}
//End Close personas1_BeforeShow

//personas1_OnValidate @437-30E343CC
function personas1_OnValidate(& $sender)
{
    $personas1_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $personas1; //Compatibility
//End personas1_OnValidate

//Custom Code @482-2A29BDB7
// -------------------------

  $db = new clsDBtdf_nuevo();


  /* Validación selectiva de acuerdo a la figura legal
  ---------------------------------------------------------- */

  if ( $personas1->tipo_persona_id->GetValue() == 2 ) {

    /* Persona jurídica */

    $persRazSoc = $personas1->persona_apellido->GetValue();
    if ( empty( $persRazSoc ) ) {
      $personas1->Errors->addError("Debe completar la Razón Social");
    }
  } else {

    /* Persona física */

    $persNombre = $personas1->persona_nombre->GetValue();
    $persApellido = $personas1->persona_apellido->GetValue();
    if ( empty( $persNombre ) || empty( $persApellido ) ) {
      $personas1->Errors->addError("Debe completar Nombre y Apellido");
    }
  }

	if ( $personas1->persona_cuit->GetValue() == '' && $personas1->persona_nro_doc->GetValue() == '' ) {
		$personas1->persona_nro_doc->SetValue("0");
		$personas1->tipo_documento_id->SetValue(7);
	  //$personas->Errors->addError("Debe cargar un numero de documento o CUIT.");
	}
  /* Si se buscó una persona valida que ya no esté relacionada */

	if( CCGetParam( 'person_id' ) ) {
		$SQL = "SELECT COUNT(*) AS CANT FROM personas_parcelas WHERE persona_id = ". CCGetParam(person_id) ." AND parcela_id = ". CCGetParam(parcela_id);
		$db->query($SQL);
		if($db->next_record()){
			if($db->f('CANT') > 0){
				$personas1->Errors->addError( "Ya existe la asociación de esta persona con la parcela actual." );
			}
		}
	}

	$db->close();
// -------------------------
//End Custom Code

//Close personas1_OnValidate @437-08811454
    return $personas1_OnValidate;
}
//End Close personas1_OnValidate

//Page_AfterInitialize @1-8B0B67B0
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $gridPersonas; //Compatibility
//End Page_AfterInitialize

//Custom Code @607-2A29BDB7
// -------------------------

	if(CCGetParam(add) || CCGetParam(direccion_id)){
		$Component->footerParcela->Visible = false;
	}

// -------------------------
//End Custom Code

//Close Page_AfterInitialize @1-379D319D
    return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize

//Page_BeforeInitialize @1-8A759367
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $gridPersonas; //Compatibility
//End Page_BeforeInitialize

//Custom Code @636-2A29BDB7
// -------------------------
    include_once(RelativePath . "/scripts/permisos1.php");
// -------------------------
//End Custom Code

//PTAutocomplete1 Initialization @600-6EA77788
    global $Charset;
    if ('direccionesnombre_callePTAutocomplete1' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new ListFormatter());
//End PTAutocomplete1 Initialization

//PTAutocomplete1 DataSource @600-E0F59DA4
        $Service->DataSource = new clsDBtdf_nuevo();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM calles {SQL_Where} {SQL_OrderBy}";
        $Service->DataSource->Parameters["postnombre_calle"] = CCGetFromPost("nombre_calle", NULL);
        $Service->DataSource->wp = new clsSQLParameters();
        $Service->DataSource->wp->AddParameter("1", "postnombre_calle", ccsText, "", "", $Service->DataSource->Parameters["postnombre_calle"], -1, false);
        $Service->DataSource->wp->Criterion[1] = $Service->DataSource->wp->Operation(opBeginsWith, "calle_nombre", $Service->DataSource->wp->GetDBValue("1"), $Service->DataSource->ToSQL($Service->DataSource->wp->GetDBValue("1"), ccsText),false);
        $Service->DataSource->Where = 
             $Service->DataSource->wp->Criterion[1];
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End PTAutocomplete1 DataSource

//PTAutocomplete1 Charset @600-4F7C968C
        $Service->AddHttpHeader("Content-type", "text/html; charset=" . $Charset);
//End PTAutocomplete1 Charset

//PTAutocomplete1 DataFields @600-661E4449
        $Service->AddDataSourceField('calle_nombre');
//End PTAutocomplete1 DataFields

//PTAutocomplete1 Execution @600-D749E478
        $Service->DisplayHeaders();
        echo $Service->Execute();
//End PTAutocomplete1 Execution

//PTAutocomplete1 Tail @600-27890EF8
        exit;
    }
//End PTAutocomplete1 Tail

//PTAutocomplete2 Initialization @602-3B8F9B77
    global $Charset;
    if ('direccionesnombre_barrioPTAutocomplete2' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new ListFormatter());
//End PTAutocomplete2 Initialization

//PTAutocomplete2 DataSource @602-8CE61EE5
        $Service->DataSource = new clsDBtdf_nuevo();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM barrios {SQL_Where} {SQL_OrderBy}";
        $Service->DataSource->Parameters["postnombre_barrio"] = CCGetFromPost("nombre_barrio", NULL);
        $Service->DataSource->wp = new clsSQLParameters();
        $Service->DataSource->wp->AddParameter("1", "postnombre_barrio", ccsText, "", "", $Service->DataSource->Parameters["postnombre_barrio"], -1, false);
        $Service->DataSource->wp->Criterion[1] = $Service->DataSource->wp->Operation(opBeginsWith, "barrio_nombre", $Service->DataSource->wp->GetDBValue("1"), $Service->DataSource->ToSQL($Service->DataSource->wp->GetDBValue("1"), ccsText),false);
        $Service->DataSource->Where = 
             $Service->DataSource->wp->Criterion[1];
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End PTAutocomplete2 DataSource

//PTAutocomplete2 Charset @602-4F7C968C
        $Service->AddHttpHeader("Content-type", "text/html; charset=" . $Charset);
//End PTAutocomplete2 Charset

//PTAutocomplete2 DataFields @602-BAE9BBE4
        $Service->AddDataSourceField('barrio_nombre');
//End PTAutocomplete2 DataFields

//PTAutocomplete2 Execution @602-D749E478
        $Service->DisplayHeaders();
        echo $Service->Execute();
//End PTAutocomplete2 Execution

//PTAutocomplete2 Tail @602-27890EF8
        exit;
    }
//End PTAutocomplete2 Tail

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize

?>
