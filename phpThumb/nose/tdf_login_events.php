<?php
//BindEvents Method @1-17538124
function BindEvents()
{
    global $Login;
    global $CCSEvents;
    $Login->Button_DoLogin->CCSEvents["OnClick"] = "Login_Button_DoLogin_OnClick";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
}
//End BindEvents Method

//Login_Button_DoLogin_OnClick @3-1454CF55
function Login_Button_DoLogin_OnClick(& $sender)
{
    $Login_Button_DoLogin_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Login; //Compatibility
//End Login_Button_DoLogin_OnClick

//Login @4-DE10C29C
    global $CCSLocales;
    global $Redirect;
    if ( !CCLoginUser( $Container->login->Value, $Container->password->Value)) {
        $Container->Errors->addError($CCSLocales->GetText("CCS_LoginError"));
        $Container->password->SetValue("");
        $Login_Button_DoLogin_OnClick = 0;
    } else {
        global $Redirect;
		$db = new clsDBmesa();
		$db_2 = new clsDBcatastro();
		//en que estado esta este usuario
		$usr_estado_id = CCDLookUp('usr_estado_id','usuarios','usuarios_id = ' . CCGetUserID(),$db_2);
				
		if($usr_estado_id == 1){
			
			$SQL = "SELECT unidades.unidad_id,unidad_p_nombre,unidad_nombre
					FROM unidades 
					INNER JOIN unidades_param USING(unidad_id)
					INNER JOIN usuarios_unidades ON unidades.unidad_id = usuarios_unidades.unidad_id
					WHERE unidad_p_f_vig <= NOW() 
					AND usuarios_unidades.estado_id = 1 
					AND usuarios_unidades.usuario_id = " . CCGetUserID() . "
					AND unidad_p_activo = 1
					ORDER BY usr_uni_id ASC
					LIMIT 1";
			
			$db->query($SQL);
			if($db->next_record()){
				CCSetSession("unidad_id",$db->f(unidad_id));
				CCSetSession("unidad_nombre",$db->f(unidad_nombre));
				$Redirect = CCGetParam("ret_link", $Redirect);

				//auditar este evento
				include_once(RelativePath . "/myFunctions.php");
				auditar("usuarios",CCGetUserID(),1);

				$Login_Button_DoLogin_OnClick = 1;
				
			} else {
				//$Container->Errors->addError("Parece que hay problemas con esta autenticacion.");
				//$Container->password->SetValue("");
    			//$Login_Button_DoLogin_OnClick = 0;
				
			}

		} else {
			$Container->Errors->addError("El usuario se encuentra deshabilitado");
			$Container->password->SetValue("");
        	$Login_Button_DoLogin_OnClick = 0;
		}
		
	
		
        
        
    }
//End Login

//Close Login_Button_DoLogin_OnClick @3-0EB5DCFE
    return $Login_Button_DoLogin_OnClick;
}
//End Close Login_Button_DoLogin_OnClick

//Page_AfterInitialize @1-3D135D17
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tdf_login; //Compatibility
//End Page_AfterInitialize

//Custom Code @10-2A29BDB7
// -------------------------
    // Write your own code here.
	if(CCGetParam(Logout)){
		//auditar este evento
		include_once(RelativePath . "/myFunctions.php");
		auditar("usuarios",CCGetUserID(),2);
		CCLogoutUser();
		CCSetSession("unidad_id", "");
		CCSetSession("unidad_nombre", "");
	}
// -------------------------
//End Custom Code

//Close Page_AfterInitialize @1-379D319D
    return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize


?>
