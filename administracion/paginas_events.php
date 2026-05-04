<?php
//BindEvents Method @1-22B99BE8
function BindEvents()
{
    global $menu1;
    global $menu2;
    global $CCSEvents;
    $menu1->Link1->CCSEvents["BeforeShow"] = "menu1_Link1_BeforeShow";
    $menu2->menu_parent_id->CCSEvents["BeforeShow"] = "menu2_menu_parent_id_BeforeShow";
    $menu2->ds->CCSEvents["AfterExecuteInsert"] = "menu2_ds_AfterExecuteInsert";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
}
//End BindEvents Method

//menu1_Link1_BeforeShow @81-6AA4CFA3
function menu1_Link1_BeforeShow(& $sender)
{
    $menu1_Link1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $menu1; //Compatibility
//End menu1_Link1_BeforeShow

//Close menu1_Link1_BeforeShow @81-081B4F19
    return $menu1_Link1_BeforeShow;
}
//End Close menu1_Link1_BeforeShow

//menu2_menu_parent_id_BeforeShow @44-2C31FDBD
function menu2_menu_parent_id_BeforeShow(& $sender)
{
    $menu2_menu_parent_id_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $menu2; //Compatibility
//End menu2_menu_parent_id_BeforeShow

//Custom Code @66-2A29BDB7
// -------------------------
    // Write your own code here.
	//$menu_parent_id->SetValue(CCGetParam(menu_idp));
	$menu2->menu_parent_id->SetValue(CCGetParam(menu_idp));
// -------------------------
//End Custom Code

//Close menu2_menu_parent_id_BeforeShow @44-7FEC6105
    return $menu2_menu_parent_id_BeforeShow;
}
//End Close menu2_menu_parent_id_BeforeShow

//menu2_ds_AfterExecuteInsert @35-52037CF2
function menu2_ds_AfterExecuteInsert(& $sender)
{
    $menu2_ds_AfterExecuteInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $menu2; //Compatibility
//End menu2_ds_AfterExecuteInsert

//Custom Code @92-2A29BDB7
// -------------------------
    // Write your own code here.

// dar de alta periso al adminisrador
$ultima_pagina = mysql_insert_id();

$db = new clsDBtdf_nuevo();
$insert = "INSERT INTO _perfiles_items (perfil_id, menu_id, nivel_id) VALUES (1,".$ultima_pagina .",2);";
$db->Query($insert);


// -------------------------
//End Custom Code

//Close menu2_ds_AfterExecuteInsert @35-66EEB6B7
    return $menu2_ds_AfterExecuteInsert;
}
//End Close menu2_ds_AfterExecuteInsert

//Page_AfterInitialize @1-71A91252
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $paginas; //Compatibility
//End Page_AfterInitialize

//Custom Code @65-2A29BDB7
// -------------------------
    // Write your own code here.
	//include_once(RelativePath . "/scripts/permisos1.php");	
// -------------------------
//End Custom Code

//Close Page_AfterInitialize @1-379D319D
    return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize

//Page_BeforeInitialize @1-6804B284
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $paginas; //Compatibility
//End Page_BeforeInitialize

//Custom Code @80-2A29BDB7
// -------------------------

    // Incluye la gestión de permisos
	include_once(RelativePath . "/scripts/permisos1.php");

// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
