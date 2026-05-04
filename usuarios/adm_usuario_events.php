<?php
//BindEvents Method @1-E9E1EFE6
function BindEvents()
{
    global $usuarios1;
    global $usuarios_unidades;
    global $CCSEvents;
    $usuarios1->Button_retorno->CCSEvents["OnClick"] = "usuarios1_Button_retorno_OnClick";
    $usuarios1->CCSEvents["BeforeShow"] = "usuarios1_BeforeShow";
    $usuarios1->ds->CCSEvents["BeforeExecuteDelete"] = "usuarios1_ds_BeforeExecuteDelete";
    $usuarios_unidades->CCSEvents["BeforeShow"] = "usuarios_unidades_BeforeShow";
}
//End BindEvents Method

//usuarios1_Button_retorno_OnClick @97-259044D9
function usuarios1_Button_retorno_OnClick(& $sender)
{
    $usuarios1_Button_retorno_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $usuarios1; //Compatibility
//End usuarios1_Button_retorno_OnClick

//Custom Code @98-2A29BDB7
// -------------------------
	if(CCGetParam('usuario_id')){
		$db = new clsDBtdf_nuevo();
		$SQL="UPDATE _usuarios SET tipo_estado_id=1 WHERE usuario_id=".CCGetParam('usuario_id');
		$db->query($SQL);
		$db->close();
		global $Redirect;
		$Redirect = "adm_usuario.php?usuario_id=".CCGetParam('usuario_id');
	}
// -------------------------
//End Custom Code

//Close usuarios1_Button_retorno_OnClick @97-C4420133
    return $usuarios1_Button_retorno_OnClick;
}
//End Close usuarios1_Button_retorno_OnClick

//usuarios1_BeforeShow @51-3C164E4C
function usuarios1_BeforeShow(& $sender)
{
    $usuarios1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $usuarios1; //Compatibility
//End usuarios1_BeforeShow

//Custom Code @63-2A29BDB7
// -------------------------
	$usuarios1->Button_retorno->Visible = FALSE;
	if(CCGetParam('usuario_id')){
		$db = new clsDBtdf_nuevo();
		$estado = CCDLookUp("tipo_estado_id","_usuarios","usuario_id=".CCGetParam('usuario_id'),$db);
		if($estado == 2){
			$usuarios1->Button_retorno->Visible = TRUE;
		}
		$db->close();
	}
// -------------------------
//End Custom Code

//Close usuarios1_BeforeShow @51-9A80124C
    return $usuarios1_BeforeShow;
}
//End Close usuarios1_BeforeShow

//usuarios1_ds_BeforeExecuteDelete @51-91AEAF8D
function usuarios1_ds_BeforeExecuteDelete(& $sender)
{
    $usuarios1_ds_BeforeExecuteDelete = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $usuarios1; //Compatibility
//End usuarios1_ds_BeforeExecuteDelete

//Custom Code @64-2A29BDB7
// -------------------------
    // Write your own code here.
// -------------------------
$Component->ds->SQL = "UPDATE _usuarios SET _usuarios.tipo_estado_id = 2 WHERE _usuarios.usuario_id = " . CCGetParam(usuario_id);
//End Custom Code

//Close usuarios1_ds_BeforeExecuteDelete @51-633F5138
    return $usuarios1_ds_BeforeExecuteDelete;
}
//End Close usuarios1_ds_BeforeExecuteDelete

//usuarios_unidades_BeforeShow @82-68CCA3C7
function usuarios_unidades_BeforeShow(& $sender)
{
    $usuarios_unidades_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $usuarios_unidades; //Compatibility
//End usuarios_unidades_BeforeShow

//Custom Code @93-2A29BDB7
// -------------------------
    // Write your own code here.


$Component->Visible=FALSE;

if(CCGetParam(usuario_id)) $Component->Visible=TRUE;


// -------------------------
//End Custom Code

//Close usuarios_unidades_BeforeShow @82-54676C05
    return $usuarios_unidades_BeforeShow;
}
//End Close usuarios_unidades_BeforeShow

//Page_BeforeInitialize @1-F7BD894D
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $adm_usuario; //Compatibility
//End Page_BeforeInitialize

//Custom Code @71-2A29BDB7
// -------------------------
    // Write your own code here.
/*
	$db_2 = new clsDBcatastro();
	$pagina = substr(strrchr($_SERVER['SCRIPT_FILENAME'], "/"), 1) ;
	$pagina = trim($pagina);
	$menu_id = CCDLookUp("menu_id","menu","menu_link LIKE  '%" . $pagina . "%'",$db_2);
	CCSetSession("menu_id",$menu_id);
	//$perfil_id = CCGetSession("perfil_id");
	$perfil_id = CCDLookUp('perfil_id','_usuarios','usuario_id = ' . CCGetUserID(),$db_2);
	$nivel_id =     CCDLookUp("_perfiles_items.nivel_id"    ,"_perfiles_items LEFT JOIN _nivel ON _nivel.nivel_id =  _perfiles_items.nivel_id"," perfil_id = ". $perfil_id . " AND menu_id =  " . $menu_id ,$db_2);
	$nivel_nombre = CCDLookUp("nivel_nombre","_perfiles_items LEFT JOIN _nivel ON _nivel.nivel_id =  _perfiles_items.nivel_id"," perfil_id = ". $perfil_id . " AND menu_id =  " . $menu_id ,$db_2);
	
	echo "<BR> Pagina: " . $pagina;
	echo " <BR> perfil_id = ". $perfil_id . " AND menu_id =  " . $menu_id;
	echo "<BR> a: " .   CCGetSession("GID") . " - " . $nivel_id ;
	
	CCSetSession("GID",$nivel_id);
	CCSetSession("perfil_id",$perfil_id);
*/

include_once(RelativePath . "/scripts/permisos1.php");	

//	echo "<BR> b: " .   CCGetSession("GID") ;
//	exit;

// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize
?>
