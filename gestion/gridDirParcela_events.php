<?php
//BindEvents Method @1-02F84082
function BindEvents()
{
    global $d_real;
    global $d_postal;
    global $direcciones;
    global $CCSEvents;
    $d_real->CCSEvents["BeforeShow"] = "d_real_BeforeShow";
    $d_postal->CCSEvents["BeforeShow"] = "d_postal_BeforeShow";
    $d_postal->CCSEvents["BeforeShowRow"] = "d_postal_BeforeShowRow";
    $direcciones->nombre_calle->CCSEvents["BeforeShow"] = "direcciones_nombre_calle_BeforeShow";
    $direcciones->nombre_barrio->CCSEvents["BeforeShow"] = "direcciones_nombre_barrio_BeforeShow";
    $direcciones->CCSEvents["BeforeShow"] = "direcciones_BeforeShow";
    $direcciones->CCSEvents["AfterInsert"] = "direcciones_AfterInsert";
    $direcciones->CCSEvents["BeforeUpdate"] = "direcciones_BeforeUpdate";
    $direcciones->CCSEvents["BeforeInsert"] = "direcciones_BeforeInsert";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
}
//End BindEvents Method

//d_real_BeforeShow @6-758B9286
function d_real_BeforeShow(& $sender)
{
    $d_real_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $d_real; //Compatibility
//End d_real_BeforeShow

//Custom Code @116-2A29BDB7
// -------------------------
    // Write your own code here.
	if($Component->ds->RecordsCount > 0){
		$Component->panel->Visible = false;
	}
// -------------------------
//End Custom Code

//Close d_real_BeforeShow @6-8ACE34D3
    return $d_real_BeforeShow;
}
//End Close d_real_BeforeShow

//d_postal_BeforeShow @117-448CB40A
function d_postal_BeforeShow(& $sender)
{
    $d_postal_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $d_postal; //Compatibility
//End d_postal_BeforeShow

//Custom Code @127-2A29BDB7
// -------------------------
    // Write your own code here.
	//manejar visibilidad del icono para agregar direccion postal
	//Si tiene direccion postal, no mostrar
	if($Component->ds->RecordsCount > 0 && $Component->panel->Visible){
		$Component->panel->Visible = false;
	
		//pero si la real es igual a la postal mostrar, para darle la opcion a cambiar
		$db = new clsDBtdf_nuevo();
		$iguales = CCDLookUp("IF(direccion_id_real = direccion_id_postal,1,0)",'parcelas','parcela_id = ' . CCGetParam(parcela_id),$db);
		if($iguales){
			$Component->panel->Visible = true;
		}
		$db->close();

	}
	

// -------------------------
//End Custom Code

//Close d_postal_BeforeShow @117-3C13A6A0
    return $d_postal_BeforeShow;
}
//End Close d_postal_BeforeShow

//d_postal_BeforeShowRow @117-3879BA8C
function d_postal_BeforeShowRow(& $sender)
{
    $d_postal_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $d_postal; //Compatibility
//End d_postal_BeforeShowRow

//Custom Code @259-2A29BDB7
// -------------------------
    // Write your own code here.
	//si las direcciones reales y postales son iguales, no dejar editar la postal
	$Component->editP->Visible = True;
	if($Component->ds->f(direccion_id_real) == $Component->ds->f(direccion_id_postal)){
		$Component->editP->Visible = False;
	}
// -------------------------
//End Custom Code

//Close d_postal_BeforeShowRow @117-7750C8BB
    return $d_postal_BeforeShowRow;
}
//End Close d_postal_BeforeShowRow

//direcciones_nombre_calle_BeforeShow @313-7F643158
function direcciones_nombre_calle_BeforeShow(& $sender)
{
    $direcciones_nombre_calle_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $direcciones; //Compatibility
//End direcciones_nombre_calle_BeforeShow

//PTAutocomplete1 BeforeShow @315-19CDFADA
    $Component->Attributes->SetValue('id', 'direccionesnombre_calle');
//End PTAutocomplete1 BeforeShow

//Close direcciones_nombre_calle_BeforeShow @313-307E6E17
    return $direcciones_nombre_calle_BeforeShow;
}
//End Close direcciones_nombre_calle_BeforeShow

//direcciones_nombre_barrio_BeforeShow @314-5FA87EE9
function direcciones_nombre_barrio_BeforeShow(& $sender)
{
    $direcciones_nombre_barrio_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $direcciones; //Compatibility
//End direcciones_nombre_barrio_BeforeShow

//PTAutocomplete2 BeforeShow @316-F56AA0A8
    $Component->Attributes->SetValue('id', 'direccionesnombre_barrio');
//End PTAutocomplete2 BeforeShow

//Close direcciones_nombre_barrio_BeforeShow @314-5AE0A13E
    return $direcciones_nombre_barrio_BeforeShow;
}
//End Close direcciones_nombre_barrio_BeforeShow

