<?php
//BindEvents Method @1-A60F0C88
function BindEvents()
{
    global $pre;
    $pre->Button_DoSearch->CCSEvents["OnClick"] = "pre_Button_DoSearch_OnClick";
}
//End BindEvents Method

//pre_Button_DoSearch_OnClick @5-99FB1ED6
function pre_Button_DoSearch_OnClick(& $sender)
{
    $pre_Button_DoSearch_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $pre; //Compatibility
	global $Redirect;
//Setear las variables basicas
//End pre_Button_DoSearch_OnClick

//Custom Code @15-2A29BDB7
// -------------------------
	$db = new clsDBmesa();
	CCSetSession('unidad_id',$Container->unidad_id->GetValue());
	$unidad_nombre = CCDLookUp('unidad_p_nombre','unidades_param','unidad_p_activo = 1 AND unidad_id = ' . $Container->unidad_id->GetValue(),$db);
	CCSetSession("unidad_nombre",$unidad_nombre);

	//buscar el privilegio en el grupo

	$grupo_id = CCDLookUp('grupo_id','usuarios_unidades','usuario_id = ' . CCGetUserID() . ' AND unidad_id = ' . $Container->unidad_id->GetValue(),$db);
	if($grupo_id){
		CCSetSession('GID',$grupo_id);
	}

	$Redirect = CCGetParam("ret_link", $Redirect);
// -------------------------
//End Custom Code

//Close pre_Button_DoSearch_OnClick @5-694D868C
    return $pre_Button_DoSearch_OnClick;
}
//End Close pre_Button_DoSearch_OnClick


?>
