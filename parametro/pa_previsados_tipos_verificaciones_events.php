<?php
//BindEvents Method @1-119BA56C
function BindEvents()
{
    global $previsados_tipos_verifica1;
    $previsados_tipos_verifica1->CCSEvents["OnValidate"] = "previsados_tipos_verifica1_OnValidate";
}
//End BindEvents Method

//previsados_tipos_verifica1_OnValidate @16-2C1F2BE0
function previsados_tipos_verifica1_OnValidate(& $sender)
{
    $previsados_tipos_verifica1_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_tipos_verifica1; //Compatibility
//End previsados_tipos_verifica1_OnValidate

//Custom Code @29-2A29BDB7
// -------------------------
	$db = new clsDBtdf_nuevo();
    if(CCGetParam('previsado_tipo_verif_id')){//actualiza
		$where = "AND previsado_tipo_verif_id <> ".CCGetParam('previsado_tipo_verif_id');
	}else{//agrega
		$where = "";
	}
	$previsado_tipo_verif_descrip = trim($previsados_tipos_verifica1->previsado_tipo_verif_descrip->GetValue());
	if($previsado_tipo_verif_descrip){
		$previsado_tipo_verif_id = CCDLookUp("previsado_tipo_verif_id","previsados_tipos_verificaciones","previsado_tipo_verif_descrip = '$previsado_tipo_verif_descrip' $where",$db);
		if($previsado_tipo_verif_id){
			$previsados_tipos_verifica1->Errors->addError("El nombre que desea ingresar ya existe");
		}
	}else{
		$previsados_tipos_verifica1->Errors->addError("No se permiten descripciones vacios");
	}
	$db->close();
// -------------------------
//End Custom Code

//Close previsados_tipos_verifica1_OnValidate @16-73B28351
    return $previsados_tipos_verifica1_OnValidate;
}
//End Close previsados_tipos_verifica1_OnValidate


?>
