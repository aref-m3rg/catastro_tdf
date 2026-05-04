<?php

//DEL  // -------------------------
//DEL      // Write your own code here.
//DEL  
//DEL  	$Component->Visible = false;
//DEL  	if (CCGetParam(perfil_id_e)) {
//DEL  		$Component->Visible = true;
//DEL  	}
//DEL  /*
//DEL  	$ph = CCGetParam(ph);
//DEL  if (($ph == "") OR (CCGetParam(nomenclatura1))) {
//DEL  	$parcelas3->Visible  = true;
//DEL  	}ELSE {
//DEL  	$parcelas3->Visible  = false;
//DEL  }
//DEL  */
//DEL  // -------------------------

//DEL  // -------------------------
//DEL  
//DEL  	//echo "<BR> z: " .   CCGetSession("GID") ;
//DEL  	//exit;
//DEL  
//DEL      // Write your own code here.
//DEL  // -------------------------

//Page_BeforeInitialize @1-5F4A2150
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $adm_perfil; //Compatibility
//End Page_BeforeInitialize

//Custom Code @68-2A29BDB7
// -------------------------
    // Write your own code here.
	/*
	global $Redirect;
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
	if ($nivel == '') $Redirect = "../tdf_restricted.php";
	*/

	include_once(RelativePath . "/scripts/permisos1.php");
	//echo "red:" . $Redirect;
// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize
?>