//direcciones_BeforeShow @183-314EEF63
function direcciones_BeforeShow(& $sender)
{
    $direcciones_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $direcciones; //Compatibility
//End direcciones_BeforeShow

//Custom Code @223-2A29BDB7
// -------------------------
    // Write your own code here.
	if(CCGetParam(tipo) == 'R' || CCGetParam(tipo) == 'P'){
		$Component->Visible = true;
 	}else{
		$Component->Visible = false;
	}

	$audit_string = implode('|',array(CCGetUserID(),$_SERVER[REMOTE_ADDR],substr(strrchr ($_SERVER['PHP_SELF'], "/"), 1)));
	$Component->audit_string->SetValue($audit_string);

	switch(CCGetParam(tipo)){
		case 'R':
			$Component->tipo->SetValue('Real');
			$Component->extras->Visible = False;
			break;
		case 'P':
			$Component->tipo->SetValue('Postal');
			$Component->extras->Visible = True;
			break;
		default:
			$Component->tipo->SetValue('');
			break;
	}
	
	if(CCGetParam(direccion_id) && CCGetParam(parcela_id)){//esta editando
		$Component->Visible = True;
		$Component->accion->SetValue('Editar');
	}

	if(CCGetParam(parcela_id) && CCGetParam(add)){//esta agregando una direccion
		$Component->Visible = True;
		$Component->accion->SetValue('Agregar');
	}
    $db = new clsDBtdf_nuevo();
	$Component->nombre_calle->SetValue(CCDLookUp("calle_nombre","calles","calle_id = ".$Component->calle_id->GetValue()." AND tipo_estado_id = 1",$db));
	$Component->nombre_barrio->SetValue(CCDLookUp("barrio_nombre","barrios","barrio_id = ".$Component->barrio_id->GetValue()." AND tipo_estado_id = 1",$db));
	if(CCGetParam(direccion_id) == '' && CCGetParam(tipo) == 'R'){
		$calle=CCDLookUp("CONCAT(parcela_calle,' ',parcela_nro,' ',parcela_localidad) AS calle","parcelas","parcela_id = ".CCGetParam(parcela_id),$db);
		$Component->error_fatal->SetValue("<font color='RED' size='2'><b>DEBE COMPLETAR CORRECTAMENTE LA DIRECCION DE ESTA PARCELA EN SUS CORRESPONDIENTES CAMPOS!</b></font><br><font color='BLACK' size='2'><b>$calle</b></font>");
	}
	$db->close();
// -------------------------
//End Custom Code

//Close direcciones_BeforeShow @183-C5F47CA8
    return $direcciones_BeforeShow;
}
//End Close direcciones_BeforeShow

//direcciones_AfterInsert @183-F5AC6163
function direcciones_AfterInsert(& $sender)
{
    $direcciones_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $direcciones; //Compatibility
//End direcciones_AfterInsert

//Custom Code @249-2A29BDB7
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

//Close direcciones_AfterInsert @183-A165E569
    return $direcciones_AfterInsert;
}
//End Close direcciones_AfterInsert

//direcciones_BeforeUpdate @183-81FCA183
function direcciones_BeforeUpdate(& $sender)
{
    $direcciones_BeforeUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $direcciones; //Compatibility
//End direcciones_BeforeUpdate

//Custom Code @281-2A29BDB7
// -------------------------
    // Write your own code here.
	$Component->direccion_f_proce->SetValue(date('Y-m-d H:i:s'));
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

//Close direcciones_BeforeUpdate @183-AAC9CD28
    return $direcciones_BeforeUpdate;
}
//End Close direcciones_BeforeUpdate

//direcciones_BeforeInsert @183-A069CEC7
function direcciones_BeforeInsert(& $sender)
{
    $direcciones_BeforeInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $direcciones; //Compatibility
//End direcciones_BeforeInsert

//Custom Code @317-2A29BDB7
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

//Close direcciones_BeforeInsert @183-65E00CA7
    return $direcciones_BeforeInsert;
}
//End Close direcciones_BeforeInsert

//Page_AfterInitialize @1-5F534086
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $gridDirParcela; //Compatibility
//End Page_AfterInitialize

//Custom Code @270-2A29BDB7
// -------------------------

  // Write your own code here.
	if(CCGetParam(add) || CCGetParam(direccion_id)){
		$Component->footerParcela->Visible = false;
	}

// -------------------------
//End Custom Code

//Close Page_AfterInitialize @1-379D319D
    return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize

//Page_BeforeInitialize @1-2BFA2425
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $gridDirParcela; //Compatibility
//End Page_BeforeInitialize

//Custom Code @326-2A29BDB7
// -------------------------
 //   include_once(RelativePath . "/scripts/permisos1.php");
// -------------------------
//End Custom Code

//PTAutocomplete1 Initialization @315-6EA77788
    global $Charset;
    if ('direccionesnombre_callePTAutocomplete1' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new ListFormatter());
//End PTAutocomplete1 Initialization

//PTAutocomplete1 DataSource @315-B4A3971F
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End PTAutocomplete1 DataSource

//PTAutocomplete1 Charset @315-4F7C968C
        $Service->AddHttpHeader("Content-type", "text/html; charset=" . $Charset);
//End PTAutocomplete1 Charset

//PTAutocomplete1 DataFields @315-53A4E65F
        $Service->AddDataSourceField('');
//End PTAutocomplete1 DataFields

//PTAutocomplete1 Execution @315-D749E478
        $Service->DisplayHeaders();
        echo $Service->Execute();
//End PTAutocomplete1 Execution

//PTAutocomplete1 Tail @315-27890EF8
        exit;
    }
//End PTAutocomplete1 Tail

//PTAutocomplete2 Initialization @316-3B8F9B77
    global $Charset;
    if ('direccionesnombre_barrioPTAutocomplete2' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new ListFormatter());
//End PTAutocomplete2 Initialization

//PTAutocomplete2 DataSource @316-B4A3971F
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End PTAutocomplete2 DataSource

//PTAutocomplete2 Charset @316-4F7C968C
        $Service->AddHttpHeader("Content-type", "text/html; charset=" . $Charset);
//End PTAutocomplete2 Charset

//PTAutocomplete2 DataFields @316-53A4E65F
        $Service->AddDataSourceField('');
//End PTAutocomplete2 DataFields

//PTAutocomplete2 Execution @316-D749E478
        $Service->DisplayHeaders();
        echo $Service->Execute();
//End PTAutocomplete2 Execution

//PTAutocomplete2 Tail @316-27890EF8
        exit;
    }
//End PTAutocomplete2 Tail

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize
?>
