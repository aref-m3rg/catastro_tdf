<?php

//BindEvents Method @1-3A7462BF
function BindEvents()
{
    global $tipos_tramites;
    global $tipos_tramites1;
    global $CCSEvents;
    $tipos_tramites->ButtonBuscar->CCSEvents["OnClick"] = "tipos_tramites_ButtonBuscar_OnClick";
    $tipos_tramites->CCSEvents["OnValidate"] = "tipos_tramites_OnValidate";
    $tipos_tramites1->Navigator->CCSEvents["BeforeShow"] = "tipos_tramites1_Navigator_BeforeShow";
}
//End BindEvents Method

//tipos_tramites_ButtonBuscar_OnClick @38-8D6CF4C2
function tipos_tramites_ButtonBuscar_OnClick(& $sender)
{
    $tipos_tramites_ButtonBuscar_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tipos_tramites; //Compatibility
//End tipos_tramites_ButtonBuscar_OnClick

//Custom Code @39-2A29BDB7
// -------------------------
    if($tipos_tramites->tramite_id->GetValue()){
		global $Redirect;
		$Redirect = "recordTipos.php?tramite_id=".$tipos_tramites->tramite_id->GetValue();
	}
// -------------------------
//End Custom Code

//Close tipos_tramites_ButtonBuscar_OnClick @38-34247C3D
    return $tipos_tramites_ButtonBuscar_OnClick;
}
//End Close tipos_tramites_ButtonBuscar_OnClick

//tipos_tramites_OnValidate @6-CB534B2A
function tipos_tramites_OnValidate(& $sender)
{
    $tipos_tramites_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tipos_tramites; //Compatibility
//End tipos_tramites_OnValidate

//Custom Code @40-2A29BDB7
// -------------------------
	$db = new clsDBmesa();
	if(CCDLookUp("tipo_tramites_id","tipos_tramites","tipo_tramites_descript = '".$tipos_tramites->tipo_tramites_descript->GetValue()."'",$db)){
		$tipos_tramites->Errors->addError("Ya existe ese nombre de tipo de tramite");
	}
	$db->close();
// -------------------------
//End Custom Code

//Close tipos_tramites_OnValidate @6-9BB699F3
    return $tipos_tramites_OnValidate;
}
//End Close tipos_tramites_OnValidate

//tipos_tramites1_Navigator_BeforeShow @23-1509C589
function tipos_tramites1_Navigator_BeforeShow(& $sender)
{
    $tipos_tramites1_Navigator_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tipos_tramites1; //Compatibility
//End tipos_tramites1_Navigator_BeforeShow

//Hide-Show Component @24-286333C6
    $Parameter1 = $Container->TotalPages;
    $Parameter2 = 2;
    if (((is_array($Parameter1) || strlen($Parameter1)) && (is_array($Parameter2) || strlen($Parameter2))) && 0 >  CCCompareValues($Parameter1, $Parameter2, ccsInteger))
        $Component->Visible = false;
//End Hide-Show Component

//Close tipos_tramites1_Navigator_BeforeShow @23-BC852E8A
    return $tipos_tramites1_Navigator_BeforeShow;
}
//End Close tipos_tramites1_Navigator_BeforeShow

//Page_BeforeInitialize @1-ECF20019
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $recordTipos; //Compatibility
//End Page_BeforeInitialize

//Custom Code @5-2A29BDB7
// -------------------------
    // Write your own code here.
	//include_once(RelativePath . "/scripts/permisos1.php");
// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize
?>
