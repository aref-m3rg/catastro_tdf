<?php
//BindEvents Method @1-01ADEC34
function BindEvents()
{
    global $tipos_personas_juridicas1;
    $tipos_personas_juridicas1->CCSEvents["OnValidate"] = "tipos_personas_juridicas1_OnValidate";
}
//End BindEvents Method

//tipos_personas_juridicas1_OnValidate @19-68C32E7C
function tipos_personas_juridicas1_OnValidate(& $sender)
{
    $tipos_personas_juridicas1_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tipos_personas_juridicas1; //Compatibility
//End tipos_personas_juridicas1_OnValidate

//Custom Code @32-2A29BDB7
// -------------------------
    $db = new clsDBtdf_nuevo();
	if(CCGetParam('tipo_perso_jur_id')){
		$tipo_perso_jur_id = " AND tipo_perso_jur_id <> ".CCGetParam('tipo_perso_jur_id');
	}else{
		$tipo_perso_jur_id = "";
	}
	$descrip=CCDLookUp("COUNT(*)","tipos_personas_juridicas","tipo_perso_jur_descrip = '".$tipos_personas_juridicas1->tipo_perso_jur_descrip->GetValue()."' $tipo_perso_jur_id",$db);
	if($descrip > 0){
		$tipos_personas_juridicas1->Errors->addError("Ya existe esta descripcion de sociedad");
	}
	$abrev=CCDLookUp("COUNT(*)","tipos_personas_juridicas","tipo_perso_jur_abrev = '".$tipos_personas_juridicas1->tipo_perso_jur_abrev->GetValue()."' $tipo_perso_jur_id",$db);
	if($abrev > 0){
		$tipos_personas_juridicas1->Errors->addError("Ya existe esta abreviacion de sociedad");
	}
	$db->close();
// -------------------------
//End Custom Code

//Close tipos_personas_juridicas1_OnValidate @19-A2BAB3E4
    return $tipos_personas_juridicas1_OnValidate;
}
//End Close tipos_personas_juridicas1_OnValidate


?>
